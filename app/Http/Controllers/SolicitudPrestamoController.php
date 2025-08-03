<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\SolicitudPrestamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitudPrestamoController extends Controller
{
    public function create()
    {
        $cliente = Cliente::where('user_id', auth()->id())->firstOrFail();
        return view('solicitudes.solicitudPrestamo', compact('cliente'));
    }

    // Registrar solicitud de préstamo
    public function store(Request $request)
    {
        $request->validate([
            'monto_solicitado' => 'required|numeric|min:0.01',
            'comentario' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        // Buscar el cliente que corresponde a este usuario
        $cliente = Cliente::where('user_id', $user->id)->first();

        if (!$cliente || !$cliente->id_user_prestamista) {
            return back()->with('error', 'No tienes un prestamista asignado.');
        }

        SolicitudPrestamo::create([
            'id_cliente' => $cliente->id,
            'id_prestamista' => $cliente->id_user_prestamista, // ← correcto aquí
            'monto_solicitado' => $request->monto_solicitado,
            'comentario' => $request->comentario,
            'estado' => 'pendiente',
        ]);

        return redirect()->route('solicitudes.create')->with('success', 'Solicitud enviada correctamente.');
    }

    public function aprobar($id)
    {
        $solicitud = SolicitudPrestamo::findOrFail($id);

        if ($solicitud->estado !== 'pendiente') {
            return back()->with('error', 'La solicitud ya fue procesada.');
        }

        $solicitud->estado = 'aprobado';
        $solicitud->save();

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
