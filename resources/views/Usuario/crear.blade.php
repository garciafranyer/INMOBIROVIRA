@extends('layouts.app')


@section('title')
    TITULO
@endsection


@section('content')


<x-card>

    <div>
        <div>
            <h2>Nuevo usuario</h2>
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
            <form action="{{ route('usuario.store') }}"method="post">
                @csrf
                <div>
                    <label for="" class="block mb-2 font-semibold">Nombre usuario</label>
                    <input type="text" name="nombre" class="w-full border rounded px-3 py-2">
                </div>

                <div>
                    <label for="" class="block mb-2 font-semibold">Gmail </label>
                    <input type="text" name="gmail" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label for="" class="block mb-2 font-semibold">Telefono </label>
                    <input type="text" name="telefono" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label for="" class="block mb-2 font-semibold">Direccion </label>
                    <input type="text" name="direccion" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label for="" class="block mb-2 font-semibold">Tipo de usuario</label>
                   <select name="tipo_usuario" id="tipo_usuario" class="w-full border rounded px-3 py-2">
                       <option value="persona">Persona</option>
                       <option value="inmobiliaria">Inmobiliaria</option>
                    </select>
                </div>
                <div>
                    <label for="" class="block mb-2 font-semibold">Nombre de la empresa </label>
                    <input type="text" name="nombre_empresa" class="w-full border rounded px-3 py-2">
                </div>
                

                <div>
                    <button type="submit">Guardar</button>
                    <a href="{{route('usuario.index')}}">Cancelar</a>
                </div>

                

            </form>
        </div>
    </div>


</x-card>

@endsection