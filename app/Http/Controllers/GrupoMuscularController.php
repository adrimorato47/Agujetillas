<?php

namespace App\Http\Controllers;

use App\Models\GrupoMuscular;
use Illuminate\Http\Request;

class GrupoMuscularController extends Controller
{
    public function index()
    {
        $grupos = GrupoMuscular::where('user_id', auth()->id())
                               ->orderBy('nombre')
                               ->paginate(15);
        return view('grupos-musculares.index', compact('grupos'));
    }

    public function create()
    {
        return view('grupos-musculares.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        GrupoMuscular::create([
            'user_id' => auth()->id(),
            'nombre' => $validated['nombre'],
        ]);

        return redirect()->route('grupos-musculares.index')
                         ->with('success', 'Grupo muscular creado.');
    }

    public function edit($id)
    {
        $grupo = GrupoMuscular::where('user_id', auth()->id())->findOrFail($id);
        return view('grupos-musculares.edit', compact('grupo'));
    }

    public function update(Request $request, $id)
    {
        $grupo = GrupoMuscular::where('user_id', auth()->id())->findOrFail($id);
        $validated = $request->validate(['nombre' => 'required|string|max:255']);
        $grupo->update($validated);
        return redirect()->route('grupos-musculares.index')
                         ->with('success', 'Grupo actualizado.');
    }

    public function destroy($id)
    {
        $grupo = GrupoMuscular::where('user_id', auth()->id())->findOrFail($id);
        // Opcional: verificar si está siendo usado en dia_grupo
        if ($grupo->diaGrupos()->exists()) {
            return redirect()->route('grupos-musculares.index')
                             ->with('error', 'No se puede eliminar porque está en uso.');
        }
        $grupo->delete();
        return redirect()->route('grupos-musculares.index')
                         ->with('success', 'Grupo eliminado.');
    }
}