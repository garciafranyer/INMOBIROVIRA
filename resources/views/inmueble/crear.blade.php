@extends('layouts.app')


@section('title')
    TITULO
@endsection


@section('content')


<x-card>

    <div>
        <div>
            <h2>Nuevo inmueble</h2>
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
            <form action="{{ route('inmueble.store') }}"method="post">
                @csrf
                <div>
                    <label for="" class="block mb-2 font-semibold">Nombre de inmueble</label>
                    <input type="text" name="nombre" class="w-full border rounded px-3 py-2">
                </div>

                <div>
                    <label for="" class="block mb-2 font-semibold">Zona del inmueble</label>
                    <select name="zona" id="zona" class="w-full border rounded px-3 py-2">
                       <option value="rural">Rural</option>
                       <option value="urbana">Urbana</option>
                    </select>
                </div>

                <div>
                    <label for="" class="block mb-2 font-semibold">usuario </label>
                    <select name="id_usuario" class="w-full border rounded px-3 py-2" id="">
                        @foreach ($usuario as $usuario )
                        <option value="{{ $usuario->id }}">{{$usuario->nombre}}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="" class="block mb-2 font-semibold">tipo de inmueble </label>
                    <select name="id_tipo_inmueble" class="w-full border rounded px-3 py-2" id="">
                        @foreach ($tipo_inmueble as $tipo_inmueble )
                        <option value="{{ $tipo_inmueble->id }}">{{$tipo_inmueble->nombre}}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="" class="block mb-2 font-semibold">municipio </label>
                    <select name="id_municipio" class="w-full border rounded px-3 py-2" id="">
                        @foreach ($municipios as $municipio )
                        <option value="{{ $municipio->id }}">{{$municipio->nombre}}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <button type="submit">Guardar</button>
                    <a href="{{ route('inmueble.index') }}">Cancelar</a>
                </div>

            </form>
        </div>
    </div>


</x-card>

@endsection