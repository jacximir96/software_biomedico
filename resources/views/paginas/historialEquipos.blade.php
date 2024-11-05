@foreach ($administradores as $element)
@if ($_COOKIE["email_login"] == $element->email)
@extends('plantilla')
@section('content')

<main>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Historial de equipos
            </h2>

            <nav>
                <ol class="flex items-center gap-2">
                    <li>
                        <a class="font-medium" href="{{ url("/") }}">Inicio /</a>
                    </li>
                    <li class="font-medium text-primary">Historial de equipos</li>
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
                                Equipo
                            </label>
                            <input type="text" id="nombre_equipo" placeholder="Buscar por equipo" autofocus
                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                        </div>

                        <div class="w-full-mitad md:w-full">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                Marca
                            </label>
                            <input type="text" id="marca_equipo" placeholder="Buscar por marca" autofocus
                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                        </div>

                        <div class="w-full-mitad md:w-full">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                Modelo
                            </label>
                            <input type="text" id="modelo_equipo" placeholder="Buscar por modelo" autofocus
                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                        </div>

                        <div class="w-full-mitad md:w-full">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                Serie
                            </label>
                            <input type="text" id="serie_equipo" placeholder="Buscar por serie" autofocus
                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                        </div>

                        <div class="w-full-mitad md:w-full">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                Código patrimonial
                            </label>
                            <input type="text" id="codigo_patrimonial_equipo" placeholder="Buscar por código patrimonial" autofocus
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
                    <div id="editarModal" class="modal fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-999999">
                        <div class="modal-content bg-white rounded-lg shadow-lg min-w-300 w-70-1 max-w-screen-2xl dark:border-strokedark dark:bg-boxdark">
                            <form id="editForm" method="POST" action="{{ url('/') }}/historialEquipos" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="flex justify-between items-center p-4 border-b border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Historial</h3>
                                    <button type="button" class="close-modal-btn text-gray-500 hover:text-gray-700">&times;</button>
                                </div>

                                <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                                    <div class="data-table-common data-table-two max-w-full overflow-x-auto">
                                        <div class="datatable-wrapper datatable-loading no-footer searchable fixed-columns">
                                            <div class="datatable-container">
                                                <table class="table table-bordered table-striped dt-responsive w-full" id="historialCompra2" style="border-bottom: 1px solid;">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2" class="text-center">Información del Equipo</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <input type="text" style="display:none" name="id_equipoHistorial" id="id_equipoHistorial">
                                                    </tbody>
                                                </table>

                                                <table class="table w-full table-auto datatable-table mt-4" id="historialCompra1">
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
                                                                        <p>Tipo</p>
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
                                                            <th style="width: 26.89655172413793%;">
                                                                <a href="#">
                                                                    <div class="flex items-center justify-between gap-1.5">
                                                                        <p>N° ODS/OTM</p>
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
                                                                        <p>Estado</p>
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
                                                                        <p>Conformidad</p>
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
                                        </div>

                                        <div class="flex justify-end p-4 border-t border-gray-200">
                                            <div class="mr-3">
                                                <a href="" target="_blank" id="historialServicioImprimir" class="inline-flex items-center justify-center gap-2.5 rounded-md bg-primary px-6 py-4 text-center font-medium 
                                                        text-white hover:bg-opacity-90 min-w-150">
                                                    Imprimir
                                                </a>
                                            </div>
                                            <div>
                                                <button type="button" class="close-modal-btn inline-flex items-center justify-center gap-2.5 rounded-md bg-danger px-6 py-4 text-center font-medium 
                                                        text-white hover:bg-opacity-90 min-w-150">
                                                    Cerrar
                                                </button>
                                            </div>
                                        </div>
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
                                <input class="datatable-input" placeholder="Escribe para buscar" type="search" title="Search within table" aria-controls="tablaHistorialEquipos">
                            </div>
                        </div>
                        <div class="datatable-container">
                            <table class="table w-full table-auto datatable-table" id="tablaHistorialEquipos">
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
                                                    <p>Equipo</p>
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
                                                    <p>Marca</p>
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
                                                    <p>Modelo</p>
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
                                                    <p>Serie</p>
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
                                                    <p>Código patrimonial</p>
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
        var table = $('#tablaHistorialEquipos').DataTable();

        $('#searchBtn').on('click', function() {
            var nombre_equipo = $('#nombre_equipo').val().toLowerCase();
            var marca_equipo = $('#marca_equipo').val().toLowerCase();
            var modelo_equipo = $('#modelo_equipo').val().toLowerCase();
            var serie_equipo = $('#serie_equipo').val().toLowerCase();
            var codigo_patrimonial_equipo = $('#codigo_patrimonial_equipo').val().toLowerCase();

            table.column(1).search(nombre_equipo);
            table.column(2).search(marca_equipo);
            table.column(3).search(modelo_equipo);
            table.column(4).search(serie_equipo);
            table.column(5).search(codigo_patrimonial_equipo);
            table.draw();
        });

        $('#clearBtn').on('click', function() {
            $('#nombre_equipo').val('');
            $('#marca_equipo').val('');
            $('#modelo_equipo').val('');
            $('#serie_equipo').val('');
            $('#codigo_patrimonial_equipo').val('');

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
        document.getElementById('nombre_equipo').value = '';
        document.getElementById('marca_equipo').value = '';
        document.getElementById('modelo_equipo').value = '';
        document.getElementById('serie_equipo').value = '';
        document.getElementById('codigo_patrimonial_equipo').value = '';
        var table = $('#tablaHistorialEquipos').DataTable();
        table.search('').columns().search('').draw();
    });
</script>

@if (Session::has("ok-crear"))
    <script>
        notie.alert({type:1,text:'!El equipo médico ha sido creado correctamente', time:10})
    </script>
@endif

@if (Session::has("no-validacion"))
    <script>
        notie.alert({type:2,text:'!Hay campos no válidos en el formulario', time:10})
    </script>
@endif

@if (Session::has("error"))
    <script>
        notie.alert({type:3,text:'!Error en el gestor de equipos médicos', time:10})
    </script>
@endif

@if (Session::has("ok-editar"))
    <script>
        notie.alert({type:1,text:'!El equipo médico ha sido actualizado correctamente', time:10})
    </script>
@endif

@if (Session::has("ok-eliminar"))
    <script>
        notie.alert({ type: 1, text: '¡El equipo médico ha sido eliminado correctamente!', time: 10 })
    </script>
@endif

@if (Session::has("no-borrar"))
    <script>
        notie.alert({ type: 2, text: '¡Este administrador no se puede borrar!', time: 10 })
    </script>
@endif

@endsection

@section('javascript')
<script src="{{ url('/') }}/js/historialEquipos.js"></script>
@endsection

@endif

@endforeach
