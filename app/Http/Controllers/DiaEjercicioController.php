<?php

namespace App\Http\Controllers;

use App\Models\DiaGrupo;
use App\Models\Ejercicio;
use App\Models\DiaEjercicio;
use Illuminate\Http\Request;

class DiaEjercicioController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'dia_grupo_id' => 'required|exists:dia_grupo,id',
            'ejercicio_id' => 'required|exists:ejercicios,id',
            'orden' => 'nullable|integer|min:0',
        ]);

        $diaGrupo = DiaGrupo::with('diaPlantilla')->findOrFail($validated['dia_grupo_id']);
        if ($diaGrupo->diaPlantilla->user_id !== auth()->id()) abort(403);

        $ejercicio = Ejercicio::where('user_id', auth()->id())->findOrFail($validated['ejercicio_id']);

        $exists = DiaEjercicio::where('dia_grupo_id', $diaGrupo->id)
                              ->where('ejercicio_id', $ejercicio->id)
                              ->exists();
        if ($exists) {
            return redirect()->back()->with('error', 'Este ejercicio ya está asignado.');
        }

        DiaEjercicio::create([
            'dia_grupo_id' => $diaGrupo->id,
            'ejercicio_id' => $ejercicio->id,
            'orden' => $validated['orden'] ?? 0,
        ]);

        return redirect()->back()->with('success', 'Ejercicio asignado correctamente.');
    }

    public function destroy($id)
    {
        $asignacion = DiaEjercicio::with('diaGrupo.diaPlantilla')->findOrFail($id);
        if ($asignacion->diaGrupo->diaPlantilla->user_id !== auth()->id()) abort(403);
        $asignacion->delete();
        return redirect()->back()->with('success', 'Ejercicio removido.');
    }
}