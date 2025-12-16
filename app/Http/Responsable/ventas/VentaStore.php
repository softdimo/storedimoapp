<?php

namespace App\Http\Responsable\ventas;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class VentaStore implements Responsable
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
        $idTipoCliente = request('id_tipo_persona', null);
        $fechaVenta = now()->format('Y-m-d H:i:s'); // Formato compatible con DATETIME en MySQL
        $descuento = request('descuento', null);
        $totalVenta = request('total_venta', null);
        $idTipoPago = request('tipo_pago', null);
        $idCliente = request('cliente_venta', null);
        $usuLogueado = session('id_usuario');
        $idEstado = 1;
        $idEstadoCredito = request('id_estado_credito', null);
        $fechaLimiteCredito = request('fecha_limite_credito', null);
        
        $idProductos = request('id_producto_venta', []); // Array productos
        $cantidades = request('cantidad_venta', []);    // Array cantidades
        $pUnitarioVenta = request('p_unitario_venta', []);   // Array precios Detal
        $pDetalVenta = request('p_detal_venta', []);   // Array precios Detal
        $pMayorVenta = request('p_mayor_venta', []);   // Array precios por Mayor
        $subtotales = request('subtotal_venta', []);    // Array de subtotales
        $gananciaVenta = request('ganancia', []);    // Array de ganancias
        
        try {
            $reqVentaStore = $this->clientApi->post($this->baseUri.'venta_store', [
                'json' => [
                    'id_empresa' => $idEmpresa,
                    'id_tipo_cliente' => $idTipoCliente,
                    'fecha_venta' => $fechaVenta,
                    'descuento' => $descuento,
                    'total_venta' => $totalVenta,
                    'id_tipo_pago' => $idTipoPago,
                    'productos' => array_map(function ($id, $cantidad, $pUnitario, $precioDetal, $precioMayor, $subtotal, $ganancia) {
                        return [
                            'id_producto' => $id,
                            'cantidad' => $cantidad,
                            'p_unitario' => $pUnitario,
                            'p_detal' => $precioDetal,
                            'p_mayor' => $precioMayor,
                            'subtotal' => $subtotal,
                            'ganancia' => $ganancia
                        ];
                    }, $idProductos, $cantidades, $pUnitarioVenta, $pDetalVenta, $pMayorVenta, $subtotales, $gananciaVenta), // Construcción del array
                    'id_cliente' => $idCliente,
                    'id_usuario' => $usuLogueado,
                    'id_estado' => $idEstado,
                    'id_estado_credito' => $idEstadoCredito,
                    'fecha_limite_credito' => $fechaLimiteCredito,
                    'id_audit' => session('id_usuario'),
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);
            $resVentaStore = json_decode($reqVentaStore->getBody()->getContents());

            if(isset($resVentaStore) && !empty($resVentaStore) && !is_null($resVentaStore)) {
                alert()->success('Proceso Exitoso', 'Venta creada satisfactoriamente');
                return redirect()->to(route('ventas.index'));
            }
        } catch (Exception $e) {
            alert()->error('Error', 'Creando la venta, contacte a Soporte.');
            return back();
        }
    }
}
