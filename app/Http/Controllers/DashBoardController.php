<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
/* Modelos de nuestro proyecto */
use App\AdministradoresModel;
use App\DepartamentosModel;
use App\DireccionesEjecutivasModel;
/* Fin de Modelos de nuestro proyecto */

use Illuminate\Support\Facades\DB;/* Agregar conbinaciones de tablas en la base de datos */

class DashBoardController extends Controller
{
    public function index(){

        $administradores = AdministradoresModel::all();
        $cantidad_equipos = DB::select('SELECT COUNT(id_equipo) as cantidad_equipos FROM equipo');
        $cantidad_equiposGarantia = DB::select('SELECT COUNT(id_equipoGarantia) as cantidad_equiposGarantia FROM equipogarantia');
        $cantidad_usuarios = DB::select('SELECT COUNT(id) as cantidad_usuarios FROM users');
        $cantidad_proveedores = DB::select('SELECT COUNT(id_proveedor) as cantidad_proveedores FROM proveedor');
        $cantidad_mantenimientosServicio = DB::select('SELECT COUNT(id_cronograma) as cantidad_mantenimientosServicio FROM cronograma WHERE realizado = 1 AND id_mantenimiento = 1 OR id_mantenimiento = 2');
        $cantidad_mantenimientosOTM = DB::select('SELECT COUNT(id_cronograma) as cantidad_mantenimientosServicio FROM cronograma WHERE realizado = 1 AND id_mantenimiento <> 1 AND id_mantenimiento <> 2');
        $cantidad_mantenimientosCompra = DB::select('SELECT COUNT(id_cronogramaCalendario) as cantidad_mantenimientosCompra FROM cronogramacalendario WHERE realizado = 1');
        $monto_ordenServicio = DB::select('SELECT SUM(O.monto_ordenServicio) as suma_total_ordenServicio FROM ordenservicio O');
        $cantidad_mesActual = DB::select('SELECT COUNT(C.id_cronograma) as cantidad_actual FROM cronograma C WHERE C.realizado = 1 AND C.id_ordenServicio IS NOT NULL
                                        AND YEAR(C.fecha) = YEAR(CURDATE()) AND MONTH(C.fecha) = MONTH(CURDATE())');
        $cantidad_mesPasado = DB::select('SELECT COUNT(C.id_cronograma) as cantidad_pasado FROM cronograma C WHERE C.realizado = 1 AND C.id_ordenServicio IS NOT NULL
                                        AND YEAR(C.fecha) = YEAR(CURDATE()) AND MONTH(C.fecha) = MONTH(CURDATE())-1');
        $notificacionesCronogramaNuevo = DB::select("SELECT C.id_equipoGarantia, C.mes_cronogramaGeneralNuevo, C.año_cronogramaGeneralNuevo, E.nombre_equipoGarantia, E.cp_equipoGarantia
        FROM cronogramageneralnuevo C INNER JOIN equipogarantia E ON C.id_equipoGarantia = E.id_equipoGarantia
        WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW()) AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

$cantidadNotificacionesCronogramaNuevo = DB::select("SELECT COUNT(C.id_cronogramaGeneralNuevo) as cantidad FROM cronogramageneralnuevo C WHERE /*C.mes_cronogramaGeneralNuevo BETWEEN MONTH('2012-01-01') AND MONTH(NOW())
        AND C.año_cronogramaGeneralNuevo = YEAR(NOW()) AND*/ C.realizado IS NULL");

        return view("paginas.dashboard",  array("administradores"=>$administradores,"notificacionesCronogramaNuevo"=>$notificacionesCronogramaNuevo,
                                                "cantidadNotificacionesCronogramaNuevo"=>$cantidadNotificacionesCronogramaNuevo,
                                                "cantidad_equipos"=>$cantidad_equipos,"cantidad_equiposGarantia"=>$cantidad_equiposGarantia,
                                                "cantidad_usuarios"=>$cantidad_usuarios,"cantidad_proveedores"=>$cantidad_proveedores,
                                                "cantidad_mantenimientosServicio"=>$cantidad_mantenimientosServicio,
                                                "cantidad_mantenimientosCompra"=>$cantidad_mantenimientosCompra,"monto_ordenServicio"=>$monto_ordenServicio,
                                                "cantidad_mesActual"=>$cantidad_mesActual,"cantidad_mesPasado"=>$cantidad_mesPasado,
                                                "cantidad_mantenimientosOTM"=>$cantidad_mantenimientosOTM));
    }

    public function listarActual(){
        $cronogramas_enero =  DB::select('SELECT COUNT(C.id_cronograma) as enero FROM cronograma C WHERE C.realizado = 1 AND C.id_ordenServicio IS NOT NULL
                                    AND YEAR(C.fecha) = YEAR(CURDATE()) AND MONTH(C.fecha) = 1');
        $cronogramas_febrero =  DB::select('SELECT COUNT(C.id_cronograma) as febrero FROM cronograma C WHERE C.realizado = 1 AND C.id_ordenServicio IS NOT NULL
                                    AND YEAR(C.fecha) = YEAR(CURDATE()) AND MONTH(C.fecha) = 2');
        $cronogramas_marzo =  DB::select('SELECT COUNT(C.id_cronograma) as marzo FROM cronograma C WHERE C.realizado = 1 AND C.id_ordenServicio IS NOT NULL
                                    AND YEAR(C.fecha) = YEAR(CURDATE()) AND MONTH(C.fecha) = 3');
        $cronogramas_abril =  DB::select('SELECT COUNT(C.id_cronograma) as abril FROM cronograma C WHERE C.realizado = 1 AND C.id_ordenServicio IS NOT NULL
                                    AND YEAR(C.fecha) = YEAR(CURDATE()) AND MONTH(C.fecha) = 4');
        $cronogramas_mayo =  DB::select('SELECT COUNT(C.id_cronograma) as mayo FROM cronograma C WHERE C.realizado = 1 AND C.id_ordenServicio IS NOT NULL
                                    AND YEAR(C.fecha) = YEAR(CURDATE()) AND MONTH(C.fecha) = 5');
        $cronogramas_junio =  DB::select('SELECT COUNT(C.id_cronograma) as junio FROM cronograma C WHERE C.realizado = 1 AND C.id_ordenServicio IS NOT NULL
                                    AND YEAR(C.fecha) = YEAR(CURDATE()) AND MONTH(C.fecha) = 6');
        $cronogramas_julio =  DB::select('SELECT COUNT(C.id_cronograma) as julio FROM cronograma C WHERE C.realizado = 1 AND C.id_ordenServicio IS NOT NULL
                                    AND YEAR(C.fecha) = YEAR(CURDATE()) AND MONTH(C.fecha) = 7');
        $cronogramas_agosto =  DB::select('SELECT COUNT(C.id_cronograma) as agosto FROM cronograma C WHERE C.realizado = 1 AND C.id_ordenServicio IS NOT NULL
                                    AND YEAR(C.fecha) = YEAR(CURDATE()) AND MONTH(C.fecha) = 8');
        $cronogramas_setiembre =  DB::select('SELECT COUNT(C.id_cronograma) as setiembre FROM cronograma C WHERE C.realizado = 1 AND C.id_ordenServicio IS NOT NULL
                                    AND YEAR(C.fecha) = YEAR(CURDATE()) AND MONTH(C.fecha) = 9');
        $cronogramas_octubre =  DB::select('SELECT COUNT(C.id_cronograma) as octubre FROM cronograma C WHERE C.realizado = 1 AND C.id_ordenServicio IS NOT NULL
                                    AND YEAR(C.fecha) = YEAR(CURDATE()) AND MONTH(C.fecha) = 10');
        $cronogramas_noviembre =  DB::select('SELECT COUNT(C.id_cronograma) as noviembre FROM cronograma C WHERE C.realizado = 1 AND C.id_ordenServicio IS NOT NULL
                                    AND YEAR(C.fecha) = YEAR(CURDATE()) AND MONTH(C.fecha) = 11');
        $cronogramas_diciembre =  DB::select('SELECT COUNT(C.id_cronograma) as diciembre FROM cronograma C WHERE C.realizado = 1 AND C.id_ordenServicio IS NOT NULL
                                    AND YEAR(C.fecha) = YEAR(CURDATE()) AND MONTH(C.fecha) = 12');

        $cronogramas_enero_pasado =  DB::select('SELECT COUNT(C.id_cronograma) as enero FROM cronograma C WHERE C.realizado = 1 AND C.id_ordenServicio IS NOT NULL
                                    AND YEAR(C.fecha) = YEAR(CURDATE())-1 AND MONTH(C.fecha) = 1');
        $cronogramas_febrero_pasado =  DB::select('SELECT COUNT(C.id_cronograma) as febrero FROM cronograma C WHERE C.realizado = 1 AND C.id_ordenServicio IS NOT NULL
                                    AND YEAR(C.fecha) = YEAR(CURDATE())-1 AND MONTH(C.fecha) = 2');
        $cronogramas_marzo_pasado =  DB::select('SELECT COUNT(C.id_cronograma) as marzo FROM cronograma C WHERE C.realizado = 1 AND C.id_ordenServicio IS NOT NULL
                                    AND YEAR(C.fecha) = YEAR(CURDATE())-1 AND MONTH(C.fecha) = 3');
        $cronogramas_abril_pasado =  DB::select('SELECT COUNT(C.id_cronograma) as abril FROM cronograma C WHERE C.realizado = 1 AND C.id_ordenServicio IS NOT NULL
                                    AND YEAR(C.fecha) = YEAR(CURDATE())-1 AND MONTH(C.fecha) = 4');
        $cronogramas_mayo_pasado =  DB::select('SELECT COUNT(C.id_cronograma) as mayo FROM cronograma C WHERE C.realizado = 1 AND C.id_ordenServicio IS NOT NULL
                                    AND YEAR(C.fecha) = YEAR(CURDATE())-1 AND MONTH(C.fecha) = 5');
        $cronogramas_junio_pasado =  DB::select('SELECT COUNT(C.id_cronograma) as junio FROM cronograma C WHERE C.realizado = 1 AND C.id_ordenServicio IS NOT NULL
                                    AND YEAR(C.fecha) = YEAR(CURDATE())-1 AND MONTH(C.fecha) = 6');
        $cronogramas_julio_pasado =  DB::select('SELECT COUNT(C.id_cronograma) as julio FROM cronograma C WHERE C.realizado = 1 AND C.id_ordenServicio IS NOT NULL
                                    AND YEAR(C.fecha) = YEAR(CURDATE())-1 AND MONTH(C.fecha) = 7');
        $cronogramas_agosto_pasado =  DB::select('SELECT COUNT(C.id_cronograma) as agosto FROM cronograma C WHERE C.realizado = 1 AND C.id_ordenServicio IS NOT NULL
                                    AND YEAR(C.fecha) = YEAR(CURDATE())-1 AND MONTH(C.fecha) = 8');
        $cronogramas_setiembre_pasado =  DB::select('SELECT COUNT(C.id_cronograma) as setiembre FROM cronograma C WHERE C.realizado = 1 AND C.id_ordenServicio IS NOT NULL
                                    AND YEAR(C.fecha) = YEAR(CURDATE())-1 AND MONTH(C.fecha) = 9');
        $cronogramas_octubre_pasado =  DB::select('SELECT COUNT(C.id_cronograma) as octubre FROM cronograma C WHERE C.realizado = 1 AND C.id_ordenServicio IS NOT NULL
                                    AND YEAR(C.fecha) = YEAR(CURDATE())-1 AND MONTH(C.fecha) = 10');
        $cronogramas_noviembre_pasado =  DB::select('SELECT COUNT(C.id_cronograma) as noviembre FROM cronograma C WHERE C.realizado = 1 AND C.id_ordenServicio IS NOT NULL
                                    AND YEAR(C.fecha) = YEAR(CURDATE())-1 AND MONTH(C.fecha) = 11');
        $cronogramas_diciembre_pasado =  DB::select('SELECT COUNT(C.id_cronograma) as diciembre FROM cronograma C WHERE C.realizado = 1 AND C.id_ordenServicio IS NOT NULL
                                    AND YEAR(C.fecha) = YEAR(CURDATE())-1 AND MONTH(C.fecha) = 12');

        $nuevo_cronograma = [];
        $nuevo_cronograma1 = [];

        /* foreach($cronogramas_enero as $key => $valor_actual){ */
            $nuevo_cronograma[] = [
                $cronogramas_enero,
                $cronogramas_febrero,
                $cronogramas_marzo,
                $cronogramas_abril,
                $cronogramas_mayo,
                $cronogramas_junio,
                $cronogramas_julio,
                $cronogramas_agosto,
                $cronogramas_setiembre,
                $cronogramas_octubre,
                $cronogramas_noviembre,
                $cronogramas_diciembre
            ];

            $nuevo_cronograma1[] = [
                $cronogramas_enero_pasado,
                $cronogramas_febrero_pasado,
                $cronogramas_marzo_pasado,
                $cronogramas_abril_pasado,
                $cronogramas_mayo_pasado,
                $cronogramas_junio_pasado,
                $cronogramas_julio_pasado,
                $cronogramas_agosto_pasado,
                $cronogramas_setiembre_pasado,
                $cronogramas_octubre_pasado,
                $cronogramas_noviembre_pasado,
                $cronogramas_diciembre_pasado
            ];
        /* } */

        return response()->json([$nuevo_cronograma,$nuevo_cronograma1]);
    }
}
