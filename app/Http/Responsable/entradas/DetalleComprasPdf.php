<?php

namespace App\Http\Responsable\entradas;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdf\FPDF;
use App\Models\Compra;
use App\Models\CompraProducto;

class DetalleComprasPdf implements Responsable
{
    protected $baseUri;
    protected $clientApi;
    protected $idCompra;

    public function __construct($idCompra)
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
        $this->idCompra = $idCompra;
    }

    // ===================================================================
    // ===================================================================

    public function toResponse($request)
    {
        $idCompra = $this->idCompra;

        // Consultar Detalle Compra Producto
        $compra = $this->detalleCompraProductoPdf($idCompra);
     
        // Verificar si hay datos
        if (!$compra || count($compra) == 0) {
            abort(404, 'Compra no encontrada');
        }

        // Obtener datos generales de la compra (desde el primer elemento del array)
        $idCompra = $compra[0]->id_compra;
        $facturaCompra = $compra[0]->factura_compra;
        $fechaCompra = $compra[0]->fecha_compra;
        $valorCompra = $compra[0]->valor_compra;
        $idEstado = $compra[0]->id_estado ?? 1; // Si no viene, asumimos estado activo
        $nombreEmpresa = $compra[0]->proveedor_juridico ?? $compra[0]->nombres_proveedor .' '. $compra[0]->apellidos_proveedor;

        // Crear instancia de FPDF
        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);

        // Título principal
        $pdf->Cell(0, 10, utf8_decode('REPORTE COMPRAS'), 0, 1, 'C');
        $pdf->Ln(5); // Espacio

        // Código de la compra
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, utf8_decode('Factura Compra: ') . $facturaCompra, 0, 1, 'C');
        $pdf->Cell(0, 10, utf8_decode('Detalle de Compra Código: ') . $idCompra, 0, 1, 'C');
        $pdf->Ln(3);

        // Estado de la compra
        if ($idEstado == 0) {
            $pdf->SetTextColor(255, 0, 0); // Rojo
            $pdf->Cell(0, 10, utf8_decode('Esta entrada fue anulada'), 0, 1, 'C');
            $pdf->SetTextColor(0, 0, 0); // Restaurar color
        }

        // Fecha del informe
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, utf8_decode('Fecha Informe: ') . now()->format('Y/m/d H:i:s'), 0, 1);
        $pdf->Ln(5);

        // Tabla de Información General
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(50, 10, 'Fecha Compra', 1, 0, 'C');
        $pdf->Cell(60, 10, 'Nombre Proveedor', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Total Compra', 1, 0, 'C');
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(50, 10, $fechaCompra, 1, 0, 'C');
        $pdf->Cell(60, 10, utf8_decode($nombreEmpresa ?? 'Anónimo'), 1, 0, 'C');
        $pdf->Cell(40, 10, '$ ' . number_format($valorCompra, 2), 1, 0, 'R');
        $pdf->Ln(10);

        // Sección de Productos
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, utf8_decode('PRODUCTOS'), 0, 1);
        $pdf->Ln(1);

        // Encabezado de la tabla de productos
        $pdf->Cell(70, 10, 'Nombre Producto', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Cantidad', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Precio', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Total', 1, 0, 'c');
        $pdf->Ln();

        // Productos
        $pdf->SetFont('Arial', '', 12);
        foreach ($compra as $producto) {
            $pdf->Cell(70, 10, utf8_decode($producto->nombre_producto), 1, 0, 'C');
            $pdf->Cell(30, 10, $producto->cantidad . ' unidades', 1, 0, 'C');
            $pdf->Cell(40, 10, '$ ' . number_format($producto->precio_unitario_compra, 2), 1, 0, 'R');
            $pdf->Cell(40, 10, '$ ' . number_format($producto->subtotal, 2), 1, 0, 'R');
            $pdf->Ln();
        }

        // Abri PDF en pestaña nueva del navegador
        $pdf->Output('I', 'detalle_compra_' . $idCompra . '.pdf');
        exit;
    }

    // ===================================================================
    // ===================================================================

    public function detalleCompraProductoPdf($idCompra)
    {
        try {
            $peticionDetalleCompraProductoPdf = $this->clientApi->post($this->baseUri.'detalle_compra_pdf/'.$idCompra, [
                'json' => ['empresa_actual' => session('empresa_actual.id_empresa')]
            ]);
            return json_decode($peticionDetalleCompraProductoPdf->getBody()->getContents());

        } catch (Exception $e) {
            alert()->error('Error', 'Exception detalleCompraProductoPdf, contacte a Soporte.');
            return back();
        }
    }
}
