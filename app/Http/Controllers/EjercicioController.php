<?php

namespace App\Http\Controllers;

use App\Models\Ejercicio;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class EjercicioController extends Controller
{
    /**
     * Mostrar lista de ejercicios del usuario autenticado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    // En controlador (cambiar respuestas JsonResponse por views)
    // app/Http/Controllers/EjercicioController.php

    public function index()
    {
        $ejercicios = Ejercicio::where('user_id', auth()->id())
                            ->orderBy('nombre')
                            ->paginate(15);
        return view('ejercicios.index', compact('ejercicios'));
    }

    public function create()
    {
        return view('ejercicios.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'video_url' => 'nullable|url|max:500',
        ]);

        Ejercicio::create([
            'user_id' => auth()->id(),
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'] ?? null,
            'video_url' => $validated['video_url'] ?? null,
        ]);

        return redirect()->route('ejercicios.index')->with('success', 'Ejercicio creado correctamente.');
    }

    public function edit($id)
    {
        $ejercicio = Ejercicio::where('user_id', auth()->id())->findOrFail($id);
        return view('ejercicios.edit', compact('ejercicio'));
    }

    public function update(Request $request, $id)
    {
        $ejercicio = Ejercicio::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'video_url' => 'nullable|url|max:500',
        ]);

        $ejercicio->update($validated);
        return redirect()->route('ejercicios.index')->with('success', 'Ejercicio actualizado.');
    }

    public function destroy($id)
    {
        $ejercicio = Ejercicio::where('user_id', auth()->id())->findOrFail($id);
        $ejercicio->delete();
        return redirect()->route('ejercicios.index')->with('success', 'Ejercicio eliminado.');
    }
}
