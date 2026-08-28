@extends('layouts.app')


@section('title')
    TITULO
@endsection


@section('content')


<x-card>

    <div>
        <div>

            <h2>Editar municipio</h2>
            <br>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-5">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('tipo_inmueble.update', $tipo_inmueble->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div>
                    <label for="nombre" class="block mb-2 font-semibold">
                        Tipo de inmueble
                    </label>

                    <input
                        type="text"
                        name="nombre"
                        id="nombre"
                        value="{{ $tipo_inmueble->nombre }}"
                        class="w-full border rounded px-3 py-2"
                    >
                </div>

                

                <div>
                    <button type="submit">
                        Actualizar
                    </button>
                </div>

            </form>

        </div>
    </div>

</x-card>

@endsection