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
        //dd($request->all());
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

        // -------------------------
        // Cálculo interés y capital usando cuota fija
        $interesMensual = $prestamo->interes_total / $prestamo->plazo;
        $capitalMensual = ($prestamo->monto_total_pagar - $prestamo->interes_total) / $prestamo->plazo;

        if ($request->monto == $prestamo->cuota_estimada) {
            $interes = $interesMensual;
            $capital = $capitalMensual;
        } else {
            // Prorrateo proporcional si paga distinto a la cuota
            $proporcion = $request->monto / $prestamo->cuota_estimada;
            $interes = $interesMensual * $proporcion;
            $capital = $capitalMensual * $proporcion;
        }

        // Calcular la cuota estimada (capital + interés)
        $cuota_estimada = $capital + $interes;
        // -------------------------

        // Guardar comprobante si existe
        $comprobantePath = null;
        if ($request->hasFile('comprobante')) {
            $comprobantePath = $request->file('comprobante')->store('comprobantes', 'public');
        }
        $pagosPrevios = $prestamo->pagos()->sum('monto');
        $saldo_restante = max(0, $prestamo->monto_total_pagar - ($pagosPrevios + $request->monto));
        // Crear el pago
        $pago = Pago::create([
            'id_prestamo' => $prestamo->id,
            'monto' => $request->monto,
            'fecha_pago' => $request->fecha_pago,
            'interes_pagado' => $interes,
            'capital_pagado' => $capital,
            'cuota_estimada' => $cuota_estimada, // campo nuevo
            'saldo_restante' => $saldo_restante,
            'metodo_pago' => $request->metodo_pago,
            'comprobante' => $comprobantePath,
            'comentario' => $request->comentario,
            'id_clienteUser' => auth()->id(),
        ]);

        // Actualizar estado del préstamo si ya está pagado
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
