<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\DetalleDocumento;
use App\Models\Documento;
use App\Models\Interes;
use App\Models\SolicitudPrestamo;
use App\Models\TipoPlazo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SolicitudPrestamoController extends Controller
{
    public function create()
    {
        $cliente = Cliente::where('user_id', auth()->id())->firstOrFail();
        $documentos = Documento::all()->keyBy('id');
        $interes = Interes::where('estado', 'activo')->first();

        // Obtener todos los tipos de plazo con su interés relacionado
        $tiposPlazo = TipoPlazo::with('interesActivo')->get();

        return view('solicitudes.solicitudPrestamo', compact('cliente', 'documentos', 'interes', 'tiposPlazo'));
    }
    // Registrar solicitud de préstamo
    public function store(Request $request)
    {
        //dd($request->all());
        // Validación de los datos
        $request->validate([
            'monto_solicitado' => 'required|numeric|min:0.01',
            'comentario' => 'nullable|string|max:255',
            'documento_identidad' => 'required|file|mimes:pdf,jpg,jpeg,png',
            'comprobante_ingresos' => 'required|file|mimes:pdf,jpg,jpeg,png',
            'comprobante_domicilio' => 'required|file|mimes:pdf,jpg,jpeg,png',
            'otros_documentos.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);

        $user = Auth::user();

        // Buscar el cliente que corresponde a este usuario
        $cliente = Cliente::where('user_id', $user->id)->first();

        if (!$cliente || !$cliente->id_user_prestamista) {
            return back()->with('error', 'No tienes un prestamista asignado.');
        }

        // Procesar firma digital (si viene en base64 desde un canvas)
        $firmaPath = null;
        if ($request->firma_electronica) {
            if (preg_match('/^data:image\/(\w+);base64,/', $request->firma_electronica, $type)) {
                $image = substr($request->firma_electronica, strpos($request->firma_electronica, ',') + 1);
                $type = strtolower($type[1]); // jpg, png, etc.

                $image = str_replace(' ', '+', $image);
                $image = base64_decode($image);

                $firmaPath = 'firmas/' . uniqid() . '.' . $type;
                Storage::disk('public')->put($firmaPath, $image);
            }
        }

        // Crear la solicitud de préstamo
        $solicitud = SolicitudPrestamo::create([
            'id_cliente' => $cliente->id,
            'id_prestamista' => $cliente->id_user_prestamista,
            'monto_solicitado' => $request->monto_solicitado,
            'destino_prestamo' => $request->destino_prestamo,
            'tipo_prestamo' => $request->tipo_prestamo,
            'id_tipo_plazo' => $request->id_tipo_plazo,
            'cantidad_plazo' => $request->plazo,
            'firma_digital' => $firmaPath, // guardamos la ruta de la firma
            'estado' => 'pendiente',
        ]);

        // Asociar documentos obligatorios excepto 'otros_documentos'
        $documentos = [
            1 => 'documento_identidad',     // Documento de identidad
            2 => 'comprobante_ingresos',    // Comprobante de ingresos
            3 => 'comprobante_domicilio',   // Comprobante de domicilio
        ];

        foreach ($documentos as $idDocumento => $inputName) {
            if ($request->hasFile($inputName)) {
                $file = $request->file($inputName);
                $path = $file->store('documentos', 'public');

                DetalleDocumento::create([
                    'id_documento' => $idDocumento,
                    'id_solicitud_prestamo' => $solicitud->id,
                    'ruta' => $path,
                ]);
            }
        }

        // Asociar otros documentos (opcionales)
        $otrosDocumentos = $request->file('otros_documentos');
        if ($otrosDocumentos) {
            if (is_array($otrosDocumentos)) {
                foreach ($otrosDocumentos as $file) {
                    $path = $file->store('documentos', 'public');

                    DetalleDocumento::create([
                        'id_documento' => 4,
                        'id_solicitud_prestamo' => $solicitud->id,
                        'ruta' => $path,
                    ]);
                }
            } else {
                $path = $otrosDocumentos->store('documentos', 'public');

                DetalleDocumento::create([
                    'id_documento' => 4,
                    'id_solicitud_prestamo' => $solicitud->id,
                    'ruta' => $path,
                ]);
            }
        }

        return redirect()->route('solicitudes.create')->with('success', 'Solicitud enviada correctamente.');
    }


    public function aprobar($id)
    {
        $solicitud = SolicitudPrestamo::findOrFail($id);

        if ($solicitud->estado !== 'pendiente') {
            return back()->with('error', 'La solicitud ya fue procesada.');
        }


        // Redirigir a la vista de crear préstamo, pasando el cliente como parámetro
        return redirect()->route('prestamos.create', ['cliente_id' => $solicitud->id_cliente, 'solicitud_id' => $solicitud->id]);
    }


    public function show($id)
    {
        $solicitud = SolicitudPrestamo::with('cliente.user', 'prestamista')->findOrFail($id);
        return view('prestamos.detalleSolicitud', compact('solicitud'));
    }


    public function index(Request $request)
    {
        $query = SolicitudPrestamo::with(['cliente', 'prestamista'])
            ->where('id_prestamista', auth()->id())
            ->latest();

        // Aplicar filtros
        if ($request->estado) {
            $query->where('estado', $request->estado);
        }

        if ($request->fecha_desde) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        if ($request->fecha_hasta) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        // Obtener los resultados paginados
        $solicitudes = $query->paginate(10);

        // Calcular estadísticas sobre el conjunto completo (sin paginación)
        $statsQuery = clone $query;
        $totalSolicitudes = $statsQuery->count();
        $solicitudesPendientes = $statsQuery->where('estado', 'pendiente')->count();
        $montoTotalSolicitado = $statsQuery->sum('monto_solicitado');

        return view('prestamos.solicitudPendiente', compact(
            'solicitudes',
            'totalSolicitudes',
            'solicitudesPendientes',
            'montoTotalSolicitado'
        ));
    }
    public function pendientes()
    {
        $prestamista = Auth::user();

        $solicitudes = SolicitudPrestamo::with('cliente.user')
            ->where('id_prestamista', $prestamista->id)
            ->where('estado', 'pendiente')
            ->latest()
            ->paginate(10); // usa paginación para compatibilidad con la vista

        // variables faltantes
        $totalSolicitudes = $solicitudes->total();
        $solicitudesPendientes = $solicitudes->total(); // ya son todas pendientes
        $montoTotalSolicitado = $solicitudes->sum('monto_solicitado');

        return view('prestamos.solicitudPendiente', compact(
            'solicitudes',
            'totalSolicitudes',
            'solicitudesPendientes',
            'montoTotalSolicitado'
        ));
    }
}
