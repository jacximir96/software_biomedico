<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/* Modelos de nuestro proyecto */
use App\AdministradoresModel;
use App\DepartamentosModel;
use App\DireccionesEjecutivasModel;
use App\EquiposModel;
use App\AmbientesModel;
/* Fin de Modelos de nuestro proyecto */

use Illuminate\Support\Facades\DB;/* Agregar conbinaciones de tablas en la base de datos */
use Yajra\DataTables\Facades\DataTables;

class AmbientesController extends Controller
{
    
    public function getAmbiente() {
        if (request()->ajax()) {
            $ambientes_general = DB::select('SELECT A.id_ambiente,A.nombre_ambiente,A.estado_ambiente,A.id_departamento,A.id_direccionEjecutiva,
                                    D.id_departamento,D.nombre_departamento,D.iniciales_departamento,D.estado_departamento,D.id_direccionEjecutiva,
                                    DE.id_direccionEjecutiva,DE.nombre_direccionEjecutiva as nombre_direccionAmbiente,DE.iniciales_direccionEjecutiva as
                                    iniciales_direccionAmbiente,DEE.id_direccionEjecutiva,DEE.nombre_direccionEjecutiva as nombre_direccionDepartamento,
                                    DEE.iniciales_direccionEjecutiva as iniciales_direccionDepartamento,E.id_estado,E.nombre_estado
                                    FROM ambiente A LEFT JOIN departamento D ON A.id_departamento = D.id_departamento
                                    LEFT JOIN direccionejecutiva DE ON A.id_direccionEjecutiva = DE.id_direccionEjecutiva
                                    LEFT JOIN direccionejecutiva DEE ON D.id_direccionEjecutiva = DEE.id_direccionEjecutiva
                                    INNER JOIN estado E ON A.estado_ambiente = E.id_estado ORDER BY A.id_ambiente DESC');
            return DataTables::of($ambientes_general)->make(true);
        }
    }

    
    public function index(){

    $ambientes_general = DB::select('SELECT A.id_ambiente,A.nombre_ambiente,A.estado_ambiente,A.id_departamento,A.id_direccionEjecutiva,
                                    D.id_departamento,D.nombre_departamento,D.iniciales_departamento,D.estado_departamento,D.id_direccionEjecutiva,
                                    DE.id_direccionEjecutiva,DE.nombre_direccionEjecutiva as nombre_direccionAmbiente,DE.iniciales_direccionEjecutiva as
                                    iniciales_direccionAmbiente,DEE.id_direccionEjecutiva,DEE.nombre_direccionEjecutiva as nombre_direccionDepartamento,
                                    DEE.iniciales_direccionEjecutiva as iniciales_direccionDepartamento,E.id_estado,E.nombre_estado
                                    FROM ambiente A LEFT JOIN departamento D ON A.id_departamento = D.id_departamento
                                    LEFT JOIN direccionejecutiva DE ON A.id_direccionEjecutiva = DE.id_direccionEjecutiva
                                    LEFT JOIN direccionejecutiva DEE ON D.id_direccionEjecutiva = DEE.id_direccionEjecutiva
                                    INNER JOIN estado E ON A.estado_ambiente = E.id_estado ORDER BY A.id_ambiente DESC');

                            /* echo "<pre>"; print_r($ambientes_general); echo "</pre>";
                        return; */
    $direccionesEjecutivas = DireccionesEjecutivasModel::all();
    $administradores = AdministradoresModel::all();
    $departamentos = DepartamentosModel::all();
    $equipos = EquiposModel::all();
    $estado = DB::select('select * from estado');
    $ambientes = AmbientesModel::all();
    $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
    FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
    WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

$cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
    AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

    return view("paginas.ambientes",array("ambientes"=>$ambientes,"equipos"=>$equipos,"departamentos"=>$departamentos,"administradores"=>$administradores,'estado' => $estado,
                                            "direccionesEjecutivas"=>$direccionesEjecutivas,"notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,
                                            "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo,"ambientes_general"=>$ambientes_general));
}

                    public function store(Request $request){
                        $datos = array("nombre_ambiente"=>$request->input("nombre_ambiente"),
                                        "estado_ambiente"=>$request->input("estado_ambiente"),
                                        "id_departamento"=>$request->input("id_departamento"),
                                        "id_direccionEjecutiva"=>$request->input("id_direccionEjecutiva"));

                /*         echo "<pre>"; print_r($datos); echo "</pre>";
                        return; */

                                /* Validar datos */
                                if(!empty($datos)){
                                    $validar = \Validator::make($datos,[
                                        "nombre_ambiente"=>'required|regex:/^[,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                                        "estado_ambiente"=>'required'
                                    ]);

                                    /* Guardar Dirección Ejecutiva */
                                    if($validar->fails()){
                                        return redirect("/ambientes")->with("no-validacion","");
                                    }else{

                                        $ambiente = new AmbientesModel();
                                        $ambiente->nombre_ambiente = $datos["nombre_ambiente"];
                                        $ambiente->estado_ambiente = $datos["estado_ambiente"];
                                        $ambiente->id_departamento = $datos["id_departamento"];
                                        $ambiente->id_direccionEjecutiva = $datos["id_direccionEjecutiva"];

                                        $ambiente->save();
                                        return redirect('/ambientes')->with("ok-crear","");

                                    }
                                }else{
                                    return redirect('/ambientes')->with("error","");
                                }
                    }

    /* Inicio Eliminar un registro */
    public function destroy($id, Request $request){
        $validar = AmbientesModel::where("id_ambiente",$id)->get();
/*         echo "<pre>"; print_r($validar); echo "</pre>";
        return; */

        if(!empty($validar)){
            $ambiente = AmbientesModel::where("id_ambiente",$validar[0]["id_ambiente"])->delete();
            //Responder al AJAX de JS
            return "ok";
        }else{
            return redirect("/ambientes")->with("no-borrar", "");
        }
    } /* Fin Eliminar un registro */

    public function show($id){
        $ambiente = AmbientesModel::where("id_ambiente",$id)->get();
        $direccionesEjecutivas = DireccionesEjecutivasModel::all();
        $administradores = AdministradoresModel::all();
        $departamentos = DepartamentosModel::all();
        $ambientes = AmbientesModel::all();
        $estado = DB::select('select * from estado');

        $ambiente_departamento = DB::select('select * from ambiente A INNER JOIN
        departamento D ON D.id_departamento = A.id_departamento
        WHERE A.id_ambiente = ?',[$id]);

        $ambiente_direccionEjecutiva = DB::select('select * from ambiente A INNER JOIN
        direccionejecutiva DE ON DE.id_direccionEjecutiva = A.id_direccionEjecutiva
        WHERE A.id_ambiente = ?',[$id]);

        $ambiente_estado = DB::select('select * from ambiente A INNER JOIN
        estado E ON A.estado_ambiente = E.id_estado where id_ambiente = ?',[$id]);

        $estado = DB::select('select * from estado');

        $ambientes_general = DB::select('SELECT A.id_ambiente,A.nombre_ambiente,A.estado_ambiente,A.id_departamento,A.id_direccionEjecutiva,
                                    D.id_departamento,D.nombre_departamento,D.iniciales_departamento,D.estado_departamento,D.id_direccionEjecutiva,
                                    DE.id_direccionEjecutiva,DE.nombre_direccionEjecutiva as nombre_direccionAmbiente,DE.iniciales_direccionEjecutiva as
                                    iniciales_direccionAmbiente,DEE.id_direccionEjecutiva,DEE.nombre_direccionEjecutiva as nombre_direccionDepartamento,
                                    DEE.iniciales_direccionEjecutiva as iniciales_direccionDepartamento,E.id_estado,E.nombre_estado
                                    FROM ambiente A LEFT JOIN departamento D ON A.id_departamento = D.id_departamento
                                    LEFT JOIN direccionejecutiva DE ON A.id_direccionEjecutiva = DE.id_direccionEjecutiva
                                    LEFT JOIN direccionejecutiva DEE ON D.id_direccionEjecutiva = DEE.id_direccionEjecutiva
                                    INNER JOIN estado E ON A.estado_ambiente = E.id_estado ORDER BY A.id_ambiente DESC');

$notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

$cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        if(count($ambiente) != 0){
            return view("paginas.ambientes",array("status"=>200,"ambiente"=>$ambiente,"ambiente_departamento"=>$ambiente_departamento,'estado' => $estado,
        "direccionesEjecutivas"=>$direccionesEjecutivas,"administradores"=>$administradores,"departamentos"=>$departamentos,
        "ambiente_estado"=>$ambiente_estado,"estado"=>$estado,"notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,
        "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo,"ambientes_general"=>$ambientes_general,
        "ambiente_direccionEjecutiva"=>$ambiente_direccionEjecutiva));
        }else{
            return view("paginas.ambientes",array("status"=>404,"ambiente"=>$ambiente,"ambiente_departamento"=>$ambiente_departamento,'estado' => $estado,
            "direccionesEjecutivas"=>$direccionesEjecutivas,"administradores"=>$administradores,"departamentos"=>$departamentos,
            "ambiente_estado"=>$ambiente_estado,"estado"=>$estado,"notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,
            "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo,"ambientes_general"=>$ambientes_general,
            "ambiente_direccionEjecutiva"=>$ambiente_direccionEjecutiva));
        }
    }

    public function update($id,Request $request){
/*         $departamento_estado_direccionEjecutiva =DB::select('select * from departamento D INNER JOIN
                                            estado E ON D.estado_departamento = E.id_estado INNER JOIN
                                            direccionejecutiva Dir ON D.id_direccionEjecutiva = Dir.id_direccionEjecutiva'); */

        $datos = array("nombre_ambiente"=>$request->input("nombre_ambiente"),
                        "estado_ambiente"=>$request->input("estado_ambiente"),
                        "id_departamento"=>$request->input("id_departamento"),
                        "id_direccionEjecutiva"=>$request->input("id_direccionEjecutiva"));

        //validar los datos
        if(!empty($datos)){
            $validar = \Validator::make($datos,[
                "nombre_ambiente"=>'required|regex:/^[,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                "estado_ambiente"=>'required'
            ]);

            if($validar->fails()){
                return redirect("/ambientes")->with("no-validacion","");
            }else{

                $datos = array("nombre_ambiente"=>$request->input("nombre_ambiente"),
                                "estado_ambiente"=>$request->input("estado_ambiente"),
                                "id_departamento"=>$request->input("id_departamento"),
                                "id_direccionEjecutiva"=>$request->input("id_direccionEjecutiva"));

                $ambiente = AmbientesModel::where('id_ambiente',$id)->update($datos);
                return redirect("/ambientes")->with("ok-editar","");
            }

        }else{
            return redirect("/ambientes")->with("error","");
        }
    }
    public function showJson($id) {
        $ambiente = AmbientesModel::find($id);
        return $ambiente;
    }
}
