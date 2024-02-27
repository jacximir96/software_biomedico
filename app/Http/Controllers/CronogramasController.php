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
use App\DireccionesEjecutivasModel;
use Facade\Ignition\DumpRecorder\Dump;
use Illuminate\Support\Facades\Storage;
/* Fin de Modelos de nuestro proyecto */

use Illuminate\Support\Facades\DB;/* Agregar conbinaciones de tablas en la base de datos */
use Yajra\DataTables\Facades\DataTables;

class CronogramasController extends Controller
{
       public function getcronogramaFecha() {
        if (request()->ajax()) {
            $cronogramas_fecha = DB::select("select M.nombre_mantenimiento,C.fecha_final,C.realizado,C.id_cronograma,C.id_equipo,C.fecha,E.nombre_equipo,E.cp_equipo from cronograma C
            INNER JOIN equipo E ON C.id_equipo = E.id_equipo
            INNER JOIN mantenimiento M ON C.id_mantenimiento = M.id_mantenimiento
            WHERE C.realizado = 0 AND C.fecha_final IS NOT NULL");
            return DataTables::of($cronogramas_fecha)->make(true);
        }
       }

    
    /* Mostrar todos los registros */
        public function index(){

            $administradores = AdministradoresModel::all();
            $direccionesEjecutivas = DireccionesEjecutivasModel::all();
            $proveedores = ProveedoresModel::all();
            $equipos = EquiposModel::all();
            $cronogramas = CronogramasModel::all();
            $tipoMantenimientos = TipoMantenimientosModel::all();
            $ordenServicios = OrdenServiciosModel::all();
            $departamentos = DepartamentosModel::all();
            $tipoMantenimientos_estado = DB::select('select * from mantenimiento where estado_mantenimiento <> 2');
            $cronogramas_fecha = DB::select("select M.nombre_mantenimiento,C.fecha_final,C.realizado,C.id_cronograma,C.id_equipo,C.fecha,E.nombre_equipo,E.cp_equipo from cronograma C
                                            INNER JOIN equipo E ON C.id_equipo = E.id_equipo
                                            INNER JOIN mantenimiento M ON C.id_mantenimiento = M.id_mantenimiento
                                            WHERE C.realizado = 0 AND C.fecha_final IS NOT NULL");
                                            $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
                                            FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
                                            WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");
            $cronograma = CronogramasModel::all();
            $events = array();

            
            foreach ($cronograma as $cronogramas) {
                if($cronogramas->realizado == 1){
                    $cronogramas->realizado = "REALIZADO";
                }else{
                    $cronogramas->realizado = "NO REALIZADO";
                }
                if ($cronogramas->id_mantenimiento == 1) {
                    $events[] = [
                        'id' => $cronogramas->id_cronograma,
                        'title' => "(P-ODS) " . $cronogramas->equipo->nombre_equipo,
                        'description' => 'Equipo: '.$cronogramas->equipo->nombre_equipo.', '.'Serie: '.$cronogramas->equipo->serie_equipo.', '.'Cod. Patrimonial: '.$cronogramas->equipo->cp_equipo.','.'Solicitado por:'.$cronogramas->id_departamento.','.'Realizado: '.$cronogramas->realizado,
                        'start' => $cronogramas->fecha,
                        'end' => $cronogramas->fecha_final,
                        'backgroundColor' => 'green',
                        'borderColor' => 'black',
                        'textColor' => 'white'
                    ];
                }elseif ($cronogramas->id_mantenimiento == 2) {
                    $events[] = [
                        'id' => $cronogramas->id_cronograma,
                        'title' => "(C-ODS) " . $cronogramas->equipo->nombre_equipo,
                        'description' => 'Equipo: '.$cronogramas->equipo->nombre_equipo.', '.'Serie: '.$cronogramas->equipo->serie_equipo.', '.'Cod. Patrimonial: '.$cronogramas->equipo->cp_equipo.','.'Solicitado por:'.$cronogramas->id_departamento.','.'Realizado: '.$cronogramas->realizado,
                        'start' => $cronogramas->fecha,
                        'end' => $cronogramas->fecha_final,
                        'backgroundColor' => 'red',
                        'borderColor' => 'black',
                        'textColor' => 'white'
                    ];
                }elseif ($cronogramas->id_mantenimiento == 3) {
                    $events[] = [
                        'id' => $cronogramas->id_cronograma,
                        'title' => "(C-OTM) " . $cronogramas->equipo->nombre_equipo,
                        'description' => 'Equipo: '.$cronogramas->equipo->nombre_equipo.', '.'Serie: '.$cronogramas->equipo->serie_equipo.', '.'Cod. Patrimonial: '.$cronogramas->equipo->cp_equipo.','.'Solicitado por:'.$cronogramas->id_departamento.','.'Realizado: '.$cronogramas->realizado,
                        'start' => $cronogramas->fecha,
                        'end' => $cronogramas->fecha_final,
                        'backgroundColor' => 'red',
                        'borderColor' => 'black',
                        'textColor' => 'white'
                    ];
                }elseif ($cronogramas->id_mantenimiento == 4) {
                   $events[] = [
                    'id' => $cronogramas->id_cronograma,
                    'title' => "(P-OTM) " . $cronogramas->equipo->nombre_equipo,
                    'description' => 'Equipo: '.$cronogramas->equipo->nombre_equipo.', '.'Serie: '.$cronogramas->equipo->serie_equipo.', '.'Cod. Patrimonial: '.$cronogramas->equipo->cp_equipo.','.'Solicitado por:'.$cronogramas->id_departamento.','.'Realizado: '.$cronogramas->realizado,
                    'start' => $cronogramas->fecha,
                    'end' => $cronogramas->fecha_final,
                    'backgroundColor' => 'green',
                    'borderColor' => 'black',
                    'textColor' => 'white'
                   ];
                }
            }
$cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
                                            AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

            return view("paginas.cronogramas",array("cronogramas"=>$cronogramas,"administradores"=>$administradores,'direccionesEjecutivas' =>$direccionesEjecutivas,
                                                    "proveedores"=>$proveedores,"equipos"=>$equipos,"tipoMantenimientos"=>$tipoMantenimientos,
                                                    "tipoMantenimientos_estado"=>$tipoMantenimientos_estado,"cronogramas_fecha"=>$cronogramas_fecha,
                                                    "ordenServicios"=>$ordenServicios,"departamentos"=>$departamentos,
                                                    "notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,
                                                    "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo,
                                                    "events" => $events));
        }

        public function listar(){

            $cronogramas = CronogramasModel::all();

            $nuevo_cronograma = [];

            foreach($cronogramas as $value => $data){
                if($data["realizado"] == 1){
                    $data["realizado"] = "REALIZADO";
                }else{
                    $data["realizado"] = "NO REALIZADO";
                }

                if($data["id_mantenimiento"] == 1){

                    $nuevo_cronograma[] = [
                        'id' => $data["id_cronograma"],
                        'title' => '(P-ODS) '.$data->equipo["nombre_equipo"],
                        'start' => $data["fecha"],
                        'end' => $data["fecha_final"].'T24:00:00',
                        'description' => 'Equipo: '.$data->equipo["nombre_equipo"].', '.'Serie: '.$data->equipo["serie_equipo"].', '.'Cod. Patrimonial: '.$data->equipo["cp_equipo"].', '.'Empresa: '.$data->proveedor["razonSocial_proveedor"].', '.'Solicitado Por: '.$data->departamento["iniciales_departamento"].', '.'Garantía: '.$data["garantia"].' Meses'.', '.'Realizado: '.$data["realizado"],
                        'backgroundColor' => 'green',
                        'borderColor' => 'black',
                        'textColor' => 'white'
                    ];
                }elseif($data["id_mantenimiento"] == 2){
                    $nuevo_cronograma[] = [
                        'id' => $data["id_cronograma"],
                        'title' => '(C-ODS) '.$data->equipo["nombre_equipo"],
                        'start' => $data["fecha"],
                        'end' => $data["fecha_final"].'T24:00:00',
                        'description' => 'Equipo: '.$data->equipo["nombre_equipo"].', '.'Serie: '.$data->equipo["serie_equipo"].', '.'Cod. Patrimonial: '.$data->equipo["cp_equipo"].', '.'Empresa: '.$data->proveedor["razonSocial_proveedor"].', '.'Solicitado Por: '.$data->departamento["iniciales_departamento"].', '.'Garantía: '.$data["garantia"].' Meses'.', '.'Realizado: '.$data["realizado"],
                        'backgroundColor' => 'red',
                        'borderColor' => 'black',
                        'textColor' => 'white'
                    ];
                }elseif($data["id_mantenimiento"] == 3){
                    $nuevo_cronograma[] = [
                        'id' => $data["id_cronograma"],
                        'title' => '(C-OTM) '.$data->equipo["nombre_equipo"],
                        'start' => $data["fecha"],
                        'end' => $data["fecha_final"].'T24:00:00',
                        'description' => 'Equipo: '.$data->equipo["nombre_equipo"].', '.'Serie: '.$data->equipo["serie_equipo"].', '.'Cod. Patrimonial: '.$data->equipo["cp_equipo"].', '.'Solicitado Por: '.$data->departamento["iniciales_departamento"].', '.'Realizado: '.$data["realizado"],
                        'backgroundColor' => 'red',
                        'borderColor' => 'black',
                        'textColor' => 'white'
                    ];
                }elseif($data["id_mantenimiento"] == 4){
                    $nuevo_cronograma[] = [
                        'id' => $data["id_cronograma"],
                        'title' => '(P-OTM) '.$data->equipo["nombre_equipo"],
                        'start' => $data["fecha"],
                        'end' => $data["fecha_final"].'T24:00:00',
                        'description' => 'Equipo: '.$data->equipo["nombre_equipo"].', '.'Serie: '.$data->equipo["serie_equipo"].', '.'Cod. Patrimonial: '.$data->equipo["cp_equipo"].', '.'Solicitado Por: '.$data->departamento["iniciales_departamento"].', '.'Realizado: '.$data["realizado"],
                        'backgroundColor' => 'green',
                        'borderColor' => 'black',
                        'textColor' => 'white'
                    ];
                }
            }

            return response()->json($nuevo_cronograma);
        }

        public function validarFecha($fecha){

                    $cronograma_validar = DB::select('select * from cronograma where fecha = :fecha',['fecha' => $fecha]);

                    return $cronograma_validar == null ? true : false;
        }

        public function guardar(Request $request){
            $input = $request->all();

            if($input["id_mantenimiento"] == ''){
                echo '<select id="nombres_mantenimiento" required></select>';
            }else{
                $cronograma_validar = CronogramasModel::create([
                    "id_equipo"=>$input["id_equipo"],
                    "fecha"=>$input["fecha_actual"],
                    "fecha_final"=>$input["fecha_final"],
                    "id_mantenimiento"=>$input["id_mantenimiento"],
                    "garantia"=>$input["garantia"],
                    "realizado"=>$input["realizado_crear"]
                ]);

                return response()->json(["ok"=>true]);
            }

        }

        public function show($id){
            $cronograma = DB::select('select * from cronograma C INNER JOIN equipo E ON C.id_equipo = E.id_equipo WHERE id_cronograma = ?',[$id]);
            $equipos = EquiposModel::all();
            $administradores = AdministradoresModel::all();
            $tipoMantenimientos = TipoMantenimientosModel::all();
            $cronogramas1 = CronogramasModel::all();
            $events = array();

            
            foreach ($cronogramas1 as $cronogramas) {
                if($cronogramas->realizado == 1){
                    $cronogramas->realizado = "REALIZADO";
                }else{
                    $cronogramas->realizado = "NO REALIZADO";
                }
                switch ($cronogramas->id_mantenimiento) {
                    case "1":
                        $events[] = [
                            'id' => $cronogramas->id_cronograma,
                            'title' => "(P-ODS) " . $cronogramas->equipo->nombre_equipo,
                            'description' => 'Equipo: '.$cronogramas->equipo->nombre_equipo.', '.'Serie: '.$cronogramas->equipo->serie_equipo.', '.'Cod. Patrimonial: '.$cronogramas->equipo->cp_equipo.','.'Solicitado por:'.$cronogramas->id_departamento.','.'Realizado: '.$cronogramas->realizado,
                            'start' => $cronogramas->fecha,
                            'end' => $cronogramas->fecha_final,
                            'backgroundColor' => 'green',
                            'borderColor' => 'black',
                            'textColor' => 'white'
                        ];
                        break;
                    case" 2":
                        $events[] = [
                            'id' => $cronogramas->id_cronograma,
                            'title' => "(C-ODS) " . $cronogramas->equipo->nombre_equipo,
                            'description' => 'Equipo: '.$cronogramas->equipo->nombre_equipo.', '.'Serie: '.$cronogramas->equipo->serie_equipo.', '.'Cod. Patrimonial: '.$cronogramas->equipo->cp_equipo.','.'Solicitado por:'.$cronogramas->id_departamento.','.'Realizado: '.$cronogramas->realizado,
                            'start' => $cronogramas->fecha,
                            'end' => $cronogramas->fecha_final,
                            'backgroundColor' => 'red',
                            'borderColor' => 'black',
                            'textColor' => 'white'
                        ];
                        break;
                    case "3":
                        $events[] = [
                            'id' => $cronogramas->id_cronograma,
                            'title' => "(C-OTM) " . $cronogramas->equipo->nombre_equipo,
                            'description' => 'Equipo: '.$cronogramas->equipo->nombre_equipo.', '.'Serie: '.$cronogramas->equipo->serie_equipo.', '.'Cod. Patrimonial: '.$cronogramas->equipo->cp_equipo.','.'Solicitado por:'.$cronogramas->id_departamento.','.'Realizado: '.$cronogramas->realizado,
                            'start' => $cronogramas->fecha,
                            'end' => $cronogramas->fecha_final,
                            'backgroundColor' => 'red',
                            'borderColor' => 'black',
                            'textColor' => 'white'
                        ];
                        break;
                    case "4":
                        $events[] = [
                                'id' => $cronogramas->id_cronograma,
                                'title' => "(P-OTM) " . $cronogramas->equipo->nombre_equipo,
                                'description' => 'Equipo: '.$cronogramas->equipo->nombre_equipo.', '.'Serie: '.$cronogramas->equipo->serie_equipo.', '.'Cod. Patrimonial: '.$cronogramas->equipo->cp_equipo.','.'Solicitado por:'.$cronogramas->id_departamento.','.'Realizado: '.$cronogramas->realizado,
                                'start' => $cronogramas->fecha,
                                'end' => $cronogramas->fecha_final,
                                'backgroundColor' => 'green',
                                'borderColor' => 'black',
                                'textColor' => 'white'
                               ];
                        break;
                }
            }
            $cronogramas_fecha = DB::select("select M.nombre_mantenimiento,C.fecha_final,C.realizado,C.id_cronograma,C.id_equipo,C.fecha,E.nombre_equipo,E.cp_equipo from cronograma C
                                            INNER JOIN equipo E ON C.id_equipo = E.id_equipo
                                            INNER JOIN mantenimiento M ON C.id_mantenimiento = M.id_mantenimiento
                                            WHERE C.realizado = 0");
            $tipoMantenimientos_estado = DB::select('select * from mantenimiento where estado_mantenimiento <> 2');
            $proveedores = ProveedoresModel::all();
            $ordenServicios = OrdenServiciosModel::all();
            $departamentos = DB::select('select D.id_departamento,D.nombre_departamento from departamento D where id_departamento <> 19');
            $direccionesEjecutivas = DB::select('SELECT * FROM direccionejecutiva');
            $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
            FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
            WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

            $cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
            AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

            if(count($cronograma) != 0){
                return view("paginas.cronogramas",array("status"=>200,"cronograma"=>$cronograma,"administradores"=>$administradores,
                "equipos"=>$equipos,"tipoMantenimientos"=>$tipoMantenimientos,"cronogramas"=>$cronogramas,"cronogramas_fecha"=>$cronogramas_fecha,
                "tipoMantenimientos_estado"=>$tipoMantenimientos_estado,"proveedores"=>$proveedores,"ordenServicios"=>$ordenServicios,
                "departamentos"=>$departamentos,"notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,"direccionesEjecutivas"=>$direccionesEjecutivas,
                "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo, "events" => $events));
            }else{
                return view("paginas.cronogramas",array("status"=>404,"cronograma"=>$cronograma,"administradores"=>$administradores,
                "equipos"=>$equipos,"tipoMantenimientos"=>$tipoMantenimientos,"cronogramas"=>$cronogramas,"cronogramas_fecha"=>$cronogramas_fecha,
                "tipoMantenimientos_estado"=>$tipoMantenimientos_estado,"proveedores"=>$proveedores,"ordenServicios"=>$ordenServicios,
                "departamentos"=>$departamentos,"notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,"direccionesEjecutivas"=>$direccionesEjecutivas,
                "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo, "events" => $events));
            }
        }
        public function destroy(Request $request, $id){

            // $cronograma = CronogramasModel::all();

            
            $cronograma_unidad = CronogramasModel::where("id_cronograma", $id)
            ->first();
            
            if (!$cronograma_unidad) {
                
                    return response()->json(['mensaje' => 'Evento no encontrado'], 404);
                
            }
            $cronograma_unidad->delete();
            
                return response()->json(['mensaje' => 'Evento eliminado exitosamente']);
            
            //$find = CronogramasModel::find($id);
            
            // if (!$cronograma_unidad) {
            //     return response()->json([
            //         'error' => 'Error'
            //     ]);
            //     $cronograma_unidad->each->delete();
            // }
        }
        public function update($id, Request $request){

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

            if ($request->file('pdf_archivo_final')) {
                $pdf = array("pdf_cronograma"=>$request->file('pdf_archivo_final')->store('public/pdf/cronograma'));
            }else{
                $pdf = null;
            }
           

            //validar los datos
            if(!empty($datos)){
                $validar = \Validator::make($datos,[
                    "id_equipo"=>'required|regex:/^[_\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                    "fecha"=>'required',
                    "fecha_final"=>'required',
                    "garantia"=>'required'
                ]);

                if($validar->fails()){
                    return redirect("/cronogramas")->with("no-validacion","");
                }else{
                    if ($request->hasFile('pdf_archivo_final')) {
                        $pdf = array("pdf_cronograma"=>$request->file("pdf_archivo_final")->store('public/pdf/cronograma'));
                        $ruta = $pdf["pdf_cronograma"];
                    }else{
                        $ruta = null;
                    }
                   
                   

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
                    // dd($cronograma);
                    return redirect("/cronogramas")->with("ok-editar","");
                }

            }else{
                return redirect("/cronogramas")->with("error","");
            }
        }

    public function showJson($id) {
        $cronogramas = CronogramasModel::with('equipo','mantenimiento')->find($id);
        return $cronogramas;
    }
}
