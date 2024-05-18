@foreach ($administradores as $element)
            @if ("administrador@inr.gob.pe" == $element->email)

@extends('plantilla')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Equipos por Compra</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url("/") }}">Inicio</a></li>
              <li class="breadcrumb-item active">Equipos por Compra</li>
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
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#crearEquipoGarantia">
                    Crear nuevo equipo médico</button>

                <!-- <button class="btn btn-danger btn-sm" style="float:right;">
                    Imprimir</button> -->
                <!-- <button class="btn btn-success btn-sm" style="float:right;  margin-right:5px;">
                    Exportar a excel</button> -->
              </div>
              <div class="card-body">

                <table class="table table-bordered table-striped dt-responsive" width="100%"
                 id="tablaEquiposGarantia">
                    <thead>
                        <tr>
                           
                            <th>Equipo</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th># Serie</th>
                            <th>Cod. Patr.</th>
                            <th>Dir. Ejecutiva</th>
                            <th>Departamento</th>
                            <th>Ambiente</th>
                            <th>Fecha (Adquisición)</th>
                            <th>Monto (Adquisición)</th>
                            <th>Antig.</th>
                            <th>Vida Util</th>
                            <th>Imagen</th>
                            <th>Tarjeta de Control</th>
                            <th>Acciones</th> 
                        </tr>

                    </thead>
                    <tbody>

                    </tbody>
                    {{-- <tbody>
                        @foreach ($equiposGarantiaGeneral as $key => $data)
                            <tr>
                                <td style="text-align: center;">{{($key+1)}}</td>
                                <td style="text-align: center; text-transform: uppercase;">{{$data->nombre_equipoGarantia}}</td>
                                <td style="text-align: center; text-transform: uppercase;">{{$data->marca_equipoGarantia}}</td>
                                <td style="text-align: center; text-transform: uppercase;">{{$data->modelo_equipoGarantia}}</td>
                                <td style="text-align: center; text-transform: uppercase;">{{$data->serie_equipoGarantia}}</td>
                                <td style="text-align: center; text-transform: uppercase;">{{$data->cp_equipoGarantia}}</td>
                                <td style="text-align: center; text-transform: uppercase;">
                                    @if($data->id_departamento == '')
                                        {{$data->iniciales_direccionAmbiente}}
                                    @else
                                        {{$data->iniciales_direccionDepartamento}}
                                    @endif
                                </td>
                                <td style="text-align: center; text-transform: uppercase;">{{$data->iniciales_departamento}}</td>
                                <td style="text-align: center; text-transform: uppercase;">{{$data->nombre_ambiente}}</td>
                                <td style="text-align: center; text-transform: uppercase;">{{ \Carbon\Carbon::parse($data->fecha_adquisicion_equipoGarantia)->format('d-m-Y')}}</td>
                                <td style="text-align: center; text-transform: uppercase;">S/. {{number_format($data->monto_adquisicion_equipoGarantia, 2)}}</td>
                                <td style="text-align: center; text-transform: uppercase;">{{$data->antiguedad_equipoGarantia}}</td>
                                <td style="text-align: center; text-transform: uppercase;">{{$data->tiempo_vida_util_equipoGarantia}}</td>
                                <td style="text-align: center; text-transform: uppercase;">
                                    <a href="{{$data->imagen_equipoGarantia}}" target="_blank">
                                        <img src="{{$data->imagen_equipoGarantia}}" style="width:200px; height:200px;" class="img-fluid"></img>
                                    </a>
                                </td>
                                <td style="text-align: center; text-transform: uppercase;">
                                    <a href="/reportesEquiposGarantia/EquiposGarantiaPdf/{{$data->id_equipoGarantia}}" class="btn btn-default btn-sm" target="_blank">
                                        <i class="fas fa-download text-black"></i> Descargar Archivo
                                    </a>
                                </td>
                                <td style="text-align: center;">
                                    <div class="btn-group">
                                        <a href="{{url('/')}}/equiposGarantia/{{$data->id_equipoGarantia}}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-pencil-alt text-white"></i>
                                        </a>

                                        <button class="btn btn-danger btn-sm eliminarRegistro" action="{{url('/')}}/equiposGarantia/{{$data->id_equipoGarantia}}"
                                            method="DELETE" pagina="equiposGarantia" token="{{ csrf_token() }}">
                                            <!-- @csrf -->
                                            <i class="fas fa-trash-alt text-white"></i>
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody> --}}
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

  <div class="modal" id="crearEquipoGarantia">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ url('/') }}/equiposGarantia" enctype="multipart/form-data">
                @csrf

                <div class="modal-header bg-info">
                    <h4 class="modal-tittle">Crear Equipo</h4>
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
                            <input type="text" class="form-control inputRutaMonto" name="cp_equipo"
                            value="{{ old("cp_equipo") }}" required autofocus
                            placeholder="Ingrese el código Patrimonial" style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin cp de equipo medico --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Ambiente:</label>

                        <div class="col-md-8">
                            <select class="form-control select2" name="id_ambiente" required style="text-transform: uppercase;">
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

                        <div class="col-md-6">
                            <input type="date" class="form-control" name="fecha_adquisicion_equipo"
                            value="{{ old("fecha_adquisicion_equipo") }}" required autofocus
                            placeholder="Ingrese la fecha de adquisición" style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin fecha adquisición de equipo medico --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Monto Adquis:</label>

                        <div class="col-md-7">
                            <input type="text" class="form-control inputRutaMonto" name="monto_adquisicion_equipo"
                            value="{{ old("monto_adquisicion_equipo") }}" required autofocus
                            placeholder="Ingrese el monto" style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin monto adquisición de equipo medico --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Vida Util:</label>

                        <div class="col-md-7">
                            <input type="text" class="form-control inputRutaMonto" name="tiempo_vida_util_equipo"
                            value="{{ old("tiempo_vida_util_equipo") }}" required autofocus
                            placeholder="Ingrese la vida util (Años)" style="text-transform: uppercase;" maxlength="2">
                        </div>
                    </div>{{-- fin vida util de equipo medico --}}

                    {{-- Imagen --}}
                        <hr class="pb-2">
                            <div class="form-group my-2 text-center">
                                <div class="btn btn-default btn-file">
                                        <i class="fas fa-paperclip"></i> Adjuntar Foto
                                        <input type="file" name="foto" id="imagen_equipoGarantia">
                                </div><br>

                                <img src="" class="previsualizarImg_foto
                                img-fluid py-2 w-25">

                                <p class="help-block small">Dimensiones: 200px * 200px | Peso Max. 10MB |
                                Formato: JPG o PNG</p>
                            </div>

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

  {{-- Editar departamento en modal --}}
  <div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-tittle">Editar Equipo Médico</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               
                <form id="editForm" method="POST"   enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Nombre:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" id="nombre_equipo" name="nombre_equipo"
                            required autofocus
                            style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin nombre de equipo medico --}}
                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Marca:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" id="marca_equipo" name="marca_equipo"
                             required autofocus
                            style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin marca de equipo medico --}}
                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Modelo:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" id="modelo_equipo"name="modelo_equipo"
                            required autofocus
                            style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin modelo de equipo medico --}}
                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Serie:</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" id="serie_equipo"name="serie_equipo"
                            required autofocus
                            placeholder="Ingrese el número de serie" style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin serie de equipo medico --}}
                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Cod. Patrim:</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control inputRuta"  id="cp_equipo"name="cp_equipo"
                             required autofocus
                            placeholder="Ingrese el código Patrimonial" style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin cp de equipo medico --}}
                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Ambiente:</label>

                        <div class="col-md-8">
                            <select class="form-control" id="id_ambiente" name="id_ambiente" required style="text-transform: uppercase;">
                                @foreach ($ambientes as $key => $value1)

                                    <option value="{{$value1->id_ambiente}}">
                                        {{$value1->nombre_ambiente}}
                                    </option>

                                @endforeach
                            </select>
                        </div>
                    </div>{{-- fin id de ambiente --}}
                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Fecha Adquis:</label>

                        <div class="col-md-6">
                            <input type="date" class="form-control" id="fecha_adquisicion_equipo" name="fecha_adquisicion_equipo"
                            required autofocus
                            placeholder="Ingrese la fecha de adquisición" style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin fecha adquisicion de equipo medico --}}
                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Monto Adquis:</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control inputRutaMonto" id="monto_adquisicion_equipo" name="monto_adquisicion_equipo"
                            required autofocus
                            placeholder="Ingrese el monto de adquisición" style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin monto adquisicion de equipo medico --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Vida Util:</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control inputRuta" id="tiempo_vida_util_equipo"name="tiempo_vida_util_equipo"
                           required autofocus
                            placeholder="Ingrese el tiempo de vida util (años)" style="text-transform: uppercase;" maxlength="2">
                        </div>
                    </div>{{-- fin vida util de equipo medico --}}

                    <hr class="pb-2">
                            <div class="form-group my-2 text-center">
                                <div class="btn btn-default btn-file">
                                        <i class="fas fa-paperclip"></i> Adjuntar Foto
                                        <input type="file" name="foto" id="imagen_equipoGarantia_editar">
                                </div><br>
                                {{-- <img id="imagenEquipo" src="/images/default.jpg" alt="Imagen predeterminada"> --}}
                                <img  id="imagenEquipo"class="previsualizarImg_foto
                                    img-fluid py-2 w-25">
                                <input type="hidden" id="imagen_actual" name="imagen_actual">
                                <p class="help-block small">Dimensiones: 200px * 200px | Peso Max. 10MB |
                                Formato: JPG o PNG</p>
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


{{-- @if (isset($status))

@if ($status == 200)

    @foreach ($equipoGarantia as $key => $value)

    <div class="modal" id="editarEquipo">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ url('/') }}/equiposGarantia/{{ $value["id_equipoGarantia"] }}"
                enctype="multipart/form-data">

                @method('PUT')
                @csrf

                <div class="modal-header bg-info">
                    <h4 class="modal-tittle">Editar Equipo Médico</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Nombre:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" name="nombre_equipo"
                            value="{{$value["nombre_equipoGarantia"]}}" required autofocus
                            style="text-transform: uppercase;">
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Marca:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" name="marca_equipo"
                            value="{{$value["marca_equipoGarantia"]}}" required autofocus
                            style="text-transform: uppercase;">
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Modelo:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" name="modelo_equipo"
                            value="{{$value["modelo_equipoGarantia"]}}" required autofocus
                            style="text-transform: uppercase;">
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Serie:</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="serie_equipo"
                            value="{{$value["serie_equipoGarantia"]}}" required autofocus
                            placeholder="Ingrese el número de serie" style="text-transform: uppercase;">
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Cod. Patrim:</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control inputRuta" name="cp_equipo"
                            value="{{$value["cp_equipoGarantia"]}}" required autofocus
                            placeholder="Ingrese el código Patrimonial" style="text-transform: uppercase;">
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Ambiente:</label>

                        <div class="col-md-8">
                            <select class="form-control select2" name="id_ambiente" required style="text-transform: uppercase;">
                                @foreach ($equipoGarantia_ambiente as $key => $value1)

                                    <option value="{{$value1->id_ambiente}}">
                                        {{$value1->nombre_ambiente}}
                                    </option>

                                    @foreach ($ambientes as $key => $value2)

                                        @if ($value2->id_ambiente != $value1->id_ambiente)
                                            <option value="{{$value2->id_ambiente}}">
                                                {{$value2->nombre_ambiente}}
                                            </option>
                                        @endif

                                    @endforeach

                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Fecha Adquis:</label>

                        <div class="col-md-6">
                            <input type="date" class="form-control" name="fecha_adquisicion_equipo"
                            value="{{$value["fecha_adquisicion_equipoGarantia"]}}" required autofocus
                            placeholder="Ingrese la fecha de adquisición" style="text-transform: uppercase;">
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Monto Adquis:</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control inputRutaMonto" name="monto_adquisicion_equipo"
                            value="{{$value["monto_adquisicion_equipoGarantia"]}}" required autofocus
                            placeholder="Ingrese el monto de adquisición" style="text-transform: uppercase;">
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Vida Util:</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control inputRuta" name="tiempo_vida_util_equipo"
                            value="{{$value["tiempo_vida_util_equipoGarantia"]}}" required autofocus
                            placeholder="Ingrese el tiempo de vida util (años)" style="text-transform: uppercase;" maxlength="2">
                        </div>
                    </div>

                 
                        <hr class="pb-2">
                            <div class="form-group my-2 text-center">
                                <div class="btn btn-default btn-file">
                                        <i class="fas fa-paperclip"></i> Adjuntar Foto
                                        <input type="file" name="foto" id="imagen_equipoGarantia_editar">
                                </div><br>

                                @if($value->imagen_equipoGarantia == "")
                                    <img src="{{ url('/') }}/img/equiposGarantia/sinImagen.jpg" class="previsualizarImg_foto
                                    img-fluid py-2 w-25">
                                @else
                                    <img src="{{ url('/') }}/{{$value->imagen_equipoGarantia}}" class="previsualizarImg_foto
                                    img-fluid py-2 w-25">
                                @endif

                                <input type="hidden" name="imagen_actual" value="{{$value->imagen_equipoGarantia}}">
                                <p class="help-block small">Dimensiones: 200px * 200px | Peso Max. 10MB |
                                Formato: JPG o PNG</p>
                            </div>
                        

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

    @endforeach

    <script>
        $("#editarEquipo").modal();
    </script>

  @else

  {{$status}}

@endif

@endif --}}

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

@endif

@endforeach
