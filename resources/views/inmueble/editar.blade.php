@extends('layouts.app')


@section('title')
    TITULO
@endsection


@section('content')


<x-card>

    <div>
        <div>
            <h2>Editar inmueble</h2>
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
            <form action="{{ route('inmueble.update', $inmueble->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div>
                    <label for="" class="block mb-2 font-semibold">Nombre de inmueble</label>
                    <input type="text" name="nombre" value="{{ $inmueble->nombre }}" class="w-full border rounded px-3 py-2">
                </div>

                <div>
                    <label for="" class="block mb-2 font-semibold">Zona del inmueble</label>
                    <select name="zona" id="zona" value="{{ $inmueble->zona }}" class="w-full border rounded px-3 py-2">
                       <option value="rural"{{ $inmueble->zona == 'rural' ? 'selected' : '';}}>Rural</option>
                       <option value="urbana"{{ $inmueble->zona == 'urbana' ? 'selected' : '';}}>Urbana</option>
                    </select>
                </div>

                <div>
                    <label for="" class="block mb-2 font-semibold">id usuario </label>
                    <select name="id_usuario" class="w-full border rounded px-3 py-2" id="">
                        @foreach ($usuario as $usuario )
                        <option value="{{ $usuario->id }}"{{ $usuario->id == $inmueble->id_usuario ? 'selected' :  '' }}>{{$usuario->nombre}}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="" class="block mb-2 font-semibold">id tipo de inmueble </label>
                    <select name="id_tipo_inmueble" class="w-full border rounded px-3 py-2" id="">
                        @foreach ($tipo_inmueble as $tipo_inmueble )
                        <option value="{{ $tipo_inmueble->id }}"{{$tipo_inmueble->id ==$inmueble->id_tipo_inmueble ? 'selected' : '' }}>{{$tipo_inmueble->nombre}}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="" class="block mb-2 font-semibold">id municipio </label>
                    <select name="id_municipio" class="w-full border rounded px-3 py-2" id="" >
                        @foreach ($municipios as $municipio)
                            <option value="{{ $municipio->id }}"{{ $municipio->id == $inmueble->id_municipio ? 'selected' :  '' }}>{{$municipio->nombre}}</option>
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