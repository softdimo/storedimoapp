{{-- INICIO Modal EDITAR CATEGORÍA --}}
{!! Form::open([
        'method' => 'POST',
        'route' => ['editar_categoria'],
        'class' => 'mt-2',
        'autocomplete' => 'off',
        'id' => 'formEditarCategoria_' . $categoriaEdit->id_categoria,]) !!}
        @csrf

    <div class="rounded-top" style="border: solid 1px #337AB7;">
        <div class="rounded-top text-white text-center"
            style="background-color: #337AB7; border: solid 1px #337AB7;">
            <h5>Modificar Categoría</h5>
        </div>

        {{-- ====================================================== --}}
        {{-- ====================================================== --}}

        <div class="modal-body p-0 m-0">
            <div class="row m-0 pt-4 pb-4">
                <div class="col-12 col-md-3">
                    <div class="form-group d-flex flex-column">
                        <label for="id_categoria" class=""
                            style="font-size: 15px">Código<span
                                class="text-danger"></span></label>
                        {{ Form::text('id_categoria', isset($categoriaEdit) ? $categoriaEdit->id_categoria : null, [
                            'class' => 'form-control bg-secondary-subtle',
                            'id' => 'id_categoria_' . $categoriaEdit->id_categoria,
                            'readonly',
                        ]) }}
                    </div>
                </div>

                <div class="col-12 col-md-9">
                    <div class="form-group d-flex flex-column">
                        <label for="categoria" class=""
                            style="font-size: 15px">Nombre<span
                                class="text-danger">*</span></label>
                        {{ Form::text('categoria', isset($categoriaEdit) ? $categoriaEdit->categoria : null, [
                            'class' => 'form-control',
                            'id' => 'categoria_' . $categoriaEdit->id_categoria,
                        ]) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ====================================================== --}}
    {{-- ====================================================== --}}

    <!-- Contenedor para el GIF -->
    <div id="loadingIndicatorEditCategoria_{{ $categoriaEdit->id_categoria }}"
        class="loadingIndicator">
        <img src="{{ asset('imagenes/loading.gif') }}"
            alt="Procesando...">
    </div>

    {{-- ====================================================== --}}
    {{-- ====================================================== --}}

    <div class="d-flex justify-content-center mt-3">
        <button type="submit" title="Guardar Configuración"
            class="btn btn-success me-3"
            id="btn_editar_categoria_{{ $categoriaEdit->id_categoria }}">
            <i class="fa fa-floppy-o" aria-hidden="true">
                Modificar</i>
        </button>

        <button type="button" title="Cancelar"
            class="btn btn-secondary" data-bs-dismiss="modal"
            id="btn_editar_cancelar_{{ $categoriaEdit->id_categoria }}">
            <i class="fa fa-times" aria-hidden="true"> Cancelar</i>
        </button>
    </div>
{!! Form::close() !!}
{{-- FINAL Modal EDITAR CATEGORÍA --}}
