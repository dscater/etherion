<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>orden_ventas</title>
    <style type="text/css">
        * {
            font-family: sans-serif;
        }

        @page {
            margin-top: 1.5cm;
            margin-bottom: 0.3cm;
            margin-left: 0.3cm;
            margin-right: 0.3cm;
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
            font-size: 7pt;
        }

        table tbody tr td {
            font-size: 6pt;
        }


        .encabezado {
            width: 100%;
        }

        .logo img {
            position: absolute;
            height: 100px;
            top: -20px;
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
            background: rgb(236, 236, 236)
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
            background: rgb(202, 202, 202);
        }

        .bg-principal {
            background: #1867C0;
            color: white;
        }

        .txt_rojo {}

        .img_celda img {
            width: 45px;
        }

        .bold {
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .text-md {
            font-size: 0.85em;
        }
    </style>
</head>

<body>
    @inject('institucion', 'App\Models\Institucion')
    <div class="encabezado">
        <div class="logo">
            <img src="{{ $institucion->first()->url_logo }}">
        </div>
        <h2 class="titulo">
            {{ $institucion->first()->razon_social }}
        </h2>
        <h4 class="texto">LISTA DE ORDENES DE VENTA</h4>
        <h4 class="fecha">Expedido: {{ date('d-m-Y') }}</h4>
    </div>
    <table border="1">
        <thead class="bg-principal">
            <tr>
                <th width="3%">N°</th>
                <th>CÓDIGO ORDEN</th>
                <th>DESCRIPCIÓN DEL PRODUCTO</th>
                <th>CATEGORÍA</th>
                <th>TAMAÑO DEL PRODUCTO</th>
                <th>CANTIDAD</th>
                <th>PRECIO S/C</th>
                <th>PRECIO TOTAL</th>
                <th>ESTADO</th>
                <th width="9%">FECHA DE REGISTRO</th>
            </tr>
        </thead>
        <tbody>
            @php
                $cont = 1;
                $suma_cantidad = 0;
                $suma_precio_sc = 0;
                $suma_precio_total = 0;
            @endphp
            @foreach ($orden_detalles as $od)
                <tr>
                    <td class="centreado">{{ $cont++ }}</td>
                    <td>{{ $od->orden_venta->codigo }}</td>
                    <td class="">{{ $od->producto->descripcion }}</td>
                    <td class="">{{ $od->producto->categoria->nombre }}</td>
                    <td class="">{{ $od->producto->producto_tamano->nombre }}</td>
                    <td class="centreado">{{ $od->cantidad }}</td>
                    <td class="centreado">{{ $od->precio_sc }}</td>
                    <td class="centreado">{{ $od->precio_total }}</td>
                    <td class="centreado">{{ $od->orden_venta->estado }}</td>
                    <td class="centreado">{{ $od->orden_venta->fecha_registro_t }}</td>
                </tr>
                @php
                    $suma_cantidad = (float) $suma_cantidad + (float) $od->cantidad;
                    $suma_precio_sc = (float) $suma_precio_sc + (float) $od->precio_sc;
                    $suma_precio_total = (float) $suma_precio_total + (float) $od->precio_total;
                @endphp
            @endforeach
            <tr>
                <td colspan="5" class="bold text-right text-md">
                    TOTAL
                </td>
                <td class="bold centreado text-md">{{ number_format($suma_cantidad, 2, '.', '') }}</td>
                <td class="bold centreado text-md">{{ number_format($suma_precio_sc, 2, '.', '') }}</td>
                <td class="bold centreado text-md">{{ number_format($suma_precio_total, 2, '.', '') }}</td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</body>

</html>
