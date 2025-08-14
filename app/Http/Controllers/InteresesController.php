<?php

namespace App\Http\Controllers;

use App\Models\Interes;
use App\Models\TipoPlazo;
use Illuminate\Http\Request;

class InteresesController extends Controller
{
    public function index()
    {
        $plazos = TipoPlazo::paginate(10);
        $intereses = Interes::with('tipoPlazo')->paginate(10, ['*'], 'interes_page');

        return view('intereses.intereses', compact('plazos', 'intereses'));
    }

    // Métodos para TipoPlazo
    public function storePlazo(Request $request)
    {
        try {
            TipoPlazo::create([
                'nombre' => $request->nombre,
                'estado' => $request->estado
            ]);

            return redirect()->back()->with('success', 'Tipo de plazo registrado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'No se pudo crear el tipo de plazo.');
        }
    }

    public function editPlazo($id)
    {
        $plazo = TipoPlazo::findOrFail($id);
        return response()->json($plazo);
    }

    public function updatePlazo(Request $request, $id)
    {
        try {
            $plazo = TipoPlazo::findOrFail($id);
            $plazo->update($request->all());

            return redirect()->back()->with('success', 'Tipo de plazo actualizado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'No se pudo actualizar el tipo de plazo.');
        }
    }

    public function toggleStatusPlazo($id)
    {
        try {
            $plazo = TipoPlazo::findOrFail($id);
            $plazo->estado = !$plazo->estado;
            $plazo->save();

            return response()->json(['success' => 'Estado cambiado exitosamente.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al cambiar estado'], 500);
        }
    }

    // Métodos para Interes
    public function storeInteres(Request $request)
    {
        //dd($request->all());


        Interes::create([
            'id_tipo_plazo' => $request->tipo_plazo_id,
            'tasa_interes' => $request->tasa,
            'estado' => $request->estado
        ]);

        return redirect()->back()->with('success', 'Tasa de interés registrada correctamente');
    }

    public function editInteres($id)
    {
        $interes = Interes::with('tipoPlazo')->findOrFail($id);
        return response()->json($interes);
    }

    public function updateInteres(Request $request, $id)
    {
        //dd($request->all());
        try {
            $interes = Interes::findOrFail($id);
            $interes->update($request->all());

            return redirect()->back()->with('success', 'Tasa de interés actualizada correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'No se pudo actualizar la tasa de interés.');
        }
    }

    public function toggleStatusInteres($id)
    {
        try {
            $interes = Interes::findOrFail($id);
            $interes->estado = !$interes->estado;
            $interes->save();

            return response()->json(['success' => 'Estado cambiado exitosamente.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al cambiar estado'], 500);
        }
    }

    // Método para obtener intereses por plazo (si es necesario)
    public function interesesPorPlazo($id)
    {
        try {
            $intereses = Interes::where('tipo_plazo_id', $id)->get();
            return response()->json($intereses);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener intereses'], 500);
        }
    }
}
