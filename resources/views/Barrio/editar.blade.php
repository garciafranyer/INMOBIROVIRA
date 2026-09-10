@extends('layouts.app')


@section('title')
    TITULO
@endsection


@section('content')


<x-card>

    <div>
        <div>

            <h2>Editar Barrio</h2>
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

            <form action="{{ route('barrio.update', $barrio->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div>
                    <label for="nombre" class="block mb-2 font-semibold">
                        Nombre Barrio
                    </label>

                    <input
                        type="text"
                        name="nombre"
                        id="nombre"
                        value="{{ $barrio->nombre }}"
                        class="w-full border rounded px-3 py-2"
                    >
                </div>

                <div>
                    <label for="id_municipio" class="block mb-2 font-semibold">
                        Id Municipio
                    </label>

                    <select name="id_municipio" class="w-full border rounded px-3 py-2" id="" >
                        @foreach ($municipios as $municipio)
                            <option value="{{ $municipio->id }}"{{ $municipio->id == $barrio->id_municipio ? 'selected' :  '' }}>{{$municipio->nombre}}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <button type="submit">
                        Actualizar
                    </button>
                    <a href="{{ route('barrio.index') }}">Cancelar</a>
                </div>

            </form>

        </div>
    </div>

</x-card>

@endsection