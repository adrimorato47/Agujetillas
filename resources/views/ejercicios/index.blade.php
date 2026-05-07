@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-bold">Mis Ejercicios</h1>
                    <a href="{{ route('ejercicios.create') }}" class="px-4 py-2 font-bold text-white bg-blue-600 rounded hover:bg-blue-800">
                        + Nuevo ejercicio
                    </a>
                </div>

                @if(session('success'))
                    <div class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if($ejercicios->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Nombre</th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Descripción</th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Video</th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($ejercicios as $ejercicio)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $ejercicio->nombre }}</td>
                                        <td class="px-6 py-4">{{ Str::limit($ejercicio->descripcion, 50) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($ejercicio->video_url)
                                                <a href="{{ $ejercicio->video_url }}" target="_blank" class="text-blue-500 hover:underline">Ver video</a>
                                            @else
                                                —
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('ejercicios.edit', $ejercicio->id) }}" class="mr-3 text-indigo-600 hover:text-indigo-900">Editar</a>
                                            <form action="{{ route('ejercicios.destroy', $ejercicio->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de eliminar este ejercicio?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="mt-6">
                        {{ $ejercicios->links() }}
                    </div>
                @else
                    <div class="py-12 text-center">
                        <p class="text-lg text-gray-500">No tienes ejercicios creados aún.</p>
                        <a href="{{ route('ejercicios.create') }}" class="inline-block px-4 py-2 mt-4 font-bold text-white bg-blue-600 rounded hover:bg-blue-800">
                            Crear mi primer ejercicio
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
