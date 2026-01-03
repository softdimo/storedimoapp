<!-- Modal Anular compra -->

{!! Form::open([
    'method' => 'POST',
    'route' => ['anular_compra'],
    'class' => 'mt-2',
    'autocomplete' => 'off',
    'id' => 'formAnularCompra_' . $entrada->id_compra,
]) !!}
@csrf

{{ Form::hidden('id_compra', isset($entrada) ? $entrada->id_compra : null,
                    ['class' => 'form-control', 'id' => 'id_compra_' . $entrada->id_compra]) }}
{{ Form::hidden('motivo', null, ['class' => 'form-control', 'id' => 'motivo']) }}

<div class="rounded-top" style="border: solid 1px #337AB7;">
    <div class="rounded-top text-white text-center" style="background-color: #337AB7; border: solid 1px #337AB7;">
        <h5>Anular Compra</h5>
    </div>

    <div class="modal-body p-0 m-0">
        <div class="mt-3 mb-3 mb-0 ps-3 text-center">
            <h5 class="text-danger">¿Desea anular esta compra?</h5>
            <h4 class="mt-4" style="color: #337AB7">
                Compra: {{ $entrada->id_compra }} -
                Comprador: {{ $entrada->nombres_usuario }}
            </h4>
        </div>

        <div class="form-group mt-3 mb-3 mb-0 ps-3 text-right mr-20">
            <label for="motivoAnulacion"> <strong>Motivo de anulación:</strong></label>
            <textarea id="motivoAnulacion" class="form-control" rows="3" placeholder="Escriba un motivo de anulación" required></textarea>
        </div>

    </div>
</div>

<div id="loadingIndicatorAnularCompra_{{ $entrada->id_compra }}" class="loadingIndicator">
    <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
</div>

<div class="d-flex justify-content-around mt-3">
    <button type="submit" class="btn btn-success" id="btn_anular_compra_{{ $entrada->id_compra }}"
        style="background-color: #337AB7">
        <i class="fa fa-trash"> Anular</i>
    </button>

    <button type="button" class="btn btn-secondary" id="btn_cancelar_compra_{{ $entrada->id_compra }}"
        data-bs-dismiss="modal">
        <i class="fa fa-times" aria-hidden="true"> Cerrar</i>
    </button>
</div>
{!! Form::close() !!}

<script>

    let formularioAnulacion = $("#formAnularCompra_{{$entrada->id_compra}}")

    $("#btn_anular_compra_{{ $entrada->id_compra }}").click(function(){

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
