{{-- INICIO Modal ESTADO CATEGORIA --}}
    {!! Form::open([
        'method' => 'POST',
        'route' => ['cambiar_estado_categoria'],
        'class' => 'mt-2',
        'autocomplete' => 'off',
        'id' => 'formCambiarEstadoCategoria_' . $categoriaEdit->id_categoria]) !!}
        @csrf

    <div class="rounded-top" style="border: solid 1px #337AB7;">
        <div class="rounded-top text-white text-center"
            style="background-color: #337AB7; border: solid 1px #337AB7;">
            <h5>Cambiar estado de categoría: <br>
                <span
                    class="text-warning">{{ $categoriaEdit->categoria }}</span>
            </h5>
        </div>

        <div class="mt-4 mb-4 text-center">
            <span class="text-danger fs-5">¿Realmente desea cambiar el
                estado de la categoría?</span>
        </div>


        {{ Form::hidden('id_categoria', isset($categoriaEdit) ? $categoriaEdit->id_categoria : null, ['class' => '', 'id' => 'id_categoria']) }}
    </div>

    {{-- ====================================================== --}}
    {{-- ====================================================== --}}

    <!-- Contenedor para el GIF -->
    <div id="loadingIndicatorEstadoCategoria_{{ $categoriaEdit->id_categoria }}"
        class="loadingIndicator">
        <img src="{{ asset('imagenes/loading.gif') }}"
            alt="Procesando...">
    </div>

    {{-- ====================================================== --}}
    {{-- ====================================================== --}}

    <div class="d-flex justify-content-around mt-3">
        <button type="submit"
            id="btn_cambiar_estado_categoria_{{ $categoriaEdit->id_categoria }}"
            class="btn btn-success" title="Guardar Configuración">
            <i class="fa fa-floppy-o" aria-hidden="true">
                Modificar</i>
        </button>


        <button type="button"
            id="btn_cancelar_estado_categoria_{{ $categoriaEdit->id_categoria }}"
            class="btn btn-secondary" title="Cancelar"
            data-bs-dismiss="modal">
            <i class="fa fa-times" aria-hidden="true"> Cancelar</i>
        </button>
    </div>
{!! Form::close() !!}
{{-- FINAL Modal ESTADO CATEGORÍA --}}
