@foreach ($administradores as $element)
            @if ($_COOKIE["email_login"] == $element->email)

@extends('plantilla')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Historial de Equipos por Compra</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url("/") }}">Inicio</a></li>
              <li class="breadcrumb-item active">Historial de Equipos por Compra</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">

                <table class="table table-bordered table-striped dt-responsive" width="100%"
                 id="tablaHistorialCompras">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Equipo</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Serie</th>
                            <th>Cod. Patr.</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>

              </div>

            </div>
          </div>
        </div>
      </div>
    </section>
    <div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-tittle">Historial</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                   
                    <form id="editForm" method="POST">
                        <table class="table table-bordered" id="miTabla">
                            <thead>
                                 <tr>
                                    <th colspan="2" style="text-align:center;">Información del Equipo</th>
                                </tr>
                            </thead>
        
                            <tbody>
                                <input type="text" style="display:none" id="id_equipoHistorial" id="id_equipoHistorial">
                               
                                
                            </tbody>
                        </table>
                        <table  class="table table-bordered table-striped dt-responsive" id="historialCompra">
                            <thead>
                                <tr>
                                    
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                    <th>Archivo</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        
                        <div class="modal-footer d-flex justify-content-between">
                            <div>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            </div>
        
                            <div>
                                <a href="" id="historialCompraImprimir" class="btn btn-primary">Guardar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@if (Session::has("ok-crear"))
  <script>
      notie.alert({type:1,text:'!El equipo médico ha sido creado correctamente', time:10})
  </script>
@endif

@if (Session::has("no-validacion"))
  <script>
      notie.alert({type:2,text:'!Hay campos no válidos en el formulario', time:10})
  </script>
@endif

@if (Session::has("error"))
  <script>
      notie.alert({type:3,text:'!Error en el gestor de equipos médicos', time:10})
  </script>
@endif

@if (Session::has("ok-editar"))
  <script>
      notie.alert({type:1,text:'!El equipo médico ha sido actualizado correctamente', time:10})
  </script>
@endif

@if (Session::has("ok-eliminar"))

<script>
    notie.alert({ type: 1, text: '¡El equipo médico ha sido eliminado correctamente!', time: 10 })
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
