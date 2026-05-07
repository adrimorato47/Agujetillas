<?php

namespace App\Http\Controllers;

use App\Models\DiaPlantilla;
use App\Models\GrupoMuscular;
use App\Models\DiaGrupo;
use Illuminate\Http\Request;

class DiaGrupoController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'dia_plantilla_id' => 'required|exists:dias_plantilla,id',
            'grupo_muscular_id' => 'required|exists:grupos_musculares,id',
            'orden' => 'nullable|integer|min:0',
        ]);

        // Verificar que el día pertenece al usuario autenticado
        $dia = DiaPlantilla::where('user_id', auth()->id())
                            ->findOrFail($validated['dia_plantilla_id']);
        
        // Verificar que el grupo pertenece al usuario
        $grupo = GrupoMuscular::where('user_id', auth()->id())
                                ->findOrFail($validated['grupo_muscular_id']);

        // Evitar duplicados
        $exists = DiaGrupo::where('dia_plantilla_id', $dia->id)
                          ->where('grupo_muscular_id', $grupo->id)
                          ->exists();
        if ($exists) {
            return redirect()->back()->with('error', 'Este grupo ya está asignado.');
        }

        DiaGrupo::create([
            'dia_plantilla_id' => $dia->id,
            'grupo_muscular_id' => $grupo->id,
            'orden' => $validated['orden'] ?? 0,
        ]);

        return redirect()->route('dias-plantilla.show', $dia->id)
                         ->with('success', 'Grupo asignado correctamente.');
    }

    public function destroy($id)
    {
        $asignacion = DiaGrupo::with('diaPlantilla')->findOrFail($id);
        
        // Verificar que el día pertenece al usuario
        if ($asignacion->diaPlantilla->user_id !== auth()->id()) {
            abort(403);
        }
        
        $asignacion->delete();
        return redirect()->back()->with('success', 'Grupo removido.');
    }
}