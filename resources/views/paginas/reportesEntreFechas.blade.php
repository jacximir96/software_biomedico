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
            <h1>Reportes entre Fechas</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url("/") }}">Inicio</a></li>
              <li class="breadcrumb-item active">Reportes entre Fechas</li>
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

              <div class="card-body">

              <form action="{{ url('/') }}/reportesEntreFechas/entreFechasPDF" method="get" target="_blank">

                <h4>Mantenimientos por Orden de Servicio</h4>
                </br>

                {{-- Fecha Inicial --}}
                <div class="input-group mb-3">

                    <label for="email" class="col-sm-4 control-label">Fecha Inicial:</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="fecha_inicial_reportes"
                        value="" required autofocus placeholder="Ingrese Fecha Inicial" onfocus="(this.type='date')">
                    </div>

                </div>{{-- Fin Fecha Inicial --}}

                {{-- Fecha Final --}}
                <div class="input-group mb-3">

                    <label for="email" class="col-sm-4 control-label">Fecha Final:</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="fecha_final_reportes"
                        value="" required autofocus placeholder="Ingrese Fecha Final" onfocus="(this.type='date')">
                    </div>
                </div>{{-- Fin Fecha Final --}}

                <button style="float:right;" class="btn btn-primary btn-sm" type="submit">GENERAR REPORTE (PDF)</button>

            </form>

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

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Default box -->
            <div class="card">

              <div class="card-body">

              <form action="{{ url('/') }}/reportesEntreFechas/entreFechasOTM" method="get" target="_blank">

                <h4>Mantenimientos por OTM</h4>
                </br>

                {{-- Fecha Inicial --}}
                <div class="input-group mb-3">

                    <label for="email" class="col-sm-4 control-label">Fecha Inicial:</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="fecha_inicial_reportes"
                        value="" required autofocus placeholder="Ingrese Fecha Inicial" onfocus="(this.type='date')">
                    </div>

                </div>{{-- Fin Fecha Inicial --}}

                {{-- Fecha Final --}}
                <div class="input-group mb-3">

                    <label for="email" class="col-sm-4 control-label">Fecha Final:</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="fecha_final_reportes"
                        value="" required autofocus placeholder="Ingrese Fecha Final" onfocus="(this.type='date')">
                    </div>
                </div>{{-- Fin Fecha Final --}}

                <button style="float:right;" class="btn btn-primary btn-sm" type="submit">GENERAR REPORTE (PDF)</button>

            </form>

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

@if (Session::has("ok-crear"))
  <script>
      notie.alert({type:1,text:'!El Rol ha sido creado correctamente', time:10})
  </script>
@endif

@if (Session::has("no-validacion"))
  <script>
      notie.alert({type:2,text:'!Hay campos no válidos en el formulario', time:10})
  </script>
@endif

@if (Session::has("error"))
  <script>
      notie.alert({type:3,text:'!Error en el gestor de roles', time:10})
  </script>
@endif

@if (Session::has("ok-editar"))
  <script>
      notie.alert({type:1,text:'!El Rol ha sido actualizado correctamente', time:10})
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
