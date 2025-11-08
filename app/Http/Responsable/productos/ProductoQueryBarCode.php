<?php

namespace App\Http\Responsable\productos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class ProductoQueryBarCode implements Responsable
{
    protected $idProducto;

    public function __construct($idProducto)
    {
        $this->idProducto = $idProducto;
    }

    // ================================

    public function toResponse($request)
    {
        $idProducto = $this->idProducto;

        try {
            // Realiza la solicitud a la API
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            $response = $clientApi->post($baseUri . 'producto_query_barcode/'.$idProducto, [
                'json' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);
            $producto = json_decode($response->getBody()->getContents(), true);

            if(isset($producto) && !empty($producto)) {
                return response()->json($producto);
            } else {
                alert()->error('Error', 'No existe el producto.');
                return redirect()->to(route('productos.index'));
            }
        } catch (Exception $e) {
            alert()->error('Error', 'Error consulta producto, si el problema persiste, contacte a Soporte.');
            return back();
        } // FIN Catch
    }
}
