<?php

namespace App\Http\Responsable\productos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Milon\Barcode\DNS2D;
use Milon\Barcode\QRcode;
use setasign\Fpdf\FPDF;
use Illuminate\Support\Str;

class ProductoGenerarBarCode implements Responsable
{
    public function toResponse($request)
    {
        $idProducto = request('id_producto_input', null);
        $referencia = request('referencia_input', null);
        $nombreProducto = request('nombre_producto_input', null);
        $cantidadBarcode = request('cantidad_barcode', 12);

        $rutaTempArchivoCodebar = "public/upfiles/productos/barcodes";
        $slugNombreProducto = Str::slug($nombreProducto); // Para evitar espacios en el nombre del archivo
        $nombreArchivoCodebar = "{$referencia}_{$slugNombreProducto}";
        $rutaCodebarImage = storage_path("app/{$rutaTempArchivoCodebar}/{$nombreArchivoCodebar}.png");
        $rutaCodebarPdf = storage_path("app/{$rutaTempArchivoCodebar}/{$nombreArchivoCodebar}.pdf");

        try
        {
            // Consultar Producto para infoQr
            $infoProducto = $this->consultarProducto($idProducto);

           if($infoProducto == "error_cantidad")
           {
               alert()->error('Error', 'No se encontraron productos o no hay inventario para el producto seleccionado');
               return back();
           }

            // Generar los datos para el código QR
            $infoQr = json_encode([
                'referencia' => $referencia,
                'nombre' => $nombreProducto,
                'precio' => $infoProducto->precio_unitario,
                'cat' => $infoProducto->categoria
            ], JSON_UNESCAPED_UNICODE);

            Storage::makeDirectory($rutaTempArchivoCodebar);

            // Generar PNG válido (con GD si existe; si no, desde la matriz del QR)
            $barcodeImageBinary = $this->generarImagenQrPng($infoQr, 10);

            if ($barcodeImageBinary === false || strlen($barcodeImageBinary) < 8) {
                alert()->error('Error', 'No se pudo generar la imagen del código QR.');
                return redirect()->to(route('productos.index'));
            }

            // Guardar el PNG como archivo físico
            Storage::put("{$rutaTempArchivoCodebar}/{$nombreArchivoCodebar}.png", $barcodeImageBinary);

            // Verificar que la imagen fue guardada correctamente y no esté vacía
            if (!file_exists($rutaCodebarImage) || filesize($rutaCodebarImage) === 0)
            {
                alert()->error('Error', 'No se pudo generar la imagen del código QR.');
                return redirect()->to(route('productos.index'));
            }

            // Crear el PDF con los códigos QR
            $pdf = new \FPDF();
            $pdf->SetAutoPageBreak(false);
            $pdf->AddPage();

            $columnas = 3;
            $espaciadoX = 70;
            $espaciadoY = 70;
            $xInicial = 5;
            $yInicial = 5;

            for ($i = 0; $i < $cantidadBarcode; $i++)
            {
                $x = $xInicial + ($i % $columnas) * $espaciadoX;
                $y = $yInicial + (floor(($i % 12) / $columnas) * $espaciadoY);

                $pdf->Image($rutaCodebarImage, $x, $y, 60, 60);

                if (($i + 1) % 12 == 0 && ($i + 1) < $cantidadBarcode) {
                    $pdf->AddPage();
                }
            }

            // Guardar el PDF final
            $pdf->Output($rutaCodebarPdf, 'F');

            // Redireccionar con la URL para ver el PDF
            $pdfUrl = route('ver.pdf', ['archivo' => "{$nombreArchivoCodebar}.pdf"]);
            return redirect()->to(route('productos.index'))->with('pdfUrl', $pdfUrl);

        } catch (Exception $e)
        {
            alert()->error('Error', 'Error al generar el código QR.');
            return redirect()->to(route('productos.index'));
        }
    }

    /**
     * Genera un PNG opaco del QR, compatible con FPDF.
     * Usa milon/DNS2D cuando hay GD; si no, construye el PNG desde la matriz del QR.
     */
    private function generarImagenQrPng($infoQr, $escala = 10)
    {
        if (function_exists('imagecreate')) {
            $barcode = new DNS2D();
            $barcodeImageBase64 = $barcode->getBarcodePNG($infoQr, 'QRCODE', $escala, $escala);

            if (!empty($barcodeImageBase64)) {
                $pngBinary = base64_decode($barcodeImageBase64);

                // FPDF falla con PNG transparentes; lo convertimos a fondo blanco
                if ($pngBinary !== false && function_exists('imagecreatefromstring')) {
                    $img = @imagecreatefromstring($pngBinary);
                    if ($img !== false) {
                        $ancho = imagesx($img);
                        $alto = imagesy($img);
                        $fondo = imagecreatetruecolor($ancho, $alto);
                        $blanco = imagecolorallocate($fondo, 255, 255, 255);
                        imagefilledrectangle($fondo, 0, 0, $ancho, $alto, $blanco);
                        imagecopy($fondo, $img, 0, 0, 0, 0, $ancho, $alto);
                        ob_start();
                        imagepng($fondo);
                        $pngBinary = ob_get_clean();
                        imagedestroy($img);
                        imagedestroy($fondo);
                    }
                }

                if ($pngBinary !== false && strlen($pngBinary) > 0) {
                    return $pngBinary;
                }
            }
        }

        return $this->generarPngQrSinGd($infoQr, $escala);
    }

    /**
     * Genera PNG RGB del QR sin extensión GD (evita archivo vacío / FPDF Unexpected end of stream).
     */
    private function generarPngQrSinGd($infoQr, $escala = 10)
    {
        $qr = new QRcode($infoQr, 'L');
        $barcodeArray = $qr->getBarcodeArray();

        if (empty($barcodeArray['bcode']) || empty($barcodeArray['num_rows']) || empty($barcodeArray['num_cols'])) {
            return false;
        }

        $filas = (int) $barcodeArray['num_rows'];
        $columnas = (int) $barcodeArray['num_cols'];
        $ancho = $columnas * $escala;
        $alto = $filas * $escala;
        $raw = '';

        for ($y = 0; $y < $alto; $y++) {
            $raw .= "\x00"; // filtro PNG: none
            $fila = intdiv($y, $escala);
            for ($x = 0; $x < $ancho; $x++) {
                $columna = intdiv($x, $escala);
                $esNegro = !empty($barcodeArray['bcode'][$fila][$columna]);
                $raw .= $esNegro ? "\x00\x00\x00" : "\xFF\xFF\xFF";
            }
        }

        $ihdr = pack('NNCCCCC', $ancho, $alto, 8, 2, 0, 0, 0);
        $png = "\x89PNG\r\n\x1a\n";
        $png .= $this->pngChunk('IHDR', $ihdr);
        $png .= $this->pngChunk('IDAT', gzcompress($raw, 9));
        $png .= $this->pngChunk('IEND', '');

        return $png;
    }

    private function pngChunk($type, $data)
    {
        return pack('N', strlen($data)) . $type . $data . pack('N', crc32($type . $data));
    }

    public function consultarProducto($idProducto)
    {
        $jwtToken = session('api_jwt_token');

        try
        {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            $peticion = $clientApi->post($baseUri . 'query_producto/' . $idProducto, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $jwtToken, // <--- JWT Inyectado
                    'Accept'        => 'application/json',
                ],
                'json' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);

            $respuesta = $peticion->getBody()->getContents();

            if(!is_null($respuesta) && !empty($respuesta))
            {
                return json_decode($respuesta);
            } else
            {
               return "error_cantidad";
            }

        } catch (Exception $e)
        {
            alert()->error('Error', 'Consultando el producto, contacte a Soporte.');
            return back();
        }
    }
}
