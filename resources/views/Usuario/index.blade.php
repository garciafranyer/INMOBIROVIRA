@extends('layouts.app')


@section('title')
    TITULO
@endsection


@section('content')


<x-card>

    <div>

        <div>

            <div>
                <h2>Listado de usuarios</h2>
                <br>

                <a href="{{ route('usuario.create') }}">
                    Nuevo Usuario
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
                        <th>Nombre usuario</th>
                        <th>gmail</th>
                        <th>telefono</th>
                        <th>direccion</th>
                        <th>tipo de usuario</th>
                        <th>nombre empresa</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($usuario as $usuario)
                        <tr>
                            <td>{{ $usuario->id }}</td>
                            <td>{{ $usuario->nombre }}</td>
                            <td>{{ $usuario->gmail }}</td>
                            <td>{{ $usuario->telefono }}</td>
                            <td>{{ $usuario->direccion }}</td>
                            <td>{{ $usuario->tipo_usuario }}</td>
                            <td>{{ $usuario->nombre_empresa }}</td>

                            <td>
                                <a href="{{ route('usuario.edit', $usuario->id) }}">
                                    Editar
                                </a>
                            </td>

                            <td>
                                <form action="{{ route('usuario.destroy', $usuario->id) }}" method="POST">
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