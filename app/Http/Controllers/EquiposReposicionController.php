<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdministradoresModel;
use App\EquiposModel;
use App\EquiposGarantiaModel;



use Illuminate\Support\Facades\DB;/* Agregar conbinaciones de tablas en la base de datos */
use Yajra\DataTables\Facades\DataTables;

class EquiposReposicionController extends Controller
{
    public function getequipoReposicion(Request $request) 
    {

        if (request()->ajax()) {

            $equipoReposicion = DB::select('SELECT *, ROUND(TIMESTAMPDIFF(MONTH, E.fecha_adquisicion_equipo, CURDATE())/12) AS antiguedad_equipo
            FROM equipo E 
            INNER JOIN cronograma C ON E.id_equipo = C.id_equipo 
            WHERE C.updated_at IN (
                SELECT MAX(C.updated_at) 
                FROM equipo E 
                INNER JOIN cronograma C ON E.id_equipo = C.id_equipo 
                GROUP BY E.id_equipo
            )');

        $resultado = [];

        foreach ($equipoReposicion as $equipo) {
            $valor_antiguedad = $equipo->antiguedad_equipo >= $equipo->tiempo_vida_util_equipo ? 1 : 0;
            $valor_porcentaje = (100 * $equipo->acumulado_cronograma) / $equipo->monto_adquisicion_equipo >= 40 ? 1 : 0;
            
            if ($equipo->baja_equipo != 1 && ($equipo->criterio_7 == 1 || ($equipo->baja_equipo != 1 && $equipo->criterio_1 + $valor_porcentaje + $equipo->criterio_3 + $equipo->criterio_4 + $valor_antiguedad + $equipo->criterio_6 >= 2))) {
                $resultado[] = $equipo;
            }
        }

        return DataTables::of($resultado)->make(true);
    }
            
            // if($equipoReposicion->antiguedad_equipo> =)
            
        }
    public function index(){
        $administradores = AdministradoresModel::all();
        

        $suma_criterios = $administradores[0]->suma_criterios;
        $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
                                                    FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
                                                    WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");
 $equipos_criterios = DB::select('SELECT *,ROUND(TIMESTAMPDIFF(MONTH,E.fecha_adquisicion_equipo,CURDATE())/12)
                                      AS antiguedad_equipo FROM equipo E INNER JOIN cronograma C ON E.id_equipo = C.id_equipo WHERE C.updated_at in
                                      (SELECT MAX(C.updated_at) FROM equipo E INNER JOIN cronograma C ON E.id_equipo = C.id_equipo GROUP BY E.id_equipo)');
        $cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
                                                    AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        return view("paginas.equiposReposicion",  array("administradores"=>$administradores,"suma_criterios"=>$suma_criterios,'equipos_criterios' => $equipos_criterios,
                                                        "notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,
                                                        "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo));
    }

    public function show($id){
        $equipo_criterio = DB::select('SELECT * FROM equipo WHERE id_equipo = ?',[$id]);
        $administradores = AdministradoresModel::all();
        $equipos_criterios = DB::select('SELECT *,ROUND(TIMESTAMPDIFF(MONTH,E.fecha_adquisicion_equipo,CURDATE())/12)
                                        AS antiguedad_equipo FROM equipo E INNER JOIN cronograma C ON E.id_equipo = C.id_equipo WHERE C.updated_at in
                                        (SELECT MAX(C.updated_at) FROM equipo E INNER JOIN cronograma C ON E.id_equipo = C.id_equipo GROUP BY E.id_equipo)');

        $suma_criterios = $administradores[0]->suma_criterios;
        $equiposGarantia = EquiposGarantiaModel::all();
        $equipos = EquiposModel::all();
        $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
                                                    FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
                                                    WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        $cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
                                                    AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        if(count($equipo_criterio) != 0){
            return view("paginas.equiposReposicion",array("status"=>200,"equipo_criterio"=>$equipo_criterio,"equiposGarantia"=>$equiposGarantia,'equipos' => $equipos,
        "administradores"=>$administradores,"equipos_criterios"=>$equipos_criterios,"suma_criterios"=>$suma_criterios,
        "notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,"cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo));
        }else{
            return view("paginas.equiposReposicion",array("status"=>404,"equipo_criterio"=>$equipo_criterio,"equiposGarantia"=>$equiposGarantia,'equipos' => $equipos,
            "administradores"=>$administradores,"equipos_criterios"=>$equipos_criterios,"suma_criterios"=>$suma_criterios,
            "notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,"cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo));
        }
    }

    public function update($id,Request $request){

        
        $datos = array("fecha_baja"=>$request->input("fecha_baja"),
                        "equipo_baja"=>$request->input("equipo_baja"));

/*              echo "<pre>"; print_r($datos); echo "</pre>";
            return; */

        //validar los datos
        if(!empty($datos)){
            $validar = \Validator::make($datos,[
                "fecha_baja"=>'required',
                "equipo_baja"=>'required|regex:/^[,\\:\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
            ]);

            if($validar->fails()){
                return redirect("/equiposReposicion")->with("no-validacion","");
            }else{

                $datos = array("fecha_baja"=>$request->input("fecha_baja"),
                                "idEquipo_baja"=>$request->input("equipo_baja"),
                                "baja_equipo"=>1);

                $equipo_criterio = EquiposModel::where('id_equipo',$id)->update($datos);
                return redirect("/equiposReposicion")->with("ok-editar","");
            }

        }else{
            return redirect("/equiposReposicion")->with("error","");
        }
    }
    public function showJson($id) {
        $equipo =EquiposModel::find($id);
        return $equipo;
    }
}
