<?php

namespace App\Http\Controllers;

use App\AdministradoresModel;
use Illuminate\Support\Facades\DB;/* Agregar conbinaciones de tablas en la base de datos */
use PDF;

use Illuminate\Http\Request;

class ReportesEntreFechasController extends Controller
{
    public function index(){

        $administradores = AdministradoresModel::all();
        $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
                                                    FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
                                                    WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        $cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
                                                    AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        return view("paginas.reportesEntreFechas",array("administradores"=>$administradores,
                                                        "notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,
                                                        "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo));
    }

    public function createPDF(Request $request) {

        $datos = array("fecha_inicial"=>$request->input("fecha_inicial_reportes"),
                       "fecha_final"=>$request->input("fecha_final_reportes"));

        // recuperar todos los registros de la base de datos

        $cronogramas_general =  DB::select("SELECT C.observacion,C.pdf_cronograma,C.otm_cronograma,OS.codigo_ordenServicio,D.iniciales_departamento,
                                            DE.iniciales_direccionEjecutiva,P.razonSocial_proveedor,C.monto_cronograma,M.nombre_mantenimiento,C.garantia,
                                            C.fecha_final,C.realizado,C.id_cronograma,C.id_equipo,C.fecha,E.nombre_equipo,E.cp_equipo FROM cronograma C
                                            INNER JOIN equipo E ON C.id_equipo = E.id_equipo INNER JOIN mantenimiento M ON C.id_mantenimiento = M.id_mantenimiento
                                            LEFT JOIN proveedor P ON C.id_proveedor = P.id_proveedor LEFT JOIN departamento D ON C.id_departamento = D.id_departamento
                                            LEFT JOIN direccionejecutiva DE ON C.id_direccionEjecutiva = DE.id_direccionEjecutiva LEFT JOIN ordenservicio OS
                                            ON C.id_ordenServicio = OS.id_ordenServicio WHERE C.fecha_final IS NOT NULL AND C.realizado = 1 AND OS.codigo_ordenServicio IS NOT NULL AND fecha BETWEEN :fecha_inicial AND :fecha_final",
                                            ['fecha_inicial'=>$datos["fecha_inicial"],'fecha_final'=>$datos["fecha_final"]]);

/*                 echo "<pre>"; print_r($cronogramas_general); echo "</pre>";
                       return; */

        // compartir datos para ver
        view()->share('datos',$datos);
        view()->share('cronogramas_general',$cronogramas_general);

        $pdf = PDF::loadView('paginas.reportesEntreFechasR',$cronogramas_general);

        // descargar archivo PDF con método de descarga
        return $pdf->setPaper('a4','landscape')->stream('reportesEntreFechas.pdf');
      }

      public function createPDF_OTM(Request $request) {

        $datos = array("fecha_inicial"=>$request->input("fecha_inicial_reportes"),
                       "fecha_final"=>$request->input("fecha_final_reportes"));

        // recuperar todos los registros de la base de datos

        $cronogramas_general =  DB::select("SELECT C.observacion,C.pdf_cronograma,C.otm_cronograma,OS.codigo_ordenServicio,D.iniciales_departamento,
                                            DE.iniciales_direccionEjecutiva,P.razonSocial_proveedor,C.monto_cronograma,M.nombre_mantenimiento,C.garantia,
                                            C.fecha_final,C.realizado,C.id_cronograma,C.id_equipo,C.fecha,E.nombre_equipo,E.cp_equipo FROM cronograma C
                                            INNER JOIN equipo E ON C.id_equipo = E.id_equipo INNER JOIN mantenimiento M ON C.id_mantenimiento = M.id_mantenimiento
                                            LEFT JOIN proveedor P ON C.id_proveedor = P.id_proveedor LEFT JOIN departamento D ON C.id_departamento = D.id_departamento
                                            LEFT JOIN direccionejecutiva DE ON C.id_direccionEjecutiva = DE.id_direccionEjecutiva LEFT JOIN ordenservicio OS
                                            ON C.id_ordenServicio = OS.id_ordenServicio WHERE C.fecha_final IS NOT NULL AND C.realizado = 1 AND OS.codigo_ordenServicio IS NULL AND fecha BETWEEN :fecha_inicial AND :fecha_final",
                                            ['fecha_inicial'=>$datos["fecha_inicial"],'fecha_final'=>$datos["fecha_final"]]);

/*                 echo "<pre>"; print_r($cronogramas_general); echo "</pre>";
                       return; */

        // compartir datos para ver
        view()->share('datos',$datos);
        view()->share('cronogramas_general',$cronogramas_general);

        $pdf = PDF::loadView('paginas.reportesEntreFechasR',$cronogramas_general);

        // descargar archivo PDF con método de descarga
        return $pdf->setPaper('a4','landscape')->stream('reportesEntreFechas.pdf');
      }
}
