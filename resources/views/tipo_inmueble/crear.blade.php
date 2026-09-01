@extends('layouts.app')


@section('title')
    TITULO
@endsection


@section('content')


<x-card>

    <div>
        <div>
            <h2>Nuevo tipo de inmueble</h2>
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
            <form action="{{ route('tipo_inmueble.store') }}"method="post">
                @csrf
                <div>
                    <label for="" class="block mb-2 font-semibold">Tipo de inmueble</label>
                    <input type="text" name="nombre" class="w-full border rounded px-3 py-2">
                </div>


                <div>
                    <button type="submit">Guardar</button>
                    <a href="{{ route('tipo_inmueble.index') }}">Cancelar</a>
                </div>

            </form>
        </div>
    </div>


</x-card>

@endsection