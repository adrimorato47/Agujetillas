<?php

namespace App\Http\Controllers;

use App\Models\SeriePlantilla;
use App\Models\DiaEjercicio;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class SeriePlantillaController extends Controller
{
    /**
     * Mostrar todas las series de un ejercicio específico en un día.
     * 
     * @param  int  $diaEjercicioId  ID de la relación día-ejercicio
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($diaEjercicioId)
    {
        $diaEjercicio = DiaEjercicio::with('ejercicio')->findOrFail($diaEjercicioId);
        
        // Verificar que el ejercicio pertenece al usuario autenticado
        if ($diaEjercicio->ejercicio->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $series = SeriePlantilla::where('dia_ejercicio_id', $diaEjercicioId)
            ->orderBy('numero_serie')
            ->get();

        return response()->json([
            'dia_ejercicio_id' => $diaEjercicioId,
            'ejercicio' => $diaEjercicio->ejercicio->nombre,
            'series' => $series
        ]);
    }

    /**
     * Guardar una nueva serie.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'dia_ejercicio_id' => 'required|exists:dia_ejercicio,id',
            'numero_serie' => 'required|integer|min:1',
            'repeticiones_planificadas' => 'required|integer|min:1',
            'peso_planificado' => 'nullable|numeric|min:0',
            'descanso_segundos' => 'nullable|integer|min:0'
        ]);

        // Verificar que el dia_ejercicio pertenece al usuario autenticado
        $diaEjercicio = DiaEjercicio::with('ejercicio')->findOrFail($validated['dia_ejercicio_id']);
        if ($diaEjercicio->ejercicio->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Validar que no exista ya una serie con el mismo número en el mismo dia_ejercicio
        $exists = SeriePlantilla::where('dia_ejercicio_id', $validated['dia_ejercicio_id'])
            ->where('numero_serie', $validated['numero_serie'])
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Ya existe una serie con el número ' . $validated['numero_serie'] . ' para este ejercicio.'
            ], 422);
        }

        $serie = SeriePlantilla::create($validated);

        return response()->json($serie, 201);
    }

    /**
     * Mostrar una serie específica.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $serie = SeriePlantilla::with('diaEjercicio.ejercicio')->findOrFail($id);
        
        // Verificar propiedad
        if ($serie->diaEjercicio->ejercicio->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($serie);
    }

    /**
     * Actualizar una serie existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $serie = SeriePlantilla::with('diaEjercicio.ejercicio')->findOrFail($id);
        
        if ($serie->diaEjercicio->ejercicio->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'numero_serie' => 'sometimes|integer|min:1',
            'repeticiones_planificadas' => 'sometimes|integer|min:1',
            'peso_planificado' => 'nullable|numeric|min:0',
            'descanso_segundos' => 'nullable|integer|min:0'
        ]);

        // Si se cambia el número de serie, verificar que no haya conflicto
        if (isset($validated['numero_serie']) && $validated['numero_serie'] != $serie->numero_serie) {
            $conflict = SeriePlantilla::where('dia_ejercicio_id', $serie->dia_ejercicio_id)
                ->where('numero_serie', $validated['numero_serie'])
                ->exists();

            if ($conflict) {
                return response()->json([
                    'message' => 'Ya existe una serie con el número ' . $validated['numero_serie'] . ' para este ejercicio.'
                ], 422);
            }
        }

        $serie->update($validated);

        return response()->json($serie);
    }

    /**
     * Eliminar una serie.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $serie = SeriePlantilla::with('diaEjercicio.ejercicio')->findOrFail($id);
        
        if ($serie->diaEjercicio->ejercicio->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $serie->delete();

        return response()->json(['message' => 'Serie eliminada correctamente']);
    }

    /**
     * Obtener todas las series de un entrenamiento completo (opcional, para resúmenes)
     *
     * @param  int  $diaPlantillaId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByDiaPlantilla($diaPlantillaId)
    {
        $diaPlantilla = \App\Models\DiaPlantilla::findOrFail($diaPlantillaId);
        
        if ($diaPlantilla->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $series = SeriePlantilla::whereHas('diaEjercicio.diaGrupo', function ($query) use ($diaPlantillaId) {
            $query->where('dia_plantilla_id', $diaPlantillaId);
        })
        ->with(['diaEjercicio.ejercicio', 'diaEjercicio.diaGrupo.grupoMuscular'])
        ->orderBy('dia_ejercicio_id')
        ->orderBy('numero_serie')
        ->get();

        return response()->json($series);
    }
}