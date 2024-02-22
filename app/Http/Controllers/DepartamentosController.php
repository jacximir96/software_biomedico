<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/* Modelos de nuestro proyecto */
use App\AdministradoresModel;
use App\DepartamentosModel;
use App\DireccionesEjecutivasModel;
/* Fin de Modelos de nuestro proyecto */

use Illuminate\Support\Facades\DB;/* Agregar conbinaciones de tablas en la base de datos */

class DepartamentosController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function index(){

        /* DB::select('select * from departamento D INNER JOIN
        estado E ON D.estado_departamento = E.id_estado'); */

        /*=============================================
        DataTable Servidor de departamentos
        =============================================*/

        /* Si existe un requerimiento del tipo AJAX */
        if(request()->ajax()){
            return datatables()->of(DB::select('select * from departamento D INNER JOIN
                                                estado E ON D.estado_departamento = E.id_estado INNER JOIN
                                                direccionejecutiva Dir ON D.id_direccionEjecutiva = Dir.id_direccionEjecutiva'))
            ->addColumn('acciones', function($data){
                $acciones = '<div class="btn-group">
                <button class="btn btn-warning btn-sm editar-btn" data-toggle="modal" data-target="#editarModal" data-id="' .$data->id_departamento.'"><i class="fas fa-pencil-alt text-white"></i></button>

                                <button class="btn btn-danger btn-sm eliminarRegistro" action="'.url()->current().'/'.$data->id_departamento.'"
                                method="DELETE" pagina="departamentos" token="'.csrf_token().'">
                                    <i class="fas fa-trash-alt text-white"></i>
                                </button>
                            </div>';
                return $acciones;
            })
            ->rawColumns(['acciones'])
            ->make(true);
        }

        $departamentos = DepartamentosModel::all();
        $administradores = AdministradoresModel::all();
        $direccionesEjecutivas = DireccionesEjecutivasModel::all();
        // $departamento_estado = DB::select("select * from estado_departamento");
        $departamento_estado_direccionEjecutiva =DB::select('select * from departamento D INNER JOIN
        estado E ON D.estado_departamento = E.id_estado INNER JOIN
        direccionejecutiva Dir ON D.id_direccionEjecutiva = Dir.id_direccionEjecutiva');
        $estado = DB::select('select * from estado');
        $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
                                                    FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
                                                    WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        $cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
                                                    AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        return view("paginas.departamentos",array("departamentos"=>$departamentos,"administradores"=>$administradores,
                                                "direccionesEjecutivas"=>$direccionesEjecutivas,"estado"=>$estado,
                                                "notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,
                                                "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo),['departamento_estado_direccionEjecutiva'=>$departamento_estado_direccionEjecutiva]);

    }

    public function show($id){
        $departamento = DepartamentosModel::where("id_departamento",$id)->get();
        $departamento_direccionEjecutiva = DB::select('select * from departamento D INNER JOIN
                                                        direccionejecutiva Dir ON D.id_direccionEjecutiva = Dir.id_direccionEjecutiva
                                                        WHERE D.id_departamento = ?',[$id]);

/*         $jalar_direccionEjecutiva_sinID = DB::select('select * from departamento D INNER JOIN
                                                        direccionejecutiva Dir ON D.id_direccionEjecutiva = Dir.id_direccionEjecutiva
                                                        WHERE D.id_departamento = ?',[$id]); */
        $direccionesEjecutivas = DireccionesEjecutivasModel::all();
        $administradores = AdministradoresModel::all();
        $departamentos = DepartamentosModel::all();
        $departamento_estado = DB::select('select * from departamento D INNER JOIN estado E ON D.estado_departamento = E.id_estado where D.id_departamento = ?',[$id]);
        $estado = DB::select('select * from estado');

        $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
                                                    FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
                                                    WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        $cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
                                                    AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        if(count($departamento) != 0){
            return view("paginas.departamentos",array("status"=>200,"departamento"=>$departamento,"departamento_direccionEjecutiva"=>$departamento_direccionEjecutiva,
        "direccionesEjecutivas"=>$direccionesEjecutivas,"administradores"=>$administradores,"departamentos"=>$departamentos,"departamento_estado"=>$departamento_estado,"estado"=>$estado,
        "notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,"cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo));
        }else{
            return view("paginas.departamentos",array("status"=>404,"departamento"=>$departamento,
            "direccionesEjecutivas"=>$direccionesEjecutivas,"administradores"=>$administradores,"departamentos"=>$departamentos,"departamento_estado"=>$departamento_estado,"estado"=>$estado,
            "notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,"cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo));
        }
    }

    public function store(Request $request){

        $departamento_estado_direccionEjecutiva =DB::select('select * from departamento D INNER JOIN
                                    estado E ON D.estado_departamento = E.id_estado INNER JOIN
                                    direccionejecutiva Dir ON D.id_direccionEjecutiva = Dir.id_direccionEjecutiva');

        $datos = array("nombre_departamento"=>strtoupper($request->input("nombre_departamento")),
                       "iniciales_departamento"=>strtoupper($request->input("iniciales_departamento")),
                       "estado_departamento"=>$request->input("estado_departamento"),
                       "id_direccionEjecutiva"=>$request->input("id_direccionEjecutiva"));

       /* echo "<pre>"; print_r($datos); echo "</pre>";
        return; */

                /* Validar datos */
                if(!empty($datos)){
                    $validar = \Validator::make($datos,[
                        "nombre_departamento"=>'required|regex:/^[,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                        "iniciales_departamento"=>'required|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/i',
                        "estado_departamento"=>'required',
                        "id_direccionEjecutiva"=>'required'
                    ]);

                    /* Guardar Dirección Ejecutiva */
                    if($validar->fails()){
                        return redirect("/departamentos")->with("no-validacion","");
                    }else{

                        $departamento = new DepartamentosModel();
                        $departamento->nombre_departamento = $datos["nombre_departamento"];
                        $departamento->iniciales_departamento = $datos["iniciales_departamento"];
                        $departamento->estado_departamento = $datos["estado_departamento"];
                        $departamento->id_direccionEjecutiva = $datos["id_direccionEjecutiva"];

                        $departamento->save();
                        return redirect('/departamentos')->with("ok-crear","");

                    }
                }else{
                    return redirect('/departamentos')->with("error","");
                }
    }

        /* Inicio Eliminar un registro */
        public function destroy($id, Request $request){
            $validar = DepartamentosModel::where("id_departamento",$id)->get();
            /*echo "<pre>"; print_r($validar); echo "</pre>";
            return; */

            if(!empty($validar)){
                $departamento = DepartamentosModel::where("id_departamento",$validar[0]["id_departamento"])->delete();
                //Responder al AJAX de JS
                return "ok";
            }else{
                return redirect("/departamentos")->with("no-borrar", "");
            }
        } /* Fin Eliminar un registro */

        public function update($id,Request $request){
            $departamento_estado_direccionEjecutiva =DB::select('select * from departamento D INNER JOIN
                                                estado E ON D.estado_departamento = E.id_estado INNER JOIN
                                                direccionejecutiva Dir ON D.id_direccionEjecutiva = Dir.id_direccionEjecutiva');

            $datos =  array("nombre_departamento"=>$request->input("nombre_departamento"),
                            "iniciales_departamento"=>$request->input("iniciales_departamento"),
                            "estado_departamento"=>$request->input("estado_departamento"),
                            "id_direccionEjecutiva"=>$request->input("id_direccionEjecutiva"));

            //validar los datos
            if(!empty($datos)){
                $validar = \Validator::make($datos,[
                    "nombre_departamento"=>'required|regex:/^[,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                    "iniciales_departamento"=>'required|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/i',
                    "estado_departamento"=>'required',
                    "id_direccionEjecutiva"=>'required'
                ]);

                if($validar->fails()){
                    return redirect("/departamentos")->with("no-validacion","");
                }else{

                    $datos =  array("nombre_departamento"=>$request->input("nombre_departamento"),
                                    "iniciales_departamento"=>$request->input("iniciales_departamento"),
                                    "estado_departamento"=>$request->input("estado_departamento"),
                                    "id_direccionEjecutiva"=>$request->input("id_direccionEjecutiva"));

                    $departamento = DepartamentosModel::where('id_departamento',$id)->update($datos);
                    return redirect("/departamentos")->with("ok-editar","");
                }

            }else{
                return redirect("/departamentos")->with("error","");
            }
        }

    function showJson($id){
        $departamento = DepartamentosModel::find($id);
        return $departamento;
    }
}
