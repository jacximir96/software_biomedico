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
                <th style="vertical-align : middle;text-align:center;border:none;" scope="col" colspan="17"></th>
                <th style="vertical-align : middle;text-align:center;" scope="col" colspan="5">CRITERIOS DE EVALUACIÓN</th>
                <th style="vertical-align : middle;text-align:center;" scope="col"></th>
                <th style="vertical-align : middle;text-align:center;" scope="col" colspan="2">FUENTE DE EVALUACIÓN</th>
                <th style="vertical-align : middle;text-align:center;" scope="col" colspan="7"></th>
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
                <th style="vertical-align : middle;text-align:center;" scope="col">DENOMINACIÓN DEL EQUIPAMIENTO</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">TIPO DE EQUIPAMIENTO</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">CÓDIGO PATRIMONIAL</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">MARCA</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">MODELO</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">SERIE / PLACA DE RODAJE</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">PRIORIDAD DE INTERVENCIÓN</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">ANTIG. (AÑOS)</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">VIDA UTIL</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">C1</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">C2</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">C3</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">C4</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">C5</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">CONCLUSIONES DE LA EVALUACIÓN</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">FUENTE: EESS O PROVEEDOR</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">N° INFORME TÉCNICO DEL TDR / N° COTIZACIÓN</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">VALOR ACTUAL EQUIPO NUEVO</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">COSTO UNITARIO ESTIMADO DE MNTO</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">FRECUEN./ AÑO</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">COSTO TOTAL DEL MNTO</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">ACTIVIDADES PRINCIPALES</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">PRIOR. MULTIA.</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">ORDEN DE PREL.</th>
            </tr>
        </thead>

        <tbody>
        @foreach($listadoFormato7 as $key => $value_listadoFormato7)
            <tr>
                <td style="vertical-align : middle;text-align:center;">{{($key+1)}}</td>
                <td style="vertical-align : middle;text-align:center;">LIMA METROPOLITANA</td>
                <td style="vertical-align : middle;text-align:center;">009-125: INSTITUTO NACIONAL DE REHABILITACION</td>
                <td style="vertical-align : middle;text-align:center;">7734</td>
                <td style="vertical-align : middle;text-align:center;">INSTITUTO NACIONAL DE REHABILITACION 'DRA. ADRIANA REBAZA FLORES' AMISTAD PERU - JAPON</td>
                <td style="vertical-align : middle;text-align:center;">III-E</td>
                <td style="vertical-align : middle;text-align:center;">
                                @if($value_listadoFormato7->id_equipoExterno == '')
                                    {{$value_listadoFormato7->departamentoEquipo}}
                                @else
                                    {{$value_listadoFormato7->departamentoEquipoExterno}}
                                @endif
                </td>
                <td style="vertical-align : middle;text-align:center;">
                                @if($value_listadoFormato7->id_equipoExterno == '')
                                    {{$value_listadoFormato7->ambienteEquipo}}
                                @else
                                    {{$value_listadoFormato7->ambienteEquipoExterno}}
                                @endif
                </td>
                <td style="vertical-align : middle;text-align:center;">
                                @if($value_listadoFormato7->id_equipoExterno == '')
                                    {{$value_listadoFormato7->nombre_equipo}}
                                @else
                                    {{$value_listadoFormato7->nombre_equipoExterno}}
                                @endif
                </td>
                <td style="vertical-align : middle;text-align:center;">
                                @if($value_listadoFormato7->id_equipoExterno == '')
                                    {{$value_listadoFormato7->tipoEquipamientoEquipo}}
                                @else
                                    {{$value_listadoFormato7->tipoEquipamientoEquipoExterno}}
                                @endif
                </td>
                <td style="vertical-align : middle;text-align:center;">
                                @if($value_listadoFormato7->id_equipoExterno == '')
                                    {{$value_listadoFormato7->cp_equipo}}
                                @else
                                    {{$value_listadoFormato7->cp_equipoExterno}}
                                @endif
                </td>
                <td style="vertical-align : middle;text-align:center;">
                                @if($value_listadoFormato7->id_equipoExterno == '')
                                    {{$value_listadoFormato7->marca_equipo}}
                                @else
                                    {{$value_listadoFormato7->marca_equipoExterno}}
                                @endif
                </td>
                <td style="vertical-align : middle;text-align:center;">
                                @if($value_listadoFormato7->id_equipoExterno == '')
                                    {{$value_listadoFormato7->modelo_equipo}}
                                @else
                                    {{$value_listadoFormato7->modelo_equipoExterno}}
                                @endif
                </td>
                <td style="vertical-align : middle;text-align:center;">
                                @if($value_listadoFormato7->id_equipoExterno == '')
                                    {{$value_listadoFormato7->serie_equipo}}
                                @else
                                    {{$value_listadoFormato7->serie_equipoExterno}}
                                @endif
                </td>
                <td style="vertical-align : middle;text-align:center;">
                                @if($value_listadoFormato7->id_equipoExterno == '')
                                    {{$value_listadoFormato7->prioridad_equipo}}
                                @else
                                    {{$value_listadoFormato7->prioridad_equipoExterno}}
                                @endif
                </td>
                <td style="vertical-align : middle;text-align:center;">
                                @if($value_listadoFormato7->id_equipoExterno == '')
                                    {{$value_listadoFormato7->antiguedad_equipo}}
                                @else
                                    {{$value_listadoFormato7->antiguedad_equipoExterno}}
                                @endif
                </td>
                <td style="vertical-align : middle;text-align:center;">
                                @if($value_listadoFormato7->id_equipoExterno == '')
                                    {{$value_listadoFormato7->tiempo_vida_util_equipo}}
                                @else
                                    {{$value_listadoFormato7->tiempo_vida_util_equipoExterno}}
                                @endif
                </td>
                <td style="vertical-align : middle;text-align:center;">
                    @if($value_listadoFormato7->id_equipoExterno == '')
                        @php
                            $valor = (100*$value_listadoFormato7->acumulado_cronograma)/$value_listadoFormato7->monto_adquisicion_equipo;
                        @endphp

                        @if($valor > 40)

                        @else
                            X
                        @endif
                    @else
                        @if($value_listadoFormato7->criterio_2 == 1)
                            X
                        @endif
                    @endif
                </td>
                <td style="vertical-align : middle;text-align:center;">
                    @if($value_listadoFormato7->id_equipoExterno == '')
                        @if($value_listadoFormato7->antiguedad_equipo >= $value_listadoFormato7->tiempo_vida_util_equipo)

                        @else
                            X
                        @endif
                    @else
                        @if($value_listadoFormato7->antiguedad_equipoExterno >= $value_listadoFormato7->tiempo_vida_util_equipoExterno)

                        @else
                            X
                        @endif
                    @endif
                </td>
                <td style="vertical-align : middle;text-align:center;">
                    @if($value_listadoFormato7->criterio_3 == 1)
                        X
                    @endif
                </td>
                <td style="vertical-align : middle;text-align:center;">
                    @if($value_listadoFormato7->criterio_4 == 1)
                        X
                    @endif
                </td>
                <td style="vertical-align : middle;text-align:center;">
                    @if($value_listadoFormato7->criterio_5 == 1)
                        X
                    @endif
                </td>
                <td style="vertical-align : middle;text-align:center;">
                    @if($value_listadoFormato7->id_equipoExterno == '')
                        @php
                            $valor = (100*$value_listadoFormato7->acumulado_cronograma)/$value_listadoFormato7->monto_adquisicion_equipo;
                        @endphp

                        @if($value_listadoFormato7->antiguedad_equipo <= $value_listadoFormato7->tiempo_vida_util_equipo && $valor < 40 && $value_listadoFormato7->criterio_3 == 1)
                            PREVENTIVO
                        @endif

                        @if($value_listadoFormato7->antiguedad_equipo <= $value_listadoFormato7->tiempo_vida_util_equipo && $valor < 40 && $value_listadoFormato7->criterio_4 == 1 ||
                            $value_listadoFormato7->antiguedad_equipo <= $value_listadoFormato7->tiempo_vida_util_equipo && $valor < 40 && $value_listadoFormato7->criterio_5 == 1)
                            CORRECTIVO
                        @elseif($value_listadoFormato7->antiguedad_equipo <= $value_listadoFormato7->tiempo_vida_util_equipo && $valor < 40 && $value_listadoFormato7->criterio_3 == '' && $value_listadoFormato7->criterio_4 == 0 ||
                                $value_listadoFormato7->antiguedad_equipo <= $value_listadoFormato7->tiempo_vida_util_equipo && $valor < 40 && $value_listadoFormato7->criterio_3 == '' && $value_listadoFormato7->criterio_5 == 0)
                                PREVENTIVO
                        @endif

                    @else

                        @if($value_listadoFormato7->antiguedad_equipoExterno <= $value_listadoFormato7->tiempo_vida_util_equipoExterno && $value_listadoFormato7->criterio_2 == 1 &&
                            $value_listadoFormato7->criterio_3 == 1)
                            PREVENTIVO
                        @endif

                        @if($value_listadoFormato7->antiguedad_equipoExterno <= $value_listadoFormato7->tiempo_vida_util_equipoExterno && $value_listadoFormato7->criterio_2 == 1 &&
                            $value_listadoFormato7->criterio_4 == 1 || $value_listadoFormato7->antiguedad_equipoExterno <= $value_listadoFormato7->tiempo_vida_util_equipoExterno && $value_listadoFormato7->criterio_2 == 1 && $value_listadoFormato7->criterio_5 == 1)
                            CORRECTIVO
                        @elseif($value_listadoFormato7->antiguedad_equipoExterno <= $value_listadoFormato7->tiempo_vida_util_equipoExterno && $value_listadoFormato7->criterio_2 == 1 &&
                                $value_listadoFormato7->criterio_3 == 0 && $value_listadoFormato7->criterio_4 == 0 || $value_listadoFormato7->antiguedad_equipoExterno <= $value_listadoFormato7->tiempo_vida_util_equipoExterno && $value_listadoFormato7->criterio_2 == 1 && $value_listadoFormato7->criterio_3 == 0 && $value_listadoFormato7->criterio_5 == 0)
                            PREVENTIVO
                        @endif

                    @endif
                </td>
                <td style="vertical-align : middle;text-align:center;">
                                @if($value_listadoFormato7->id_proveedor == '')
                                    {{$value_listadoFormato7->nombre_proveedor2}}
                                @else
                                    {{$value_listadoFormato7->razonSocial_proveedor}}
                                @endif
                </td>
                <td style="vertical-align : middle;text-align:center;">
                                @if($value_listadoFormato7->id_ordenServicio == '')
                                    {{$value_listadoFormato7->nombre_informe2}}
                                @else
                                    ORDEN DE SERVICIO N° {{$value_listadoFormato7->codigo_ordenServicio}}
                                @endif
                </td>
                <td style="vertical-align : middle;text-align:center;width:70px;">
                    S/. {{number_format($value_listadoFormato7->precio_equipoNuevo, 2)}}
                </td>
                <td style="vertical-align : middle;text-align:center;">S/. {{number_format($value_listadoFormato7->costo_mantenimiento, 2)}}</td>
                <td style="vertical-align : middle;text-align:center;">1</td>
                <td style="vertical-align : middle;text-align:center;width:70px;">S/. {{number_format($value_listadoFormato7->costo_mantenimiento, 2)}}</td>
                <td style="vertical-align : middle;text-align:left;width:130px;">{{$value_listadoFormato7->actividades_principales}}</td>
                <td style="vertical-align : middle;text-align:center;">{{$value_listadoFormato7->prioridad_multianual}}</td>
                <td style="vertical-align : middle;text-align:center;">{{$value_listadoFormato7->orden_prelacion}}</td>
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
