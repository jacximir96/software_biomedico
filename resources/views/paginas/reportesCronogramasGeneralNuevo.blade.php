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
            <th colspan="4" style="text-align:center;">Formato de Intervenciones de Mantenimiento de Equipos Médicos - {{date("Y")}}</th>
        </tr>
    </thead>

    <tbody>

    </tbody>

    </table>

    <hr>

    <table class="table table-bordered table-sm" id="tabla_cronogramaGeneralNuevo" style="text-align:center;">
        <thead class="thead-light">
            <tr style="background:#B2CFB6;">
                <th style="vertical-align : middle;text-align:center;" scope="col">ITEM</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">UPSS</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">EQUIPO</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">MARCA</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">MODELO</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">SERIE</th>
                <th style="vertical-align : middle;text-align:center;" scope="col">C.P</th>
                <th class="rotate"><div>ENERO</div></th>
                <th class="rotate"><div>FEBRERO</div></th>
                <th class="rotate"><div>MARZO</div></th>
                <th class="rotate"><div>ABRIL</div></th>
                <th class="rotate"><div>MAYO</div></th>
                <th class="rotate"><div>JUNIO</div></th>
                <th class="rotate"><div>JULIO</div></th>
                <th class="rotate"><div>AGOSTO</div></th>
                <th class="rotate"><div>SETIEMBRE</div></th>
                <th class="rotate"><div>OCTUBRE</div></th>
                <th class="rotate"><div>NOVIEMBRE</div></th>
                <th class="rotate"><div>DICIEMBRE</div></th>

            </tr>
        </thead>

        <tbody>
            @foreach($cronogramasGeneralNuevo as $key => $valorCronogramasGeneral)
            <tr>
                <td style="vertical-align : middle;text-align:center;">{{($key+1)}}</td>
                <td style="vertical-align : middle;text-align:center;">{{$valorCronogramasGeneral->nombre_ambiente}}</td>
                <td style="vertical-align : middle;text-align:left;">{{$valorCronogramasGeneral->nombre_equipoGarantia}}</td>
                <td style="vertical-align : middle;text-align:center;">{{$valorCronogramasGeneral->marca_equipoGarantia}}</td>
                <td style="vertical-align : middle;text-align:center;">{{$valorCronogramasGeneral->modelo_equipoGarantia}}</td>
                <td style="vertical-align : middle;text-align:center;">{{$valorCronogramasGeneral->serie_equipoGarantia}}</td>
                <td style="vertical-align : middle;text-align:center;">{{$valorCronogramasGeneral->cp_equipoGarantia}}</td>


                        <th style="vertical-align : middle;text-align:center;">
                        @foreach(explode(',', $valorCronogramasGeneral->juntar_meses) as $valores)
                            @if($valores == 1)
                                X
                            @endif
                        @endforeach
                        </th>

                        <th style="vertical-align : middle;text-align:center;">
                        @foreach(explode(',', $valorCronogramasGeneral->juntar_meses) as $valores)
                            @if($valores == 2)
                                X
                            @endif
                        @endforeach
                        </th>

                        <th style="vertical-align : middle;text-align:center;">
                        @foreach(explode(',', $valorCronogramasGeneral->juntar_meses) as $valores)
                            @if($valores == 3)
                                X
                            @endif
                        @endforeach
                        </th>

                        <th style="vertical-align : middle;text-align:center;">
                        @foreach(explode(',', $valorCronogramasGeneral->juntar_meses) as $valores)
                            @if($valores == 4)
                                X
                            @endif
                        @endforeach
                        </th>

                        <th style="vertical-align : middle;text-align:center;">
                        @foreach(explode(',', $valorCronogramasGeneral->juntar_meses) as $valores)
                            @if($valores == 5)
                                X
                            @endif
                        @endforeach
                        </th>

                        <th style="vertical-align : middle;text-align:center;">
                        @foreach(explode(',', $valorCronogramasGeneral->juntar_meses) as $valores)
                            @if($valores == 6)
                                X
                            @endif
                        @endforeach
                        </th>

                        <th style="vertical-align : middle;text-align:center;">
                        @foreach(explode(',', $valorCronogramasGeneral->juntar_meses) as $valores)
                            @if($valores == 7)
                                X
                            @endif
                        @endforeach
                        </th>

                        <th style="vertical-align : middle;text-align:center;">
                        @foreach(explode(',', $valorCronogramasGeneral->juntar_meses) as $valores)
                            @if($valores == 8)
                                X
                            @endif
                        @endforeach
                        </th>

                        <th style="vertical-align : middle;text-align:center;">
                        @foreach(explode(',', $valorCronogramasGeneral->juntar_meses) as $valores)
                            @if($valores == 9)
                                X
                            @endif
                        @endforeach
                        </th>

                        <th style="vertical-align : middle;text-align:center;">
                        @foreach(explode(',', $valorCronogramasGeneral->juntar_meses) as $valores)
                            @if($valores == 10)
                                X
                            @endif
                        @endforeach
                        </th>

                        <th style="vertical-align : middle;text-align:center;">
                        @foreach(explode(',', $valorCronogramasGeneral->juntar_meses) as $valores)
                            @if($valores == 11)
                                X
                            @endif
                        @endforeach
                        </th>

                        <th style="vertical-align : middle;text-align:center;">
                        @foreach(explode(',', $valorCronogramasGeneral->juntar_meses) as $valores)
                            @if($valores == 12)
                                X
                            @endif
                        @endforeach
                        </th>
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

    th{
    padding: 5px;
    }

    #tabla_cronogramaGeneralNuevo{
        border-collapse: collapse;
        width: 100%;
    }

    #tabla_cronogramaGeneralNuevo, td, th {
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
