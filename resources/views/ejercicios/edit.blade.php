@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h1 class="mb-6 text-2xl font-bold">Editar ejercicio: {{ $ejercicio->nombre }}</h1>

                <form action="{{ route('ejercicios.update', $ejercicio->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre *</label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $ejercicio->nombre) }}" required
                               class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        @error('nombre') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                        <textarea name="descripcion" id="descripcion" rows="3"
                                  class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">{{ old('descripcion', $ejercicio->descripcion) }}</textarea>
                        @error('descripcion') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="video_url" class="block text-sm font-medium text-gray-700">URL del video</label>
                        <input type="url" name="video_url" id="video_url" value="{{ old('video_url', $ejercicio->video_url) }}"
                               class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        @error('video_url') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('ejercicios.index') }}" class="px-4 py-2 mr-2 font-bold text-gray-800 bg-gray-300 rounded hover:bg-gray-400">Cancelar</a>
                        <button type="submit" class="px-4 py-2 font-bold text-white bg-blue-600 rounded hover:bg-blue-800">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
