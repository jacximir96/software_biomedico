@foreach ($administradores as $element)
            @if ($_COOKIE["email_login"] == $element->email)

@extends('plantilla')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
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
                    id="defecto">
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

                    <tbody>
                        @foreach ($cronogramas_fecha as $key => $data)
                            <tr>
                                <th>{{($key+1)}}</th>
                                <td>{{$data->nombre_equipo}}</td>
                                <td>{{$data->cp_equipo}}</td>
                                <td>{{$data->nombre_mantenimiento}}</td>
                                <td>{{ \Carbon\Carbon::parse($data->fecha)->format('d-m-Y')}}</td>
                                <td>{{ \Carbon\Carbon::parse($data->fecha_final)->format('d-m-Y')}}</td>
                                <td style="text-align: center;">
                                    <div class="btn-group">
                                        <a href="{{url('/')}}/cronogramasLista/{{$data->id_cronograma}}" class="btn btn-warning btn-sm">
                                            Registrar
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            </div>
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
                        {{-- @foreach($cronogramas_general as $key => $valor_cronogramas_general)
                        <tr>
                            <td style="text-align: center;">{{($key+1)}}</td>
                            <td style="text-align: center; text-transform: uppercase;">{{$valor_cronogramas_general->nombre_equipo}}</td>
                            <td style="text-align: center; text-transform: uppercase;">{{$valor_cronogramas_general->cp_equipo}}</td>
                            <td style="text-align: center; text-transform: uppercase;">{{$valor_cronogramas_general->nombre_mantenimiento}}</td>
                            <td style="text-align: center; text-transform: uppercase;">{{ \Carbon\Carbon::parse($valor_cronogramas_general->fecha)->format('d-m-Y')}}</td>
                            <td style="text-align: center; text-transform: uppercase;">{{ \Carbon\Carbon::parse($valor_cronogramas_general->fecha_final)->format('d-m-Y')}}</td>
                            <td style="text-align: center; text-transform: uppercase;">
                                @if($valor_cronogramas_general->codigo_ordenServicio == '' AND $valor_cronogramas_general->realizado == 1)
                                    {{$valor_cronogramas_general->otm_cronograma}}
                                @else
                                    {{$valor_cronogramas_general->codigo_ordenServicio}}
                                @endif
                            </td>
                            <td style="text-align: center; text-transform: uppercase;">{{$valor_cronogramas_general->ruc_proveedor}}</td>
                            <td style="text-align: center; text-transform: uppercase;">
                                @if($valor_cronogramas_general->iniciales_departamento == '' AND $valor_cronogramas_general->realizado == 1)
                                    {{$valor_cronogramas_general->iniciales_direccionEjecutiva}}
                                @else
                                    {{$valor_cronogramas_general->iniciales_departamento}}
                                @endif
                            </td>
                            <td style="text-align: center; text-transform: uppercase;">{{$valor_cronogramas_general->garantia}} meses</td>
                            <td style="text-align: center; text-transform: uppercase;">{{$valor_cronogramas_general->observacion}}</td>
                            <td style="text-align: center; text-transform: uppercase;">S/. {{number_format($valor_cronogramas_general->monto_cronograma, 2)}}</td>
                            <td style="text-align: center; text-transform: uppercase;">
                                <a href="../storage/app/{{$valor_cronogramas_general->pdf_cronograma}}" download="Conformidad del Servicio" class="btn btn-default btn-sm" >
                                    <i class="fas fa-download text-black"></i> Descargar Archivo
                                </a>
                            </td>
                            <td style="text-align: center; text-transform: uppercase;">
                                @if($valor_cronogramas_general->realizado == NULL)
                                    <span style="color:red;">NO REALIZADO</span>
                                @elseif($valor_cronogramas_general->realizado == 1)
                                    <span style="color:green;">REALIZADO</span>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <div class="btn-group">
                                        
                                    <button class="btn btn-warning btn-sm editar-btn" data-toggle="modal" data-target="#editarModalCronograma" data-id="' +data+'"><i class="fas fa-pencil-alt text-white"></i></button>




                                    <form method="POST" id="frmVerDa" action="{{url('/')}}/cronogramasLista/editar">
                                        @csrf
                                     
                                        <button style="width:100%;font-weight:400;" type="submit" class="btn btn-warning btn-sm"> 
							            <i class="fas fa-pencil-alt text-white"></i></button>
                                    </form>

                                    <button class="btn btn-danger btn-sm eliminarRegistro" action="{{url('/')}}/cronogramasLista/{{$valor_cronogramas_general->id_cronograma}}"
                                        method="DELETE" pagina="cronogramasLista" token="{{ csrf_token() }}">
                                        <i class="fas fa-trash-alt text-white"></i>
                                    </button>

                                </div>
                            </td>
                        </tr>
                        @endforeach --}}
                   

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
                        <!-- Inicio de Fecha -->
                        <div class="input-group mb-3">
                            <label for="email" class="col-md-3 control-label">Fecha Inicial:</label>
        
                            <div class="col-md-8">
                                <input id="fecha_actual_editar" name="fecha_actual" type="date" class="form-control">
        
                            </div>
                        </div><!-- Fin de fecha -->
        
                        <!-- Inicio de Fecha final -->
                        <div class="input-group mb-3">
                            <label for="email" class="col-md-3 control-label">Fecha Final:</label>
        
                            <div class="col-md-8">
                                <input id="fecha_final_editar" name="fecha_final" type="date" class="form-control">
        
                            </div>
                        </div><!-- Fin de fecha -->
        
                        <!-- Inicio de Equipo -->
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
                        </div><!-- Fin de Equipo -->
        
                        {{-- Realizado --}}
                            <div class="input-group mb-3" style="display:none;">
        
                                <label for="email" class="col-md-3 control-label">Realizado:</label>
        
                                <div class="col-md-6">
                                    <input class="form-control" name="realizado_crear"
                                    value="0" required autofocus
                                    style="text-transform: uppercase;" readonly="">
                                </div>
                            </div>{{-- fin Realizado --}}
        
                        <!-- Inicio de Mantenimiento -->
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
                        </div><!-- Fin de Mantenimiento -->
        
                        <!-- Inicio de Garantia -->
                        <div class="input-group mb-3" id="valor_garantia">
                            <label for="email" class="col-md-3 control-label">Garantía:</label>
        
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="garantia"
                                value="0" autofocus
                                placeholder="Ingrese la garantía (Meses)" style="text-transform: uppercase;" maxlength="2">
                            </div>
                        </div><!-- Fin de Garantia -->
        
                    
        
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















{{-- Agregar calendario en modal --}}
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

                <!-- Inicio de Fecha -->
                <div class="input-group mb-3">
                    <label for="email" class="col-md-3 control-label">Fecha Inicial:</label>

                    <div class="col-md-8">
                        <input id="fecha_actual_calendario" name="fecha_actual" type="date" class="form-control">

                    </div>
                </div><!-- Fin de fecha -->

                <!-- Inicio de Fecha final -->
                <div class="input-group mb-3">
                    <label for="email" class="col-md-3 control-label">Fecha Final:</label>

                    <div class="col-md-8">
                        <input id="fecha_final_calendario" name="fecha_final" type="date" class="form-control">

                    </div>
                </div><!-- Fin de fecha -->

                <!-- Inicio de Equipo -->
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
                </div><!-- Fin de Equipo -->

                {{-- Realizado --}}
                    <div class="input-group mb-3" style="display:none;">

                        <label for="email" class="col-md-3 control-label">Realizado:</label>

                        <div class="col-md-6">
                            <input class="form-control" name="realizado_crear"
                            value="0" required autofocus
                            style="text-transform: uppercase;" readonly="">
                        </div>
                    </div>{{-- fin Realizado --}}

                <!-- Inicio de Mantenimiento -->
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
                </div><!-- Fin de Mantenimiento -->

                <!-- Inicio de Garantia -->
                <div class="input-group mb-3" id="valor_garantia">
                    <label for="email" class="col-md-3 control-label">Garantía:</label>

                    <div class="col-md-4">
                        <input type="text" class="form-control" name="garantia"
                        value="0" autofocus
                        placeholder="Ingrese la garantía (Meses)" style="text-transform: uppercase;" maxlength="2">
                    </div>
                </div><!-- Fin de Garantia -->

            </div><!-- Fin del modal-body -->

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

{{-- Editar departamento en modal --}}

{{-- @if (isset($status))

@if ($status == 200)

    @foreach ($cronograma as $key => $value)

    <div class="modal" id="editarCronograma">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ url('/') }}/cronogramasLista/{{ $value->id_cronograma }}"
                enctype="multipart/form-data">

                @method('PUT')
                @csrf

                <div class="modal-header bg-info">
                    <h4 class="modal-tittle">Registrar Mantenimiento</h4>
                    <a href="{{ url("/") }}/cronogramasLista" type="button" class="close">&times;</a>
                </div>

                <div class="modal-body">
                
                    <div class="input-group mb-3" style="display:none;">

                        <label for="email" class="col-md-4 control-label">Mantenimiento:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" name="mantenimiento_oculto" id="mantenimiento_oculto"
                            value="{{$value->id_mantenimiento}}" autofocus
                            style="text-transform: uppercase;" readonly="">
                        </div>
                    </div>

                    <div class="input-group mb-3">

                        <label for="email" class="col-md-4 control-label">Equipo:</label>

                        <div class="col-md-8">
                            <input type="hidden" class="form-control" name="cronograma_equipo"
                            value="{{$value->id_equipo}}" required autofocus
                            style="text-transform: uppercase;" readonly="">

                            <input type="text" class="form-control" name=""
                            value="{{$value->nombre_equipo}}" required autofocus
                            style="text-transform: uppercase;" readonly="">
                        </div>
                    </div>

                    <div class="input-group mb-3">

                        <label for="email" class="col-md-4 control-label">Fecha Inicial:</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="cronograma_fecha"
                            value="{{$value->fecha}}" required autofocus
                            style="text-transform: uppercase;" readonly="">
                        </div>
                    </div>

                    <div class="input-group mb-3">

                        <label for="email" class="col-md-4 control-label">Fecha Final:</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="cronograma_fecha_final"
                            value="{{$value->fecha_final}}" required autofocus
                            style="text-transform: uppercase;" readonly="">
                        </div>
                    </div>

                    <div class="input-group mb-3" id="orden_servicio_cronograma">
                        <label for="email" class="col-md-4 control-label">ODS:</label>

                        <div class="col-md-8">
                            <select class="form-control select2" name="id_ordenServicio">
                                <option value="">
                                    -- Seleccionar la orden de Servicio --
                                </option>

                                @foreach ($ordenServicios as $key => $value_orden)
                                    <option value="{{$value_orden->id_ordenServicio}}">
                                        {{$value_orden->codigo_ordenServicio}} - {{ \Carbon\Carbon::parse($value_orden->fecha_ordenServicio)->format('Y')}}
                                    </option>
                                @endforeach
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
                            <select class="form-control" name="id_proveedor" id="nombres_proveedor">
                                    <option value="">
                                        -- Seleccionar el Proveedor --
                                    </option>

                                    @foreach($proveedores as $key => $valorProveedor)
                                    <option value="{{$valorProveedor->id_proveedor}}">{{$valorProveedor->razonSocial_proveedor}}</option>
                                    @endforeach

                                </select>
                        </div>
                    </div>

                    <div class="input-group mb-3" id="nombres_departamento_editar">
                        <label for="email" class="col-md-4 control-label">Solicitado por:</label>

                        <div class="col-md-7">
                            <select class="form-control" name="id_departamento" id="nombres_departamento">
                                    <option value="">
                                        -- Seleccionar el Departamento --
                                    </option>

                                    @foreach($departamentos as $key => $valorDepartamento)
                                    <option value="{{$valorDepartamento->id_departamento}}">{{$valorDepartamento->nombre_departamento}}</option>
                                    @endforeach

                                </select>
                        </div>

                        <label for="email" class="col-md-1 control-label">o</label>
                    </div>

                    <div class="input-group mb-3" id="nombres_direccionEjecutiva_editar">
                        <label for="email" class="col-md-4 control-label" style="color:white;">Solicitado por:</label>

                        <div class="col-md-8">
                            <select class="form-control" name="id_direccionEjecutiva" id="nombres_direccionEjecutiva">
                                    <option value="">
                                        -- Seleccionar la Dirección Ejecutiva --
                                    </option>

                                    @foreach($direccionesEjecutivas as $key => $valorDireccion)
                                    <option value="{{$valorDireccion->id_direccionEjecutiva}}">{{$valorDireccion->nombre_direccionEjecutiva}}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="input-group mb-3" id="garantia_cronograma">

                        <label for="email" class="col-md-4 control-label">Garantía (Meses):</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="cronograma_garantia"
                            value="{{$value->garantia}}" autofocus
                            style="text-transform: uppercase;">
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-4 control-label">Detalles del Servicio:</label>

                        <div class="col-md-8">
                            <textarea class="form-control" name="cronograma_observacion" autofocus style="text-transform: uppercase;"></textarea>
                        </div>
                    </div>

                    <div class="input-group mb-3" id="monto_cronograma">

                        <label for="email" class="col-md-4 control-label">Monto:</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="monto_cronograma"
                            value="" autofocus
                            style="text-transform: uppercase;">
                        </div>
                    </div>

                    <div class="input-group mb-3" id="otm_cronograma">

                        <label for="email" class="col-md-4 control-label">N° OTM:</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="otm_cronograma"
                            value="" autofocus
                            style="text-transform: uppercase;">
                        </div>
                    </div>

                        <hr class="pb-2">
                            <div class="form-group my-2 text-center">
                                <div class="btn btn-default btn-file">
                                    <i class="fas fa-paperclip"></i> Adjuntar Archivo
                                    <p><label for="pdf_archivo_final">
                                        <input type="file" name="pdf_archivo_final" id="pdf_cronograma">
                                    </label></p>

                                </div><br>

                                <p class="help-block small">Tamaño máximo de archivos: 20MB</p>
                            </div>

                </div>

                <div class="modal-footer d-flex justify-content-between">
                    <div>
                        <a href="{{ url("/") }}/cronogramasLista" type="button" class="btn btn-danger">Cerrar</a>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </div>

            </form>
          </div>
        </div>

    </div>

    @endforeach

    <script>
        $("#editarCronograma").modal();
    </script>

  @else

  {{$status}}

@endif

@endif --}}
{{-- 
<script type="text/javascript">

    var id = $("#probando0101").val();

    $.ajax({
          url: url + '/cronogramasLista/editar',
          method: "POST",
          data: $("#frmVerDa").serialize(),
          success: function(respuesta){
            console.log("respuesta",respuesta);
          },

          error: function(jqXHR,textStatus,errorThrown){
            console.error(textStatus + " " + errorThrown);
          }
    });
</script> --}}

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

@endif

@endforeach