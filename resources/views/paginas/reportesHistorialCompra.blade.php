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
            <td>{{$valor_equipoUnidad->nombre_equipoGarantia}}</td>
            <th></th>
            <td></td>
        </tr>

        <tr>
            <th>MARCA:</th>
            <td>{{$valor_equipoUnidad->marca_equipoGarantia}}</td>
            <th>SBN:</th>
            <td>{{$valor_equipoUnidad->cp_equipoGarantia}}</td>
        </tr>

        <tr>
            <th>MODELO:</th>
            <td>{{$valor_equipoUnidad->modelo_equipoGarantia}}</td>
            <th>ADQUIRIDO:</th>
            <td>{{ \Carbon\Carbon::parse($valor_equipoUnidad->fecha_adquisicion_equipoGarantia)->format('d-m-Y')}}</td>
        </tr>

        <tr>
            <th>SERIE:</th>
            <td>{{$valor_equipoUnidad->serie_equipoGarantia}}</td>
            <th>VALOR INICIAL:</th>
            <td>S/. {{number_format($valor_equipoUnidad->monto_adquisicion_equipoGarantia, 2)}}</td>
        </tr>
    @endforeach
    </tbody>
    </table>

    <table class="table table-bordered table-sm" style="text-align:center;">
        <thead class="thead-light">
            <tr>
                <th scope="col">ITEM</th>
                <th colspan="5" scope="col">ACTIVIDAD</th>
                <th scope="col">FECHA</th>
                <th colspan="3" scope="col">ESTADO FINAL</th>
            </tr>
        </thead>

        <tbody>

        @foreach($cronogramas as $key => $valor_cronograma)
                <tr>
                    <td style="vertical-align : middle;text-align:center;" rowspan="2">{{($key+1)}}</td>
                    <td style="vertical-align : middle;text-align:center;">Empresa:</td>
                    <td colspan="4" style="text-align:left;">{{$valor_cronograma->razonSocial_proveedor}}</td>
                    <td style="vertical-align : middle;text-align:center;width:20%;" rowspan="2">{{$valor_cronograma->fecha}}</td>
                    <td>B</td>
                    <td>R</td>
                    <td>M</td>
                </tr>

                <tr>
                    <td style="vertical-align : middle;text-align:center;">Actividades:</td>
                    @if(strlen(strstr($valor_cronograma->observacion,','))>0)
                        <td colspan="4" style="text-align:left;">{{$valor_cronograma->observacion}}</td>
                    @else
                        <td colspan="4" style="text-align:left;">{{$valor_cronograma->observacion}}</td>
                    @endif

                    <td style="vertical-align : middle;text-align:center;">X</td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach

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


