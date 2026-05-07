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

                <!-- Listado de grupos asignados -->
                <h2 class="text-xl font-semibold mb-4">Grupos asignados</h2>
                @if($dia->gruposMusculares->count() > 0)
                    <table class="min-w-full bg-white border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-6 py-3 text-left">Nombre</th>
                                <th class="px-6 py-3 text-left">Orden</th>
                                <th class="px-6 py-3 text-left">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dia->gruposMusculares as $grupo)
                            <tr class="border-t">
                                <td class="px-6 py-4">{{ $grupo->nombre }}</td>
                                <td class="px-6 py-4">{{ $grupo->pivot->orden ?? 0 }}</td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('dia-grupo.destroy', $grupo->pivot->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este grupo?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-gray-500">Aún no hay grupos asignados. Agrega uno arriba.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection