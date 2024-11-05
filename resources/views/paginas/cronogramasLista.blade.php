@foreach ($administradores as $element)
@if ($_COOKIE["email_login"] == $element->email)
@extends('plantilla')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<main>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Mantenimiento de equipos
            </h2>

            <nav>
                <ol class="flex items-center gap-2">
                    <li>
                        <a class="font-medium" href="{{ url("/") }}">Inicio /</a>
                    </li>
                    <li class="font-medium text-primary">Mantenimiento de equipos</li>
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
                                Nombre
                            </label>
                            <input type="text" id="nombre" placeholder="Buscar por nombre" autofocus
                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                        </div>

                        <div class="w-full-mitad md:w-full">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                Código patrimonial
                            </label>
                            <input type="text" id="codigo_patrimonial" placeholder="Buscar por código patrimonial" autofocus
                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                        </div>

                        <div class="w-full-mitad md:w-full">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                Tipo mantenimiento
                            </label>
                            <div x-data="{ isOptionSelected: false }"
                                class="relative z-20 bg-white dark:bg-form-input">
                                <select
                                    class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                    id="mantenimiento">
                                    <option value="" class="text-body">Todos</option>
                                    @foreach ($tipoMantenimientos as $key => $value1)
                                        <option value="{{$value1->id_mantenimiento}}" class="text-body">{{$value1->nombre_mantenimiento}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="w-full-mitad md:w-full">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                Fecha inicio
                            </label>
                            <input type="date" id="fecha_inicial" placeholder="Buscar por fecha inicial" autofocus
                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                        </div>

                        <div class="w-full-mitad md:w-full">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                Fecha fin
                            </label>
                            <input type="date" id="fecha_final" placeholder="Buscar por fecha final" autofocus
                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                        </div>

                        <div class="w-full-mitad md:w-full">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                N° orden de servicio
                            </label>
                            <input type="text" id="numero_orden_servicio" placeholder="Buscar por número de orden" autofocus
                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                        </div>

                        <div class="w-full-mitad md:w-full">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                Empresa
                            </label>
                            <input type="text" id="empresa" placeholder="Buscar por RUC" autofocus
                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                        </div>

                        <div class="w-full-mitad md:w-full">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                Ambiente
                            </label>
                            <div x-data="{ isOptionSelected: false }"
                                class="relative z-20 bg-white dark:bg-form-input">
                                <select
                                    class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                    id="ambiente">
                                    <option value="" class="text-body">Todos</option>
                                    @foreach ($ambientes as $key => $value1)
                                        <option value="{{$value1->id_ambiente}}" class="text-body">{{$value1->nombre_ambiente}}</option>
                                    @endforeach
                                </select>
                            </div>
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

        <div class="rounded-lg shadow-md border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark mb-4">
            <div class="flex flex-wrap justify-between items-center border-b p-4 px-4 py-6 md:px-6 xl:px-7.5">
                <div>
                    <h2 class="text-gray-700 text-xl font-bold text-black dark:text-white">Registrar mantenimientos</h2>
                </div>

                <div>
                    <button id="toggleFilterIcon1" class="inline-flex items-center justify-center text-gray-700 dark:text-white text-xl font-bold">
                        <span id="filterIcon1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                    </button>
                </div>
            </div>

            <div id="listForm" class="hidden p-4 rounded-lg shadow-md border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="data-table-common data-table-two max-w-full overflow-x-auto">
                        <div class="datatable-wrapper datatable-loading no-footer searchable fixed-columns">
                            <div class="datatable-container">
                                <table class="table w-full table-auto datatable-table mt-4" id="historial">
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
                                                        <p>Codigo patrimonial</p>
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
                                                        <p>Tipo mantenimiento</p>
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
                                                        <p>Fecha inicial</p>
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
                                                        <p>Fecha final</p>
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
                        </div>
                    </div>
                </div>
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

                            <form method="POST" action="{{ url('/') }}/cronogramasLista">
                                @csrf
                                <div class="flex justify-between items-center p-4 border-b border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Crear cronograma de mantenimiento</h3>
                                    <button class="close-modal-btn text-gray-500 hover:text-gray-700">&times;</button>
                                </div>

                                <div class="flex flex-wrap gap-5.5 p-6.5">
                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Fecha inicial
                                        </label>
                                        <input type="date" placeholder="Ingrese la fecha inicial" name="fecha_actual" id="fecha_actual_calendario" value="{{ old("fecha_actual") }}" required autofocus
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Fecha final
                                        </label>
                                        <input type="date" placeholder="Ingrese la fecha final" name="fecha_final" id="fecha_final_calendario" value="{{ old("fecha_final") }}" required autofocus
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Equipo
                                        </label>
                                        <div x-data="{ isOptionSelected: false }"
                                            class="relative z-20 bg-white dark:bg-form-input">
                                            <select
                                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                                :class="isOptionSelected && 'text-black dark:text-white'"
                                                @change="isOptionSelected = true" name="id_equipo" id="nombres_equipo" required>
                                                <option value="">-- Seleccionar el equipo --</option>
                                                @foreach ($equipos as $key => $value)
                                                    <option value="{{$value->id_equipo}}" class="text-body">{{$value->nombre_equipo}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="w-full-mitad md:w-full" style="display:none;">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Realizado
                                        </label>
                                        <input type="text" placeholder="" name="realizado_crear" required autofocus value="0"
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Tipo de mantenimiento
                                        </label>
                                        <div x-data="{ isOptionSelected: false }"
                                            class="relative z-20 bg-white dark:bg-form-input">
                                            <select
                                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                                :class="isOptionSelected && 'text-black dark:text-white'"
                                                @change="isOptionSelected = true" name="id_mantenimiento" id="nombres_mantenimiento" required>
                                                <option value="">-- Seleccionar el tipo de mantenimiento --</option>
                                                @foreach ($tipoMantenimientos_estado as $key => $value)
                                                    <option value="{{$value->id_mantenimiento}}" class="text-body">{{$value->nombre_mantenimiento}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="w-full-mitad md:w-full" id="valor_garantia_div">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Garantia
                                        </label>
                                        <input type="text" placeholder="Ingrese la garantía (Meses)" name="garantia" autofocus maxlength="2" value="0"
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
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
                            <form id="editForm" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="flex justify-between items-center p-4 border-b border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Registrar Mantenimiento</h3>
                                    <button type="button" class="close-modal-btn text-gray-500 hover:text-gray-700">&times;</button>
                                </div>

                                <div class="flex flex-wrap gap-5.5 p-6.5">
                                    <input type="text" name="lista" value="1" hidden>
                                    <div class="w-full-mitad md:w-full" style="display:none;">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Mantenimiento
                                        </label>
                                        <input type="text" name="mantenimiento_oculto1" id="mantenimiento_oculto1" autofocus readonly=""
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Equipo
                                        </label>
                                        <input type="hidden" placeholder="Ingrese el equipo" name="cronograma_equipo" id="cronograma_equipo" value="{{ old("cronograma_equipo") }}" required autofocus
                                        class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                        <input type="text" placeholder="Ingrese el equipo" name="" id="nombre_equipo" value="{{ old("nombre_equipo") }}" required autofocus readonly=""
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Fecha inicial
                                        </label>
                                        <input type="text" placeholder="Ingrese el modelo" name="cronograma_fecha" id="cronograma_fecha" value="{{ old("cronograma_fecha") }}" required autofocus readonly=""
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Fecha final
                                        </label>
                                        <input type="text" placeholder="Ingrese el número de serie" name="cronograma_fecha_final" id="cronograma_fecha_final" value="{{ old("cronograma_fecha_final") }}" required autofocus readonly=""
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full" style="display:none;">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Fecha
                                        </label>
                                        <input type="text" placeholder="Ingrese el número de serie" name="cronograma_realizado" value="1" required autofocus
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full" id="proveedor_cronograma">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Empresa
                                        </label>
                                        <div x-data="{ isOptionSelected: false }"
                                            class="relative z-20 bg-white dark:bg-form-input">
                                            <select
                                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                                :class="isOptionSelected && 'text-black dark:text-white'"
                                                @change="isOptionSelected = true" name="id_proveedor" id="id_proveedor">
                                                <option value="">-- Seleccionar el proveedor --</option>
                                                @foreach ($proveedores as $key => $value)
                                                    <option value="{{$value->id_proveedor}}" class="text-body">{{$value->razonSocial_proveedor}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Solicitante por departamento
                                        </label>
                                        <div x-data="{ isOptionSelected: false }"
                                            class="relative z-20 bg-white dark:bg-form-input">
                                            <select
                                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                                :class="isOptionSelected && 'text-black dark:text-white'"
                                                @change="isOptionSelected = true" name="id_departamento" id="id_departamento">
                                                <option value="">-- Seleccionar el departamento --</option>
                                                @foreach ($departamentos as $key => $value)
                                                    <option value="{{$value->id_departamento}}" class="text-body">{{$value->nombre_departamento}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="w-full-mitad md:w-full" id="garantiaVer">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Garantía (Meses)
                                        </label>
                                        <input type="text" placeholder="Ingrese la fecha de adquisición" name="cronograma_garantia" id="cronograma_garantia" value="{{ old("fecha_adquisicion_equipo") }}" autofocus
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full" id="monto_cronograma">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Monto
                                        </label>
                                        <input type="text" placeholder="Ingrese el monto" name="monto_cronograma" id="monto_cronograma" autofocus
                                            class="inputRutaMonto w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" id="otm">N° OTM</label>
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" id="ods">N° ODS</label>
                                        <input type="text" placeholder="Ingrese el número de OTM o ODS" name="otm_cronograma" id="otm_cronograma" value="{{ old("otm_cronograma") }}" autofocus
                                            class="inputRutaMonto w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                        <div x-data="{ isOptionSelected: false }" id="orden_servicio_cronograma"
                                            class="relative z-20 bg-white dark:bg-form-input">
                                            <select
                                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                                :class="isOptionSelected && 'text-black dark:text-white'"
                                                @change="isOptionSelected = true" name="id_ordenServicio" id="id_ordenServicio">
                                                <option value="">-- Seleccionar la orden de servicio --</option>
                                                @foreach ($ordenServicios as $key => $value)
                                                    <option value="{{$value->id_ordenServicio}}" class="text-body">{{$value->codigo_ordenServicio}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="w-full md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Detalles del Servicio
                                        </label>
                                        <textarea name="cronograma_observacion" id="cronograma_observacion" value="{{ old("cronograma_observacion") }}" autofocus
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"></textarea>
                                    </div>

                                    <hr class="pb-2">

                                    <div class="w-full" style="text-align:center;">
                                        <div class="btn btn-default btn-file">
                                            <i class="fas fa-paperclip"></i> Adjuntar archivo
                                            <input type="file" name="pdf_archivo_final" id="pdf_archivo_final">
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

                    <!-- INICIO JACXIMIR -->
                    <div id="editarModalCronograma" class="modal fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-999999">
                        <div class="modal-content bg-white rounded-lg shadow-lg min-w-300 w-70-1 max-w-screen-2xl dark:border-strokedark dark:bg-boxdark">
                            <form id="editFormCronogramaList" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="flex justify-between items-center p-4 border-b border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Editar cronograma de mantenimiento</h3>
                                    <button type="button" class="close-modal-btn text-gray-500 hover:text-gray-700">&times;</button>
                                </div>

                                <div class="w-full-mitad md:w-full" style="display:none;">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Mantenimiento
                                        </label>
                                        <input type="text" name="mantenimiento_oculto2" id="mantenimiento_oculto2" autofocus readonly=""
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                <div class="flex flex-wrap gap-5.5 p-6.5">
                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Fecha inicial
                                        </label>
                                        <input type="date" placeholder="Ingrese la fecha inicial" name="fecha_actual" id="fecha_actual_editar" required autofocus
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Fecha final
                                        </label>
                                        <input type="date" placeholder="Ingrese la fecha final" name="fecha_final" id="fecha_final_editar" required autofocus
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Equipo
                                        </label>
                                        <div x-data="{ isOptionSelected: false }"
                                            class="relative z-20 bg-white dark:bg-form-input">
                                            <select
                                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                                :class="isOptionSelected && 'text-black dark:text-white'"
                                                @change="isOptionSelected = true" name="id_equipo" id="nombres_equipo_editar" required autofocus>
                                                @foreach ($equipos as $key => $value)
                                                    <option value="{{$value->id_equipo}}" class="text-body">{{$value->nombre_equipo}} - {{$value->cp_equipo}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="w-full-mitad md:w-full" style="display:none;">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Realizado
                                        </label>
                                        <input type="text" name="realizado_crear" required autofocus value="0" readonly=""
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full" style="display:none;">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Fecha
                                        </label>
                                        <input type="text" name="cronograma_realizado" value="1" required autofocus
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Tipo de mantenimiento
                                        </label>
                                        <div x-data="{ isOptionSelected: false }"
                                            class="relative z-20 bg-white dark:bg-form-input">
                                            <select
                                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                                :class="isOptionSelected && 'text-black dark:text-white'"
                                                @change="isOptionSelected = true" name="id_mantenimiento" id="nombres_mantenimiento_editar">
                                                @foreach ($tipoMantenimientos_estado as $key => $value)
                                                    <option value="{{$value->id_mantenimiento}}" class="text-body">{{$value->nombre_mantenimiento}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="w-full-mitad md:w-full" id="valor_garantia">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Garantía (Meses)
                                        </label>
                                        <input type="text" placeholder="Ingrese la garantía (Meses)" name="garantia" id="garantia_edit" required autofocus maxlength="2"
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full" id="monto_cronograma_div_editar">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Monto
                                        </label>
                                        <input type="text" placeholder="Ingrese el monto" name="monto_cronograma" id="monto_cronograma_editar" required autofocus
                                            class="inputRutaMonto w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" id="otm_editar">N° OTM</label>
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" id="ods_editar">N° ODS</label>
                                        <input type="text" placeholder="Ingrese el número de OTM o ODS" name="otm_cronograma_editar" id="otm_cronograma_editar" autofocus
                                            class="inputRutaMonto w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                        <div x-data="{ isOptionSelected: false }" id="orden_servicio_cronograma"
                                            class="relative z-20 bg-white dark:bg-form-input">
                                            <select
                                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                                :class="isOptionSelected && 'text-black dark:text-white'"
                                                @change="isOptionSelected = true" name="id_ordenServicio_editar" id="id_ordenServicio_editar">
                                                @foreach ($ordenServicios as $key => $value)
                                                    <option value="{{$value->id_ordenServicio}}" class="text-body">{{$value->codigo_ordenServicio}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>













                                    

                                    <div class="w-full md:w-full" id="class_detalle">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Detalles del Servicio
                                        </label>
                                        <textarea name="cronograma_observacion_editar" id="cronograma_observacion_editar" autofocus
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"></textarea>
                                    </div>

                                    <div class="w-full-mitad md:w-full" id="divLista">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Conformidad de servicio
                                        </label>
                                        <a href="../storage/" id="descargaLista" download="Conformidad del Servicio" class="btn btn-default btn-sm">
                                            <i class="fas fa-download text-black"></i> Descargar Archivo
                                        </a>
                                    </div>







<!--                                     <div class="w-full-mitad md:w-full" id="proveedor_cronograma">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Empresa
                                        </label>
                                        <div x-data="{ isOptionSelected: false }"
                                            class="relative z-20 bg-white dark:bg-form-input">
                                            <select
                                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                                :class="isOptionSelected && 'text-black dark:text-white'"
                                                @change="isOptionSelected = true" name="id_proveedor" id="id_proveedor">
                                                <option value="">-- Seleccionar el proveedor --</option>
                                                @foreach ($proveedores as $key => $value)
                                                    <option value="{{$value->id_proveedor}}" class="text-body">{{$value->razonSocial_proveedor}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> -->

<!--                                     <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Solicitante por departamento
                                        </label>
                                        <div x-data="{ isOptionSelected: false }"
                                            class="relative z-20 bg-white dark:bg-form-input">
                                            <select
                                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                                :class="isOptionSelected && 'text-black dark:text-white'"
                                                @change="isOptionSelected = true" name="id_departamento" id="id_departamento">
                                                <option value="">-- Seleccionar el departamento --</option>
                                                @foreach ($departamentos as $key => $value)
                                                    <option value="{{$value->id_departamento}}" class="text-body">{{$value->nombre_departamento}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> -->

<!--                                     <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" id="otm">N° OTM</label>
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" id="ods">N° ODS</label>
                                        <input type="text" placeholder="Ingrese el número de OTM o ODS" name="otm_cronograma" id="otm_cronograma" value="{{ old("otm_cronograma") }}" autofocus
                                            class="inputRutaMonto w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                        <div x-data="{ isOptionSelected: false }" id="orden_servicio_cronograma"
                                            class="relative z-20 bg-white dark:bg-form-input">
                                            <select
                                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                                :class="isOptionSelected && 'text-black dark:text-white'"
                                                @change="isOptionSelected = true" name="id_ordenServicio" id="id_ordenServicio">
                                                <option value="">-- Seleccionar la orden de servicio --</option>
                                                @foreach ($ordenServicios as $key => $value)
                                                    <option value="{{$value->id_ordenServicio}}" class="text-body">{{$value->codigo_ordenServicio}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> -->

                                    <hr class="pb-2">

                                    <div class="w-full" style="text-align:center;" id="class_archivo">
                                        <div class="btn btn-default btn-file">
                                            <i class="fas fa-paperclip"></i> Adjuntar archivo
                                            <input type="file" name="pdf_archivo_final_editar" id="pdf_archivo_final_editar">
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
                    <!-- FIN JACXIMIR -->
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
                                <input class="datatable-input" placeholder="Escribe para buscar" type="search" title="Search within table" aria-controls="tablaCronogramaLista">
                            </div>
                        </div>
                        <div class="datatable-container">
                            <table class="table w-full table-auto datatable-table" id="tablaCronogramaLista">
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
                                        <th style="width: 26.89655172413793%;">
                                            <a href="#">
                                                <div class="flex items-center justify-between gap-1.5">
                                                    <p>Tipo mantenimiento</p>
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
                                                    <p>Fecha inicial</p>
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
                                                    <p>Fecha final</p>
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
                                                    <p>Empresa</p>
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
                                                    <p>Solicitante</p>
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
                                                    <p>Garantía</p>
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
                                                    <p>Detalles del servicio</p>
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
                                                    <p>Monto del mantenimiento</p>
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
                                                    <p>Conformidad del servicio</p>
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

<!-- <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Cronogramas (Lista)</h1>
            </br>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url("/") }}">Inicio</a></li>
              <li class="breadcrumb-item active">Cronogramas (Lista)</li>
            </ol>
          </div>

          <div class="col-sm-12">
            <div class="callout callout-info col-md-12" style="float:left;">
                    <h5>
                        <span class="spinner-grow text-danger"></span>
                        <i> Registrar si se realizó el Mantenimiento:</i>
                        <button id="ocultar_listado" class="btn btn-danger btn-sm">Ver Listado</button>
                    </h5>

                    </br>

                <div id="tabla_ocultar">
                    <table class="table table-bordered table-striped dt-responsive" width="100%"
                    id="historial">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Equipo</th>
                            <th>Cod. Patrimonial</th>
                            <th>Tipo de Mantenimiento</th>
                            <th>Fecha Inicial</th>
                            <th>Fecha Final</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
            </div>
          </div>
        </div>
      </div>
    </section>


    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#agregarCalendario">
                    Crear nuevo cronograma</button>
              </div>
              <div class="card-body">

                <table class="table table-bordered table-striped dt-responsive" width="100%"
                 id="tablaCronogramaLista">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Equipo</th>
                            <th>Cod. Patrimonial</th>
                            <th>Tipo Mantenimiento</th>
                            <th>Fecha Inicial</th>
                            <th>Fecha Final</th>
                            <th>N° ODS/OTM</th>
                            <th>Empresa</th>
                            <th>Solicitado por</th>
                            <th>Garantía</th>
                            <th>Detalles del Servicio</th>
                            <th>Monto del Mantenimiento</th>
                            <th>Conformidad del Servicio</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>

                    </thead>

                    <tbody>
                    </tbody>
                </table>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>




<div class="modal fade" id="editarModalCronograma" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-tittle">Cronograma de Mantenimiento</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
            
                <form id="editFormCronogramaList" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                        <div class="input-group mb-3">
                            <label for="email" class="col-md-3 control-label">Fecha Inicial:</label>
        
                            <div class="col-md-8">
                                <input id="fecha_actual_editar" name="fecha_actual" type="date" class="form-control">
        
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <label for="email" class="col-md-3 control-label">Fecha Final:</label>
        
                            <div class="col-md-8">
                                <input id="fecha_final_editar" name="fecha_final" type="date" class="form-control">
        
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <label for="email" class="col-md-3 control-label">Equipo:</label>
        
                            <div class="col-md-8">
                                <select class="form-control " name="id_equipo" id="nombres_equipo_editar" required>
                                        <option value="">
                                            -- Seleccionar el Equipo --
                                        </option>
        
                                        @foreach($equipos as $key => $value)
                                            <option  value="{{$value->id_equipo}}">
                                                {{$value->nombre_equipo}}<span> - </span><p>Cod. Patrimonial: {{$value->cp_equipo}}</p>
                                            </option>
                                        @endforeach
                                </select>
                            </div>
                        </div>

                            <div class="input-group mb-3" style="display:none;">
        
                                <label for="email" class="col-md-3 control-label">Realizado:</label>
        
                                <div class="col-md-6">
                                    <input class="form-control" name="realizado_crear"
                                    value="0" required autofocus
                                    style="text-transform: uppercase;" readonly="">
                                </div>
                            </div>

                        <div class="input-group mb-3">
                            <label for="email" class="col-md-3 control-label">Tipo:</label>
        
                            <div class="col-md-8">
                                <select class="form-control" name="id_mantenimiento" id="nombres_mantenimiento_editar" required>
                                        <option value="">
                                            -- Seleccionar el Tipo de Mantenimiento --
                                        </option>
        
                                        @foreach($tipoMantenimientos_estado as $key => $valorMantenimiento)
                                        <option value="{{$valorMantenimiento->id_mantenimiento}}">{{$valorMantenimiento->nombre_mantenimiento}}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="input-group mb-3" id="valor_garantia">
                            <label for="email" class="col-md-3 control-label">Garantía:</label>
        
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="garantia" id="garantia_edit"
                                 autofocus
                                placeholder="Ingrese la garantía (Meses)" style="text-transform: uppercase;" maxlength="2">
                            </div>
                        </div>

                        <div class="input-group mb-3" id="class_detalle">
                            <label for="email" class="col-md-3 control-label">Detalles del Servicio:</label>
    
                            <div class="col-md-8">
                                <textarea class="form-control" name="cronograma_observacion_editar" id="cronograma_observacion_editar" autofocus style="text-transform: uppercase;"></textarea>
                            </div>
                        </div>

                        <div class="input-group mb-3" id="monto_cronograma">
    
                            <label for="email" class="col-md-4 control-label">Monto:</label>
    
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="monto_cronograma" id="monto_cronograma"
                                 autofocus
                                style="text-transform: uppercase;">
                            </div>
                        </div>

                        <div class="input-group mb-3" id="class_otm">
    
                            <label for="email" class="col-md-3 control-label">N° OTM:</label>
    
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="otm_cronograma_editar" id="otm_cronograma_editar"
                                autofocus
                                style="text-transform: uppercase;">
                            </div>
                        </div>

                        <div class="text-center" id="divLista">
                            <a href="../storage/" id="descargaLista" download="Conformidad del Servicio" class="btn btn-default btn-sm">
                                <i class="fas fa-download text-black"></i> Descargar Archivo
                            </a>
                            
                        </div>

                                <div class="form-group my-2 text-center" id="class_archivo">
                                    <hr class="pb-2">
                                    <div class="btn btn-default btn-file">
                                        <i class="fas fa-paperclip"></i> Adjuntar Archivo
                                        <p><label for="pdf_archivo_final">
                                            <input type="file" name="pdf_archivo_final_editar" id="pdf_archivo_final_editar">
                                        </label></p>
    
                                    </div><br>
    
                                    <p class="help-block small">Tamaño máximo de archivos: 20MB</p>
                                </div>
    


        
                    <div class="modal-footer d-flex justify-content-between">
                        <div>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
        
                        <div>
                            <button type="submit" id="boton_enviar_calendario" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-tittle">Registrar Mantenimiento</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               
                <form id="editForm" method="POST"  accept-charset="UTF-8" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="text" name="lista" value="1" hidden>
                            <div class="input-group mb-3" style="display:none;">
        
                                <label for="email" class="col-md-4 control-label">Mantenimiento:</label>
        
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="mantenimiento_oculto" id="mantenimiento_oculto"
                                   autofocus
                                    style="text-transform: uppercase;" readonly="">
                                </div>
                            </div>

                            <div class="input-group mb-3">
        
                                <label for="email" class="col-md-4 control-label">Equipo:</label>
        
                                <div class="col-md-8">
                                    <input type="hidden" class="form-control" name="cronograma_equipo" id="cronograma_equipo"
                                     required autofocus
                                    style="text-transform: uppercase;" readonly="">
        
                                    <input type="text" class="form-control" name="" id="nombre_equipo"
                                     required autofocus
                                    style="text-transform: uppercase;" readonly="">
                                </div>
                            </div>

                            <div class="input-group mb-3">
        
                                <label for="email" class="col-md-4 control-label">Fecha Inicial:</label>
        
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="cronograma_fecha"  id="cronograma_fecha"
                                     required autofocus
                                    style="text-transform: uppercase;" readonly="">
                                </div>
                            </div>
        
                            <div class="input-group mb-3">
        
                                <label for="email" class="col-md-4 control-label">Fecha Final:</label>
        
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="cronograma_fecha_final" id="cronograma_fecha_final"
                                    required autofocus
                                    style="text-transform: uppercase;" readonly="">
                                </div>
                            </div>

                            <div class="input-group mb-3" id="orden_servicio_cronograma" >
                                <label for="email" class="col-md-4 control-label">ODS:</label>
        
                                <div class="col-md-8">
                                    <select class="form-control" name="id_ordenServicio"  id="id_ordenServicio">
                                        <option value="">
                                            -- Seleccionar la orden de Servicio --
                                        </option>
        
                                       
                                    </select>
                                </div>
                            </div>

                            <div class="input-group mb-3" style="display:none;">
        
                                <label for="email" class="col-md-4 control-label">Fecha:</label>
        
                                <div class="col-md-6">
                                    <input class="form-control" name="cronograma_realizado" 
                                    value="1" required autofocus
                                    style="text-transform: uppercase;" readonly="">
                                </div>
                            </div>

                            <div class="input-group mb-3" id="proveedor_cronograma">
                                <label for="email" class="col-md-4 control-label">Empresa:</label>
        
                                <div class="col-md-8">
                                    <select class="form-control" name="id_proveedor" id="id_proveedor">
                                            <option value="">
                                                -- Seleccionar el Proveedor --
                                            </option>
        
                                           
        
                                        </select>
                                </div>
                            </div>

                            <div class="input-group mb-3">
                                <label for="email" class="col-md-4 control-label">Solicitado por:</label>
        
                                <div class="col-md-7">
                                    <select class="form-control" name="id_departamento" id="id_departamento">
                                            <option value="">
                                                -- Seleccionar el Departamento --
                                            </option>
                                            @foreach ($departamentos as $item)
                                                <option value="{{$item->id_departamento}}">{{$item->nombre_departamento}}</option>
                                            @endforeach
                                            
        
                                        </select>
                                </div>
        
                                <label for="email" class="col-md-1 control-label">o</label>
                            </div>

                            <div class="input-group mb-3">
                                <label for="email" class="col-md-4 control-label" style="color:white;">Solicitado por:</label>
        
                                <div class="col-md-8">
                                    <select class="form-control" name="id_direccionEjecutiva" id="id_direccionEjecutiva" required>
                                            <option value="">
                                                -- Seleccionar la Dirección Ejecutiva --
                                            </option>
                                            @foreach ($direccionesEjecutivas as $item)
                                                <option value="{{$item->id_direccionEjecutiva}}">{{$item->nombre_direccionEjecutiva}}</option>
                                            @endforeach
                                           
                                    </select>
                                </div>
                            </div>

                            <div class="input-group mb-3" id="garantiaVer">
        
                                <label for="email" class="col-md-4 control-label">Garantía (Meses):</label>
        
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="cronograma_garantia" id="cronograma_garantia"
                                    autofocus
                                    style="text-transform: uppercase;">
                                </div>
                            </div>

                            <div class="input-group mb-3">
                                <label for="email" class="col-md-4 control-label">Detalles del Servicio:</label>
        
                                <div class="col-md-8">
                                    <textarea class="form-control" name="cronograma_observacion" id="cronograma_observacion" autofocus style="text-transform: uppercase;"></textarea>
                                </div>
                            </div>

                            <div class="input-group mb-3" id="monto_cronograma">
        
                                <label for="email" class="col-md-4 control-label">Monto:</label>
        
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="monto_cronograma" id="monto_cronograma"
                                     autofocus
                                    style="text-transform: uppercase;">
                                </div>
                            </div>

                            <div class="input-group mb-3" >
        
                                    <label for="email" id="otm" class="col-md-4 control-label">N° OTM:</label>

                                    <label for="email" id="ods" class="col-md-4 control-label">N° ODS:</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="otm_cronograma" id="otm_cronograma"
                                    autofocus
                                    style="text-transform: uppercase;">
                                </div>
                            </div>

                                <hr class="pb-2">
                                    <div class="form-group my-2 text-center">
                                        <div class="btn btn-default btn-file">
                                            <i class="fas fa-paperclip"></i> Adjuntar Archivo
                                            <p><label for="pdf_archivo_final">
                                                <input type="file" name="pdf_archivo_final" id="pdf_archivo_final">
                                            </label></p>
        
                                        </div><br>
        
                                        <p class="help-block small">Tamaño máximo de archivos: 20MB</p>
                                    </div>
        
                

                    <div class="modal-footer d-flex justify-content-between">
                        <div>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
    
                        <div>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="agregarCalendario">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formulario_calendario" method="POST" action="{{url('/')}}/cronogramasLista">
            @csrf

            <div class="modal-header bg-info">
                <h4 class="modal-tittle">Cronograma de Mantenimiento</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <div class="input-group mb-3">
                    <label for="email" class="col-md-3 control-label">Fecha Inicial:</label>

                    <div class="col-md-8">
                        <input id="fecha_actual_calendario" name="fecha_actual" type="date" class="form-control">

                    </div>
                </div>

                <div class="input-group mb-3">
                    <label for="email" class="col-md-3 control-label">Fecha Final:</label>

                    <div class="col-md-8">
                        <input id="fecha_final_calendario" name="fecha_final" type="date" class="form-control">

                    </div>
                </div>

                <div class="input-group mb-3">
                    <label for="email" class="col-md-3 control-label">Equipo:</label>

                    <div class="col-md-8">
                        <select class="form-control select2" name="id_equipo" id="nombres_equipo" required>
                                <option value="">
                                    -- Seleccionar el Equipo --
                                </option>

                                @foreach($equipos as $key => $value)
                                    <option  value="{{$value->id_equipo}}">
                                        {{$value->nombre_equipo}}<span> - </span><p>Cod. Patrimonial: {{$value->cp_equipo}}</p>
                                    </option>
                                @endforeach
                        </select>
                    </div>
                </div>

                    <div class="input-group mb-3" style="display:none;">

                        <label for="email" class="col-md-3 control-label">Realizado:</label>

                        <div class="col-md-6">
                            <input class="form-control" name="realizado_crear"
                            value="0" required autofocus
                            style="text-transform: uppercase;" readonly="">
                        </div>
                    </div>

                <div class="input-group mb-3">
                    <label for="email" class="col-md-3 control-label">Tipo:</label>

                    <div class="col-md-8">
                        <select class="form-control" name="id_mantenimiento" id="nombres_mantenimiento" required>
                                <option value="">
                                    -- Seleccionar el Tipo de Mantenimiento --
                                </option>

                                @foreach($tipoMantenimientos_estado as $key => $valorMantenimiento)
                                <option value="{{$valorMantenimiento->id_mantenimiento}}">{{$valorMantenimiento->nombre_mantenimiento}}</option>
                                @endforeach
                        </select>
                    </div>
                </div>

                <div class="input-group mb-3" id="valor_garantia_div">
                    <label for="email" class="col-md-3 control-label">Garantía:</label>

                    <div class="col-md-4">
                        <input type="text" class="form-control" name="garantia"
                        value="0" autofocus
                        placeholder="Ingrese la garantía (Meses)" style="text-transform: uppercase;" maxlength="2">
                    </div>
                </div>

            </div>

            <div class="modal-footer d-flex justify-content-between">
                <div>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>

                <div>
                    <button type="submit" id="boton_enviar_calendario" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
      </div>
    </div>
</div> -->

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
        var table = $('#tablaCronogramaLista').DataTable();

        $('#searchBtn').on('click', function() {
            var nombre = $('#nombre').val().toLowerCase();
            var codigo_patrimonial = $('#codigo_patrimonial').val().toLowerCase();
            var mantenimiento = $('#mantenimiento').val();
            var fecha_inicial = $('#modelo').val();
            var fecha_final = $('#serie').val();
            var numero_orden_servicio = $('#numero_orden_servicio').val();
            var empresa = $('#empresa').val().toLowerCase();
            var ambiente = $('#ambiente').val();

            table.column(1).search(nombre);
            table.column(2).search(codigo_patrimonial);
            table.column(3).search(mantenimiento);
            table.column(4).search(fecha_inicial);
            table.column(5).search(fecha_final);
            table.column(6).search(numero_orden_servicio);
            table.column(7).search(empresa);
            table.column(8).search(ambiente);
            table.draw();
        });

        $('#clearBtn').on('click', function() {
            $('#nombre').val('');
            $('#codigo_patrimonial').val('');
            $('#mantenimiento').val('');
            $('#fecha_inicial').val('');
            $('#fecha_final').val('');
            $('#numero_orden_servicio').val('');
            $('#empresa').val('');
            $('#ambiente').val('');

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

    document.getElementById('toggleFilterIcon1').addEventListener('click', function() {
        var listForm = document.getElementById('listForm');
        var filterIcon1 = document.getElementById('filterIcon1');

        if (listForm.classList.contains('hidden')) {
            listForm.classList.remove('hidden');
            filterIcon1.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                </svg>`;
        } else {
            listForm.classList.add('hidden');
            filterIcon1.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>`;
        }
    });
</script>

<script>
    document.getElementById('clearBtn').addEventListener('click', function() {
        document.getElementById('nombre').value = '';
        document.getElementById('codigo_patrimonial').value = '';
        document.getElementById('mantenimiento').selectedIndex = 0;
        document.getElementById('fecha_inicial').value = '';
        document.getElementById('fecha_final').value = '';
        document.getElementById('numero_orden_servicio').value = '';
        document.getElementById('empresa').value = '';
        document.getElementById('ambiente').selectedIndex = 0;
        
        document.getElementById('serie').value = '';
        var table = $('#tablaCronogramaLista').DataTable();
        table.search('').columns().search('').draw();
    });
</script>

@if (Session::has("ok-crear"))
    <script>
        notie.alert({type:1,text:'!El Mantenimiento ha sido creado correctamente', time:10})
    </script>
@endif

@if (Session::has("no-validacion"))
    <script>
        notie.alert({type:2,text:'!Hay campos no válidos en el formulario', time:10})
    </script>
@endif

@if (Session::has("error"))
    <script>
        notie.alert({type:3,text:'!Error en el gestor de mantenimientos', time:10})
    </script>
@endif

@if (Session::has("ok-editar"))
    <script>
        notie.alert({type:1,text:'!El Mantenimiento ha sido actualizado correctamente', time:10})
    </script>
@endif

@if (Session::has("ok-eliminar"))
    <script>
        notie.alert({ type: 1, text: '¡El Mantenimiento ha sido eliminado correctamente!', time: 10 })
    </script>
@endif

@if (Session::has("no-borrar"))
    <script>
        notie.alert({ type: 2, text: '¡Este administrador no se puede borrar!', time: 10 })
    </script>
@endif

@endsection

@section('javascript')
<script src="{{ url('/') }}/js/cronogramaLista.js"></script>
@endsection

@endif
@endforeach