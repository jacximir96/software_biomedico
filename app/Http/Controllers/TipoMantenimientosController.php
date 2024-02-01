<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/* Modelos de nuestro proyecto */
use App\AdministradoresModel;
use App\DepartamentosModel;
use App\DireccionesEjecutivasModel;
use App\EquiposModel;
use App\AmbientesModel;
use App\TipoMantenimientosModel;
/* Fin de Modelos de nuestro proyecto */

use Illuminate\Support\Facades\DB;/* Agregar conbinaciones de tablas en la base de datos */

class TipoMantenimientosController extends Controller
{
    public function index(){

        /* DB::select('select * from direccionejecutiva D INNER JOIN
        estado E ON D.estado_direccionEjecutiva = E.id_estado'); */

        /*=============================================
        DataTable Servidor de Ambientes
        =============================================*/

        /* Si existe un requerimiento del tipo AJAX */
        if(request()->ajax()){
            return datatables()->of(DB::select('select * from mantenimiento M INNER JOIN
                                                estado E ON M.estado_mantenimiento = E.id_estado'))
            ->addColumn('acciones', function($data){
                $acciones = '<div class="btn-group">
                                <a href="'.url()->current().'/'.$data->id_mantenimiento.'" class="btn btn-warning btn-sm">
                                    <i class="fas fa-pencil-alt text-white"></i>
                                </a>

                                <button class="btn btn-danger btn-sm eliminarRegistro" action="'.url()->current().'/'.$data->id_mantenimiento.'"
                                method="DELETE" pagina="tipoMantenimientos" token="'.csrf_token().'">
                                    <i class="fas fa-trash-alt text-white"></i>
                                </button>
                            </div>';
                return $acciones;
            })
            ->rawColumns(['acciones'])
            ->make(true);
        }

        $direccionesEjecutivas = DireccionesEjecutivasModel::all();
        $administradores = AdministradoresModel::all();
        $departamentos = DepartamentosModel::all();
        $equipos = EquiposModel::all();
        $ambientes = AmbientesModel::all();
        $tipoMantenimientos = TipoMantenimientosModel::all();
        $estados = DB::select('select * from estado');
        $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
                                                    FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
                                                    WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        $cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
                                                    AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        return view("paginas.tipoMantenimientos",array("tipoMantenimientos"=>$tipoMantenimientos,"ambientes"=>$ambientes,"equipos"=>$equipos,
                                                        "departamentos"=>$departamentos,"administradores"=>$administradores,
                                                        "direccionesEjecutivas"=>$direccionesEjecutivas,"estados"=>$estados,
                                                        "notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,
                                                        "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo));
    }

    public function store(Request $request){
        $datos = array("nombre_mantenimiento"=>$request->input("nombre_mantenimiento"),
                        "estado_mantenimiento"=>$request->input("estado_mantenimiento"));

/*         echo "<pre>"; print_r($datos); echo "</pre>";
        return; */

                /* Validar datos */
                if(!empty($datos)){
                    $validar = \Validator::make($datos,[
                        "nombre_mantenimiento"=>'required|regex:/^[_\\-\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                        "estado_mantenimiento"=>'required'
                    ]);

                    /* Guardar Dirección Ejecutiva */
                    if($validar->fails()){
                        return redirect("/tipoMantenimientos")->with("no-validacion","");
                    }else{

                        $mantenimiento = new TipoMantenimientosModel();
                        $mantenimiento->nombre_mantenimiento = $datos["nombre_mantenimiento"];
                        $mantenimiento->estado_mantenimiento = $datos["estado_mantenimiento"];

                        $mantenimiento->save();
                        return redirect('/tipoMantenimientos')->with("ok-crear","");

                    }
                }else{
                    return redirect('/tipoMantenimientos')->with("error","");
                }
    }

        /* Inicio Eliminar un registro */
        public function destroy($id, Request $request){
            $validar = TipoMantenimientosModel::where("id_mantenimiento",$id)->get();
            /*echo "<pre>"; print_r($validar); echo "</pre>";
            return; */

            if(!empty($validar)){
                $mantenimiento = TipoMantenimientosModel::where("id_mantenimiento",$validar[0]["id_mantenimiento"])->delete();
                //Responder al AJAX de JS
                return "ok";
            }else{
                return redirect("/tipoMantenimientos")->with("no-borrar", "");
            }
        } /* Fin Eliminar un registro */

        public function show($id){
            $mantenimiento = TipoMantenimientosModel::where("id_mantenimiento",$id)->get();
            $direccionesEjecutivas = DireccionesEjecutivasModel::all();
            $administradores = AdministradoresModel::all();
            $departamentos = DepartamentosModel::all();
            $ambientes = AmbientesModel::all();
            $tipoMantenimientos = TipoMantenimientosModel::all();
            $estados = DB::select('select * from estado');
            $estado_mantenimiento = DB::select('select * from mantenimiento M INNER JOIN
                                                estado E ON M.estado_mantenimiento = E.id_estado WHERE id_mantenimiento = ?',[$id]);
                                                $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
                                                FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
                                                WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

    $cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
                                                AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

            if(count($mantenimiento) != 0){
                return view("paginas.tipoMantenimientos",array("status"=>200,"mantenimiento"=>$mantenimiento,"estado_mantenimiento"=>$estado_mantenimiento,"estados"=>$estados,
            "direccionesEjecutivas"=>$direccionesEjecutivas,"administradores"=>$administradores,"departamentos"=>$departamentos,
            "notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,"cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo));
            }else{
                return view("paginas.tipoMantenimientos",array("status"=>404,"mantenimiento"=>$mantenimiento,"estado_mantenimiento"=>$estado_mantenimiento,"estados"=>$estados,
                "direccionesEjecutivas"=>$direccionesEjecutivas,"administradores"=>$administradores,"departamentos"=>$departamentos,
                "notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,"cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo));
            }
        }

        public function update($id,Request $request){

                    $datos = array("nombre_mantenimiento"=>$request->input("nombre_mantenimiento"),
                                    "estado_mantenimiento"=>$request->input("estado_mantenimiento"));

                    //validar los datos
                    if(!empty($datos)){
                        $validar = \Validator::make($datos,[
                            "nombre_mantenimiento"=>'required|regex:/^[_\\-\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                            "estado_mantenimiento"=>'required'
                        ]);

                        if($validar->fails()){
                            return redirect("/tipoMantenimientos")->with("no-validacion","");
                        }else{

                            $datos = array("nombre_mantenimiento"=>$request->input("nombre_mantenimiento"),
                                            "estado_mantenimiento"=>$request->input("estado_mantenimiento"));

                            $mantenimiento = TipoMantenimientosModel::where('id_mantenimiento',$id)->update($datos);
                            return redirect("/tipoMantenimientos")->with("ok-editar","");
                        }

                    }else{
                        return redirect("/tipoMantenimientos")->with("error","");
                    }
                }
}
