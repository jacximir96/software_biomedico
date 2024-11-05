@foreach ($administradores as $element)
@if ($_COOKIE["email_login"] == $element->email)
@extends('plantilla')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<main>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Orden de servicios
            </h2>

            <nav>
                <ol class="flex items-center gap-2">
                    <li>
                        <a class="font-medium" href="{{ url("/") }}">Inicio /</a>
                    </li>
                    <li class="font-medium text-primary">Orden de servicios</li>
                </ol>
            </nav>
        </div>

        <div class="rounded-lg shadow-md border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark mb-4">
            <div class="flex flex-wrap justify-between items-center border-b p-4 px-4 py-6 md:px-6 xl:px-7.5">
                <div>
                    <h2 class="text-gray-700 text-xl font-bold text-black dark:text-white">Filtro de búsqueda</h2>
                </div>

                <div>
                    <button id="toggleFilterIcon" class="inline-flex items-center justify-center text-gray-700 dark:text-white text-xl font-bold">
                        <span id="filterIcon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                    </button>
                </div>
            </div>

            <div id="searchForm" class="hidden p-4 rounded-lg shadow-md border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <form id="searchFields">
                    <div class="flex flex-wrap gap-5.5">
                        <div class="w-full-mitad md:w-full">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                N° orden de servicio
                            </label>
                            <input type="text" id="numero_orden_servicio" placeholder="Buscar por número de orden" autofocus
                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                        </div>

                        <div class="w-full-mitad md:w-full">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                N° expediente
                            </label>
                            <input type="text" id="numero_expediente" placeholder="Buscar por número de expediente" autofocus
                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                        </div>

                        <div class="w-full-mitad md:w-full">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                Fecha
                            </label>
                            <input type="date" id="fecha" placeholder="Buscar por fecha" autofocus
                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="button" id="searchBtn" class="inline-flex items-center justify-center gap-2.5 rounded-md bg-success px-6 py-4 text-center font-medium 
                            text-white hover:bg-opacity-90 min-w-150">
                            Buscar
                        </button>

                        <button type="button" id="clearBtn" class="inline-flex items-center justify-center gap-2.5 rounded-md bg-secondary px-6 py-4 text-center font-medium 
                            text-white hover:bg-opacity-90 min-w-150">
                            Limpiar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="rounded-lg shadow-md border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="flex flex-wrap justify-between items-center p-4 border-b px-4 py-6 md:px-6 xl:px-7.5">
                <div>
                    <h2 class="text-gray-700 text-xl font-bold text-black dark:text-white">Lista de registros</h2>
                </div>

                <div id="asignar-botones">
                    <button data-modal-target="crearModal" class="open-modal-btn inline-flex items-center justify-center gap-2.5 rounded-md bg-primary px-6 py-4 text-center font-medium 
                            text-white hover:bg-opacity-90 min-w-150 ml-333 button-general">
                        Añadir
                    </button>

                    <div id="crearModal" class="modal fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-999999">
                        <div class="modal-content bg-white rounded-lg shadow-lg min-w-300 w-70-1 max-w-screen-2xl dark:border-strokedark dark:bg-boxdark">

                            <form method="POST" action="{{ url('/') }}/ordenServicios" enctype="multipart/form-data">
                                @csrf
                                <div class="flex justify-between items-center p-4 border-b border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Crear orden de servicio</h3>
                                    <button class="close-modal-btn text-gray-500 hover:text-gray-700">&times;</button>
                                </div>

                                <div class="flex flex-wrap gap-5.5 p-6.5">
                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            N° orden
                                        </label>
                                        <input type="text" placeholder="Ingrese el número de orden" name="codigo_ordenServicio" value="{{ old("codigo_ordenServicio") }}" required autofocus
                                            class="inputRutaMonto w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            N° expediente
                                        </label>
                                        <input type="text" placeholder="Ingrese el número de expediente" name="expediente_ordenServicio" value="{{ old("expediente_ordenServicio") }}" required autofocus
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Fecha
                                        </label>
                                        <input type="date" placeholder="Ingrese la fecha de la orden de servicio" name="fecha_ordenServicio" value="{{ old("fecha_ordenServicio") }}" required autofocus
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Monto
                                        </label>
                                        <input type="text" placeholder="Ingrese el monto total" name="monto_ordenServicio" value="{{ old("monto_ordenServicio") }}" required autofocus
                                            class="inputRutaMonto w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <hr class="pb-2">

                                    <div class="w-full" style="text-align:center;">
                                        <div class="btn btn-default btn-file">
                                            <i class="fas fa-paperclip"></i> Adjuntar archivo
                                            <input type="file" name="pdf_archivo" id="pdf_ordenServicio">
                                        </div><br>

                                        <p class="help-block small" style="margin-top:15px;">Tamaño máximo de archivos: 20MB</p>
                                    </div>
                                </div>

                                <div class="flex justify-end p-4 border-t border-gray-200">
                                    <div class="mr-3">
                                        <button type="submit" class="inline-flex items-center justify-center gap-2.5 rounded-md bg-primary px-6 py-4 text-center font-medium 
                                                text-white hover:bg-opacity-90 min-w-150">
                                            Guardar
                                        </button>
                                    </div>

                                    <div>
                                        <button type="button" class="close-modal-btn inline-flex items-center justify-center gap-2.5 rounded-md bg-danger px-6 py-4 text-center font-medium
                                                text-white hover:bg-opacity-90 min-w-150">
                                            Cerrar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div id="editarModal" class="modal fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-999999">
                        <div class="modal-content bg-white rounded-lg shadow-lg min-w-300 w-70-1 max-w-screen-2xl dark:border-strokedark dark:bg-boxdark">
                            <form id="editForm" method="POST" action="{{ url('/') }}/ordenServicios" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="flex justify-between items-center p-4 border-b border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Editar orden de servicio</h3>
                                    <button type="button" class="close-modal-btn text-gray-500 hover:text-gray-700">&times;</button>
                                </div>

                                <div class="flex flex-wrap gap-5.5 p-6.5">
                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            N° orden
                                        </label>
                                        <input type="text" placeholder="Ingrese el número de orden" name="codigo_ordenServicio" id="codigo_ordenServicio" value="{{ old("codigo_ordenServicio") }}" required autofocus
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            N° expediente
                                        </label>
                                        <input type="text" placeholder="Ingrese el número de expediente" name="expediente_ordenServicio" id="expediente_ordenServicio" value="{{ old("expediente_ordenServicio") }}" required autofocus
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Fecha
                                        </label>
                                        <input type="date" placeholder="Ingrese la fecha de la orden de servicio" name="fecha_ordenServicio" id="fecha_ordenServicio" value="{{ old("fecha_ordenServicio") }}" required autofocus
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Monto
                                        </label>
                                        <input type="text" placeholder="Ingrese el monto total" name="monto_ordenServicio" id="monto_ordenServicio" value="{{ old("monto_ordenServicio") }}" required autofocus
                                            class="inputRutaMonto w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <hr class="pb-2">

                                    <div class="w-full" style="text-align:center;">
                                        <div class="btn btn-default btn-file">
                                            <i class="fas fa-paperclip"></i> Adjuntar archivo
                                            <input type="file" name="pdf_archivo_editar" id="pdf_ordenServicio_editar">
                                        </div><br>

                                        <p class="help-block small" style="margin-top:15px;">Tamaño máximo de archivos: 20MB</p>
                                        <input type="hidden" class="form-control" name="pdf_archivo_editar_actual" id="pdf_archivo_editar_actual"
                                        required autofocus style="text-transform: uppercase;">
                                        <p id="file-name" style="margin-top:15px;"></p>
                                    </div>
                                </div>

                                <div class="flex justify-end p-4 border-t border-gray-200">
                                    <div class="mr-3">
                                        <button type="submit" class="inline-flex items-center justify-center gap-2.5 rounded-md bg-primary px-6 py-4 text-center font-medium 
                                                text-white hover:bg-opacity-90 min-w-150">
                                            Guardar
                                        </button>
                                    </div>
                                    <div>
                                        <button type="button" class="close-modal-btn inline-flex items-center justify-center gap-2.5 rounded-md bg-danger px-6 py-4 text-center font-medium 
                                                text-white hover:bg-opacity-90 min-w-150">
                                            Cerrar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="data-table-common data-table-two max-w-full overflow-x-auto">
                    <div class="datatable-wrapper datatable-loading no-footer searchable fixed-columns">
                        <div class="datatable-top">
                            <div class="datatable-dropdown">
                                <label>
                                    <select class="datatable-selector">
                                        <option value="5">5</option>
                                        <option value="10" selected="">10</option>
                                        <option value="15">15</option>
                                        <option value="-1">All</option>
                                    </select> entradas por página
                                </label>
                            </div>
                            <div class="datatable-search">
                                <input class="datatable-input" placeholder="Escribe para buscar" type="search" title="Search within table" aria-controls="tablaOrdenServicios">
                            </div>
                        </div>
                        <div class="datatable-container">
                            <table class="table w-full table-auto datatable-table" id="tablaOrdenServicios">
                                <thead>
                                    <tr>
                                        <th style="width: 21.379310344827587%;">
                                            <a href="#">
                                                <div class="flex items-center justify-between gap-1.5">
                                                    <p>#</p>
                                                    <div class="inline-flex flex-col space-y-[2px]">
                                                        <span class="inline-block">
                                                            <svg class="fill-current" width="10" height="5" viewBox="0 0 10 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                             <path d="M5 0L0 5H10L5 0Z" fill=""></path>
                                                            </svg>
                                                        </span>
                                                        <span class="inline-block">
                                                            <svg class="fill-current" width="10" height="5" viewBox="0 0 10 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M5 5L10 0L-4.37114e-07 8.74228e-07L5 5Z" fill=""></path>
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </div>
                                            </a>
                                        </th>
                                        <th style="width: 26.89655172413793%;">
                                            <a href="#">
                                                <div class="flex items-center justify-between gap-1.5">
                                                    <p>N° Orden de Servicio</p>
                                                    <div class="inline-flex flex-col space-y-[2px]">
                                                        <span class="inline-block">
                                                            <svg class="fill-current" width="10" height="5" viewBox="0 0 10 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M5 0L0 5H10L5 0Z" fill=""></path>
                                                            </svg>
                                                        </span>
                                                        <span class="inline-block">
                                                            <svg class="fill-current" width="10" height="5" viewBox="0 0 10 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M5 5L10 0L-4.37114e-07 8.74228e-07L5 5Z" fill=""></path>
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </div>
                                            </a>
                                        </th>
                                        <th style="width: 7.931034482758621%;">
                                            <a href="#">
                                                <div class="flex items-center justify-between gap-1.5">
                                                    <p>N° Expediente</p>
                                                    <div class="inline-flex flex-col space-y-[2px]">
                                                        <span class="inline-block">
                                                            <svg class="fill-current" width="10" height="5" viewBox="0 0 10 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M5 0L0 5H10L5 0Z" fill=""></path>
                                                            </svg>
                                                        </span>
                                                        <span class="inline-block">
                                                            <svg class="fill-current" width="10" height="5" viewBox="0 0 10 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M5 5L10 0L-4.37114e-07 8.74228e-07L5 5Z" fill=""></path>
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </div>
                                            </a>
                                        </th>
                                        <th style="width: 26.89655172413793%;">
                                            <a href="#">
                                                <div class="flex items-center justify-between gap-1.5">
                                                    <p>Fecha</p>
                                                    <div class="inline-flex flex-col space-y-[2px]">
                                                        <span class="inline-block">
                                                            <svg class="fill-current" width="10" height="5" viewBox="0 0 10 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M5 0L0 5H10L5 0Z" fill=""></path>
                                                            </svg>
                                                        </span>
                                                        <span class="inline-block">
                                                            <svg class="fill-current" width="10" height="5" viewBox="0 0 10 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M5 5L10 0L-4.37114e-07 8.74228e-07L5 5Z" fill=""></path>
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </div>
                                            </a>
                                        </th>
                                        <th style="width: 7.931034482758621%;">
                                            <a href="#">
                                                <div class="flex items-center justify-between gap-1.5">
                                                    <p>Monto</p>
                                                    <div class="inline-flex flex-col space-y-[2px]">
                                                        <span class="inline-block">
                                                            <svg class="fill-current" width="10" height="5" viewBox="0 0 10 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M5 0L0 5H10L5 0Z" fill=""></path>
                                                            </svg>
                                                        </span>
                                                        <span class="inline-block">
                                                            <svg class="fill-current" width="10" height="5" viewBox="0 0 10 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M5 5L10 0L-4.37114e-07 8.74228e-07L5 5Z" fill=""></path>
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </div>
                                            </a>
                                        </th>
                                        <th style="width: 7.931034482758621%;">
                                            <a href="#">
                                                <div class="flex items-center justify-between gap-1.5">
                                                    <p>Orden de Servicio</p>
                                                    <div class="inline-flex flex-col space-y-[2px]">
                                                        <span class="inline-block">
                                                            <svg class="fill-current" width="10" height="5" viewBox="0 0 10 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M5 0L0 5H10L5 0Z" fill=""></path>
                                                            </svg>
                                                        </span>
                                                        <span class="inline-block">
                                                            <svg class="fill-current" width="10" height="5" viewBox="0 0 10 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M5 5L10 0L-4.37114e-07 8.74228e-07L5 5Z" fill=""></path>
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </div>
                                            </a>
                                        </th>
                                        <th class="red" style="width: 13.908045977011493%;">
                                            <a href="#">
                                                <div class="flex items-center justify-between gap-1.5">
                                                    <p>Acciones</p>
                                                    <div class="inline-flex flex-col space-y-[2px]">
                                                        <span class="inline-block">
                                                            <svg class="fill-current" width="10" height="5" viewBox="0 0 10 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M5 0L0 5H10L5 0Z" fill=""></path>
                                                            </svg>
                                                        </span>
                                                        <span class="inline-block">
                                                            <svg class="fill-current" width="10" height="5" viewBox="0 0 10 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M5 5L10 0L-4.37114e-07 8.74228e-07L5 5Z" fill=""></path>
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </div>
                                            </a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="datatable-bottom">
                            <div class="datatable-info" id="datatable-info">Showing 1 to 10 of 26 entries</div>
                            <nav class="datatable-pagination">
                                <ul class="datatable-pagination-list"></ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    document.querySelectorAll('.open-modal-btn').forEach(button => {
        button.addEventListener('click', () => {
            const target = button.getAttribute('data-modal-target');
            const modal = document.getElementById(target);
            modal.classList.remove('hidden');
            document.body.classList.add('modal-open');
        });
    });

    document.querySelectorAll('.close-modal-btn').forEach(button => {
        button.addEventListener('click', () => {
            const modal = button.closest('.modal');
            modal.classList.add('hidden');
            document.body.classList.remove('modal-open');
        });
    });
</script>

<script>
    $(document).ready(function() {
        var table = $('#tablaOrdenServicios').DataTable();

        $('#searchBtn').on('click', function() {
            var numero_orden_servicio = $('#numero_orden_servicio').val();
            var numero_expediente = $('#numero_expediente').val().toLowerCase();
            var fecha = $('#fecha').val();

            table.column(1).search(numero_orden_servicio);
            table.column(2).search(numero_expediente);
            table.column(3).search(fecha);
            table.draw();
        });

        $('#clearBtn').on('click', function() {
            $('#numero_orden_servicio').val('');
            $('#numero_expediente').val('');
            $('#fecha').val('');

            table.columns().search('').draw();
        });
    });
</script>

<script>
    document.getElementById('toggleFilterIcon').addEventListener('click', function() {
        var searchForm = document.getElementById('searchForm');
        var filterIcon = document.getElementById('filterIcon');

        if (searchForm.classList.contains('hidden')) {
            searchForm.classList.remove('hidden');
            filterIcon.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                </svg>`;
        } else {
            searchForm.classList.add('hidden');
            filterIcon.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>`;
        }
    });
</script>

<script>
    document.getElementById('clearBtn').addEventListener('click', function() {
        document.getElementById('numero_orden_servicio').value = '';
        document.getElementById('numero_expediente').value = '';
        document.getElementById('fecha').value = '';
        var table = $('#tablaOrdenServicios').DataTable();
        table.search('').columns().search('').draw();
    });
</script>

@if (Session::has("ok-crear"))
    <script>
        notie.alert({type:1,text:'!La orden de Servicio ha sido creado correctamente', time:10})
    </script>
@endif

@if (Session::has("orden-existe"))
    <script>
        notie.alert({type:2,text:'!La orden de Servicio ya existe en nuestros registros', time:10})
    </script>
@endif

@if (Session::has("no-validacion"))
    <script>
        notie.alert({type:2,text:'!Hay campos no válidos en el formulario', time:10})
    </script>
@endif

@if (Session::has("error"))
    <script>
        notie.alert({type:3,text:'!Error en el gestor de orden de Servicio', time:10})
    </script>
@endif

@if (Session::has("ok-editar"))
    <script>
        notie.alert({type:1,text:'!La orden de Servicio ha sido actualizado correctamente', time:10})
    </script>
@endif

@if (Session::has("ok-eliminar"))
    <script>
        notie.alert({ type: 1, text: '¡La orden de Servicio ha sido eliminado correctamente!', time: 10 })
    </script>
@endif

@if (Session::has("no-borrar"))
    <script>
        notie.alert({ type: 2, text: '¡Este administrador no se puede borrar!', time: 10 })
    </script>
@endif

@if (Session::has("no-pdf"))
    <script>
        notie.alert({ type: 2, text: '¡El archivo PDF es requerido!', time: 10 })
    </script>
@endif

@endsection

@section('javascript')
<script src="{{ url('/') }}/js/ordenServicios.js"></script>
@endsection

@endif
@endforeach
