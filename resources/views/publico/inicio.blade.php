@extends('layouts.publico')

@section('title', 'Inmuebles disponibles')

@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Inmuebles disponibles</h1>
    <p class="text-gray-500">Encuentra tu próximo hogar en García Rovira.</p>
</div>

@if ($inmuebles->isEmpty())
    <div class="bg-white border border-gray-200 rounded-xl p-10 text-center text-gray-500">
        Aún no hay inmuebles disponibles.
    </div>
@else
    <div id="inmuebles" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($inmuebles as $inmueble)
            <x-publico.tarjeta-inmueble :inmueble="$inmueble" />
        @endforeach
    </div>

    <div class="mt-8">
        {{ $inmuebles->links() }}
    </div>
@endif

@endsection