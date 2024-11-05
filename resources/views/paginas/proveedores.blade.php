@foreach ($administradores as $element)
@if ($_COOKIE["email_login"] == $element->email)
@extends('plantilla')
@section('content')

<main>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Proveedores
            </h2>

            <nav>
                <ol class="flex items-center gap-2">
                    <li>
                        <a class="font-medium" href="{{ url("/") }}">Inicio /</a>
                    </li>
                    <li class="font-medium text-primary">Proveedores</li>
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
                                RUC
                            </label>
                            <input type="text" id="ruc_b" placeholder="Buscar por RUC" autofocus
                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                        </div>

                        <div class="w-full-mitad md:w-full">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                Razón Social
                            </label>
                            <input type="text" id="razon_social" placeholder="Buscar por razón social" autofocus
                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                        </div>

                        <div class="w-full-mitad md:w-full">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                Estado
                            </label>
                            <input type="text" id="estado" placeholder="Buscar por estado" autofocus
                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                        </div>

                        <div class="w-full-mitad md:w-full">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                Dirección
                            </label>
                            <input type="text" id="direccion" placeholder="Buscar por dirección" autofocus
                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                        </div>

                        <div class="w-full-mitad md:w-full">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                Distrito
                            </label>
                            <input type="text" id="distrito" placeholder="Buscar por distrito" autofocus
                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                        </div>

                        <div class="w-full-mitad md:w-full">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                Provincia
                            </label>
                            <input type="text" id="provincia" placeholder="Buscar por provincia" autofocus
                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                        </div>

                        <div class="w-full-mitad md:w-full">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                Departamento
                            </label>
                            <input type="text" id="departamento" placeholder="Buscar por departamento" autofocus
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
                    @can("crear_proveedores")
                    <button data-modal-target="crearModal" class="open-modal-btn inline-flex items-center justify-center gap-2.5 rounded-md bg-primary px-6 py-4 text-center font-medium 
                            text-white hover:bg-opacity-90 min-w-150 ml-333 button-general">
                        Añadir
                    </button>
                    @endcan

                    <div id="crearModal" class="modal fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-999999">
                        <div class="modal-content bg-white rounded-lg shadow-lg min-w-300 w-70-1 max-w-screen-2xl dark:border-strokedark dark:bg-boxdark">
                            <form method="POST" action="{{ url('/') }}/proveedores">
                                @csrf

                                <div class="flex justify-between items-center p-4 border-b border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Crear proveedor</h3>
                                    <button class="close-modal-btn text-gray-500 hover:text-gray-700">&times;</button>
                                </div>

                                <div class="flex justify-between items-center p-4 border-b border-gray-200">
                                    <div style="display:flex;">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white" style="margin-right: 15px; margin-top: 13px;">
                                            Buscar por RUC:
                                        </label>
                                        <input id="ruc" name="ruc" type="text" placeholder="Ingrese el RUC" value="" required autofocus maxlength="11"
                                            class="inputRuta rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>
                                    <button type="button" id="btnbuscar" class="inline-flex items-center justify-center gap-2.5 rounded-md bg-secondary px-6 py-4 text-center font-medium 
                                            text-white hover:bg-opacity-90 min-w-150 ml-333 button-general">
                                        <i class="fa fa-search"></i> Buscar
                                    </button>
                                </div>

                                <div>
                                    <small id="mensaje" style="color: red;display: none;font-size: 12pt;margin-left:16px;">
                                        <i class="fa fa-remove"></i> El numero de RUC no es valido.
                                    </small>
                                </div>

                                <div class="flex flex-wrap gap-5.5 p-6.5">
                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Razón social
                                        </label>
                                        <textarea id="txtrazonBuscar" name="txtrazon" readonly="" rows="2" required
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary">
                                        </textarea>
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Dirección
                                        </label>
                                        <textarea id="txtdireccionBuscar" name="txtdireccion" readonly="" rows="2"
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary">
                                        </textarea>
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            RUC
                                        </label>
                                        <input type="text" id="txtdniBuscar" name="txtdni" readonly="" required
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Estado
                                        </label>
                                        <input id="txtgrupoBuscar" name="txtgrupo" type="text" readonly="" required
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Distrito
                                        </label>
                                        <input id="txtdistritoBuscar" name="txtdistrito" type="text" readonly=""
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Provincia
                                        </label>
                                        <input id="txtprovinciaBuscar" name="txtprovincia" type="text" readonly=""
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Departamento
                                        </label>
                                        <input id="txtdepartamentoBuscar" name="txtdepartamento" type="text" readonly=""
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
                                        <button type="button" class="limpiar_datos close-modal-btn inline-flex items-center justify-center gap-2.5 rounded-md bg-danger px-6 py-4 text-center font-medium
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
                            <form id="editForm" method="POST" action="{{ url('/') }}/proveedores">
                                @csrf
                                @method('PUT')
                                <div class="flex justify-between items-center p-4 border-b border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Editar proveedor</h3>
                                    <button type="button" class="close-modal-btn text-gray-500 hover:text-gray-700">&times;</button>
                                </div>

                                <div class="flex flex-wrap gap-5.5 p-6.5">
                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Razón social
                                        </label>
                                        <textarea id="txtrazon" name="txtrazon" readonly="" rows="2" required
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary">
                                        </textarea>
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Dirección
                                        </label>
                                        <textarea id="txtdireccion" name="txtdireccion" readonly="" rows="2"
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary">
                                        </textarea>
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            RUC
                                        </label>
                                        <input type="text" id="txtdni" name="txtdni" readonly="" required
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Estado
                                        </label>
                                        <input id="txtgrupo" name="txtgrupo" type="text" readonly="" required
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Distrito
                                        </label>
                                        <input id="txtdistrito" name="txtdistrito" type="text" readonly=""
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Provincia
                                        </label>
                                        <input id="txtprovincia" name="txtprovincia" type="text" readonly=""
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Departamento
                                        </label>
                                        <input id="txtdepartamento" name="txtdepartamento" type="text" readonly=""
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
                                <input class="datatable-input" placeholder="Escribe para buscar" type="search" title="Search within table" aria-controls="tablaProveedores">
                            </div>
                        </div>
                        <div class="datatable-container">
                            <table class="table w-full table-auto datatable-table" id="tablaProveedores">
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
                                                    <p>RUC</p>
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
                                        <th style="width: 15.862068965517242%;">
                                            <a href="#">
                                                <div class="flex items-center justify-between gap-1.5">
                                                    <p>Razón Social</p>
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
                                                    <p>Dirección</p>
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
                                                    <p>Distrito</p>
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
                                                    <p>Provincia</p>
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
                                                    <p>Departamento</p>
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
        var table = $('#tablaProveedores').DataTable();

        $('#searchBtn').on('click', function() {
            var ruc = $('#ruc_b').val();
            var razon_social = $('#razon_social').val().toLowerCase();
            var estado = $('#estado').val().toLowerCase();
            var direccion = $('#direccion').val().toLowerCase();
            var distrito = $('#distrito').val().toLowerCase();
            var provincia = $('#provincia').val().toLowerCase();
            var departamento = $('#departamento').val().toLowerCase();

            table.column(1).search(ruc);
            table.column(2).search(razon_social);
            table.column(3).search(estado);
            table.column(4).search(direccion);
            table.column(5).search(distrito);
            table.column(6).search(provincia);
            table.column(7).search(departamento);
            table.draw();
        });

        $('#clearBtn').on('click', function() {
            $('#ruc_b').val('');
            $('#razon_social').val('');
            $('#estado').val('');
            $('#direccion').val('');
            $('#distrito').val('');
            $('#provincia').val('');
            $('#departamento').val('');

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
        document.getElementById('ruc').value = '';
        document.getElementById('razon_social').value = '';
        document.getElementById('estado').value = '';
        document.getElementById('direccion').value = '';
        document.getElementById('distrito').value = '';
        document.getElementById('provincia').value = '';
        document.getElementById('departamento').value = '';
        var table = $('#tablaProveedores').DataTable();
        table.search('').columns().search('').draw();
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#btnbuscar').click(function(){
            var numdni=$('#ruc').val();
            
            if (numdni!='') {
                $.ajax({
                    url:"{{ route('consultar.sunat') }}",
                    method:'GET',
                    data:{ruc:numdni},
                    dataType:'json',
                    success:function(data){
                        var resultados=data.entidad['success'];
                        if (resultados==true) {
                            var razon=data.entidad['entity']['nombre_o_razon_social'];
                            var direccion=data.entidad['entity']['direccion'];
                            var distrito=data.entidad['entity']['distrito'];
                            var provincia=data.entidad['entity']['provincia'];
                            var departamento=data.entidad['entity']['departamento'];
                            var estado=data.entidad['entity']['estado_del_contribuyente'];
                            $('#txtdniBuscar').val(numdni);
                            $('#txtrazonBuscar').val(razon);
                            $('#txtgrupoBuscar').val(estado);
                            $('#txtdireccionBuscar').val(direccion);
                            $('#txtdistritoBuscar').val(distrito);
                            $('#txtprovinciaBuscar').val(provincia);
                            $('#txtdepartamentoBuscar').val(departamento);
                        }else{
                            $('#txtdniBuscar').val('');
                            $('#txtrazonBuscar').val('');
                            $('#txtgrupoBuscar').val('');
                            $('#txtdireccionBuscar').val('');
                            $('#txtdistritoBuscar').val('');
                            $('#txtprovinciaBuscar').val('');
                            $('#txtdepartamentoBuscar').val('');
                            $('#mensaje').show();
                            $('#mensaje').delay(2000).hide(2500);
                        }
                    }
                });
            }else{
                alert('Escriba el RUC.!');
                $('#ruc').focus();
            }
        });

        $('.limpiar_datos').click(function(){
            $('#ruc').val('');
            $('#txtdniBuscar').val('');
            $('#txtrazonBuscar').val('');
            $('#txtgrupoBuscar').val('');
            $('#txtdireccionBuscar').val('');
            $('#txtdistritoBuscar').val('');
            $('#txtprovinciaBuscar').val('');
            $('#txtdepartamentoBuscar').val('');
        });
    });
</script>

@if (Session::has("ok-crear"))
  <script>
      notie.alert({type:1,text:'!El Proveedor ha sido creado correctamente', time:10})
  </script>
@endif

@if (Session::has("ruc-existe"))
  <script>
      notie.alert({type:2,text:'!El Proveedor ya existe en nuestros registros', time:10})
  </script>
@endif

@if (Session::has("no-validacion"))
  <script>
      notie.alert({type:2,text:'!Hay campos no válidos en el formulario', time:10})
  </script>
@endif

@if (Session::has("error"))
  <script>
      notie.alert({type:3,text:'!Error en el gestor de Proveedores', time:10})
  </script>
@endif

@if (Session::has("ok-editar"))
  <script>
      notie.alert({type:1,text:'!El Proveedor ha sido actualizado correctamente', time:10})
  </script>
@endif

@if (Session::has("ok-eliminar"))

<script>
    notie.alert({ type: 1, text: '¡El Rol ha sido eliminado correctamente!', time: 10 })
</script>

@endif

@if (Session::has("no-borrar"))

<script>
    notie.alert({ type: 2, text: '¡Este administrador no se puede borrar!', time: 10 })
</script>

@endif

@endsection

@section('javascript')
<script src="{{ url('/') }}/js/proveedores.js"></script>
@endsection

@endif

@endforeach
