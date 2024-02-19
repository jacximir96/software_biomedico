<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/* Modelos de nuestro proyecto */
use App\AdministradoresModel;
use App\DepartamentosModel;
use App\DireccionesEjecutivasModel;
use App\RolesModel;
use App\EquiposModel;
use App\CronogramasModel;
/* Fin de Modelos de nuestro proyecto */

use Illuminate\Support\Facades\DB;/* Agregar conbinaciones de tablas en la base de datos */
use Illuminate\Support\Facades\Storage;
use PDF;/* Apuntamos al modelo que existe por defecto para obtener información en PDF */
use Yajra\DataTables\DataTables as DataTablesDataTables;

class HistorialEquiposController extends Controller
{
    public function gethistorialEquipos() {
        if (request()->ajax()) {
            $equipos = EquiposModel::all();
            return DataTablesDataTables::of($equipos)->make(true);
        }
    }
    
    public function index(){
        $administradores = AdministradoresModel::all();
        
        $cronogramas= CronogramasModel::all();
        $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
                                                    FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
                                                    WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");
       
        $cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
                                                    AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        return view("paginas.historialEquipos",array("administradores"=>$administradores,"cronogramas"=>$cronogramas,
                                                    "notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,
                                                    "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo));
    }

    public function show($id){

        $equipo = EquiposModel::where("id_equipo",$id)->get();
        
        $administradores = AdministradoresModel::all();
        $equipos = EquiposModel::all();
        
        $cronograma_equipo = DB::select('select C.pdf_cronograma,C.fecha_final,C.realizado,M.nombre_mantenimiento,C.fecha,C.id_mantenimiento,C.otm_cronograma,OS.codigo_ordenServicio from cronograma C INNER JOIN
                                        equipo E ON C.id_equipo = E.id_equipo INNER JOIN
                                        mantenimiento M ON C.id_mantenimiento = M.id_mantenimiento LEFT JOIN ordenservicio OS ON C.id_ordenServicio = OS.id_ordenServicio WHERE C.id_equipo = ? ORDER BY C.fecha ASC',[$id]);
                                    
        $cronogramas= CronogramasModel::all();
        $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
                                                    FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
                                                    WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        $cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
                                                    AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        if(count($equipo) != 0){
            return view("paginas.historialEquipos",array("status"=>200,"equipo"=>$equipo,
        "administradores"=>$administradores,"equipos"=>$equipos,"cronogramas"=>$cronogramas,
        "notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,"cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo),["cronograma_equipo"=>$cronograma_equipo]);
        }else{
            return view("paginas.historialEquipos",array("status"=>404,"equipo"=>$equipo,
            "administradores"=>$administradores,"equipos"=>$equipos,"cronogramas"=>$cronogramas,
            "notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,"cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo),["cronograma_equipo"=>$cronograma_equipo]);
        }
    }

    public function createPDF(Request $request) {

        $datos = array("id_equipoHistorial"=>$request->input("id_equipoHistorial"));
        /* $cronogramas = CronogramasModel::all(); */
        $cronogramas = DB::select('select * from cronograma C INNER JOIN proveedor P ON C.id_proveedor = P.id_proveedor
        INNER JOIN ordenservicio O ON C.id_ordenServicio = O.id_ordenServicio WHERE C.id_equipo = ? ORDER BY C.id_cronograma ASC',[$datos["id_equipoHistorial"]]);

        // recuperar todos los registros de la base de datos
        $equipo_unidad = DB::select('select * from equipo E INNER JOIN
                                    ambiente A ON E.id_ambiente = A.id_ambiente where id_equipo = ?',[$request->input("id_equipoHistorial")]);

        /* $epp_prueba = DB::select("select * from epp E INNER JOIN
                                  profesionales P ON E.id_profesional = P.id_profesional INNER JOIN
                                  jornada_laboral J ON E.id_jornada = J.id_jornada
                                  WHERE fecha BETWEEN :fecha_inicial AND :fecha_final",
                                  ['fecha_inicial'=>$datos["fecha_inicial"],'fecha_final'=>$datos["fecha_final"]]); */

        /* $epp_prueba_1 = DB::select("select * from epp E INNER JOIN
                                  personal_externo P ON E.id_personal_externo = P.id_personal_externo INNER JOIN
                                  jornada_laboral J ON E.id_jornada = J.id_jornada
                                  WHERE fecha BETWEEN :fecha_inicial AND :fecha_final",
                                  ['fecha_inicial'=>$datos["fecha_inicial"],'fecha_final'=>$datos["fecha_final"]]); */

        // compartir datos para ver
        view()->share('cronogramas',$cronogramas);
        view()->share('equipo_unidad',$equipo_unidad);
        view()->share('datos',$datos);

        /* $pdf = PDF::loadView('paginas.prueba',$epp_prueba,$datos); */
        $pdf = PDF::loadView('paginas.reportesHistorial',$equipo_unidad);
        /* echo "<pre>"; print_r($epp_prueba); echo "</pre>";
                       return; */


        // descargar archivo PDF con método de descarga
        return $pdf->setPaper('a4','landscape')->stream('cronogramasGeneral.pdf');
      }
      public function showJson($id) {
        $historial = EquiposModel::with('cronogramas')->find($id);
        $historial->pdf_cronograma = Storage::url($historial->pdf_cronograma);
        return $historial;
    }
}
