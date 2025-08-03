<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombre_completo' => 'required',
            'ci' => 'required|unique:clientes',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'referencia_nombre' => 'required',
            'referencia_ci' => 'required',
            'referencia_telefono' => 'required',
        ]);

        $user = User::create([
            'name' => $request->nombre_completo,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $idPrestamista = auth()->id();

        $user->assignRole('Cliente');

        // 2. Subir la foto
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('clientes', 'public');
        }

        // 3. Crear el cliente
        // 3. Crear el cliente
        $cliente = Cliente::create([
            'user_id' => $user->id,
            'nombre_completo' => $request->nombre_completo,
            'ci' => $request->ci,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'nacionalidad' => $request->nacionalidad,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'email' => $request->email,
            'ocupacion' => $request->ocupacion,
            'egresos_mensuales' => $request->egresos_mensuales,
            'referencia_nombre' => $request->referencia_nombre,
            'referencia_ci' => $request->referencia_ci,
            'referencia_telefono' => $request->referencia_telefono,
            'lugar_trabajo' => $request->lugar_trabajo,
            'estado_civil' => $request->estado_civil,
            'genero' => $request->genero,
            'foto' => $fotoPath,
            'id_user_prestamista' => $idPrestamista
        ]);
        return redirect()->route('prestamos.create', ['cliente_id' => $cliente->id]);
    }


    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre_completo' => 'required',
            'ci' => 'required|unique:clientes,ci,' . $cliente->id,
            'email' => 'required|email|unique:users,email,' . $cliente->user_id,
        ]);

        $cliente->update($request->except(['email']));
        $cliente->user->update(['email' => $request->email]);

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->user()->delete(); // Borra el usuario relacionado también
        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado');
    }
}
