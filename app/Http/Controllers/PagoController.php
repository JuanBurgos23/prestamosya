<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Prestamo;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function create($prestamo_id)
    {
        $prestamo = Prestamo::findOrFail($prestamo_id);
        
        // Verificar que el préstamo pertenece al cliente autenticado
        if (!auth()->user()->cliente || $prestamo->id_cliente != auth()->user()->cliente->id) {
            abort(403);
        }

        return view('pagos.create', compact('prestamo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_prestamo' => 'required|exists:prestamos,id',
            'monto' => 'required|numeric|min:0.01',
            'fecha_pago' => 'required|date',
            'metodo_pago' => 'required|string|max:50',
            'comprobante' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $prestamo = Prestamo::findOrFail($request->id_prestamo);
        
        // Verificar que el préstamo pertenece al cliente autenticado
        if ($prestamo->id_cliente != auth()->user()->cliente->id) {
            abort(403);
        }

        // Lógica para calcular interés y capital (depende de tu sistema de amortización)
        $interes = $prestamo->saldo_pendiente * ($prestamo->interes / 100 / 12); // Ejemplo mensual
        $capital = $request->monto - $interes;

        // Guardar comprobante si existe
        $comprobantePath = null;
        if ($request->hasFile('comprobante')) {
            $comprobantePath = $request->file('comprobante')->store('comprobantes', 'public');
        }

        // Crear el pago
        $pago = Pago::create([
            'id_prestamo' => $prestamo->id,
            'monto' => $request->monto,
            'fecha_pago' => $request->fecha_pago,
            'interes_pagado' => $interes,
            'capital_pagado' => $capital,
            'saldo_restante' => $prestamo->saldo_pendiente - $capital,
            'metodo_pago' => $request->metodo_pago,
            'comprobante' => $comprobantePath,
            'comentario' => $request->comentario,
            'id_prestamista' => auth()->id(),
        ]);

        // Actualizar estado del préstamo si está completamente pagado
        if ($pago->saldo_restante <= 0) {
            $prestamo->update([
                'estado' => 'completado',
                'fecha_finalizacion' => now(),
            ]);
        }

        return redirect()->route('prestamos.mis-prestamos')
            ->with('success', 'Pago registrado exitosamente');
    }
}
