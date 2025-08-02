<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class PrestamosController extends Controller
{
    public function create()
    {
        $clientes = Cliente::where('id_user_prestamista', auth()->id())->get();

        return view('prestamos.prestamos',compact('clientes'));
    }
}
