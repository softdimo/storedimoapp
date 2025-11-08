<?php

namespace App\Http\Responsable\productos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdf\FPDF;
use Carbon\Carbon;


class ReporteProductosPdf implements Responsable
{
    protected $baseUri;
    protected $clientApi;

    public function __construct()
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
    }

    // ===================================================================
    // ===================================================================

    public function toResponse($request)
    {
        // Obtiene la fecha y hora actual
        $fechaReporte = Carbon::now()->format('d/m/Y H:i:s');

        // Consulta a la BD
        $productos = $this->reporteProductosPdf();

        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);

         // Encabezado
        //  $pdf->Cell(190, 10, 'STOREDIMO', 0, 1, 'C');
        //  $pdf->SetFont('Arial', '', 10);
        //  $pdf->Cell(190, 6, 'Nit: 123456789-0', 0, 1, 'C');
        //  $pdf->Cell(190, 6, utf8_decode('Centro Comercial Cisneros'), 0, 1, 'C');
        //  $pdf->Cell(190, 6, utf8_decode('Teléfono: 513-10-12'), 0, 1, 'C');
        //  $pdf->Cell(190, 6, utf8_decode('Cra. 51 N° 44 - 69, Local 144 B - Medellín'), 0, 1, 'C');

        // Título
        $pdf->Cell(190, 10, "INFORME PRODUCTOS", 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(190, 10, "Fecha Reporte: $fechaReporte", 0, 1, 'C');
        $pdf->Ln(5);
  
        // Encabezado de tabla
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(15, 10, utf8_decode("Ref"), 1, 0, 'C');
        $pdf->Cell(50, 10, utf8_decode("Producto"), 1, 0, 'C');
        $pdf->Cell(30, 10, utf8_decode("Categoría"), 1, 0, 'C');
        $pdf->Cell(20, 10, utf8_decode("Cantidad"), 1, 0, 'C');

        // Guardamos la posición inicial
        $x = $pdf->GetX();
        $y = $pdf->GetY();

        // Precio Unitario
        $pdf->MultiCell(25, 5, utf8_decode("Precio\nUnitario"), 1, 'C');
        $pdf->SetXY($x + 25, $y); // Restaurar posición

        // Precio Detal
        $x = $pdf->GetX();
        $pdf->MultiCell(25, 5, utf8_decode("Precio\nal Detal"), 1, 'C');
        $pdf->SetXY($x + 25, $y); // Restaurar posición

        // Precio por Mayor
        // $x = $pdf->GetX();
        $pdf->MultiCell(25, 5, utf8_decode("Precio\npor Mayor"), 1, 'C');

        // Ajustar posición Y después de MultiCell para que el contenido comience justo debajo
        $pdf->SetY($y + 10);

        // Datos de Productos
        $pdf->SetFont('Arial', '', 10);
        foreach ($productos as $producto) {
            $pdf->Cell(15, 10, $producto->referencia, 1, 0, 'C');
            $pdf->Cell(50, 10, utf8_decode($producto->nombre_producto), 1, 0, 'C');
            $pdf->Cell(30, 10, utf8_decode($producto->categoria), 1, 0, 'C');
            $pdf->Cell(20, 10, utf8_decode($producto->cantidad), 1, 0, 'C');
            $pdf->Cell(25, 10, "$ " . number_format($producto->precio_unitario, 2), 1, 0, 'C');
            $pdf->Cell(25, 10, "$ " . number_format($producto->precio_detal, 2), 1, 0, 'C');
            $pdf->Cell(25, 10, "$ " . number_format($producto->precio_por_mayor, 2), 1, 0, 'C');
            $pdf->Ln();
        }

        // Salida del PDF
        $pdf->Output();
        exit;
    }

    // ===================================================================
    // ===================================================================

    public function reporteProductosPdf()
    {
        try {
            $peticionReporteProductosPdf = $this->clientApi->get($this->baseUri.'reporte_productos_pdf', [
                'json' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);

            return json_decode($peticionReporteProductosPdf->getBody()->getContents());

        } catch (Exception $e) {
            alert()->error('Error', 'Exception reporteProductosPdf, contacte a Soporte.');
            return back();
        }
    }
}
