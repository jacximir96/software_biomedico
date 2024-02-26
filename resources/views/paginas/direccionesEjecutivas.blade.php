@foreach ($administradores as $element)



@extends('plantilla')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Direcciones Ejecutivas</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url("/") }}">Inicio</a></li>
              <li class="breadcrumb-item active">Direcciones Ejecutivas</li>
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
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#crearDireccionEjecutiva">
                    Crear nueva Dirección Ejecutiva</button>
              </div>
              <div class="card-body">

                <table class="table table-bordered table-striped dt-responsive" width="100%"
                 id="tablaDireccionesEjecutivas">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Dirección Ejecutiva</th>
                            <th>Iniciales</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>

                    </thead>

                    <tbody>

                      
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

  <div class="modal" id="crearDireccionEjecutiva">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ url('/') }}/direccionesEjecutivas">
                @csrf

                <div class="modal-header bg-info">
                    <h4 class="modal-tittle">Crear Dirección Ejecutiva</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="input-group mb-3">
                        <div class="input-group-append input-group-text">
                            <i class="fas fa-angle-double-right"></i>
                        </div>

                        <input type="text" class="form-control" name="nombre_direccionEjecutiva"
                        value="{{ old("nombre_direccionEjecutiva") }}" required autofocus
                        placeholder="Ingrese la dirección Ejecutiva" style="text-transform: uppercase;">
                    </div>{{-- fin nombre de dirección Ejecutiva --}}

                    <div class="input-group mb-3">
                        <div class="input-group-append input-group-text">
                            <i class="fas fa-angle-double-right"></i>
                        </div>

                        <input type="text" class="form-control" name="iniciales_direccionEjecutiva"
                        value="{{ old("iniciales_direccionEjecutiva") }}" required autofocus
                        placeholder="Ingrese las iniciales" style="text-transform: uppercase;">
                    </div>{{-- fin iniciales de dirección Ejecutiva --}}

                    <div class="input-group mb-3">
                        <div class="input-group-append input-group-text">
                            <i class="fas fa-angle-double-right"></i>
                        </div>

                        <select class="form-control" name="estado_direccionEjecutiva" required>
                            <option value="1">Activo</option>
                            <option value="2">Inactivo</option>
                        </select>
                    </div>{{-- fin estado de dirección Ejecutiva --}}

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



 
  <div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-tittle">Editar Dirección Ejecutiva</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="input-group mb-3">

                        <label for="email" class="col-md-3 control-label">Nombre:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" name="nombre_direccionEjecutiva"  id="nombre_direccionEjecutiva"
                            required autofocus
                            style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin nombre de dirección Ejecutiva --}}
                    <div class="input-group mb-3">

                        <label for="email" class="col-md-3 control-label">Iniciales:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" name="iniciales_direccionEjecutiva"  id="iniciales_direccionEjecutiva"
                             required autofocus
                            style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin iniciales de dirección Ejecutiva --}}

                    {{-- Estado --}}
                    <div class="input-group mb-3">

                        <label for="email" class="col-md-3 control-label">Estado:</label>

                        <div class="col-md-8">
                            <select class="form-control"  id="estado_direccionEjecutiva" name="estado_direccionEjecutiva" required>


                                @foreach ($estado as $key => $value2)

                                        
                                            <option value="{{$value2->id_estado}}">
                                                {{$value2->nombre_estado}}
                                            </option>
                                        

                                @endforeach

                          
                            </select>
                        </div>
                    </div>{{-- fin estado de dirección Ejecutiva --}}

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
  {{-- Editar Administrador en modal --}}

@if (isset($status))

@if ($status == 200)

    @foreach ($direccionEjecutiva as $key => $value)

    <div class="modal" id="editarDireccionEjecutiva">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ url('/') }}/direccionesEjecutivas/{{ $value["id_direccionEjecutiva"] }}"
                enctype="multipart/form-data">

                @method('PUT')
                @csrf

                <div class="modal-header bg-info">
                    <h4 class="modal-tittle">Editar Dirección Ejecutiva</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    {{-- Nombre --}}
                    <div class="input-group mb-3">

                        <label for="email" class="col-md-3 control-label">Nombre:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" name="nombre_direccionEjecutiva"
                            value="{{$value["nombre_direccionEjecutiva"]}}" required autofocus
                            style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin nombre de dirección Ejecutiva --}}

                    {{-- Iniciales --}}
                    <div class="input-group mb-3">

                        <label for="email" class="col-md-3 control-label">Iniciales:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" name="iniciales_direccionEjecutiva"
                            value="{{$value["iniciales_direccionEjecutiva"]}}" required autofocus
                            style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin iniciales de dirección Ejecutiva --}}

                    {{-- Estado --}}
                    <div class="input-group mb-3">

                        <label for="email" class="col-md-3 control-label">Estado:</label>

                        <div class="col-md-8">
                            <select class="form-control" name="estado_direccionEjecutiva" required>
                            @foreach ($direccion_estado as $key => $value1)

                                <option value="{{$value1->estado_direccionEjecutiva}}">
                                    {{$value1->nombre_estado}}
                                </option>

                                @foreach ($estado as $key => $value2)

                                        @if ($value2->id_estado != $value1->estado_direccionEjecutiva)
                                            <option value="{{$value2->id_estado}}">
                                                {{$value2->nombre_estado}}
                                            </option>
                                        @endif{{-- Aparece todo menos el que es diferente --}}

                                @endforeach

                            @endforeach
                            </select>
                        </div>
                    </div>{{-- fin estado de dirección Ejecutiva --}}

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
        $("#editarDireccionEjecutiva").modal();
    </script>

  @else

  {{$status}}

@endif

@endif

@if (Session::has("ok-crear"))
    <script>
        notie.alert({type:1,text:'!La Dirección Ejecutiva ha sido creado correctamente', time:10})
    </script>
@endif

@if (Session::has("no-validacion"))
    <script>
        notie.alert({type:2,text:'!Hay campos no válidos en el formulario', time:10})
    </script>
@endif

@if (Session::has("error"))
    <script>
        notie.alert({type:3,text:'!Error en el gestor de profesionales', time:10})
    </script>
@endif

@if (Session::has("ok-editar"))
    <script>
        notie.alert({type:1,text:'!La Dirección Ejecutiva ha sido actualizado correctamente', time:10})
    </script>
@endif

@if (Session::has("ok-eliminar"))

  <script>
      notie.alert({ type: 1, text: '¡La Dirección Ejecutiva ha sido eliminado correctamente!', time: 10 })
 </script>

@endif

@if (Session::has("no-borrar"))

  <script>
      notie.alert({ type: 2, text: '¡Este administrador no se puede borrar!', time: 10 })
 </script>

@endif

@endsection

@endforeach