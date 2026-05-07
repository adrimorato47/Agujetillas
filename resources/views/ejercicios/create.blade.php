@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h1 class="text-2xl font-bold mb-6">Crear nuevo ejercicio</h1>

                <form action="{{ route('ejercicios.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre *</label>
                        <input type="text" name="nombre" id="nombre" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                               value="{{ old('nombre') }}">
                        @error('nombre')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción (opcional)</label>
                        <textarea name="descripcion" id="descripcion" rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="video_url" class="block text-sm font-medium text-gray-700">URL del vídeo (opcional)</label>
                        <input type="url" name="video_url" id="video_url"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                               value="{{ old('video_url') }}">
                        @error('video_url')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('ejercicios.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">Cancelar</a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection