{{-- INICIO Modal ESTADO PRODUCTO --}}
{!! Form::open([
    'method' => 'POST',
    'route' => ['cambiar_estado_producto'],
    'class' => 'mt-2',
    'autocomplete' => 'off',
    'id' => 'formCambiarEstadoProducto_' . $productoEdit->id_producto,]) !!}
    @csrf
    
    <div class="rounded-top" style="border: solid 1px #337AB7;">
        <div class="rounded-top text-white text-center"
            style="background-color: #337AB7; border: solid 1px #337AB7;">
            <h5>Cambiar estado del producto: <br>
                <span
                    class="text-warning">{{ $productoEdit->nombre_producto }}</span>
            </h5>
        </div>

        <div class="mt-4 mb-4 text-center">
            <span class="text-danger fs-5">¿Realmente desea cambiar el estado del producto?</span>
        </div>

        {{ Form::hidden('id_producto', isset($productoEdit) ? $productoEdit->id_producto : null, ['class' => '', 'id' => 'id_producto']) }}
    </div>

    {{-- ====================================================== --}}
    {{-- ====================================================== --}}

    <!-- Contenedor para el GIF -->
    <div id="loadingIndicatorEstadoProducto_{{ $productoEdit->id_producto }}"
        class="loadingIndicator">
        <img src="{{ asset('imagenes/loading.gif') }}"
            alt="Procesando...">
    </div>

    {{-- ====================================================== --}}
    {{-- ====================================================== --}}

    <div class="d-flex justify-content-center mt-3">
        <button type="submit"
            id="btn_cambiar_estado_producto_{{ $productoEdit->id_producto }}"
            class="btn btn-success me-3" title="Guardar Configuración">
            <i class="fa fa-floppy-o" aria-hidden="true"> Modificar</i>
        </button>


        <button type="button"
            id="btn_cancelar_estado_producto_{{ $productoEdit->id_producto }}"
            class="btn btn-secondary" title="Cancelar"
            data-bs-dismiss="modal">
            <i class="fa fa-times" aria-hidden="true"> Cancelar</i>
        </button>
    </div>
{!! Form::close() !!}
{{-- FINAL Modal ESTADO PRODUCTO --}}
