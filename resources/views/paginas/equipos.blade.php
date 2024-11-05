@foreach ($administradores as $element)
@if ($_COOKIE["email_login"] == $element->email)
@extends('plantilla')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    .modalDiv {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.9);
    }

    .modalImg {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    .close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #fff;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close:hover,
    .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<main>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Equipos
            </h2>

            <nav>
                <ol class="flex items-center gap-2">
                    <li>
                        <a class="font-medium" href="{{ url("/") }}">Inicio /</a>
                    </li>
                    <li class="font-medium text-primary">Equipos</li>
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
                                Marca
                            </label>
                            <input type="text" id="marca" placeholder="Buscar por nombre" autofocus
                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                        </div>

                        <div class="w-full-mitad md:w-full">
                            <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                Modelo
                            </label>
                            <input type="text" id="modelo" placeholder="Buscar por modelo" autofocus
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
                                Serie
                            </label>
                            <input type="text" id="serie" placeholder="Buscar por serie" autofocus
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

                            <form method="POST" action="{{ url('/') }}/equipos" enctype="multipart/form-data">
                                @csrf
                                <div class="flex justify-between items-center p-4 border-b border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Crear equipo</h3>
                                    <button class="close-modal-btn text-gray-500 hover:text-gray-700">&times;</button>
                                </div>

                                <div class="flex flex-wrap gap-5.5 p-6.5">
                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Nombre
                                        </label>
                                        <input type="text" placeholder="Ingrese el nombre" name="nombre_equipo" value="{{ old("nombre_equipo") }}" required autofocus
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Marca
                                        </label>
                                        <input type="text" placeholder="Ingrese la marca" name="marca_equipo" value="{{ old("marca_equipo") }}" required autofocus
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Modelo
                                        </label>
                                        <input type="text" placeholder="Ingrese el modelo" name="modelo_equipo" value="{{ old("modelo_equipo") }}" required autofocus
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Serie
                                        </label>
                                        <input type="text" placeholder="Ingrese el número de serie" name="serie_equipo" value="{{ old("serie_equipo") }}" required autofocus
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Código patrimonial
                                        </label>
                                        <input type="text" placeholder="Ingrese el código patrimonial" name="cp_equipo" value="{{ old("cp_equipo") }}" required autofocus
                                            class="inputRutaMonto w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Tipo de equipamiento
                                        </label>
                                        <div x-data="{ isOptionSelected: false }"
                                            class="relative z-20 bg-white dark:bg-form-input">
                                            <select
                                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                                :class="isOptionSelected && 'text-black dark:text-white'"
                                                @change="isOptionSelected = true" name="id_tipoEquipamiento" required>
                                                <option value="">-- Seleccionar el tipo de equipamiento --</option>
                                                @foreach ($tipoEquipamientos as $key => $value)
                                                    <option value="{{$value->id_tipoEquipamiento}}" class="text-body">{{$value->nombre_tipoEquipamiento}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Ambiente
                                        </label>
                                        <div x-data="{ isOptionSelected: false }"
                                            class="relative z-20 bg-white dark:bg-form-input">
                                            <select
                                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                                :class="isOptionSelected && 'text-black dark:text-white'"
                                                @change="isOptionSelected = true" name="id_ambiente" required>
                                                <option value="">-- Seleccionar el ambiente --</option>
                                                @foreach ($ambientes as $key => $value)
                                                    <option value="{{$value->id_ambiente}}" class="text-body">{{$value->nombre_ambiente}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Fecha de adquisición
                                        </label>
                                        <input type="date" placeholder="Ingrese la fecha de adquisición" name="fecha_adquisicion_equipo" value="{{ old("fecha_adquisicion_equipo") }}" required autofocus
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Monto de adquisición
                                        </label>
                                        <input type="text" placeholder="Ingrese el monto de adquisición" name="monto_adquisicion_equipo" value="{{ old("monto_adquisicion_equipo") }}" required autofocus
                                            class="inputRutaMonto w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Vida útil
                                        </label>
                                        <input type="text" placeholder="Ingrese la vida util (Años)" name="tiempo_vida_util_equipo" value="{{ old("tiempo_vida_util_equipo") }}" required autofocus maxlength="2"
                                            class="inputRutaMonto w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Prioridad
                                        </label>
                                        <input type="text" placeholder="Ingrese la prioridad" name="prioridad_equipo" value="{{ old("prioridad_equipo") }}" required autofocus maxlength="2"
                                            class="inputRutaMonto w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Estado
                                        </label>
                                        <div x-data="{ isOptionSelected: false }"
                                            class="relative z-20 bg-white dark:bg-form-input">
                                            <select
                                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                                :class="isOptionSelected && 'text-black dark:text-white'"
                                                @change="isOptionSelected = true" name="estado" required>
                                                <option value="0" class="text-body">Servicio</option>
                                            </select>
                                        </div>
                                    </div>

                                    <hr class="pb-2">

                                    <div class="w-full" style="text-align:center;">
                                        <div class="btn btn-default btn-file">
                                            <i class="fas fa-paperclip"></i> Adjuntar Foto
                                            <input type="file" name="foto" id="imagen_equipo" onchange="previewImage(event)">
                                        </div><br>

                                        <img src="" class="previsualizarImg_foto img-fluid py-2 w-25" style="margin:auto;">
                                        <p class="help-block small" style="margin-top:15px;">Dimensiones: 200px * 200px | Peso Max. 2MB | Formato: JPG o PNG</p>
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
                            <form id="editForm" method="POST" action="{{ url('/') }}/equipos" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="flex justify-between items-center p-4 border-b border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Editar equipo</h3>
                                    <button type="button" class="close-modal-btn text-gray-500 hover:text-gray-700">&times;</button>
                                </div>

                                <div class="flex flex-wrap gap-5.5 p-6.5">
                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Nombre
                                        </label>
                                        <input type="text" placeholder="Ingrese el nombre" name="nombre_equipo" id="nombre_equipo" value="{{ old("nombre_equipo") }}" required autofocus
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Marca
                                        </label>
                                        <input type="text" placeholder="Ingrese la marca" name="marca_equipo" id="marca_equipo" value="{{ old("marca_equipo") }}" required autofocus
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Modelo
                                        </label>
                                        <input type="text" placeholder="Ingrese el modelo" name="modelo_equipo" id="modelo_equipo" value="{{ old("modelo_equipo") }}" required autofocus
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Serie
                                        </label>
                                        <input type="text" placeholder="Ingrese el número de serie" name="serie_equipo" id="serie_equipo" value="{{ old("serie_equipo") }}" required autofocus
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Código patrimonial
                                        </label>
                                        <input type="text" placeholder="Ingrese el código patrimonial" name="cp_equipo" id="cp_equipo" value="{{ old("cp_equipo") }}" required autofocus
                                            class="inputRutaMonto w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Tipo de equipamiento
                                        </label>
                                        <div x-data="{ isOptionSelected: false }"
                                            class="relative z-20 bg-white dark:bg-form-input">
                                            <select
                                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                                :class="isOptionSelected && 'text-black dark:text-white'"
                                                @change="isOptionSelected = true" name="id_tipoEquipamiento" id="id_tipoEquipamiento" required>
                                                @foreach ($tipoEquipamientos as $key => $value)
                                                    <option value="{{$value->id_tipoEquipamiento}}" class="text-body">{{$value->nombre_tipoEquipamiento}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Ambiente
                                        </label>
                                        <div x-data="{ isOptionSelected: false }"
                                            class="relative z-20 bg-white dark:bg-form-input">
                                            <select
                                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                                :class="isOptionSelected && 'text-black dark:text-white'"
                                                @change="isOptionSelected = true" name="id_ambiente_editar" id="id_ambiente_editar" required>
                                                @foreach ($ambientes as $key => $value)
                                                    <option value="{{$value->id_ambiente}}" class="text-body">{{$value->nombre_ambiente}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Fecha de adquisición
                                        </label>
                                        <input type="date" placeholder="Ingrese la fecha de adquisición" name="fecha_adquisicion_equipo" id="fecha_adquisicion_equipo" value="{{ old("fecha_adquisicion_equipo") }}" required autofocus
                                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Monto de adquisición
                                        </label>
                                        <input type="text" placeholder="Ingrese el monto de adquisición" name="monto_adquisicion_equipo" id="monto_adquisicion_equipo" value="{{ old("monto_adquisicion_equipo") }}" required autofocus
                                            class="inputRutaMonto w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Vida útil
                                        </label>
                                        <input type="text" placeholder="Ingrese la vida util (Años)" name="tiempo_vida_util_equipo" id="tiempo_vida_util_equipo" value="{{ old("tiempo_vida_util_equipo") }}" required autofocus maxlength="2"
                                            class="inputRutaMonto w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Prioridad
                                        </label>
                                        <input type="text" placeholder="Ingrese la prioridad" name="prioridad_equipo" id="prioridad_equipo" value="{{ old("prioridad_equipo") }}" required autofocus maxlength="2"
                                            class="inputRutaMonto w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                                    </div>

                                    <div class="w-full-mitad md:w-full">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                                            Estado
                                        </label>
                                        <div x-data="{ isOptionSelected: false }"
                                            class="relative z-20 bg-white dark:bg-form-input">
                                            <select
                                                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                                :class="isOptionSelected && 'text-black dark:text-white'"
                                                @change="isOptionSelected = true" name="estado_editar" id="estado_editar" required>
                                                <option value="0" class="text-body">Servicio</option>
                                            </select>
                                        </div>
                                    </div>

                                    <hr class="pb-2">
                                    <!-- VERIFICAR INICIO -->
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <div class="col-12">
                                                <input type="checkbox" value="1" class="custom-control-input" id="customSwitch1_1" name="criterio1_equipo">
                                                <label class="custom-control-label" for="customSwitch1_1">Se encuentra en estado de conservación malo</label>
                                            </div>
                                        </div>
                                        <div class="custom-control custom-switch">
                                            <div class="col-12">        
                                                <input checked type="checkbox" class="custom-control-input" id="customSwitch2" disabled name="criterio2_equipo">
                                                <label class="custom-control-label" for="customSwitch2">El costo supera el 40% del valor Inicial</label>
                                            </div>
                                        </div>
                                        <div class="custom-control custom-switch">
                                            <div class="col-12">
                                                <input type="checkbox" value="1" class="custom-control-input" id="customSwitch3_1" name="criterio3_equipo">
                                                
                                                <label class="custom-control-label" for="customSwitch3_1">No existe soporte técnico en el Mercado Nacional</label>
                                            </div>
                                        </div>
                                        <div class="custom-control custom-switch">
                                            <div class="col-12">
                                                <input type="checkbox" value="1" class="custom-control-input" id="customSwitch4_1" name="criterio4_equipo">
                                                <label class="custom-control-label" for="customSwitch4_1">Tenga mayores costos de operación comparado con otros similares</label>
                                            </div>
                                        </div>
                                        <div class="custom-control custom-switch">
                                            <div class="col-12">
                                                <input checked type="checkbox" class="custom-control-input" id="customSwitch5" disabled name="criterio5_equipo">
                                                <label class="custom-control-label" for="customSwitch5">Antiguedad mayor al tiempo de vida util</label>
                                            </div>
                                        </div>
                                        <div class="custom-control custom-switch">
                                            <div class="col-12">
                                                <input type="checkbox" value="1" class="custom-control-input" id="customSwitch6_1" name="criterio6_equipo">
                                                <label class="custom-control-label" for="customSwitch6_1">No se encuentre vigente Tecnologicamente</label>
                                            </div>
                                        </div>
                                        <div class="custom-control custom-switch">
                                            <div class="col-12">
                                                <input type="checkbox" value="1" class="custom-control-input" id="customSwitch7_1" name="criterio7_equipo">
                                                <label class="custom-control-label" for="customSwitch7_1">Condición de seguridad</label>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- VERIFICAR FIN -->

                                    <hr class="pb-2">

                                    <div class="w-full" style="text-align:center;">
                                        <div class="btn btn-default btn-file">
                                            <i class="fas fa-paperclip"></i> Adjuntar Foto
                                            <input type="file" name="foto" id="imagen_equipo_editar" onchange="previewImage(event)">
                                        </div><br>

                                        <img id="imagenEquipo" class="previsualizarImg_foto img-fluid py-2 w-25" style="margin:auto;">
                                        <input type="hidden" name="imagen_actual" id="imagen_actual">
                                        <p class="help-block small" style="margin-top:15px;">Dimensiones: 200px * 200px | Peso Max. 2MB | Formato: JPG o PNG</p>
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
                                <input class="datatable-input" placeholder="Escribe para buscar" type="search" title="Search within table" aria-controls="tablaEquipos">
                            </div>
                        </div>
                        <div class="datatable-container">
                            <table class="table w-full table-auto datatable-table" id="tablaEquipos">
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
                                                    <p>Cod. Patrimonial</p>
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
                                                    <p>Tipo Equipamiento</p>
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
                                                    <p>Dir. Ejecutiva</p>
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
                                        <th style="width: 7.931034482758621%;">
                                            <a href="#">
                                                <div class="flex items-center justify-between gap-1.5">
                                                    <p>Ambiente</p>
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
                                                    <p>Fecha (Adquisición)</p>
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
                                                    <p>Monto (Adquisición)</p>
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
                                                    <p># Serie</p>
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
                                                    <p>Antiguedad</p>
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
                                                    <p>Vida Util</p>
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
                                                    <p>Prioridad</p>
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
                                                    <p>Imagen</p>
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
                                                    <p>Tarjeta de Control</p>
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

<div id="imageModal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.8);">
    <span onclick="document.getElementById('imageModal').style.display='none'" style="color: white; font-size: 30px; position: absolute; right: 20px; top: 20px; cursor: pointer;">&times;</span>
    <img id="modalImage" style="margin: auto; display: block; max-width: 80%; max-height: 80%; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%);">
</div>

<script>
    function showImageModal(imageSrc) {
        const modalImage = document.getElementById('modalImage');
        modalImage.src = imageSrc;

        const modal = document.getElementById('imageModal');
        modal.style.display = 'block';
    }

    document.getElementById('imageModal').onclick = function() {
        this.style.display = 'none';
    };
</script>

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
        var table = $('#tablaEquipos').DataTable();

        $('#searchBtn').on('click', function() {
            var nombre              = $('#nombre').val().toLowerCase();
            var marca               = $('#marca').val().toLowerCase();
            var modelo              = $('#modelo').val().toLowerCase();
            var codigo_patrimonial  = $('#codigo_patrimonial').val().toLowerCase();
            var serie               = $('#serie').val().toLowerCase();
            var ambiente            = $('#ambiente').val();

            table.column(1).search(nombre);
            table.column(2).search(marca);
            table.column(3).search(modelo);
            table.column(4).search(codigo_patrimonial);
            table.column(12).search(serie);
            table.column(8).search(ambiente);
            table.draw();
        });

        $('#clearBtn').on('click', function() {
            $('#nombre').val('');
            $('#marca').val('');
            $('#modelo').val('');
            $('#codigo_patrimonial').val('');
            $('#serie').val('');
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
</script>

<script>
    document.getElementById('clearBtn').addEventListener('click', function() {
        document.getElementById('nombre').value = '';
        document.getElementById('marca').value = '';
        document.getElementById('modelo').value = '';
        document.getElementById('codigo_patrimonial').value = '';
        document.getElementById('serie').value = '';
        document.getElementById('ambiente').selectedIndex = 0;
        var table = $('#tablaEquipos').DataTable();
        table.search('').columns().search('').draw();
    });
</script>

@if (Session::has("ok-crear"))
    <script>
        notie.alert({type:1,text:'!El equipo médico ha sido creado correctamente', time:10})
    </script>
@endif

@if (Session::has("cp-existe"))
    <script>
        notie.alert({type:2,text:'!El equipo médico ya existe en nuestros registros', time:10})
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
<script src="{{ url('/') }}/js/equipos.js"></script>
@endsection

@endif
@endforeach