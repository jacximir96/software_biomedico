@extends('plantilla')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Panel de Control</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url("/") }}">Inicio</a></li>
              <li class="breadcrumb-item active">Panel de Control</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">

            <div class="col-lg-3 col-6">

                <div class="small-box bg-info">
                <div class="inner">
                    <h3>
                        @foreach($cantidad_equipos as $key => $value_equipos)
                            {{$value_equipos->cantidad_equipos}}
                        @endforeach
                    </h3>

                    <p>Equipos por Servicio</p>
                </div>
                <div class="icon">
                    <i class="ion ion-gear-b"></i>
                </div>
                <a href="{{url("/")}}/equipos" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
                </div>

            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-success">
                <div class="inner">
                    <h3>
                        @foreach($cantidad_equiposGarantia as $key => $value_equiposGarantia)
                            {{$value_equiposGarantia->cantidad_equiposGarantia}}
                        @endforeach
                    </h3>

                    <p>Equipos por Compra</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{url("/")}}/equiposGarantia" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
                </div>

            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-warning">
                <div class="inner">
                    <h3>
                        @foreach($cantidad_usuarios as $key => $value_usuarios)
                            {{$value_usuarios->cantidad_usuarios}}
                        @endforeach
                    </h3>

                    <p>Usuarios Registrados</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{url("/")}}/administradores" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
                </div>

            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-danger">
                <div class="inner">
                    <h3>
                        @foreach($cantidad_proveedores as $key => $value_proveedores)
                            {{$value_proveedores->cantidad_proveedores}}
                        @endforeach
                    </h3>

                    <p>Proveedores</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-stalker"></i>
                </div>
                <a href="{{url("/")}}/proveedores" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
                </div>

            </div>

            <div class="col-lg-4 col-12">

                <div class="small-box bg-info">
                <div class="inner">
                    <h3>
                        @foreach($cantidad_mantenimientosServicio as $key => $value_mantenimientosServicio)
                            {{$value_mantenimientosServicio->cantidad_mantenimientosServicio}}
                        @endforeach
                    </h3>

                    <p>Mantenimientos Realizados por ODS</p>
                </div>
                <div class="icon">
                    <i class="ion ion-gear-b"></i>
                </div>
                <a href="{{url("/")}}/cronogramas" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
                </div>

            </div>

            <div class="col-lg-4 col-12">

                <div class="small-box bg-warning">
                <div class="inner">
                    <h3>
                        @foreach($cantidad_mantenimientosOTM as $key => $value_mantenimientosOTM)
                            {{$value_mantenimientosOTM->cantidad_mantenimientosServicio}}
                        @endforeach
                    </h3>

                    <p>Mantenimientos Realizados por OTM</p>
                </div>
                <div class="icon">
                    <i class="ion ion-gear-b"></i>
                </div>
                <a href="{{url("/")}}/cronogramas" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
                </div>

                </div>

            <div class="col-lg-4 col-12">

                <div class="small-box bg-success">
                <div class="inner">
                    <h3>
                        @foreach($cantidad_mantenimientosCompra as $key => $value_mantenimientosCompra)
                            {{$value_mantenimientosCompra->cantidad_mantenimientosCompra}}
                        @endforeach
                    </h3>

                    <p>Mantenimientos Realizados por Compra</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{url("/")}}/cronogramasCalendario" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
                </div>

            </div>

            <div class="col-lg-12">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Mantenimientos preventivos y correctivos (Orden de Servicio)</h3>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg">
                        @foreach($monto_ordenServicio as $key => $value_monto)
                            S/. {{number_format($value_monto->suma_total_ordenServicio, 2)}}
                        @endforeach
                    </span>
                    <span>Total de costo a lo largo del tiempo</span>
                  </p>
                  <p class="ml-auto d-flex flex-column text-right">
                        @foreach($cantidad_mesActual as $key => $value_cantidad_mesActual)
                            @foreach($cantidad_mesPasado as $key => $value_cantidad_mesPasado)

                                @if($value_cantidad_mesActual->cantidad_actual > $value_cantidad_mesPasado->cantidad_pasado)
                                    <span class="text-success">
                                        <i class="fas fa-arrow-up"></i>
                                        {{$value_cantidad_mesActual->cantidad_actual*100 - $value_cantidad_mesPasado->cantidad_pasado*100}} %
                                    </span>
                                @else
                                    <span class="text-danger">
                                        <i class="fas fa-arrow-down"></i>
                                        {{$value_cantidad_mesPasado->cantidad_pasado*100 - $value_cantidad_mesActual->cantidad_actual*100}} %
                                    </span>
                                @endif

                            @endforeach
                        @endforeach
                    <span class="text-muted">Desde el mes pasado</span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <canvas id="sales-chart" height="200"></canvas>
                  <script src="{{ url('/') }}/js/pages/dashboard3.js"></script>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> Este año
                  </span>

                  <span>
                    <i class="fas fa-square text-gray"></i> El año pasado
                  </span>
                </div>
              </div>
            </div>
        </div>

        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>

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
