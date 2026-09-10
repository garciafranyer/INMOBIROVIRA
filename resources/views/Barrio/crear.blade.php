@extends('layouts.app')


@section('title')
    TITULO
@endsection


@section('content')


<x-card>

    <div>
        <div>
            <h2>Nuevo Barrio</h2>
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
            <form action="{{ route('barrio.store') }}"method="post">
                @csrf
                <div>
                    <label for="" class="block mb-2 font-semibold">Nombre barrio</label>
                    <input type="text" name="nombre" class="w-full border rounded px-3 py-2">
                </div>

                <div>
                    <label for="" class="block mb-2 font-semibold">id municipio </label>
                    <select name="id_municipio" class="w-full border rounded px-3 py-2" id="">
                        @foreach ($municipios as $municipio )
                        <option value="{{ $municipio->id }}">{{$municipio->nombre}}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <button type="submit">Guardar</button>
                    <a href="{{ route('barrio.index') }}">Cancelar</a>
                </div>

            </form>
        </div>
    </div>


</x-card>

@endsection