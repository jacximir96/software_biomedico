<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Formato de Intervenciones de Mantenimiento de Equipos Médicos {{date("Y")}}</title>
    {{-- BOOTSTRAP 4 --}}
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->
</head>
<body>
    <table class="table table-sm borderless" id="tabla_titulo">
    <thead>
        <tr>
            <th colspan="4" style="text-align:center;">Formato 7.1 (FORMATO DE IDENTIFICACIÓN Y EVALUACIÓN DE EQUIPAMIENTO) - {{date("Y")}}</th>
        </tr>
    </thead>

    <tbody>

    </tbody>

    </table>

    <hr>

    <table class="table table-bordered table-sm" id="tabla_cronogramaGeneral" style="text-align:center;">
        <thead class="thead-light">
            <tr>
                <th style="vertical-align : middle;text-align:center;border:none;" scope="col" colspan="16"></th>
                <th style="vertical-align : middle;text-align:center;" scope="col" colspan="7">CRITERIOS DE EVALUACIÓN</th>
                <th style="vertical-align : middle;text-align:center;" scope="col" colspan="9"></th>
            </tr>

            <tr style="background:#B2CFB6;">
                <th style="vertical-align : middle;text-align:center;" scope="col">ITEM</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">REGIÓN</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">UNIDAD EJECUTORA</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">CÓDIGO IPRESS</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">NOMBRE DEL ESTABLECIMIENTO DE SALUD</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">CATEG. DEL EESS</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">UPSS</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">AMBIENTE</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">CÓDIGO PATRIMONIAL</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">DENOMINACIÓN DEL EQUIPAMIENTO EXISTENTE</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">MARCA</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">MODELO</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">SERIE / PLACA DE RODAJE</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">ANTIG. (AÑOS)</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">VIDA UTIL</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">TIPO DE EQUIPAMIENTO</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">C1</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">C2</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">C3</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">C4</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">C5</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">C6</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">C7</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">PROGRAMA PRESUPUESTAL</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">PRODUCTO</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">ACTIVIDAD</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">FAMILIA</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">DENOMINACIÓN DEL EQUIPAMIENTO A ADQUIRIR</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">COSTO REFERENCIAL</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">FUENTE DEL COSTO REFERENCIAL</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">PRIOR. MULTIA.</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">ORDEN DE PREL.</th>
            </tr>
        </thead>

        <tbody>
        @foreach($listadoFormato8 as $key => $value_listadoFormato8)
            <tr>
                <td style="vertical-align : middle;text-align:center;">{{($key+1)}}</td>
                <td style="vertical-align : middle;text-align:center;">LIMA METROPOLITANA</td>
                <td style="vertical-align : middle;text-align:center;">009-125: INSTITUTO NACIONAL DE REHABILITACION</td>
                <td style="vertical-align : middle;text-align:center;">7734</td>
                <td style="vertical-align : middle;text-align:center;">INSTITUTO NACIONAL DE REHABILITACION 'DRA. ADRIANA REBAZA FLORES' AMISTAD PERU - JAPON</td>
                <td style="vertical-align : middle;text-align:center;">III-E</td>
                <td style="vertical-align : middle;text-align:center;">{{$value_listadoFormato8->nombre_departamento}}</td>
                <td style="vertical-align : middle;text-align:center;">{{$value_listadoFormato8->nombre_ambiente}}</td>
                <td style="vertical-align : middle;text-align:center;">{{$value_listadoFormato8->cp_equipo}}</td>
                <td style="vertical-align : middle;text-align:center;">{{$value_listadoFormato8->nombre_equipo}}</td>
                <td style="vertical-align : middle;text-align:center;">{{$value_listadoFormato8->marca_equipo}}</td>
                <td style="vertical-align : middle;text-align:center;">{{$value_listadoFormato8->modelo_equipo}}</td>
                <td style="vertical-align : middle;text-align:center;">{{$value_listadoFormato8->serie_equipo}}</td>
                <td style="vertical-align : middle;text-align:center;">{{$value_listadoFormato8->antiguedad_equipo}}</td>
                <td style="vertical-align : middle;text-align:center;">{{$value_listadoFormato8->tiempo_vida_util_equipo}}</td>
                <td style="vertical-align : middle;text-align:center;">{{$value_listadoFormato8->nombre_tipoEquipamiento}}</td>
                <td style="vertical-align : middle;text-align:center;">
                    @if($value_listadoFormato8->criterio_1 == 0)
                    @else
                        X
                    @endif
                </td>
                <td style="vertical-align : middle;text-align:center;">
                    @if(100*$value_listadoFormato8->acumulado_cronograma/$value_listadoFormato8->monto_adquisicion_equipo >= 40)
                        X
                    @else
                    @endif
                </td>
                <td style="vertical-align : middle;text-align:center;">
                    @if($value_listadoFormato8->criterio_3 == 0)
                    @else
                        X
                    @endif
                </td>
                <td style="vertical-align : middle;text-align:center;">
                    @if($value_listadoFormato8->criterio_4 == 0)
                    @else
                        X
                    @endif
                </td>
                <td style="vertical-align : middle;text-align:center;">
                    @if($value_listadoFormato8->antiguedad_equipo >= $value_listadoFormato8->tiempo_vida_util_equipo)
                        X
                    @else
                    @endif
                </td>
                <td style="vertical-align : middle;text-align:center;">
                    @if($value_listadoFormato8->criterio_6 == 0)
                    @else
                        X
                    @endif
                </td>
                <td style="vertical-align : middle;text-align:center;">
                    @if($value_listadoFormato8->criterio_7 == 0)
                    @else
                        X
                    @endif
                </td>
                <td style="vertical-align : middle;text-align:center;"></td>
                <td style="vertical-align : middle;text-align:center;"></td>
                <td style="vertical-align : middle;text-align:center;"></td>
                <td style="vertical-align : middle;text-align:center;"></td>
                <td style="vertical-align : middle;text-align:center;"></td>
                <td style="vertical-align : middle;text-align:center;"></td>
                <td style="vertical-align : middle;text-align:center;"></td>
                <td style="vertical-align : middle;text-align:center;"></td>
                <td style="vertical-align : middle;text-align:center;"></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>

<style>
    body{
        font-size:10px;
        text-transform: uppercase;
        font-family: "Gill Sans Extrabold", Helvetica, sans-serif;
    }

    .borderless td, .borderless th {
        border: none;
    }

    th {
    padding: 5px;
    }

    #tabla_cronogramaGeneral{
        border-collapse: collapse;
        width: 100%;
    }

    #tabla_cronogramaGeneral, td, th {
        border: 1px solid black;
    }

    #tabla_titulo{
        width:100%;
    }

    .rotate {
        text-align: left;
        white-space: nowrap;
        vertical-align: middle;
        width: 1.5em;
    }

        hr {
        margin-top:0px;
        height: 1px;
        background-color: #B2CFB6;
    }

    .rotate div {
        -moz-transform: rotate(-90.0deg);  /* FF3.5+ */
        -o-transform: rotate(-90.0deg);  /* Opera 10.5 */
        -webkit-transform: rotate(-90.0deg);  /* Saf3.1+, Chrome */
        filter:  progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083);  /* IE6,IE7 */
        -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083)"; /* IE8 */
        margin-left: -10em;
        margin-right: -10em;
        margin-top: -5em;
        margin-bottom: 10em;
}

</style>
</html>
