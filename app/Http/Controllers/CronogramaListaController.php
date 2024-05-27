<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables as DataTablesDataTables;
use Illuminate\Http\Request;
use App\CronogramasModel;

class CronogramaListaController extends Controller
{
    public function obtenerDatos() {
        if (request()->ajax()) {

            $equiposGeneral = DB::select("SELECT C.id_cronograma, C.observacion,C.pdf_cronograma,C.otm_cronograma,OS.codigo_ordenServicio,D.iniciales_departamento,DE.iniciales_direccionEjecutiva,
            CASE WHEN P.ruc_proveedor IS NULL AND C.realizado = 1 THEN 'ESGTMEB' ELSE P.ruc_proveedor END AS ruc_proveedor,C.monto_cronograma,M.nombre_mantenimiento,C.garantia,C.fecha_final,C.realizado,C.id_cronograma,C.id_equipo,C.fecha,E.nombre_equipo,E.cp_equipo from cronograma C
            INNER JOIN equipo E ON C.id_equipo = E.id_equipo INNER JOIN mantenimiento M ON C.id_mantenimiento = M.id_mantenimiento LEFT JOIN proveedor P ON C.id_proveedor = P.id_proveedor LEFT JOIN departamento D ON C.id_departamento = D.id_departamento LEFT JOIN direccionejecutiva DE ON C.id_direccionEjecutiva = DE.id_direccionEjecutiva LEFT JOIN ordenservicio OS ON C.id_ordenServicio = OS.id_ordenServicio
            WHERE C.fecha_final IS NOT NULL ORDER BY C.id_cronograma DESC");
            
            return DataTablesDataTables::of($equiposGeneral)->make(true);
        }

        
    }


    public function update($id,Request $request){

        $cronograma = CronogramasModel::find($id);

        if ($request->hasFile('pdf_archivo_final_editar')) {
            $pdf = array("pdf_cronograma"=>$request->file("pdf_archivo_final_editar")->store('public/pdf/cronograma'));
            $ruta = $pdf["pdf_cronograma"];
            $ruta_sin_public = str_replace("public/", "", $ruta);
            
        }else{
            $ruta_sin_public = $cronograma->pdf_cronograma;
        }

        $datos = array("fecha"=>$request->input("fecha_actual"),
                        "fecha_final"=>$request->input("fecha_final"),
                        "id_equipo"=>$request->input("id_equipo"),
                        // "realizado"=>$request->input("realizado_crear"),
                        "id_mantenimiento"=>$request->input("id_mantenimiento"),
                        "garantia"=>$request->input("garantia"),
                        "observacion"=>$request->input("cronograma_observacion_editar"),
                        "otm_cronograma"=>$request->input("otm_cronograma_editar"),
                        "pdf_cronograma" => $ruta_sin_public
                    );

                    $equipo = CronogramasModel::where('id_cronograma',$id)->update($datos);

                    if($request->has('crono')){
                        return redirect("/cronogramas")->with("ok-editar","");
                    }

                    return redirect("/cronogramasLista")->with("ok-editar","");
    }


    public function showJson($id) {
        $equipo = CronogramasModel::find($id);
        
        return $equipo;
    }


    public function destroy($id, Request $request){
        
        $validar = CronogramasModel::where("id_cronograma",$id)->get();

        if(!empty($validar)){
            $ambiente = CronogramasModel::where("id_cronograma",$validar[0]["id_cronograma"])->delete();
            return "ok";
        }else{
            return redirect("/cronogramasLista")->with("no-borrar", "");
        }
    }
}
