@foreach ($administradores as $element)
            @if ($_COOKIE["email_login"] == $element->email)

@extends('plantilla')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>FORMATO 7.1 FORMATO DE IDENTIFICACIÓN Y EVALUACIÓN DE EQUIPAMIENTO</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url("/") }}">Inicio</a></li>
              <li class="breadcrumb-item active">Formato 7.1</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Default box -->
            <div class="card">
              <div class="card-header">
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#crearEquipoExistente">
                    Extraer Equipo Existente
                </button>
                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#crearEquipoNuevo">
                    Añadir Equipo nuevo
                </button>
                <a href="{{ url('/') }}/reportesFormato7R/formato7Pdf" target="_blank" class="btn btn-success btn-sm" style="float:right;">
                    Exportar a PDF
                </a>

              </div>
              <div class="card-body">

                <table class="table table-bordered table-striped dt-responsive" width="100%"
                 id="defecto">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Equipo</th>
                            <th>Marca</th>
                            <th>Modelo </th>
                            <th># Serie</th>
                            <th>Cod. Patr.</th>
                            <th>Tipo Equipam.</th>
                            <th>Ambiente</th>
                            <th>Fecha (Adquisición)</th>
                            <th>Vida Util</th>
                            <th>Prioridad</th>
                            <th>Proveedor</th>
                            <th>N° Informe/N° Cotización</th>
                            <th>Precio Equipo Nuevo (Actual)</th>
                            <th>Costo Mantenimiento</th>
                            <th>Principales Actividades</th>
                            <th>Prioridad Multianual</th>
                            <th>Orden de Prelación</th>
                            <th>Acciones</th>
                        </tr>

                    </thead>

                    <tbody>

                    @foreach($listadoFormato7 as $key => $data)
                        <tr>
                            <td style="text-align: center;">{{($key+1)}}</td>
                            <td style="text-transform: uppercase;">
                                @if($data->id_equipoExterno == '')
                                    {{$data->nombre_equipo}}
                                @else
                                    {{$data->nombre_equipoExterno}}
                                @endif
                            </td>
                            <td style="text-align: center; text-transform: uppercase;">
                                @if($data->id_equipoExterno == '')
                                    {{$data->marca_equipo}}
                                @else
                                    {{$data->marca_equipoExterno}}
                                @endif
                            </td>
                            <td style="text-align: center; text-transform: uppercase;">
                                @if($data->id_equipoExterno == '')
                                    {{$data->modelo_equipo}}
                                @else
                                    {{$data->modelo_equipoExterno}}
                                @endif
                            </td>
                            <td style="text-align: center; text-transform: uppercase;">
                                @if($data->id_equipoExterno == '')
                                    {{$data->serie_equipo}}
                                @else
                                    {{$data->serie_equipoExterno}}
                                @endif
                            </td>
                            <td style="text-align: center; text-transform: uppercase;">
                                @if($data->id_equipoExterno == '')
                                    {{$data->cp_equipo}}
                                @else
                                    {{$data->cp_equipoExterno}}
                                @endif
                            </td>
                            <td style="text-align: center; text-transform: uppercase;">
                                @if($data->id_equipoExterno == '')
                                    {{$data->tipoEquipamientoEquipo}}
                                @else
                                    {{$data->tipoEquipamientoEquipoExterno}}
                                @endif
                            </td>
                            <td style="text-align: center; text-transform: uppercase;">
                                @if($data->id_equipoExterno == '')
                                    {{$data->ambienteEquipo}}
                                @else
                                    {{$data->ambienteEquipoExterno}}
                                @endif
                            </td>
                            <td style="text-align: center; text-transform: uppercase;">
                                @if($data->id_equipoExterno == '')
                                    {{ \Carbon\Carbon::parse($data->fecha_adquisicion_equipo)->format('d-m-Y')}}
                                @else
                                    {{ \Carbon\Carbon::parse($data->fecha_adquisicion_equipoExterno)->format('d-m-Y')}}
                                @endif
                            </td>
                            <td style="text-align: center; text-transform: uppercase;">
                                @if($data->id_equipoExterno == '')
                                    {{$data->tiempo_vida_util_equipo}}
                                @else
                                    {{$data->tiempo_vida_util_equipoExterno}}
                                @endif
                            </td>
                            <td style="text-align: center; text-transform: uppercase;">
                                @if($data->id_equipoExterno == '')
                                    {{$data->prioridad_equipo}}
                                @else
                                    {{$data->prioridad_equipoExterno}}
                                @endif
                            </td>
                            <td style="text-align: center; text-transform: uppercase;">
                                @if($data->id_proveedor == '')
                                    {{$data->nombre_proveedor2}}
                                @else
                                    {{$data->razonSocial_proveedor}}
                                @endif
                            </td>
                            <td style="text-align: center; text-transform: uppercase;">
                                @if($data->id_ordenServicio == '')
                                    {{$data->nombre_informe2}}
                                @else
                                    ORDEN DE SERVICIO N° {{$data->codigo_ordenServicio}}
                                @endif
                            </td>
                            <td style="text-align: center; text-transform: uppercase;">
                                {{$data->precio_equipoNuevo}}
                            </td>
                            <td style="text-align: center; text-transform: uppercase;">
                                {{$data->costo_mantenimiento}}
                            </td>
                            <td style="text-align: center; text-transform: uppercase;">
                                {{$data->actividades_principales}}
                            </td>
                            <td style="text-align: center; text-transform: uppercase;">
                                {{$data->prioridad_multianual}}
                            </td>
                            <td style="text-align: center; text-transform: uppercase;">
                                {{$data->orden_prelacion}}
                            </td>
                            <td style="text-align: center;">
                                <div class="btn-group">
                                    @if($data->id_equipoExterno == '')
                                        <a href="{{url('/')}}/reportesFormato7/{{$data->id_formato7}}/{{$data->id_equipo}}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-pencil-alt text-white"></i>
                                        </a>
                                    @else
                                        <a href="{{url('/')}}/reportesFormato7/{{$data->id_formato7}}/{{$data->id_equipoExterno}}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-pencil-alt text-white"></i>
                                        </a>
                                    @endif

                                    <button class="btn btn-danger btn-sm eliminarRegistro" action="{{url('/')}}/reportesFormato7/{{$data->id_formato7}}"
                                        method="DELETE" pagina="reportesFormato7" token="{{ csrf_token() }}">
                                        <!-- @csrf -->
                                        <i class="fas fa-trash-alt text-white"></i>
                                    </button>

                                </div>
                            </td>

                        </tr>
                    @endforeach

                    </tbody>
                </table>

              </div>
              <!-- /.card-body -->

              <!-- /.card-footer-->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
</div>

<div class="modal" id="crearEquipoNuevo">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ url('/') }}/reportesFormato7">
                @csrf

                <div class="modal-header bg-info">
                    <h4 class="modal-tittle">Añadir equipo Nuevo</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Nombre:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" name="nombre_equipo"
                            value="{{ old("nombre_equipo") }}" required autofocus
                            placeholder="Ingrese el nombre" style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin nombre de equipo medico --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Marca:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" name="marca_equipo"
                            value="{{ old("marca_equipo") }}" required autofocus
                            placeholder="Ingrese la marca" style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin marca de equipo medico --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Modelo:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" name="modelo_equipo"
                            value="{{ old("modelo_equipo") }}" required autofocus
                            placeholder="Ingrese el modelo" style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin modelo de equipo medico --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Serie:</label>

                        <div class="col-md-7">
                            <input type="text" class="form-control" name="serie_equipo"
                            value="{{ old("serie_equipo") }}" required autofocus
                            placeholder="Ingrese el número de serie" style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin serie de equipo medico --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Cod. Patrim:</label>

                        <div class="col-md-7">
                            <input type="text" class="form-control" name="cp_equipo"
                            value="{{ old("cp_equipo") }}" required autofocus
                            placeholder="Ingrese el código Patrimonial" style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin cp de equipo medico --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">T. Equipam:</label>

                        <div class="col-md-8">
                            <select class="form-control" name="id_tipoEquipamiento" required style="text-transform: uppercase;">
                                <option value="">
                                    -- Seleccionar el Tipo de Equipamiento --
                                </option>

                                @foreach ($tipoEquipamientos as $key => $value)
                                    <option value="{{$value->id_tipoEquipamiento}}">
                                        {{$value->nombre_tipoEquipamiento}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>{{-- fin id de departamento --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Ambiente:</label>

                        <div class="col-md-8">
                            <select class="form-control" name="id_ambiente" required style="text-transform: uppercase;">
                                <option value="">
                                    -- Seleccionar el Ambiente --
                                </option>

                                @foreach ($ambientes as $key => $value)
                                    <option value="{{$value->id_ambiente}}">
                                        {{$value->nombre_ambiente}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>{{-- fin id de departamento --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Fecha Adquis:</label>

                        <div class="col-md-7">
                            <input type="date" class="form-control" name="fecha_adquisicion_equipo"
                            value="{{ old("fecha_adquisicion_equipo") }}" required autofocus
                            style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin FECHA DE ADQUISICIONS --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Vida Util:</label>

                        <div class="col-md-7">
                            <input type="text" class="form-control inputRuta" name="tiempo_vida_util_equipo"
                            value="{{ old("tiempo_vida_util_equipo") }}" required autofocus
                            placeholder="Ingrese la vida util (Años)" style="text-transform: uppercase;" maxlength="2">
                        </div>
                    </div>{{-- fin vida util de equipo medico --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Prioridad:</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control inputRuta" name="prioridad_equipo"
                            value="{{ old("prioridad_equipo") }}" required autofocus
                            placeholder="Ingrese la prioridad" style="text-transform: uppercase;" maxlength="2">
                        </div>
                    </div>{{-- fin prioridad de equipo medico --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Proveedor:</label>

                        <div class="col-md-8">
                            <select class="form-control" name="nombre_proveedor1" style="text-transform: uppercase;margin-bottom: 5px;">
                                <option value="">
                                    -- Seleccionar el Proveedor --
                                </option>

                                @foreach ($proveedores as $key => $value)
                                    <option value="{{$value->id_proveedor}}">
                                        {{$value->razonSocial_proveedor}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-1" style="text-align:center;margin:auto;">o</div>

                        <label for="email" class="col-md-3 control-label" style="color:white;">Proveedor:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" name="nombre_proveedor2"
                            value="{{ old("nombre_proveedor") }}" autofocus
                            placeholder="Ingrese el proveedor" style="text-transform: uppercase;">
                        </div>

                    </div>{{-- fin id de proveedor --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">N° Inf./N° Cot:</label>

                        <div class="col-md-8">
                            <select class="form-control" name="nombre_informe1" style="text-transform: uppercase;margin-bottom: 5px;">
                                <option value="">
                                    -- Seleccionar la orden de Serv. --
                                </option>

                                @foreach ($ordenServicios as $key => $value)
                                    <option value="{{$value->id_ordenServicio}}">
                                        {{$value->codigo_ordenServicio}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-1" style="text-align:center;margin:auto;">o</div>

                        <label for="email" class="col-md-3 control-label" style="color:white;">N° Inf./N° Cot:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" name="nombre_informe2"
                            value="{{ old("nombre_informe2") }}" autofocus
                            placeholder="Ingrese el N° de Informe o Cotiz." style="text-transform: uppercase;">
                        </div>

                    </div>{{-- fin id de ORDENSERVICIO--}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">P. Eq. Nuevo:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control inputRutaMonto" name="precio_equipoNuevo"
                            value="{{ old("precio_equipoNuevo") }}" required autofocus
                            placeholder="Ingrese el precio de equipo Nuevo" style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin precio equipo nuevo --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Costo Mnto:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control inputRutaMonto" name="costo_mantenimiento"
                            value="{{ old("costo_mantenimiento") }}" required autofocus
                            placeholder="Ingrese el costo de Mantenimiento" style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin precio equipo nuevo --}}

                    {{-- Actividades Principales --}}
                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Actividades Principales:</label>

                        <div class="col-md-8">
                            <textarea class="form-control" name="actividades_principales" autofocus style="text-transform: uppercase;"></textarea>
                        </div>
                    </div>{{-- Fin Actividades Principales --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Prd. M.Anual:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control inputRuta" name="prioridad_multianual"
                            value="{{ old("prioridad_multianual") }}" required autofocus
                            placeholder="Ingrese la prioridad Multianual" style="text-transform: uppercase;" maxlength="4">
                        </div>
                    </div>{{-- fin prioridad multianual --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Ord. Prelac:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control inputRuta" name="orden_prelacion"
                            value="{{ old("orden_prelacion") }}" autofocus
                            placeholder="Ingrese la orden de Prelación" style="text-transform: uppercase;" maxlength="2">
                        </div>
                    </div>{{-- fin orden prelación --}}

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

<div class="modal" id="crearEquipoExistente">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ url('/') }}/reportesFormato7">
                @csrf

                <div class="modal-header bg-info">
                    <h4 class="modal-tittle">Añadir equipo Nuevo</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Equipo:</label>

                        <div class="col-md-8">
                            <select class="form-control select2" name="id_equipo" required style="text-transform: uppercase;">
                                <option value="">
                                    -- Seleccionar el Equipo --
                                </option>

                                @foreach ($equipos as $key => $value)
                                    <option value="{{$value->id_equipo}}">
                                        {{$value->nombre_equipo}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>{{-- fin id de departamento --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Proveedor:</label>

                        <div class="col-md-8">
                            <select class="form-control" name="nombre_proveedor1" style="text-transform: uppercase;margin-bottom: 5px;">
                                <option value="">
                                    -- Seleccionar el Proveedor --
                                </option>

                                @foreach ($proveedores as $key => $value)
                                    <option value="{{$value->id_proveedor}}">
                                        {{$value->razonSocial_proveedor}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-1" style="text-align:center;margin:auto;">o</div>

                        <label for="email" class="col-md-3 control-label" style="color:white;">Proveedor:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" name="nombre_proveedor2"
                            value="{{ old("nombre_proveedor") }}" autofocus
                            placeholder="Ingrese el proveedor" style="text-transform: uppercase;">
                        </div>

                    </div>{{-- fin id de proveedor --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">N° Inf./N° Cot:</label>

                        <div class="col-md-8">
                            <select class="form-control" name="nombre_informe1" style="text-transform: uppercase;margin-bottom: 5px;">
                                <option value="">
                                    -- Seleccionar la orden de Serv. --
                                </option>

                                @foreach ($ordenServicios as $key => $value)
                                    <option value="{{$value->id_ordenServicio}}">
                                        {{$value->codigo_ordenServicio}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-1" style="text-align:center;margin:auto;">o</div>

                        <label for="email" class="col-md-3 control-label" style="color:white;">N° Inf./N° Cot:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" name="nombre_informe2"
                            value="{{ old("nombre_informe2") }}" autofocus
                            placeholder="Ingrese el N° de Informe o Cotiz." style="text-transform: uppercase;">
                        </div>

                    </div>{{-- fin id de ORDENSERVICIO--}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">P. Eq. Nuevo:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control inputRutaMonto" name="precio_equipoNuevo"
                            value="{{ old("precio_equipoNuevo") }}" required autofocus
                            placeholder="Ingrese el precio de equipo Nuevo" style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin precio equipo nuevo --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Costo Mnto:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control inputRutaMonto" name="costo_mantenimiento"
                            value="{{ old("costo_mantenimiento") }}" required autofocus
                            placeholder="Ingrese el costo de Mantenimiento" style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin precio equipo nuevo --}}

                    {{-- Actividades Principales --}}
                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Actividades Principales:</label>

                        <div class="col-md-8">
                            <textarea class="form-control" name="actividades_principales" autofocus style="text-transform: uppercase;"></textarea>
                        </div>
                    </div>{{-- Fin Actividades Principales --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Prd. M.Anual:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control inputRuta" name="prioridad_multianual"
                            value="{{ old("prioridad_multianual") }}" required autofocus
                            placeholder="Ingrese la prioridad Multianual" style="text-transform: uppercase;" maxlength="4">
                        </div>
                    </div>{{-- fin prioridad multianual --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Ord. Prelac:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control inputRuta" name="orden_prelacion"
                            value="{{ old("orden_prelacion") }}" autofocus
                            placeholder="Ingrese la orden de Prelación" style="text-transform: uppercase;" maxlength="2">
                        </div>
                    </div>{{-- fin orden prelación --}}

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

{{-- Editar formato7 en modal --}}

@if (isset($status))

@if ($status == 200)

    @foreach ($formato7 as $key => $value)

    <div class="modal" id="editarFormato7">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ url('/') }}/reportesFormato7/{{ $value->id_formato7 }}"
                enctype="multipart/form-data">

                @method('PUT')
                @csrf

                <div class="modal-header bg-info">
                    <h4 class="modal-tittle">Editar Equipo Médico</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="input-group mb-3" style="display:none;">
                        <label for="email" class="col-md-3 control-label">ID:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" name="id_equipo"
                            value="{{ $value->id_equipo }}" autofocus
                            style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin id equipo --}}

                    <div class="input-group mb-3" style="display:none;">
                        <label for="email" class="col-md-3 control-label">ID:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" name="id_equipoExterno"
                            value="{{ $value->id_equipoExterno }}" autofocus
                            style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin id equipo externo --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Nombre:</label>

                        <div class="col-md-8">
                            @if($value->id_equipo == '')
                            <input type="text" class="form-control" name="nombre_equipo"
                            value="{{ $value->nombre_equipoExterno }}" required autofocus
                            style="text-transform: uppercase;">
                            @else
                            <input type="text" class="form-control" name="nombre_equipo"
                            value="{{ $value->nombre_equipo }}" required autofocus
                            style="text-transform: uppercase;" readonly="">
                            @endif
                        </div>
                    </div>{{-- fin nombre de equipo medico --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Marca:</label>

                        <div class="col-md-8">
                            @if($value->id_equipo == '')
                            <input type="text" class="form-control" name="marca_equipo"
                            value="{{ $value->marca_equipoExterno }}" required autofocus
                            style="text-transform: uppercase;">
                            @else
                            <input type="text" class="form-control" name="marca_equipo"
                            value="{{ $value->marca_equipo }}" required autofocus
                            style="text-transform: uppercase;" readonly="">
                            @endif
                        </div>
                    </div>{{-- fin marca de equipo medico --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Modelo:</label>

                        <div class="col-md-8">
                            @if($value->id_equipo == '')
                            <input type="text" class="form-control" name="modelo_equipo"
                            value="{{ $value->modelo_equipoExterno }}" required autofocus
                            style="text-transform: uppercase;">
                            @else
                            <input type="text" class="form-control" name="modelo_equipo"
                            value="{{ $value->marca_equipo }}" required autofocus
                            style="text-transform: uppercase;" readonly="">
                            @endif
                        </div>
                    </div>{{-- fin modelo de equipo medico --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Serie:</label>

                        <div class="col-md-7">
                            @if($value->id_equipo == '')
                            <input type="text" class="form-control" name="serie_equipo"
                            value="{{ $value->serie_equipoExterno }}" required autofocus
                            placeholder="Ingrese el número de serie" style="text-transform: uppercase;">
                            @else
                            <input type="text" class="form-control" name="serie_equipo"
                            value="{{ $value->serie_equipo }}" required autofocus
                            placeholder="Ingrese el número de serie" style="text-transform: uppercase;" readonly="">
                            @endif
                        </div>
                    </div>{{-- fin serie de equipo medico --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Cod. Patrim:</label>

                        <div class="col-md-7">
                            @if($value->id_equipo == '')
                            <input type="text" class="form-control" name="cp_equipo"
                            value="{{ $value->cp_equipoExterno }}" required autofocus
                            placeholder="Ingrese el código Patrimonial" style="text-transform: uppercase;">
                            @else
                            <input type="text" class="form-control" name="cp_equipo"
                            value="{{ $value->cp_equipo }}" required autofocus
                            placeholder="Ingrese el código Patrimonial" style="text-transform: uppercase;" readonly="">
                            @endif
                        </div>
                    </div>{{-- fin cp de equipo medico --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">T. Equipam:</label>

                        <div class="col-md-8">
                            <select class="form-control" name="id_tipoEquipamiento" required style="text-transform: uppercase;">

                                    @if($value->id_equipo == '')
                                    <option value="{{$value->id_tipoEquipamientoEquipoExterno}}">
                                        {{$value->nombre_tipoEquipamientoEquipoExterno}}
                                    </option>

                                    @foreach ($tipoEquipamientos as $key => $value2)
                                        @if ($value2->id_tipoEquipamiento != $value->id_tipoEquipamientoEquipoExterno)
                                            <option value="{{$value2->id_tipoEquipamiento}}">
                                                {{$value2->nombre_tipoEquipamiento}}
                                            </option>
                                        @endif{{-- Aparece todo menos el que es diferente --}}
                                    @endforeach

                                @else
                                    <option value="{{$value->id_tipoEquipamientoEquipo}}">
                                        {{$value->nombre_tipoEquipamientoEquipo}}
                                    </option>

                                @endif

                            </select>
                        </div>
                    </div>{{-- fin id de tipo de equipamiento --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Ambiente:</label>

                        <div class="col-md-8">
                            <select class="form-control" name="id_ambiente" required style="text-transform: uppercase;">
                                @if($value->id_equipo == '')
                                    <option value="{{$value->id_ambienteEquipoExterno}}">
                                        {{$value->ambienteEquipoExterno}}
                                    </option>

                                    @foreach ($ambientes as $key => $value2)
                                        @if ($value2->id_ambiente != $value->id_ambienteEquipoExterno)
                                            <option value="{{$value2->id_ambiente}}">
                                                {{$value2->nombre_ambiente}}
                                            </option>
                                        @endif{{-- Aparece todo menos el que es diferente --}}
                                    @endforeach

                                @else
                                    <option value="{{$value->id_ambienteEquipo}}" readonly="">
                                        {{$value->ambienteEquipo}}
                                    </option>

                                @endif

                            </select>
                        </div>
                    </div>{{-- fin id de ambiente --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Fecha Adquis:</label>

                        <div class="col-md-7">
                            @if($value->id_equipo == '')
                            <input type="date" class="form-control" name="fecha_adquisicion_equipo"
                            value="{{ $value->fecha_adquisicion_equipoExterno }}" required autofocus
                            style="text-transform: uppercase;">
                            @else
                            <input type="date" class="form-control" name="fecha_adquisicion_equipo"
                            value="{{ $value->fecha_adquisicion_equipo }}" required autofocus
                            style="text-transform: uppercase;" readonly="">
                            @endif
                        </div>
                    </div>{{-- fin FECHA DE ADQUISICIONS --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Vida Util:</label>

                        <div class="col-md-7">
                            @if($value->id_equipo == '')
                            <input type="text" class="form-control inputRuta" name="tiempo_vida_util_equipo"
                            value="{{ $value->tiempo_vida_util_equipoExterno }}" required autofocus
                            style="text-transform: uppercase;" maxlength="2">
                            @else
                            <input type="text" class="form-control inputRuta" name="tiempo_vida_util_equipo"
                            value="{{ $value->tiempo_vida_util_equipo }}" required autofocus
                            style="text-transform: uppercase;" maxlength="2" readonly="">
                            @endif
                        </div>
                    </div>{{-- fin vida util de equipo medico --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Prioridad:</label>

                        <div class="col-md-6">
                            @if($value->id_equipo == '')
                            <input type="text" class="form-control inputRuta" name="prioridad_equipo"
                            value="{{ $value->prioridad_equipoExterno }}" required autofocus
                            style="text-transform: uppercase;" maxlength="2">
                            @else
                            <input type="text" class="form-control inputRuta" name="prioridad_equipo"
                            value="{{ $value->prioridad_equipo }}" required autofocus
                            style="text-transform: uppercase;" maxlength="2" readonly="">
                            @endif
                        </div>
                    </div>{{-- fin prioridad de equipo medico --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Proveedor:</label>

                        <div class="col-md-8">
                            <select class="form-control" name="nombre_proveedor1" style="text-transform: uppercase;margin-bottom: 5px;">
                                    @if($value->id_proveedor == '')
                                    <option value="">
                                        -- Seleccionar el Proveedor --
                                    </option>
                                    @else
                                    <option value="{{$value->id_proveedor}}">
                                        {{$value->razonSocial_proveedor}}
                                    </option>
                                    @endif

                                    @foreach ($proveedores as $key => $value2)
                                        @if ($value2->id_proveedor != $value->id_proveedor)
                                            <option value="{{$value2->id_proveedor}}">
                                                {{$value2->razonSocial_proveedor}}
                                            </option>
                                        @endif{{-- Aparece todo menos el que es diferente --}}
                                    @endforeach
                            </select>
                        </div>

                        <div class="col-md-1" style="text-align:center;margin:auto;">o</div>

                        <label for="email" class="col-md-3 control-label" style="color:white;">Proveedor:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" name="nombre_proveedor2"
                            value="{{ $value->nombre_proveedor2 }}" autofocus
                            placeholder="Ingrese el proveedor" style="text-transform: uppercase;">
                        </div>

                    </div>{{-- fin id de proveedor --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">N° Inf./N° Cot:</label>

                        <div class="col-md-8">
                            <select class="form-control" name="nombre_informe1" style="text-transform: uppercase;margin-bottom: 5px;">
                                @if($value->id_proveedor == '')
                                    <option value="">
                                        -- Seleccionar el Proveedor --
                                    </option>
                                @else
                                    <option value="{{$value->id_ordenServicio}}">
                                        {{$value->codigo_ordenServicio}}
                                    </option>
                                @endif

                                @foreach ($ordenServicios as $key => $value2)
                                        @if ($value2->id_ordenServicio != $value->id_ordenServicio)
                                            <option value="{{$value2->id_ordenServicio}}">
                                                {{$value2->codigo_ordenServicio}}
                                            </option>
                                        @endif{{-- Aparece todo menos el que es diferente --}}
                                    @endforeach
                            </select>
                        </div>

                        <div class="col-md-1" style="text-align:center;margin:auto;">o</div>

                        <label for="email" class="col-md-3 control-label" style="color:white;">N° Inf./N° Cot:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" name="nombre_informe2"
                            value="{{ $value->nombre_informe2 }}" autofocus
                            placeholder="Ingrese el N° de Informe o Cotiz." style="text-transform: uppercase;">
                        </div>

                    </div>{{-- fin id de ORDENSERVICIO--}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">P. Eq. Nuevo:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control inputRutaMonto" name="precio_equipoNuevo"
                            value="{{ $value->precio_equipoNuevo}}" required autofocus
                            style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin precio equipo nuevo --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Costo Mnto:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control inputRutaMonto" name="costo_mantenimiento"
                            value="{{ $value->costo_mantenimiento }}" required autofocus
                            style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin precio equipo nuevo --}}

                    {{-- Actividades Principales --}}
                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Actividades Principales:</label>

                        <div class="col-md-8">
                            <textarea class="form-control" name="actividades_principales" autofocus
                            style="text-transform: uppercase;">{{$implode_actividades_principales}}</textarea>
                        </div>
                    </div>{{-- Fin Actividades Principales --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Prd. M.Anual:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control inputRuta" name="prioridad_multianual"
                            value="{{ $value->prioridad_multianual }}" required autofocus
                            style="text-transform: uppercase;" maxlength="4">
                        </div>
                    </div>{{-- fin prioridad multianual --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Ord. Prelac:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control inputRuta" name="orden_prelacion"
                            value="{{ $value->orden_prelacion }}" autofocus
                            placeholder="Ingrese la orden de Prelación" style="text-transform: uppercase;" maxlength="2">
                        </div>
                    </div>{{-- fin orden prelación --}}


                    <div class="form-group">
                        <p style="text-align:center;font-weight: 900;text-decoration: underline;">CRITERIOS DE REPOSICIÓN DE EQUIPOS</p>

                        @if($value->id_equipo == '')
                        <div class="custom-control custom-switch">
                            <div class="col-12">
                                <input type="checkbox" value="1" class="custom-control-input" id="customSwitch6" name="criterio_2"
                                {{ ($value->criterio_2 == 1 ? 'checked' : '')}}>
                                <label class="custom-control-label" for="customSwitch6">El costo de mantenimiento acumulado hasta el momento
                                de la evaluación, no supere el 40% del valor del equipamiento</label>
                            </div>
                        </div>
                        @endif

                        <div class="custom-control custom-switch">
                            <div class="col-12">
                                <input type="checkbox" value="1" class="custom-control-input" id="customSwitch3" name="criterio_3"
                                {{ ($value->criterio_3 == 1 ? 'checked' : '')}}>
                                <label class="custom-control-label" for="customSwitch3">Se encuentra funcionando, rinde o cumple
                                según estándar o especificación de fábrica</label>
                            </div>
                        </div>

                        <div class="custom-control custom-switch">
                            <div class="col-12">
                                <input type="checkbox" value="1" class="custom-control-input" id="customSwitch4" name="criterio_4"
                                {{ ($value->criterio_4 == 1 ? 'checked' : '')}}>
                                <label class="custom-control-label" for="customSwitch4">Se encuentra funcionando, pero NO rinde o
                                cumple según estándar o especificación de fábrica</label>
                            </div>
                        </div>

                        <div class="custom-control custom-switch">
                            <div class="col-12">
                                <input type="checkbox" value="1" class="custom-control-input" id="customSwitch1" name="criterio_5"
                                {{ ($value->criterio_5 == 1 ? 'checked' : '')}}>
                                <label class="custom-control-label" for="customSwitch1">No se encuentra funcionando por defectos
                                técnicos propios del bien</label>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="modal-footer d-flex justify-content-between">
                    <div>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>

                    <div>
                        <button type="submit" id="boton_equipo" class="btn btn-primary">Guardar</button>
                    </div>
                </div>

            </form>
          </div>
        </div>

    </div>

    @endforeach

    <script>
        $("#editarFormato7").modal();
    </script>

  @else

  {{$status}}

@endif

@endif

@if (Session::has("ok-crear"))
  <script>
      notie.alert({type:1,text:'!El Equipo Nuevo ha sido creado correctamente', time:10})
  </script>
@endif

@if (Session::has("equipo-existe"))
  <script>
      notie.alert({type:2,text:'!El Equipo ya existe en la lista mostrada', time:10})
  </script>
@endif

@if (Session::has("no-validacion"))
  <script>
      notie.alert({type:2,text:'!Hay campos no válidos en el formulario', time:10})
  </script>
@endif

@if (Session::has("error"))
  <script>
      notie.alert({type:3,text:'!Error en el gestor de Equipos Nuevos', time:10})
  </script>
@endif

@if (Session::has("ok-editar"))
  <script>
      notie.alert({type:1,text:'!El Equipo Nuevo ha sido actualizado correctamente', time:10})
  </script>
@endif

@if (Session::has("ok-eliminar"))

<script>
    notie.alert({ type: 1, text: '¡El Equipo Nuevo ha sido eliminado correctamente!', time: 10 })
</script>

@endif

@if (Session::has("no-borrar"))

<script>
    notie.alert({ type: 2, text: '¡Este administrador no se puede borrar!', time: 10 })
</script>

@endif

@endsection

@endif

@endforeach
