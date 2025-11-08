<!-- INICIO Modal DETALLES BAJA -->
<div class="rounded-top" style="border: solid 1px #337AB7;">
    <div class="rounded-top text-white text-center" style="background-color: #337AB7; border: solid 1px #337AB7;">
        <h5 class="m-2">Código: {{ $baja->id_baja }} - Fecha Baja: {{ $baja->fecha_baja }}</h5>
    </div>

    <div class="modal-body p-0 m-0">
        <div class="row m-0">
            <div class="col-12 p-3 pt-1">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered w-100 mb-0" aria-describedby="venta" id="tblDetalleBaja">
                        <thead>
                            <tr class="header-table text-center">
                                <th>Tipo Baja</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Categoria</th>
                                <th>Observaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bajaDetalles as $producto)
                                <tr class="text-center">
                                    <td>{{ $producto->tipo_baja }}</td>
                                    <td>{{ $producto->nombre_producto }}</td>
                                    <td>{{ $producto->cantidad }}</td>
                                    <td>{{ $producto->categoria }}</td>
                                    <td>{{ $producto->observaciones }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-end mt-3">
    <button type="button" title="Cancelar" class="btn btn-secondary" data-bs-dismiss="modal">
        <i class="fa fa-times"> Cerrar</i>
    </button>
</div>
<!-- FIN Modal DETALLES BAJA -->
