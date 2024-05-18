<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Software Biomédico</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <!-- =============================================================
    PLUGINS DE CSS
    ==============================================================  -->

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

	{{-- BOOTSTRAP 4 --}}
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    	{{-- OverlayScrollbars.min.css --}}
	<link rel="stylesheet" href="{{ url('/') }}/css/plugins/OverlayScrollbars.min.css">

	{{-- TAGS INPUT --}}
	<link rel="stylesheet" href="{{ url('/') }}/css/plugins/tagsinput.css">

	{{-- SUMMERNOTE --}}
	<link rel="stylesheet" href="{{ url('/') }}/css/plugins/summernote.css">

	{{-- NOTIE --}}
    <link rel="stylesheet" href="{{ url('/') }}/css/plugins/notie.css">

    <!-- DataTables -->
	<link rel="stylesheet" href="{{ url('/') }}/css/plugins/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="{{ url('/') }}/css/plugins/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/css/plugins/buttons.dataTables.min.css"> 

    {{-- CSS AdminLTE --}}
    <link rel="stylesheet" href="{{ url('/') }}/css/plugins/fullcalendar.min.css">

    {{-- CSS FULLCALENDAR --}}
    <link rel='stylesheet' href="{{ url('/') }}/lib/main.min.css">

	{{-- CSS AdminLTE --}}
    <link rel="stylesheet" href="{{ url('/') }}/css/plugins/adminlte.min.css">

	{{-- google fonts --}}
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ url('/') }}/css/plugins/select2.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/css/plugins/select2-bootstrap4.min.css">

      <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- =============================================================
    PLUGINS DE JS
    ==============================================================  -->

    <!-- FontAwesome  -->
	{{-- Fontawesome --}}
	<script src="https://kit.fontawesome.com/e632f1f723.js" crossorigin="anonymous"></script>

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

	{{-- jquery.overlayScrollbars.min.js --}}
	<script src="{{ url('/') }}/js/plugins/jquery.overlayScrollbars.min.js"></script>

	{{-- TAGS INPUT --}}
	{{-- https://www.jqueryscript.net/form/Bootstrap-4-Tag-Input-Plugin-jQuery.html --}}
	<script src="{{ url('/') }}/js/plugins/tagsinput.js"></script>

	{{-- SUMMERNOTE --}}
	{{-- https://summernote.org/ --}}
	<script src="{{ url('/') }}/js/plugins/summernote.js"></script>

	{{-- NOTIE --}}
	{{-- https://github.com/jaredreich/notie --}}
    <script src="{{ url('/') }}/js/plugins/notie.js"></script>

    	{{-- SWEET ALERT --}}
	{{-- https://sweetalert2.github.io/ --}}
    <script src="{{ url('/') }}/js/plugins/sweetalert.js"></script>


    {{-- Moment JS --}}
    <script src="{{ url('/') }}/js/moment.min.js"></script>

    <!-- DataTables
	https://datatables.net/-->
	<script src="{{ url('/') }}/js/plugins/jquery.dataTables.min.js"></script>
	<script src="{{ url('/') }}/js/plugins/dataTables.bootstrap4.min.js"></script>
	<script src="{{ url('/') }}/js/plugins/dataTables.responsive.min.js"></script>
    <script src="{{ url('/') }}/js/plugins/responsive.bootstrap.min.js"></script>
    <script src="{{ url('/') }}/js/plugins/dataTables.buttons.min.js"></script>
    <script src="{{ url('/') }}/js/plugins/jszip.min.js"></script>
    <script src="{{ url('/') }}/js/plugins/pdfmake.min.js"></script>
    <script src="{{ url('/') }}/js/plugins/vfs_fonts.js"></script>
    <script src="{{ url('/') }}/js/plugins/buttons.html5.min.js"></script>
    <script src="{{ url('/') }}/js/plugins/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.21/dataRender/datetime.js" charset="utf8"></script>
    <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>

    {{-- https://sweetalert2.github.io/ --}}
    <script src="{{ url('/') }}/js/plugins/sweetalert.js"></script>

    {{-- fullcalendar --}}
    <script src="{{ url('/') }}/lib/main.min.js"></script>
    <script src="{{ url('/') }}/lib/locales/es.js"></script>

	{{-- JS AdminLTE --}}
    <script src="{{ url('/') }}/js/plugins/adminlte.js"></script>

    {{-- JS Select2--}}
    <script src="{{ url('/') }}/js/select2.full.min.js"></script>

    {{-- DASHBOARD3--}}
    <script src="{{ url('/') }}/js/pages/dashboard.js"></script>
    <script src="{{ url('/') }}/js/pages/dashboard2.js"></script>


    <script src="{{ url('/') }}/js/plugins/chart.min.js"></script>

<!--     <script src="{{ asset('js/app.js') }}"></script> -->

</head>

@if (Route::has('login'))
@auth

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('modulos.header')
        @include('modulos.sidebar')
        @yield('content')
        @include('modulos.footer')
    </div>

    <input type="hidden" id="ruta" value="{{url('/')}}">

    {{-- JS Summernote --}}
    <script src="{{ url('/') }}/js/codigo.js"></script>
    <script src="{{ url('/') }}/js/administradores.js"></script>
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
    <script src="{{ url('/') }}/js/equiposBaja.js"></script>

</body>

@else
@include('paginas.login')

@endauth
@endif

</html>
