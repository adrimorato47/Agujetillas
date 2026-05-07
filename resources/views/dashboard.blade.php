@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Tarjeta de bienvenida -->
        <div class="mb-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="text-2xl font-bold">¡Bienvenido, {{ Auth::user()->name }}!</h1>
                <p class="mt-2">Aquí tienes un resumen de tu progreso y accesos directos.</p>
            </div>
        </div>

        <!-- Accesos rápidos -->
        <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-3">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-center">
                    <div class="mb-3 text-4xl">💪</div>
                    <h2 class="text-xl font-semibold">Ejercicios</h2>
                    <p class="mt-2 mb-4 text-gray-600">Gestiona tu catálogo de ejercicios personalizados.</p>
                    <a href="{{ route('ejercicios.index') }}" class="inline-block px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-700">
                        Ver ejercicios
                    </a>
                </div>
            </div>
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-center">
                    <div class="mb-3 text-4xl">📅</div>
                    <h2 class="text-xl font-semibold">Rutinas</h2>
                    <p class="mt-2 mb-4 text-gray-600">Crea y edita tus rutinas semanales.</p>
                    <a href="#" class="inline-block px-4 py-2 text-white bg-green-500 rounded hover:bg-green-700">
                        Próximamente
                    </a>
                </div>
            </div>
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-center">
                    <div class="mb-3 text-4xl">📊</div>
                    <h2 class="text-xl font-semibold">Historial</h2>
                    <p class="mt-2 mb-4 text-gray-600">Revisa tu progreso y marcas personales.</p>
                    <a href="#" class="inline-block px-4 py-2 text-white bg-purple-500 rounded hover:bg-purple-700">
                        Próximamente
                    </a>
                </div>
            </div>
        </div>

        <!-- Últimos ejercicios añadidos (ejemplo) -->
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="mb-4 text-xl font-bold">Últimos ejercicios añadidos</h2>
                @php
                    $ultimosEjercicios = App\Models\Ejercicio::where('user_id', auth()->id())
                                        ->orderBy('created_at', 'desc')
                                        ->limit(5)
                                        ->get();
                @endphp
                @if($ultimosEjercicios->count() > 0)
                    <ul class="divide-y divide-gray-200">
                        @foreach($ultimosEjercicios as $ejercicio)
                            <li class="flex justify-between py-3">
                                <span class="font-medium">{{ $ejercicio->nombre }}</span>
                                <span class="text-sm text-gray-500">Añadido el {{ $ejercicio->created_at->format('d/m/Y') }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500">Aún no has añadido ningún ejercicio. ¡Empieza creando tu primer ejercicio!</p>
                    <a href="{{ route('ejercicios.create') }}" class="inline-block px-4 py-2 mt-3 text-white bg-blue-500 rounded hover:bg-blue-700">
                        Crear primer ejercicio
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
