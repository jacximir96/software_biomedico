<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdministradoresModel;
use App\EquiposModel;
use Yajra\DataTables\DataTables as DataTablesDataTables;

use Illuminate\Support\Facades\DB;/* Agregar conbinaciones de tablas en la base de datos */

class EquiposBajaController extends Controller
{
    public function obtenerEquipoBaja(){
      
        if (request()->ajax()) {
            $equipos_baja = DB::select('SELECT * FROM equipo WHERE baja_equipo = 1');
            return DataTablesDataTables::of($equipos_baja)->make(true);
        }
    }
    
    public function index(){
        $administradores = AdministradoresModel::all();
        $equipos_baja = DB::select('SELECT * FROM equipo WHERE baja_equipo = 1');

        $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
                                                    FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
                                                    WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        $cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
                                                    AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        return view("paginas.equiposBaja",  array("administradores"=>$administradores,
                                                        "equipos_baja"=>$equipos_baja,"notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,
                                                        "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo));
    }

   
}
