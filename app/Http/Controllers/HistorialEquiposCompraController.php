<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/* Modelos de nuestro proyecto */
use App\AdministradoresModel;
use App\DepartamentosModel;
use App\DireccionesEjecutivasModel;
use App\RolesModel;
use App\EquiposGarantiaModel;
use App\CronogramasModel;
/* Fin de Modelos de nuestro proyecto */

use Illuminate\Support\Facades\DB;/* Agregar conbinaciones de tablas en la base de datos */
use Illuminate\Support\Facades\Storage;
use PDF;/* Apuntamos al modelo que existe por defecto para obtener información en PDF */
use Yajra\DataTables\Facades\DataTables;

class HistorialEquiposCompraController extends Controller
{
    public function gethistorialCompra() {
        if (request()->ajax()) {
            $equiposGarantia = EquiposGarantiaModel::all();
            return DataTables::of($equiposGarantia)->make(true);
        }
    }
    // public function gethistorialComprasModal () {
    //     if (request()->ajax()) {
    //         $equiposGarantia = EquiposGarantiaModel::all();
    //         return DataTables::of($equiposGarantia)->make(true);
    //     }
    // }
    public function index(){
        $cronograma_equipo = DB::select('select C.pdf_cronograma,C.fecha_final,C.realizado,C.fecha from cronogramacalendario C INNER JOIN
        equipoGarantia E ON C.id_equipoGarantia = E.id_equipoGarantia');
        $administradores = AdministradoresModel::all();
        // $equiposGarantia = EquiposGarantiaModel::all();
        $cronogramas= CronogramasModel::all();
        $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
                                                    FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
                                                    WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        $cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
                                                    AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        return view("paginas.historialEquiposCompra",array("administradores"=>$administradores, 'cronograma_equipo' => $cronograma_equipo,
                                                            "cronogramas"=>$cronogramas,"notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,
                                                            "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo));
    }

    public function show($id){

        $equipo = EquiposGarantiaModel::where("id_equipoGarantia",$id)->get();
        $administradores = AdministradoresModel::all();
        $equiposGarantia = EquiposGarantiaModel::all();
        $cronograma_equipo = DB::select('select C.pdf_cronograma,C.fecha_final,C.realizado,C.fecha from cronogramacalendario C INNER JOIN
                                        equipoGarantia E ON C.id_equipoGarantia = E.id_equipoGarantia WHERE C.id_equipoGarantia = ? ORDER BY C.fecha ASC',[$id]);
        $cronogramas= CronogramasModel::all();
        $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
                                                    FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
                                                    WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        $cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
                                                    AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        if(count($equipo) != 0){
            return view("paginas.historialEquiposCompra",array("status"=>200,"equipo"=>$equipo,
        "administradores"=>$administradores,"equiposGarantia"=>$equiposGarantia,"cronogramas"=>$cronogramas,
        "notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,"cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo),["cronograma_equipo"=>$cronograma_equipo]);
        }else{
            return view("paginas.historialEquiposCompra",array("status"=>404,"equipo"=>$equipo,
            "administradores"=>$administradores,"equiposGarantia"=>$equiposGarantia,"cronogramas"=>$cronogramas,
            "notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,"cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo),["cronograma_equipo"=>$cronograma_equipo]);
        }
    }

    public function createPDF(Request $request) {

        $datos = array("id_equipoHistorial"=>$request->input("id_equipoHistorial"));

        $cronogramas = DB::select('select * from cronogramaCalendario C INNER JOIN proveedor P ON C.id_proveedor = P.id_proveedor
                                    WHERE C.id_equipoGarantia = ? ORDER BY C.id_cronogramaCalendario ASC',[$datos["id_equipoHistorial"]]);

        // recuperar todos los registros de la base de datos
        $equipo_unidad = DB::select('select * from equipogarantia where id_equipoGarantia = ?',[$request->input("id_equipoHistorial")]);

        // compartir datos para ver
        view()->share('cronogramas',$cronogramas);
        view()->share('equipo_unidad',$equipo_unidad);
        view()->share('datos',$datos);

        /* $pdf = PDF::loadView('paginas.prueba',$epp_prueba,$datos); */
        $pdf = PDF::loadView('paginas.reportesHistorialCompra',$equipo_unidad);
        /* echo "<pre>"; print_r($epp_prueba); echo "</pre>";
                       return; */


        // descargar archivo PDF con método de descarga
        return $pdf->setPaper('a4','landscape')->stream('cronogramasGeneral.pdf');
      }
    public function showJson($id) {
        $historial = EquiposGarantiaModel::with('cronogramas')->find($id);
        $historial->pdf_cronograma = Storage::url($historial->pdf_cronograma);
        return $historial;
    }
}
