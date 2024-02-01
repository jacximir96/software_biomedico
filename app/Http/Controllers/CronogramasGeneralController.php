<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/* Modelos de nuestro proyecto */
use App\AdministradoresModel;
use App\DireccionesEjecutivasModel;
use App\DepartamentosModel;
use App\AmbientesModel;
use App\RolesModel;
use App\EquiposModel;
use App\CronogramasGeneralModel;
/* Fin de Modelos de nuestro proyecto */

use Illuminate\Support\Facades\DB;/* Agregar conbinaciones de tablas en la base de datos */
use PDF;/* Apuntamos al modelo que existe por defecto para obtener información en PDF */


class CronogramasGeneralController extends Controller
{
    public function index(){

        $administradores = AdministradoresModel::all();
        $direccionesEjecutivas = DireccionesEjecutivasModel::all();
        $departamentos = DepartamentosModel::all();
        $ambientes = AmbientesModel::all();
        $equipos = EquiposModel::all();
        $cronogramasGeneral = DB::select('SELECT C.id_cronogramaGeneral,C.mes_cronogramaGeneral,C.año_cronogramaGeneral,E.nombre_equipo,A.nombre_ambiente,
                                        E.marca_equipo,E.modelo_equipo,E.serie_equipo,E.cp_equipo FROM cronogramageneral C
                                        INNER JOIN equipo E ON C.id_equipo = E.id_equipo INNER JOIN ambiente A ON
                                        E.id_ambiente = A.id_ambiente ORDER BY C.mes_cronogramaGeneral ASC');
        $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
        FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
        WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

$cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
        AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");


        return view("paginas.cronogramasGeneral",array("administradores"=>$administradores,"direccionesEjecutivas"=>$direccionesEjecutivas,
                                                        "departamentos"=>$departamentos,"ambientes"=>$ambientes,"equipos"=>$equipos,
                                                        "cronogramasGeneral"=>$cronogramasGeneral,"notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,
                                                        "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo));
    }

    public function store(request $request){

        $datos =  array("mes_cronogramaGeneral"=>$request->input("mes_cronograma"),
                        "año_cronogramaGeneral"=>$request->input("año_cronograma"),
                        "equipos_cronogramaGeneral"=>$request->input("equipos_cronograma"));

        foreach($datos["equipos_cronogramaGeneral"] as $valorEquiposCronogramasGeneral){
            $cronogramaGeneral_validacion = DB::select('select * from cronogramageneral where id_equipo = ?', [$valorEquiposCronogramasGeneral]);

/*         if(empty($cronogramaGeneral_validacion) == ""){
            return redirect("/cronogramasGeneral")->with("equipo-existe","");
        }else{ */
                if(!empty($datos)){
                    $validar = \Validator::make($datos,[
                        "mes_cronogramaGeneral"=>'required|regex:/^[0-9]+$/i',
                        "año_cronogramaGeneral"=>'required|regex:/^[0-9]+$/i',
                        "equipos_cronogramaGeneral"=>'required'
                    ]);

                    if($validar->fails()){
                        return redirect("/cronogramasGeneral")->with("no-validacion","");
                    }else{

                        foreach($datos["equipos_cronogramaGeneral"] as $valorEquiposCronogramasGeneral){

                        $cronogramaGeneral = new CronogramasGeneralModel();
                        $cronogramaGeneral->id_equipo = $valorEquiposCronogramasGeneral;
                        $cronogramaGeneral->mes_cronogramaGeneral = $datos["mes_cronogramaGeneral"];
                        $cronogramaGeneral->año_cronogramaGeneral = $datos["año_cronogramaGeneral"];

                        $cronogramaGeneral->save();

                        }

                        return redirect("/cronogramasGeneral")->with("ok-crear","");
                    }
                }else{
                    return redirect("/cronogramasGeneral")->with("error","");
                }
            /* } */
        }
    }

    public function destroy($id,Request $request){
        $validar = CronogramasGeneralModel::where("id_cronogramaGeneral",$id)->get();

        if(!empty($validar)){
            $cronogramaGeneral = CronogramasGeneralModel::where("id_cronogramaGeneral",$validar[0]["id_cronogramaGeneral"])->delete();
            //Responder al AJAX de JS
            return "ok";
        }else{
            return redirect("/cronogramasGeneral")->with("no-borrar", "");
        }
    }

    public function show($id){
        $cronogramaGeneral = CronogramasGeneralModel::where("id_cronogramaGeneral",$id)->get();
        $administradores = AdministradoresModel::all();
        $equipos = EquiposModel::all();
        $cronogramasGeneral = DB::select('SELECT C.id_cronogramaGeneral,C.mes_cronogramaGeneral,C.año_cronogramaGeneral,E.nombre_equipo,A.nombre_ambiente,
                                        E.marca_equipo,E.modelo_equipo,E.serie_equipo,E.cp_equipo FROM cronogramageneral C
                                        INNER JOIN equipo E ON C.id_equipo = E.id_equipo INNER JOIN ambiente A ON
                                        E.id_ambiente = A.id_ambiente ORDER BY C.mes_cronogramaGeneral ASC');
        $cronogramaGeneralUnidad =  DB::select('SELECT C.id_cronogramaGeneral,C.mes_cronogramaGeneral,C.año_cronogramaGeneral,E.id_equipo,E.nombre_equipo,A.nombre_ambiente,
                                                E.marca_equipo,E.modelo_equipo,E.serie_equipo,E.cp_equipo FROM cronogramageneral C
                                                INNER JOIN equipo E ON C.id_equipo = E.id_equipo INNER JOIN ambiente A ON
                                                E.id_ambiente = A.id_ambiente WHERE C.id_cronogramaGeneral = ? ORDER BY C.mes_cronogramaGeneral ASC',[$id]);
        $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
        FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
        WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

$cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
        AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        if(count($cronogramaGeneralUnidad) != 0){
            return view("paginas.cronogramasGeneral",array("status"=>200,"cronogramaGeneral"=>$cronogramaGeneral,
                                                            "cronogramasGeneral"=>$cronogramasGeneral,"administradores"=>$administradores,
                                                            "equipos"=>$equipos,"notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,
                                                            "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo),["cronogramaGeneralUnidad"=>$cronogramaGeneralUnidad]);
        }else{
            return view("paginas.cronogramasGeneral",array("status"=>404,"cronogramaGeneral"=>$cronogramaGeneral,
                                                            "cronogramasGeneral"=>$cronogramasGeneral,"administradores"=>$administradores,
                                                            "equipos"=>$equipos,"notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,
                                                            "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo),["cronogramaGeneralUnidad"=>$cronogramaGeneralUnidad]);
        }
    }

    public function update($id,Request $request){

        $datos =  array("id_equipo"=>$request->input("id_equipo"),
                        "mes_cronogramaGeneral"=>$request->input("mes_cronogramaGeneral"),
                        "año_cronogramaGeneral"=>$request->input("año_cronogramaGeneral"));

        if(!empty($datos)){
            $validar = \Validator::make($datos,[
                "id_equipo" => 'required|regex:/^[0-9]+$/i',
                "mes_cronogramaGeneral" => 'required|regex:/^[0-9]+$/i',
                "año_cronogramaGeneral" => 'required|regex:/^[0-9]+$/i'
            ]);

            if($validar->fails()){
                return redirect("/cronogramasGeneral")->with("no-validacion","");
            }else{
                $datos =  array("id_equipo"=>$request->input("id_equipo"),
                                "mes_cronogramaGeneral"=>$request->input("mes_cronogramaGeneral"),
                                "año_cronogramaGeneral"=>$request->input("año_cronogramaGeneral"));

                $cronogramaGeneral = CronogramasGeneralModel::where('id_cronogramaGeneral',$id)->update($datos);
                return redirect("/cronogramasGeneral")->with("ok-editar","");
            }
        }else{
            return redirect("/cronogramasGeneral")->with("error","");
        }

    }

    public function createPDF(Request $request){
        $cronogramasGeneral = DB::select('SELECT GROUP_CONCAT(C.mes_cronogramaGeneral)
                                        AS juntar_meses, C.id_cronogramaGeneral,C.mes_cronogramaGeneral,C.año_cronogramaGeneral,E.nombre_equipo,A.nombre_ambiente,
                                        E.marca_equipo,E.modelo_equipo,E.serie_equipo,E.cp_equipo FROM cronogramageneral C
                                        INNER JOIN equipo E ON C.id_equipo = E.id_equipo INNER JOIN ambiente A ON
                                        E.id_ambiente = A.id_ambiente GROUP BY C.id_equipo ORDER BY C.mes_cronogramaGeneral ASC');

        // compartir datos para ver
        view()->share('cronogramasGeneral',$cronogramasGeneral);

        $pdf = PDF::loadView('paginas.reportesCronogramasGeneral',$cronogramasGeneral);

        // descargar archivo PDF con método de descarga
        return $pdf->setPaper('a4','landscape')->stream('registroHistorio_Mantenimiento.pdf');
    }
}
