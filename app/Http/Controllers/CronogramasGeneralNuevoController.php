<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/* Modelos de nuestro proyecto */
use App\AdministradoresModel;
use App\DireccionesEjecutivasModel;
use App\DepartamentosModel;
use App\AmbientesModel;
use App\RolesModel;
use App\EquiposGarantiaModel;
use App\CronogramasGeneralModel;
use App\CronogramasGeneralNuevoModel;
/* Fin de Modelos de nuestro proyecto */

use Illuminate\Support\Facades\DB;/* Agregar conbinaciones de tablas en la base de datos */
use PDF;/* Apuntamos al modelo que existe por defecto para obtener información en PDF */

class CronogramasGeneralNuevoController extends Controller
{
    public function index(){

        $administradores = AdministradoresModel::all();
        $direccionesEjecutivas = DireccionesEjecutivasModel::all();
        $departamentos = DepartamentosModel::all();
        $ambientes = AmbientesModel::all();
        $equiposGarantia = EquiposGarantiaModel::all();
        $cronogramasGeneralNuevo = DB::select('SELECT C.id_cronogramaGeneralNuevo,C.mes_cronogramaGeneralNuevo,C.año_cronogramaGeneralNuevo,E.nombre_equipoGarantia,A.nombre_ambiente,
                                                E.marca_equipoGarantia,E.modelo_equipoGarantia,E.serie_equipoGarantia,E.cp_equipoGarantia,C.realizado FROM cronogramageneralnuevo C
                                                INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia INNER JOIN ambiente A ON
                                                E.id_ambiente = A.id_ambiente ORDER BY C.mes_cronogramaGeneralNuevo ASC');

$notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

$cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        return view("paginas.cronogramasGeneralNuevo",array("administradores"=>$administradores,"direccionesEjecutivas"=>$direccionesEjecutivas,
                                                        "departamentos"=>$departamentos,"ambientes"=>$ambientes,"equiposGarantia"=>$equiposGarantia,
                                                        "cronogramasGeneralNuevo"=>$cronogramasGeneralNuevo,"notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,
                                                        "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo));
    }

    public function store(request $request){

        $datos =  array("mes_cronogramaGeneral"=>$request->input("mes_cronograma"),
                        "año_cronogramaGeneral"=>$request->input("año_cronograma"),
                        "equipos_cronogramaGeneral"=>$request->input("equipos_cronograma"));

        foreach($datos["equipos_cronogramaGeneral"] as $valorEquiposCronogramasGeneral){
            $cronogramaGeneral_validacion = DB::select('select * from cronogramageneralNuevo where id_equipoGarantia = ?', [$valorEquiposCronogramasGeneral]);

/*         if(empty($cronogramaGeneral_validacion) == ""){
            return redirect("/cronogramasGeneralNuevo")->with("equipo-existe","");
        }else{ */
                if(!empty($datos)){
                    $validar = \Validator::make($datos,[
                        "mes_cronogramaGeneral"=>'required|regex:/^[0-9]+$/i',
                        "año_cronogramaGeneral"=>'required|regex:/^[0-9]+$/i',
                        "equipos_cronogramaGeneral"=>'required'
                    ]);

                    if($validar->fails()){
                        return redirect("/cronogramasGeneralNuevo")->with("no-validacion","");
                    }else{

                        foreach($datos["equipos_cronogramaGeneral"] as $valorEquiposCronogramasGeneral){

                        $cronogramaGeneral = new CronogramasGeneralNuevoModel();
                        $cronogramaGeneral->id_equipoGarantia = $valorEquiposCronogramasGeneral;
                        $cronogramaGeneral->mes_cronogramaGeneralNuevo = $datos["mes_cronogramaGeneral"];
                        $cronogramaGeneral->año_cronogramaGeneralNuevo = $datos["año_cronogramaGeneral"];

                        $cronogramaGeneral->save();

                        }

                        return redirect("/cronogramasGeneralNuevo")->with("ok-crear","");
                    }
                }else{
                    return redirect("/cronogramasGeneralNuevo")->with("error","");
                }
            /* } */
        }
    }

    public function destroy($id,Request $request){
        $validar = CronogramasGeneralNuevoModel::where("id_cronogramaGeneralNuevo",$id)->get();

        if(!empty($validar)){
            $cronogramaGeneralNuevo = CronogramasGeneralNuevoModel::where("id_cronogramaGeneralNuevo",$validar[0]["id_cronogramaGeneralNuevo"])->delete();
            //Responder al AJAX de JS
            return "ok";
        }else{
            return redirect("/cronogramasGeneralNuevo")->with("no-borrar", "");
        }
    }

    public function show($id){
        $cronogramaGeneral = CronogramasGeneralModel::where("id_cronogramaGeneral",$id)->get();
        $administradores = AdministradoresModel::all();
        $equiposGarantia = EquiposGarantiaModel::all();
        $cronogramasGeneralNuevo = DB::select('SELECT C.id_cronogramaGeneralNuevo,C.mes_cronogramaGeneralNuevo,C.año_cronogramaGeneralNuevo,E.nombre_equipoGarantia,A.nombre_ambiente,
                                                E.marca_equipoGarantia,E.modelo_equipoGarantia,E.serie_equipoGarantia,E.cp_equipoGarantia,C.realizado FROM cronogramageneralnuevo C
                                                INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia INNER JOIN ambiente A ON
                                                E.id_ambiente = A.id_ambiente ORDER BY C.mes_cronogramaGeneralNuevo ASC');

        $cronogramaGeneralNuevoUnidad =  DB::select('SELECT C.id_cronogramaGeneralNuevo,C.mes_cronogramaGeneralNuevo,C.año_cronogramaGeneralNuevo,E.id_equipoGarantia,E.nombre_equipoGarantia,A.nombre_ambiente,
                                                E.marca_equipoGarantia,E.modelo_equipoGarantia,E.serie_equipoGarantia,E.cp_equipoGarantia FROM cronogramageneralnuevo C
                                                INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia INNER JOIN ambiente A ON
                                                E.id_ambiente = A.id_ambiente WHERE C.id_cronogramaGeneralNuevo = ? ORDER BY C.mes_cronogramaGeneralNuevo ASC',[$id]);

$notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

$cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");


        if(count($cronogramaGeneralNuevoUnidad) != 0){
            return view("paginas.cronogramasGeneralNuevo",array("status"=>200,"cronogramaGeneral"=>$cronogramaGeneral,"equiposGarantia"=>$equiposGarantia,
                                                            "cronogramasGeneralNuevo"=>$cronogramasGeneralNuevo,"administradores"=>$administradores,
                                                            "notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,
                                                            "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo),["cronogramaGeneralNuevoUnidad"=>$cronogramaGeneralNuevoUnidad]);
        }else{
            return view("paginas.cronogramasGeneralNuevo",array("status"=>404,"cronogramaGeneral"=>$cronogramaGeneral,"equiposGarantia"=>$equiposGarantia,
                                                            "cronogramasGeneralNuevo"=>$cronogramasGeneralNuevo,"administradores"=>$administradores,
                                                            "notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,
                                                            "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo),["cronogramaGeneralNuevoUnidad"=>$cronogramaGeneralNuevoUnidad]);
        }
    }

    public function update($id,Request $request){

        $datos =  array("id_equipoGarantia"=>$request->input("id_equipo"),
                        "mes_cronogramaGeneralNuevo"=>$request->input("mes_cronogramaGeneral"),
                        "año_cronogramaGeneralNuevo"=>$request->input("año_cronogramaGeneral"));

        if(!empty($datos)){
            $validar = \Validator::make($datos,[
                "id_equipoGarantia" => 'required|regex:/^[0-9]+$/i',
                "mes_cronogramaGeneralNuevo" => 'required|regex:/^[0-9]+$/i',
                "año_cronogramaGeneralNuevo" => 'required|regex:/^[0-9]+$/i'
            ]);

            if($validar->fails()){
                return redirect("/cronogramasGeneralNuevo")->with("no-validacion","");
            }else{
                $datos =  array("id_equipoGarantia"=>$request->input("id_equipo"),
                                "mes_cronogramaGeneralNuevo"=>$request->input("mes_cronogramaGeneral"),
                                "año_cronogramaGeneralNuevo"=>$request->input("año_cronogramaGeneral"));

                $cronogramaGeneralNuevo = CronogramasGeneralNuevoModel::where('id_cronogramaGeneralNuevo',$id)->update($datos);
                return redirect("/cronogramasGeneralNuevo")->with("ok-editar","");
            }
        }else{
            return redirect("/cronogramasGeneralNuevo")->with("error","");
        }

    }

    public function createPDF(Request $request){
        $cronogramasGeneralNuevo = DB::select("SELECT GROUP_CONCAT(C.mes_cronogramaGeneralNuevo)
                                                AS juntar_meses,C.id_cronogramaGeneralNuevo,C.mes_cronogramaGeneralNuevo,C.año_cronogramaGeneralNuevo,
                                                E.nombre_equipoGarantia,A.nombre_ambiente, E.marca_equipoGarantia,E.modelo_equipoGarantia,E.serie_equipoGarantia,
                                                E.cp_equipoGarantia FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
                                                INNER JOIN ambiente A ON E.id_ambiente = A.id_ambiente GROUP BY C.id_equipoGarantia ORDER BY C.mes_cronogramaGeneralNuevo ASC");

        // compartir datos para ver
        view()->share('cronogramasGeneralNuevo',$cronogramasGeneralNuevo);

        $pdf = PDF::loadView('paginas.reportesCronogramasGeneralNuevo',$cronogramasGeneralNuevo);

        // descargar archivo PDF con método de descarga
        return $pdf->setPaper('a4','landscape')->stream('registroHistorio_Mantenimiento.pdf');
    }
}
