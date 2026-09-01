@extends('layouts.app')


@section('title')
    TITULO
@endsection


@section('content')


<x-card>

    <div>
        <div>
            <h2>Actualizar usuario</h2>
            <br>


            @if ($errors->any())

            <div>
                <ul>
                    @foreach ($errors->all() as $error )
                    <li>{{$error}}</li>                        
                    @endforeach
                </ul>
            </div>
                
            @endif
            <form action="{{ route('usuario.update', $usuario->id) }}" method="POST">
            @csrf
            @method('PUT')
                <div>
                    <label for="" class="block mb-2 font-semibold">Nombre usuario</label>
                    <input type="text" name="nombre" value="{{ $usuario->nombre}}"
                        class="w-full border rounded px-3 py-2" class="w-full border rounded px-3 py-2">
                </div>

                <div>
                    <label for="" class="block mb-2 font-semibold">Gmail </label>
                    <input type="text" name="gmail" value="{{ $usuario->gmail}}"
                        class="w-full border rounded px-3 py-2" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label for="" class="block mb-2 font-semibold">Telefono </label>
                    <input type="text" name="telefono" value="{{ $usuario->telefono}}"
                        class="w-full border rounded px-3 py-2" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label for="" class="block mb-2 font-semibold">Direccion </label>
                    <input type="text" name="direccion" value="{{ $usuario->direccion}}"
                        class="w-full border rounded px-3 py-2" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label for="" class="block mb-2 font-semibold">Tipo de usuario</label>
                   <select name="tipo_usuario" id="tipo_usuario"  class="w-full border rounded px-3 py-2">
                       <option value="persona" {{ $usuario->tipo_usuario == 'persona' ? 'selected' : '';}}>Persona</option>
                       <option value="inmobiliaria" {{ $usuario->tipo_usuario == 'inmobiliaria' ? 'selected' : '';}}>Inmobiliaria</option>
                    </select>
                </div>
                <div>
                    <label for="" class="block mb-2 font-semibold">Nombre de la empresa </label>
                    <input type="text" name="nombre_empresa" value="{{ $usuario->nombre_empresa}}"
                        class="w-full border rounded px-3 py-2" class="w-full border rounded px-3 py-2">
                </div>
                

                <div>
                    <button type="submit">Actualizar</button>
                    <a href="{{route('usuario.index')}}">Cancelar</a>
                </div>

            </form>
        </div>
    </div>


</x-card>

@endsection