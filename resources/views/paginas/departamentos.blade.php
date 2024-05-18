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
            <h1>Departamentos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url("/") }}">Inicio</a></li>
              <li class="breadcrumb-item active">Departamentos</li>
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
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#crearDepartamento">
                    Crear nuevo departamento</button>
              </div>
              <div class="card-body">

                <table class="table table-bordered table-striped dt-responsive" width="100%"
                 id="tablaDepartamentos">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Departamento</th>
                            <th>Iniciales</th>
                            <th>Estado</th>
                            <th>Dirección Ejecutiva</th>
                            <th>Acciones</th>
                        </tr>

                    </thead>

                    <tbody>
                        {{-- Todo se ejecuta desde el controlador (parte servidor) --}}
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

  {{-- @foreach ($departamentos as $departamento) --}}
  <div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-tittle">Editar Departamento</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="input-group mb-3">

                        <label for="email" class="col-md-3 control-label">Nombre:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" id="nombre_departamento" name="nombre_departamento"
                            required autofocus
                            style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin nombre de departamento --}}
                    <div class="input-group mb-3">

                        <label for="email" class="col-md-3 control-label">Iniciales:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control"  id="iniciales_departamento" name="iniciales_departamento" 
                             required autofocus
                            style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin iniciales de departamento --}}
                    <div class="input-group mb-3">

                        <label for="email" class="col-md-3 control-label">Estado:</label>

                        <div class="col-md-6">
                            <select class="form-control" id="estado_departamento" name="estado_departamento" required>
                            @foreach ($estado as $key => $value1)

                                <option value="{{$value1->id_estado}}">
                                    {{$value1->nombre_estado}}
                                </option>

                            @endforeach
                            </select>
                        </div>
                    </div>{{-- fin estado de departamento --}}
                    <div class="input-group mb-3">

                        <label for="email" class="col-md-3 control-label">Dir. Ejecutiva:</label>

                        <div class="col-md-8">
                            <select class="form-control" id ="id_direccionEjecutiva" name="id_direccionEjecutiva" required>
                                    @foreach ($direccionesEjecutivas as $key => $value1)

                                        <option value="{{$value1->id_direccionEjecutiva}}">
                                            {{$value1->nombre_direccionEjecutiva}}
                                        </option>

                                    @endforeach
                                </select>
                        </div>
                    </div>{{-- fin id de dirección Ejecutiva --}}
                  
                    
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

    
  <div class="modal" id="crearDepartamento">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ url('/') }}/departamentos">
                @csrf

                <div class="modal-header bg-info">
                    <h4 class="modal-tittle">Crear Departamento</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="input-group mb-3">
                        <div class="input-group-append input-group-text">
                            <i class="fas fa-angle-double-right"></i>
                        </div>

                        <input type="text" class="form-control" name="nombre_departamento"
                        value="{{ old("nombre_departamento") }}" required autofocus
                        placeholder="Ingrese el Departamento" style="text-transform: uppercase;">
                    </div>{{-- fin nombre de departamento --}}

                    <div class="input-group mb-3">
                        <div class="input-group-append input-group-text">
                            <i class="fas fa-angle-double-right"></i>
                        </div>

                        <input type="text" class="form-control" name="iniciales_departamento"
                        value="{{ old("iniciales_departamento") }}" required autofocus
                        placeholder="Ingrese las iniciales" style="text-transform: uppercase;">
                    </div>{{-- fin iniciales de departamento --}}

                    <div class="input-group mb-3">
                        <div class="input-group-append input-group-text">
                            <i class="fas fa-angle-double-right"></i>
                        </div>

                        <select class="form-control" name="estado_departamento" required>
                            <option value="">
                                -- Seleccionar el Estado (Activo o Inactivo) --
                            </option>
                            <option value="1">Activo</option>
                            <option value="2">Inactivo</option>
                        </select>
                    </div>{{-- fin estado de departamento --}}

                    <div class="input-group mb-3">
                        <div class="input-group-append input-group-text">
                            <i class="fas fa-angle-double-right"></i>
                        </div>


                            <select class="form-control" name="id_direccionEjecutiva" required>
                                <option value="">
                                    -- Seleccionar la Dirección Ejecutiva --
                                </option>

                                @foreach ($direccionesEjecutivas as $key => $value)
                                    <option value="{{$value->id_direccionEjecutiva}}">
                                        {{$value->nombre_direccionEjecutiva}}
                                    </option>
                                @endforeach
                            </select>

                    </div>{{-- fin id de dirección Ejecutiva --}}

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

  <!-- Modal -->


{{-- Editar departamento en modal --}}

{{-- @if (isset($status))

@if ($status == 200)

    @foreach ($departamento as $key => $value)

    <div class="modal fade" id="editarDepartamento" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ url('/') }}/departamentos/{{ $value["id_departamento"] }}"
                enctype="multipart/form-data">

                @method('PUT')
                @csrf

                <div class="modal-header bg-info">
                    <h4 class="modal-tittle">Editar Departamento</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <div class="input-group mb-3">

                        <label for="email" class="col-md-3 control-label">Nombre:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" name="nombre_departamento"
                            value="{{$value["nombre_departamento"]}}" required autofocus
                            style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="input-group mb-3">

                        <label for="email" class="col-md-3 control-label">Iniciales:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" name="iniciales_departamento"
                            value="{{$value["iniciales_departamento"]}}" required autofocus
                            style="text-transform: uppercase;">
                        </div>
                    </div>

      
                    <div class="input-group mb-3">

                        <label for="email" class="col-md-3 control-label">Estado:</label>

                        <div class="col-md-6">
                            <select class="form-control" name="estado_departamento" required>
                            @foreach ($departamento_estado as $key => $value1)

                                <option value="{{$value1->estado_departamento}}">
                                    {{$value1->nombre_estado}}
                                </option>

                                @foreach ($estado as $key => $value2)

                                        @if ($value2->id_estado != $value1->estado_departamento)
                                            <option value="{{$value2->id_estado}}">
                                                {{$value2->nombre_estado}}
                                            </option>
                                        @endif

                                @endforeach

                            @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="input-group mb-3">

                        <label for="email" class="col-md-3 control-label">Dir. Ejecutiva:</label>

                        <div class="col-md-8">
                            <select class="form-control" name="id_direccionEjecutiva" required>
                                    @foreach ($departamento_direccionEjecutiva as $key => $value1)

                                        <option value="{{$value1->id_direccionEjecutiva}}">
                                            {{$value1->nombre_direccionEjecutiva}}
                                        </option>

                                        @foreach ($direccionesEjecutivas as $key => $value2)

                                            @if ($value2->id_direccionEjecutiva != $value1->id_direccionEjecutiva)
                                                <option value="{{$value2->id_direccionEjecutiva}}">
                                                    {{$value2->nombre_direccionEjecutiva}}
                                                </option>
                                            @endif

                                        @endforeach

                                    @endforeach
                                </select>
                        </div>
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
        $("#editarDepartamento").modal();
    </script>

  @else

  {{$status}}

@endif

@endif --}}

@if (Session::has("ok-crear"))
  <script>
      notie.alert({type:1,text:'!El Departamento ha sido creado correctamente', time:10})
  </script>
@endif

@if (Session::has("no-validacion"))
  <script>
      notie.alert({type:2,text:'!Hay campos no válidos en el formulario', time:10})
  </script>
@endif

@if (Session::has("error"))
  <script>
      notie.alert({type:3,text:'!Error en el gestor de departamentos', time:10})
  </script>
@endif

@if (Session::has("ok-editar"))
  <script>
      notie.alert({type:1,text:'!El departamento ha sido actualizado correctamente', time:10})
  </script>
@endif

@if (Session::has("ok-eliminar"))

<script>
    notie.alert({ type: 1, text: '¡El departamento ha sido eliminado correctamente!', time: 10 })
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

