<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdministradoresModel;
use App\DepartamentosModel;
use App\DireccionesEjecutivasModel;
use App\RolesModel;
use App\ModelHasRolesModel;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdministradoresController extends Controller
{
    public function getAdministrador() {
        if (request()->ajax()) {
            $administradores_general = DB::select('SELECT U.id AS id_administrador,U.name AS nombre_administrador,U.email AS correo_administrador,U.foto AS foto_administrador
                                                ,U.id_rol AS rol_administrador,U.password AS password_administrador,R.id AS id_rol,R.name AS nombreRol_administador FROM users U
                                                LEFT JOIN roles R ON U.id_rol = R.id ORDER BY U.id DESC');

            return DataTables::of($administradores_general)->make(true);
        }
    }
    public function index(){

        $administradores = DB::select('select U.id as id_usuario,U.name,U.email,U.foto,U.id_rol,U.password,R.id,R.name rol from users U
        LEFT JOIN roles R ON U.id_rol = R.id');
        $user = Auth::user();
        $roles = DB::select('SELECT * FROM roles where estado_rol = 1');
        $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
                                                    FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
                                                    WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        $cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
                                                    AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        return view("paginas.administradores",array("administradores"=>$administradores,"roles"=>$roles,"user"=>$user,
                                                    "notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,
                                                    "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo));
    }

    /* Mostrar un solo registro */
    public function show($id){
        $administrador = AdministradoresModel::where("id",$id)->get();
        $administradores = AdministradoresModel::all();

        $administrador_rol = DB::select('select U.id as id_usuario,U.name as usuario,U.email,U.foto,U.id_rol,U.password,R.id,R.name from users U
                                        INNER JOIN roles R ON U.id_rol = R.id WHERE U.id = ?',[$id]);

        $roles = DB::select('select * from roles where estado_rol = 1');

        $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
                                                    FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
                                                    WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        $cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
                                                    AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        if(count($administrador) != 0){
            return view("paginas.administradores",array("status"=>200,"administrador"=>
            $administrador, "administradores"=>$administradores,"administrador_rol"=>$administrador_rol,"roles"=>$roles,
            "notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,"cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo));
        }else{
            return view("paginas.administradores",array("status"=>404,"administradores"=>$administradores,"roles"=>$roles,
            "notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,"cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo));
        }
    }

    /* Editar un registro */
    public function update($id, Request $request){
        //recoger datos
        $datos = array("name"=>$request->input("name"),
                       "email"=>$request->input("email"),
                       "password_actual"=>$request->input("password_actual"),
                       "id_rol"=>$request->input("id_rol"),
                       "imagen_actual"=>$request->input("imagen_actual"));

        $datos1 = array("role_id" => $datos["id_rol"],
                       "model_type" => 'App\User',
                       "model_id" => $id);

        $password = array("password"=>$request->input("password"));
        $foto = array("foto"=>$request->file("foto"));

/*         echo "<pre>"; print_r($datos1); echo "</pre>";
        return; */

        //validar los datos
        if(!empty($datos)){
            $validar = \Validator::make($datos,[
                'name' => "required|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i",
                'email' => 'required|regex:/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/i'
            ]);

        if($password["password"] != ""){
            $validarPassword = \Validator::make($password,[
                "password" => "required|regex:/^[_\\-\\;\\,\\+\\-\\*\\.\\&\\%\\$\\#\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/i"
            ]);

            if($validarPassword->fails()){
                return redirect("/administradores")->with("no-validacion","");
            }else{
                $nuevaPassword = Hash::make($password['password']);
            }
        }else{
            $nuevaPassword = $datos["password_actual"];
        }

        if($foto["foto"] != ""){
            $validarFoto = \Validator::make($foto,[
                "foto" => 'required|image|mimes:jpg,jpeg,png|max:2000000'
            ]);

            if($validarFoto->fails()){
                return redirect("/administradores")->with("no-validacion","");
            }
        }

        if($validar->fails()){
            return redirect("/administradores")->with("no-validacion","");
        }else{
            if($foto["foto"] != ""){

                if(!empty($datos["imagen_actual"])){

                    if($datos["imagen_actual"] != "img/administradores/administrador.png"){

                        unlink($datos["imagen_actual"]);

                    }

                }

                $aleatorio = mt_rand(100,999);

                $ruta = "img/administradores/".$aleatorio.".".$foto["foto"]->guessExtension();

                move_uploaded_file($foto["foto"], $ruta);

            }else{
                $ruta = $datos["imagen_actual"];
            }

            $datos = array("name" => $datos["name"],
                           "email" => $datos["email"],
                           "password" => $nuevaPassword,
                           "id_rol" => $datos["id_rol"],
                           "foto" => $ruta);

            $datos1 = array("role_id" => $datos["id_rol"],
                            "model_type" => 'App\User',
                            "model_id" => $id);

            $administrador = AdministradoresModel::where('id',$id)->update($datos);
            $model_has_roles = ModelHasRolesModel::where('model_id',$id)->update($datos1);
            return redirect("/administradores")->with("ok-editar","");
        }
     }else{
        return redirect("/administradores")->with("error","");
     }
    }

    /* Eliminar un registro */
    public function destroy($id, Request $request){
        $validar = AdministradoresModel::where("id",$id)->get();
        /* echo "<pre>"; print_r($validar); echo "</pre>";
        return; */

        if(!empty($validar) && $id != 1){

    		if(!empty($validar[0]["foto"])){

    			unlink($validar[0]["foto"]);

    		}

    		$administrador = AdministradoresModel::where("id",$validar[0]["id"])->delete();
            $model_has_roles = ModelHasRolesModel::where('model_id',$validar[0]["id"])->delete();

    		//Responder al AJAX de JS
    		return "ok";

    	}else{

    		return redirect("/administradores")->with("no-borrar", "");

    	}
    }

    public function showJson($id) {
        $administrador = AdministradoresModel::find($id);
        return $administrador;
    }
}
