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
/* Fin de Modelos de nuestro proyecto */

use Illuminate\Support\Facades\DB;/* Agregar conbinaciones de tablas en la base de datos */
use PDF;/* Apuntamos al modelo que existe por defecto para obtener información en PDF */

class EquiposController extends Controller
{
    public function index(){

        $direccionesEjecutivas = DireccionesEjecutivasModel::all();
        $administradores = AdministradoresModel::all();
        $departamentos = DepartamentosModel::all();
        $equipos = EquiposModel::all();
        $ambientes = AmbientesModel::all();
        $tipoEquipamientos = DB::select('SELECT * FROM tipoequipamiento');
        $equiposGeneral =DB::select('SELECT *,DE.iniciales_direccionEjecutiva as iniciales_direccionAmbiente,DEE.iniciales_direccionEjecutiva as iniciales_direccionDepartamento,
                                     ROUND(TIMESTAMPDIFF(MONTH,fecha_adquisicion_equipo,CURDATE())/12) AS antiguedad_equipo from equipo E INNER JOIN cronograma C ON E.id_equipo = C.id_equipo
                                     INNER JOIN ambiente A ON E.id_ambiente = A.id_ambiente LEFT JOIN departamento D ON A.id_departamento = D.id_departamento LEFT JOIN direccionejecutiva DE
                                     ON A.id_direccionEjecutiva = DE.id_direccionEjecutiva LEFT JOIN direccionejecutiva DEE ON D.id_direccionEjecutiva = DEE.id_direccionEjecutiva INNER JOIN
                                     tipoequipamiento TE ON E.id_tipoEquipamiento = TE.id_tipoEquipamiento WHERE C.updated_at in (SELECT MAX(C.updated_at) FROM equipo E INNER JOIN cronograma C
                                     ON E.id_equipo = C.id_equipo GROUP BY E.id_equipo)');
        $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
        FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
        WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

$cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
        AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

                return view("paginas.equipos",array("equipos"=>$equipos,"departamentos"=>$departamentos,"administradores"=>$administradores,
                                                        "direccionesEjecutivas"=>$direccionesEjecutivas,"ambientes"=>$ambientes,
                                                        "notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,"tipoEquipamientos"=>$tipoEquipamientos,
                                                        "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo,"equiposGeneral"=>$equiposGeneral));
            }

    public function show($id){
        /* $equipo = EquiposModel::where("id_equipo",$id)->get(); */
        $equipo = DB::select('select *,ROUND(TIMESTAMPDIFF(MONTH,fecha_adquisicion_equipo,CURDATE())/12) AS antiguedad_equipo from equipo where id_equipo = ?',[$id]);
        $cronogramas = DB::select('select * from cronograma C INNER JOIN proveedor P ON C.id_proveedor = P.id_proveedor
                                    INNER JOIN ordenservicio O ON C.id_ordenServicio = O.id_ordenServicio WHERE C.id_equipo = ? ORDER BY C.id_cronograma ASC',[$id]);
        $direccionesEjecutivas = DireccionesEjecutivasModel::all();
        $administradores = AdministradoresModel::all();
        $departamentos = DepartamentosModel::all();
        $ambientes = AmbientesModel::all();
        $tipoEquipamientos = DB::select('SELECT * FROM tipoequipamiento');

        $equiposGeneral =DB::select('SELECT *,DE.iniciales_direccionEjecutiva as iniciales_direccionAmbiente,DEE.iniciales_direccionEjecutiva as iniciales_direccionDepartamento,
                                     ROUND(TIMESTAMPDIFF(MONTH,fecha_adquisicion_equipo,CURDATE())/12) AS antiguedad_equipo from equipo E INNER JOIN cronograma C ON E.id_equipo = C.id_equipo
                                     INNER JOIN ambiente A ON E.id_ambiente = A.id_ambiente LEFT JOIN departamento D ON A.id_departamento = D.id_departamento LEFT JOIN direccionejecutiva DE
                                     ON A.id_direccionEjecutiva = DE.id_direccionEjecutiva LEFT JOIN direccionejecutiva DEE ON D.id_direccionEjecutiva = DEE.id_direccionEjecutiva INNER JOIN
                                     tipoequipamiento TE ON E.id_tipoEquipamiento = TE.id_tipoEquipamiento WHERE C.updated_at in (SELECT MAX(C.updated_at) FROM equipo E INNER JOIN cronograma C
                                     ON E.id_equipo = C.id_equipo GROUP BY E.id_equipo)');

        $equipo_ambiente=DB::select('select * from equipo A INNER JOIN
                                    ambiente AM ON A.id_ambiente = AM.id_ambiente WHERE A.id_equipo = ?',[$id]);

        $equipo_tipoEquipamiento=DB::select('SELECT * FROM equipo E INNER JOIN tipoequipamiento TE ON
                                            E.id_tipoEquipamiento  = TE.id_tipoEquipamiento WHERE E.id_equipo = ?',[$id]);

$notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

$cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        if(count($equipo) != 0){
            return view("paginas.equipos",array("status"=>200,"equipo"=>$equipo,"equipo_ambiente"=>$equipo_ambiente,
        "direccionesEjecutivas"=>$direccionesEjecutivas,"administradores"=>$administradores,"departamentos"=>$departamentos,
        "ambientes"=>$ambientes,"notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,"cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo,
        "cronogramas"=>$cronogramas,"tipoEquipamientos"=>$tipoEquipamientos,"equipo_tipoEquipamiento"=>$equipo_tipoEquipamiento,"equiposGeneral"=>$equiposGeneral));
        }else{
            return view("paginas.equipos",array("status"=>404,"direccionEjecutiva"=>$direccionEjecutiva,
            "direccionesEjecutivas"=>$direccionesEjecutivas,"administradores"=>$administradores,"departamentos"=>$departamentos,
            "ambientes"=>$ambientes,"notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,"cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo,
            "cronogramas"=>$cronogramas,"tipoEquipamientos"=>$tipoEquipamientos,"equipo_tipoEquipamiento"=>$equipo_tipoEquipamiento,"equiposGeneral"=>$equiposGeneral));
        }
    }

                /* Inicio Eliminar un registro */
    public function destroy($id, Request $request){
        $validar = EquiposModel::where("id_equipo",$id)->get();
        /*echo "<pre>"; print_r($validar); echo "</pre>";
        return; */

        if(!empty($validar)){
            $equipo = EquiposModel::where("id_equipo",$validar[0]["id_equipo"])->delete();
            //Responder al AJAX de JS
            return "ok";
        }else{
            return redirect("/equipos")->with("no-borrar", "");
        }
    } /* Fin Eliminar un registro */

    public function store(Request $request){
        $datos = array("nombre_equipo"=>$request->input("nombre_equipo"),
                        "marca_equipo"=>$request->input("marca_equipo"),
                        "modelo_equipo"=>$request->input("modelo_equipo"),
                        "serie_equipo"=>$request->input("serie_equipo"),
                        "cp_equipo"=>$request->input("cp_equipo"),
                        "id_tipoEquipamiento"=>$request->input("id_tipoEquipamiento"),
                        "id_ambiente"=>$request->input("id_ambiente"),
                        "fecha_adquisicion_equipo"=>$request->input("fecha_adquisicion_equipo"),
                        "monto_adquisicion_equipo"=>$request->input("monto_adquisicion_equipo"),
                        "tiempo_vida_util_equipo"=>$request->input("tiempo_vida_util_equipo"),
                        "prioridad_equipo"=>$request->input("prioridad_equipo"));

        $imagenEquipo = array("imagen_equipo"=>$request->file("foto"));

        $cp_validacion = DB::select('select * from equipo where cp_equipo = ?', [$request->input("cp_equipo")]);

        if(empty($cp_validacion) == ""){
            return redirect("/equipos")->with("cp-existe","");
        }else{

                /* Validar datos */
                if(!empty($datos)){
                    $validar = \Validator::make($datos,[
                        "nombre_equipo"=>'required|regex:/^[-\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                        "marca_equipo"=>'required|regex:/^[-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                        "modelo_equipo"=>'required|regex:/^[=\\-\\/\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                        "serie_equipo"=>'required|regex:/^[=\\-\\/\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                        "cp_equipo"=>'required|regex:/^[0-9]+$/i',
                        "id_tipoEquipamiento"=>'required',
                        "id_ambiente"=>'required',
                        "fecha_adquisicion_equipo"=>'required',
                        "monto_adquisicion_equipo"=>'required|regex:/^[.\\0-9]+$/i',
                        "tiempo_vida_util_equipo"=>'required|regex:/^[0-9]+$/i',
                        "prioridad_equipo"=>'required|regex:/^[0-9]+$/i'
                    ]);

                    /* Guardar Dirección Ejecutiva */
                    if($validar->fails()){
                        return redirect("/equipos")->with("no-validacion","");
                    }else{

                        if($imagenEquipo["imagen_equipo"]==''){
                            $ruta = "img/equipos/sinImagen.jpg";
                        }else{
                            $aleatorio = mt_rand(100,999);
                            $ruta = "img/equipos/".$aleatorio.".".$imagenEquipo["imagen_equipo"]->guessExtension();
                            move_uploaded_file($imagenEquipo["imagen_equipo"], $ruta);
                        }

                        $equipo = new EquiposModel();
                        $equipo->nombre_equipo = $datos["nombre_equipo"];
                        $equipo->marca_equipo = $datos["marca_equipo"];
                        $equipo->modelo_equipo = $datos["modelo_equipo"];
                        $equipo->serie_equipo = $datos["serie_equipo"];
                        $equipo->cp_equipo = $datos["cp_equipo"];
                        $equipo->id_tipoEquipamiento = $datos["id_tipoEquipamiento"];
                        $equipo->id_ambiente = $datos["id_ambiente"];
                        $equipo->fecha_adquisicion_equipo = $datos["fecha_adquisicion_equipo"];
                        $equipo->monto_adquisicion_equipo = $datos["monto_adquisicion_equipo"];
                        $equipo->tiempo_vida_util_equipo = $datos["tiempo_vida_util_equipo"];
                        $equipo->prioridad_equipo = $datos["prioridad_equipo"];
                        $equipo->criterio_1 = 0;
                        $equipo->criterio_3 = 0;
                        $equipo->criterio_4 = 0;
                        $equipo->criterio_6 = 0;
                        $equipo->imagen_equipo = $ruta;

                        $equipo->save();

                        $extraer_equipos = DB::select('SELECT * FROM equipo E ORDER BY E.id_equipo DESC LIMIT 1');

                        $cronograma = new CronogramasModel();
                        $cronograma->id_equipo = $extraer_equipos[0]->id_equipo;
                        $cronograma->fecha;
                        $cronograma->fecha_final;
                        $cronograma->id_mantenimiento;
                        $cronograma->id_proveedor;
                        $cronograma->garantia = 0;
                        $cronograma->monto_cronograma = 0;
                        $cronograma->acumulado_cronograma = 0;
                        $cronograma->realizado = 1;
                        $cronograma->observacion='';
                        $cronograma->id_ordenServicio;
                        $cronograma->id_departamento;
                        $cronograma->pdf_cronograma;
                        $cronograma->save();

                        return redirect('/equipos')->with("ok-crear","");

                    }
                }else{
                    return redirect('/equipos')->with("error","");
                }
        }
    }

    public function update($id,Request $request){
        $datos = array("nombre_equipo"=>$request->input("nombre_equipo"),
                        "marca_equipo"=>$request->input("marca_equipo"),
                        "modelo_equipo"=>$request->input("modelo_equipo"),
                        "serie_equipo"=>$request->input("serie_equipo"),
                        "cp_equipo"=>$request->input("cp_equipo"),
                        "id_tipoEquipamiento"=>$request->input("id_tipoEquipamiento"),
                        "id_ambiente"=>$request->input("id_ambiente"),
                        "fecha_adquisicion_equipo"=>$request->input("fecha_adquisicion_equipo"),
                        "monto_adquisicion_equipo"=>$request->input("monto_adquisicion_equipo"),
                        "tiempo_vida_util_equipo"=>$request->input("tiempo_vida_util_equipo"),
                        "prioridad_equipo"=>$request->input("prioridad_equipo"),
                        "criterio1_equipo"=>$request->input("criterio1_equipo"),
                        "criterio3_equipo"=>$request->input("criterio3_equipo"),
                        "criterio4_equipo"=>$request->input("criterio4_equipo"),
                        "criterio6_equipo"=>$request->input("criterio6_equipo"),
                        "criterio7_equipo"=>$request->input("criterio7_equipo"));

        $imagen_actual = array("imagen_actual"=>$request->input("imagen_actual"));
        $imagenEquipo = array("imagen_equipo"=>$request->file("foto"));

/*                 echo "<pre>"; print_r($datos); echo "</pre>";
                return; */

        //validar los datos
        if(!empty($datos)){
            $validar = \Validator::make($datos,[
                "nombre_equipo"=>'required|regex:/^[-\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                "marca_equipo"=>'required|regex:/^[-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                "modelo_equipo"=>'required|regex:/^[=\\-\\/\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                "serie_equipo"=>'required|regex:/^[=\\-\\/\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                "cp_equipo"=>'required|regex:/^[0-9]+$/i',
                "id_tipoEquipamiento"=>'required',
                "id_ambiente"=>'required',
                "fecha_adquisicion_equipo"=>'required',
                "monto_adquisicion_equipo"=>'required|regex:/^[.\\0-9]+$/i',
                "tiempo_vida_util_equipo"=>'required|regex:/^[0-9]+$/i',
                "prioridad_equipo"=>'required|regex:/^[0-9]+$/i'
            ]);

            if($validar->fails()){
                return redirect("/equipos")->with("no-validacion","");
            }else{

                if($imagenEquipo["imagen_equipo"] != ""){

                    if(!empty($imagen_actual["imagen_actual"])){

                        if($imagen_actual["imagen_actual"] != "img/equipos/sinImagen.jpg"){

                            unlink($imagen_actual["imagen_actual"]);

                        }

                    }

                    $aleatorio = mt_rand(100,999);

                    $ruta = "img/equipos/".$aleatorio.".".$imagenEquipo["imagen_equipo"]->guessExtension();

                    move_uploaded_file($imagenEquipo["imagen_equipo"], $ruta);

                }else{
                    $ruta = $imagen_actual["imagen_actual"];
                }

                $datos = array("nombre_equipo"=>$request->input("nombre_equipo"),
                                "marca_equipo"=>$request->input("marca_equipo"),
                                "modelo_equipo"=>$request->input("modelo_equipo"),
                                "serie_equipo"=>$request->input("serie_equipo"),
                                "cp_equipo"=>$request->input("cp_equipo"),
                                "id_tipoEquipamiento"=>$request->input("id_tipoEquipamiento"),
                                "id_ambiente"=>$request->input("id_ambiente"),
                                "fecha_adquisicion_equipo"=>$request->input("fecha_adquisicion_equipo"),
                                "monto_adquisicion_equipo"=>$request->input("monto_adquisicion_equipo"),
                                "tiempo_vida_util_equipo"=>$request->input("tiempo_vida_util_equipo"),
                                "prioridad_equipo"=>$request->input("prioridad_equipo"),
                                "criterio_1"=>$request->input("criterio1_equipo"),
                                "criterio_3"=>$request->input("criterio3_equipo"),
                                "criterio_4"=>$request->input("criterio4_equipo"),
                                "criterio_6"=>$request->input("criterio6_equipo"),
                                "criterio_7"=>$request->input("criterio7_equipo"),
                                "imagen_equipo"=>$ruta);

                $equipo = EquiposModel::where('id_equipo',$id)->update($datos);
                return redirect("/equipos")->with("ok-editar","");
            }

        }else{
            return redirect("/equipos")->with("error","");
        }
    }

    public function createPDF($id,Request $request) {

        $equipos = DB::select('SELECT E.id_equipo, E.id_ambiente, E.cp_equipo, E.nombre_equipo,
                               E.marca_equipo, E.modelo_equipo, E.serie_equipo, A.nombre_ambiente,
                               E.fecha_adquisicion_equipo, D.nombre_departamento, D.iniciales_departamento
                               FROM equipo E INNER JOIN ambiente A ON E.id_ambiente = A.id_ambiente LEFT JOIN
                               departamento D ON A.id_departamento = D.id_departamento
                               WHERE E.id_equipo = ?',[$id]);

        $cronogramaCalendarioEquipos = DB::select("SELECT C.id_mantenimiento,M.nombre_mantenimiento,C.fecha,C.observacion,C.id_proveedor,
                                                   CASE WHEN P.razonSocial_proveedor IS NULL THEN 'ÁREA DE INGENIERÍA ELECTRÓNICA DE LA OFICINA DE SERVICIOS GENERALES INR (ESGTMEB)'
                                                   ELSE P.razonSocial_proveedor END AS razonSocial_proveedor
                                                   FROM cronograma C LEFT JOIN proveedor P ON C.id_proveedor = P.id_proveedor INNER JOIN mantenimiento M ON
                                                   M.id_mantenimiento = C.id_mantenimiento WHERE
                                                   C.id_equipo = ? AND C.realizado = 1 ORDER BY C.fecha ASC",[$id]);

/*         echo "<pre>"; print_r($equiposGarantia); echo "</pre>";
        return; */

        // compartir datos para ver
        view()->share('cronogramaCalendarioEquipos',$cronogramaCalendarioEquipos);
        view()->share('equipos',$equipos);

        $pdf = PDF::loadView('paginas.reportesEquipos',$equipos);

        // descargar archivo PDF con método de descarga
        return $pdf->setPaper('a4','portrait')->stream('equipos.pdf');
      }

}
