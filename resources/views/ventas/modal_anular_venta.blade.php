<!-- Modal Anular compra -->

{!! Form::open([
    'method' => 'POST',
    'route' => ['anular_venta'],
    'class' => 'mt-2',
    'autocomplete' => 'off',
    'id' => 'formAnularVenta_' . $venta->id_venta,
]) !!}
@csrf

{{ Form::hidden('id_venta', isset($venta) ? $venta->id_venta : null,
                    ['class' => 'form-control', 'id' => 'id_compra_' . $venta->id_venta]) }}
{{ Form::hidden('motivo', null, ['class' => 'form-control', 'id' => 'motivo']) }}

<div class="rounded-top" style="border: solid 1px #337AB7;">
    <div class="rounded-top text-white text-center" style="background-color: #337AB7; border: solid 1px #337AB7;">
        <h5>Anular Venta</h5>
    </div>

    <div class="modal-body p-0 m-0">
        <div class="mt-3 mb-3 mb-0 ps-3 text-center">
            <h5 class="text-danger">¿Deseas anular esta venta?</h5>
            <h4 class="mt-4" style="color: #337AB7">
                Venta ID: {{ $venta->id_venta }} -
                Cliente: {{ $venta->nombres_cliente }}
            </h4>
        </div>

        <div class="form-group mt-3 mb-3 mb-0 ps-3 text-right mr-20">
            <label for="motivoAnulacion"> <strong>Motivo de anulación:</strong></label>
            <textarea id="motivoAnulacion" class="form-control" rows="3"
            placeholder="Escriba un motivo de anulación" required></textarea>
        </div>

        <input type="hidden" name="accion" value="anular" id="accion">

    </div>
</div>

<div id="loadingIndicatorAnularVenta_{{ $venta->id_venta }}" class="loadingIndicator">
    <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
</div>

<div class="d-flex justify-content-around mt-3">
    <button type="submit" class="btn btn-danger" id="btn_anular_venta_{{ $venta->id_venta }}">
        <i class="fa fa-trash"> Anular</i>
    </button>

    <button type="button" class="btn btn-secondary" id="btn_cancelar_venta_{{ $venta->id_venta }}"
        data-bs-dismiss="modal">
        <i class="fa fa-times" aria-hidden="true"> Cerrar</i>
    </button>
</div>
{!! Form::close() !!}

<script>

    let formularioAnulacion = $("#formAnularVenta_{{$venta->id_venta}}")

    $("#btn_anular_venta_{{ $venta->id_venta }}").click(function(){

        event.preventDefault();
        let motivoAnulacion = $("#motivoAnulacion").val().trim();

        if(motivoAnulacion == "" || motivoAnulacion == undefined)
        {
            Swal.fire(
                'Error!',
                'El campo motivo anulación es obligatorio',
                'error'
            );

            return;
        } else
        {
            $("#motivo").val(motivoAnulacion);
            formularioAnulacion.submit();
        }
    });

</script>
