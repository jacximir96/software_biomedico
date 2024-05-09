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
            <h1>FORMATO 8 MATRIZ DE CONSOLIDACION DEL PLAN DE EQUIPAMIENTO POR REPOSICIÓN DE LOS ESTABLECIMIENTOS DE SALUD</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url("/") }}">Inicio</a></li>
              <li class="breadcrumb-item active">Formato 8</li>
            </ol>
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

    </br>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Default box -->
            <div class="card">
              <div class="card-header">
                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#crearEquipoNuevo">
                    Añadir Equipo nuevo
                </button>
                <a href="{{ url('/') }}/reportesFormato8R/formato8Pdf" target="_blank" class="btn btn-success btn-sm" style="float:right;">
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

                    <tbody>

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

                        @if($data->criterio_7 == 1 || $data->criterio_1 + $valor_porcentaje + $data->criterio_3 + $data->criterio_4 + $valor_antiguedad + $data->criterio_6 >= 2)
                        <tr>
                            <td style="text-align: center;">{{($key+1)}}</td>
                            <td style="text-transform: uppercase;">{{$data->nombre_equipo}}</td>
                            <td style="text-align: center; text-transform: uppercase;">{{$data->marca_equipo}}</td>
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
                                    <a href="{{url('/')}}/reportesFormato8/" class="btn btn-warning btn-sm">
                                        <i class="fas fa-pencil-alt text-white"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endif
                    @endforeach

                    @foreach($equipoExterno1 as $key => $valor_equipoExterno1)
                        <tr>
                                <td style="text-align: center; text-transform: uppercase;">{{($key+1)}}</td>
                                <td style="text-transform: uppercase;">{{$valor_equipoExterno1->nombre_equipoExterno1}}</td>
                                <td style="text-align: center; text-transform: uppercase;">{{$valor_equipoExterno1->marca_equipoExterno1}}</td>
                                <td style="text-align: center; text-transform: uppercase;">{{$valor_equipoExterno1->modelo_equipoExterno1}}</td>
                                <td style="text-align: center; text-transform: uppercase;">{{$valor_equipoExterno1->serie_equipoExterno1}}</td>
                                <td style="text-align: center; text-transform: uppercase;">{{$valor_equipoExterno1->cp_equipoExterno1}}</td>
                                <td style="text-align: center; text-transform: uppercase;"></td>
                                <td style="text-align: center; text-transform: uppercase;"></td>
                                <td style="text-align: center; text-transform: uppercase;"></td>
                                <td style="text-align: center; text-transform: uppercase;"></td>
                                <td style="text-align: center; text-transform: uppercase;">
                                    @if($valor_equipoExterno1->antiguedad_equipo >= $valor_equipoExterno1->tiempo_vida_util_equipoExterno1)
                                        <i class="fas fa-check text-green" style="text-align:center;"></i>
                                    @else
                                        <i class="fas fa-times text-red" style="text-align:center;"></i>
                                    @endif
                                </td>
                                <td style="text-align: center; text-transform: uppercase;"></td>
                                <td style="text-align: center; text-transform: uppercase;"></td>
                                <td style="text-align: center; text-transform: uppercase;">
                                    <div class="btn-group">
                                        <a href="{{url('/')}}/reportesFormato8" class="btn btn-warning btn-sm">
                                            <i class="fas fa-pencil-alt text-white"></i>
                                        </a>
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
            <form method="POST" action="{{ url('/') }}/reportesFormato8">
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
                    </div>{{-- fin id de tipoEquipamiento --}}

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
                    </div>{{-- fin id de ambiente --}}

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
                        <label for="email" class="col-md-3 control-label">Prog. Presup:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" name="programa_presupuestal"
                            value="{{ old("programa_presupuestal") }}" autofocus
                            placeholder="Ingrese el programa presupuestal" style="text-transform: uppercase;">
                        </div>

                    </div>{{-- fin programa presupuestal --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Producto:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" name="producto"
                            value="{{ old("producto") }}" autofocus
                            placeholder="Ingrese el producto" style="text-transform: uppercase;">
                        </div>

                    </div>{{-- fin PRODUCTO--}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Actividad:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" name="actividad"
                            value="{{ old("actividad") }}" required autofocus
                            placeholder="Ingrese la actividad" style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin ACTIVIDAD --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Familia:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" name="familia"
                            value="{{ old("familia") }}" required autofocus
                            placeholder="Ingrese la familia" style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin FAMILIA --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Equip. Adqu:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" name="equipamiento_adquirir"
                            value="{{ old("equipamiento_adquirir") }}" required autofocus
                            placeholder="Ingrese el equipamiento a adquirir" style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin EQUIPAMIENTO A ADQUIRIR --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Costo Refer:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control inputRutaMonto" name="costo_referencial"
                            value="{{ old("costo_referencial") }}" required autofocus
                            placeholder="Ingrese el costo referencial" style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin COSTO REFERENCIAL --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Fuente:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" name="fuente_costo"
                            value="{{ old("fuente_costo") }}" required autofocus
                            placeholder="Ingrese la fuente del costo refer." style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin COSTO REFERENCIAL --}}

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
