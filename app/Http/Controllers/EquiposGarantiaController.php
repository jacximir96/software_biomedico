<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/* Modelos de nuestro proyecto */
use App\AdministradoresModel;
use App\DepartamentosModel;
use App\DireccionesEjecutivasModel;
use App\EquiposModel;
use App\AmbientesModel;
use App\CronogramasModel;
use App\EquiposGarantiaModel;
/* Fin de Modelos de nuestro proyecto */

use Illuminate\Support\Facades\DB;/* Agregar conbinaciones de tablas en la base de datos */
use PDF;/* Apuntamos al modelo que existe por defecto para obtener información en PDF */
use Yajra\DataTables\DataTables as DataTablesDataTables;


class EquiposGarantiaController extends Controller
{
    public function getequipoGarantia() {
        if (request()->ajax()) {
            $equiposGarantiaGeneral = DB::select("SELECT *,DE.iniciales_direccionEjecutiva as iniciales_direccionAmbiente,DEE.iniciales_direccionEjecutiva as iniciales_direccionDepartamento,
                                            ROUND(TIMESTAMPDIFF(MONTH,fecha_adquisicion_equipoGarantia,CURDATE())/12) AS antiguedad_equipoGarantia from equipogarantia E INNER JOIN ambiente A
                                            ON E.id_ambiente = A.id_ambiente LEFT JOIN departamento D ON A.id_departamento = D.id_departamento LEFT JOIN direccionejecutiva DE ON
                                            A.id_direccionEjecutiva = DE.id_direccionEjecutiva LEFT JOIN direccionejecutiva DEE ON D.id_direccionEjecutiva = DEE.id_direccionEjecutiva
                                            ORDER BY E.id_equipoGarantia DESC");
           return DataTablesDataTables::of($equiposGarantiaGeneral)->make(true);
        }
    }
    public function index(){

    
        $direccionesEjecutivas = DireccionesEjecutivasModel::all();
        $administradores = AdministradoresModel::all();
        $departamentos = DepartamentosModel::all();
        $equipos = EquiposModel::all();
        $ambientes = AmbientesModel::all();
        $equiposGarantia = EquiposGarantiaModel::all();
        $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
                                                    FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
                                                    WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        $cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
                                                    AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        return view("paginas.equiposGarantia",array("equipos"=>$equipos,"departamentos"=>$departamentos,"administradores"=>$administradores,
                                                    "direccionesEjecutivas"=>$direccionesEjecutivas,"ambientes"=>$ambientes,
                                                    "equiposGarantia"=>$equiposGarantia,"notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,
                                                    "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo,
                                                    ));
    }

    public function show($id){
        $equipoGarantia = EquiposGarantiaModel::where("id_equipoGarantia",$id)->get();
        $direccionesEjecutivas = DireccionesEjecutivasModel::all();
        $administradores = AdministradoresModel::all();
        $departamentos = DepartamentosModel::all();
        $ambientes = AmbientesModel::all();
        $equiposGarantia = EquiposGarantiaModel::all();
        $equipoGarantia_ambiente=DB::select('select * from equipogarantia A INNER JOIN
                                    ambiente AM ON A.id_ambiente = AM.id_ambiente WHERE A.id_equipoGarantia = ?',[$id]);

        $equiposGarantiaGeneral = DB::select("SELECT *,DE.iniciales_direccionEjecutiva as iniciales_direccionAmbiente,DEE.iniciales_direccionEjecutiva as iniciales_direccionDepartamento,
                                    ROUND(TIMESTAMPDIFF(MONTH,fecha_adquisicion_equipoGarantia,CURDATE())/12) AS antiguedad_equipoGarantia from equipogarantia E INNER JOIN ambiente A
                                    ON E.id_ambiente = A.id_ambiente LEFT JOIN departamento D ON A.id_departamento = D.id_departamento LEFT JOIN direccionejecutiva DE ON
                                    A.id_direccionEjecutiva = DE.id_direccionEjecutiva LEFT JOIN direccionejecutiva DEE ON D.id_direccionEjecutiva = DEE.id_direccionEjecutiva
                                    ORDER BY E.id_equipoGarantia DESC");

$notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

$cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        if(count($equipoGarantia) != 0){
            return view("paginas.equiposGarantia",array("status"=>200,"equipoGarantia"=>$equipoGarantia,"equipoGarantia_ambiente"=>$equipoGarantia_ambiente,'equiposGarantia' => $equiposGarantia,
        "direccionesEjecutivas"=>$direccionesEjecutivas,"administradores"=>$administradores,"departamentos"=>$departamentos,
        "ambientes"=>$ambientes,"notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,"cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo,
        "equiposGarantiaGeneral"=>$equiposGarantiaGeneral));
        }else{
            return view("paginas.equiposGarantia",array("status"=>404,"equipoGarantia"=>$equipoGarantia,"equipoGarantia_ambiente"=>$equipoGarantia_ambiente, 'equiposGarantia' => $equiposGarantia,
            "direccionesEjecutivas"=>$direccionesEjecutivas,"administradores"=>$administradores,"departamentos"=>$departamentos,
            "ambientes"=>$ambientes,"notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,"cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo,
            "equiposGarantiaGeneral"=>$equiposGarantiaGeneral));
        }
    }

    /* Inicio Eliminar un registro */
    public function destroy($id, Request $request){
        $validar = EquiposGarantiaModel::where("id_equipoGarantia",$id)->get();

        if(!empty($validar)){
            $equipoGarantia = EquiposGarantiaModel::where("id_equipoGarantia",$validar[0]["id_equipoGarantia"])->delete();
            //Responder al AJAX de JS
            return "ok";
        }else{
            return redirect("/equiposGarantia")->with("no-borrar", "");
        }
    } /* Fin Eliminar un registro */

    public function store(Request $request){
        $datos = array("nombre_equipo"=>$request->input("nombre_equipo"),
                        "marca_equipo"=>$request->input("marca_equipo"),
                        "modelo_equipo"=>$request->input("modelo_equipo"),
                        "serie_equipo"=>$request->input("serie_equipo"),
                        "cp_equipo"=>$request->input("cp_equipo"),
                        "id_ambiente"=>$request->input("id_ambiente"),
                        "fecha_adquisicion_equipo"=>$request->input("fecha_adquisicion_equipo"),
                        "monto_adquisicion_equipo"=>$request->input("monto_adquisicion_equipo"),
                        "tiempo_vida_util_equipo"=>$request->input("tiempo_vida_util_equipo"));

        $imagenEquipo = array("imagen_equipo"=>$request->file("foto"));

        $cp_validacion = DB::select('select * from equipogarantia where cp_equipoGarantia = ?', [$request->input("cp_equipo")]);

        if(empty($cp_validacion) == ""){
            return redirect("/equiposGarantia")->with("cp-existe","");
        }else{

                /* Validar datos */
                if(!empty($datos)){
                    $validar = \Validator::make($datos,[
                        "nombre_equipo"=>'required|regex:/^[_\\-\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                        "marca_equipo"=>'required|regex:/^[-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                        "modelo_equipo"=>'required|regex:/^[-\\/\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                        "serie_equipo"=>'required|regex:/^[-\\/\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                        "cp_equipo"=>'required|regex:/^[0-9]+$/i',
                        "id_ambiente"=>'required',
                        "fecha_adquisicion_equipo"=>'required',
                        "monto_adquisicion_equipo"=>'required|regex:/^[.\\0-9]+$/i',
                        "tiempo_vida_util_equipo"=>'required|regex:/^[0-9]+$/i'
                    ]);

                    /* Guardar Dirección Ejecutiva */
                    if($validar->fails()){
                        return redirect("/equiposGarantia")->with("no-validacion","");
                    }else{

                        if($imagenEquipo["imagen_equipo"]==''){
                            $ruta = "img/equiposGarantia/sinImagen.jpg";
                        }else{
                            $aleatorio = mt_rand(100,999);
                            $ruta = "img/equiposGarantia/".$aleatorio.".".$imagenEquipo["imagen_equipo"]->guessExtension();
                            move_uploaded_file($imagenEquipo["imagen_equipo"], $ruta);
                        }

                        $equipoGarantia = new EquiposGarantiaModel();
                        $equipoGarantia->nombre_equipoGarantia = $datos["nombre_equipo"];
                        $equipoGarantia->marca_equipoGarantia = $datos["marca_equipo"];
                        $equipoGarantia->modelo_equipoGarantia = $datos["modelo_equipo"];
                        $equipoGarantia->serie_equipoGarantia = $datos["serie_equipo"];
                        $equipoGarantia->cp_equipoGarantia = $datos["cp_equipo"];
                        $equipoGarantia->id_ambiente = $datos["id_ambiente"];
                        $equipoGarantia->fecha_adquisicion_equipoGarantia = $datos["fecha_adquisicion_equipo"];
                        $equipoGarantia->monto_adquisicion_equipoGarantia = $datos["monto_adquisicion_equipo"];
                        $equipoGarantia->tiempo_vida_util_equipoGarantia = $datos["tiempo_vida_util_equipo"];
                        $equipoGarantia->imagen_equipoGarantia = $ruta;
                        $equipoGarantia->save();

                        return redirect('/equiposGarantia')->with("ok-crear","");

                    }
                }else{
                    return redirect('/equiposGarantia')->with("error","");
                }

        }
    }

    public function update($id,Request $request){
        $datos = array("nombre_equipoGarantia"=>$request->input("nombre_equipo"),
                        "marca_equipoGarantia"=>$request->input("marca_equipo"),
                        "modelo_equipoGarantia"=>$request->input("modelo_equipo"),
                        "serie_equipoGarantia"=>$request->input("serie_equipo"),
                        "cp_equipoGarantia"=>$request->input("cp_equipo"),
                        "id_ambiente"=>$request->input("id_ambiente"),
                        "fecha_adquisicion_equipoGarantia"=>$request->input("fecha_adquisicion_equipo"),
                        "monto_adquisicion_equipoGarantia"=>$request->input("monto_adquisicion_equipo"),
                        "tiempo_vida_util_equipoGarantia"=>$request->input("tiempo_vida_util_equipo"));

        $imagen_actual = array("imagen_actual"=>$request->input("imagen_actual"));
        $imagenEquipo = array("imagen_equipoGarantia"=>$request->file("foto"));

/*                         echo "<pre>"; print_r($imagen_actual); echo "</pre>";
                        echo "<pre>"; print_r($imagenEquipo); echo "</pre>";
        return; */

        //validar los datos
        if(!empty($datos)){
            $validar = \Validator::make($datos,[
                "nombre_equipoGarantia"=>'required|regex:/^[_\\-\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                "marca_equipoGarantia"=>'required|regex:/^[-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                "modelo_equipoGarantia"=>'required|regex:/^[-\\/\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                "serie_equipoGarantia"=>'required|regex:/^[-\\/\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                "cp_equipoGarantia"=>'required|regex:/^[0-9]+$/i',
                "id_ambiente"=>'required',
                "fecha_adquisicion_equipoGarantia"=>'required',
                "monto_adquisicion_equipoGarantia"=>'required|regex:/^[.\\0-9]+$/i',
                "tiempo_vida_util_equipoGarantia"=>'required|regex:/^[0-9]+$/i'
            ]);

            if($validar->fails()){
                return redirect("/equiposGarantia")->with("no-validacion","");
            }else{

                if($imagenEquipo["imagen_equipoGarantia"] != ""){

                    if(!empty($imagen_actual["imagen_actual"])){

                        if($imagen_actual["imagen_actual"] != "img/equiposGarantia/sinImagen.jpg"){

                            unlink($imagen_actual["imagen_actual"]);

                        }

                    }

                    $aleatorio = mt_rand(100,999);

                    $ruta = "img/equiposGarantia/".$aleatorio.".".$imagenEquipo["imagen_equipoGarantia"]->guessExtension();

                    move_uploaded_file($imagenEquipo["imagen_equipoGarantia"], $ruta);

                }else{
                    $ruta = $imagen_actual["imagen_actual"];
                }

                $datos = array("nombre_equipoGarantia"=>$request->input("nombre_equipo"),
                                "marca_equipoGarantia"=>$request->input("marca_equipo"),
                                "modelo_equipoGarantia"=>$request->input("modelo_equipo"),
                                "serie_equipoGarantia"=>$request->input("serie_equipo"),
                                "cp_equipoGarantia"=>$request->input("cp_equipo"),
                                "id_ambiente"=>$request->input("id_ambiente"),
                                "fecha_adquisicion_equipoGarantia"=>$request->input("fecha_adquisicion_equipo"),
                                "monto_adquisicion_equipoGarantia"=>$request->input("monto_adquisicion_equipo"),
                                "tiempo_vida_util_equipoGarantia"=>$request->input("tiempo_vida_util_equipo"),
                                "imagen_equipoGarantia"=>$ruta);

                $equipoGarantia = EquiposGarantiaModel::where('id_equipoGarantia',$id)->update($datos);
                return redirect("/equiposGarantia")->with("ok-editar","");
            }

        }else{
            return redirect("/equiposGarantia")->with("error","");
        }
    }

    public function createPDF($id,Request $request) {

        $equiposGarantia = DB::select('select EG.id_equipoGarantia, EG.id_ambiente, EG.cp_equipoGarantia, EG.nombre_equipoGarantia,
                                        EG.marca_equipoGarantia, EG.modelo_equipoGarantia, EG.serie_equipoGarantia, A.nombre_ambiente,
                                        EG.fecha_adquisicion_equipoGarantia, D.nombre_departamento, D.iniciales_departamento
                                        from equipogarantia EG INNER JOIN ambiente A ON EG.id_ambiente = A.id_ambiente LEFT JOIN
                                        departamento D ON A.id_departamento = D.id_departamento
                                        where EG.id_equipoGarantia = ?',[$id]);

        $cronogramaCalendarioEquiposGarantia = DB::select('select CC.fecha,CC.observacion,CC.id_proveedor,P.razonSocial_proveedor from cronogramacalendario CC
                                                            INNER JOIN proveedor P ON CC.id_proveedor = P.id_proveedor where
                                                            CC.id_equipoGarantia = ? and CC.realizado = 1 ORDER BY CC.fecha ASC',[$id]);

/*         echo "<pre>"; print_r($equiposGarantia); echo "</pre>";
        return; */

        // compartir datos para ver
        view()->share('cronogramaCalendarioEquiposGarantia',$cronogramaCalendarioEquiposGarantia);
        view()->share('equiposGarantia',$equiposGarantia);

        $pdf = PDF::loadView('paginas.reportesEquiposGarantia',$equiposGarantia);

        // descargar archivo PDF con método de descarga
        return $pdf->setPaper('a4','portrait')->stream('equipos.pdf');
      }
      public function showJson($id) {
        $equipogarantia = EquiposGarantiaModel::with('ambiente')->find($id);
        return $equipogarantia;
      }
}
