<!-- Modal Detalles compra -->

<div class="rounded-top" style="border: solid 1px #337AB7;">
    <div class="rounded-top text-white text-center" style="background-color: #337AB7; border: solid 1px #337AB7;">
        <h5 class="m-1">Detalle Compra Código: {{ $entrada->id_compra }}</h5>
    </div>

    <div class="mt-3 mb-0 ps-3">
        <h5>Factura: {{ $entrada->factura_compra }}</h5>
        <h6>Compra realizada por: <span style="color: #337AB7">{{ $entrada->nombres_usuario }}</span></h6>
    </div>

    <div class="modal-body p-0 m-0">
        <div class="row m-0">
            <div class="col-12 p-3 pt-1">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered w-100 mb-0" aria-describedby="entradas">
                        <thead>
                            <tr class="header-table text-center align-middle">
                                {{-- <th>Factura</th> --}}
                                <th>Fecha Compra</th>
                                {{-- <th>Empresa</th> --}}
                                <th>Id Proveedor</th>
                                <th>Nombre Proveedor</th>
                                <th>Valor Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center align-middle">
                                {{-- <td>{{ $entrada->factura_compra }}</td> --}}
                                <td>{{ $entrada->fecha_compra }}</td>
                                @if ($entrada->nit_proveedor)
                                    <td>{{ $entrada->nit_proveedor }}</td>
                                @else
                                    <td>{{ $entrada->identificacion }}</td>
                                @endif

                                @if ($entrada->proveedor_juridico)
                                    <td>{{ $entrada->proveedor_juridico }}</td>
                                @else
                                    <td>{{ $entrada->nombres_proveedor }}
                                        {{ $entrada->apellidos_proveedor }}</td>
                                @endif

                                @php
                                    $valorCompra = trim(str_replace(['$', 'COP', ' ', "\xc2\xa0"], '', (string) ($entrada->valor_compra ?? '0')));
                                    if (preg_match('/^\d{1,3}([.,]\d{3})+$/', $valorCompra) || substr_count($valorCompra, '.') > 1) {
                                        $valorCompra = str_replace(['.', ','], '', $valorCompra);
                                    } elseif (substr_count($valorCompra, ',') === 1 && !str_contains($valorCompra, '.')) {
                                        $decimales = substr(strrchr($valorCompra, ','), 1);
                                        $valorCompra = strlen($decimales) === 3
                                            ? str_replace(',', '', $valorCompra)
                                            : str_replace(',', '.', $valorCompra);
                                    }
                                    $valorCompra = (float) $valorCompra;
                                    if ($valorCompra == 0) {
                                        $digitosValorCompra = preg_replace('/\D/', '', (string) ($entrada->valor_compra ?? ''));
                                        if ($digitosValorCompra !== '') {
                                            $valorCompra = (float) $digitosValorCompra;
                                        }
                                    }
                                @endphp
                                <td>$ {{ number_format($valorCompra, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="">
            <div class="mt-3 mb-0 ps-3">
                <h5 class="mb-0" style="color: #337AB7">Productos</h5>
            </div>

            <div class="row m-0">
                <div class="col-12 p-3 pt-1">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered w-100 mb-0" aria-describedby="compra_detalle"
                            id="tblDetalleCompraProductos_{{ $entrada->id_compra }}">
                            <thead>
                                <tr class="header-table text-center">
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($entradaDetalles as $producto)
                                    @php
                                        $precioProducto = trim(str_replace(['$', 'COP', ' ', "\xc2\xa0"], '', (string) ($producto->precio_unitario_compra ?? '0')));
                                        if (preg_match('/^\d{1,3}([.,]\d{3})+$/', $precioProducto) || substr_count($precioProducto, '.') > 1) {
                                            $precioProducto = str_replace(['.', ','], '', $precioProducto);
                                        } elseif (substr_count($precioProducto, ',') === 1 && !str_contains($precioProducto, '.')) {
                                            $decimalesPrecio = substr(strrchr($precioProducto, ','), 1);
                                            $precioProducto = strlen($decimalesPrecio) === 3
                                                ? str_replace(',', '', $precioProducto)
                                                : str_replace(',', '.', $precioProducto);
                                        }
                                        $precioProducto = (float) $precioProducto;
                                        if ($precioProducto == 0) {
                                            $digitosPrecio = preg_replace('/\D/', '', (string) ($producto->precio_unitario_compra ?? ''));
                                            if ($digitosPrecio !== '') {
                                                $precioProducto = (float) $digitosPrecio;
                                            }
                                        }

                                        $subtotalProducto = trim(str_replace(['$', 'COP', ' ', "\xc2\xa0"], '', (string) ($producto->subtotal ?? '0')));
                                        if (preg_match('/^\d{1,3}([.,]\d{3})+$/', $subtotalProducto) || substr_count($subtotalProducto, '.') > 1) {
                                            $subtotalProducto = str_replace(['.', ','], '', $subtotalProducto);
                                        } elseif (substr_count($subtotalProducto, ',') === 1 && !str_contains($subtotalProducto, '.')) {
                                            $decimalesSubtotal = substr(strrchr($subtotalProducto, ','), 1);
                                            $subtotalProducto = strlen($decimalesSubtotal) === 3
                                                ? str_replace(',', '', $subtotalProducto)
                                                : str_replace(',', '.', $subtotalProducto);
                                        }
                                        $subtotalProducto = (float) $subtotalProducto;
                                        if ($subtotalProducto == 0) {
                                            $digitosSubtotal = preg_replace('/\D/', '', (string) ($producto->subtotal ?? ''));
                                            if ($digitosSubtotal !== '') {
                                                $subtotalProducto = (float) $digitosSubtotal;
                                            }
                                        }
                                    @endphp
                                    <tr class="text-center">
                                        <td>{{ $producto->nombre_producto }}</td>
                                        <td>{{ $producto->cantidad }}</td>
                                        <td>$ {{ number_format($precioProducto, 0, ',', '.') }}</td>
                                        <td>$ {{ number_format($subtotalProducto, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="">
            <div class="mt-3 mb-0 ps-3">
                <h5 class="mb-0" style="color: #337AB7">Detalle de Anulaciones</h5>
            </div>
            <div class="row m-0">
                <div class="col-12 p-3 pt-1">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered w-100 mb-0" aria-describedby="detalle_anulacion"
                            id="tblDetalleanulacion_{{ $entrada->id_compra }}">
                            <thead>
                                <tr class="header-table text-center">
                                    <th>Motivo Anulación</th>
                                    <th>Fecha Anulación (D-M-Y)</th>
                                    <th>Usuario Anulación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($entradaDetalles as $anulacion)
                                    <tr class="text-center">
                                        <td>{{ $anulacion->motivo_anulacion }}</td>
                                        <td>{{ $anulacion->fecha_anulacion }}</td>
                                        <td>{{ $anulacion->usuario_anulacion }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="loadingIndicatorEditCategoria" class="loadingIndicator">
    <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
</div>

<div class="d-flex justify-content-center mt-3">
    <a href="{{ route('detalle_compras_pdf', $entrada->id_compra) }}" target="_blank" class="btn btn-success me-3"
        style="background-color: #337AB7">
        <i class="fa fa-file-pdf-o"></i> Pdf Detalle Compra
    </a>

    <button type="button" title="Cancelar" class="btn btn-secondary" data-bs-dismiss="modal"
        id="btn_cancelar_detalle_compra">
        <i class="fa fa-times" aria-hidden="true"> Cerrar</i>
    </button>
</div>