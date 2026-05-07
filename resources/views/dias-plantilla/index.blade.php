@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Días Plantilla</h1>
                    <a href="{{ route('dias-plantilla.create') }}" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
                        + Nuevo día
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
                @endif

                @if($dias->count() > 0)
                    <table class="min-w-full bg-white border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-6 py-3 text-left">Fecha</th>
                                <th class="px-6 py-3 text-left">Nombre</th>
                                <th class="px-6 py-3 text-left">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dias as $dia)
                            <tr class="border-t">
                                <td class="px-6 py-4">{{ $dia->fecha->format('d/m/Y') }}</td>
                                <td class="px-6 py-4">{{ $dia->nombre ?? '—' }}</td>                           
                                <td class="px-6 py-4">
                                  <a href="{{ route('dias-plantilla.show', $dia->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Ver</a>
                                  <a href="{{ route('dias-plantilla.edit', $dia->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>
                                    <form action="{{ route('dias-plantilla.destroy', $dia->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $dias->links() }}</div>
                @else
                    <p class="text-gray-500 text-center">No hay días plantilla. Crea uno.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection