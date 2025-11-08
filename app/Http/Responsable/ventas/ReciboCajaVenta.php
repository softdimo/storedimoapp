<?php

namespace App\Http\Responsable\ventas;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class ReciboCajaVenta implements Responsable
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
        $venta = $request->all(); // Recibe los datos enviados desde JavaScript

        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);

        // Encabezado
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->Cell(190, 10, "RECIBO VENTA", 0, 1, 'C');

        // Información de la venta
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(95, 6, utf8_decode('Recibo de caja número: ') . $venta['id'], 0, 0, 'L');
        $pdf->Cell(95, 6, 'Fecha: ' . $venta['fecha'], 0, 1, 'R');
        $pdf->Ln(3);
        $pdf->Cell(190, 6, 'Atendido por: ' . utf8_decode($venta['usuario']), 0, 1, 'L');
        $pdf->Cell(190, 6, 'Cliente: ' . utf8_decode($venta['cliente']), 0, 1, 'L');

        // Detalles de la venta
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(30, 6, utf8_decode('Código'), 1, 0, 'C');
        $pdf->Cell(70, 6, 'Producto', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Cantidad', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Precio', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Subtotal', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 10);
        foreach ($venta['detalles'] as $producto) {
            $pdf->Cell(30, 6, $producto['id_producto'], 1, 0, 'C');
            $pdf->Cell(70, 6, utf8_decode($producto['nombre_producto']), 1, 0, 'C');
            $pdf->Cell(30, 6, $producto['cantidad'], 1, 0, 'C');
            $pdf->Cell(30, 6, '$ ' . number_format($producto['precio_venta'], 2), 1, 0, 'R');
            $pdf->Cell(30, 6, '$ ' . number_format($producto['subtotal'], 2), 1, 1, 'R');
        }

        // Información final
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(95, 6, 'Tipo de pago: Contado', 0, 0, 'L');
        $pdf->Cell(95, 6, 'Descuento: $ ' . number_format($venta['descuento'], 2), 0, 1, 'R');

        // Total de entradas
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(190, 10, 'Valor total a pagar: $ ' . number_format($venta['total'], 2), 0, 1, 'C');

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Cell(190, 6, 'Gracias por su compra', 0, 1, 'C');

        // Enviar el PDF como respuesta
        return response($pdf->Output('S'), 200)->header('Content-Type', 'application/pdf');
    }
}
