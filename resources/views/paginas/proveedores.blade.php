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
            <h1>Proveedores</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url("/") }}">Inicio</a></li>
              <li class="breadcrumb-item active">Proveedores</li>
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
                @can("crear_proveedores")
                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#consultaSunat">
                    Consulta y/o guardado de datos (SUNAT)
                </button>
                @endcan
              </div>
              <div class="card-body">

                <table class="table table-bordered table-striped dt-responsive" width="100%"
                 id="tablaProveedores">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>RUC</th>
                            <th>Razón Social</th>
                            <th>Estado</th>
                            <th>Dirección</th>
                            <th>Distrito</th>
                            <th>Provincia</th>
                            <th>Departamento</th>
                            <th>Acciones</th>
                        </tr>

                    </thead>

                    <tbody>

                    @foreach ($proveedores as $key => $data)
                        <tr>
                            <td>{{($key+1)}}</td>
                            <td>{{$data->ruc_proveedor}}</td>
                            <td style="text-transform: uppercase;">{{$data->razonSocial_proveedor}}</td>
                            <td style="text-transform: uppercase;">{{$data->estado_proveedor}}</td>
                            <td style="text-transform: uppercase;">{{$data->direccion_proveedor}}</td>
                            <td style="text-transform: uppercase;">{{$data->distrito_proveedor}}</td>
                            <td style="text-transform: uppercase;">{{$data->provincia_proveedor}}</td>
                            <td style="text-transform: uppercase;">{{$data->departamento_proveedor}}</td>
                            </td>
                            <td>
                                <div class="btn-group">
                                    @can("editar_proveedores")
                                    <a href="{{url('/')}}/proveedores/{{$data->id_proveedor}}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-pencil-alt text-white"></i>
                                    </a>
                                    @endcan

                                    @can("eliminar_proveedores")
                                    <button class="btn btn-danger btn-sm eliminarRegistro" action="{{url('/')}}/proveedores/{{$data["id_proveedor"]}}"
                                        method="DELETE" pagina="proveedores" token="{{ csrf_token() }}">
                                        <!-- @csrf -->
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

<div class="modal" id="consultaSunat">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ url('/') }}/proveedores" class="form-horizontal">
            @csrf

                <div class="modal-header bg-info">
                    <h4 class="modal-tittle">Consulta Sunat</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                        <div class="input-group mb-3">
                            <label for="email" class="col-md-3 control-label">NUMERO RUC:</label>

                            <div class="col-md-6">
                                <input id="ruc" name="ruc" type="text" class="form-control inputRuta" name="ruc" value="" placeholder="Escribe RUC" required autofocus maxlength="11">
                            </div>

                            <div class="col-md-3">
                                <button type="button" class="btn btn-danger" id="btnbuscar">
                                <i class="fa fa-search"></i> Buscar
                                </button>
                            </div>
                        </div>{{-- fin nombre de rol --}}

                        <div class="form-group">
                            <div class="col-md-3"></div>
                            <div class="col-md-5">
                                <small id="mensaje" style="color: red;display: none;font-size: 12pt;" >
                                    <i class="fa fa-remove"></i> El numero de RUC no es valido.
                                </small>
                            </div>
                        </div>

                        <hr>

                        <!-- <div class="row"> -->
                            <!-- <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12"></div> -->
                            <!-- <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"> -->

                                <div class="input-group mb-3">
                                    <label for="email" class="col-md-3 control-label">RUC:</label>
                                    <div class="col-md-6">
                                        <input id="txtdni" name="txtdni" type="text" class="form-control"  placeholder="RUC" readonly="">
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <label for="email" class="col-md-3 control-label">Razón Social:</label>
                                    <div class="col-md-8">
                                        <textarea id="txtrazon" name="txtrazon" class="form-control" placeholder="Razon social" readonly=""></textarea>
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <label for="email" class="col-md-3 control-label">Estado:</label>
                                    <div class="col-md-6">
                                        <input id="txtgrupo" name="txtgrupo" type="text" class="form-control"  placeholder="Estado" readonly="">
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <label for="email" class="col-md-3 control-label">Direccion: <i class="fa fa-map-marker"></i> </label>
                                    <div class="col-md-8">
                                    <textarea id="txtdireccion" name="txtdireccion" class="form-control" placeholder="Direccion" readonly="" rows="2"></textarea>
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <label for="email" class="col-md-3 control-label">Distrito:</label>
                                    <div class="col-md-7">
                                        <input id="txtdistrito" name="txtdistrito" type="text" class="form-control"  placeholder="Distrito" readonly="">
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <label for="email" class="col-md-3 control-label">Provincia:</label>
                                    <div class="col-md-7">
                                        <input id="txtprovincia" name="txtprovincia" type="text" class="form-control"  placeholder="Provincia" readonly="">
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <label for="email" class="col-md-3 control-label">Departamento:</label>
                                    <div class="col-md-7">
                                        <input id="txtdepartamento" name="txtdepartamento" type="text" class="form-control"  placeholder="Departamento" readonly="">
                                    </div>
                                </div>
                           <!--  </div>
                        </div> -->
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

@if (isset($status))

@if ($status == 200)

    @foreach ($proveedor as $key => $value)

    <div class="modal" id="editarProveedor">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ url('/') }}/proveedores/{{$value["id_proveedor"]}}"
                enctype="multipart/form-data">

                @method('PUT')
                @csrf

                <div class="modal-header bg-info">
                    <h4 class="modal-tittle">Editar Proveedor</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    {{-- Ruc --}}
                    <div class="input-group mb-3">

                        <label for="email" class="col-md-3 control-label">RUC:</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="txtdni"
                            value="{{$value["ruc_proveedor"]}}" required autofocus
                            style="text-transform: uppercase;" readonly="">
                        </div>
                    </div>{{-- fin ruc --}}

                    {{-- Razon Social --}}
                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Razón Social:</label>

                        <div class="col-md-8">
                            <textarea class="form-control" name="txtrazon" required autofocus style="text-transform: uppercase;" readonly="">{{$value["razonSocial_proveedor"]}}</textarea>
                        </div>
                    </div>{{-- fin razon social --}}

                    {{-- Estado --}}
                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Estado:</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="txtgrupo"
                            value="{{$value["estado_proveedor"]}}" required autofocus
                            style="text-transform: uppercase;" readonly="">
                        </div>
                    </div>{{-- fin estado --}}

                    {{-- Direccion --}}
                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Direccion: <i class="fa fa-map-marker"></i> </label>

                        <div class="col-md-8">
                            <textarea class="form-control" name="txtdireccion" required autofocus style="text-transform: uppercase;">{{$value["direccion_proveedor"]}}</textarea>
                        </div>
                    </div>{{-- fin DIRECCION --}}

                    {{-- Distrito --}}
                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Distrito:</label>

                        <div class="col-md-7">
                            <input type="text" class="form-control" name="txtdistrito"
                            value="{{$value["distrito_proveedor"]}}" required autofocus
                            style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin distrito --}}

                    {{-- provincia --}}
                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Provincia:</label>

                        <div class="col-md-7">
                            <input type="text" class="form-control" name="txtprovincia"
                            value="{{$value["provincia_proveedor"]}}" required autofocus
                            style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin provincia --}}

                    {{-- departamento --}}
                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Departamento:</label>

                        <div class="col-md-7">
                            <input type="text" class="form-control" name="txtdepartamento"
                            value="{{$value["departamento_proveedor"]}}" required autofocus
                            style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin departamento --}}

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
        $("#editarProveedor").modal();
    </script>

  @else

  {{$status}}

@endif

@endif

  <script type="text/javascript">
    $(document).ready(function(){

        $('#btnbuscar').click(function(){
            var numdni=$('#ruc').val();
            if (numdni!='') {
                $.ajax({
                    url:"{{ route('consultar.sunat') }}",
                    method:'GET',
                    data:{ruc:numdni},
                    dataType:'json',
                    success:function(data){
                        var resultados=data.entidad['success'];
                        if (resultados==true) {
                          var razon=data.entidad['entity']['nombre_o_razon_social'];
                          var direccion=data.entidad['entity']['direccion'];
                          var distrito=data.entidad['entity']['distrito'];
                          var provincia=data.entidad['entity']['provincia'];
                          var departamento=data.entidad['entity']['departamento'];
                          var estado=data.entidad['entity']['estado_del_contribuyente'];

                            $('#txtdni').val(numdni);
                            $('#txtrazon').val(razon);
                            $('#txtgrupo').val(estado);
                            $('#txtdireccion').val(direccion);
                            $('#txtdistrito').val(distrito);
                            $('#txtprovincia').val(provincia);
                            $('#txtdepartamento').val(departamento);
                        }else{
                            $('#txtdni').val('');
                            $('#txtrazon').val('');
                            $('#txtgrupo').val('');
                            $('#txtdireccion').val('');
                            $('#txtdistrito').val('');
                            $('#txtprovincia').val('');
                            $('#txtdepartamento').val('');
                            $('#mensaje').show();
                            $('#mensaje').delay(2000).hide(2500);
                        }
                    }
                });
            }else{
                alert('Escriba el RUC.!');
                $('#ruc').focus();
            }
        });
    });

</script>

@if (Session::has("ok-crear"))
  <script>
      notie.alert({type:1,text:'!El Proveedor ha sido creado correctamente', time:10})
  </script>
@endif

@if (Session::has("ruc-existe"))
  <script>
      notie.alert({type:2,text:'!El Proveedor ya existe en nuestros registros', time:10})
  </script>
@endif

@if (Session::has("no-validacion"))
  <script>
      notie.alert({type:2,text:'!Hay campos no válidos en el formulario', time:10})
  </script>
@endif

@if (Session::has("error"))
  <script>
      notie.alert({type:3,text:'!Error en el gestor de Proveedores', time:10})
  </script>
@endif

@if (Session::has("ok-editar"))
  <script>
      notie.alert({type:1,text:'!El Proveedor ha sido actualizado correctamente', time:10})
  </script>
@endif

@if (Session::has("ok-eliminar"))

<script>
    notie.alert({ type: 1, text: '¡El Rol ha sido eliminado correctamente!', time: 10 })
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
