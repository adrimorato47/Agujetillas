@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Día: {{ $dia->fecha->format('d/m/Y') }} {{ $dia->nombre ? '- '.$dia->nombre : '' }}</h1>
                    <a href="{{ route('dias-plantilla.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">← Volver</a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
                @endif

                <!-- Formulario para asignar grupo muscular -->
                <div class="bg-gray-50 p-4 rounded mb-6">
                    <h2 class="text-xl font-semibold mb-4">Añadir grupo muscular</h2>
                    <form action="{{ route('dia-grupo.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="dia_plantilla_id" value="{{ $dia->id }}">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="grupo_muscular_id" class="block text-sm font-medium text-gray-700">Grupo muscular</label>
                                <select name="grupo_muscular_id" id="grupo_muscular_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring">
                                    <option value="">Seleccionar...</option>
                                    @foreach($gruposDisponibles as $grupo)
                                        <option value="{{ $grupo->id }}">{{ $grupo->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="orden" class="block text-sm font-medium text-gray-700">Orden (opcional)</label>
                                <input type="number" name="orden" id="orden" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring">
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">Asignar grupo</button>
                        </div>
                    </form>
                </div>

                <!-- Listado de grupos asignados con sus ejercicios -->
                <!-- Listado de grupos asignados -->
<h2 class="text-xl font-semibold mb-4">Grupos asignados</h2>
@if($dia->diaGrupos->count() > 0)
    @foreach($dia->diaGrupos->sortBy('orden') as $diaGrupo)   {{-- orden seguro --}}
        <div class="mb-6 border rounded p-4 bg-gray-50">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold">{{ $diaGrupo->grupoMuscular->nombre }}</h3>
                    <p class="text-sm text-gray-500">Orden: {{ $diaGrupo->orden ?? 0 }}</p>
                </div>
                <!-- Botón eliminar grupo -->
                <form action="{{ route('dia-grupo.destroy', $diaGrupo->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este grupo?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-800 text-white font-bold py-2 px-4 rounded">
                        Eliminar grupo
                    </button>
                </form>
            </div>

            <!-- Listado de ejercicios asignados -->
            @if($diaGrupo->ejercicios->count() > 0)
                <table class="min-w-full mt-3 bg-white border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-left">Ejercicio</th>
                            <th class="px-4 py-2 text-left">Orden</th>
                            <th class="px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($diaGrupo->ejercicios->sortBy('orden') as $asignacionEj)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $asignacionEj->ejercicio->nombre }}</td>
                            <td class="px-4 py-2">{{ $asignacionEj->orden ?? '—' }}</td>
                            <td class="px-4 py-2 text-center">
                                <form action="{{ route('dia-ejercicio.destroy', $asignacionEj->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este ejercicio?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-500 mt-3">No hay ejercicios asignados a este grupo aún.</p>
            @endif

            <!-- Formulario para añadir ejercicio -->
            <div class="mt-4 border-t pt-4">
                <h4 class="font-medium mb-2">Añadir ejercicio</h4>
                <form action="{{ route('dia-ejercicio.store') }}" method="POST" class="flex flex-wrap gap-2 items-end">
                    @csrf
                    <input type="hidden" name="dia_grupo_id" value="{{ $diaGrupo->id }}">
                    <div>
                        <label for="ejercicio_id_{{ $diaGrupo->id }}" class="block text-sm text-gray-600">Ejercicio</label>
                        <select name="ejercicio_id" id="ejercicio_id_{{ $diaGrupo->id }}" required class="rounded border-gray-300">
                            <option value="">Seleccionar...</option>
                            @foreach($ejerciciosDisponibles as $ej)
                                <option value="{{ $ej->id }}">{{ $ej->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="orden_{{ $diaGrupo->id }}" class="block text-sm text-gray-600">Orden</label>
                        <input type="number" name="orden" id="orden_{{ $diaGrupo->id }}" placeholder="Opcional" class="rounded border-gray-300 w-24">
                    </div>
                    <div>
                        <button type="submit" class="bg-green-600 hover:bg-green-800 text-white px-4 py-2 rounded">Asignar</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
    @else
        <p class="text-gray-500">Aún no hay grupos asignados. Agrega uno arriba.</p>
    @endif
            </div>
        </div>
    </div>
</div>
@endsection