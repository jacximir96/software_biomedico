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
                    <h1>Tipos de Mantenimientos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url("/") }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Tipos de Mantenimientos</li>
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
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#crearTipoMantenimiento">
                            Crear nuevo tipo de Mantenimiento</button>
                        </div>

        <div class="card-body">

                <table class="table table-bordered table-striped dt-responsive" width="100%"
                 id="tablaTipoMantenimientos">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Mantenimiento</th>
                            <th>Estado</th>
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

<div class="modal" id="crearTipoMantenimiento">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ url('/') }}/tipoMantenimientos">
                @csrf

                <div class="modal-header bg-info">
                    <h4 class="modal-tittle">Crear tipo de Mantenimiento</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="input-group mb-3">
                        <div class="input-group-append input-group-text">
                            <i class="fas fa-angle-double-right"></i>
                        </div>

                        <input type="text" class="form-control" name="nombre_mantenimiento"
                        value="{{ old("nombre_mantenimiento") }}" required autofocus
                        placeholder="Ingrese el tipo de Mantenimiento" style="text-transform: uppercase;">
                    </div>{{-- fin nombre de mantenimiento --}}

                    <div class="input-group mb-3">
                        <div class="input-group-append input-group-text">
                            <i class="fas fa-angle-double-right"></i>
                        </div>

                        <select class="form-control" name="estado_mantenimiento" required>
                            <option value="">
                                -- Seleccionar el Estado (Activo o Inactivo) --
                            </option>

                            @foreach($estados as $key => $valorEstado)
                                <option value="{{$valorEstado->id_estado}}">{{$valorEstado->nombre_estado}}</option>
                            @endforeach
                        </select>
                    </div>{{-- fin estado de mantenimiento --}}
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
 {{-- editar modal  --}}
@foreach ($tipoMantenimientos as $value)
   
    <div class="modal fade" id="exampleModalLong{{$value->id_mantenimiento}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-tittle">Editar tipo de Mantenimiento</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ url('/') }}/tipoMantenimientos/{{ $value->id_mantenimiento}}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                
                    {{-- Nombre --}}
                    <div class="input-group mb-3">
                        <div class="input-group-append input-group-text">
                            <i class="fas fa-angle-double-right"></i>
                        </div>
    
                        <input type="text" class="form-control" name="nombre_mantenimiento"
                        value="{{$value["nombre_mantenimiento"]}}" required autofocus
                        style="text-transform: uppercase;">
                    </div>{{-- fin nombre de mantenimiento --}}
    
                    <div class="input-group mb-3">
                        <div class="input-group-append input-group-text">
                            <i class="fas fa-angle-double-right"></i>
                        </div>
    
                        <select class="form-control" name="estado_mantenimiento" required>
                                @foreach ($estado_mantenimiento as $key => $value1)
                                    <option value="{{$value1->id_estado}}"
                                        @if ($value1->id_estado == $value->estado_mantenimiento)
                                            selected
                                        @endif 
                                        >{{$value1->nombre_estado}}</option>
    
                                @endforeach
                            </select>
                    </div>{{-- fin estado del tipo de Mantenimiento --}}
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
    {{-- fin editar modal  --}}

{{-- Editar ambiente en modal --}}

@if (isset($status))

@if ($status == 200)

    @foreach ($mantenimiento as $key => $value)

    <div class="modal" id="editarTipoMantenimiento">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ url('/') }}/tipoMantenimientos/{{ $value["id_mantenimiento"] }}"
                enctype="multipart/form-data">

                @method('PUT')
                @csrf

                <div class="modal-header bg-info">
                    <h4 class="modal-tittle">Editar tipo de Mantenimiento</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    {{-- Nombre --}}
                    <div class="input-group mb-3">
                        <div class="input-group-append input-group-text">
                            <i class="fas fa-angle-double-right"></i>
                        </div>

                        <input type="text" class="form-control" name="nombre_mantenimiento"
                        value="{{$value["nombre_mantenimiento"]}}" required autofocus
                        style="text-transform: uppercase;">
                    </div>{{-- fin nombre de mantenimiento --}}

                    <div class="input-group mb-3">
                        <div class="input-group-append input-group-text">
                            <i class="fas fa-angle-double-right"></i>
                        </div>

                        <select class="form-control" name="estado_mantenimiento" required>
                                @foreach ($estado_mantenimiento as $key => $value1)
                                    <option value="{{$value1->id_estado}}">
                                        {{$value1->nombre_estado}}
                                    </option>

                                    @foreach ($estados as $key => $value2)

                                        @if ($value2->id_estado != $value1->estado_mantenimiento)
                                            <option value="{{$value2->id_estado}}">
                                                {{$value2->nombre_estado}}
                                            </option>
                                        @endif{{-- Aparece todo menos el que es diferente --}}

                                    @endforeach

                                @endforeach
                            </select>
                    </div>{{-- fin estado del tipo de Mantenimiento --}}
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
        $("#editarTipoMantenimiento").modal();
    </script>

  @else

  {{$status}}

@endif

@endif

@if (Session::has("ok-crear"))
  <script>
      notie.alert({type:1,text:'!El tipo de Mantenimiento ha sido creado correctamente', time:10})
  </script>
@endif

@if (Session::has("no-validacion"))
  <script>
      notie.alert({type:2,text:'!Hay campos no válidos en el formulario', time:10})
  </script>
@endif

@if (Session::has("error"))
  <script>
      notie.alert({type:3,text:'!Error en el gestor de tipo de Mantenimiento', time:10})
  </script>
@endif

@if (Session::has("ok-editar"))
  <script>
      notie.alert({type:1,text:'!El tipo de Mantenimiento ha sido actualizado correctamente', time:10})
  </script>
@endif

@if (Session::has("ok-eliminar"))

<script>
    notie.alert({ type: 1, text: '¡El tipo de Mantenimiento ha sido eliminado correctamente!', time: 10 })
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
