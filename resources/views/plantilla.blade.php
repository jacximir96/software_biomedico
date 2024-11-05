<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Software Biomédico</title>

    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --><!-- Este conflicto -->
 	<!-- <link rel="stylesheet" href="{{ url('/') }}/css/plugins/bootstrap.min.css"> --><!-- Este conflicto -->
	<link rel="stylesheet" href="{{ url('/') }}/css/plugins/OverlayScrollbars.min.css">
	<link rel="stylesheet" href="{{ url('/') }}/css/plugins/tagsinput.css">
	<link rel="stylesheet" href="{{ url('/') }}/css/plugins/summernote.css">
    <link rel="stylesheet" href="{{ url('/') }}/css/plugins/notie.css">
	<!-- <link rel="stylesheet" href="{{ url('/') }}/css/plugins/dataTables.bootstrap4.min.css"> -->
	<!-- <link rel="stylesheet" href="{{ url('/') }}/css/plugins/responsive.bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/css/plugins/buttons.dataTables.min.css"> 
    <link rel="stylesheet" href="{{ url('/') }}/css/plugins/fullcalendar.min.css">
    <link rel='stylesheet' href="{{ url('/') }}/lib/main.min.css">

    <!-- <link rel="stylesheet" href="{{ url('/') }}/css/plugins/adminlte.min.css"> --><!-- Este conflicto -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('/') }}/css/plugins/select2.min.css">
    <!-- <link rel="stylesheet" href="{{ url('/') }}/css/plugins/select2-bootstrap4.min.css"> -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> -->
	<script src="https://kit.fontawesome.com/2776b79eec.js" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<!-- <script src="{{ url('/') }}/js/plugins/bootstrap.min.js"></script> -->
	<script src="{{ url('/') }}/js/plugins/jquery.overlayScrollbars.min.js"></script>
	<script src="{{ url('/') }}/js/plugins/tagsinput.js"></script>
	<script src="{{ url('/') }}/js/plugins/summernote.js"></script>
    <script src="{{ url('/') }}/js/plugins/notie.js"></script>
    <script src="{{ url('/') }}/js/plugins/sweetalert.js"></script>
    <script src="{{ url('/') }}/js/moment.min.js"></script>

	<script src="{{ url('/') }}/js/plugins/jquery.dataTables.min.js"></script>
	<!-- <script src="{{ url('/') }}/js/plugins/dataTables.bootstrap4.min.js"></script> -->
	<script src="{{ url('/') }}/js/plugins/dataTables.responsive.min.js"></script>
    <!-- <script src="{{ url('/') }}/js/plugins/responsive.bootstrap.min.js"></script> -->
    <script src="{{ url('/') }}/js/plugins/dataTables.buttons.min.js"></script>
    <script src="{{ url('/') }}/js/plugins/jszip.min.js"></script>
    <script src="{{ url('/') }}/js/plugins/pdfmake.min.js"></script>
    <script src="{{ url('/') }}/js/plugins/vfs_fonts.js"></script>
    <script src="{{ url('/') }}/js/plugins/buttons.html5.min.js"></script>
    <script src="{{ url('/') }}/js/plugins/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.21/dataRender/datetime.js" charset="utf8"></script>
    <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
    <script src="{{ url('/') }}/js/plugins/sweetalert.js"></script>
    <script src="{{ url('/') }}/lib/main.min.js"></script>
    <script src="{{ url('/') }}/lib/locales/es.js"></script>
    <!-- <script src="{{ url('/') }}/js/plugins/adminlte.js"></script> -->
    <script src="{{ url('/') }}/js/select2.full.min.js"></script>
    <!-- <script src="{{ url('/') }}/js/pages/dashboard.js"></script> -->
    <!-- <script src="{{ url('/') }}/js/pages/dashboard2.js"></script> -->
    <script src="{{ url('/') }}/js/plugins/chart.min.js"></script>
    <script src="{{ url('/') }}/js/bundle.js"></script>
</head>

@if (Route::has('login'))
@auth

<body
    x-data="{ page: 'header', 'loaded': false, 'darkMode': true, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
    x-init="
          darkMode = JSON.parse(localStorage.getItem('darkMode'));
          $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{'dark text-bodydark bg-boxdark-2': darkMode === true}">
    <div
        x-show="loaded"
        x-init="window.addEventListener('DOMContentLoaded', () => {setTimeout(() => loaded = false, 500)})"
        class="fixed left-0 top-0 z-999999 flex h-screen w-screen items-center justify-center bg-white dark:bg-black">
        <div class="h-16 w-16 animate-spin rounded-full border-4 border-solid border-primary border-t-transparent"></div>
    </div>
    <div class="wrapper flex h-screen overflow-hidden">
        @include('modulos.sidebar')
        <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
            @include('modulos.header')
            @yield('content')

            <div class="relative h-screen">
                <div class="absolute bottom-0 w-full bg-gray-200">
                    @include('modulos.footer')
                </div>
            </div>

        </div>
    </div>

    <input type="hidden" id="ruta" value="{{url('/')}}">
    <script src="{{ url('/') }}/js/codigo.js"></script>
    @yield('javascript')

<!--     <script src="{{ url('/') }}/js/administradores.js"></script>
    <script src="{{ url('/') }}/js/departamentos.js"></script>
    <script src="{{ url('/') }}/js/direccionesEjecutivas.js"></script>
    <script src="{{ url('/') }}/js/equipos.js"></script>
    <script src="{{ url('/') }}/js/equiposGarantia.js"></script>
    <script src="{{ url('/') }}/js/ambientes.js"></script>
    <script src="{{ url('/') }}/js/proveedores.js"></script>
    <script src="{{ url('/') }}/js/roles.js"></script>
    <script src="{{ url('/') }}/js/historialCronograma.js"></script>
    <script src="{{ url('/') }}/js/tipoMantenimientos.js"></script>
    <script src="{{ url('/') }}/js/historialEquipos.js"></script>
    <script src="{{ url('/') }}/js/historialCronogramaCompra.js"></script>
    <script src="{{ url('/') }}/js/historialCompras.js"></script>
    <script src="{{ url('/') }}/js/ordenServicios.js"></script>
    <script src="{{ url('/') }}/js/cronogramasGeneral.js"></script>
    <script src="{{ url('/') }}/js/cronogramasGenerales.js"></script>
    <script src="{{ url('/') }}/js/cronogramasGeneralNuevo.js"></script>
    <script src="{{ url('/') }}/js/cronogramasGeneralesNuevo.js"></script>
    <script src="{{ url('/') }}/js/defecto.js"></script>
    <script src="{{ url('/') }}/js/cronogramaLista.js"></script>
    <script src="{{ url('/') }}/js/equiposBaja.js"></script> -->
    <script src="{{ url('/') }}/js/historialCronograma.js"></script>
</body>

@else
    @include('paginas.login')
    @endauth
@endif

</html>
