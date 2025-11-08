<?php

namespace App\Http\Responsable\productos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class ProductoEdit implements Responsable
{
    protected $idProducto;
    protected $categorias;
    protected $unidaMedida;
    protected $proveedor;

    public function __construct($idProducto, $categorias, $umd, $proveedor)
    {
        $this->idProducto = $idProducto;
        $this->categorias = $categorias;
        $this->unidaMedida = $umd;
        $this->proveedor = $proveedor;
    }

    public function toResponse($request)
    {
        $idProducto = $this->idProducto;
        $categorias = $this->categorias;
        $unidaMedida = $this->unidaMedida;
        $proveedor = $this->proveedor;
        view()->share('categorias', $categorias);
        view()->share('umd', $unidaMedida);
        view()->share('proveedores', $proveedor);
        try
        {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);
            
            // Realiza la solicitud a la API
            $response = $clientApi->post($baseUri . 'producto_edit/'.$idProducto, [
                'json' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);

            $productoEdit = json_decode($response->getBody()->getContents());

            // Recibe el tipo de modal desde la request
            $tipoModal = $request->get('tipo_modal', 'editar'); // valor por defecto

            return match ($tipoModal)
            {
                'qr'     => view('productos.modal_codigo_qr', compact('productoEdit')),
                'estado' => view('productos.modal_estado_producto', compact('productoEdit')),
                default  => view('productos.modal_editar_producto', compact('productoEdit')),
            };
            
        } catch (Exception $e)
        {
            alert()->error('Error', 'Error consulta producto, si el problema persiste, contacte a Soporte.');
            return back();
        }
    }
}
