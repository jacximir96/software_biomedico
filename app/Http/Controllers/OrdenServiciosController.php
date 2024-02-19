<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/* Modelos de nuestro proyecto */
use App\AdministradoresModel;
use App\DepartamentosModel;
use App\DireccionesEjecutivasModel;
use App\RolesModel;
use App\OrdenServiciosModel;
/* Fin de Modelos de nuestro proyecto */

use Illuminate\Support\Facades\DB;/* Agregar conbinaciones de tablas en la base de datos */
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class OrdenServiciosController extends Controller
{
        
        public function getordenServicios() {
            if (request()->ajax()) {    
                $ordenServicios = OrdenServiciosModel::all();
                foreach ($ordenServicios as $dato) {
                    $dato->pdf_ordenServicio = Storage::url($dato->pdf_ordenServicio);
                }
                return DataTables::of($ordenServicios)->make(true);
            }
        }
    
    /* Mostrar todos los registros */
        public function index(){

            $administradores = AdministradoresModel::all();
            $ordenServicio = OrdenServiciosModel::all();
          
            $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
            FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
            WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

            $cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
            AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

            return view("paginas.ordenServicios",array("administradores"=>$administradores,'ordenServicio' => $ordenServicio,
                                                        "notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,
                                                        "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo));
        }

        public function store(Request $request){

            $datos = array("codigo_ordenServicio"=>$request->input("codigo_ordenServicio"),
                            "fecha_ordenServicio"=>$request->input("fecha_ordenServicio"),
                            "expediente_ordenServicio"=>$request->input("expediente_ordenServicio"),
                            "monto_ordenServicio"=>$request->input("monto_ordenServicio"));

            $orden_validacion = DB::select('select * from ordenservicio where codigo_ordenServicio = ?', [$request->input("codigo_ordenServicio")]);
            $pdf = array("pdf_ordenServicio"=>$request->file("pdf_archivo")->store('public/pdf/ordenServicio'));

                    /* echo "<pre>"; print_r($datos); echo "</pre>";
                    return; */

            /*if(empty($orden_validacion) == ""){
                return redirect("/ordenServicios")->with("orden-existe","");
            }else{*/
                    /* Validar datos */
                    if(!empty($datos)){
                        $validar = \Validator::make($datos,[
                            "codigo_ordenServicio"=>'required|regex:/^[0-9]+$/i',
                            "fecha_ordenServicio"=>'required',
                            "expediente_ordenServicio"=>'required|regex:/^[-\\.\\0-9a-zA-Z]+$/i',
                            "monto_ordenServicio"=>'required|regex:/^[.\\0-9]+$/i',
                        ]);

                        /* Guardar Dirección Ejecutiva */
                        if($validar->fails()){
                            return redirect("/ordenServicios")->with("no-validacion","");
                        }else{

                            $ruta = $pdf["pdf_ordenServicio"];

                            $ordenServicio = new OrdenServiciosModel();
                            $ordenServicio->codigo_ordenServicio = $datos["codigo_ordenServicio"];
                            $ordenServicio->fecha_ordenServicio = $datos["fecha_ordenServicio"];
                            $ordenServicio->pdf_ordenServicio = $ruta;
                            $ordenServicio->expediente_ordenServicio = $datos["expediente_ordenServicio"];
                            $ordenServicio->monto_ordenServicio = $datos["monto_ordenServicio"];

                            $ordenServicio->save();
                            return redirect('/ordenServicios')->with("ok-crear","");

                        }
                    }else{
                        return redirect('/ordenServicios')->with("error","");
                    }
            //}
        }

                /* Inicio Eliminar un registro */
                public function destroy($id, Request $request){
                    $validar = OrdenServiciosModel::where("id_ordenServicio",$id)->get();

                    if(!empty($validar)){
                        $ordenServicio = OrdenServiciosModel::where("id_ordenServicio",$validar[0]["id_ordenServicio"])->delete();
                        //Responder al AJAX de JS
                        return "ok";
                    }else{
                        return redirect("/ordenServicios")->with("no-borrar", "");
                    }
                } /* Fin Eliminar un registro */

                public function show($id){

                    $ordenServicio = OrdenServiciosModel::where("id_ordenServicio",$id)->get();
                    $administradores = AdministradoresModel::all();
                    $ordenServicios = OrdenServiciosModel::all();
                    $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
                    FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
                    WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

$cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
                    AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

                    if(count($ordenServicio) != 0){
                        return view("paginas.ordenServicios",array("status"=>200,"ordenServicio"=>$ordenServicio,
                    "administradores"=>$administradores,"ordenServicios"=>$ordenServicios,
                    "notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,
                    "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo));
                    }else{
                        return view("paginas.ordenServicios",array("status"=>404,"ordenServicio"=>$ordenServicio,
                        "administradores"=>$administradores,"ordenServicios"=>$ordenServicios,
                        "notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,
                        "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo));
                    }
                }

                public function update($id,Request $request){

                    $datos = array("codigo_ordenServicio"=>$request->input("codigo_ordenServicio"),
                                    "fecha_ordenServicio"=>$request->input("fecha_ordenServicio"),
                                    "expediente_ordenServicio"=>$request->input("expediente_ordenServicio"),
                                    "monto_ordenServicio"=>$request->input("monto_ordenServicio"),
                                    "pdf_archivo_editar_actual"=>$request->input("pdf_archivo_editar_actual"));

                    $pdf = array("pdf_ordenServicio_editar"=>$request->file("pdf_archivo_editar"));

                    if($pdf["pdf_ordenServicio_editar"] == ''){
                        $pdf_nuevo = $datos["pdf_archivo_editar_actual"];
                    }else{
                        $pdf_nuevo = $pdf["pdf_ordenServicio_editar"]->store('public/pdf/ordenServicio');
                    }

                    //validar los datos
                    if(!empty($datos)){
                        $validar = \Validator::make($datos,[
                            "codigo_ordenServicio"=>'required|regex:/^[0-9]+$/i',
                            "fecha_ordenServicio"=>'required',
                            "expediente_ordenServicio"=>'required|regex:/^[-\\.\\0-9a-zA-Z]+$/i',
                            "monto_ordenServicio"=>'required|regex:/^[.\\0-9]+$/i',
                        ]);

                        if($validar->fails()){
                            return redirect("/ordenServicios")->with("no-validacion","");
                        }else{

                            $datos = array("codigo_ordenServicio"=>$request->input("codigo_ordenServicio"),
                                            "fecha_ordenServicio"=>$request->input("fecha_ordenServicio"),
                                            "expediente_ordenServicio"=>$request->input("expediente_ordenServicio"),
                                            "monto_ordenServicio"=>$request->input("monto_ordenServicio"),
                                            "pdf_ordenServicio"=>$pdf_nuevo);

                            $ordenServicio = OrdenServiciosModel::where('id_ordenServicio',$id)->update($datos);
                            return redirect("/ordenServicios")->with("ok-editar","");
                        }

                    }else{
                        return redirect("/ordenServicios")->with("error","");
                    }
                }
    public function showJson($id) {
        $ordenServicio = OrdenServiciosModel::find($id);
        return $ordenServicio;
    }
}
