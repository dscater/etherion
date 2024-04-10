<?php

namespace App\Http\Controllers;

use App\Models\Institucion;
use App\Models\Obra;
use App\Models\OrdenDetalle;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use PDF;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ReporteController extends Controller
{
    public $styleTexto = [
        'font' => [
            'bold' => true,
            'size' => 12,
            'family' => 'Times New Roman'
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE,
            ],
        ],
    ];

    public $styleTextoForm = [
        'font' => [
            'bold' => true,
            'size' => 10,
        ],
    ];

    public $styleArray = [
        'font' => [
            'bold' => true,
            'size' => 10,
            'color' => ['argb' => 'ffffff'],
        ],
        'alignment' => [
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'color' => ['rgb' => '1867C0']
        ],
    ];


    public $styleArray2 = [
        'font' => [
            'bold' => true,
            'size' => 10,
            'color' => ['argb' => 'ffffff'],
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'color' => ['rgb' => '1867C0']
        ],
    ];

    public $estilo_conenido = [
        'font' => [
            'size' => 10,
        ],
        'alignment' => [
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            // 'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
        ],
    ];

    public $estilo_conenido2 = [
        'font' => [
            'size' => 10,
            'bold' => true
        ],
        'alignment' => [
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            // 'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'color' => ['rgb' => 'EBF1DE']
        ],
    ];

    public $estilo_conenido3 = [
        'font' => [
            'size' => 10,
            'bold' => true
        ],
        'alignment' => [
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'color' => ['rgb' => 'EEECE1']
        ],
    ];

    public $entregado = [
        'font' => [
            'bold' => true,
            'size' => 10,
            'color' => ['argb' => 'ffffff'],
        ],

        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'color' => ['rgb' => '029609']
        ],
    ];
    public $devolucion = [
        'font' => [
            'bold' => true,
            'size' => 10,
            'color' => ['argb' => 'ffffff'],
        ],

        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'color' => ['rgb' => 'bb3a13']
        ],
    ];
    public $pendiente = [
        'font' => [
            'bold' => true,
            'size' => 10,
            'color' => ['argb' => 'ffffff'],
        ],

        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'color' => ['rgb' => '1867C0']
        ],
    ];

    public function productos()
    {
        return Inertia::render("Admin/Reportes/Productos");
    }

    public function r_productos(Request $request)
    {
        $filtro =  $request->filtro;
        $categoria_id =  $request->categoria_id;
        $producto_tamano_id =  $request->producto_tamano_id;
        $fecha_ini =  $request->fecha_ini;
        $fecha_fin =  $request->fecha_fin;
        $tipo =  $request->tipo;
        $productos = Producto::all();

        if ($filtro != 'todos') {
            if ($filtro == 'categoria') {
                $productos = Producto::select("productos.*");
                if ($categoria_id != 'todos') {
                    $productos->where("categoria_id", $categoria_id);
                }
                if ($producto_tamano_id != 'todos') {
                    $productos->where("producto_tamano_id", $producto_tamano_id);
                }
                $productos = $productos->get();
            }
            if ($filtro == 'fechas') {
                if ($fecha_ini && $fecha_fin) {
                    $productos = Producto::whereBetween('fecha_registro', [$fecha_ini, $fecha_fin])->get();
                }
            }
        }

        if ($tipo == 'pdf') {
            $pdf = PDF::loadView('reportes.productos', compact('productos'))->setPaper('letter', 'landscape');

            // ENUMERAR LAS PÁGINAS USANDO CANVAS
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();
            $canvas = $dom_pdf->get_canvas();
            $alto = $canvas->get_height();
            $ancho = $canvas->get_width();
            $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 9, array(0, 0, 0));

            return $pdf->stream('productos.pdf');
        }

        if ($tipo == 'excel') {
            return $this->r_productos_excel($productos);
        }
    }

    private function r_productos_excel($productos)
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator("ADMIN")
            ->setLastModifiedBy('Administración')
            ->setTitle('Reporte')
            ->setSubject('Reporte')
            ->setDescription('Reporte')
            ->setKeywords('PHPSpreadsheet')
            ->setCategory('Reporte');

        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');

        $fila = 1;
        if (file_exists(public_path() . '/imgs/' . Institucion::first()->logo)) {
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setName('logo');
            $drawing->setDescription('logo');
            $drawing->setPath(public_path() . '/imgs/' . Institucion::first()->logo); // put your path and image here
            $drawing->setCoordinates('A' . $fila);
            $drawing->setOffsetX(5);
            $drawing->setOffsetY(0);
            $drawing->setHeight(60);
            $drawing->setWorksheet($sheet);
        }

        $fila = 2;

        $sheet->setCellValue('A' . $fila, "LISTA DE PRODUCTOS");
        $sheet->mergeCells("A" . $fila . ":H" . $fila);  //COMBINAR CELDAS
        $sheet->getStyle('A' . $fila . ':U' . $fila)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A' . $fila . ':H' . $fila)->applyFromArray($this->styleTextoForm);
        $fila++;
        $fila++;
        $fila++;
        $sheet->setCellValue('A' . $fila, "No.");
        $sheet->setCellValue('B' . $fila, "Descripción");
        $sheet->setCellValue('C' . $fila, "Afiliado");
        $sheet->setCellValue('D' . $fila, "Categoría");
        $sheet->setCellValue('E' . $fila, "Tamaño");
        $sheet->setCellValue('F' . $fila, "Precio");
        $sheet->setCellValue('G' . $fila, "Precio Total");
        $sheet->setCellValue('H' . $fila, "Fecha de Registro");
        $sheet->getStyle('A' . $fila . ':H' . $fila)->applyFromArray($this->styleArray2);
        $fila++;
        $cont = 1;
        foreach ($productos as $producto) {
            $sheet->setCellValue('A' . $fila, $cont++);
            $sheet->setCellValue('B' . $fila, $producto->descripcion);
            $sheet->setCellValue('C' . $fila, $producto->user->full_name);
            $sheet->setCellValue('D' . $fila, $producto->categoria->nombre);
            $sheet->setCellValue('E' . $fila, $producto->producto_tamano->nombre);
            $sheet->setCellValue('F' . $fila, $producto->precio);
            $sheet->setCellValue('G' . $fila, $producto->precio_total);
            $sheet->setCellValue('H' . $fila, $producto->fecha_registro_t);
            $sheet->getStyle('A' . $fila . ':H' . $fila)->applyFromArray($this->estilo_conenido);
            $fila++;
        }

        $sheet->getColumnDimension('A')->setWidth(6);
        $sheet->getColumnDimension('B')->setWidth(60);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(10);

        foreach (range('A', 'H') as $columnID) {
            $sheet->getStyle($columnID)->getAlignment()->setWrapText(true);
        }

        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
        $sheet->getPageMargins()->setTop(0.5);
        $sheet->getPageMargins()->setRight(0.1);
        $sheet->getPageMargins()->setLeft(0.1);
        $sheet->getPageMargins()->setBottom(0.1);
        $sheet->getPageSetup()->setPrintArea('A:H');
        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);

        // DESCARGA DEL ARCHIVO
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="productos.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function orden_ventas()
    {
        return Inertia::render("Admin/Reportes/OrdenVentas");
    }

    public function r_orden_ventas(Request $request)
    {
        $filtro =  $request->filtro;
        $categoria_id =  $request->categoria_id;
        $estado =  $request->estado;
        $fecha_ini =  $request->fecha_ini;
        $fecha_fin =  $request->fecha_fin;
        $tipo =  $request->tipo;
        $orden_detalles = OrdenDetalle::all();

        if ($filtro != 'todos') {
            if ($filtro == 'categoria') {
                $orden_detalles = OrdenDetalle::select("orden_detalles.*")
                    ->join("orden_ventas", "orden_ventas.id", "=", "orden_detalles.orden_venta_id")
                    ->join("productos", "productos.id", "=", "orden_detalles.producto_id");
                if ($categoria_id != 'todos') {
                    $orden_detalles->where("productos.categoria_id", $categoria_id);
                }
                if ($estado != 'todos') {
                    $orden_detalles->where("orden_ventas.estado", $estado);
                }
                $orden_detalles = $orden_detalles->get();
            }
            if ($filtro == 'fechas') {
                if ($fecha_ini && $fecha_fin) {
                    $orden_detalles = OrdenDetalle::select("orden_detalles.*")
                        ->join("orden_ventas", "orden_ventas.id", "=", "orden_detalles.orden_venta_id")
                        ->whereBetween('orden_ventas.fecha_registro', [$fecha_ini, $fecha_fin])->get();
                }
            }
        }

        if ($tipo == 'pdf') {
            $pdf = PDF::loadView('reportes.orden_ventas', compact('orden_detalles'))->setPaper('letter', 'landscape');

            // ENUMERAR LAS PÁGINAS USANDO CANVAS
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();
            $canvas = $dom_pdf->get_canvas();
            $alto = $canvas->get_height();
            $ancho = $canvas->get_width();
            $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 9, array(0, 0, 0));

            return $pdf->stream('orden_ventas.pdf');
        }

        if ($tipo == 'excel') {
            return $this->r_orden_ventas_excel($orden_detalles);
        }
    }

    private function r_orden_ventas_excel($orden_detalles)
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator("ADMIN")
            ->setLastModifiedBy('Administración')
            ->setTitle('Reporte')
            ->setSubject('Reporte')
            ->setDescription('Reporte')
            ->setKeywords('PHPSpreadsheet')
            ->setCategory('Reporte');

        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');

        $fila = 1;
        if (file_exists(public_path() . '/imgs/' . Institucion::first()->logo)) {
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setName('logo');
            $drawing->setDescription('logo');
            $drawing->setPath(public_path() . '/imgs/' . Institucion::first()->logo); // put your path and image here
            $drawing->setCoordinates('A' . $fila);
            $drawing->setOffsetX(5);
            $drawing->setOffsetY(0);
            $drawing->setHeight(60);
            $drawing->setWorksheet($sheet);
        }

        $fila = 2;

        $sheet->setCellValue('A' . $fila, "LISTA DE ORDENDES DE VENTA");
        $sheet->mergeCells("A" . $fila . ":J" . $fila);  //COMBINAR CELDAS
        $sheet->getStyle('A' . $fila . ':J' . $fila)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A' . $fila . ':J' . $fila)->applyFromArray($this->styleTextoForm);
        $fila++;
        $fila++;
        $fila++;
        $sheet->setCellValue('A' . $fila, "No.");
        $sheet->setCellValue('B' . $fila, "Código Orden");
        $sheet->setCellValue('C' . $fila, "Descripción del Producto");
        $sheet->setCellValue('D' . $fila, "Categoría");
        $sheet->setCellValue('E' . $fila, "Tamaño del Producto");
        $sheet->setCellValue('F' . $fila, "Cantidad");
        $sheet->setCellValue('G' . $fila, "Precio S/C");
        $sheet->setCellValue('H' . $fila, "Precio Total");
        $sheet->setCellValue('I' . $fila, "Estado");
        $sheet->setCellValue('J' . $fila, "Fecha de Registro");
        $sheet->getStyle('A' . $fila . ':J' . $fila)->applyFromArray($this->styleArray2);
        $fila++;
        $cont = 1;
        $suma_cantidad = 0;
        $suma_precio_sc = 0;
        $suma_precio_total = 0;
        foreach ($orden_detalles as $od) {
            $sheet->setCellValue('A' . $fila, $cont++);
            $sheet->setCellValue('B' . $fila, $od->orden_venta->codigo);
            $sheet->setCellValue('C' . $fila, $od->producto->descripcion);
            $sheet->setCellValue('D' . $fila, $od->producto->categoria->nombre);
            $sheet->setCellValue('E' . $fila, $od->producto->producto_tamano->nombre);
            $sheet->setCellValue('F' . $fila, $od->cantidad);
            $sheet->setCellValue('G' . $fila, $od->precio_sc);
            $sheet->setCellValue('H' . $fila, $od->precio_total);
            $sheet->setCellValue('I' . $fila, $od->orden_venta->estado);
            $sheet->setCellValue('J' . $fila, $od->orden_venta->fecha_registro_t);
            $sheet->getStyle('A' . $fila . ':J' . $fila)->applyFromArray($this->estilo_conenido);
            $suma_cantidad = (float) $suma_cantidad + (float) $od->cantidad;
            $suma_precio_sc = (float) $suma_precio_sc + (float) $od->precio_sc;
            $suma_precio_total = (float) $suma_precio_total + (float) $od->precio_total;
            $fila++;
        }

        $sheet->setCellValue('E' . $fila, "TOTALES");
        $sheet->setCellValue('F' . $fila, number_format($suma_cantidad, 2, ".", ""));
        $sheet->setCellValue('G' . $fila, number_format($suma_precio_sc, 2, ".", ""));
        $sheet->setCellValue('H' . $fila, number_format($suma_precio_total, 2, ".", ""));
        $sheet->getStyle('E' . $fila . ':H' . $fila)->applyFromArray($this->styleArray2);


        $sheet->getColumnDimension('A')->setWidth(6);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(60);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(10);

        foreach (range('A', 'J') as $columnID) {
            $sheet->getStyle($columnID)->getAlignment()->setWrapText(true);
        }

        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
        $sheet->getPageMargins()->setTop(0.5);
        $sheet->getPageMargins()->setRight(0.1);
        $sheet->getPageMargins()->setLeft(0.1);
        $sheet->getPageMargins()->setBottom(0.1);
        $sheet->getPageSetup()->setPrintArea('A:J');
        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);

        // DESCARGA DEL ARCHIVO
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="orden_ventas.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function ingresos_comision()
    {
        return Inertia::render("Admin/Reportes/IngresosComision");
    }

    public function r_ingresos_comision(Request $request)
    {
        $filtro =  $request->filtro;
        $categoria_id =  $request->categoria_id;
        $producto_tamano_id =  $request->producto_tamano_id;
        $estado =  $request->estado;
        $fecha_ini =  $request->fecha_ini;
        $fecha_fin =  $request->fecha_fin;
        $tipo =  $request->tipo;
        $orden_detalles = OrdenDetalle::all();

        if ($filtro != 'todos') {
            if ($filtro == 'categoria') {
                $orden_detalles = OrdenDetalle::select("orden_detalles.*")
                    ->join("orden_ventas", "orden_ventas.id", "=", "orden_detalles.orden_venta_id")
                    ->join("productos", "productos.id", "=", "orden_detalles.producto_id");
                if ($categoria_id != 'todos') {
                    $orden_detalles->where("productos.categoria_id", $categoria_id);
                }
                if ($producto_tamano_id != 'todos') {
                    $orden_detalles->where("productos.producto_tamano_id", $producto_tamano_id);
                }
                if ($estado != 'todos') {
                    $orden_detalles->where("orden_ventas.estado", $estado);
                }
                $orden_detalles = $orden_detalles->get();
            }
            if ($filtro == 'fechas') {
                if ($fecha_ini && $fecha_fin) {
                    $orden_detalles = OrdenDetalle::select("orden_detalles.*")
                        ->join("orden_ventas", "orden_ventas.id", "=", "orden_detalles.orden_venta_id")
                        ->whereBetween('orden_ventas.fecha_registro', [$fecha_ini, $fecha_fin])->get();
                }
            }
        }

        if ($tipo == 'pdf') {
            $pdf = PDF::loadView('reportes.ingresos_comision', compact('orden_detalles'))->setPaper('letter', 'landscape');

            // ENUMERAR LAS PÁGINAS USANDO CANVAS
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();
            $canvas = $dom_pdf->get_canvas();
            $alto = $canvas->get_height();
            $ancho = $canvas->get_width();
            $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 9, array(0, 0, 0));

            return $pdf->stream('orden_ventas.pdf');
        }

        if ($tipo == 'excel') {
            return $this->r_ingresos_comision_excel($orden_detalles);
        }
    }

    private function r_ingresos_comision_excel($orden_detalles)
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator("ADMIN")
            ->setLastModifiedBy('Administración')
            ->setTitle('Reporte')
            ->setSubject('Reporte')
            ->setDescription('Reporte')
            ->setKeywords('PHPSpreadsheet')
            ->setCategory('Reporte');

        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');

        $fila = 1;
        if (file_exists(public_path() . '/imgs/' . Institucion::first()->logo)) {
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setName('logo');
            $drawing->setDescription('logo');
            $drawing->setPath(public_path() . '/imgs/' . Institucion::first()->logo); // put your path and image here
            $drawing->setCoordinates('A' . $fila);
            $drawing->setOffsetX(5);
            $drawing->setOffsetY(0);
            $drawing->setHeight(60);
            $drawing->setWorksheet($sheet);
        }

        $fila = 2;

        $sheet->setCellValue('A' . $fila, "INGRESOS POR COMISIONES");
        $sheet->mergeCells("A" . $fila . ":J" . $fila);  //COMBINAR CELDAS
        $sheet->getStyle('A' . $fila . ':J' . $fila)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A' . $fila . ':J' . $fila)->applyFromArray($this->styleTextoForm);
        $fila++;
        $fila++;
        $fila++;
        $sheet->setCellValue('A' . $fila, "No.");
        $sheet->setCellValue('B' . $fila, "Código Orden");
        $sheet->setCellValue('C' . $fila, "Descripción del Producto");
        $sheet->setCellValue('D' . $fila, "Categoría");
        $sheet->setCellValue('E' . $fila, "Tamaño del Producto");
        $sheet->setCellValue('F' . $fila, "Cantidad");
        $sheet->setCellValue('G' . $fila, "Precio S/C");
        $sheet->setCellValue('H' . $fila, "Precio Total");
        $sheet->setCellValue('I' . $fila, "Total comisión");
        $sheet->setCellValue('J' . $fila, "Fecha de Registro");
        $sheet->getStyle('A' . $fila . ':J' . $fila)->applyFromArray($this->styleArray2);
        $fila++;
        $cont = 1;
        $suma_cantidad = 0;
        $suma_precio_sc = 0;
        $suma_precio_total = 0;
        $suma_comision = 0;
        foreach ($orden_detalles as $od) {
            $comision = (float) $od->precio_total - (float) $od->precio_sc;
            $comision = round($comision, 2);
            $suma_comision = (float) $suma_comision + (float) $comision;
            $sheet->setCellValue('A' . $fila, $cont++);
            $sheet->setCellValue('B' . $fila, $od->orden_venta->codigo);
            $sheet->setCellValue('C' . $fila, $od->producto->descripcion);
            $sheet->setCellValue('D' . $fila, $od->producto->categoria->nombre);
            $sheet->setCellValue('E' . $fila, $od->producto->producto_tamano->nombre);
            $sheet->setCellValue('F' . $fila, $od->cantidad);
            $sheet->setCellValue('G' . $fila, $od->precio_sc);
            $sheet->setCellValue('H' . $fila, $od->precio_total);
            $sheet->setCellValue('I' . $fila, number_format($comision, 2, '.', ''));
            $sheet->setCellValue('J' . $fila, $od->orden_venta->fecha_registro_t);
            $sheet->getStyle('A' . $fila . ':J' . $fila)->applyFromArray($this->estilo_conenido);
            $suma_cantidad = (float) $suma_cantidad + (float) $od->cantidad;
            $suma_precio_sc = (float) $suma_precio_sc + (float) $od->precio_sc;
            $suma_precio_total = (float) $suma_precio_total + (float) $od->precio_total;
            $fila++;
        }

        $sheet->setCellValue('E' . $fila, "TOTALES");
        $sheet->setCellValue('F' . $fila, number_format($suma_cantidad, 2, ".", ""));
        $sheet->setCellValue('G' . $fila, number_format($suma_precio_sc, 2, ".", ""));
        $sheet->setCellValue('H' . $fila, number_format($suma_precio_total, 2, ".", ""));
        $sheet->setCellValue('I' . $fila, number_format($suma_comision, 2, ".", ""));
        $sheet->getStyle('E' . $fila . ':I' . $fila)->applyFromArray($this->styleArray2);


        $sheet->getColumnDimension('A')->setWidth(6);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(60);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(10);

        foreach (range('A', 'J') as $columnID) {
            $sheet->getStyle($columnID)->getAlignment()->setWrapText(true);
        }

        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
        $sheet->getPageMargins()->setTop(0.5);
        $sheet->getPageMargins()->setRight(0.1);
        $sheet->getPageMargins()->setLeft(0.1);
        $sheet->getPageMargins()->setBottom(0.1);
        $sheet->getPageSetup()->setPrintArea('A:J');
        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);

        // DESCARGA DEL ARCHIVO
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="ingreso_comision.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function afiliados()
    {
        return Inertia::render("Admin/Reportes/Afiliados");
    }

    public function r_afiliados(Request $request)
    {
        $filtro =  $request->filtro;
        $fecha_ini =  $request->fecha_ini;
        $fecha_fin =  $request->fecha_fin;
        $tipo =  $request->tipo;
        $afiliados = User::where("tipo", "AFILIADO")->get();

        if ($filtro != 'todos') {
            if ($filtro == 'fechas') {
                if ($fecha_ini && $fecha_fin) {
                    $afiliados = User::where("tipo", "AFILIADO")->whereBetween('fecha_registro', [$fecha_ini, $fecha_fin])->get();
                }
            }
        }

        if ($tipo == 'pdf') {
            $pdf = PDF::loadView('reportes.afiliados', compact('afiliados'))->setPaper('letter', 'landscape');

            // ENUMERAR LAS PÁGINAS USANDO CANVAS
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();
            $canvas = $dom_pdf->get_canvas();
            $alto = $canvas->get_height();
            $ancho = $canvas->get_width();
            $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 9, array(0, 0, 0));

            return $pdf->stream('afiliados.pdf');
        }

        if ($tipo == 'excel') {
            return $this->r_afiliados_excel($afiliados);
        }
    }

    private function r_afiliados_excel($afiliados)
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator("ADMIN")
            ->setLastModifiedBy('Administración')
            ->setTitle('Reporte')
            ->setSubject('Reporte')
            ->setDescription('Reporte')
            ->setKeywords('PHPSpreadsheet')
            ->setCategory('Reporte');

        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');

        $fila = 1;
        if (file_exists(public_path() . '/imgs/' . Institucion::first()->logo)) {
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setName('logo');
            $drawing->setDescription('logo');
            $drawing->setPath(public_path() . '/imgs/' . Institucion::first()->logo); // put your path and image here
            $drawing->setCoordinates('A' . $fila);
            $drawing->setOffsetX(5);
            $drawing->setOffsetY(0);
            $drawing->setHeight(60);
            $drawing->setWorksheet($sheet);
        }

        $fila = 2;

        $sheet->setCellValue('A' . $fila, "LISTA DE AFILIADOS");
        $sheet->mergeCells("A" . $fila . ":J" . $fila);  //COMBINAR CELDAS
        $sheet->getStyle('A' . $fila . ':J' . $fila)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A' . $fila . ':J' . $fila)->applyFromArray($this->styleTextoForm);
        $fila++;
        $fila++;
        $fila++;
        $sheet->setCellValue('A' . $fila, "No.");
        $sheet->setCellValue('B' . $fila, "Nombre completo");
        $sheet->setCellValue('C' . $fila, "C.I.");
        $sheet->setCellValue('D' . $fila, "Dirección");
        $sheet->setCellValue('E' . $fila, "Email");
        $sheet->setCellValue('F' . $fila, "Teléfono");
        $sheet->setCellValue('G' . $fila, "Banco");
        $sheet->setCellValue('H' . $fila, "Nro. cuenta");
        $sheet->setCellValue('I' . $fila, "Acceso");
        $sheet->setCellValue('J' . $fila, "Fecha de Registro");
        $sheet->getStyle('A' . $fila . ':J' . $fila)->applyFromArray($this->styleArray2);
        $fila++;
        $cont = 1;
        foreach ($afiliados as $afiliado) {
            $sheet->setCellValue('A' . $fila, $cont++);
            $sheet->setCellValue('B' . $fila, $afiliado->full_name);
            $sheet->setCellValue('C' . $fila, $afiliado->full_ci);
            $sheet->setCellValue('D' . $fila, $afiliado->dir);
            $sheet->setCellValue('E' . $fila, $afiliado->email);
            $sheet->setCellValue('F' . $fila, $afiliado->fono);
            $sheet->setCellValue('G' . $fila, $afiliado->afiliado->banco);
            $sheet->setCellValue('H' . $fila, $afiliado->afiliado->nro_cuenta);
            $sheet->setCellValue('I' . $fila, $afiliado->acceso == 1 ? 'HABILITADO' : 'DENEGADO');
            $sheet->setCellValue('J' . $fila, $afiliado->fecha_registro_t);
            $sheet->getStyle('A' . $fila . ':J' . $fila)->applyFromArray($this->estilo_conenido);
            $fila++;
        }

        $sheet->getColumnDimension('A')->setWidth(6);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(10);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(10);

        foreach (range('A', 'J') as $columnID) {
            $sheet->getStyle($columnID)->getAlignment()->setWrapText(true);
        }

        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
        $sheet->getPageMargins()->setTop(0.5);
        $sheet->getPageMargins()->setRight(0.1);
        $sheet->getPageMargins()->setLeft(0.1);
        $sheet->getPageMargins()->setBottom(0.1);
        $sheet->getPageSetup()->setPrintArea('A:J');
        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);

        // DESCARGA DEL ARCHIVO
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="afiliados.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function clientes()
    {
        return Inertia::render("Admin/Reportes/Clientes");
    }

    public function r_clientes(Request $request)
    {
        $filtro =  $request->filtro;
        $fecha_ini =  $request->fecha_ini;
        $fecha_fin =  $request->fecha_fin;
        $tipo =  $request->tipo;
        $clientes = User::where("tipo", "CLIENTE")->get();

        if ($filtro != 'todos') {
            if ($filtro == 'fechas') {
                if ($fecha_ini && $fecha_fin) {
                    $clientes = User::where("tipo", "CLIENTE")->whereBetween('fecha_registro', [$fecha_ini, $fecha_fin])->get();
                }
            }
        }

        if ($tipo == 'pdf') {
            $pdf = PDF::loadView('reportes.clientes', compact('clientes'))->setPaper('letter', 'landscape');

            // ENUMERAR LAS PÁGINAS USANDO CANVAS
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();
            $canvas = $dom_pdf->get_canvas();
            $alto = $canvas->get_height();
            $ancho = $canvas->get_width();
            $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 9, array(0, 0, 0));

            return $pdf->stream('clientes.pdf');
        }

        if ($tipo == 'excel') {
            return $this->r_clientes_excel($clientes);
        }
    }

    private function r_clientes_excel($clientes)
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator("ADMIN")
            ->setLastModifiedBy('Administración')
            ->setTitle('Reporte')
            ->setSubject('Reporte')
            ->setDescription('Reporte')
            ->setKeywords('PHPSpreadsheet')
            ->setCategory('Reporte');

        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');

        $fila = 1;
        if (file_exists(public_path() . '/imgs/' . Institucion::first()->logo)) {
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setName('logo');
            $drawing->setDescription('logo');
            $drawing->setPath(public_path() . '/imgs/' . Institucion::first()->logo); // put your path and image here
            $drawing->setCoordinates('A' . $fila);
            $drawing->setOffsetX(5);
            $drawing->setOffsetY(0);
            $drawing->setHeight(60);
            $drawing->setWorksheet($sheet);
        }

        $fila = 2;

        $sheet->setCellValue('A' . $fila, "LISTA DE CLIENTES");
        $sheet->mergeCells("A" . $fila . ":H" . $fila);  //COMBINAR CELDAS
        $sheet->getStyle('A' . $fila . ':H' . $fila)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A' . $fila . ':H' . $fila)->applyFromArray($this->styleTextoForm);
        $fila++;
        $fila++;
        $fila++;
        $sheet->setCellValue('A' . $fila, "No.");
        $sheet->setCellValue('B' . $fila, "Nombre completo");
        $sheet->setCellValue('C' . $fila, "C.I.");
        $sheet->setCellValue('D' . $fila, "Dirección");
        $sheet->setCellValue('E' . $fila, "Email");
        $sheet->setCellValue('F' . $fila, "Teléfono");
        $sheet->setCellValue('G' . $fila, "Acceso");
        $sheet->setCellValue('H' . $fila, "Fecha de Registro");
        $sheet->getStyle('A' . $fila . ':H' . $fila)->applyFromArray($this->styleArray2);
        $fila++;
        $cont = 1;
        foreach ($clientes as $cliente) {
            $sheet->setCellValue('A' . $fila, $cont++);
            $sheet->setCellValue('B' . $fila, $cliente->full_name);
            $sheet->setCellValue('C' . $fila, $cliente->full_ci);
            $sheet->setCellValue('D' . $fila, $cliente->dir);
            $sheet->setCellValue('E' . $fila, $cliente->email);
            $sheet->setCellValue('F' . $fila, $cliente->fono);
            $sheet->setCellValue('G' . $fila, $cliente->acceso == 1 ? 'HABILITADO' : 'DENEGADO');
            $sheet->setCellValue('H' . $fila, $cliente->fecha_registro_t);
            $sheet->getStyle('A' . $fila . ':H' . $fila)->applyFromArray($this->estilo_conenido);
            $fila++;
        }

        $sheet->getColumnDimension('A')->setWidth(6);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(10);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(10);

        foreach (range('A', 'H') as $columnID) {
            $sheet->getStyle($columnID)->getAlignment()->setWrapText(true);
        }

        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
        $sheet->getPageMargins()->setTop(0.5);
        $sheet->getPageMargins()->setRight(0.1);
        $sheet->getPageMargins()->setLeft(0.1);
        $sheet->getPageMargins()->setBottom(0.1);
        $sheet->getPageSetup()->setPrintArea('A:H');
        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);

        // DESCARGA DEL ARCHIVO
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="clientes.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function e_orden_ventas()
    {
        return Inertia::render("Admin/Reportes/EOrdenVentas");
    }
    public function r_e_orden_ventas(Request $request)
    {
        $filtro =  $request->filtro;
        $categoria_id =  $request->categoria_id;
        $estado =  $request->estado;
        $fecha_ini =  $request->fecha_ini;
        $fecha_fin =  $request->fecha_fin;
        $tipo =  $request->tipo;
        $orden_detalles = OrdenDetalle::all();

        if ($filtro != 'todos') {
            if ($filtro == 'categoria') {
                $orden_detalles = OrdenDetalle::select("orden_detalles.*")
                    ->join("orden_ventas", "orden_ventas.id", "=", "orden_detalles.orden_venta_id")
                    ->join("productos", "productos.id", "=", "orden_detalles.producto_id");
                if ($categoria_id != 'todos') {
                    $orden_detalles->where("productos.categoria_id", $categoria_id);
                }
                if ($estado != 'todos') {
                    $orden_detalles->where("orden_ventas.estado", $estado);
                }
                $orden_detalles = $orden_detalles->get();
            }
            if ($filtro == 'fechas') {
                if ($fecha_ini && $fecha_fin) {
                    $orden_detalles = OrdenDetalle::select("orden_detalles.*")
                        ->join("orden_ventas", "orden_ventas.id", "=", "orden_detalles.orden_venta_id")
                        ->whereBetween('orden_ventas.fecha_registro', [$fecha_ini, $fecha_fin])->get();
                }
            }
        }

        if ($tipo == 'pdf') {
            $pdf = PDF::loadView('reportes.e_orden_ventas', compact('orden_detalles'))->setPaper('letter', 'landscape');

            // ENUMERAR LAS PÁGINAS USANDO CANVAS
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();
            $canvas = $dom_pdf->get_canvas();
            $alto = $canvas->get_height();
            $ancho = $canvas->get_width();
            $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 9, array(0, 0, 0));

            return $pdf->stream('e_orden_ventas.pdf');
        }

        if ($tipo == 'excel') {
            return $this->r_e_orden_ventas_excel($orden_detalles);
        }
    }

    private function r_e_orden_ventas_excel($orden_detalles)
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator("ADMIN")
            ->setLastModifiedBy('Administración')
            ->setTitle('Reporte')
            ->setSubject('Reporte')
            ->setDescription('Reporte')
            ->setKeywords('PHPSpreadsheet')
            ->setCategory('Reporte');

        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');

        $fila = 1;
        if (file_exists(public_path() . '/imgs/' . Institucion::first()->logo)) {
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setName('logo');
            $drawing->setDescription('logo');
            $drawing->setPath(public_path() . '/imgs/' . Institucion::first()->logo); // put your path and image here
            $drawing->setCoordinates('A' . $fila);
            $drawing->setOffsetX(5);
            $drawing->setOffsetY(0);
            $drawing->setHeight(60);
            $drawing->setWorksheet($sheet);
        }
        $fila = 2;
        $sheet->setCellValue('A' . $fila, "ESTADO DE ORDENDES DE VENTA");
        $sheet->mergeCells("A" . $fila . ":J" . $fila);  //COMBINAR CELDAS
        $sheet->getStyle('A' . $fila . ':J' . $fila)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A' . $fila . ':J' . $fila)->applyFromArray($this->styleTextoForm);
        $fila++;
        $fila++;
        $fila++;
        $sheet->setCellValue('A' . $fila, "No.");
        $sheet->setCellValue('B' . $fila, "Código Orden");
        $sheet->setCellValue('C' . $fila, "Descripción del Producto");
        $sheet->setCellValue('D' . $fila, "Categoría");
        $sheet->setCellValue('E' . $fila, "Tamaño del Producto");
        $sheet->setCellValue('F' . $fila, "Cantidad");
        $sheet->setCellValue('G' . $fila, "Precio S/C");
        $sheet->setCellValue('H' . $fila, "Precio Total");
        $sheet->setCellValue('I' . $fila, "Estado");
        $sheet->setCellValue('J' . $fila, "Fecha de Registro");
        $sheet->getStyle('A' . $fila . ':J' . $fila)->applyFromArray($this->styleArray2);
        $fila++;
        $cont = 1;
        $suma_cantidad = 0;
        $suma_precio_sc = 0;
        $suma_precio_total = 0;
        foreach ($orden_detalles as $od) {
            $sheet->setCellValue('A' . $fila, $cont++);
            $sheet->setCellValue('B' . $fila, $od->orden_venta->codigo);
            $sheet->setCellValue('C' . $fila, $od->producto->descripcion);
            $sheet->setCellValue('D' . $fila, $od->producto->categoria->nombre);
            $sheet->setCellValue('E' . $fila, $od->producto->producto_tamano->nombre);
            $sheet->setCellValue('F' . $fila, $od->cantidad);
            $sheet->setCellValue('G' . $fila, $od->precio_sc);
            $sheet->setCellValue('H' . $fila, $od->precio_total);
            $sheet->setCellValue('I' . $fila, $od->orden_venta->estado);
            $sheet->setCellValue('J' . $fila, $od->orden_venta->fecha_registro_t);
            $sheet->getStyle('A' . $fila . ':J' . $fila)->applyFromArray($this->estilo_conenido);

            if ($od->orden_venta->estado == 'DEVOLUCIÓN') {
                $sheet->getStyle('I' . $fila)->applyFromArray($this->devolucion);
            }
            if ($od->orden_venta->estado == 'ENTREGADO') {
                $sheet->getStyle('I' . $fila)->applyFromArray($this->entregado);
            }
            if ($od->orden_venta->estado == 'ENTREGA PENDIENTE') {
                $sheet->getStyle('I' . $fila)->applyFromArray($this->pendiente);
            }

            $suma_cantidad = (float) $suma_cantidad + (float) $od->cantidad;
            $suma_precio_sc = (float) $suma_precio_sc + (float) $od->precio_sc;
            $suma_precio_total = (float) $suma_precio_total + (float) $od->precio_total;
            $fila++;
        }

        // $sheet->setCellValue('E' . $fila, "TOTALES");
        // $sheet->setCellValue('F' . $fila, number_format($suma_cantidad, 2, ".", ""));
        // $sheet->setCellValue('G' . $fila, number_format($suma_precio_sc, 2, ".", ""));
        // $sheet->setCellValue('H' . $fila, number_format($suma_precio_total, 2, ".", ""));
        // $sheet->getStyle('E' . $fila . ':H' . $fila)->applyFromArray($this->styleArray2);


        $sheet->getColumnDimension('A')->setWidth(6);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(60);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(10);

        foreach (range('A', 'J') as $columnID) {
            $sheet->getStyle($columnID)->getAlignment()->setWrapText(true);
        }

        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
        $sheet->getPageMargins()->setTop(0.5);
        $sheet->getPageMargins()->setRight(0.1);
        $sheet->getPageMargins()->setLeft(0.1);
        $sheet->getPageMargins()->setBottom(0.1);
        $sheet->getPageSetup()->setPrintArea('A:J');
        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);

        // DESCARGA DEL ARCHIVO
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="orden_ventas.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function g_orden_ventas()
    {
        return Inertia::render("Admin/Reportes/GOrdenVentas");
    }

    public function r_g_orden_ventas(Request $request)
    {
        $filtro =  $request->filtro;
        $categoria_id =  $request->categoria_id;
        $estado =  $request->estado;
        $fecha_ini =  $request->fecha_ini;
        $fecha_fin =  $request->fecha_fin;
        $productos = Producto::all();

        if ($filtro != 'todos') {
            $productos = Producto::select("productos.*");
            $productos->join("orden_detalles", "orden_detalles.producto_id", "=", "productos.id")
                ->join("orden_ventas", "orden_ventas.id", "=", "orden_detalles.orden_venta_id");
            if ($filtro == 'categoria') {
                if ($estado != 'todos') {
                    $productos->where("orden_ventas.estado", $estado);
                }
                if ($categoria_id != 'todos') {
                    $productos->where("productos.categoria_id", $categoria_id);
                }
            }
            if ($filtro == 'fechas') {
                if ($fecha_ini && $fecha_fin) {
                    $productos->where("orden_ventas.fecha_registro", [$fecha_ini, $fecha_fin]);
                }
            }
            $productos = $productos->get();
        }

        $categories = [];
        $series = [
            [
                "name" => "CANTIDAD",
                "data" => [],
            ],
            [
                "name" => "TOTAL MONTO",
                "data" => [],
            ],
        ];

        $suma_total_cantidad = 0;
        $suma_total_monto = 0;
        foreach ($productos as $p) {
            $categories[]  = $p->descripcion;
            $orden_detalles = OrdenDetalle::where("producto_id", $p->id)->get();
            $total_monto = $orden_detalles->sum("precio_total");
            $total_cantidad = $orden_detalles->sum("cantidad");
            $series[0]["data"][] = (float)$total_cantidad;
            $series[1]["data"][] = (float)$total_monto;

            $suma_total_cantidad = (float)$suma_total_cantidad + $total_cantidad;
            $suma_total_monto = (float)$suma_total_monto + $total_monto;
        }


        return response()->JSON([
            "categories" => $categories,
            "series" => $series,
            "suma_total_cantidad" => number_format($suma_total_cantidad, 0, ".", ""),
            "suma_total_monto" => number_format($suma_total_monto, 2, ".", ""),
        ]);
    }

    public function g_ingresos_comision()
    {
        return Inertia::render("Admin/Reportes/GIngresosComision");
    }

    public function r_g_ingresos_comision(Request $request)
    {
        $filtro =  $request->filtro;
        $categoria_id =  $request->categoria_id;
        $producto_tamano_id =  $request->producto_tamano_id;
        $estado =  $request->estado;
        $fecha_ini =  $request->fecha_ini;
        $fecha_fin =  $request->fecha_fin;
        $productos = Producto::all();

        if ($filtro != 'todos') {
            $productos = Producto::select("productos.*");
            $productos->join("orden_detalles", "orden_detalles.producto_id", "=", "productos.id")
                ->join("orden_ventas", "orden_ventas.id", "=", "orden_detalles.orden_venta_id");
            if ($filtro == 'categoria') {
                if ($estado != 'todos') {
                    $productos->where("orden_ventas.estado", $estado);
                }
                if ($categoria_id != 'todos') {
                    $productos->where("productos.categoria_id", $categoria_id);
                }
                if ($producto_tamano_id != 'todos') {
                    $productos->where("productos.producto_tamano_id", $producto_tamano_id);
                }
            }
            if ($filtro == 'fechas') {
                if ($fecha_ini && $fecha_fin) {
                    $productos->where("orden_ventas.fecha_registro", [$fecha_ini, $fecha_fin]);
                }
            }
            $productos = $productos->get();
        }

        $categories = [];
        $series = [
            [
                "name" => "CANTIDAD",
                "data" => [],
            ],
            [
                "name" => "TOTAL COMISIÓN",
                "data" => [],
            ],
        ];

        $suma_total_cantidad = 0;
        $suma_total_monto = 0;
        foreach ($productos as $p) {
            $categories[]  = $p->descripcion;
            $orden_detalles = OrdenDetalle::where("producto_id", $p->id)->get();
            $total_monto_sc = $orden_detalles->sum("precio_sc");
            $total_monto = $orden_detalles->sum("precio_total");
            $total_cantidad = $orden_detalles->sum("cantidad");
            $series[0]["data"][] = (float)$total_cantidad;
            $series[1]["data"][] = (float)(number_format((float)$total_monto - (float)$total_monto_sc, 2, ".", ""));

            $suma_total_cantidad = (float)$suma_total_cantidad + $total_cantidad;
            $suma_total_monto = (float)$suma_total_monto + $total_monto;
        }

        return response()->JSON([
            "categories" => $categories,
            "series" => $series,
            "suma_total_cantidad" => number_format($suma_total_cantidad, 0, ".", ""),
            "suma_total_monto" => number_format($suma_total_monto, 2, ".", ""),
        ]);
    }
}
