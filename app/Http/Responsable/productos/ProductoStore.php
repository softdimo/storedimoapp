<?php

namespace App\Http\Responsable\productos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;
use Carbon\Carbon;

class ProductoStore implements Responsable
{
    public function toResponse($request)
    {
        $formEntradas = request('form_entradas', null); // Identifico el formulario origen entradas
        $formVentas = request('form_ventas', null); // Identifico el formulario origen ventas
        $idTipoPersona = request('id_tipo_persona', null);
        $nombreProducto = request('nombre_producto', null);
        $idCategoria = request('id_categoria', null);
        $precioUnitario = request('precio_unitario', null);
        $precioDetal = request('precio_detal', null);
        $precioPorMayor = request('precio_por_mayor', null);
        $descripcion = request('descripcion', null);
        $stockMinimo = request('stock_minimo', null);
        $idEstado = 1;
        $referencia = request('referencia', null);
        $fechaVencimiento = request('fecha_vencimiento', null);
        $idUnidadMedida = request('id_umd', null);
        $idProveedor = request('id_proveedor', null);
        $imagenProductoBase64 = null;

        if ($request->hasFile('imagen_producto'))
        {
            $imagenProducto = $request->file('imagen_producto');

            if ($imagenProducto->isValid()) {
                // Validación de tipo MIME
                $tiposPermitidos = ['image/jpg', 'image/jpeg', 'image/png', 'image/webp'];
                $tipoMime = $imagenProducto->getMimeType();

                if (!in_array($tipoMime, $tiposPermitidos)) {
                    alert()->error('Error', 'El tipo de imagen no es válido. Solo se permiten JPG, JPEG, PNG o WEBP.');
                    return back();
                }

                // Validación de tamaño (2 MB = 2048 KB)
                $tamanioMaximoKB = 2048;
                $tamanioArchivoKB = $imagenProducto->getSize() / 1024;

                if ($tamanioArchivoKB > $tamanioMaximoKB) {
                    alert()->error('Error', 'La imagen excede el tamaño máximo permitido de 2 MB.');
                    return back();
                }

                // Codificación base64
                $contenido = file_get_contents($imagenProducto);
                $imagenProductoBase64 = 'data:' . $imagenProducto->getMimeType() . ';base64,' . base64_encode($contenido);
            }
        }

        if ( isset($formEntradas) && !is_null($formEntradas) && !empty($formEntradas) )
        {
            $formStore = $formEntradas;
        } else
        {
            $formStore = $formVentas;
        }
        
        $baseUri = env('BASE_URI');
        $clientApi = new Client(['base_uri' => $baseUri]);

        try
        {
            $peticionProductoStore = $clientApi->post($baseUri.'producto_store', [
                'json' => [
                    'id_tipo_persona' => $idTipoPersona,
                    'imagen_producto' => $imagenProductoBase64,
                    'nombre_producto' => $nombreProducto,
                    'id_categoria' => $idCategoria,
                    'precio_unitario' => doubleval(str_replace(".", "", $precioUnitario)),
                    'precio_detal' => doubleval(str_replace(".","", $precioDetal)),
                    'precio_por_mayor' => doubleval(str_replace(".", "", $precioPorMayor)),
                    'descripcion' => $descripcion,
                    'stock_minimo' => intval($stockMinimo),
                    'id_estado' => $idEstado,
                    'referencia' => $referencia,
                    'fecha_vencimiento' => $fechaVencimiento,
                    'id_umd' => $idUnidadMedida,
                    'id_proveedor' => $idProveedor,
                    'id_audit' => session('id_usuario'),
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);
            
            $respuestaProductoStore = json_decode($peticionProductoStore->getBody()->getContents());

            if (isset($respuestaProductoStore) && !empty($respuestaProductoStore))
            {
                if ($formStore == 'crearProductoEntrada')
                {
                    alert()->success('Proceso Exitoso', 'Producto creado satisfactoriamente');
                    return redirect()->to(route('entradas.create'));
                } elseif ($formStore == 'crearProductoVenta')
                {
                    alert()->success('Proceso Exitoso', 'Producto creado satisfactoriamente');
                    return redirect()->to(route('ventas.create'));
                } else
                {
                    alert()->success('Proceso Exitoso', 'Producto creado satisfactoriamente');
                    return redirect()->to(route('productos.index'));
                }
            }
        } catch (Exception $e)
        {
            alert()->error('Error', 'Creando el producto, si el problema persiste, contacte a Soporte.' . $e->getMessage());
            return back();
        }
    }
}
