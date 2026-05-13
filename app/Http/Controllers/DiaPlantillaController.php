<?php

namespace App\Http\Controllers;

use App\Models\DiaPlantilla;
use App\Models\GrupoMuscular;
use App\Models\Ejercicio;
use Illuminate\Http\Request;

class DiaPlantillaController extends Controller
{
    public function index()
    {
        $dias = DiaPlantilla::where('user_id', auth()->id())
                            ->orderBy('fecha', 'desc')
                            ->paginate(15);
        return view('dias-plantilla.index', compact('dias'));
    }

    public function create()
    {
        return view('dias-plantilla.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fecha' => 'required|date',
            'nombre' => 'nullable|string|max:255',
        ]);

        DiaPlantilla::create([
            'user_id' => auth()->id(),
            'fecha' => $validated['fecha'],
            'nombre' => $validated['nombre'] ?? null,
        ]);

        return redirect()->route('dias-plantilla.index')
                         ->with('success', 'Día plantilla creado.');
    }

    public function edit($id)
    {
        $dia = DiaPlantilla::where('user_id', auth()->id())->findOrFail($id);
        return view('dias-plantilla.edit', compact('dia'));
    }

    public function update(Request $request, $id)
    {
        $dia = DiaPlantilla::where('user_id', auth()->id())->findOrFail($id);
        $validated = $request->validate([
            'fecha' => 'required|date',
            'nombre' => 'nullable|string|max:255',
        ]);
        $dia->update($validated);
        return redirect()->route('dias-plantilla.index')
                         ->with('success', 'Día actualizado.');
    }
    public function show($id)
    {
        $dia = DiaPlantilla::where('user_id', auth()->id())
        ->with(['gruposMusculares' => function ($q) {
            $q->withPivot('id', 'orden');
        }])
        ->findOrFail($id);

        // Cargar los diaGrupos ordenados por 'orden' (de menor a mayor)
        $dia->load(['diaGrupos' => function ($q) {
            $q->orderBy('orden', 'asc')
            ->with(['ejercicios' => function ($q2) {
                $q2->with('ejercicio')->orderBy('orden', 'asc');
            }]);
        }]);

        $gruposDisponibles = GrupoMuscular::where('user_id', auth()->id())
                                        ->orderBy('nombre')
                                        ->get();
        $ejerciciosDisponibles = Ejercicio::where('user_id', auth()->id())
                                        ->orderBy('nombre')
                                        ->get();

        return view('dias-plantilla.show', compact('dia', 'gruposDisponibles', 'ejerciciosDisponibles'));
    }

    public function destroy($id)
    {
        $dia = DiaPlantilla::where('user_id', auth()->id())->findOrFail($id);
        // Opcional: verificar si tiene grupos asociados (dia_grupo)
        if ($dia->diaGrupos()->exists()) {
            return redirect()->route('dias-plantilla.index')
                             ->with('error', 'No se puede eliminar porque tiene grupos asignados.');
        }
        $dia->delete();
        return redirect()->route('dias-plantilla.index')
                         ->with('success', 'Día eliminado.');
    }
}