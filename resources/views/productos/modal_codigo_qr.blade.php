{{-- INICIO Modal CÓDIGO DE BARRAS PRODUCTO --}}
{!! Form::open([
    'method' => 'POST',
    'route' => ['producto_barcode'],
    'class' => 'm-0 p-0',
    'autocomplete' => 'off',
    'id' => 'formProductoBarcode_' . $productoEdit->id_producto,]) !!}
    @csrf

    <div class="rounded-top" style="border: solid 1px #337AB7;">
        <div class="rounded-top text-white text-center"
            style="background-color: #337AB7; border: solid 1px #337AB7;">
            <h5>Producto: <span
                    id="nombre_producto">{{ $productoEdit->nombre_producto }}</span>
                - Referencia: <span
                    id="referencia">{{ $productoEdit->referencia }}</span>
            </h5>

            {{ Form::hidden('id_producto_input', isset($productoEdit) ? $productoEdit->id_producto : null, ['class' => '', 'id' => 'id_producto_input', 'required' => 'required']) }}
            {{ Form::hidden('referencia_input', isset($productoEdit) ? $productoEdit->referencia : null, ['class' => '', 'id' => 'referencia_input', 'required' => 'required']) }}
            {{ Form::hidden('nombre_producto_input', isset($productoEdit) ? $productoEdit->nombre_producto : null, ['class' => 'form-control', 'id' => 'nombre_producto_input', 'required' => 'required']) }}
        </div>

        <div class="modal-body p-0 m-0">
            <div class="m-0 p-4 d-flex justify-content-between">
                <div class="">
                    {{ Form::number('cantidad_barcode', null, [
                        'class' => 'form-control',
                        'id' => 'cantidad_barcode_' . $productoEdit->id_producto,
                        'placeholder' => 'Ingresar cantidad',
                        'min' => '1',
                    ]) }}
                </div>

                <div class="">
                    <button type="submit" class="btn btn-success"
                        id="btn_codebar_producto_{{ $productoEdit->id_producto }}">
                        <i class="fa fa-floppy-o" aria-hidden="true">
                            Generar Código</i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenedor para el GIF -->
    <div id="loadingIndicatorCodeBarProducto_{{ $productoEdit->id_producto }}"
        class="loadingIndicator">
        <img src="{{ asset('imagenes/loading.gif') }}"
            alt="Procesando...">
    </div>

    <div class="d-flex justify-content-end mt-3">
        <button type="button" class="btn btn-secondary"
            data-bs-dismiss="modal"
            id="btn_cancelar_codebar_{{ $productoEdit->id_producto }}">
            <i class="fa fa-remove" aria-hidden="true"> Cancelar</i>
        </button>
    </div>
{!! Form::close() !!}
{{-- FINAL Modal CÓDIGO DE BARRAS PRODUCTO --}}
