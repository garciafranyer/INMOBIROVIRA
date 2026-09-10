@extends('layouts.app')


@section('title')
    TITULO
@endsection


@section('content')


<x-card>

    <div>

        <div>

            <div>
                <h2>Listado de barrios</h2>
                <br>

                <a href="{{ route('barrio.create') }}">
                    Nuevo Barrio
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
                        <th>ID</th>
                        <th>Nombre barrio</th>
                        <th>ID municipio</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($barrio as $barrio)
                        <tr>
                            <td>{{ $barrio->id }}</td>
                            <td>{{ $barrio->nombre }}</td>
                            <td>{{ $barrio->municipio->nombre }}</td>

                            <td>
                                <a href="{{ route('barrio.edit', $barrio->id) }}">
                                    Editar
                                </a>
                            </td>

                            <td>
                                <form action="{{ route('barrio.destroy', $barrio->id) }}" method="POST">
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