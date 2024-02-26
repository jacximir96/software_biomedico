<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/* Modelos de nuestro proyecto */
use App\AdministradoresModel;
use App\AmbientesModel;
use App\DepartamentosModel;
use App\DireccionesEjecutivasModel;
use App\EquiposModel;
/* Fin de Modelos de nuestro proyecto */

use Illuminate\Support\Facades\DB;/* Agregar conbinaciones de tablas en la base de datos */

class DireccionesEjecutivasController extends Controller
{
    public function index(){

        /* DB::select('select * from direccionejecutiva D INNER JOIN
        estado E ON D.estado_direccionEjecutiva = E.id_estado'); */

        /*=============================================
        DataTable Servidor de administradores
        =============================================*/

        /* Si existe un requerimiento del tipo AJAX */
        if(request()->ajax()){
            return datatables()->of(DB::select('select * from direccionejecutiva D INNER JOIN
                                                estado E ON D.estado_direccionEjecutiva = E.id_estado
                                                '))
            ->addColumn('acciones', function($data){
                $acciones = '<div class="btn-group">
                <button class="btn btn-warning btn-sm editar-btn" data-toggle="modal" data-target="#editarModal" data-id="' .$data->id_direccionEjecutiva.'">
                <i class="fas fa-pencil-alt text-white"></i></button>


                                <button class="btn btn-danger btn-sm eliminarRegistro" action="'.url()->current().'/'.$data->id_direccionEjecutiva.'"
                                method="DELETE" pagina="direccionesEjecutivas" token="'.csrf_token().'">
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
        
        $estado = DB::select('select * from estado');
        $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
                                                    FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
                                                    WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        $cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
                                                    AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        return view("paginas.direccionesEjecutivas",array("departamentos"=>$departamentos,"administradores"=>$administradores,
                                                "direccionesEjecutivas"=>$direccionesEjecutivas,"estado"=>$estado,
                                                "notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,
                                                "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo));

    }

    public function show($id){
        $direccionEjecutiva = DireccionesEjecutivasModel::where("id_direccionEjecutiva",$id)->get();
        $direccionesEjecutivas = DireccionesEjecutivasModel::all();
        $administradores = AdministradoresModel::all();
        $departamentos = DepartamentosModel::all();
        $direccion_estado = DB::select('select * from direccionejecutiva D INNER JOIN estado E ON D.estado_direccionEjecutiva = E.id_estado where D.id_direccionEjecutiva = ?',[$id]);
        $estado = DB::select('select * from estado');
        $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
                                                    FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
                                                    WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        $cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
                                                    AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        if(count($direccionEjecutiva) != 0){
            return view("paginas.direccionesEjecutivas",array("status"=>200,"direccionEjecutiva"=>$direccionEjecutiva,
        "direccionesEjecutivas"=>$direccionesEjecutivas,"administradores"=>$administradores,"departamentos"=>$departamentos,"direccion_estado"=>$direccion_estado,"estado"=>$estado,
        "notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,"cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo));
        }else{
            return view("paginas.direccionesEjecutivas",array("status"=>404,"direccionEjecutiva"=>$direccionEjecutiva,
            "direccionesEjecutivas"=>$direccionesEjecutivas,"administradores"=>$administradores,"departamentos"=>$departamentos,"direccion_estado"=>$direccion_estado,"estado"=>$estado,
            "notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,"cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo));
        }
    }

    public function store(Request $request){
        $datos = array("nombre_direccionEjecutiva"=>$request->input("nombre_direccionEjecutiva"),
                       "iniciales_direccionEjecutiva"=>$request->input("iniciales_direccionEjecutiva"),
                       "estado_direccionEjecutiva"=>$request->input("estado_direccionEjecutiva"));

/*         echo "<pre>"; print_r($datos); echo "</pre>";
        return; */

                /* Validar datos */
                if(!empty($datos)){
                    $validar = \Validator::make($datos,[
                        "nombre_direccionEjecutiva"=>'required|regex:/^[,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                        "iniciales_direccionEjecutiva"=>'required|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/i',
                        "estado_direccionEjecutiva"=>'required'
                    ]);

                    /* Guardar Dirección Ejecutiva */
                    if($validar->fails()){
                        return redirect("/direccionesEjecutivas")->with("no-validacion","");
                    }else{

                        $direccionEjecutiva = new DireccionesEjecutivasModel();
                        $direccionEjecutiva->nombre_direccionEjecutiva = $datos["nombre_direccionEjecutiva"];
                        $direccionEjecutiva->iniciales_direccionEjecutiva = $datos["iniciales_direccionEjecutiva"];
                        $direccionEjecutiva->estado_direccionEjecutiva = $datos["estado_direccionEjecutiva"];

                        $direccionEjecutiva->save();
                        return redirect('/direccionesEjecutivas')->with("ok-crear","");

                    }
                }else{
                    return redirect('/direccionesEjecutivas')->with("error","");
                }
    }

    /* Inicio Eliminar un registro */
    public function destroy($id, Request $request){
        $validar = DireccionesEjecutivasModel::where("id_direccionEjecutiva",$id)->get();
        /*echo "<pre>"; print_r($validar); echo "</pre>";
        return; */

        if(!empty($validar)){
            $direccionEjecutiva = DireccionesEjecutivasModel::where("id_direccionEjecutiva",$validar[0]["id_direccionEjecutiva"])->delete();
            //Responder al AJAX de JS
            return "ok";
        }else{
            return redirect("/direccionesEjecutivas")->with("no-borrar", "");
        }
    } /* Fin Eliminar un registro */

    public function update($id,Request $request){
        $datos = array("nombre_direccionEjecutiva"=>$request->input("nombre_direccionEjecutiva"),
                       "iniciales_direccionEjecutiva"=>$request->input("iniciales_direccionEjecutiva"),
                       "estado_direccionEjecutiva"=>$request->input("estado_direccionEjecutiva"));

        //validar los datos
        if(!empty($datos)){
            $validar = \Validator::make($datos,[
                "nombre_direccionEjecutiva"=>'required|regex:/^[,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                "iniciales_direccionEjecutiva"=>'required|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/i',
                "estado_direccionEjecutiva"=>'required'
            ]);

            if($validar->fails()){
                return redirect("/direccionesEjecutivas")->with("no-validacion","");
            }else{

                $datos = array("nombre_direccionEjecutiva"=>$request->input("nombre_direccionEjecutiva"),
                               "iniciales_direccionEjecutiva"=>$request->input("iniciales_direccionEjecutiva"),
                               "estado_direccionEjecutiva"=>$request->input("estado_direccionEjecutiva"));

                $direccionEjecutiva = DireccionesEjecutivasModel::where('id_direccionEjecutiva',$id)->update($datos);
                return redirect("/direccionesEjecutivas")->with("ok-editar","");
            }

        }else{
            return redirect("/direccionesEjecutivas")->with("error","");
        }
    }

    public function showJson($id) {
        $direccionesEjecutivas = DireccionesEjecutivasModel::find($id);
        return $direccionesEjecutivas;
    }

}
