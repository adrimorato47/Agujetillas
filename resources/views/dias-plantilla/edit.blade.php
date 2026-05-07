@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h1 class="text-2xl font-bold mb-6">Editar día plantilla: {{ $dia->fecha->format('d/m/Y') }}</h1>

                <form action="{{ route('dias-plantilla.update', $dia->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                        <input type="date" name="fecha" id="fecha" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                               value="{{ old('fecha', $dia->fecha->format('Y-m-d')) }}">
                        @error('fecha') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre (opcional)</label>
                        <input type="text" name="nombre" id="nombre"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                               value="{{ old('nombre', $dia->nombre) }}">
                        @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex justify-end">
                        <a href="{{ route('dias-plantilla.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">Cancelar</a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection