<?php

namespace App\Http\Responsable\ventas;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class ReporteVentasPdf implements Responsable
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
        $fechaInicial = request('fecha_inicial', null);
        $fechaFinal = request('fecha_final', null);

        // Consulta a la BD
        $datosVentas = $this->reporteVentasPdf($fechaInicial,$fechaFinal);

        // Extraer ventas y total
        $ventas = $datosVentas->ventas;
        $total = $datosVentas->total;

        $pdf = new \FPDF('L');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);

        // Título
        $pdf->Cell(277, 10, "INFORME DE VENTAS", 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(277, 10, "Desde: $fechaInicial hasta $fechaFinal", 0, 1, 'C');
        $pdf->Ln(5);

        // Encabezado de tabla
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 10, utf8_decode("Código"), 1, 0, 'C');
        $pdf->Cell(40, 10, "Fecha Venta", 1, 0, 'C');
        $pdf->Cell(35, 10, "Subtotal Venta", 1, 0, 'C');
        $pdf->Cell(25, 10, "Descuento", 1, 0, 'C');
        $pdf->Cell(35, 10, "Total Venta", 1, 0, 'C');
        $pdf->Cell(50, 10, utf8_decode("Cliente"), 1, 0, 'C');
        $pdf->Cell(25, 10, utf8_decode("Tipo Pago"), 1, 0, 'C');
        $pdf->Cell(50, 10, utf8_decode("Vendedor"), 1, 0, 'C');
        $pdf->Ln();

        // Datos de compras
        $pdf->SetFont('Arial', '', 10);
        foreach ($ventas as $venta) {
            $pdf->Cell(20, 10, $venta->id_venta, 1);
            $pdf->Cell(40, 10, $venta->fecha_venta, 1);
            $pdf->Cell(35, 10, "$ " . number_format($venta->subtotal_venta, 2), 1, 0, 'R');
            $pdf->Cell(25, 10, "$ " . number_format($venta->descuento, 2), 1, 0, 'R');
            $pdf->Cell(35, 10, "$ " . number_format($venta->total_venta, 2), 1, 0, 'R');
            $pdf->Cell(50, 10, utf8_decode($venta->nombres_cliente), 1);
            $pdf->Cell(25, 10, utf8_decode($venta->tipo_pago), 1);
            $pdf->Cell(50, 10, utf8_decode($venta->vendedor), 1);
            $pdf->Ln();
        }

        // Total de entradas
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->Cell(277, 10, "Total Venta: $ " . number_format($total, 2), 0, 1, 'C');

        // Salida del PDF
        $pdf->Output();
        exit;
    }

    // ===================================================================
    // ===================================================================

    public function reporteVentasPdf($fechaInicial,$fechaFinal)
    {
        try {
            $peticionReporteVentasPdf = $this->clientApi->post($this->baseUri.'reporte_ventas_pdf', [
                'json' => [
                    'fecha_inicial' => $fechaInicial,
                    'fecha_final' => $fechaFinal,
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);
            return json_decode($peticionReporteVentasPdf->getBody()->getContents());
        } catch (Exception $e) {
            alert()->error('Error', 'Exception reporteVentasPdf, contacte a Soporte.');
            return back();
        }
    }
}
