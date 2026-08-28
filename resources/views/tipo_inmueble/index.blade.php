@extends('layouts.app')


@section('title')
    TITULO
@endsection


@section('content')


<x-card>

    <div>

        <div>

            <div>
                <h2>Listado de los tipos de inmuebles</h2>
                <br>

                <a href="{{ route('tipo_inmueble.create') }}">
                    Nuevo tipo de inmueble
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>tipo de inmueble</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($tipo_inmueble as $tipoInmueble)
                        <tr>
                            <td>{{ $tipoInmueble->id }}</td>
                            <td>{{ $tipoInmueble->nombre }}</td>

                            <td>
                                <a href="{{ route('tipo_inmueble.edit', $tipoInmueble->id) }}">
                                    Editar
                                </a>
                            </td>

                            <td>
                                <form action="{{ route('tipo_inmueble.destroy', $tipoInmueble->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>

    </div>

</x-card>

@endsection