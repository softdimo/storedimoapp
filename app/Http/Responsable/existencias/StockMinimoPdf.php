<?php

namespace App\Http\Responsable\existencias;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdf\FPDF;
use Carbon\Carbon;

class StockMinimoPdf implements Responsable
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
        $productos = $request->input('productos'); // Recibe la lista de productos
        $fechaReporte = Carbon::now()->format('d/m/Y H:i:s');

        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);

        // Encabezado
        // $pdf->Cell(190, 10, 'STOREDIMO', 0, 1, 'C');
        // $pdf->SetFont('Arial', '', 10);
        // $pdf->Cell(190, 6, 'Nit: 123456789-0', 0, 1, 'C');
        // $pdf->Cell(190, 6, utf8_decode('Centro Comercial Cisneros'), 0, 1, 'C');
        // $pdf->Cell(190, 6, utf8_decode('Teléfono: 513-10-12'), 0, 1, 'C');
        // $pdf->Cell(190, 6, utf8_decode('Cra. 51 N° 44 - 69, Local 144 B - Medellín'), 0, 1, 'C');
        
        // Título
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(190, 10, utf8_decode("INFORME STOCK MÍNIMO"), 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(190, 10, "Fecha Reporte: $fechaReporte", 0, 1, 'C');
        $pdf->Ln(5);

        // Títulos de tabla
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(30, 6, utf8_decode('Código'), 1, 0, 'C');
        $pdf->Cell(70, 6, 'Producto', 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode('Categoría'), 1, 0, 'C');
        $pdf->Cell(30, 6, 'Cantidad', 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode('Stock Mínimo'), 1, 1, 'C');

        $pdf->SetFont('Arial', '', 10);

        // Recorrer productos y agregarlos a la tabla
        foreach ($productos as $producto) {
            $pdf->Cell(30, 6, $producto['id'], 1, 0, 'C');
            $pdf->Cell(70, 6, utf8_decode($producto['producto']), 1, 0, 'C');
            $pdf->Cell(30, 6, utf8_decode($producto['categoria']), 1, 0, 'C');
            $pdf->Cell(30, 6, $producto['cantidad'], 1, 0, 'C');
            $pdf->Cell(30, 6, $producto['stock_minimo'], 1, 1, 'C');
        }

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Cell(190, 6, 'Gracias por su visita', 0, 1, 'C');

        // Enviar el PDF como respuesta
        return response($pdf->Output('S'), 200)->header('Content-Type', 'application/pdf');
    }
}
