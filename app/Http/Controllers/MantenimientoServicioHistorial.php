<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables as DataTablesDataTables;

class MantenimientoServicioHistorial extends Controller
{
    public function obtenerDatos($id) {
        if (request()->ajax()) {

            $historialDatos = DB::select("SELECT C.id_cronograma, M.nombre_mantenimiento, C.fecha, C.fecha_final, O.codigo_ordenServicio, 
            C.realizado, C.pdf_cronograma, E.id_equipo, E.nombre_equipo FROM cronograma C INNER JOIN mantenimiento M ON C.id_mantenimiento = M.id_mantenimiento 
            INNER JOIN ordenservicio O ON C.id_ordenServicio = O.id_ordenServicio INNER JOIN equipo E ON C.id_equipo = E.id_equipo WHERE C.id_equipo = $id");

            
            return DataTablesDataTables::of($historialDatos)->make(true);
        }

        
    }

    public function obtenerEquipo($id) {
        if (request()->ajax()) {

            $datos = DB::select("SELECT * FROM equipo WHERE id_equipo = $id");

            
            return $datos;
        }

        
    }
}
