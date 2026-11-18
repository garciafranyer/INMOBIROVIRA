@extends('layouts.app')

@section('title', 'Usuarios')
@section('page-title', 'Usuarios')

@section('content')
<div class="space-y-6">

    {{-- Encabezado Superior --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white border border-slate-200/90 rounded-3xl p-5 sm:p-6 shadow-xs">
        <div>
            <div class="flex items-center gap-2">
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Listado de Usuarios</h1>
                <span class="text-xs font-bold px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 border border-blue-200/80">
                    {{ count($usuario) }} registrados
                </span>
            </div>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Consulta las cuentas registradas en la plataforma. Para crear, editar o eliminar usuarios ve a <strong>Seguridad &rsaquo; Cuentas de usuario</strong>.
            </p>
        </div>

        @if (Route::has('seguridad.cuentas.create'))
            @can(config('seguridad.permiso_admin'))
                <a href="{{ route('seguridad.cuentas.create') }}"
                   class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-4 py-3 rounded-2xl shadow-md shadow-blue-600/30 transition transform hover:-translate-y-0.5 cursor-pointer shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                    <span>Crear desde Seguridad</span>
                </a>
            @endcan
        @endif
    </div>

    {{-- Tarjeta de la Tabla con DataTables --}}
    <div class="bg-white border border-slate-200/90 rounded-3xl p-5 sm:p-6 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="datatable w-full text-left text-xs">
                <thead>
                    <tr>
                        <th class="px-4 py-3.5">ID</th>
                        <th class="px-4 py-3.5">Usuario</th>
                        <th class="px-4 py-3.5">Correo Electrónico</th>
                        <th class="px-4 py-3.5">Teléfono / WhatsApp</th>
                        <th class="px-4 py-3.5">Dirección</th>
                        <th class="px-4 py-3.5">Rol / Tipo</th>
                        <th class="px-4 py-3.5 text-right">Registrado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuario as $item)
                        <tr>
                            <td class="px-4 py-3.5 text-slate-400 font-bold">#{{ $item->id }}</td>
                            <td class="px-4 py-3.5 font-bold text-slate-900 text-sm">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 border border-slate-200/80 flex items-center justify-center text-slate-700 font-black text-xs shrink-0">
                                        {{ strtoupper(substr($item->nombre, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-bold text-slate-900 truncate">{{ $item->nombre }}</div>
                                        @if(!empty($item->nombre_empresa) && $item->nombre_empresa !== $item->nombre)
                                            <div class="text-[11px] text-slate-400 font-normal truncate">{{ $item->nombre_empresa }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3.5">
                                <span class="text-slate-600 font-medium">{{ $item->email ?? $item->gmail }}</span>
                            </td>
                            <td class="px-4 py-3.5">
                                @if(!empty($item->telefono))
                                    <span class="inline-flex items-center gap-1.5 text-slate-700 font-medium">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                        {{ $item->telefono }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic">Sin teléfono</span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 text-slate-600">
                                {{ $item->direccion ?: 'Sin dirección' }}
                            </td>
                            <td class="px-4 py-3.5">
                                @php
                                    $rolNombre = $item->roles->first()?->name ?? $item->tipo_usuario ?? 'usuario';
                                @endphp
                                @if($rolNombre === 'administrador')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-xs font-bold bg-purple-50 text-purple-700 border border-purple-200/80">
                                        Administrador
                                    </span>
                                @elseif($rolNombre === 'empresa' || $rolNombre === 'inmobiliaria')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/80">
                                        Empresa
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200/80">
                                        {{ ucfirst($rolNombre) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 text-right text-slate-500 font-medium whitespace-nowrap">
                                {{ $item->created_at ? $item->created_at->format('d/m/Y') : '—' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection