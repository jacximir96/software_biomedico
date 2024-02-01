<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdministradoresModel;
use App\AmbientesModel;
use App\EquiposExternoModel;
use App\ReportesFormato7Model;
use App\EquiposModel;

use Illuminate\Support\Facades\DB;/* Agregar conbinaciones de tablas en la base de datos */
use PDF;/* Apuntamos al modelo que existe por defecto para obtener información en PDF */

class ReportesFormato7Controller extends Controller
{
    public function index(){

        $administradores = AdministradoresModel::all();
        $ambientes = AmbientesModel::all();
        $equipos = EquiposModel::all();
        $tipoEquipamientos = DB::select('SELECT * FROM tipoequipamiento');
        $proveedores = DB::select('SELECT P.id_proveedor,P.razonSocial_proveedor FROM proveedor P');
        $ordenServicios = DB::select('SELECT OS.id_ordenServicio,OS.codigo_ordenServicio FROM ordenservicio OS');
        $listadoFormato7 =  DB::select('SELECT EE.fecha_adquisicion_equipoExterno,E.fecha_adquisicion_equipo,F.id_formato7,AA.nombre_ambiente as ambienteEquipo,A.nombre_ambiente as ambienteEquipoExterno,T.nombre_tipoEquipamiento as tipoEquipamientoEquipoExterno,TE.nombre_tipoEquipamiento as tipoEquipamientoEquipo,EE.id_equipoExterno,EE.nombre_equipoExterno,EE.marca_equipoExterno,
                                        EE.modelo_equipoExterno,EE.serie_equipoExterno,EE.cp_equipoExterno,EE.id_tipoEquipamiento,EE.id_ambiente,EE.tiempo_vida_util_equipoExterno,EE.prioridad_equipoExterno,E.id_equipo,E.nombre_equipo,E.marca_equipo,
                                        E.modelo_equipo,E.serie_equipo,E.cp_equipo,E.id_ambiente,E.tiempo_vida_util_equipo,E.prioridad_equipo,T.id_tipoEquipamiento,T.nombre_tipoEquipamiento,P.id_proveedor,P.razonSocial_proveedor,F.nombre_proveedor2,
                                        F.precio_equipoNuevo,F.costo_mantenimiento,F.actividades_principales,F.prioridad_multianual,F.orden_prelacion,F.nombre_informe2,OS.id_ordenServicio,OS.codigo_ordenServicio FROM formato7 F LEFT JOIN
                                        equipoexterno EE ON F.id_equipoExterno = EE.id_equipoExterno LEFT JOIN equipo E ON F.id_equipo = E.id_equipo LEFT JOIN ambiente A ON EE.id_ambiente = A.id_ambiente LEFT JOIN
                                        tipoequipamiento T ON EE.id_tipoEquipamiento = T.id_tipoEquipamiento LEFT JOIN ambiente AA ON E.id_ambiente = AA.id_ambiente LEFT JOIN proveedor P ON F.id_proveedor = P.id_proveedor LEFT JOIN ordenservicio OS ON
                                        F.id_ordenServicio = OS.id_ordenServicio LEFT JOIN tipoequipamiento TE ON E.id_tipoEquipamiento = TE.id_tipoEquipamiento');
        $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
        FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
        WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

$cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
        AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        return view('paginas.reportesFormato7',   array("administradores"=>$administradores,"notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,
                                                        "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo,
                                                        "ambientes"=>$ambientes,"tipoEquipamientos"=>$tipoEquipamientos,"listadoFormato7"=>$listadoFormato7,
                                                        "proveedores"=>$proveedores,"ordenServicios"=>$ordenServicios,"equipos"=>$equipos));
    }

    /* Inicio Eliminar un registro */
    public function destroy($id, Request $request){
        $validar = ReportesFormato7Model::where("id_formato7",$id)->get();

        if(!empty($validar)){
            $formato7 = ReportesFormato7Model::where("id_formato7",$validar[0]["id_formato7"])->delete();
            //Responder al AJAX de JS
            return "ok";
        }else{
            return redirect("/reportesFormato7")->with("no-borrar", "");
        }
    } /* Fin Eliminar un registro */

    public function show($id,$id2){
        $formato7 = DB::select('SELECT F.criterio_2,F.criterio_3,F.criterio_4,F.criterio_5,EE.fecha_adquisicion_equipoExterno,E.fecha_adquisicion_equipo,F.id_formato7,AA.id_ambiente as id_ambienteEquipo,A.id_ambiente as id_ambienteEquipoExterno,AA.nombre_ambiente as ambienteEquipo,A.nombre_ambiente as ambienteEquipoExterno,F.id_equipo,F.id_equipoExterno,F.id_proveedor,F.nombre_proveedor2,F.id_ordenServicio,F.nombre_informe2,F.precio_equipoNuevo,F.costo_mantenimiento,
                                F.actividades_principales,F.prioridad_multianual,F.orden_prelacion,E.nombre_equipo,E.marca_equipo,E.modelo_equipo,E.serie_equipo,E.cp_equipo,E.tiempo_vida_util_equipo,E.prioridad_equipo,
                                EE.nombre_equipoExterno,EE.marca_equipoExterno,EE.modelo_equipoExterno,EE.serie_equipoExterno,EE.cp_equipoExterno,EE.tiempo_vida_util_equipoExterno,EE.prioridad_equipoExterno,
                                P.razonSocial_proveedor,OS.codigo_ordenServicio,TE.nombre_tipoEquipamiento as nombre_tipoEquipamientoEquipoExterno,TE.id_tipoEquipamiento as id_tipoEquipamientoEquipoExterno,TEE.id_tipoEquipamiento as id_tipoEquipamientoEquipo,TEE.nombre_tipoEquipamiento as nombre_tipoEquipamientoEquipo,A.id_ambiente,A.nombre_ambiente
                                FROM formato7 F LEFT JOIN equipo E ON F.id_equipo = E.id_equipo LEFT JOIN equipoexterno EE ON F.id_equipoExterno = EE.id_equipoExterno LEFT JOIN proveedor P ON
                                F.id_proveedor = P.id_proveedor LEFT JOIN ordenservicio OS ON F.id_ordenServicio = OS.id_ordenServicio
                                LEFT JOIN tipoequipamiento TE ON EE.id_tipoEquipamiento = TE.id_tipoEquipamiento LEFT JOIN tipoequipamiento TEE ON E.id_tipoEquipamiento = TEE.id_tipoEquipamiento LEFT JOIN ambiente AA ON E.id_ambiente = AA.id_ambiente LEFT JOIN ambiente A ON EE.id_ambiente = A.id_ambiente
                                WHERE F.id_formato7 = ?',[$id]);
        $formato7_decode = DB::select('SELECT F.id_formato7,F.actividades_principales FROM formato7 F WHERE id_formato7 = ?',[$id]);

        $administradores = AdministradoresModel::all();
        $ambientes = AmbientesModel::all();
        $equipos = EquiposModel::all();
        $cronogramas = DB::select('select * from cronograma C INNER JOIN proveedor P ON C.id_proveedor = P.id_proveedor
                                    INNER JOIN ordenservicio O ON C.id_ordenServicio = O.id_ordenServicio WHERE C.id_equipo = ? ORDER BY C.id_cronograma ASC',[$id2]);
                        /* echo "<pre>"; print_r($cronogramas); echo "</pre>";
                return; */
        $tipoEquipamientos = DB::select('SELECT * FROM tipoequipamiento');
        $proveedores = DB::select('SELECT P.id_proveedor,P.razonSocial_proveedor FROM proveedor P');
        $ordenServicios = DB::select('SELECT OS.id_ordenServicio,OS.codigo_ordenServicio FROM ordenservicio OS');
        $listadoFormato7 =  DB::select('SELECT EE.fecha_adquisicion_equipoExterno,E.fecha_adquisicion_equipo,F.id_formato7,AA.nombre_ambiente as ambienteEquipo,A.nombre_ambiente as ambienteEquipoExterno,T.nombre_tipoEquipamiento as tipoEquipamientoEquipoExterno,TE.nombre_tipoEquipamiento as tipoEquipamientoEquipo,EE.id_equipoExterno,EE.nombre_equipoExterno,EE.marca_equipoExterno,
                                        EE.modelo_equipoExterno,EE.serie_equipoExterno,EE.cp_equipoExterno,EE.id_tipoEquipamiento,EE.id_ambiente,EE.tiempo_vida_util_equipoExterno,EE.prioridad_equipoExterno,E.id_equipo,E.nombre_equipo,E.marca_equipo,
                                        E.modelo_equipo,E.serie_equipo,E.cp_equipo,E.id_ambiente,E.tiempo_vida_util_equipo,E.prioridad_equipo,T.id_tipoEquipamiento,T.nombre_tipoEquipamiento,P.id_proveedor,P.razonSocial_proveedor,F.nombre_proveedor2,
                                        F.precio_equipoNuevo,F.costo_mantenimiento,F.actividades_principales,F.prioridad_multianual,F.orden_prelacion,F.nombre_informe2,OS.id_ordenServicio,OS.codigo_ordenServicio FROM formato7 F LEFT JOIN
                                        equipoexterno EE ON F.id_equipoExterno = EE.id_equipoExterno LEFT JOIN equipo E ON F.id_equipo = E.id_equipo LEFT JOIN ambiente A ON EE.id_ambiente = A.id_ambiente LEFT JOIN
                                        tipoequipamiento T ON EE.id_tipoEquipamiento = T.id_tipoEquipamiento LEFT JOIN ambiente AA ON E.id_ambiente = AA.id_ambiente LEFT JOIN proveedor P ON F.id_proveedor = P.id_proveedor LEFT JOIN ordenservicio OS ON
                                        F.id_ordenServicio = OS.id_ordenServicio LEFT JOIN tipoequipamiento TE ON E.id_tipoEquipamiento = TE.id_tipoEquipamiento');

        foreach($formato7 as $value_formato7){
            $json_decode = json_decode($value_formato7->actividades_principales);
            $implode_actividades_principales = implode(',',$json_decode);
        }

        $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
                                                    FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
                                                    WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        $cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
                                                    AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        if(count($formato7) != 0){
            return view("paginas.reportesFormato7",array("status"=>200,"formato7"=>$formato7,"administradores"=>$administradores,
        "ambientes"=>$ambientes,"tipoEquipamientos"=>$tipoEquipamientos,"proveedores"=>$proveedores,"equipos"=>$equipos,"implode_actividades_principales"=>$implode_actividades_principales,"cronogramas"=>$cronogramas,
        "ordenServicios"=>$ordenServicios,"listadoFormato7"=>$listadoFormato7,"notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,"cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo));
        }else{
            return view("paginas.reportesFormato7",array("status"=>404,"formato7"=>$formato7,
            "administradores"=>$administradores,"ambientes"=>$ambientes,"tipoEquipamientos"=>$tipoEquipamientos,"equipos"=>$equipos,"implode_actividades_principales"=>$implode_actividades_principales,"cronogramas"=>$cronogramas,
            "proveedores"=>$proveedores,"ordenServicios"=>$ordenServicios,"listadoFormato7"=>$listadoFormato7,"notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,"cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo));
        }
    }

    public function store(Request $request){
        $datos = array("id_equipo"=>$request->input("id_equipo"),
                        "nombre_equipo"=>$request->input("nombre_equipo"),
                        "marca_equipo"=>$request->input("marca_equipo"),
                        "modelo_equipo"=>$request->input("modelo_equipo"),
                        "serie_equipo"=>$request->input("serie_equipo"),
                        "cp_equipo"=>$request->input("cp_equipo"),
                        "id_tipoEquipamiento"=>$request->input("id_tipoEquipamiento"),
                        "id_ambiente"=>$request->input("id_ambiente"),
                        "fecha_adquisicion_equipo"=>$request->input("fecha_adquisicion_equipo"),
                        "tiempo_vida_util_equipo"=>$request->input("tiempo_vida_util_equipo"),
                        "prioridad_equipo"=>$request->input("prioridad_equipo"),
                        "nombre_proveedor1"=>$request->input("nombre_proveedor1"),
                        "nombre_proveedor2"=>$request->input("nombre_proveedor2"),
                        "nombre_informe1"=>$request->input("nombre_informe1"),
                        "nombre_informe2"=>$request->input("nombre_informe2"),
                        "precio_equipoNuevo"=>$request->input("precio_equipoNuevo"),
                        "costo_mantenimiento"=>$request->input("costo_mantenimiento"),
                        "actividades_principales"=>$request->input("actividades_principales"),
                        "prioridad_multianual"=>$request->input("prioridad_multianual"),
                        "orden_prelacion"=>$request->input("orden_prelacion"));

        $actividades = json_encode(explode(",",$datos["actividades_principales"]));
        $equipo_validacion = DB::select('select * from formato7 where id_equipo = ?', [$request->input("id_equipo")]);
        /* $equipoExterno_validacion = DB::select('select * from formato7 where id_equipoExterno = ?', [$request->input("id_equipo")]); */

/*                 echo "<pre>"; print_r($equipo_validacion); echo "</pre>";
                return; */

            if(empty($equipo_validacion) == ""){
                return redirect("/reportesFormato7")->with("equipo-existe","");
            }else{

                /* Validar datos */
                if(!empty($datos)){
                    $validar = \Validator::make($datos,[
/*                      "nombre_equipo"=>'required|regex:/^[-\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                        "marca_equipo"=>'required|regex:/^[-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                        "modelo_equipo"=>'required|regex:/^[-\\/\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                        "serie_equipo"=>'required|regex:/^[-\\/\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                        "cp_equipo"=>'required|regex:/^[0-9]+$/i',
                        "id_tipoEquipamiento"=>'required',
                        "id_ambiente"=>'required',
                        "tiempo_vida_util_equipo"=>'required|regex:/^[0-9]+$/i',
                        "prioridad_equipo"=>'required|regex:/^[0-9]+$/i', */
                        "precio_equipoNuevo"=>'required|regex:/^[.\\0-9]+$/i',
                        "costo_mantenimiento"=>'required|regex:/^[.\\0-9]+$/i',
                        "prioridad_multianual"=>'required|regex:/^[0-9]+$/i',
                    ]);

                    /* Guardar Dirección Ejecutiva */
                    if($validar->fails()){
                        return redirect("/reportesFormato7")->with("no-validacion","");
                    }else{

                        if($datos["id_equipo"] == ''){

                        $equipoexterno = new EquiposExternoModel();
                        $equipoexterno->nombre_equipoExterno = $datos["nombre_equipo"];
                        $equipoexterno->marca_equipoExterno = $datos["marca_equipo"];
                        $equipoexterno->modelo_equipoExterno = $datos["modelo_equipo"];
                        $equipoexterno->serie_equipoExterno = $datos["serie_equipo"];
                        $equipoexterno->cp_equipoExterno = $datos["cp_equipo"];
                        $equipoexterno->id_tipoEquipamiento = $datos["id_tipoEquipamiento"];
                        $equipoexterno->id_ambiente = $datos["id_ambiente"];
                        $equipoexterno->fecha_adquisicion_equipoExterno = $datos["fecha_adquisicion_equipo"];
                        $equipoexterno->tiempo_vida_util_equipoExterno = $datos["tiempo_vida_util_equipo"];
                        $equipoexterno->prioridad_equipoExterno = $datos["prioridad_equipo"];

                        $equipoexterno->save();

                        }

                        $extraer_equipos = DB::select('SELECT * FROM equipoexterno E ORDER BY E.id_equipoExterno DESC LIMIT 1');

                        $listaformato7 = new ReportesFormato7Model();
                        $listaformato7->id_equipo = $datos["id_equipo"];

                        if($datos["id_equipo"] == ''){
                            $listaformato7->id_equipoExterno = $extraer_equipos[0]->id_equipoExterno;
                        }

                        $listaformato7->id_proveedor = $datos["nombre_proveedor1"];
                        $listaformato7->nombre_proveedor2 = $datos["nombre_proveedor2"];
                        $listaformato7->id_ordenServicio = $datos["nombre_informe1"];
                        $listaformato7->nombre_informe2 = $datos["nombre_informe2"];
                        $listaformato7->precio_equipoNuevo = $datos["precio_equipoNuevo"];
                        $listaformato7->costo_mantenimiento = $datos["costo_mantenimiento"];
                        $listaformato7->actividades_principales = $actividades;
                        $listaformato7->prioridad_multianual = $datos["prioridad_multianual"];
                        $listaformato7->orden_prelacion = $datos["orden_prelacion"];

                        $listaformato7->save();

                        return redirect('/reportesFormato7')->with("ok-crear","");

                    }
                }else{
                    return redirect('/reportesFormato7')->with("error","");
                }
            }
    }

    public function update($id,Request $request){
        $datos1 =  array("nombre_equipoExterno"=>$request->input("nombre_equipo"),
                        "marca_equipoExterno"=>$request->input("marca_equipo"),
                        "modelo_equipoExterno"=>$request->input("modelo_equipo"),
                        "serie_equipoExterno"=>$request->input("serie_equipo"),
                        "cp_equipoExterno"=>$request->input("cp_equipo"),
                        "id_tipoEquipamiento"=>$request->input("id_tipoEquipamiento"),
                        "id_ambiente"=>$request->input("id_ambiente"),
                        "fecha_adquisicion_equipoExterno"=>$request->input("fecha_adquisicion_equipo"),
                        "tiempo_vida_util_equipoExterno"=>$request->input("tiempo_vida_util_equipo"),
                        "prioridad_equipoExterno"=>$request->input("prioridad_equipo"));

        $id_equipoExterno = $request->input("id_equipoExterno");
        $id_equipo = $request->input("id_equipo");

        $datos2 =  array("id_proveedor"=>$request->input("nombre_proveedor1"),
                        "nombre_proveedor2"=>$request->input("nombre_proveedor2"),
                        "id_ordenServicio"=>$request->input("nombre_informe1"),
                        "nombre_informe2"=>$request->input("nombre_informe2"),
                        "precio_equipoNuevo"=>$request->input("precio_equipoNuevo"),
                        "costo_mantenimiento"=>$request->input("costo_mantenimiento"),
                        "actividades_principales"=>$request->input("actividades_principales"),
                        "prioridad_multianual"=>$request->input("prioridad_multianual"),
                        "orden_prelacion"=>$request->input("orden_prelacion"),
                        "criterio_2"=>$request->input("criterio_2"),
                        "criterio_3"=>$request->input("criterio_3"),
                        "criterio_4"=>$request->input("criterio_4"),
                        "criterio_5"=>$request->input("criterio_5"));

        $actividades = json_encode(explode(",",$datos2["actividades_principales"]));

/*         echo "<pre>"; print_r($datos1); echo "</pre>";
        return; */

        //validar los datos
        if(!empty($datos1)){
            $validar = \Validator::make($datos1,[
                "nombre_equipoExterno"=>'required|regex:/^[-\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                "marca_equipoExterno"=>'required|regex:/^[-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                "modelo_equipoExterno"=>'required|regex:/^[-\\/\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                "serie_equipoExterno"=>'required|regex:/^[-\\/\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                "cp_equipoExterno"=>'required|regex:/^[0-9]+$/i',
                "id_tipoEquipamiento"=>'required',
                "id_ambiente"=>'required',
                "fecha_adquisicion_equipoExterno"=>'required',
                "tiempo_vida_util_equipoExterno"=>'required|regex:/^[0-9]+$/i',
                "prioridad_equipoExterno"=>'required|regex:/^[0-9]+$/i'
            ]);

            if($validar->fails()){
                return redirect("/reportesFormato7")->with("no-validacion","");
            }else{

                $datos1 =  array("nombre_equipoExterno"=>$request->input("nombre_equipo"),
                                "marca_equipoExterno"=>$request->input("marca_equipo"),
                                "modelo_equipoExterno"=>$request->input("modelo_equipo"),
                                "serie_equipoExterno"=>$request->input("serie_equipo"),
                                "cp_equipoExterno"=>$request->input("cp_equipo"),
                                "id_tipoEquipamiento"=>$request->input("id_tipoEquipamiento"),
                                "id_ambiente"=>$request->input("id_ambiente"),
                                "fecha_adquisicion_equipoExterno"=>$request->input("fecha_adquisicion_equipo"),
                                "tiempo_vida_util_equipoExterno"=>$request->input("tiempo_vida_util_equipo"),
                                "prioridad_equipoExterno"=>$request->input("prioridad_equipo"));

                $id_equipoExterno = $request->input("id_equipoExterno");

                $datos2 =  array("id_proveedor"=>$request->input("nombre_proveedor1"),
                                "nombre_proveedor2"=>$request->input("nombre_proveedor2"),
                                "id_ordenServicio"=>$request->input("nombre_informe1"),
                                "nombre_informe2"=>$request->input("nombre_informe2"),
                                "precio_equipoNuevo"=>$request->input("precio_equipoNuevo"),
                                "costo_mantenimiento"=>$request->input("costo_mantenimiento"),
                                "actividades_principales"=>$actividades,
                                "prioridad_multianual"=>$request->input("prioridad_multianual"),
                                "orden_prelacion"=>$request->input("orden_prelacion"),
                                "criterio_2"=>$request->input("criterio_2"),
                                "criterio_3"=>$request->input("criterio_3"),
                                "criterio_4"=>$request->input("criterio_4"),
                                "criterio_5"=>$request->input("criterio_5"));

                $equipoExterno = EquiposExternoModel::where('id_equipoExterno',$id_equipoExterno)->update($datos1);
                $formato7 = ReportesFormato7Model::where('id_formato7',$id)->update($datos2);

                return redirect("/reportesFormato7")->with("ok-editar","");
            }

        }else{
            return redirect("/reportesFormato7")->with("error","");
        }
    }

    public function createPDF(Request $request){
        $listadoFormato7 =  DB::select('SELECT F.criterio_2,F.criterio_3,F.criterio_4,F.criterio_5,C.realizado,C.realizado,E.monto_adquisicion_equipo,C.acumulado_cronograma,D.nombre_departamento as departamentoEquipo,DD.nombre_departamento as departamentoEquipoExterno,ROUND(TIMESTAMPDIFF(MONTH,E.fecha_adquisicion_equipo,CURDATE())/12) AS antiguedad_equipo,ROUND(TIMESTAMPDIFF(MONTH,EE.fecha_adquisicion_equipoExterno,CURDATE())/12) AS antiguedad_equipoExterno,EE.fecha_adquisicion_equipoExterno,E.fecha_adquisicion_equipo,F.id_formato7,AA.nombre_ambiente as ambienteEquipo,A.nombre_ambiente as ambienteEquipoExterno,T.nombre_tipoEquipamiento as tipoEquipamientoEquipoExterno,TE.nombre_tipoEquipamiento as tipoEquipamientoEquipo,EE.id_equipoExterno,EE.nombre_equipoExterno,EE.marca_equipoExterno,
                                        EE.modelo_equipoExterno,EE.serie_equipoExterno,EE.cp_equipoExterno,EE.id_tipoEquipamiento,EE.id_ambiente,EE.tiempo_vida_util_equipoExterno,EE.prioridad_equipoExterno,E.id_equipo,E.nombre_equipo,E.marca_equipo,
                                        E.modelo_equipo,E.serie_equipo,E.cp_equipo,E.id_ambiente,E.tiempo_vida_util_equipo,E.prioridad_equipo,T.id_tipoEquipamiento,T.nombre_tipoEquipamiento,P.id_proveedor,P.razonSocial_proveedor,F.nombre_proveedor2,
                                        F.precio_equipoNuevo,F.costo_mantenimiento,F.actividades_principales,F.prioridad_multianual,F.orden_prelacion,F.nombre_informe2,OS.id_ordenServicio,OS.codigo_ordenServicio FROM formato7 F LEFT JOIN
                                        equipoexterno EE ON F.id_equipoExterno = EE.id_equipoExterno LEFT JOIN equipo E ON F.id_equipo = E.id_equipo LEFT JOIN ambiente A ON EE.id_ambiente = A.id_ambiente LEFT JOIN
                                        tipoequipamiento T ON EE.id_tipoEquipamiento = T.id_tipoEquipamiento LEFT JOIN ambiente AA ON E.id_ambiente = AA.id_ambiente LEFT JOIN proveedor P ON F.id_proveedor = P.id_proveedor LEFT JOIN ordenservicio OS ON
                                        F.id_ordenServicio = OS.id_ordenServicio LEFT JOIN tipoequipamiento TE ON E.id_tipoEquipamiento = TE.id_tipoEquipamiento LEFT JOIN departamento D ON AA.id_departamento = D.id_departamento LEFT JOIN departamento DD ON A.id_departamento = DD.id_departamento LEFT JOIN cronograma C ON E.id_equipo = C.id_equipo WHERE C.realizado=0 OR C.realizado=1 GROUP BY F.id_formato7');

/*                 echo "<pre>"; print_r($listadoFormato7); echo "</pre>";
        return; */

        // compartir datos para ver
        view()->share('listadoFormato7',$listadoFormato7);

        $pdf = PDF::loadView('paginas.reportesFormato7R',$listadoFormato7);

        // descargar archivo PDF con método de descarga
        return $pdf->setPaper('a2','landscape')->stream('listado_Formato7.pdf');
    }
}
