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

            <form action="{{ route('municipio.update', $municipio->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div>
                    <label for="nombre" class="block mb-2 font-semibold">
                        Nombre municipio
                    </label>

                    <input
                        type="text"
                        name="nombre"
                        id="nombre"
                        value="{{ $municipio->nombre }}"
                        class="w-full border rounded px-3 py-2"
                    >
                </div>

                <div>
                    <label for="codigo_postal" class="block mb-2 font-semibold">
                        Código postal
                    </label>

                    <input
                        type="text"
                        name="codigo_postal"
                        id="codigo_postal"
                        value="{{ $municipio->codigo_postal }}"
                        class="w-full border rounded px-3 py-2"
                    >
                </div>

                <div>
                    <button type="submit">
                        Actualizar
                    </button>
                    <a href="{{ route('municipio.index') }}">Cancelar</a>
                </div>

            </form>

        </div>
    </div>

</x-card>

@endsection