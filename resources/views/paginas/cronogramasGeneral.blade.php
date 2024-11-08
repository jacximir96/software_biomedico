@foreach ($administradores as $element)
            @if ($_COOKIE["email_login"] == $element->email)

@extends('plantilla')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .spinner-container {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 9999;
    background-color: rgba(0, 0, 0, 0.7); /* Fondo negro semitransparente */
    border-radius: 10px;
    padding: 20px;
    color: white;
    display: none; /* Empieza oculto */
    }

    .spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #fff;
    border-top: 4px solid transparent; /* El mismo color que el fondo del contenedor */
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto;
    }

    .spinner-text {
    margin-top: 10px;
    text-align: center;
    }

    @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
    }
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Cronograma General (Inter. Programadas) - Equipos sin Garantía</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url("/") }}">Inicio</a></li>
              <li class="breadcrumb-item active">Cronograma General</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="container-fluid">
        <div id="spinner" class="spinner-container">
            <div class="spinner"></div>
            <div class="spinner-text">Generando PDF...</div>
          </div>
        <div class="row">
            <div class="col-12">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">

                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#crearCronogramaGeneral">
                        Programas Mantenimientos de Equipos</button>
                    <button id="downloadButton" class="btn btn-success btn-sm" style="float:right;">
                        Exportar a PDF
                    </button>
                    
                    

                    </div>

                <div class="card-body">

                <table class="table table-bordered table-striped dt-responsive" width="100%"
                id="tablaCronogramasGenerales">
                    <thead>
                        <tr>
                            <th>Ambiente</th>
                            <th>Equipo</th>
                            <th>Marca</th>
                            <th>Módelo</th>
                            <th>Serie</th>
                            <th>Cod. Patrim.</th>
                            <th>Mes</th>
                            <th>Año</th>
                            <th>Acciones</th>
                        </tr>

                    </thead>
                    <tbody>

                    </tbody>
                    {{-- <tbody>
                        @foreach($cronogramasGeneral as $key => $valor_cronogramasGeneral)
                        <tr>
                            <td style="text-align: center;">{{($key+1)}}</td>
                            <td style="text-transform: uppercase;">{{$valor_cronogramasGeneral->nombre_ambiente}}</td>
                            <td style="text-transform: uppercase;">{{$valor_cronogramasGeneral->nombre_equipo}}</td>
                            <td style="text-transform: uppercase;width:100px;">{{$valor_cronogramasGeneral->marca_equipo}}</td>
                            <td style="text-transform: uppercase;">{{$valor_cronogramasGeneral->modelo_equipo}}</td>
                            <td style="text-transform: uppercase;">{{$valor_cronogramasGeneral->serie_equipo}}</td>
                            <td style="text-transform: uppercase;">{{$valor_cronogramasGeneral->cp_equipo}}</td>

                                @switch($valor_cronogramasGeneral->mes_cronogramaGeneral)
                                            @case(1)
                                                <td style="text-transform: uppercase;">ENERO</td>
                                            @break

                                            @case(2)
                                                <td style="text-transform: uppercase;">FEBRERO</td>
                                            @break

                                            @case(3)
                                                <td style="text-transform: uppercase;">MARZO</td>
                                            @break

                                            @case(4)
                                                <td style="text-transform: uppercase;">ABRIL</td>
                                            @break

                                            @case(5)
                                                <td style="text-transform: uppercase;">MAYO</td>
                                            @break

                                            @case(6)
                                                <td style="text-transform: uppercase;">JUNIO</td>
                                            @break

                                            @case(7)
                                                <td style="text-transform: uppercase;">JULIO</td>
                                            @break

                                            @case(8)
                                                <td style="text-transform: uppercase;">AGOSTO</td>
                                            @break

                                            @case(9)
                                                <td style="text-transform: uppercase;">SETIEMBRE</td>
                                            @break

                                            @case(10)
                                                <td style="text-transform: uppercase;">OCTUBRE</td>
                                            @break

                                            @case(11)
                                                <td style="text-transform: uppercase;">NOVIEMBRE</td>
                                            @break

                                            @case(12)
                                                <td style="text-transform: uppercase;">DICIEMBRE</td>
                                            @break
                                        @endswitch

                            <td style="text-transform: uppercase;">{{$valor_cronogramasGeneral->año_cronogramaGeneral}}</td>
                            </td>
                            <td style="text-align: center;">
                                <div class="btn-group">
                                    <a href="{{url('/')}}/cronogramasGeneral/{{$valor_cronogramasGeneral->id_cronogramaGeneral}}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-pencil-alt text-white"></i>
                                    </a>

                                    <button class="btn btn-danger btn-sm eliminarRegistro" action="{{url('/')}}/cronogramasGeneral/{{$valor_cronogramasGeneral->id_cronogramaGeneral}}"
                                        method="DELETE" pagina="cronogramasGeneral" token="{{ csrf_token() }}">
                                        <!-- @csrf -->
                                        <i class="fas fa-trash-alt text-white"></i>
                                    </button>

                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody> --}}
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

<div class="modal" id="crearCronogramaGeneral">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ url('/') }}/cronogramasGeneral" id="form1">
                <!-- @csrf -->
                <input style="display:none;" type="text" name="_token" id="token" value="{{ csrf_token() }}">

                <div class="modal-header bg-info">
                    <h4 class="modal-tittle">Programar Mantenimiento de Equipos</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Fecha (Mes):</label>

                        <div class="col-md-8">
                                <select class="form-control" name="mes_cronograma" required>
                                    <option value="">
                                        -- Seleccionar el Mes --
                                    </option>
                                    @for($i=1; $i<=12; $i++)
                                        @switch($i)
                                            @case(1)
                                                <option value="1">
                                                    ENERO
                                                </option>
                                            @break

                                            @case(2)
                                                <option value="2">
                                                    FEBRERO
                                                </option>
                                            @break

                                            @case(3)
                                                <option value="3">
                                                    MARZO
                                                </option>
                                            @break

                                            @case(4)
                                                <option value="4">
                                                    ABRIL
                                                </option>
                                            @break

                                            @case(5)
                                                <option value="5">
                                                    MAYO
                                                </option>
                                            @break

                                            @case(6)
                                                <option value="6">
                                                    JUNIO
                                                </option>
                                            @break

                                            @case(7)
                                                <option value="7">
                                                    JULIO
                                                </option>
                                            @break

                                            @case(8)
                                                <option value="8">
                                                    AGOSTO
                                                </option>
                                            @break

                                            @case(9)
                                                <option value="9">
                                                    SETIEMBRE
                                                </option>
                                            @break

                                            @case(10)
                                                <option value="10">
                                                    OCTUBRE
                                                </option>
                                            @break

                                            @case(11)
                                                <option value="11">
                                                    NOVIEMBRE
                                                </option>
                                            @break

                                            @case(12)
                                                <option value="12">
                                                    DICIEMBRE
                                                </option>
                                            @break
                                        @endswitch
                                    @endfor
                                </select>
                        </div>
                    </div>{{-- fin fecha mes --}}

                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Fecha (Año):</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" name="año_cronograma"
                            value="{{date('Y')}}" required autofocus
                            style="text-transform: uppercase;" readonly="">
                        </div>
                    </div>{{-- fin fecha año --}}

                    <div class="input-group mb-3">
                        <div class="col-md-12">
                        <table class="table table-bordered table-striped dt-responsive" width="100%"
                        id="tablaCronogramasGeneral">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Equipo</th>
                                    <th>Cod. Patrim.</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($equipos as $key => $value_equipos)
                                <tr>
                                    <td>{{$value_equipos->id_equipo}}</td>
                                    <td>{{$value_equipos->nombre_equipo}}</td>
                                    <td>{{$value_equipos->cp_equipo}}</td>
                                    <td></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                    </div>

                </div>

                <div class="modal-footer d-flex justify-content-between">
                    <div>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary" id="guardarCronogramaGeneral">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- inicio de modal cronograma general en modal --}}
<div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-tittle">Editar Programación de Equipo</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="input-group mb-3" style="display:none;">
                        <label for="email" class="col-md-3 control-label">ID:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" id="id_equipo" name="id_equipo" 
                            required autofocus
                            style="text-transform: uppercase;" readonly="">
                        </div>
                    </div>{{-- fin Id de Equipo --}}
                     {{-- Nombre de Equipo --}}
                     <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Equipo:</label>

                        <div class="col-md-8">
                            <input type="text" class="form-control" id="nombre_equipo"name="nombre_equipo"
                            required autofocus
                            style="text-transform: uppercase;" readonly="">
                        </div>
                    </div>{{-- fin Nombre de Equipo --}}
                     {{-- Marca de Equipo --}}
                     <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Marca:</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" id="marca_equipo"name="marca_equipo"
                           required autofocus
                            style="text-transform: uppercase;" readonly="">
                        </div>
                    </div>{{-- fin Marca de Equipo --}}
                      {{-- Modelo de Equipo --}}
                      <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Modelo:</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" id="modelo_equipo" name="modelo_equipo"
                             required autofocus
                            style="text-transform: uppercase;" readonly="">
                        </div>
                    </div>{{-- fin Modelo de Equipo --}}
                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label"># Serie:</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" id="serie_equipo" name="serie_equipo"
                            required autofocus
                            style="text-transform: uppercase;" readonly="">
                        </div>
                    </div>{{-- fin Serie de Equipo --}}
                     {{-- CP de Equipo --}}
                     <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label"># C. Patrim:</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" id="cp_equipo" name="cp_equipo"
                            required autofocus
                            style="text-transform: uppercase;" readonly="">
                        </div>
                    </div>{{-- fin CP de Equipo --}}
                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Mes:</label>

                        <div class="col-md-6">
                            <select class="form-control" id="mes_cronogramaGeneral" name="mes_cronogramaGeneral" required>
                                @for($i=1; $i<=12; $i++)

                                @switch($i)
                                    @case(1)
                                        <option value="1">
                                            ENERO
                                        </option>
                                    @break

                                    @case(2)
                                        <option value="2">
                                            FEBRERO
                                        </option>
                                    @break

                                    @case(3)
                                        <option value="3">
                                            MARZO
                                        </option>
                                    @break

                                    @case(4)
                                        <option value="4">
                                            ABRIL
                                        </option>
                                    @break

                                    @case(5)
                                        <option value="5">
                                            MAYO
                                        </option>
                                    @break

                                    @case(6)
                                        <option value="6">
                                            JUNIO
                                        </option>
                                    @break

                                    @case(7)
                                        <option value="7">
                                            JULIO
                                        </option>
                                    @break

                                    @case(8)
                                        <option value="8">
                                            AGOSTO
                                        </option>
                                    @break

                                    @case(9)
                                        <option value="9">
                                            SETIEMBRE
                                        </option>
                                    @break

                                    @case(10)
                                        <option value="10">
                                            OCTUBRE
                                        </option>
                                    @break

                                    @case(11)
                                        <option value="11">
                                            NOVIEMBRE
                                        </option>
                                    @break

                                    @case(12)
                                        <option value="12">
                                            DICIEMBRE
                                        </option>
                                    @break
                                @endswitch

                            @endfor

                            </select>
                        </div>
                    </div>{{-- fin Mes de Equipo --}}
                    <div class="input-group mb-3">
                        <label for="email" class="col-md-3 control-label">Año:</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" 
                             id="año_cronogramaGeneral" name="año_cronogramaGeneral"
                            required autofocus
                            style="text-transform: uppercase;">
                        </div>
                    </div>{{-- fin Año de Equipo --}}
                    
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

{{-- Editar cronograma general en modal --}}




@if (Session::has("ok-crear"))
  <script>
      notie.alert({type:1,text:'!El Cronograma ha sido creado correctamente', time:10})
  </script>
@endif

@if (Session::has("equipo-existe"))
  <script>
      notie.alert({type:2,text:'!El Equipo ya existe en nuestros registros', time:10})
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
      notie.alert({type:1,text:'!El Cronograma ha sido actualizado correctamente', time:10})
  </script>
@endif

@if (Session::has("ok-eliminar"))

<script>
    notie.alert({ type: 1, text: '¡El Cronograma ha sido eliminado correctamente!', time: 10 })
</script>

@endif

@if (Session::has("no-borrar"))

<script>
    notie.alert({ type: 2, text: '¡Este administrador no se puede borrar!', time: 10 })
</script>

@endif
<script>
    document.getElementById('downloadButton').addEventListener('click', async function() {
      
       document.getElementById('spinner').style.display = 'block';
       $("body").css({opacity:.65,'pointer-events':'none'});
       try {
            const respuesta = await fetch('reportesCronogramaGeneral/cronogramaGeneralPdf');
            if (!respuesta.ok) {
                throw new Error('Error al obtener el archivo PDF desde el servidor');
            }
            const headerLine = respuesta.headers.get('Content-Disposition');
            const nombre = headerLine.match(/(?<=filename\s*=["']).*(?=["'])/)[0];
            const blob = await respuesta.blob();
            let url = URL.createObjectURL(blob);

            // Crear un enlace temporal para descargar el archivo PDF
            let enlaceDescarga = document.createElement('a');
            enlaceDescarga.href = url;
            enlaceDescarga.download = nombre||'archivo.pdf';

            // Agregar el enlace al DOM y hacer clic en él para iniciar la descarga
            document.body.appendChild(enlaceDescarga);
            enlaceDescarga.click();

            // Limpiar el objeto URL y eliminar el enlace del DOM después de la descarga
            document.body.removeChild(enlaceDescarga);
            URL.revokeObjectURL(url);
       } catch (error) {
            console.error('Error:', error);
       }

       document.getElementById('spinner').style.display = 'none';
        $("body").css({opacity:'','pointer-events':''});
   });
</script>

@endsection

@endif

@endforeach


