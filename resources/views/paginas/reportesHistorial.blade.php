<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Registro Histórico de Mantenimiento</title>
    {{-- BOOTSTRAP 4 --}}
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <table class="table table-sm borderless" id="tabla_titulo">
    <thead>
        <tr>
            <th colspan="4" style="text-align:center;">REGISTRO HISTORICO DE MANTENIMIENTO</th>
        </tr>
    </thead>

    <tbody>
    @foreach($equipo_unidad as $key => $valor_equipoUnidad)
        <tr>
            <th>EE.SS:</th>
            <td>INSTITUTO NACIONAL DE REHABILITACIÓN "DRA. ADRIANA REBAZA FLOREZ" AMISTAD PERÚ - JAPÓN</td>
            <td colspan="2"></td>
        </tr>

        <tr>
            <th>EQUIPO:</th>
            <td>{{$valor_equipoUnidad->nombre_equipo}}</td>
            <th>AREA USUARIA:</th>
            <td>{{$valor_equipoUnidad->nombre_ambiente}}</td>
        </tr>

        <tr>
            <th>MARCA:</th>
            <td>{{$valor_equipoUnidad->marca_equipo}}</td>
            <th>SBN:</th>
            <td>{{$valor_equipoUnidad->cp_equipo}}</td>
        </tr>

        <tr>
            <th>MODELO:</th>
            <td>{{$valor_equipoUnidad->modelo_equipo}}</td>
            <th>ADQUIRIDO:</th>
            <td>{{ \Carbon\Carbon::parse($valor_equipoUnidad->fecha_adquisicion_equipo)->format('d-m-Y')}}</td>
        </tr>

        <tr>
            <th>SERIE:</th>
            <td>{{$valor_equipoUnidad->serie_equipo}}</td>
            <th>VALOR INICIAL:</th>
            <td>S/. {{number_format($valor_equipoUnidad->monto_adquisicion_equipo, 2)}}</td>
        </tr>
    @endforeach
    </tbody>
    </table>

    <table class="table table-bordered table-sm" style="text-align:center;">
        <thead class="thead-light">
            <tr>
                <th scope="col">ITEM</th>
                <th colspan="4" scope="col">ACTIVIDAD</th>
                <th scope="col">FECHA</th>
                <th scope="col">COSTO POR INTERVENCIÓN</th>
                <th scope="col">C. ACUMULADO</th>
                <th scope="col">C.A./P.A. X 100</th>
                <th colspan="3" scope="col">ESTADO FINAL</th>
            </tr>
        </thead>

        <tbody>

            @php
                $suma_acumulado_s = 0;
                $porcentaje_acumulado_s = 0;
            @endphp

            @foreach($cronogramas as $key => $valor_cronograma)
                <tr>
                    <td style="vertical-align : middle;text-align:center;" rowspan="2">{{($key+1)}}</td>
                    <td>MP</td>

                    @if($valor_cronograma->id_mantenimiento == 1)
                        <td>X</td>
                    @else
                        <td></td>
                    @endif

                    <td>N° ODS</td>
                    <td style="text-align:left;">{{$valor_cronograma->razonSocial_proveedor}}</td>
                    <td style="vertical-align : middle;text-align:center;" rowspan="2">{{ \Carbon\Carbon::parse($valor_cronograma->fecha_ordenServicio)->format('d-m-Y')}}</td>
                    <td style="vertical-align : middle;text-align:center;" rowspan="2">S/. {{number_format($valor_cronograma->monto_cronograma, 2)}}</td>
                    <td style="vertical-align : middle;text-align:center;" rowspan="2">S/. {{number_format($valor_cronograma->acumulado_cronograma, 2)}}</td>

                    @foreach($equipo_unidad as $key => $valor_equipoUnidad)

                    <td style="vertical-align : middle;text-align:center;" rowspan="2">{{number_format(($valor_cronograma->acumulado_cronograma*100)/$valor_equipoUnidad->monto_adquisicion_equipo, 2)}} %</td>

                    @endforeach

                    <td>B</td>
                    <td>R</td>
                    <td>M</td>
                </tr>

                <tr>
                    <td style="vertical-align : middle;text-align:center;">MC</td>

                    @if($valor_cronograma->id_mantenimiento == 2)
                        <td>X</td>
                    @else
                        <td></td>
                    @endif

                    <td style="vertical-align : middle;text-align:center;">{{$valor_cronograma->codigo_ordenServicio}}</td>

                    @if(strlen(strstr($valor_cronograma->observacion,','))>0)
                        <td style="text-align:left; width:30%;">{{$valor_cronograma->observacion}}</td>
                    @else
                        <td style="text-align:left;">{{$valor_cronograma->observacion}}</td>
                    @endif

                    <td style="vertical-align : middle;text-align:center;">X</td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach

            @foreach($cronogramas as $key => $valor_cronograma)
                @php
                    $suma_acumulado_s += $valor_cronograma->monto_cronograma;
                    $porcentaje_acumulado_s += ($valor_cronograma->monto_cronograma*100)/$valor_equipoUnidad->monto_adquisicion_equipo;
                @endphp
            @endforeach

            <tr>
                    <td colspan="6" style="border:none;"></td>
                    <td>TOTAL</td>
                    <td>S/. {{number_format($suma_acumulado_s, 2)}}</td>
                    <td>{{number_format($porcentaje_acumulado_s, 2)}} %</td>
                    <td colspan="3"></td>
                </tr>
        </tbody>
    </table>
</body>

<style>
    body{
        font-size:10px;
        text-transform: uppercase;
    }

    .borderless td, .borderless th {
    border: none;
    }

</style>
</html>
