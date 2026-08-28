@extends('layouts.app')


@section('title')
    TITULO
@endsection


@section('content')


<x-card>

    <div>
        <div>
            <h2>Nuevo municipio</h2>
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
            <form action="{{ route('municipio.store') }}"method="post">
                @csrf
                <div>
                    <label for="" class="block mb-2 font-semibold">Nombre municipio</label>
                    <input type="text" name="nombre" class="w-full border rounded px-3 py-2">
                </div>

                <div>
                    <label for="" class="block mb-2 font-semibold">Codigo postal </label>
                    <input type="text" name="codigo_postal" class="w-full border rounded px-3 py-2">
                </div>

                <div>
                    <button type="submit">Guardar</button>
                </div>

            </form>
        </div>
    </div>


</x-card>

@endsection