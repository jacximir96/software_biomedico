<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/* Modelos de nuestro proyecto */
use App\AdministradoresModel;
use App\ProveedoresModel;
use App\EquiposModel;
use App\CronogramasModel;
use App\TipoMantenimientosModel;
use App\OrdenServiciosModel;
use App\DepartamentosModel;
/* Fin de Modelos de nuestro proyecto */

use Illuminate\Support\Facades\DB;/* Agregar conbinaciones de tablas en la base de datos */
use Yajra\DataTables\DataTables;

class CronogramasListaController extends Controller
{
   
    public function getindex(Request $request) {
        if($request->ajax()){
            $data  = CronogramasModel::all();
            return DataTables::of($data)->make(true);

        }
        return view('paginas.cronogramasLista');
    }

    public function index(){

     

        $administradores = AdministradoresModel::all();
        $proveedores = ProveedoresModel::all();
        $equipos = EquiposModel::all();
        $cronogramas = CronogramasModel::all();
        $tipoMantenimientos = TipoMantenimientosModel::all();
        $ordenServicios = OrdenServiciosModel::all();
        $departamentos = DepartamentosModel::all();
        $tipoMantenimientos_estado = DB::select('SELECT * FROM mantenimiento WHERE estado_mantenimiento <> 2');
        $cronogramas_fecha = DB::select("SELECT M.nombre_mantenimiento,C.fecha_final,C.realizado,C.id_cronograma,C.id_equipo,C.fecha,E.nombre_equipo,E.cp_equipo FROM cronograma C
                                        INNER JOIN equipo E ON C.id_equipo = E.id_equipo
                                        INNER JOIN mantenimiento M ON C.id_mantenimiento = M.id_mantenimiento
                                        WHERE C.realizado = 0 AND C.fecha_final IS NOT NULL");
        $cronogramas_general =  DB::select("SELECT C.observacion,C.pdf_cronograma,C.otm_cronograma,OS.codigo_ordenServicio,D.iniciales_departamento,DE.iniciales_direccionEjecutiva,
                                            CASE WHEN P.ruc_proveedor IS NULL AND C.realizado = 1 THEN 'ESGTMEB' ELSE P.ruc_proveedor END AS ruc_proveedor,C.monto_cronograma,M.nombre_mantenimiento,C.garantia,C.fecha_final,C.realizado,C.id_cronograma,C.id_equipo,C.fecha,E.nombre_equipo,E.cp_equipo from cronograma C
                                            INNER JOIN equipo E ON C.id_equipo = E.id_equipo INNER JOIN mantenimiento M ON C.id_mantenimiento = M.id_mantenimiento LEFT JOIN proveedor P ON C.id_proveedor = P.id_proveedor LEFT JOIN departamento D ON C.id_departamento = D.id_departamento LEFT JOIN direccionejecutiva DE ON C.id_direccionEjecutiva = DE.id_direccionEjecutiva LEFT JOIN ordenservicio OS ON C.id_ordenServicio = OS.id_ordenServicio
                                            WHERE C.fecha_final IS NOT NULL ORDER BY C.id_cronograma DESC");
        $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
        FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
        WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

$cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
        AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        return view("paginas.cronogramasLista",array("cronogramas"=>$cronogramas,"administradores"=>$administradores,
                                                "proveedores"=>$proveedores,"equipos"=>$equipos,"tipoMantenimientos"=>$tipoMantenimientos,
                                                "tipoMantenimientos_estado"=>$tipoMantenimientos_estado,"cronogramas_fecha"=>$cronogramas_fecha,
                                                "ordenServicios"=>$ordenServicios,"departamentos"=>$departamentos,
                                                "notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,"cronogramas_general"=>$cronogramas_general,
                                                "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo));
    }

    public function store(Request $request){
        $datos =  array("id_equipo"=>$request->input("id_equipo"),
                        "fecha"=>$request->input("fecha_actual"),
                        "fecha_final"=>$request->input("fecha_final"),
                        "id_mantenimiento"=>$request->input("id_mantenimiento"),
                        "garantia"=>$request->input("garantia"),
                        "realizado"=>$request->input("realizado_crear"));

/*         echo "<pre>"; print_r($datos); echo "</pre>";
        return; */

        if(!empty($datos)){
            $validar = \Validator::make($datos,[
                "id_equipo"=>'required',
                "fecha"=>'required',
                "fecha_final"=>'required',
                "id_mantenimiento"=>'required',
                "garantia"=>'required',
                "realizado"=>'required'
            ]);

            if($validar->fails()){
                return redirect("/cronogramasLista")->with("no-validacion","");
            }else{
                $cronograma = new CronogramasModel;
                $cronograma->id_equipo = $datos["id_equipo"];
                $cronograma->fecha = $datos["fecha"];
                $cronograma->fecha_final = $datos["fecha_final"];
                $cronograma->id_mantenimiento = $datos["id_mantenimiento"];
                $cronograma->garantia = $datos["garantia"];
                $cronograma->realizado = $datos["realizado"];

                $cronograma->save();

                return redirect("/cronogramasLista")->with("ok-crear","");
            }
        }else{
            return redirect("/cronogramasLista")->with("error","");
        }
    }

    public function destroy($id, Request $request){
        $validar = CronogramasModel::where("id_cronograma",$id)->get();

        if(!empty($validar)){
            $cronograma = CronogramasModel::where("id_cronograma",$validar[0]["id_cronograma"])->delete();
            //Responder al AJAX de JS
            return "ok";
        }else{
            return redirect("/cronogramasLista")->with("no-borrar", "");
        }
    }

    public function show($id){

        $cronograma = DB::select('SELECT * from cronograma C INNER JOIN equipo E ON C.id_equipo = E.id_equipo WHERE id_cronograma = ?',[$id]);
        $equipos = EquiposModel::all();
        $administradores = AdministradoresModel::all();
        $tipoMantenimientos = TipoMantenimientosModel::all();
        $cronogramas = CronogramasModel::all();
        $cronogramas_fecha = DB::select("select M.nombre_mantenimiento,C.fecha_final,C.realizado,C.id_cronograma,C.id_equipo,C.fecha,E.nombre_equipo,E.cp_equipo from cronograma C
                                        INNER JOIN equipo E ON C.id_equipo = E.id_equipo
                                        INNER JOIN mantenimiento M ON C.id_mantenimiento = M.id_mantenimiento
                                        WHERE C.realizado = 0 AND C.fecha_final <> ''");
        $tipoMantenimientos_estado = DB::select('select * from mantenimiento where estado_mantenimiento <> 2');
        $cronograma_ordenServicio=DB::select('SELECT * FROM cronograma C INNER JOIN ordenservicio OS ON
                                             C.id_ordenServicio  = OS.id_ordenServicio WHERE C.id_cronograma = ?',[$id]);

        $cronograma_proveedor=DB::select('SELECT * FROM cronograma C INNER JOIN proveedor P ON
                                              C.id_proveedor  = P.id_proveedor WHERE C.id_cronograma = ?',[$id]);
        $proveedores = ProveedoresModel::all();
        $ordenServicios = OrdenServiciosModel::all();
        $departamentos = DB::select('select D.id_departamento,D.nombre_departamento from departamento D where id_departamento <> 19');
        $direccionesEjecutivas = DB::select('SELECT * FROM direccionejecutiva');
        $cronogramas_general =  DB::select("select C.observacion,C.pdf_cronograma,C.otm_cronograma,OS.codigo_ordenServicio,D.iniciales_departamento,DE.iniciales_direccionEjecutiva,P.ruc_proveedor,C.monto_cronograma,M.nombre_mantenimiento,C.garantia,C.fecha_final,C.realizado,C.id_cronograma,C.id_equipo,C.fecha,E.nombre_equipo,E.cp_equipo from cronograma C
        INNER JOIN equipo E ON C.id_equipo = E.id_equipo INNER JOIN mantenimiento M ON C.id_mantenimiento = M.id_mantenimiento LEFT JOIN proveedor P ON C.id_proveedor = P.id_proveedor LEFT JOIN departamento D ON C.id_departamento = D.id_departamento LEFT JOIN direccionejecutiva DE ON C.id_direccionEjecutiva = DE.id_direccionEjecutiva LEFT JOIN ordenservicio OS ON C.id_ordenServicio = OS.id_ordenServicio
        WHERE C.fecha_final IS NOT NULL ORDER BY C.id_cronograma DESC");
        $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
                                                    FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
                                                    WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        $cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
                                                    AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        if(count($cronograma) != 0){
            return view("paginas.cronogramasLista",array("status"=>200,"cronograma"=>$cronograma,"administradores"=>$administradores,
            "equipos"=>$equipos,"tipoMantenimientos"=>$tipoMantenimientos,"cronogramas"=>$cronogramas,"cronogramas_fecha"=>$cronogramas_fecha,
            "tipoMantenimientos_estado"=>$tipoMantenimientos_estado,"proveedores"=>$proveedores,"ordenServicios"=>$ordenServicios,
            "departamentos"=>$departamentos,"notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,"direccionesEjecutivas"=>$direccionesEjecutivas,
            "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo,"cronogramas_general"=>$cronogramas_general,"cronograma_ordenServicio"=>$cronograma_ordenServicio,
            "cronograma_proveedor"=>$cronograma_proveedor));
        }else{
            return view("paginas.cronogramasLista",array("status"=>404,"cronograma"=>$cronograma,"administradores"=>$administradores,
            "equipos"=>$equipos,"tipoMantenimientos"=>$tipoMantenimientos,"cronogramas"=>$cronogramas,"cronogramas_fecha"=>$cronogramas_fecha,
            "tipoMantenimientos_estado"=>$tipoMantenimientos_estado,"proveedores"=>$proveedores,"ordenServicios"=>$ordenServicios,
            "departamentos"=>$departamentos,"notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,"direccionesEjecutivas"=>$direccionesEjecutivas,
            "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo,"cronogramas_general"=>$cronogramas_general,"cronograma_ordenServicio"=>$cronograma_ordenServicio,
            "cronograma_proveedor"=>$cronograma_proveedor));
        }
    }

    public function show1(Request $request){

        return $request->all(); /* response(json_encode($datosReferencia)) */;  
        /* return "probando"; */

        /* $cronograma = DB::select('SELECT * FROM cronograma C INNER JOIN equipo E ON C.id_equipo = E.id_equipo WHERE id_cronograma = ?',[$id]); */
/*         $equipos = EquiposModel::all();
        $administradores = AdministradoresModel::all();
        $tipoMantenimientos = TipoMantenimientosModel::all();
        $cronogramas = CronogramasModel::all();
        $cronogramas_fecha = DB::select("select M.nombre_mantenimiento,C.fecha_final,C.realizado,C.id_cronograma,C.id_equipo,C.fecha,E.nombre_equipo,E.cp_equipo from cronograma C
                                        INNER JOIN equipo E ON C.id_equipo = E.id_equipo
                                        INNER JOIN mantenimiento M ON C.id_mantenimiento = M.id_mantenimiento
                                        WHERE C.realizado = 0 AND C.fecha_final <> ''");
        $tipoMantenimientos_estado = DB::select('select * from mantenimiento where estado_mantenimiento <> 2');
        $cronograma_ordenServicio=DB::select('SELECT * FROM cronograma C INNER JOIN ordenservicio OS ON
                                             C.id_ordenServicio  = OS.id_ordenServicio WHERE C.id_cronograma = ?',[$id]);

        $cronograma_proveedor=DB::select('SELECT * FROM cronograma C INNER JOIN proveedor P ON
                                              C.id_proveedor  = P.id_proveedor WHERE C.id_cronograma = ?',[$id]);
        $proveedores = ProveedoresModel::all();
        $ordenServicios = OrdenServiciosModel::all();
        $departamentos = DB::select('select D.id_departamento,D.nombre_departamento from departamento D where id_departamento <> 19');
        $direccionesEjecutivas = DB::select('SELECT * FROM direccionejecutiva');
        $cronogramas_general =  DB::select("select C.observacion,C.pdf_cronograma,C.otm_cronograma,OS.codigo_ordenServicio,D.iniciales_departamento,DE.iniciales_direccionEjecutiva,P.ruc_proveedor,C.monto_cronograma,M.nombre_mantenimiento,C.garantia,C.fecha_final,C.realizado,C.id_cronograma,C.id_equipo,C.fecha,E.nombre_equipo,E.cp_equipo from cronograma C
        INNER JOIN equipo E ON C.id_equipo = E.id_equipo INNER JOIN mantenimiento M ON C.id_mantenimiento = M.id_mantenimiento LEFT JOIN proveedor P ON C.id_proveedor = P.id_proveedor LEFT JOIN departamento D ON C.id_departamento = D.id_departamento LEFT JOIN direccionejecutiva DE ON C.id_direccionEjecutiva = DE.id_direccionEjecutiva LEFT JOIN ordenservicio OS ON C.id_ordenServicio = OS.id_ordenServicio
        WHERE C.fecha_final IS NOT NULL ORDER BY C.id_cronograma DESC");
        $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
                                                    FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
                                                    WHERE C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND C.realizado IS NULL");

        $cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
                                                            AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND C.realizado IS NULL");

        if(count($cronograma) != 0){
            return view("paginas.cronogramasLista",array("cronograma"=>$cronograma,"administradores"=>$administradores,
            "equipos"=>$equipos,"tipoMantenimientos"=>$tipoMantenimientos,"cronogramas"=>$cronogramas,"cronogramas_fecha"=>$cronogramas_fecha,
            "tipoMantenimientos_estado"=>$tipoMantenimientos_estado,"proveedores"=>$proveedores,"ordenServicios"=>$ordenServicios,
            "departamentos"=>$departamentos,"notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,"direccionesEjecutivas"=>$direccionesEjecutivas,
            "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo,"cronogramas_general"=>$cronogramas_general,"cronograma_ordenServicio"=>$cronograma_ordenServicio,
            "cronograma_proveedor"=>$cronograma_proveedor));
        }else{
            return view("paginas.cronogramasLista",array("cronograma"=>$cronograma,"administradores"=>$administradores,
            "equipos"=>$equipos,"tipoMantenimientos"=>$tipoMantenimientos,"cronogramas"=>$cronogramas,"cronogramas_fecha"=>$cronogramas_fecha,
            "tipoMantenimientos_estado"=>$tipoMantenimientos_estado,"proveedores"=>$proveedores,"ordenServicios"=>$ordenServicios,
            "departamentos"=>$departamentos,"notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,"direccionesEjecutivas"=>$direccionesEjecutivas,
            "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo,"cronogramas_general"=>$cronogramas_general,"cronograma_ordenServicio"=>$cronograma_ordenServicio,
            "cronograma_proveedor"=>$cronograma_proveedor));
        } */

        if($request->ajax()){
             /* $idPaciente_pacientesCitados = $request->id; */
            /*$datosReferencia = DB::SELECT("SELECT TOP 1 RRH.estb2_cod,TE.descripcion,RRH.ref_rec_hoja_nro FROM INRDIS_II.dbo.Referencias_Rec_Hojas RRH 
                                           INNER JOIN INRDIS_II.dbo.tbEstablecimiento TE ON RRH.estb2_cod = TE.codigoRenaes COLLATE Modern_Spanish_CI_AS 
                                           WHERE RRH.Persona_id = ? ORDER BY ref_rec_hoja_fech DESC",[$idPaciente_pacientesCitados]); */

            return $request->all() /* response(json_encode($datosReferencia)) */;  
        }
    }

    public function update($id,Request $request){

        $extraer_cronograma_penultimo = DB::select('SELECT * FROM cronograma C WHERE C.id_equipo = ? AND C.realizado = 1 AND (C.id_mantenimiento IN (1,2) OR C.id_mantenimiento IS NULL) ORDER BY C.id_cronograma DESC LIMIT 1',[$request->input("cronograma_equipo")]);
        $extraer_cronograma = $extraer_cronograma_penultimo[0]->acumulado_cronograma;

        $datos = array("id_equipo"=>$request->input("cronograma_equipo"),
                        "fecha"=>$request->input("cronograma_fecha"),
                        "fecha_final"=>$request->input("cronograma_fecha_final"),
                        "realizado"=>$request->input("cronograma_realizado"),
                        "observacion"=>$request->input("cronograma_observacion"),
                        "monto_cronograma"=>$request->input("monto_cronograma"),
                        "acumulado_cronograma"=>$request->input("monto_cronograma")+$extraer_cronograma,
                        "id_ordenServicio"=>$request->input("id_ordenServicio"),
                        "id_proveedor"=>$request->input("id_proveedor"),
                        "id_departamento"=>$request->input("id_departamento"),
                        "id_direccionEjecutiva"=>$request->input("id_direccionEjecutiva"),
                        "garantia"=>$request->input("cronograma_garantia"),
                        "otm_cronograma"=>$request->input("otm_cronograma"));

        $observacion = json_encode(explode(",",$datos["observacion"]));

        $pdf = array("pdf_cronograma"=>$request->file("pdf_archivo_final")->store('public/pdf/cronograma'));

        //validar los datos
        if(!empty($datos)){
            $validar = \Validator::make($datos,[
                "id_equipo"=>'required|regex:/^[_\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                "fecha"=>'required',
                "fecha_final"=>'required',
                "garantia"=>'required'
            ]);

            if($validar->fails()){
                return redirect("/cronogramasLista")->with("no-validacion","");
            }else{

                $ruta = $pdf["pdf_cronograma"];

                $datos = array("id_equipo"=>$request->input("cronograma_equipo"),
                                "fecha"=>$request->input("cronograma_fecha"),
                                "fecha_final"=>$request->input("cronograma_fecha_final"),
                                "realizado"=>$request->input("cronograma_realizado"),
                                "observacion"=>$observacion,
                                "monto_cronograma"=>$request->input("monto_cronograma"),
                                "acumulado_cronograma"=>$request->input("monto_cronograma")+$extraer_cronograma,
                                "id_ordenServicio"=>$request->input("id_ordenServicio"),
                                "pdf_cronograma"=>$ruta,
                                "id_proveedor"=>$request->input("id_proveedor"),
                                "id_departamento"=>$request->input("id_departamento"),
                                "id_direccionEjecutiva"=>$request->input("id_direccionEjecutiva"),
                                "garantia"=>$request->input("cronograma_garantia"),
                                "otm_cronograma"=>$request->input("otm_cronograma"));

                $cronograma = CronogramasModel::where('id_cronograma',$id)->update($datos);
                return redirect("/cronogramasLista")->with("ok-editar","");
            }

        }else{
            return redirect("/cronogramasLista")->with("error","");
        }
    }


}
