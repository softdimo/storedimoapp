<?php

namespace App\Http\Responsable\entradas;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class EntradaStore implements Responsable
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
        $idEmpresa = request('id_empresa', null);
        $facturaCompra = request('factura_compra', null);
        $fechaCompra = now()->format('Y-m-d H:i:s'); // Formato compatible con DATETIME en MySQL
        $valorCompra = request('valor_compra', null);
        $idProveedor = request('id_tipo_proveedor', null);
        $usuLogueado = session('id_usuario');
        $idEstado = 1;

        $idProductos = request('id_producto_compra', []); // Array de productos
        $pUnitarios = request('p_unitario_compra', []);   // Array de precios unitarios
        $cantidades = request('cantidad_compra', []);    // Array de cantidades
        $subtotales = request('subtotal_compra', []);    // Array de subtotales

        try {
            $reqEntradaStore = $this->clientApi->post($this->baseUri.'entrada_store', [
                'json' => [
                    'id_empresa' => $idEmpresa,
                    'factura_compra' => $facturaCompra,
                    'fecha_compra' => $fechaCompra,
                    'valor_compra' => $valorCompra,
                    'id_proveedor' => $idProveedor,
                    'productos' => array_map(function ($id, $precio, $cantidad, $subtotal) {
                        return [
                            'id_producto' => $id,
                            'p_unitario' => $precio,
                            'cantidad' => $cantidad,
                            'subtotal' => $subtotal
                        ];
                    }, $idProductos, $pUnitarios, $cantidades, $subtotales), // Construcción del array
                    'id_usuario' => $usuLogueado,
                    'id_estado' => $idEstado,
                    'id_audit' => session('id_usuario'),
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);
            $resEntradaStore = json_decode($reqEntradaStore->getBody()->getContents());

            if(isset($resEntradaStore->success) && $resEntradaStore->success) {
                alert()->success('Proceso Exitoso', 'Compra creada satisfactoriamente');
                return redirect()->to(route('entradas.index'));
            }
        } catch (Exception $e) {
            alert()->error('Error', 'Creando la compra, contacte a Soporte.');
            return back();
        }
    } // FIN function toResponse
} // FIN Class EntradaStore
