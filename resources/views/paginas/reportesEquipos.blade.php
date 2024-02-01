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
    <table class="table table-bordered table-sm" id="tabla_titulo">
    <thead class="thead-light">
        <tr>
            <th scope="col" colspan="2" style="text-align:center;vertical-align : middle;">INSTITUTO NACIONAL DE REHABILITACIÓN</th>
            <th scope="col" colspan="8" style="text-align:center;vertical-align : middle;">TARJETA DE REGISTRO DE MANTENIMIENTO DE EQUIPOS MÉDICOS</th>
        </tr>
    </thead>

    <tbody>

        <tr>
            <th colspan="10" style="text-align:center;background:#F6F9FC;">OF. DE SERVICIOS GENERALES - EQUIPO DEL SERVICIO DE GESTIÓN TECNOLÓGICA DE MANTENIMIENTO ELECTRÓNICO Y BIOMÉDICO</th>
        </tr>

        <tr>
            <th colspan="10" style="text-align:center;">DATOS DEL EQUIPO</th>
        </tr>

    @foreach($equipos as $key => $value)
        <tr>
            <th colspan="2">NOMBRE DEL EQUIPO</th>
            <td colspan="8" style="text-align:center;">{{$value->nombre_equipo}}</td>
        </tr>

        <tr>
            <th style="text-align:center; vertical-align : middle;">COD. PATRIMONIAL</th>
            <th style="text-align:center; vertical-align : middle;">MARCA</th>
            <th style="text-align:center; vertical-align : middle;">MODELO</th>
            <th style="text-align:center; vertical-align : middle;">SERIE</th>
            <th style="text-align:center; vertical-align : middle;">FECHA DE INGRESO</th>
            <th colspan="5" style="text-align:center; vertical-align : middle;width:15px;">DPTO / AMBIENTE</th>
        </tr>

        <tr>
            <td style="text-align:center; vertical-align : middle;">{{$value->cp_equipo}}</td>
            <td style="text-align:center; vertical-align : middle;">{{$value->marca_equipo}}</td>
            <td style="text-align:center; vertical-align : middle;">{{$value->modelo_equipo}}</td>
            <td style="text-align:center; vertical-align : middle;">{{$value->serie_equipo}}</td>
            <td style="text-align:center; vertical-align : middle;">{{ \Carbon\Carbon::parse($value->fecha_adquisicion_equipo)->format('d-m-Y')}}</td>
            <td colspan="5" style="text-align:center; vertical-align : middle;width:15px;">{{$value->iniciales_departamento}} / {{$value->nombre_ambiente}}</td>
        </tr>

        <tr>
            <th colspan="10" style="text-align:center;">REPORTES DEL SERVICIO DE MANTENIMIENTO</th>
        </tr>

        <tr>
            <th style="text-align:center; vertical-align : middle;">N°</th>
            <th style="text-align:center; vertical-align : middle;width:15px;">FECHA DE MANTENIMIENTO</th>
            <th style="text-align:center; vertical-align : middle;">RESPONSABLE</th>
            <th style="text-align:center; vertical-align : middle;width:15px;">TIPO DE MANTENIMIENTO</th>
            <th style="text-align:center; vertical-align : middle;" colspan="1">DETALLE DEL MANTENIMIENTO REALIZADO</th>
            <th style="text-align:center; vertical-align : middle;width:15px;" colspan="5">PROXIMO MNTO (Obs)</th>
        </tr>
    @endforeach

    @foreach($cronogramaCalendarioEquipos as $key => $value_cronograma)
        <tr>
            <td style="text-align:center; vertical-align : middle;">{{($key+1)}}</td>
            <td style="text-align:center; vertical-align : middle;">{{ \Carbon\Carbon::parse($value_cronograma->fecha)->format('d-m-Y')}}</td>
            <td style="text-align:center; vertical-align : middle;">{{$value_cronograma->razonSocial_proveedor}}</td>
            <td style="text-align:center; vertical-align : middle;">{{$value_cronograma->nombre_mantenimiento}}</td>
            <td style="text-align:left; vertical-align : middle;text-transform:uppercase">{{$value_cronograma->observacion}}</td>
            <td style="text-align:center; vertical-align : middle;" colspan="5"></td>
        </tr>
    @endforeach

    </tbody>
    </table>

    <table class="table table-bordered table-sm" style="text-align:center;">
        <thead class="thead-light">

        </thead>

        <tbody>

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
