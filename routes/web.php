<?php
use App\Exports\EquipoExport;
use Maatwebsite\Excel\Facades\Excel;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// \DB::listen(function($query) {
    
//     var_dump($query->sql);
// });
Route::get('/excel', 'EquiposController@ExcelExport')->name('equipo.excel');

Route::get('/', function () {
    return view('plantilla');
});

Auth::routes();

Route::group(['middleware' => ['permission:ver_usuarios|editar_usuarios|eliminar_usuarios|crear_usuarios']], function () {
    Route::resource('/administradores','AdministradoresController');
});


Route::resource('/ambientes','AmbientesController');


Route::group(['middleware' => ['permission:ver_proveedores|editar_proveedores|eliminar_proveedores|crear_proveedores']], function () {
    Route::resource('/proveedores','ProveedoresController');
   
    
});

Route::get('/obtenerproveedor','ProveedoresController@getProveedor')->name('proveedor.getproveedor');
Route::get('/obtener','EquiposController@obtenerDatos')->name('equipos.obtenerDatos');
Route::get('/obtenercronograma','CronogramasGeneralController@obtenercronogramageneral')->name('cronogramageneral');
Route::get('/obtenerCronogramaLista','CronogramaListaController@obtenerDatos')->name('cronogramaLista.obtenerDatos');
// Route::get('/prueba','EquiposController@prueba')->name('equipos.pruebas');
Route::get('/obtenerequipogarantia','EquiposGarantiaController@getequipoGarantia')->name('equipos.obtenergarantias');
Route::get('/obtenerequiporeposicion','EquiposReposicionController@getequipoReposicion')->name('equipos.reposicion');
Route::get('/obtenerhistorialequipos','HistorialEquiposController@gethistorialEquipos')->name('equipos.historialequipos');
Route::get('/obtenerequiposervicios','OrdenServiciosController@getordenServicios')->name('equipos.ordenservicios');
Route::get('/obtenercronogramageneralnuevo','CronogramasGeneralNuevoController@getCronogramaNuevo')->name('cronograma.generalnuevo');
Route::get('/obtenerhistorialcompras','HistorialEquiposCompraController@gethistorialCompra')->name('compras.historialcompras');
Route::get('/obtenerambiente','AmbientesController@getAmbiente')->name('ambientes.getambiente');
Route::get('/obtenercronogramafecha','CronogramasController@getcronogramaFecha')->name('cronogramas.getfechas');
Route::get('/obtenercronogramacompra','CronogramasCalendarioController@getConogramaCompra')->name('cronogramas.compras');
Route::get('/obtenerEquipoBaja','EquiposBajaController@obtenerEquipoBaja')->name('equipos.obtenerEquipoBaja');



// Route::get('/getcronograma','CronogramasController@getindex')->name('cronogramas.getindex');

Route::resource('/','DashboardController');
Route::resource('/departamentos','DepartamentosController');
Route::resource('/manual','ManualController');
Route::resource('/direccionesEjecutivas','DireccionesEjecutivasController');
Route::resource('/equipos','EquiposController');

Route::resource('/cronogramaLista','CronogramaListaController');

Route::resource('/equiposGarantia','EquiposGarantiaController');
Route::resource('/equiposReposicion','EquiposReposicionController');
Route::resource('/equiposBaja','EquiposBajaController');
Route::resource('/roles','RolesController');
Route::delete('/permisos/{role_id}/{permission_id}','PermisosRolesController@destroy');
Route::get('/permisos/{role_id}','PermisosRolesController@show');
Route::post('/permisos/{role_id}','PermisosRolesController@store');
Route::resource('/cronogramas','CronogramasController');
Route::resource('/cronogramasCalendario','CronogramasCalendarioController');
Route::resource('/historialEquipos','HistorialEquiposController');
Route::resource('/historialEquiposCompra','HistorialEquiposCompraController');
Route::resource('/tipoMantenimientos','TipoMantenimientosController');
Route::resource('/dashboard','DashBoardController');
Route::resource('/ordenServicios','OrdenServiciosController');
Route::resource('/cronogramasGeneral','CronogramasGeneralController');
Route::resource('/cronogramasGeneralNuevo','CronogramasGeneralNuevoController');


/* Route::resource('/reportesFormato7','ReportesFormato7Controller'); */
Route::delete('/reportesFormato7/{formato7_id}','ReportesFormato7Controller@destroy');
Route::get('/reportesFormato7/{formato7_id}/{equipo_id}','ReportesFormato7Controller@show');
Route::get('/reportesFormato7','ReportesFormato7Controller@index');
Route::post('/reportesFormato7','ReportesFormato7Controller@store');
Route::put('/reportesFormato7/{formato7_id}','ReportesFormato7Controller@update');


Route::resource('/reportesFormato8','ReportesFormato8Controller');
Route::get('/consultarruc', 'ProveedoresController@buscarRuc')->name('consultar.sunat');
Route::get('/cronogramas/calendario/listar','CronogramasController@listar');
Route::post('/cronogramas/guardar','CronogramasController@guardar');
// Route::delete('/cronogramas/{id_cronograma}','CronogramasController@destroy');

Route::resource('/cronogramasLista','CronogramasListaController');
Route::get('getindex','CronogramasListaController@getindex')->name('lista.getindex');

Route::get('/cronogramasLista','CronogramasListaController@index');
Route::get('/cronogramasLista/{id_cronograma}','CronogramasListaController@show');
Route::post('/cronogramasLista/editar','CronogramasListaController@show1');
Route::post('/cronogramasLista','CronogramasListaController@store');
Route::get('/cronogramasLista/{id_cronograma}','CronogramasListaController@update');
Route::delete('/cronogramasLista/{id_cronograma}','CronogramasListaController@destroy');

Route::get('/cronogramasCalendario/calendario/listar','CronogramasCalendarioController@listar');
Route::post('/cronogramasCalendario/guardar','CronogramasCalendarioController@guardar');
Route::post('/cronogramasCalendario/{id_cronogramaCalendario}/eliminar','CronogramasCalendarioController@destroy');

Route::get('/reportesHistorial/historialPdf','HistorialEquiposController@createPDF')->name('crearPdf.MantenimientoServicioHistorial');
Route::get('/reportesHistorialCompra/historialPdf','HistorialEquiposCompraController@createPDF');
// cronograma para pdf
Route::get('/reportesCronogramaGeneral/cronogramaGeneralPdf','CronogramasGeneralController@createPDF');





Route::get('/reportesCronogramaGeneralNuevo/cronogramaGeneralPdf','CronogramasGeneralNuevoController@createPDF');
Route::get('/reportesFormato7R/formato7Pdf','ReportesFormato7Controller@createPDF');
Route::get('/reportesFormato8R/formato8Pdf','ReportesFormato8Controller@createPDF');


Route::get('/formato8/json/{id}','ReportesFormato8Controller@obtenerDatos');

Route::get('/reportesEquipos/EquiposPdf/{id_equipo}','EquiposController@createPDF');
Route::get('/reportesEquiposGarantia/EquiposGarantiaPdf/{id_equipoGarantia}','EquiposGarantiaController@createPDF');

Route::get('/dashboard/datosActual/listarActual','DashboardController@listarActual');

Route::get('/reportesEntreFechas/entreFechasPDF','ReportesEntreFechasController@createPDF');
Route::get('/reportesEntreFechas/entreFechasOTM','ReportesEntreFechasController@createPDF_OTM');
Route::get('/reportesEntreFechas','ReportesEntreFechasController@index');


Route::get('pdf','OrdenServiciosController@createPDF')->name('ordenServicios.pdf');



Route::get('/departamentos/json/{id}','DepartamentosController@showJson')->name('departamentos.showjson');  
Route::get('/ambientes/json/{id}','AmbientesController@showJson')->name('ambientes.showjson'); 
Route::get('/cronogramageneralnuevo/json/{id}','CronogramasGeneralNuevoController@showJson')->name('cronogramasGeneralNuevo.showjson'); 
Route::get('/ordenservicio/json/{id}','OrdenServiciosController@showJson')->name('ordenservicios.showjson'); 
Route::get('/cronogramasgeneral/json/{id}','CronogramasGeneralController@showJson')->name('cronogramasgeneral.showjson'); 
Route::get('/equipogarantia/json/{id}','EquiposGarantiaController@showJson')->name('equipogarantia.showjson'); 
Route::get('/equipos/json/{id}','EquiposController@showJson')->name('equipos.showjson'); 
Route::get('/cronogramaLista/json/{id}','CronogramaListaController@showJson')->name('cronogramaLista.showjson'); 
Route::get('/proveedores/json/{id}','ProveedoresController@showJson')->name('proveedor.json');
Route::get('/equiporeposicion/json/{id}','EquiposReposicionController@showJson')->name('reposicion.json');
Route::get('/historialgarantia/json/{id}','HistorialEquiposCompraController@showJson')->name('historial.json');
Route::get('/historialequipo/json/{id}','HistorialEquiposController@showJson')->name('historialequipos.json');
Route::get('/direccionesejecutivas/json/{id}','DireccionesEjecutivasController@showJson')->name('direccionesEjecutivas.json');
Route::get('/cronogramasfecha/json/{id}','CronogramasController@showJson')->name('cronogramas.json');
Route::get('/cronogramasfechacompras/json/{id}','CronogramasCalendarioController@showJson')->name('cronogramascompras.json');

Route::get('/mantenimientoServicioHistorial/json/{id}','cr@obtenerDatos')->name('mantenimientoServicioHistorial.json');
Route::get('/equipoDatos/json/{id}','MantenimientoServicioHistorial@obtenerEquipo')->name('equipoDatos.json');

