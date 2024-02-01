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
            <th colspan="4" style="text-align:center;">Reporte de los mantenimientos por rango de fechas</th>
        </tr>

        <tr>
            <th colspan="4" style="text-align:center;">Del {{ \Carbon\Carbon::parse($datos["fecha_inicial"])->format('d-m-Y')}} al {{ \Carbon\Carbon::parse($datos["fecha_final"])->format('d-m-Y')}}</th>
        </tr>

    </thead>

    <tbody>

    </tbody>

    </table>

    <table class="table table-bordered table-sm" id="tabla_cronogramaGeneral" style="text-align:center;">
        <thead class="thead-light">
            <tr style="background:#B2CFB6;">
                <th style="vertical-align : middle;text-align:center;" scope="col">ITEM</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">EQUIPO</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">COD. PATRIMONIAL</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">TIPO MNTO</th>
                <th style="vertical-align : middle;text-align:center;width:50px;" scope="col">FECHA INICIAL</th>
                <th style="vertical-align : middle;text-align:center;width:50px;" scope="col">FECHA FINAL</th>
                <th style="vertical-align : middle;text-align:center;width:60px;" scope="col">N° ODS/OTM</th>
                <th style="vertical-align : middle;text-align:center;width:80px;" scope="col">EMPRESA</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">SOLICITADO POR</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">GARANTÍA</th>
                <th style="vertical-align : middle;text-align:center;width:220px;" scope="col">DETALLES DEL SERVICIO</th>
                <th style="vertical-align : middle;text-align:center;width:50px;" scope="col">MONTO MNTO</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">ESTADO</th>
            </tr>
        </thead>

        <tbody>
        @foreach($cronogramas_general as $key => $valor_cronogramas_general)
            <tr>
            <td style="text-align: center;">{{($key+1)}}</td>
                            <td style="text-align: center; text-transform: uppercase;">{{$valor_cronogramas_general->nombre_equipo}}</td>
                            <td style="text-align: center; text-transform: uppercase;">{{$valor_cronogramas_general->cp_equipo}}</td>
                            <td style="text-align: center; text-transform: uppercase;">{{$valor_cronogramas_general->nombre_mantenimiento}}</td>
                            <td style="text-align: center; text-transform: uppercase;">{{ \Carbon\Carbon::parse($valor_cronogramas_general->fecha)->format('d-m-Y')}}</td>
                            <td style="text-align: center; text-transform: uppercase;">{{ \Carbon\Carbon::parse($valor_cronogramas_general->fecha_final)->format('d-m-Y')}}</td>
                            <td style="text-align: center; text-transform: uppercase;">
                                @if($valor_cronogramas_general->codigo_ordenServicio == '' AND $valor_cronogramas_general->realizado == 1)
                                    {{$valor_cronogramas_general->otm_cronograma}}
                                @else
                                    {{$valor_cronogramas_general->codigo_ordenServicio}}
                                @endif
                            </td>
                            <td style="text-align: center; text-transform: uppercase;">
                                @if($valor_cronogramas_general->razonSocial_proveedor == '')
                                    ESGTMEB
                                @else
                                    {{$valor_cronogramas_general->razonSocial_proveedor}}
                                @endif
                            </td>
                            <td style="text-align: center; text-transform: uppercase;">
                                @if($valor_cronogramas_general->iniciales_departamento == '' AND $valor_cronogramas_general->realizado == 1)
                                    {{$valor_cronogramas_general->iniciales_direccionEjecutiva}}
                                @else
                                    {{$valor_cronogramas_general->iniciales_departamento}}
                                @endif
                            </td>
                            <td style="text-align: center; text-transform: uppercase;">{{$valor_cronogramas_general->garantia}} meses</td>
                            <td style="text-align: left; text-transform: uppercase;">{{$valor_cronogramas_general->observacion}}</td>
                            <td style="text-align: center; text-transform: uppercase;">S/. {{number_format($valor_cronogramas_general->monto_cronograma, 2)}}</td>
                            <td style="text-align: center; text-transform: uppercase;">
                                @if($valor_cronogramas_general->realizado == NULL)
                                    <p style="color:red;">NO REALIZADO</p>
                                @elseif($valor_cronogramas_general->realizado == 1)
                                    <p style="color:green;">REALIZADO</p>
                                @endif
                            </td>
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
