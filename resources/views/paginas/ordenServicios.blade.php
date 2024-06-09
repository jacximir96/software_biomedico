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
            <h1>Orden de Servicios</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url("/") }}">Inicio</a></li>
              <li class="breadcrumb-item active">Orden de Servicios</li>
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
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#crearOrdenServicio">
                    Crear nueva orden de Servicio</button>
                    {{-- <a class="btn btn-warning btn-sm" href="{{ route('ordenServicios.pdf') }}">
                        pdf prueba</a> --}}
                    
                    
              </div>
              <div class="card-body">

                <table class="table table-bordered table-striped dt-responsive" width="100%"
                 id="tablaOrdenServicios">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>N° Orden de Servicio</th>
                            <th>N° Expediente</th>
                            <th>Fecha</th>
                            <th>Monto</th>
                            <th>Orden de Servicio</th>
                            <th>Acciones</th>
                        </tr>

                    </thead>
                    <tbody>

                    </tbody>

                    {{-- <tbody>

                        @foreach ($ordenServicios as $key => $data)
                            <tr>
                                <td style="text-align: center;">{{($key+1)}}</td>
                                <td style="text-align: center; text-transform: uppercase;">{{$data->codigo_ordenServicio}}</td>
                                <td style="text-align: center; text-transform: uppercase;">{{$data->expediente_ordenServicio}}</td>
                                <td style="text-align: center; text-transform: uppercase;">{{ \Carbon\Carbon::parse($data->fecha_ordenServicio)->format('d-m-Y')}}</td>
                                <td style="text-align: center; text-transform: uppercase;">S/. {{number_format($data->monto_ordenServicio, 2)}}</td>
                                <td style="text-align: center; text-transform: uppercase;">
                                    <a href="../storage/app/{{$data->pdf_ordenServicio}}" download="Orden de Servicio" class="btn btn-default btn-sm" >
                                        <i class="fas fa-download text-black"></i> Descargar Archivo
                                    </a>
                                </td>
                                </td>
                                <td style="text-align: center;">
                                    <div class="btn-group">
                                        <a href="{{url('/')}}/ordenServicios/{{$data->id_ordenServicio}}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-pencil-alt text-white"></i>
                                        </a>

                                        <button class="btn btn-danger btn-sm eliminarRegistro" action="{{url('/')}}/ordenServicios/{{$data->id_ordenServicio}}"
                                            method="DELETE" pagina="ordenServicios" token="{{ csrf_token() }}">
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
{{-- crear nuevo orden de servicio --}}
<div class="modal" id="crearOrdenServicio">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ url('/') }}/ordenServicios" enctype="multipart/form-data">
                @csrf

                <div class="modal-header bg-info">
                    <h4 class="modal-tittle">Crear Orden de Servicio</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="input-group mb-3">
                        <div class="input-group-append input-group-text">
                            <i class="fas fa-angle-double-right"></i>
                        </div>

                        <input type="text" class="form-control inputRutaMonto" name="codigo_ordenServicio"
                        value="{{ old("codigo_ordenServicio") }}" required autofocus
                        placeholder="Ingrese el número de orden" style="text-transform: uppercase;">
                    </div>{{-- fin codigo de orden de servicio --}}

                    <div class="input-group mb-3">
                        <div class="input-group-append input-group-text">
                            <i class="fas fa-angle-double-right"></i>
                        </div>

                        <input type="date" class="form-control" name="fecha_ordenServicio"
                        value="{{ old("fecha_ordenServicio") }}" required autofocus
                        placeholder="Ingrese la fecha de la orden de Servicio" style="text-transform: uppercase;">
                    </div>{{-- fin fecha de orden de servicio --}}

                    <div class="input-group mb-3">
                        <div class="input-group-append input-group-text">
                            <i class="fas fa-angle-double-right"></i>
                        </div>

                        <input type="text" class="form-control" name="expediente_ordenServicio"
                        value="{{ old("expediente_ordenServicio") }}" required autofocus
                        placeholder="Ingrese el número de expediente" style="text-transform: uppercase;">
                    </div>{{-- fin expediente de orden de servicio --}}

                    <div class="input-group mb-3">
                        <div class="input-group-append input-group-text">
                            <i class="fas fa-angle-double-right"></i>
                        </div>

                        <input type="text" class="form-control inputRutaMonto" name="monto_ordenServicio"
                        value="{{ old("monto_ordenServicio") }}" required autofocus
                        placeholder="Ingrese el monto total" style="text-transform: uppercase;">
                    </div>{{-- fin monto de orden de servicio --}}

                    {{-- pdf --}}
                        <hr class="pb-2">
                            <div class="form-group my-2 text-center">
                                <div class="btn btn-default btn-file">
                                    <i class="fas fa-paperclip"></i> Adjuntar Archivo
                                    <p><label for="pdf_archivo">
                                        <input type="file" name="pdf_archivo" id="pdf_ordenServicio">
                                    </label></p>

                                </div><br>

                                <p class="help-block small">Tamaño máximo de archivos: 20MB</p>
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
{{-- fin de crear nueva orden de servicio --}}


{{-- inicio del modal editar orden de servicio --}}
<div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-tittle">Editar Departamento</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-append input-group-text">
                            <i class="fas fa-angle-double-right"></i>
                        </div>

                        <input type="text" class="form-control" id="codigo_ordenServicio" name="codigo_ordenServicio"
                        required autofocus
                        style="text-transform: uppercase;">
                    </div>{{-- fin codigo de orden de servicio --}}
                    <div class="input-group mb-3">
                        <div class="input-group-append input-group-text">
                            <i class="fas fa-angle-double-right"></i>
                        </div>

                        <input type="date" class="form-control" id="fecha_ordenServicio"name="fecha_ordenServicio"
                         required autofocus
                        style="text-transform: uppercase;">
                    </div>{{-- fin fecha de orden de servicio --}}
                    <div class="input-group mb-3">
                        <div class="input-group-append input-group-text">
                            <i class="fas fa-angle-double-right"></i>
                        </div>

                        <input type="text" class="form-control"  id="expediente_ordenServicio" name="expediente_ordenServicio"
                        required autofocus
                        style="text-transform: uppercase;">
                    </div>{{-- fin expediente de orden de servicio --}}
                    <div class="input-group mb-3">
                        <div class="input-group-append input-group-text">
                            <i class="fas fa-angle-double-right"></i>
                        </div>

                        <input type="text" class="form-control" id="monto_ordenServicio" name="monto_ordenServicio"
                         required autofocus
                        style="text-transform: uppercase;">
                    </div>{{-- fin monto de orden de servicio --}}
                    {{-- pdf --}}
                    <hr class="pb-2">
                    <div class="form-group my-2 text-center">
                        <div class="btn btn-default btn-file">
                            <i class="fas fa-paperclip"></i> Adjuntar Archivo
                            <p><label for="pdf_archivo_editar">
                                <input type="file" name="pdf_archivo_editar" id="pdf_ordenServicio_editar">
                            </label></p>

                        </div><br>

                        <p class="help-block small">Tamaño máximo de archivos: 20MB</p>
                    </div>
                    <div class="input-group mb-3" style="display:none;">
                        <div class="input-group-append input-group-text">
                            <i class="fas fa-angle-double-right"></i>
                        </div>

                        <input type="hidden" class="form-control" name="pdf_archivo_editar_actual" id="pdf_archivo_editar_actual"
                         required autofocus
                        style="text-transform: uppercase;">
                    </div>{{-- fin pdf actual --}}
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


{{-- fin del modal editar orden del servicio  --}}



{{-- Editar departamento en modal --}}

{{-- @if (isset($status))

@if ($status == 200)

    @foreach ($ordenServicio as $key => $value)

    <div class="modal" id="editarOrdenServicio">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ url('/') }}/ordenServicios/{{ $value["id_ordenServicio"] }}"
                enctype="multipart/form-data">

                @method('PUT')
                @csrf

                <div class="modal-header bg-info">
                    <h4 class="modal-tittle">Editar Orden de Servicio</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <div class="input-group mb-3">
                        <div class="input-group-append input-group-text">
                            <i class="fas fa-angle-double-right"></i>
                        </div>

                        <input type="text" class="form-control" name="codigo_ordenServicio"
                        value="{{ $value["codigo_ordenServicio"] }}" required autofocus
                        style="text-transform: uppercase;">
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-append input-group-text">
                            <i class="fas fa-angle-double-right"></i>
                        </div>

                        <input type="date" class="form-control" name="fecha_ordenServicio"
                        value="{{ $value["fecha_ordenServicio"] }}" required autofocus
                        style="text-transform: uppercase;">
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-append input-group-text">
                            <i class="fas fa-angle-double-right"></i>
                        </div>

                        <input type="text" class="form-control" name="expediente_ordenServicio"
                        value="{{ $value["expediente_ordenServicio"] }}" required autofocus
                        style="text-transform: uppercase;">
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-append input-group-text">
                            <i class="fas fa-angle-double-right"></i>
                        </div>

                        <input type="text" class="form-control" name="monto_ordenServicio"
                        value="{{ $value["monto_ordenServicio"] }}" required autofocus
                        style="text-transform: uppercase;">
                    </div>

                        <hr class="pb-2">
                            <div class="form-group my-2 text-center">
                                <div class="btn btn-default btn-file">
                                    <i class="fas fa-paperclip"></i> Adjuntar Archivo
                                    <p><label for="pdf_archivo_editar">
                                        <input type="file" name="pdf_archivo_editar" id="pdf_ordenServicio_editar">
                                    </label></p>

                                </div><br>

                                <p class="help-block small">Tamaño máximo de archivos: 20MB</p>
                            </div>

                    <div class="input-group mb-3" style="display:none;">
                        <div class="input-group-append input-group-text">
                            <i class="fas fa-angle-double-right"></i>
                        </div>

                        <input type="text" class="form-control" name="pdf_archivo_editar_actual"
                        value="{{ $value["pdf_ordenServicio"] }}" required autofocus
                        style="text-transform: uppercase;">
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
        $("#editarOrdenServicio").modal();
    </script>

  @else

  {{$status}}

@endif

@endif --}}

@if (Session::has("ok-crear"))
  <script>
      notie.alert({type:1,text:'!La orden de Servicio ha sido creado correctamente', time:10})
  </script>
@endif

@if (Session::has("orden-existe"))
  <script>
      notie.alert({type:2,text:'!La orden de Servicio ya existe en nuestros registros', time:10})
  </script>
@endif

@if (Session::has("no-validacion"))
  <script>
      notie.alert({type:2,text:'!Hay campos no válidos en el formulario', time:10})
  </script>
@endif

@if (Session::has("error"))
  <script>
      notie.alert({type:3,text:'!Error en el gestor de orden de Servicio', time:10})
  </script>
@endif

@if (Session::has("ok-editar"))
  <script>
      notie.alert({type:1,text:'!La orden de Servicio ha sido actualizado correctamente', time:10})
  </script>
@endif

@if (Session::has("ok-eliminar"))

<script>
    notie.alert({ type: 1, text: '¡La orden de Servicio ha sido eliminado correctamente!', time: 10 })
</script>

@endif

@if (Session::has("no-borrar"))

<script>
    notie.alert({ type: 2, text: '¡Este administrador no se puede borrar!', time: 10 })
</script>

@endif

@if (Session::has("no-pdf"))

<script>
    notie.alert({ type: 2, text: '¡El archivo PDF es requerido!', time: 10 })
</script>

@endif

@endsection

@endif

@endforeach
