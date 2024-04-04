<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Operarios/Personal</title>
    <style type="text/css">
        * {
            font-family: sans-serif;
        }

        @page {
            margin-top: 0.5cm;
            margin-bottom: 0.5cm;
            margin-left: 1.5cm;
            margin-right: 0.5cm;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-top: 20px;
            page-break-before: avoid;
        }

        table thead tr th,
        tbody tr td {
            padding: 3px;
            word-wrap: break-word;
        }

        table thead tr th {
            font-size: 8pt;
        }

        table tbody tr td {
            font-size: 7pt;
        }


        .encabezado {
            width: 100%;
        }

        .logo img {
            position: absolute;
            height: 100px;
            top: 0px;
            left: 0px;
        }

        h2.titulo {
            width: 450px;
            margin: auto;
            margin-top: 0PX;
            margin-bottom: 15px;
            text-align: center;
            font-size: 14pt;
        }

        .texto {
            width: 250px;
            text-align: center;
            margin: auto;
            margin-top: 15px;
            font-weight: bold;
            font-size: 1.1em;
        }

        .fecha {
            width: 250px;
            text-align: center;
            margin: auto;
            margin-top: 15px;
            font-weight: normal;
            font-size: 0.85em;
        }

        .total {
            text-align: right;
            padding-right: 15px;
            font-weight: bold;
        }

        table {
            width: 100%;
        }

        table thead {
            background: rgb(236, 236, 236);
        }

        tr {
            page-break-inside: avoid !important;
        }

        .centreado {
            padding-left: 0px;
            text-align: center;
        }

        .datos {
            margin-left: 15px;
            border-top: solid 1px;
            border-collapse: collapse;
            width: 250px;
        }

        .txt {
            font-weight: bold;
            text-align: right;
            padding-right: 5px;
        }

        .txt_center {
            font-weight: bold;
            text-align: center;
        }

        .cumplimiento {
            position: absolute;
            width: 150px;
            right: 0px;
            top: 86px;
        }

        .b_top {
            border-top: solid 1px black;
        }

        .gray {
            background: rgb(236, 236, 236);
        }

        .bg-principal {
            background: #1867C0;
            color: white;
        }

        .txt_rojo {}

        .img_celda img {
            width: 45px;
        }

        .nueva_pagina {
            page-break-after: always;
        }

        .subtitulo {
            font-size: 0.9em;
        }

        .txtinfo {
            font-weight: bold;
        }

        .border-bot {
            border-bottom: solid 0.7px black;
        }

        .table-info {
            margin-top: 4px;
            border-collapse: separate;
            border-spacing: 15px 0px;
        }

        .bordeado {
            border: solid 0.7px black;
            height: 14px;
        }

        .bold {
            font-weight: bold;
        }

        .txt-md {
            font-size: 0.8em;
        }

        .foto {
            width: 15%;
            padding: 0px;
            padding-bottom: 5px;
        }

        .foto img {
            width: 100%;
        }

        .bg-gray {
            background: gray;
        }
    </style>
</head>

<body>
    @inject('institucion', 'App\Models\Institucion')
    @php
        $contador = 0;
    @endphp
    @foreach ($obras as $obra)
        <div class="encabezado">
            <div class="logo">
                <img src="{{ $institucion->first()->url_logo }}">
            </div>
            <h2 class="titulo">
                {{ $institucion->first()->razon_social }}
            </h2>
            <h4 class="texto">LISTA DE OPERARIOS/PERSONAL</h4>
            <h4 class="fecha">Expedido: {{ date('d-m-Y') }}</h4>
        </div>
        <h2 class="subtitulo centreado">{{ $obra->nombre }}</h2>
        @if ($obra->presupuesto)
            <table border="1" style="margin-top:5px;">
                <thead>
                    <tr>
                        <th class="centreado" width="4%">N°</th>
                        <th>Operario/Personal</th>
                        <th>C.I.</th>
                        <th>Teléfono</th>
                        <th>Tipo</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $cont = 1;
                    @endphp
                    @foreach ($obra->presupuesto->operarios as $value)
                        <tr>
                            <td class="centreado">{{ $cont++ }}</td>
                            <td class="">{{ $value->operario->full_name }}</td>
                            <td class="centreado">{{ $value->operario->full_ci }}</td>
                            <td class="centreado">{{ $value->operario->fono }}</td>
                            <td class="centreado">{{ $value->operario->tipo }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="txt-md centreado">NO SE ENCONTRÓ NINGUN REGISTRO EN LA OBRA</p>
        @endif
        @php
            $contador++;
        @endphp
        @if ($contador < count($obras))
            <div class="nueva_pagina"></div>
        @endif
    @endforeach
</body>

</html>
