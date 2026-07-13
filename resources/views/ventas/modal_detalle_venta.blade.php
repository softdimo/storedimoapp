<!-- INICIO Modal Detalles VENTA -->
<div class="rounded-top" style="border: solid 1px #337AB7;">
    <div class="rounded-top text-white text-center" style="background-color: #337AB7; border: solid 1px #337AB7;">
        <h5>Detalle de Venta Código: {{ $venta->id_venta }}</h5>
    </div>
    <div class="mt-3 mb-0 ps-3">
        <h6>Venta realizada por: <span style="color: #337AB7">{{ $venta->nombres_usuario }}</span></h6>
    </div>
    <div class="modal-body p-0 m-0">
        <div class="row m-0">
            <div class="col-12 p-3 pt-1">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered w-100 mb-0" aria-describedby="venta">
                        <thead>
                            <tr class="header-table text-center">
                                <th>Fecha Venta</th>
                                <th>Nombre Cliente</th>
                                <th>Subtotal</th>
                                <th>Descuento</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center">
                                <td>{{ $venta->fecha_venta }}</td>
                                <td>{{ $venta->nombres_cliente }}</td>
                                <td class="text-end">{{ $venta->subtotal_venta }}</td>
                                <td class="text-end">{{ $venta->descuento }}</td>
                                <td class="text-end">{{ $venta->total_venta_index }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="">
            <div class="mt-3 mb-0 ps-3">
                <h4 class="mb-0" style="color: #337AB7">Productos</h4>
            </div>
            <div class="row m-0">
                <div class="col-12 p-3 pt-1">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered w-100 mb-0" aria-describedby="ventas"
                            id="tblDetalleVentaProductos_{{ $venta->id_venta }}">
                            <thead>
                                <tr class="header-table text-center">
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Total</th>
                                    <th>Ganancia</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ventaDetalles as $producto)
                                    <tr class="text-center">
                                        <td>{{ $producto->nombre_producto }}</td>
                                        <td class="text-end">{{ $producto->precio_venta_detalle }}</td>
                                        <td>{{ $producto->cantidad }}</td>
                                        <td class="text-end">{{ $producto->subtotal_detalle }}</td>
                                        <td class="text-end">{{ $producto->ganancia_venta }}</td>
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
                            id="tblDetalleanulacion_{{ $venta->id_venta }}">
                            <thead>
                                <tr class="header-table text-center">
                                    <th>Producto</th>
                                    <th>Motivo Anulación</th>
                                    <th>Fecha Anulación (D-M-Y)</th>
                                    <th>Usuario Anulación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ventaDetalles as $anulacion)
                                    <tr class="text-center">
                                        <td>{{ $anulacion->nombre_producto }}</td>
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
<!-- Contenedor para el GIF -->
<div id="loadingIndicatorReciboVenta_{{ $venta->id_venta }}" class="loadingIndicator" style="display: none;">
    <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
</div>

<div class="d-flex justify-content-center mt-3">

    @if($venta->id_estado_venta == 2)
        <button type="button" class="btn btn-success generar-pdf me-3" style="background-color: #337AB7"
            id="btnReciboVenta_{{ $venta->id_venta }}" data-id="{{ $venta->id_venta }}"
            data-fecha="{{ $venta->fecha_venta }}" data-usuario="{{ $venta->nombres_usuario }}"
            data-cliente="{{ $venta->nombres_cliente }}" data-subtotal="{{ $venta->subtotal_venta }}"
            data-descuento="{{ $venta->descuento }}" data-total="{{ $venta->total_venta }}"
            data-detalles='@json($ventaDetalles)' disabled>
            <i class="fa fa-file-pdf-o"></i> Recibo Caja
        </button>
    @else
        <button type="button" class="btn btn-success generar-pdf me-3" style="background-color: #337AB7"
            id="btnReciboVenta_{{ $venta->id_venta }}" data-id="{{ $venta->id_venta }}"
            data-fecha="{{ $venta->fecha_venta }}" data-usuario="{{ $venta->nombres_usuario }}"
            data-cliente="{{ $venta->nombres_cliente }}" data-subtotal="{{ $venta->subtotal_venta }}"
            data-descuento="{{ $venta->descuento }}" data-total="{{ $venta->total_venta }}"
            data-detalles='@json($ventaDetalles)'>
            <i class="fa fa-file-pdf-o"></i> Recibo Caja
        </button>
    @endif

    <button type="button" title="Cancelar" class="btn btn-secondary" data-bs-dismiss="modal"
        id="btnCancelarReciboVenta_{{ $venta->id_venta }}">
        <i class="fa fa-times" aria-hidden="true"> Cerrar</i>
    </button>
</div>
