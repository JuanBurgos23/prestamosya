<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Cliente;
use App\Models\Prestamo;
use Illuminate\Http\Request;
use App\Models\SolicitudPrestamo;
use App\Http\Controllers\Controller;

class PrestamoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Prestamo::with(['cliente', 'pagos'])
            ->where('id_prestamista', auth()->id())
            ->orderBy('fecha_vencimiento', 'asc');

        // Filtros
        if ($request->estado) {
            if ($request->estado == 'atrasado') {
                $query->where('fecha_vencimiento', '<', now())
                    ->where('estado', 'activo');
            } else {
                $query->where('estado', $request->estado);
            }
        }

        if ($request->fecha_desde) {
            $query->where('fecha_inicio', '>=', $request->fecha_desde);
        }

        if ($request->fecha_hasta) {
            $query->where('fecha_inicio', '<=', $request->fecha_hasta);
        }

        // Estadísticas para los cards
        $totalPrestamosActivos = Prestamo::where('id_prestamista', auth()->id())
            ->where('estado', 'activo')
            ->sum('monto_aprobado');

        $totalRecuperado = Pago::whereHas('prestamo', function ($q) {
            $q->where('id_prestamista', auth()->id());
        })
            ->sum('monto');

        $totalClientes = Prestamo::where('id_prestamista', auth()->id())
            ->distinct('id_cliente')
            ->count('id_cliente');

        $porcentajeActivos = $totalPrestamosActivos > 0 ?
            round(($totalPrestamosActivos / ($totalPrestamosActivos + $totalRecuperado)) * 100) : 0;
        $porcentajeRecuperado = 100 - $porcentajeActivos;

        return view('prestamos.index', [
            'prestamos' => $query->paginate(10),
            'totalPrestamos' => $query->count(),
            'totalPrestamosActivos' => $totalPrestamosActivos,
            'totalRecuperado' => $totalRecuperado,
            'totalClientes' => $totalClientes,
            'porcentajeActivos' => $porcentajeActivos,
            'porcentajeRecuperado' => $porcentajeRecuperado
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $cliente_id = $request->cliente_id;
        $solicitud_id = $request->solicitud_id;

        $cliente = null;
        $solicitud = null;

        if ($cliente_id) {
            $cliente = Cliente::with('user')->findOrFail($cliente_id);
        }

        // Solo busca la solicitud si te pasan el ID (asociado a un cliente)
        if ($solicitud_id) {
            $solicitud = SolicitudPrestamo::findOrFail($solicitud_id);
        }

        $clientes = Cliente::all();

        return view('prestamos.create', compact('cliente', 'clientes', 'solicitud'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_cliente' => 'required|exists:clientes,id',
            'id_prestamista' => 'required|exists:users,id',
            'monto_aprobado' => 'required|numeric',
            'interes' => 'required|numeric',
            'plazo' => 'required|integer',
            'tipo_plazo' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_vencimiento' => 'required|date|after_or_equal:fecha_inicio',
            // 'comentario' => 'nullable|string',
        ]);

        $prestamo = new Prestamo($validated);
        $prestamo->comentario = $request->comentario;

        if ($request->has('id_solicitud')) {
            $solicitud = SolicitudPrestamo::findOrFail($request->id_solicitud);
            $solicitud->estado = 'aprobado';
            $solicitud->save();
            $prestamo->id_solicitud = $solicitud->id;
        }

        $prestamo->save();

        return redirect()->route('prestamos.index')->with('success', 'Préstamo registrado correctamente');
    }



    public function misPrestamos()
    {
        // Obtener el cliente autenticado (asumiendo que el usuario tiene un cliente asociado)
        $cliente = auth()->user()->cliente;

        if (!$cliente) {
            abort(403, 'No tiene un perfil de cliente asociado');
        }

        // Obtener préstamos activos
        $prestamosActivos = Prestamo::where('id_cliente', $cliente->id)
            ->where('estado', 'activo')
            ->with(['pagos'])
            ->get()
            ->map(function ($prestamo) {
                // Agregar atributos calculados
                $prestamo->monto_pagado = $prestamo->monto_pagado;
                $prestamo->interes_pagado = $prestamo->interes_pagado;
                $prestamo->saldo_pendiente = $prestamo->saldo_pendiente;
                $prestamo->porcentaje_pagado = $prestamo->porcentaje_pagado;
                $prestamo->proximo_pago = $prestamo->proximo_pago;
                $prestamo->monto_cuota = $prestamo->monto_cuota;
                return $prestamo;
            });

        // Obtener préstamos finalizados
        $prestamosFinalizados = Prestamo::where('id_cliente', $cliente->id)
            ->where('estado', 'completado')
            ->with(['pagos'])
            ->get()
            ->map(function ($prestamo) {
                $prestamo->monto_pagado = $prestamo->monto_pagado;
                $prestamo->interes_pagado = $prestamo->interes_pagado;
                $prestamo->porcentaje_pagado = 100;
                return $prestamo;
            });

        // Obtener solicitudes pendientes
        $prestamosPendientes = SolicitudPrestamo::where('id_cliente', $cliente->id)
            ->where('estado', 'pendiente')
            ->get();

        // Calcular totales
        $totalPendiente = $prestamosActivos->sum('saldo_pendiente');
        $totalPagado = $prestamosActivos->sum('monto_pagado') + $prestamosFinalizados->sum('monto_pagado');
        $totalPrestamos = $prestamosActivos->count() + $prestamosFinalizados->count() + $prestamosPendientes->count();

        // Calcular porcentajes para las barras de progreso
        $porcentajePendiente = $totalPagado + $totalPendiente > 0 ?
            round(($totalPendiente / ($totalPagado + $totalPendiente)) * 100) : 0;
        $porcentajePagado = 100 - $porcentajePendiente;

        return view('prestamos.mis-prestamos', compact(
            'prestamosActivos',
            'prestamosFinalizados',
            'prestamosPendientes',
            'totalPendiente',
            'totalPagado',
            'totalPrestamos',
            'porcentajePendiente',
            'porcentajePagado'
        ));
    }

    public function show($id)
    {
        $prestamo = Prestamo::with(['cliente', 'pagos', 'pagos.prestamista'])
            ->where('id_prestamista', auth()->id())
            ->findOrFail($id);

        return view('prestamos.show', compact('prestamo'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
