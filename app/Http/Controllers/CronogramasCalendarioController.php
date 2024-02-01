<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/* Modelos de nuestro proyecto */
use App\AdministradoresModel;
use App\ProveedoresModel;
use App\EquiposGarantiaModel;
use App\CronogramasCalendarioModel;
use App\TipoMantenimientosModel;
use App\OrdenServiciosModel;
use App\DepartamentosModel;
use App\CronogramasGeneralNuevoModel;
use Carbon\Carbon;
/* Fin de Modelos de nuestro proyecto */

use Illuminate\Support\Facades\DB;/* Agregar conbinaciones de tablas en la base de datos */

class CronogramasCalendarioController extends Controller
{
            /* Mostrar todos los registros */
            public function index(){


                $administradores = AdministradoresModel::all();
                $proveedores = ProveedoresModel::all();
                $equipos = EquiposGarantiaModel::all();
                $cronogramasCalendario = CronogramasCalendarioModel::all();
                $tipoMantenimientos = TipoMantenimientosModel::all();
                $ordenServicios = OrdenServiciosModel::all();
                $departamentos = DepartamentosModel::all();
                $tipoMantenimientos_estado = DB::select('select * from mantenimiento where estado_mantenimiento <> 2');
                $cronogramasCalendario_fecha = DB::select("select E.cp_equipoGarantia,C.fecha_final,C.realizado,C.id_cronogramaCalendario,C.id_equipoGarantia,C.fecha,E.nombre_equipoGarantia from cronogramacalendario C
                                                            INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
                                                            WHERE C.realizado = 0 AND C.fecha_final <> ''");
                                                            $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
                                                            FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
                                                            WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");
        
                $cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
                                                            AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

                return view("paginas.cronogramasCalendario",array("cronogramasCalendario"=>$cronogramasCalendario,"administradores"=>$administradores,
                                                        "proveedores"=>$proveedores,"equipos"=>$equipos,"tipoMantenimientos"=>$tipoMantenimientos,
                                                        "tipoMantenimientos_estado"=>$tipoMantenimientos_estado,"cronogramasCalendario_fecha"=>$cronogramasCalendario_fecha,
                                                        "ordenServicios"=>$ordenServicios,"departamentos"=>$departamentos,"notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,
                                                        "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo));
            }

            public function listar(){

                $cronogramas = CronogramasCalendarioModel::all();

                $nuevo_cronograma = [];

                foreach($cronogramas as $value => $data){
                    if($data["realizado"] == 1){
                        $data["realizado"] = "REALIZADO";
                    }else{
                        $data["realizado"] = "NO REALIZADO";
                    }
                        $nuevo_cronograma[] = [
                            'id' => $data["id_cronogramaCalendario"],
                            'title' => $data->equipo["nombre_equipoGarantia"],
                            'start' => $data["fecha"],
                            'end' => $data["fecha_final"].'T24:00:00',
                            'description' => 'Equipo: '.$data->equipo["nombre_equipoGarantia"].', '.'Serie: '.$data->equipo["serie_equipoGarantia"].', '.'Cod. Patrimonial: '.$data->equipo["cp_equipoGarantia"].', '.'Realizado: '.$data["realizado"],
                            'backgroundColor' => 'green',
                            'borderColor' => 'black',
                            'textColor' => 'white'
                        ];
                }

                return response()->json($nuevo_cronograma);
            }

            public function validarFecha($fecha){

                $cronograma_validar = DB::select('select * from cronogramacalendario where fecha = :fecha',['fecha' => $fecha]);

                return $cronograma_validar == null ? true : false;
            }

            public function guardar(Request $request){
                $input = $request->all();

                /* if($this->validarFecha($input["fecha_actual"])){ */

                    if($input["id_equipo"] == ''){
                        echo '<select id="nombres_mantenimiento" required></select>';
                    }else{

                        $cronograma_validar = CronogramasCalendarioModel::create([
                            "id_equipoGarantia"=>$input["id_equipo"],
                            "fecha"=>$input["fecha_actual"],
                            "fecha_final"=>$input["fecha_final"],
                            "realizado"=>$input["realizado_crear"]
                        ]);

                    return response()->json(["ok"=>true]);
                    }
            }

            public function show($id){

                $cronograma = DB::select('select * from cronogramacalendario C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia WHERE id_cronogramaCalendario = ?',[$id]);
                $administradores = AdministradoresModel::all();
                $equipos = EquiposGarantiaModel::all();
                $tipoMantenimientos = TipoMantenimientosModel::all();
                $cronogramas = CronogramasCalendarioModel::all();
                $cronogramasCalendario_fecha = DB::select("select E.cp_equipoGarantia,C.fecha_final,C.realizado,C.id_cronogramaCalendario,C.id_equipoGarantia,C.fecha,E.nombre_equipoGarantia from cronogramacalendario C
                                                INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
                                                WHERE C.realizado = 0 AND C.fecha_final <> ''");
                $tipoMantenimientos_estado = DB::select('select * from mantenimiento where estado_mantenimiento <> 2');
                $proveedores = ProveedoresModel::all();
                $ordenServicios = OrdenServiciosModel::all();
                $departamentos = DB::select('select D.id_departamento,D.nombre_departamento from departamento D where id_departamento <> 19');

                $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
                FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
                WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

$cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
                AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

                if(count($cronograma) != 0){
                    return view("paginas.cronogramasCalendario",array("status"=>200,"cronograma"=>$cronograma,"administradores"=>$administradores,
                    "equipos"=>$equipos,"tipoMantenimientos"=>$tipoMantenimientos,"cronogramas"=>$cronogramas,"cronogramasCalendario_fecha"=>$cronogramasCalendario_fecha,
                    "tipoMantenimientos_estado"=>$tipoMantenimientos_estado,"proveedores"=>$proveedores,"ordenServicios"=>$ordenServicios,
                    "departamentos"=>$departamentos,"notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,
                    "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo));
                }else{
                    return view("paginas.cronogramasCalendario",array("status"=>404,"cronograma"=>$cronograma,"administradores"=>$administradores,
                    "equipos"=>$equipos,"tipoMantenimientos"=>$tipoMantenimientos,"cronogramas"=>$cronogramas,"cronogramasCalendario_fecha"=>$cronogramasCalendario_fecha,
                    "tipoMantenimientos_estado"=>$tipoMantenimientos_estado,"proveedores"=>$proveedores,"ordenServicios"=>$ordenServicios,
                    "departamentos"=>$departamentos,"notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,
                    "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo));
                }
            }

            public function destroy(Request $request){
                $cronograma_unidad = CronogramasCalendarioModel::where("id_cronogramaCalendario",$request->id_cronogramaCalendario)->delete();

                return "ok";
            }

            public function update($id,Request $request){

                $datos = array("id_equipoGarantia"=>$request->input("cronograma_equipo"),
                                "fecha"=>$request->input("cronograma_fecha"),
                                "fecha_final"=>$request->input("cronograma_fecha_final"),
                                "realizado"=>$request->input("cronograma_realizado"),
                                "observacion"=>$request->input("cronograma_observacion"),
                                "id_proveedor"=>$request->input("id_proveedor"));

                $fechaMes = Carbon::parse($request->input("cronograma_fecha"))->month;
                $fechaAño = Carbon::parse($request->input("cronograma_fecha"))->year;

                $observacion = json_encode(explode(",",$datos["observacion"]));

                $pdf = array("pdf_cronograma"=>$request->file("pdf_archivo_final")->store('public/pdf/cronogramaCalendario'));

                //validar los datos
                if(!empty($datos)){
                    $validar = \Validator::make($datos,[
                        "id_equipoGarantia"=>'required|regex:/^[_\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                        "fecha"=>'required',
                        "fecha_final"=>'required',
                        "id_proveedor"=>'required'
                    ]);

                    if($validar->fails()){
                        return redirect("/cronogramasCalendario")->with("no-validacion","");
                    }else{

                        $ruta = $pdf["pdf_cronograma"];

                        $datos = array("id_equipoGarantia"=>$request->input("cronograma_equipo"),
                                        "fecha"=>$request->input("cronograma_fecha"),
                                        "fecha_final"=>$request->input("cronograma_fecha_final"),
                                        "realizado"=>$request->input("cronograma_realizado"),
                                        "observacion"=>$observacion,
                                        "pdf_cronograma"=>$ruta,
                                        "id_proveedor"=>$request->input("id_proveedor"));

                        $fechaMes = Carbon::parse($request->input("cronograma_fecha"))->month;
                        $fechaAño = Carbon::parse($request->input("cronograma_fecha"))->year;

                        $datosRealizado = array("id_equipoGarantia"=>$request->input("cronograma_equipo"),
                                                "mes_cronogramaGeneralNuevo"=>$fechaMes,
                                                "año_cronogramaGeneralNuevo"=>$fechaAño,
                                                "realizado"=>1);

                        $cronograma = CronogramasCalendarioModel::where('id_cronogramaCalendario',$id)->update($datos);
                        $cronogramaRealizado = CronogramasGeneralNuevoModel::where(['id_equipoGarantia'=>$request->input("cronograma_equipo"),
                        'mes_cronogramaGeneralNuevo'=>$fechaMes,'año_cronogramaGeneralNuevo'=>$fechaAño])->update($datosRealizado);
                        return redirect("/cronogramasCalendario")->with("ok-editar","");
                    }

                }else{
                    return redirect("/cronogramasCalendario")->with("error","");
                }
            }
}
