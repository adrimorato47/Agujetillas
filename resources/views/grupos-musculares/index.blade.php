@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Grupos Musculares</h1>
                    <a href="{{ route('grupos-musculares.create') }}" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
                        + Nuevo grupo
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
                @endif

                @if($grupos->count() > 0)
                    <table class="min-w-full bg-white border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-6 py-3 text-left">Nombre</th>
                                <th class="px-6 py-3 text-left">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grupos as $grupo)
                            <tr class="border-t">
                                <td class="px-6 py-4">{{ $grupo->nombre }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('grupos-musculares.edit', $grupo->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>
                                    <form action="{{ route('grupos-musculares.destroy', $grupo->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $grupos->links() }}</div>
                @else
                    <p class="text-gray-500 text-center">No tienes grupos creados. ¡Crea uno!</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection