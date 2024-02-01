<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdministradoresModel;
use App\AmbientesModel;
use App\EquiposExterno1Model;
use App\ReportesFormato8Model;
use App\EquiposModel;

use Illuminate\Support\Facades\DB;/* Agregar conbinaciones de tablas en la base de datos */
use PDF;/* Apuntamos al modelo que existe por defecto para obtener información en PDF */

class ReportesFormato8Controller extends Controller
{
    public function index(){

        $administradores = AdministradoresModel::all();
        $ambientes = AmbientesModel::all();
        $equipos = EquiposModel::all();
        $equipoExterno1 = DB::select('SELECT *,ROUND(TIMESTAMPDIFF(MONTH,EE1.fecha_adquisicion_equipoExterno1,CURDATE())/12)
                                        AS antiguedad_equipo FROM equipoexterno1 EE1 INNER JOIN formato8 F ON EE1.id_equipoExterno1 = F.id_equipoExterno1');
        $tipoEquipamientos = DB::select('SELECT * FROM tipoequipamiento');
        $proveedores = DB::select('SELECT P.id_proveedor,P.razonSocial_proveedor FROM proveedor P');
        $ordenServicios = DB::select('SELECT OS.id_ordenServicio,OS.codigo_ordenServicio FROM ordenservicio OS');
        $equipos_criterios =  DB::select('SELECT *,ROUND(TIMESTAMPDIFF(MONTH,E.fecha_adquisicion_equipo,CURDATE())/12)
                                        AS antiguedad_equipo FROM equipo E INNER JOIN cronograma C ON E.id_equipo = C.id_equipo WHERE C.updated_at in
                                        (SELECT MAX(C.updated_at) FROM equipo E INNER JOIN cronograma C ON E.id_equipo = C.id_equipo GROUP BY E.id_equipo)');
        $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
        FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
        WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

$cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
        AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        return view('paginas.reportesFormato8',   array("administradores"=>$administradores,"notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,
                                                        "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo,"equipoExterno1"=>$equipoExterno1,
                                                        "ambientes"=>$ambientes,"tipoEquipamientos"=>$tipoEquipamientos,"equipos_criterios"=>$equipos_criterios,
                                                        "proveedores"=>$proveedores,"ordenServicios"=>$ordenServicios,"equipos"=>$equipos));
    }

    public function store(Request $request){
        $datos = array("nombre_equipo"=>$request->input("nombre_equipo"),
                        "marca_equipo"=>$request->input("marca_equipo"),
                        "modelo_equipo"=>$request->input("modelo_equipo"),
                        "serie_equipo"=>$request->input("serie_equipo"),
                        "cp_equipo"=>$request->input("cp_equipo"),
                        "id_tipoEquipamiento"=>$request->input("id_tipoEquipamiento"),
                        "id_ambiente"=>$request->input("id_ambiente"),
                        "fecha_adquisicion_equipo"=>$request->input("fecha_adquisicion_equipo"),
                        "tiempo_vida_util_equipo"=>$request->input("tiempo_vida_util_equipo"),
                        "programa_presupuestal"=>$request->input("programa_presupuestal"),
                        "producto"=>$request->input("producto"),
                        "actividad"=>$request->input("actividad"),
                        "familia"=>$request->input("familia"),
                        "equipamiento_adquirir"=>$request->input("equipamiento_adquirir"),
                        "costo_referencial"=>$request->input("costo_referencial"),
                        "fuente_costo"=>$request->input("fuente_costo"),
                        "prioridad_multianual"=>$request->input("prioridad_multianual"),
                        "orden_prelacion"=>$request->input("orden_prelacion"));

        /* $equipo_validacion = DB::select('select * from formato8 where id_equipo = ?', [$request->input("id_equipo")]); */
        /* $equipoExterno_validacion = DB::select('select * from formato7 where id_equipoExterno = ?', [$request->input("id_equipo")]); */

                /* echo "<pre>"; print_r($datos); echo "</pre>";
                return; */

            if(empty($equipo_validacion) == ""){
                return redirect("/reportesFormato8")->with("equipo-existe","");
            }else{

                /* Validar datos */
                if(!empty($datos)){
                    $validar = \Validator::make($datos,[
                        "costo_referencial"=>'required|regex:/^[.\\0-9]+$/i',
                        "prioridad_multianual"=>'required|regex:/^[0-9]+$/i',
                    ]);

                    /* Guardar Dirección Ejecutiva */
                    if($validar->fails()){
                        return redirect("/reportesFormato8")->with("no-validacion","");
                    }else{

                        $equipoexterno = new EquiposExterno1Model();
                        $equipoexterno->nombre_equipoExterno1 = $datos["nombre_equipo"];
                        $equipoexterno->marca_equipoExterno1 = $datos["marca_equipo"];
                        $equipoexterno->modelo_equipoExterno1 = $datos["modelo_equipo"];
                        $equipoexterno->serie_equipoExterno1 = $datos["serie_equipo"];
                        $equipoexterno->cp_equipoExterno1 = $datos["cp_equipo"];
                        $equipoexterno->id_tipoEquipamiento = $datos["id_tipoEquipamiento"];
                        $equipoexterno->id_ambiente = $datos["id_ambiente"];
                        $equipoexterno->fecha_adquisicion_equipoExterno1 = $datos["fecha_adquisicion_equipo"];
                        $equipoexterno->tiempo_vida_util_equipoExterno1 = $datos["tiempo_vida_util_equipo"];

                        $equipoexterno->save();


                        $extraer_equipos = DB::select('SELECT * FROM equipoexterno1 E ORDER BY E.id_equipoExterno1 DESC LIMIT 1');

                        $listaformato8 = new ReportesFormato8Model();
                        $listaformato8->id_equipoExterno1 = $extraer_equipos[0]->id_equipoExterno1;


                        $listaformato8->programa_presupuestal = $datos["programa_presupuestal"];
                        $listaformato8->producto = $datos["producto"];
                        $listaformato8->actividad = $datos["actividad"];
                        $listaformato8->familia = $datos["familia"];
                        $listaformato8->equipamiento_adquirir = $datos["equipamiento_adquirir"];
                        $listaformato8->costo_referencial = $datos["costo_referencial"];
                        $listaformato8->fuente_costo = $datos["fuente_costo"];
                        $listaformato8->prioridad_multianual = $datos["prioridad_multianual"];
                        $listaformato8->orden_prelacion = $datos["orden_prelacion"];

                        $listaformato8->save();

                        return redirect('/reportesFormato8')->with("ok-crear","");

                    }
                }else{
                    return redirect('/reportesFormato8')->with("error","");
                }
            }
    }

    public function createPDF(Request $request){
        $listadoFormato8 =  DB::select('SELECT *,ROUND(TIMESTAMPDIFF(MONTH,E.fecha_adquisicion_equipo,CURDATE())/12) AS antiguedad_equipo FROM equipo E INNER JOIN cronograma C ON E.id_equipo = C.id_equipo INNER JOIN ambiente A ON E.id_ambiente = A.id_ambiente INNER JOIN departamento D ON A.id_departamento = D.id_departamento INNER JOIN tipoequipamiento TE ON E.id_tipoEquipamiento = TE.id_tipoEquipamiento WHERE C.updated_at in (SELECT MAX(C.updated_at) FROM equipo E INNER JOIN cronograma C ON E.id_equipo = C.id_equipo INNER JOIN ambiente A ON E.id_ambiente = A.id_ambiente INNER JOIN departamento D ON A.id_departamento = D.id_departamento INNER JOIN tipoequipamiento TE ON E.id_tipoEquipamiento = TE.id_tipoEquipamiento GROUP BY E.id_equipo)');

/*         echo "<pre>"; print_r($listadoFormato8); echo "</pre>";
        return; */

        // compartir datos para ver
        view()->share('listadoFormato8',$listadoFormato8);

        $pdf = PDF::loadView('paginas.reportesFormato8R',$listadoFormato8);

        // descargar archivo PDF con método de descarga
        return $pdf->setPaper('a2','landscape')->stream('listado_Formato8.pdf');
    }

}
