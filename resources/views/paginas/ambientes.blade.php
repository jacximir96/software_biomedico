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
            <h1>Ambientes</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url("/") }}">Inicio</a></li>
              <li class="breadcrumb-item active">Ambientes</li>
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
                @can("crear_ambientes")
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#crearAmbiente">
                    Crear nuevo ambiente
                </button>
                @endcan
              </div>
              <div class="card-body">

                <table class="table table-bordered table-striped dt-responsive" width="100%"
                 id="tablaAmbientes">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Ambiente</th>
                            <th>Estado</th>
                            <th>Departamento</th>
                            <th>Dirección Ejecutiva</th>
                            <th>Acciones</th>
                        </tr>

                    </thead>

                    <tbody>
                    @foreach ($ambientes_general as $key => $data)
                        <tr>
                            <td style="text-align: center;">{{($key+1)}}</td>
                            <td style="text-align: center; text-transform: uppercase;">{{$data->nombre_ambiente}}</td>
                            <td style="text-align: center; text-transform: uppercase;">{{$data->nombre_estado}}</td>
                            <td style="text-align: center; text-transform: uppercase;">{{$data->nombre_departamento}}</td>
                            <td style="text-align: center; text-transform: uppercase;">
                                @if($data->id_departamento == '')
                                    {{$data->nombre_direccionAmbiente}}
                                @else
                                    {{$data->nombre_direccionDepartamento}}
                                @endif
                            </td>

                            <td style="text-align: center;">
                                <div class="btn-group">
                                    @can("editar_ambientes")
                                    <a href="{{url('/')}}/ambientes/{{$data->id_ambiente}}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-pencil-alt text-white"></i>
                                    </a>
                                    @endcan

                                    @can("eliminar_ambientes")
                                    <button class="btn btn-danger btn-sm eliminarRegistro" action="{{url('/')}}/ambientes/{{$data->id_ambiente}}"
                                        method="DELETE" pagina="ambientes" token="{{ csrf_token() }}">
                                        @csrf
                                        <i class="fas fa-trash-alt text-white"></i>
                                    </button>
                                    @endcan

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

  <div class="modal" id="crearAmbiente">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ url('/') }}/ambientes">
                @csrf

                <div class="modal-header bg-info">
                    <h4 class="modal-tittle">Crear Ambiente</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="input-group mb-3">
                        <div class="input-group-append input-group-text">
                            <i class="fas fa-angle-double-right"></i>
                        </div>

                        <input type="text" class="form-control" name="nombre_ambiente"
                        value="{{ old("nombre_ambiente") }}" required autofocus
                        placeholder="Ingrese el Ambiente" style="text-transform: uppercase;">
                    </div>{{-- fin nombre de ambiente --}}

                    <div class="input-group mb-3">
                        <div class="input-group-append input-group-text">
                            <i class="fas fa-angle-double-right"></i>
                        </div>

                        <select class="form-control" name="estado_ambiente" required>
                            <option value="">
                                -- Seleccionar el Estado (Activo o Inactivo) --
                            </option>
                            <option value="1">Activo</option>
                            <option value="2">Inactivo</option>
                        </select>
                    </div>{{-- fin estado de ambiente --}}

                    <div class="input-group mb-3">
                        <div class="input-group-append input-group-text">
                            <i class="fas fa-angle-double-right"></i>
                        </div>


                            <select class="form-control" name="id_departamento" id="id_departamento_a">
                                <option value="">
                                    -- Seleccionar el Departamento --
                                </option>

                                @foreach ($departamentos as $key => $value)
                                    <option value="{{$value->id_departamento}}">
                                        {{$value->nombre_departamento}}
                                    </option>
                                @endforeach
                            </select>

                    </div>{{-- fin id de departamento --}}

                    <div class="input-group mb-3" id="id_direccionEjecutiva_a">
                        <div class="input-group-append input-group-text">
                            <i class="fas fa-angle-double-right"></i>
                        </div>


                            <select class="form-control" name="id_direccionEjecutiva">
                                <option value="">
                                    -- Seleccionar la Dirección Ejecutiva --
                                </option>

                                @foreach ($direccionesEjecutivas as $key => $value)
                                    <option value="{{$value->id_direccionEjecutiva}}">
                                        {{$value->nombre_direccionEjecutiva}}
                                    </option>
                                @endforeach
                            </select>

                    </div>{{-- fin id de direccionEjecutiva --}}

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

  {{-- Editar ambiente en modal --}}

@if (isset($status))

@if ($status == 200)

    @foreach ($ambiente as $key => $value)

    <div class="modal" id="editarAmbiente">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ url('/') }}/ambientes/{{ $value["id_ambiente"] }}"
                enctype="multipart/form-data">

                @method('PUT')
                @csrf

                <div class="modal-header bg-info">
                    <h4 class="modal-tittle">Editar Ambiente</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    {{-- Nombre --}}
                    <div class="input-group mb-3">

                        <label for="email" class="col-md-3 control-label">Nombre:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" name="nombre_ambiente"
                            value="{{$value["nombre_ambiente"]}}" required autofocus
                            style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin nombre de ambiente --}}

                    {{-- Estado --}}
                    <div class="input-group mb-3">

                        <label for="email" class="col-md-3 control-label">Estado:</label>

                        <div class="col-md-6">
                            <select class="form-control" name="estado_ambiente" required>
                            @foreach ($ambiente_estado as $key => $value1)

                                <option value="{{$value1->estado_ambiente}}">
                                    {{$value1->nombre_estado}}
                                </option>

                                @foreach ($estado as $key => $value2)

                                        @if ($value2->id_estado != $value1->estado_ambiente)
                                            <option value="{{$value2->id_estado}}">
                                                {{$value2->nombre_estado}}
                                            </option>
                                        @endif{{-- Aparece todo menos el que es diferente --}}

                                @endforeach

                            @endforeach
                            </select>
                        </div>
                    </div>{{-- fin estado de ambiente --}}

                    <div class="input-group mb-3">

                        <label for="email" class="col-md-3 control-label">Departamento:</label>

                        <div class="col-md-8">
                            <select class="form-control" name="id_departamento" id="id_departamento_b">
                                @foreach ($ambiente_departamento as $key => $value1)

                                    <option value="{{$value1->id_departamento}}">
                                        {{$value1->nombre_departamento}}
                                    </option>

                                    @foreach ($departamentos as $key => $value2)

                                        @if ($value2->id_departamento != $value1->id_departamento)
                                            <option value="{{$value2->id_departamento}}">
                                                {{$value2->nombre_departamento}}
                                            </option>
                                        @endif{{-- Aparece todo menos el que es diferente --}}

                                    @endforeach

                                @endforeach
                            </select>
                        </div>
                    </div>{{-- fin id de departamento --}}

                    <div class="input-group mb-3" id="id_direccionEjecutiva_c">

                    <label for="email" class="col-md-3 control-label">Dir. Ejecutiva:</label>

                    <div class="col-md-8">
                        <select class="form-control" name="id_direccionEjecutiva">
                            @foreach ($ambiente_direccionEjecutiva as $key => $value1)

                                <option value="{{$value1->id_direccionEjecutiva}}">
                                    {{$value1->nombre_direccionEjecutiva}}
                                </option>

                                @foreach ($direccionesEjecutivas as $key => $value2)

                                    @if ($value2->id_direccionEjecutiva != $value1->id_direccionEjecutiva)
                                        <option value="{{$value2->id_direccionEjecutiva}}">
                                            {{$value2->nombre_direccionEjecutiva}}
                                        </option>
                                    @endif{{-- Aparece todo menos el que es diferente --}}

                                @endforeach

                            @endforeach
                        </select>
                    </div>
                    </div>{{-- fin id de direccion Ejecutiva --}}

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
        $("#editarAmbiente").modal();
    </script>

  @else

  {{$status}}

@endif

@endif

@if (Session::has("ok-crear"))
  <script>
      notie.alert({type:1,text:'!El ambiente ha sido creado correctamente', time:10})
  </script>
@endif

@if (Session::has("no-validacion"))
  <script>
      notie.alert({type:2,text:'!Hay campos no válidos en el formulario', time:10})
  </script>
@endif

@if (Session::has("error"))
  <script>
      notie.alert({type:3,text:'!Error en el gestor de Ambientes', time:10})
  </script>
@endif

@if (Session::has("ok-editar"))
  <script>
      notie.alert({type:1,text:'!El ambiente ha sido actualizado correctamente', time:10})
  </script>
@endif

@if (Session::has("ok-eliminar"))

<script>
    notie.alert({ type: 1, text: '¡El ambiente ha sido eliminado correctamente!', time: 10 })
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

