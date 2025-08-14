<?php

namespace App\Http\Controllers;

use App\Models\Interes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Str;

class PerfilController extends Controller
{
    public function index()
    {
        $interes = Interes::where('estado', 'activo')->first();
        return view('perfil.perfil', compact('interes'));
    }
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validación
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'avatar'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'qr'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Actualizar datos básicos
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->telefono = $request->phone;

        // Contraseña
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Avatar
        if ($request->hasFile('avatar')) {
            if ($user->imagen && Storage::exists('public/' . $user->imagen)) {
                Storage::delete('public/' . $user->imagen);
            }
            $user->foto = $request->file('avatar')->store('usuarios/fotos', 'public');
        }

        // QR
        if ($request->hasFile('qr')) {
            if ($user->qr && Storage::exists('public/' . $user->qr)) {
                Storage::delete('public/' . $user->qr);
            }
            $user->qr = $request->file('qr')->store('usuarios/qr', 'public');
        }


        $user->save();

        return redirect()->route('perfil.index')->with('success', 'Perfil actualizado correctamente');
    }
}
