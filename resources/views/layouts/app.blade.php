<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - {{ config('app.name', 'Admin') }}</title>
    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eef2ff', 100: '#e0e7ff', 200: '#c7d2fe', 300: '#a5b4fc',
                            400: '#818cf8', 500: '#6366f1', 600: '#4f46e5', 700: '#4338ca',
                            800: '#3730a3', 900: '#312e81'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Chart.js (solo se usa donde se necesita) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js" defer></script>

    {{-- DataTables CSS CDN --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }

        /* Estilos Dashboard para DataTables */
        .dt-container { width: 100% !important; max-width: 100% !important; font-size: 0.8125rem; }
        .dt-container .dt-layout-row:first-child,
        .dt-container .dt-layout-row:has(.dt-search) {
            display: flex; flex-direction: column; gap: 0.75rem; padding-bottom: 1rem;
        }
        @media (min-width: 640px) {
            .dt-container .dt-layout-row:first-child,
            .dt-container .dt-layout-row:has(.dt-search) {
                flex-direction: row; align-items: center; justify-content: space-between;
            }
        }
        .dt-container .dt-layout-row:last-child,
        .dt-container .dt-layout-row:has(.dt-paging) {
            display: flex; flex-direction: column; gap: 0.75rem; padding-top: 1rem; border-top: 1px solid #f1f5f9;
        }
        @media (min-width: 640px) {
            .dt-container .dt-layout-row:last-child,
            .dt-container .dt-layout-row:has(.dt-paging) {
                flex-direction: row; align-items: center; justify-content: space-between;
            }
        }
        .dt-container .dt-search, .dt-container .dt-length {
            display: flex; align-items: center; gap: 0.5rem; font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;
        }
        .dt-container .dt-search input {
            border-radius: 0.75rem; border: 1px solid #e2e8f0; background-color: #f8fafc; padding: 0.5rem 0.875rem; font-size: 0.75rem; font-weight: 600; color: #1e293b; outline: none; transition: all 0.2s;
        }
        .dt-container .dt-search input:focus {
            background-color: #ffffff; border-color: #2563eb; box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.15);
        }
        .dt-container .dt-length select {
            border-radius: 0.75rem; border: 1px solid #e2e8f0; background-color: #f8fafc; padding: 0.4rem 0.75rem; font-size: 0.75rem; font-weight: 700; color: #334155; outline: none; cursor: pointer;
        }
        .dt-container table.dataTable {
            width: 100% !important; border-collapse: collapse; border: 1px solid #f1f5f9; border-radius: 1rem;
        }
        .dt-container table.dataTable thead th {
            background-color: #f8fafc; padding: 0.875rem 1rem; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #e2e8f0;
        }
        .dt-container table.dataTable tbody td {
            padding: 0.875rem 1rem; border-bottom: 1px solid #f8fafc; vertical-align: middle;
        }
        .dt-container table.dataTable tbody tr:hover { background-color: #f8fafc; }
        .dt-container .dt-info { font-size: 0.75rem; font-weight: 600; color: #94a3b8; }
        .dt-container .dt-paging { display: flex; align-items: center; gap: 0.25rem; }
        .dt-container .dt-paging .dt-paging-button {
            display: inline-flex; align-items: center; justify-content: center; min-width: 2rem; height: 2rem; border-radius: 0.625rem; border: 1px solid #e2e8f0; background: #ffffff; font-size: 0.75rem; font-weight: 700; color: #475569; padding: 0 0.5rem; transition: all 0.15s; cursor: pointer;
        }
        .dt-container .dt-paging .dt-paging-button:hover:not(.current):not(.disabled) { background: #f1f5f9; color: #0f172a; }
        .dt-container .dt-paging .dt-paging-button.current {
            background: #2563eb !important; border-color: #2563eb !important; color: #ffffff !important; font-weight: 800;
        }
        .dt-container .dt-paging .dt-paging-button.disabled { opacity: 0.35; cursor: not-allowed; }

        /* Ocultar flechas de ordenamiento de DataTables */
        .dt-container table.dataTable thead th::before,
        .dt-container table.dataTable thead th::after,
        .dt-container table.dataTable thead th .dt-column-order,
        .dt-container table.dataTable thead th span.dt-column-order,
        table.dataTable thead th .dt-column-order,
        table.dataTable thead th::before,
        table.dataTable thead th::after {
            display: none !important;
            content: "" !important;
            opacity: 0 !important;
            visibility: hidden !important;
        }
    </style>

    @stack('styles')
</head>
<body class="h-full text-slate-800 antialiased">

    <div x-data="{ sidebarOpen: false }" class="min-h-screen flex">

        {{-- Overlay móvil --}}
        <div
            x-show="sidebarOpen"
            x-cloak
            @click="sidebarOpen = false"
            class="fixed inset-0 z-30 bg-slate-900/50 lg:hidden"
            aria-hidden="true"
        ></div>

        @include('layouts.partials.sidebar')

        <div class="flex-1 flex flex-col min-w-0 lg:pl-64">
            @include('layouts.partials.navbar')

            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                @if (session('success'))
                    <x-alert type="success" class="mb-6">{{ session('success') }}</x-alert>
                @endif
                @if (session('error'))
                    <x-alert type="error" class="mb-6">{{ session('error') }}</x-alert>
                @endif

                @yield('content')
            </main>

            @include('layouts.partials.footer')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js" defer></script>

    {{-- jQuery CDN (Requerido por DataTables) --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    {{-- DataTables JS CDN e inicialización automática --}}
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.datatable').each(function () {
                if ($.fn.DataTable.isDataTable(this)) return;

                $(this).DataTable({
                    pageLength: 10,
                    lengthMenu: [5, 10, 25, 50, 100],
                    searching: true,
                    ordering: false,
                    paging: true,
                    info: true,
                    autoWidth: false,
                    language: {
                        emptyTable: 'No hay registros disponibles',
                        info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
                        infoEmpty: 'Mostrando 0 a 0 de 0 registros',
                        infoFiltered: '(filtrado de _MAX_ registros totales)',
                        lengthMenu: 'Mostrar _MENU_ registros',
                        loadingRecords: 'Cargando...',
                        processing: 'Procesando...',
                        search: 'Buscar:',
                        zeroRecords: 'No se encontraron resultados coincidentes',
                        paginate: {
                            first: '«',
                            last: '»',
                            next: '›',
                            previous: '‹',
                        },
                    },
                    initComplete: function () {
                        $(this).addClass('dt-inicializada');
                    },
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
