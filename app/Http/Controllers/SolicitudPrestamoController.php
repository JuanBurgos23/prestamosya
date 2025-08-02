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
        return view('solicitudes.solicitudPrestamo');
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
    public function pendientes()
    {
        $prestamista = Auth::user();

        // Obtener todas las solicitudes con estado 'pendiente' que pertenecen al prestamista actual
        $solicitudes = SolicitudPrestamo::with('cliente.user') // cliente -> usuario (relación para mostrar el nombre/email)
            ->where('id_prestamista', $prestamista->id)
            ->where('estado', 'pendiente')
            ->latest()
            ->get();

        return view('prestamos.solicitudPendiente', compact('solicitudes'));
    }
}
