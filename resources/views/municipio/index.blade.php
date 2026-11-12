@extends('layouts.app')

@section('title', 'Municipios')
@section('page-title', 'Municipios')

@section('content')
<div class="space-y-6">

    {{-- Encabezado Superior --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white border border-slate-200/90 rounded-3xl p-5 sm:p-6 shadow-xs">
        <div>
            <div class="flex items-center gap-2">
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Listado de Municipios</h1>
                <span class="text-xs font-bold px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 border border-blue-200/80">
                    {{ count($municipio) }} registrados
                </span>
            </div>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Administra los municipios y códigos postales de la provincia de García Rovira.
            </p>
        </div>

        <a href="{{ route('municipio.create') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-4 py-3 rounded-2xl shadow-md shadow-blue-600/30 transition transform hover:-translate-y-0.5 cursor-pointer shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            <span>Nuevo Municipio</span>
        </a>
    </div>

    {{-- Tarjeta de la Tabla con DataTables --}}
    <div class="bg-white border border-slate-200/90 rounded-3xl p-5 sm:p-6 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="datatable w-full text-left text-xs">
                <thead>
                    <tr>
                        <th class="px-4 py-3.5">ID</th>
                        <th class="px-4 py-3.5">Municipio</th>
                        <th class="px-4 py-3.5">Código Postal</th>
                        <th class="px-4 py-3.5 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($municipio as $item)
                        <tr>
                            <td class="px-4 py-3.5 text-slate-400 font-bold">#{{ $item->id }}</td>
                            <td class="px-4 py-3.5 font-bold text-slate-900 text-sm">{{ $item->nombre }}</td>
                            <td class="px-4 py-3.5">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200/80">
                                    {{ $item->codigo_postal ?: 'Sin código' }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-right">
                                <div class="inline-flex items-center gap-1.5 justify-end">
                                    {{-- Editar --}}
                                    <a href="{{ route('municipio.edit', $item->id) }}"
                                       class="p-2 rounded-xl text-slate-500 hover:text-amber-600 hover:bg-amber-50 border border-slate-200/80 transition cursor-pointer"
                                       title="Editar municipio">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>

                                    {{-- Eliminar --}}
                                    <form action="{{ route('municipio.destroy', $item->id) }}" method="POST"
                                          onsubmit="return confirm('¿Seguro que deseas eliminar este municipio?')"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="p-2 rounded-xl text-slate-500 hover:text-rose-600 hover:bg-rose-50 border border-slate-200/80 transition cursor-pointer"
                                                title="Eliminar municipio">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
