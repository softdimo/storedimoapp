<?php

namespace App\Http\Responsable\existencias;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdf\FPDF;

class ReporteBajasPdf implements Responsable
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
        $bajas = $this->reporteBajasPdf($fechaInicial, $fechaFinal);

        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);

        // Título
        $pdf->Cell(190, 10, "REPORTE BAJAS", 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(190, 10, "Desde: $fechaInicial hasta $fechaFinal", 0, 1, 'C');
        $pdf->Ln(5);

        // Encabezado de tabla
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(15, 10, utf8_decode("Código"), 1);
        $pdf->Cell(45, 10, "Producto", 1);
        $pdf->Cell(25, 10, utf8_decode("Categoría"), 1);
        $pdf->Cell(25, 10, "Referencia", 1);
        $pdf->Cell(40, 10, "Fecha Baja", 1);
        $pdf->Cell(20, 10, "Cantidad", 1);
        $pdf->Cell(20, 10, "Tipo Baja", 1);
        $pdf->Ln();

        // Datos de compras
        $pdf->SetFont('Arial', '', 10);
        foreach ($bajas as $baja) {
            $pdf->Cell(15, 10, $baja->id_producto, 1);
            $pdf->Cell(45, 10, utf8_decode(substr($baja->nombre_producto, 0, 30)), 1);
            $pdf->Cell(25, 10, utf8_decode(substr($baja->categoria, 0, 20)), 1);
            $pdf->Cell(25, 10, substr($baja->referencia, 0, 15), 1);
            $pdf->Cell(40, 10, $baja->fecha_baja, 1);
            $pdf->Cell(20, 10, $baja->cantidad, 1);
            $pdf->Cell(20, 10, utf8_decode(substr($baja->tipo_baja, 0, 20)), 1);
            $pdf->Ln();
        }

        // Salida del PDF
        $pdf->Output();
        exit;
    }

    // ===================================================================
    // ===================================================================

    public function reporteBajasPdf($fechaInicial, $fechaFinal)
    {
        try {
            $peticionReporteBajasPdf = $this->clientApi->post($this->baseUri . 'reporte_bajas_pdf', [
                'json' => [
                    'fecha_inicial' => $fechaInicial,
                    'fecha_final' => $fechaFinal,
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);
            return json_decode($peticionReporteBajasPdf->getBody()->getContents());
        } catch (Exception $e) {
            alert()->error('Error', 'Exception reporteBajasPdf, contacte a Soporte.');
            return back();
        }
    }
}
