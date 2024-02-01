<?php

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

Route::get('/', function () {
    return view('plantilla');
});

Auth::routes();

Route::group(['middleware' => ['permission:ver_usuarios|editar_usuarios|eliminar_usuarios|crear_usuarios']], function () {
    Route::resource('/administradores','AdministradoresController');
});

Route::group(['middleware' => ['permission:ver_ambientes|editar_ambientes|eliminar_ambientes|crear_ambientes']], function () {
    Route::resource('/ambientes','AmbientesController');
});

Route::group(['middleware' => ['permission:ver_proveedores|editar_proveedores|eliminar_proveedores|crear_proveedores']], function () {
    Route::resource('/proveedores','ProveedoresController');
});

Route::resource('/','DashboardController');
Route::resource('/departamentos','DepartamentosController');
Route::resource('/manual','ManualController');
Route::resource('/direccionesEjecutivas','DireccionesEjecutivasController');
Route::resource('/equipos','EquiposController');
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
Route::post('/cronogramas/{id_cronograma}/eliminar','CronogramasController@destroy');

Route::resource('/cronogramasLista','CronogramasListaController');

Route::get('/cronogramasLista','CronogramasListaController@index');
Route::get('/cronogramasLista/{id_cronograma}','CronogramasListaController@show');
Route::post('/cronogramasLista/editar','CronogramasListaController@show1');
Route::post('/cronogramasLista','CronogramasListaController@store');
Route::get('/cronogramasLista/{id_cronograma}','CronogramasListaController@update');
Route::delete('/cronogramasLista/{id_cronograma}','CronogramasListaController@destroy');

Route::get('/cronogramasCalendario/calendario/listar','CronogramasCalendarioController@listar');
Route::post('/cronogramasCalendario/guardar','CronogramasCalendarioController@guardar');
Route::post('/cronogramasCalendario/{id_cronogramaCalendario}/eliminar','CronogramasCalendarioController@destroy');

Route::get('/reportesHistorial/historialPdf','HistorialEquiposController@createPDF');
Route::get('/reportesHistorialCompra/historialPdf','HistorialEquiposCompraController@createPDF');
Route::get('/reportesCronogramaGeneral/cronogramaGeneralPdf','CronogramasGeneralController@createPDF');
Route::get('/reportesCronogramaGeneralNuevo/cronogramaGeneralPdf','CronogramasGeneralNuevoController@createPDF');
Route::get('/reportesFormato7R/formato7Pdf','ReportesFormato7Controller@createPDF');
Route::get('/reportesFormato8R/formato8Pdf','ReportesFormato8Controller@createPDF');


Route::get('/reportesEquipos/EquiposPdf/{id_equipo}','EquiposController@createPDF');
Route::get('/reportesEquiposGarantia/EquiposGarantiaPdf/{id_equipoGarantia}','EquiposGarantiaController@createPDF');

Route::get('/dashboard/datosActual/listarActual','DashboardController@listarActual');

Route::get('/reportesEntreFechas/entreFechasPDF','ReportesEntreFechasController@createPDF');
Route::get('/reportesEntreFechas/entreFechasOTM','ReportesEntreFechasController@createPDF_OTM');
Route::get('/reportesEntreFechas','ReportesEntreFechasController@index');







