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
            <h1>Equipos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url("/") }}">Inicio</a></li>
              <li class="breadcrumb-item active">Equipos</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered table-striped dt-responsive" width="100%"
                            id="tablaHistorialEquipos">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Equipo</th>
                                        <th>Marca</th>
                                        <th>Modelo</th>
                                        <th>Serie</th>
                                        <th>Cod. Patr.</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                {{-- <tbody>
                                    @foreach ($equipos as $key => $data)
                                        <tr>
                                            <td style="text-align: center;">{{($key+1)}}</td>
                                            <td style="text-align: center; text-transform: uppercase;">{{$data->nombre_equipo}}</td>
                                            <td style="text-align: center; text-transform: uppercase;">{{$data->marca_equipo}}</td>
                                            <td style="text-align: center; text-transform: uppercase;">{{$data->modelo_equipo}}</td>
                                            <td style="text-align: center; text-transform: uppercase;">{{$data->serie_equipo}}</td>
                                            <td style="text-align: center; text-transform: uppercase;">{{$data->cp_equipo}}</td>
                                            <td>
                                                <a href="{{url('/')}}/historialEquipos/{{$data->id_equipo}}" class="btn btn-warning btn-sm">
                                                    Historial
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody> --}}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
  </div>

  <div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-tittle">Historial</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               
                {{-- <form id="editForm" method="GET" action="{{route('crearPdf.MantenimientoServicioHistorial')}}" target="#"> --}}
                  
                    <table class="table table-bordered table-striped dt-responsive" width="100%"
                    id="historialCompra2">
                        <thead>
                            <tr>
                                <th colspan="2" style="text-align:center;">Información del Equipo</th>
                            </tr>
                        </thead>
    
                        <tbody>
                            <input type="text" style="display:none" name="id_equipoHistorial" id="id_equipoHistorial">
                        
                            
                        </tbody>
                    </table>

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                           
                                            
                                            <table class="table table-bordered table-striped dt-responsive" width="100%" id="historialCompra1">
                                                <thead>
                                                    <tr>       
                                                        <th>#</th>
                                                        <th>Tipo</th>
                                                        <th>Fecha</th>
                                                        <th>N° ODS/OTM</th>
                                                        <th>Estado</th>
                                                        <th>Conformidad</th>
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



                    
                    
                    <div class="modal-footer d-flex justify-content-between">
                        <div>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
    
                        <div>
                            <a href="" id="historialServicioImprimir" class="btn btn-success">Imprimir</a>
                        </div>
                    </div>
                {{-- </form> --}}
            </div>
        </div>
    </div>
  </div>



{{-- Modal de Historial del equipo --}}

{{-- @if (isset($status))

@if ($status == 200)

    @foreach ($equipo as $key => $value)

    <div class="modal" id="historial_visualizar">
    <div class="modal-dialog">
        <div class="modal-content">
        <form action="{{ url('/') }}/reportesHistorial/historialPdf" method="get" target="_blank">
            <div class="modal-header bg-info">
                <h4 class="modal-tittle">Historial</h4>
                <a href="{{url("/")}}/historialEquipos" type="button" class="close">&times;</a>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
            </div>

            <div class="modal-body">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th colspan="2" style="text-align:center;">Información del Equipo</th>
                        </tr>
                    </thead>

                    <tbody>
                        <input type="text" value="{{$value->id_equipo}}" style="display:none;" name="id_equipoHistorial">

                        <tr>
                            <th style="text-align:right;">Equipo:</th>
                            <td>{{$value->nombre_equipo}}</td>
                        </tr>

                        <tr>
                            <th style="text-align:right;">Marca:</th>
                            <td>{{$value->marca_equipo}}</td>
                        </tr>

                        <tr>
                            <th style="text-align:right;">Modelo:</th>
                            <td>{{$value->modelo_equipo}}</td>
                        </tr>

                        <tr>
                            <th style="text-align:right;">Serie:</th>
                            <td>{{$value->serie_equipo}}</td>
                        </tr>

                        <tr>
                            <th style="text-align:right;">Cod. Patr:</th>
                            <td>{{$value->cp_equipo}}</td>
                        </tr>
                    </tbody>
                </table>

                <table class="table table-bordered table-striped dt-responsive">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tipo</th>
                            <th>Fecha</th>
                            <th>N° ODS/OTM</th>
                            <th>Estado</th>
                            <th>Conformidad</th>
                        </tr>
                    </thead>

                    @foreach ($cronograma_equipo as $key => $valor_cronograma)
                        <tr>
                            <td>{{($key+1)}}</td>
                            <td>{{$valor_cronograma->nombre_mantenimiento}}</td>

                            @if($valor_cronograma->fecha < date('Y-m-d') && $valor_cronograma->realizado == 0)
                                <td style="color:red;">Inicio: {{$valor_cronograma->fecha}} </br>
                                                        Fin: {{$valor_cronograma->fecha_final}}</td>
                            @else
                                <td>Inicio: {{$valor_cronograma->fecha}} </br>
                                    Fin: {{$valor_cronograma->fecha_final}}
                                </td>
                            @endif

                            @if($valor_cronograma->id_mantenimiento == 1 or $valor_cronograma->id_mantenimiento == 2)
                                <td>{{$valor_cronograma->codigo_ordenServicio}}</td>
                            @else
                                <td>{{$valor_cronograma->otm_cronograma}}</td>
                            @endif

                            @if($valor_cronograma->realizado == 1)
                                <td style="color:green;">REALIZADO</td>
                            @else
                                <td style="color:red;">NO REALIZADO</td>
                            @endif


                            <td>
                                @if (Storage::exists($valor_cronograma->pdf_cronograma))
                                    <a href="{{Storage::url($valor_cronograma->pdf_cronograma)}}" download="Archivo de finalización" class="btn btn-default btn-sm">
                                        <i class="fas fa-download text-black"></i>
                                    </a>
                                @endif
                                <a href="{{route('download')}}" download="Archivo de finalización" class="btn btn-default btn-sm">
                                    <i class="fas fa-download text-black"></i>
                                </a>
                            </td>

                        </tr>
                    @endforeach
                    <tbody>

                    </tbody>
                </table>

                </br>

                <div class="modal-footer d-flex justify-content-between">
                    <div>
                        <a href="{{url("/")}}/historialEquipos" type="button" class="btn btn-danger">Cerrar</a>
                        
                         <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>

                    <div>
                        <button class="btn btn-success">Imprimir</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
    </div>

    @endforeach

    <script>
        $("#historial_visualizar").modal();
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
