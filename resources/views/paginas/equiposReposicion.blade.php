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
            <h1>Equipos por Reposición</h1>
            </br>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url("/") }}">Inicio</a></li>
              <li class="breadcrumb-item active">Equipos por Reposición</li>
            </ol>
          </div>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <div class="row mb-2">
                <div class="col-12">
                    <div class="input-group">
                        <label for="equipoFilterReposicion" class="col-md-2 control-label">EQUIPO:</label>
                        <div class="col-md-4" id="equipoFilterReposicion"></div>
    

                        <label for="marcaFilterReposicion" class="col-md-2 control-label">MARCA:</label>
                        <div class="col-md-4" id="marcaFilterReposicion"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



          <div class="col-sm-12">
            <div class="callout callout-info col-md-12" style="float:left;">
                <h5>
                    <span class="spinner-grow text-danger"></span>
                    <i> Leyenda:</i>
                </h5>

                <ul>
                    <li>Criterio 01: <span style="color:black;">El equipo se encuentra en estado de conservación malo.</span></li>
                    <li>Criterio 02: <span style="color:black;">El costo supera el 40% del valor del equipo.</span></li>
                    <li>Criterio 03: <span style="color:black;">No existe soporte técnico en el mercado nacional.</span></li>
                    <li>Criterio 04: <span style="color:black;">El equipo tiene mayores costos de operación comparado con otros similares.</span></li>
                    <li>Criterio 05: <span style="color:black;">Tiene una antiguedad mayor al tiempo de vida util recomendado por el fabricante.</span></li>
                    <li>Criterio 06: <span style="color:black;">El equipo no se encuentra vigente tecnológicamente.</span></li>
                    <li>Criterio 07: <span style="color:black;">Condición de seguridad.</span></li>
                </ul>
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
              <div class="card-body">

                <table class="table table-bordered table-striped dt-responsive" width="100%" id="tablaRoles">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Equipo</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th># Serie</th>
                            <th>Cod. Patrimonial</th>
                            <th>Criterio 1</th>
                            <th>Criterio 2</th>
                            <th>Criterio 3</th>
                            <th>Criterio 4</th>
                            <th>Criterio 5</th>
                            <th>Criterio 6</th>
                            <th>Criterio 7</th>
                            <th>Acciones</th>
                        </tr>

                    </thead>
                    <tbody></tbody>
                    {{-- <tbody>

                        @foreach($equipos_criterios as $key => $data)
                                @php
                                    if($data->antiguedad_equipo >= $data->tiempo_vida_util_equipo){
                                        $valor_antiguedad = 1;
                                    }else{
                                        $valor_antiguedad = 0;
                                    }
                                @endphp

                                @php
                                    if(100*$data->acumulado_cronograma/$data->monto_adquisicion_equipo >= 40){
                                        $valor_porcentaje = 1;
                                    }else{
                                        $valor_porcentaje = 0;
                                    }
                                @endphp

                            @if($data->baja_equipo != 1 && $data->criterio_7 == 1 || $data->baja_equipo != 1 && $data->criterio_1 + $valor_porcentaje + $data->criterio_3 + $data->criterio_4 + $valor_antiguedad + $data->criterio_6 >= 2)
                            <tr>
                                <td style="text-align: center;">{{($key+1)}}</td>
                                <td style="text-transform: uppercase;">{{$data->nombre_equipo}}</td>
                                <td style="text-align: center; text-transform: uppercase;">{{$data->marca_equipo}} VALOR OBTENIDO{{100*$data->acumulado_cronograma/$data->monto_adquisicion_equipo}} {{$valor_porcentaje}} {{$valor_antiguedad}}</td>
                                <td style="text-align: center; text-transform: uppercase;">{{$data->modelo_equipo}}</td>
                                <td style="text-align: center; text-transform: uppercase;">{{$data->serie_equipo}}</td>
                                <td style="text-align: center; text-transform: uppercase;">{{$data->cp_equipo}}</td>
                                <td style="text-align: center; text-transform: uppercase;">
                                    @if($data->criterio_1 == 0)
                                        <i class="fas fa-times text-red" style="text-align:center;"></i>
                                    @else
                                        <i class="fas fa-check text-green" style="text-align:center;"></i>
                                    @endif
                                </td>
                                <td style="text-align: center; text-transform: uppercase;">
                                    @if(100*$data->acumulado_cronograma/$data->monto_adquisicion_equipo >= 40)
                                        <i class="fas fa-check text-green" style="text-align:center;"></i>
                                    @else
                                        <i class="fas fa-times text-red" style="text-align:center;"></i>
                                    @endif
                                </td>
                                <td style="text-align: center; text-transform: uppercase;">
                                    @if($data->criterio_3 == 0)
                                        <i class="fas fa-times text-red" style="text-align:center;"></i>
                                    @else
                                        <i class="fas fa-check text-green" style="text-align:center;"></i>
                                    @endif
                                </td>
                                <td style="text-align: center; text-transform: uppercase;">
                                    @if($data->criterio_4 == 0)
                                        <i class="fas fa-times text-red" style="text-align:center;"></i>
                                    @else
                                        <i class="fas fa-check text-green" style="text-align:center;"></i>
                                    @endif
                                </td>
                                <td style="text-align: center; text-transform: uppercase;">
                                    @if($data->antiguedad_equipo >= $data->tiempo_vida_util_equipo)
                                        <i class="fas fa-check text-green" style="text-align:center;"></i>
                                    @else
                                        <i class="fas fa-times text-red" style="text-align:center;"></i>
                                    @endif
                                </td>
                                <td style="text-align: center; text-transform: uppercase;">
                                    @if($data->criterio_6 == 0)
                                        <i class="fas fa-times text-red" style="text-align:center;"></i>
                                    @else
                                        <i class="fas fa-check text-green" style="text-align:center;"></i>
                                    @endif
                                </td>
                                <td style="text-align: center; text-transform: uppercase;">
                                    @if($data->criterio_7 == 0)
                                        <i class="fas fa-times text-red" style="text-align:center;"></i>
                                    @else
                                        <i class="fas fa-check text-green" style="text-align:center;"></i>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <div class="btn-group">
                                        <a href="{{url('/')}}/equiposReposicion/{{$data->id_equipo}}" class="btn btn-danger btn-sm">
                                            <i class="fas fa-pencil-alt text-white"></i> Dar de Baja
                                        </a>
                                    </div>

                                    <div class="btn-group">
                                        <a href="http://192.168.6.113/software_biomedico/public/reportesEquipos/EquiposPdf/{{$data->id_equipo}}" class="btn btn-default btn-sm" target="_blank">
                                            <i class="fas fa-download text-black"></i> Tarjeta de Control
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endif
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

{{-- Editar departamento en modal --}}
<div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-tittle">Dar de Baja</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                   
                        {{-- fecha Inicial --}}
                        <div class="input-group mb-3">
    
                            <label for="email" class="col-md-4 control-label">Fecha:</label>
    
                            <div class="col-md-8">
                                <input type="date" class="form-control" id="fecha_baja" name="fecha_baja"
                                value="" required autofocus
                                style="text-transform: uppercase;">
                            </div>
                        </div>{{-- fin fecha inicial--}}
    
                        {{-- Equipo para baja--}}
                        <div class="input-group mb-3">
                            <label for="email" class="col-md-4 control-label">Reemplazado por:</label>
    
                            <div class="col-md-8">
                            <select class="form-control select2" id="equipo_baja" name="equipo_baja" required>
                                <option value="">
                                    -- Seleccionar el Equipo --
                                </option>
                                @foreach($equiposGarantia = App\EquiposGarantiaModel::all() as $key => $value_equipos)
                                    <option value="{{$value_equipos->nombre_equipoGarantia}},Cod. Patrimonial: {{$value_equipos->cp_equipoGarantia}}">{{$value_equipos->nombre_equipoGarantia}},Cod. Patrimonial: {{$value_equipos->cp_equipoGarantia}}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>{{-- fin equipo para baja --}}
                     
                  
                    
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

    @foreach ($equipo_criterio as $key => $value)

    <div class="modal" id="editarEquipoReposicion">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ url('/') }}/equiposReposicion/{{ $value->id_equipo }}"
                enctype="multipart/form-data">

                @method('PUT')
                @csrf

                <div class="modal-header bg-info">
                    <h4 class="modal-tittle">Dar de Baja</h4>
                    <a href="{{url("/")}}/equiposReposicion" type="button" class="close">&times;</a>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">

                        <label for="email" class="col-md-4 control-label">Fecha:</label>

                        <div class="col-md-8">
                            <input type="date" class="form-control" name="fecha_baja"
                            value="" required autofocus
                            style="text-transform: uppercase;">
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-4 control-label">Reemplazado por:</label>

                        <div class="col-md-8">
                        <select class="form-control select2" name="equipo_baja" required>
                            <option value="">
                                -- Seleccionar el Equipo --
                            </option>
                            @foreach($equiposGarantia as $key => $value_equipos)
                                <option value="{{$value_equipos->nombre_equipoGarantia}},Cod. Patrimonial: {{$value_equipos->cp_equipoGarantia}}">{{$value_equipos->nombre_equipoGarantia}},Cod. Patrimonial: {{$value_equipos->cp_equipoGarantia}}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer d-flex justify-content-between">
                    <div>
                        <a href="{{url("/")}}/equiposReposicion" type="button" class="btn btn-danger">Cerrar</a>
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
        $("#editarEquipoReposicion").modal();
    </script>

  @else

  {{$status}}

@endif

@endif --}}

@if (Session::has("ok-crear"))
  <script>
      notie.alert({type:1,text:'!El Equipo de Reposición ha sido creado correctamente', time:10})
  </script>
@endif

@if (Session::has("no-validacion"))
  <script>
      notie.alert({type:2,text:'!Hay campos no válidos en el formulario', time:10})
  </script>
@endif

@if (Session::has("error"))
  <script>
      notie.alert({type:3,text:'!Error en el gestor de equipos de Reposición', time:10})
  </script>
@endif

@if (Session::has("ok-editar"))
  <script>
      notie.alert({type:1,text:'!El equipo de Reposición ha sido dado de baja correctamente', time:10})
  </script>
@endif

@if (Session::has("ok-eliminar"))

<script>
    notie.alert({ type: 1, text: '¡El equipo de Reposición ha sido eliminado correctamente!', time: 10 })
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