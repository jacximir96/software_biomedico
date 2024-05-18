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
            <h1>Cronograma de Mantenimientos por Compra</h1>
            </br>
          </div>

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url("/") }}">Inicio</a></li>
              <li class="breadcrumb-item active">Cronograma por Compra</li>
            </ol>
          </div>

          <div class="col-sm-12">

            <div class="callout callout-info col-md-12" style="float:right;">
                <h5>
                    <span class="spinner-grow text-danger"></span>
                    <i> Información del Equipo:</i>
                </h5>

                <ul>
                    <li id="texto_cronograma"></li>
                </ul>
            </div>
          </div>

          <div class="col-sm-12">
            <div class="callout callout-info col-md-12" style="float:left;">
                    <h5>
                        <span class="spinner-grow text-danger"></span>
                        <i> Registrar si se realizó el Mantenimiento:</i>
                        <button id="ocultar_listado" class="btn btn-danger btn-sm">Ver Listado</button>
                    </h5>

                    </br>

                <div id="tabla_ocultar">
                    <table class="table table-bordered table-striped dt-responsive" width="100%"
                    id="historialCronogramaCompra">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Equipo</th>
                            <th>Fecha Inicial</th>
                            <th>Fecha Final</th>
                            <th>Código Patrimonial</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody></tbody>
                    {{-- <tbody>
                        @foreach ($cronogramasCalendario_fecha as $key => $data)
                            <tr>
                                <th>{{($key+1)}}</th>
                                <td>{{$data->nombre_equipoGarantia}}</td>
                                <td>{{$data->fecha}}</td>
                                <td>{{$data->fecha_final}}</td>
                                <td>{{$data->cp_equipoGarantia}}</td>
                                <td style="text-align: center;">
                                    <div class="btn-group">
                                        <a href="{{url('/')}}/cronogramasCalendario/{{$data->id_cronogramaCalendario}}" class="btn btn-warning btn-sm">
                                            Registrar
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody> --}}
                </table>
            </div>
            </div>
          </div>

        </div>

      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div id='calendar' class="ocultar_calendario"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
  </div>

  {{-- Agregar calendario en modal --}}
<div class="modal fade" id="agregarCalendario">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formulario_calendario" method="POST" action="{{url('/')}}/cronogramasCalendario/guardar">
            @csrf

            <div class="modal-header bg-info">
                <h4 class="modal-tittle">Cronograma de Mantenimiento</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <!-- Inicio de Fecha -->
                <div class="input-group mb-3">
                    <label for="email" class="col-md-3 control-label">Fecha Inicial:</label>

                    <div class="col-md-8">
                        <input id="fecha_actual_calendario" name="fecha_actual" type="date" class="form-control">

                    </div>
                </div><!-- Fin de fecha -->

                <!-- Inicio de Fecha final -->
                <div class="input-group mb-3">
                    <label for="email" class="col-md-3 control-label">Fecha Final:</label>

                    <div class="col-md-8">
                        <input id="fecha_final_calendario" name="fecha_final" type="date" class="form-control">

                    </div>
                </div><!-- Fin de fecha -->

                <!-- Inicio de Equipo -->
                <div class="input-group mb-3">
                    <label for="email" class="col-md-3 control-label">Equipo:</label>

                    <div class="col-md-8">
                        <select class="form-control select2" name="id_equipo" id="nombres_equipo" required>
                                <option value="">
                                    -- Seleccionar el Equipo --
                                </option>

                                @foreach($equipos as $key => $value)
                                    <option  value="{{$value->id_equipoGarantia}}">
                                        {{$value->nombre_equipoGarantia}}<span> - </span><p>Cod. Patrimonial: {{$value->cp_equipoGarantia}}</p>
                                    </option>
                                @endforeach
                            </select>
                    </div>
                </div><!-- Fin de Equipo -->

                {{-- Realizado --}}
                    <div class="input-group mb-3" style="display:none;">

                        <label for="email" class="col-md-3 control-label">Realizado:</label>

                        <div class="col-md-6">
                            <input class="form-control" name="realizado_crear"
                            value="0" required autofocus
                            style="text-transform: uppercase;" readonly="">
                        </div>
                    </div>{{-- fin Realizado --}}

            </div><!-- Fin del modal-body -->

            <div class="modal-footer d-flex justify-content-between">
                <div>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>

                <div>
                    <button onclick="guardar();" type="button" id="boton_enviar_calendario" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
      </div>
    </div>
</div>

{{-- Editar departamento en modal --}}

<div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-tittle">Registrar Mantenimiento</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               
                <form id="editForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        {{-- Tipo Cronograma --}}
                        <div class="input-group mb-3">

                            <label for="email" class="col-md-4 control-label">Equipo:</label>
                            {{-- idequipogarantia --}}
                            <div class="col-md-8">
                                <input type="hidden" class="form-control" name="cronograma_equipo" id="cronograma_equipo"
                                 required autofocus
                                style="text-transform: uppercase;" readonly="">
    
                                <input type="text" class="form-control" name="nombre_equipoGarantia" id="nombre_equipoGarantia"
                                 required autofocus
                                style="text-transform: uppercase;" readonly="">
                            </div>
                        </div>{{-- fin equipo --}}
    
                        <div class="input-group mb-3">

                            <label for="email" class="col-md-4 control-label">Fecha Inicial:</label>
    
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="cronograma_fecha"  id="cronograma_fecha"
                                 required autofocus
                                style="text-transform: uppercase;" readonly="">
                            </div>
                        </div>{{-- fin fecha inicial--}}
    
                        {{-- fecha Final --}}
                        <div class="input-group mb-3">
    
                            <label for="email" class="col-md-4 control-label">Fecha Final:</label>
    
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="cronograma_fecha_final" id="cronograma_fecha_final"
                                 required autofocus
                                style="text-transform: uppercase;" readonly="">
                            </div>
                        </div>{{-- fin fecha final --}}
    
                        {{-- Realizado --}}
                        <div class="input-group mb-3" >
    
                            <label for="email" class="col-md-4 control-label">Fecha:</label>
    
                            <div class="col-md-6">
                                <input class="form-control" name="cronograma_realizado" 
                                value="1" required autofocus
                                style="text-transform: uppercase;" readonly="">
                            </div>
                        </div>{{-- fin Realizado --}}
    
                        {{-- Proveedor --}}
                        <div class="input-group mb-3">
                            <label for="email" class="col-md-4 control-label">Empresa:</label>
    
                            <div class="col-md-8">
                                <select class="form-control" name="id_proveedor" id="id_proveedor" required>
                                        <option value="">
                                            -- Seleccionar el Proveedor --
                                        </option>
    
                                        @foreach($proveedores as $key => $valorProveedor)
                                        <option value="{{$valorProveedor->id_proveedor}}">{{$valorProveedor->razonSocial_proveedor}}</option>
                                        @endforeach
    
                                    </select>
                            </div>
                        </div>{{-- fin Proveedor --}}
    
                        {{-- Observación --}}
                        <div class="input-group mb-3">
                            <label for="email" class="col-md-4 control-label">Detalles del Servicio:</label>
    
                            <div class="col-md-8">
                                <textarea class="form-control" name="cronograma_observacion" id="cronograma_observacion" autofocus style="text-transform: uppercase;"></textarea>
                            </div>
                        </div>{{-- Observación --}}
    
                        {{-- pdf --}}
                            <hr class="pb-2">
                                <div class="form-group my-2 text-center">
                                    <div class="btn btn-default btn-file">
                                        <i class="fas fa-paperclip"></i> Adjuntar Archivo
                                        <p><label for="pdf_archivo_final">
                                            <input type="file" name="pdf_archivo_final" id="pdf_archivo_final">
                                        </label></p>
    
                                    </div><br>
    
                                    <p class="help-block small">Tamaño máximo de archivos: 20MB</p>
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




{{-- @if (isset($status))

@if ($status == 200)

    @foreach ($cronograma as $key => $value)

    <div class="modal" id="editarCronograma">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ url('/') }}/cronogramasCalendario/{{ $value->id_cronogramaCalendario }}"
                enctype="multipart/form-data">

                @method('PUT')
                @csrf

                <div class="modal-header bg-info">
                    <h4 class="modal-tittle">Registrar Mantenimiento</h4>
                    <a href="{{ url("/") }}/cronogramasCalendario" type="button" class="close">&times;</a>
                </div>

                <div class="modal-body">
                    <div class="input-group mb-3">

                        <label for="email" class="col-md-4 control-label">Equipo:</label>

                        <div class="col-md-8">
                            <input type="hidden" class="form-control" name="cronograma_equipo"
                            value="{{$value->id_equipoGarantia}}" required autofocus
                            style="text-transform: uppercase;" readonly="">

                            <input type="text" class="form-control" name=""
                            value="{{$value->nombre_equipoGarantia}}" required autofocus
                            style="text-transform: uppercase;" readonly="">
                        </div>
                    </div>

                    <div class="input-group mb-3">

                        <label for="email" class="col-md-4 control-label">Fecha Inicial:</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="cronograma_fecha"
                            value="{{$value->fecha}}" required autofocus
                            style="text-transform: uppercase;" readonly="">
                        </div>
                    </div>

                    <div class="input-group mb-3">

                        <label for="email" class="col-md-4 control-label">Fecha Final:</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="cronograma_fecha_final"
                            value="{{$value->fecha_final}}" required autofocus
                            style="text-transform: uppercase;" readonly="">
                        </div>
                    </div>

                    <div class="input-group mb-3" style="display:none;">

                        <label for="email" class="col-md-4 control-label">Fecha:</label>

                        <div class="col-md-6">
                            <input class="form-control" name="cronograma_realizado"
                            value="1" required autofocus
                            style="text-transform: uppercase;" readonly="">
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-4 control-label">Empresa:</label>

                        <div class="col-md-8">
                            <select class="form-control" name="id_proveedor" id="nombres_proveedor" required>
                                    <option value="">
                                        -- Seleccionar el Proveedor --
                                    </option>

                                    @foreach($proveedores as $key => $valorProveedor)
                                    <option value="{{$valorProveedor->id_proveedor}}">{{$valorProveedor->razonSocial_proveedor}}</option>
                                    @endforeach

                                </select>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-4 control-label">Detalles del Servicio:</label>

                        <div class="col-md-8">
                            <textarea class="form-control" name="cronograma_observacion" autofocus style="text-transform: uppercase;"></textarea>
                        </div>
                    </div>

                        <hr class="pb-2">
                            <div class="form-group my-2 text-center">
                                <div class="btn btn-default btn-file">
                                    <i class="fas fa-paperclip"></i> Adjuntar Archivo
                                    <p><label for="pdf_archivo_final">
                                        <input type="file" name="pdf_archivo_final" id="pdf_cronograma">
                                    </label></p>

                                </div><br>

                                <p class="help-block small">Tamaño máximo de archivos: 20MB</p>
                            </div>

                </div>

                <div class="modal-footer d-flex justify-content-between">
                    <div>
                        <a href="{{ url("/") }}/cronogramasCalendario" type="button" class="btn btn-danger">Cerrar</a>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </div>

            </form>
          </div>
        </div>

    </div>

    @endforeach

    <script>
        $("#editarCronograma").modal();
    </script>

  @else

  {{$status}}

@endif

@endif --}}

<script>

        $("#fecha_actual_calendario").prop('disabled',true); //indicamos que la fecha no se pueda cambiar

        document.addEventListener('DOMContentLoaded', function() {
          var calendarEl = document.getElementById('calendar');
          var events = @json($events);

          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     }
            });

          var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'es',   //timeZone: 'America/Bogota',

            headerToolbar: {
                left: 'prev,next today', //Con esta opción se verifica los botones anterior,siguiente y hoy
                center: 'title', //el titulo centrado donde muestra el mes del calendario
                right: 'dayGridMonth' //los botones del mes, semana y dia
            },

            /* initialDate: '2020-09-12', */
            navLinks: false,
            selectable: true,
            dayMaxEventRows: true,
            events: events,

            views: {
                timeGrid: {
                    dayMaxEventRows: 4 // adjust to 6 only for timeGridWeek/timeGridDay
                }
            },

            selectMirror: true,
            select: function(arg) {
                let m = moment(arg.start).format("YYYY-MM-DD");
                $("#fecha_actual_calendario").val(m);
                $("#agregarCalendario").modal();
                calendar.unselect(); // funcion para que no se quede seleccionado la fecha
            },

            /* Inicio evento eliminar */
            eventClick: function(arg) {
                var id = arg.event.id;
              var deleteMsg = swal({
                                title: "Estas seguro?",
                                text: "No podrás recuperar este archivo!",
                                type: "warning",
                                showCancelButton: true,
  		                        confirmButtonColor: '#3085d6',
  		                        cancelButtonColor: '#d33',
  		                        cancelButtonText: 'Cancelar',
  		                        confirmButtonText: 'Si, eliminar registro!'
                }).then(function(result){
                    if(result.value){
                    if(deleteMsg){
                $.ajax({
                    url: "{{route('cronogramasCalendario.destroy','')}}" +'/'+id,
                    type: 'DELETE',
                    data: {
                              "_token":"{{ csrf_token() }}",
                              "id_cronogramaCalendario":arg.event.id
                          },
                    success: function () {
                    arg.event.remove();
                    swal("Hecho!", "Fue eliminado con éxito!", "success");
                    location.reload(); 
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                    swal("Error al eliminar!", "Inténtalo de nuevo", "error");
                    }
                    });
                  }
                }
                })
            },/* Fin evento eliminar */

            eventDidMount: function(info) {
                /* console.log(info.event.extendedProps); */
            },

            eventMouseEnter: function(info) {
                /* console.log(info.event.extendedProps.description); */
                $('#texto_cronograma').append(info.event.extendedProps.description);
                $('#texto_cronograma').empty();
                $('#texto_cronograma').append(info.event.extendedProps.description);

                $('#texto_cronograma_id').append(info.event.extendedProps.description);
                $('#texto_cronograma_id').empty();
                $('#texto_cronograma_id').append(info.event.extendedProps.description);
            },

            editable: true, //para poder editar los datos del registro
            //events: '/software_biomedico/public/cronogramasCalendario/calendario/listar' //se listan todos los registros del cronograma
            eventDidMount: function(info) {
                // console.log(info.event.title);
                $(info.el).tooltip({ 
                title: info.event.extendedProps.description,
                placement: "top",
                trigger: "hover",
                container: "body"
            });
        },
          });

          calendar.render();

        });

        function guardar(){
            var fd = new FormData(document.getElementById("formulario_calendario"));
            let fecha = $("#fecha_actual_calendario").val();
            let equipo = $("#nombres_equipo").val();
            let realizado = $('#realizado').val();

            $("#fecha_actual_calendario").prop('disabled',false);

            if ($('#nombres_equipo').val() == '') {
                $("#fecha_actual_calendario").prop('disabled', true);
                alert("Seleccionar un Equipo Médico");
            }

             $.ajax({
                url: $('#formulario_calendario').attr('action'),
                type: $('#formulario_calendario').attr('method'),
                data: $('#formulario_calendario').serialize()
            }).done(function(respuesta){
                if(respuesta && respuesta.ok){
                    swal({
		                    type:"success",
                            title: "¡El registro ha sido guardado correctamente!",
                            showConfirmButton: true,
		                    confirmButtonText: "Cerrar"
                         }).then(function(result){
                            if(result.value){
                                window.location = "";
                            }
                         })

                    calendar.refetchEvents();
                 }/* else{
                    swal({
		                    type:"error",
                            title: "¡La fecha seleccionada ya contiene un registro!",
                            showConfirmButton: true,
		                    confirmButtonText: "Cerrar"
                         }).then(function(result){
                            if(result.value){
                                window.location = "";
                            }
                         })
                         calendar.refetchEvents();
                } */
            })
        }

</script>

@if (Session::has("ok-crear"))
  <script>
      notie.alert({type:1,text:'!El mantenimiento ha sido creado correctamente', time:10})
  </script>
@endif

@if (Session::has("no-validacion"))
  <script>
      notie.alert({type:2,text:'!Hay campos no válidos en el formulario', time:10})
  </script>
@endif

@if (Session::has("error"))
  <script>
      notie.alert({type:3,text:'!Error en el gestor de Cronogramas', time:10})
  </script>
@endif

@if (Session::has("ok-editar"))
  <script>
      notie.alert({type:1,text:'!El mantenimiento ha sido registrado correctamente', time:10})
  </script>
@endif

@if (Session::has("ok-eliminar"))

<script>
    notie.alert({ type: 1, text: '¡El cronograma ha sido eliminado correctamente!', time: 10 })
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
