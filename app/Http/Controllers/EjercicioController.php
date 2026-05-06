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
    public function index(Request $request)
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
        // 1. Validar los datos del formulario
            $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'video_url' => 'nullable|url|max:500',
        ]);

        // 2. Crear el ejercicio asignando el user_id automáticamente
        Ejercicio::create([
            'user_id' => auth()->id(),           // ← importante: usuario logueado
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'] ?? null,
            'video_url' => $validated['video_url'] ?? null,
        ]);

        // 3. Redirigir con mensaje de éxito
        return redirect()->route('ejercicios.index')->with('success', 'Ejercicio creado correctamente.');
    }


    public function edit($id)
    {
        $ejercicio = Ejercicio::where('user_id', auth()->id())->findOrFail($id);
        return view('ejercicios.edit', compact('ejercicio'));
    }

    public function update(Request $request, $id)
    {
        // similar a store
    }

    public function destroy($id)
    {
        // similar al destroy de API
        return redirect()->route('ejercicios.index')->with('success', 'Eliminado');
    }
}