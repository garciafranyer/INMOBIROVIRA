@extends('layouts.app')


@section('title')
    TITULO
@endsection


@section('content')


<x-card>

    <div>

        <div>

            <div>
                <h2>Listado de municipios</h2>
                <br>

                <a href="{{ route('municipio.create') }}">
                    Nuevo municipio
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
                        <th>Nombre municipio</th>
                        <th>Código postal</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($municipio as $municipios)
                        <tr>
                            <td>{{ $municipios->id }}</td>
                            <td>{{ $municipios->nombre }}</td>
                            <td>{{ $municipios->codigo_postal }}</td>

                            <td>
                                <a href="{{ route('municipio.edit', $municipios->id) }}">
                                    Editar
                                </a>
                            </td>

                            <td>
                                <form action="{{ route('municipio.destroy', $municipios->id) }}" method="POST">
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