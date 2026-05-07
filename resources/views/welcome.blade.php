@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="text-3xl font-bold mb-4">¡Bienvenido a Agujetillas!</h1>
                <p class="mb-4 text-lg">
                    La aplicación que te permite guardar rutinas de entrenamiento personalizables, 
                    registrar tu progreso día a día y nunca perder de vista tus objetivos.
                </p>
                <p class="mb-4">
                    Con Agujetillas puedes:
                </p>
                <ul class="list-disc list-inside mb-6 space-y-1">
                    <li>Crear tus propios ejercicios y grupos musculares</li>
                    <li>Diseñar rutinas semanales a tu medida</li>
                    <li>Registrar series, repeticiones y pesos</li>
                    <li>Llevar un historial de tu evolución</li>
                </ul>
                @guest
                    <div class="mt-8">
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-3 px-6 rounded-lg shadow">
                            Comienza ahora - Crear cuenta gratis
                        </a>
                        <a href="{{ route('login') }}" class="ml-4 text-gray-600 hover:text-gray-900">¿Ya tienes cuenta? Inicia sesión</a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</div>
@endsection