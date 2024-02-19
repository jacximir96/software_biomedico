<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProveedoresModel;
use App\AdministradoresModel;

use App\reniec\reniec;
use App\reniec\curl;
use Illuminate\Support\Facades\DB;/* Agregar conbinaciones de tablas en la base de datos */
use Yajra\DataTables\Facades\DataTables;

class ProveedoresController extends Controller
{
    public function getProveedor() {
        if (request()->ajax()) {
            $proveedores = ProveedoresModel::all();
            return DataTables::of($proveedores)->make(true);
        }
    }
    /* Mostrar todos los registros */
    public function index(){

        $administradores = AdministradoresModel::all();
        $proveedores = ProveedoresModel::all();
        $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
                                                    FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
                                                    WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        $cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
                                                    AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");


        return view("paginas.proveedores",array("proveedores"=>$proveedores,"administradores"=>$administradores,
                                                "notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,
                                                "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo));
    }

    function buscarRuc(Request $request)
    {
        if ($request->ajax()) {
            $ruc=$request->get('ruc');
            $ruta = "https://ruc.com.pe/api/beta/ruc";
            $token="5729fb14-cc00-4c9b-8034-af7f4146e572-79a63ec8-9627-4b74-9e8f-6c7eff2834fb";

            $rucaconsultar = $ruc;
            $data = array(
                "token" => $token,
                "ruc"   => $rucaconsultar
            );

            $data_json = json_encode($data);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $ruta);
            curl_setopt(
                $ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                )
            );
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $respuesta  = curl_exec($ch);
            curl_close($ch);

            $leer_respuesta = json_decode($respuesta, true);
            $data=array('entidad' => $leer_respuesta);
            echo json_encode($data);
        }
    }

    public function store(Request $request){

        $datos = array("txtdni"=>$request->input("txtdni"),
                        "txtrazon"=>$request->input("txtrazon"),
                        "txtgrupo"=>$request->input("txtgrupo"),
                        "txtdireccion"=>$request->input("txtdireccion"),
                        "txtdistrito"=>$request->input("txtdistrito"),
                        "txtprovincia"=>$request->input("txtprovincia"),
                        "txtdepartamento"=>$request->input("txtdepartamento"));

        $ruc_validacion = DB::select('SELECT * FROM proveedor WHERE ruc_proveedor = ?', [$request->input("ruc")]);

        if(empty($ruc_validacion) == ""){
            return redirect("/proveedores")->with("ruc-existe","");
        }else{

                            /* Validar datos */
                            if(!empty($datos)){
                                $validar = \Validator::make($datos,[
                                    "txtdni"=>'required|regex:/^[0-9]+$/i',
                                    "txtrazon"=>'required|regex:/^[’\\"\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                                    "txtgrupo"=>'required|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                                    /* "txtdireccion"=>'required', */
                                    "txtdistrito"=>'required|regex:/^[-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                                    "txtprovincia"=>'required|regex:/^[-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                                    "txtdepartamento"=>'required|regex:/^[-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i'
                                ]);

                                if($validar->fails()){
                                    return redirect("/proveedores")->with("no-validacion","");
                                }else{

                                    $proveedor = new ProveedoresModel();
                                    $proveedor->ruc_proveedor = $datos["txtdni"];
                                    $proveedor->razonSocial_proveedor = $datos["txtrazon"];
                                    $proveedor->estado_proveedor = $datos["txtgrupo"];
                                    $proveedor->direccion_proveedor = $datos["txtdireccion"];
                                    $proveedor->distrito_proveedor = $datos["txtdistrito"];
                                    $proveedor->provincia_proveedor = $datos["txtprovincia"];
                                    $proveedor->departamento_proveedor = $datos["txtdepartamento"];

                                    $proveedor->save();
                                    return redirect('/proveedores')->with("ok-crear","");

                                }
                                /* Guardar Dirección Ejecutiva */

                            }else{
                                return redirect('/proveedores')->with("error","");
                            }
        }
    }

        /* Inicio Eliminar un registro */
        public function destroy($id, Request $request){
            $validar = ProveedoresModel::where("id_proveedor",$id)->get();
/*             echo "<pre>"; print_r($validar); echo "</pre>";
            return; */

            if(!empty($validar)){
                $proveedor = ProveedoresModel::where("id_proveedor",$validar[0]["id_proveedor"])->delete();
                //Responder al AJAX de JS
                return "ok";
            }else{
                return redirect("/proveedores")->with("no-borrar", "");
            }
        } /* Fin Eliminar un registro */

        public function show($id){
            $proveedor = ProveedoresModel::where("id_proveedor",$id)->get();
            $proveedores = ProveedoresModel::all();
            $administradores = AdministradoresModel::all();
            $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
            FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
            WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

$cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
            AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

            if(count($proveedor) != 0){
                return view("paginas.proveedores",array("status"=>200,"proveedor"=>$proveedor,"proveedores"=>$proveedores,
                                                        "administradores"=>$administradores,"notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,
                                                        "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo));
            }else{
                return view("paginas.proveedores",array("status"=>404,"proveedor"=>$proveedor,"proveedores"=>$proveedores,
                                                        "administradores"=>$administradores,"notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,
                                                        "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo));
            }
        }

        public function update($id,Request $request){

            $datos = array("txtdni"=>$request->input("txtdni"),
                            "txtrazon"=>$request->input("txtrazon"),
                            "txtgrupo"=>$request->input("txtgrupo"),
                            "txtdireccion"=>$request->input("txtdireccion"),
                            "txtdistrito"=>$request->input("txtdistrito"),
                            "txtprovincia"=>$request->input("txtprovincia"),
                            "txtdepartamento"=>$request->input("txtdepartamento"));

                    //validar los datos
                    if(!empty($datos)){
                        $validar = \Validator::make($datos,[
                                    "txtdni"=>'required|regex:/^[0-9]+$/i',
                                    "txtrazon"=>'required|regex:/^["\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                                    "txtgrupo"=>'required|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/i',
                                    /* "txtdireccion"=>'required', */
                                    "txtdistrito"=>'required|regex:/^[-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                                    "txtprovincia"=>'required|regex:/^[-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                                    "txtdepartamento"=>'required|regex:/^[-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i'
                        ]);

                        if($validar->fails()){
                            return redirect("/proveedores")->with("no-validacion","");
                        }else{

                            $datos = array("ruc_proveedor"=>$request->input("txtdni"),
                                            "razonSocial_proveedor"=>$request->input("txtrazon"),
                                            "estado_proveedor"=>$request->input("txtgrupo"),
                                            "direccion_proveedor"=>$request->input("txtdireccion"),
                                            "distrito_proveedor"=>$request->input("txtdistrito"),
                                            "provincia_proveedor"=>$request->input("txtprovincia"),
                                            "departamento_proveedor"=>$request->input("txtdepartamento"));

                            $proveedor = ProveedoresModel::where('id_proveedor',$id)->update($datos);
                            return redirect("/proveedores")->with("ok-editar","");
                        }

                    }else{
                        return redirect("/proveedores")->with("error","");
                    }
                }
                public function showJson($id) {
                    $proveedores = ProveedoresModel::find($id);
                    return $proveedores;
                }
}

