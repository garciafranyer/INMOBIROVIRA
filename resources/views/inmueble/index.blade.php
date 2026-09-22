 @extends('layouts.app')


@section('title')
    TITULO
@endsection


@section('content')


<x-card>

    <div>

        <div>

            <div>
                <h2>Listado de inmuebles</h2>
                <br>

                <a href="{{ route('inmueble.create') }}">
                    Nuevo inmueble
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
                        <th>Nombre del inmueble</th>
                        <th>Zona</th>
                        <th>usuario</th>
                        <th>tipo de inmueble</th>
                        <th>municipio</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($inmueble as $inmueble)
                        <tr>
                            <td>{{ $inmueble->id }}</td>
                            <td>{{ $inmueble->nombre }}</td>
                            <td>{{ $inmueble->zona}}</td>
                            <td>{{ $inmueble->usuario->nombre }}</td>
                            <td>{{ $inmueble->tipo_inmueble->nombre }}</td>
                            <td>{{ $inmueble->municipio->nombre }}</td>

                            <td>
                                <a href="{{ route('inmueble.edit', $inmueble->id) }}">
                                    Editar
                                </a>
                            </td>

                            <td>
                                <form action="{{ route('inmueble.destroy', $inmueble->id) }}" method="POST">
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