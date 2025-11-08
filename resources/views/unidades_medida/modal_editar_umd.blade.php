<!-- Modal Editar Unidad de Medida -->
{!! Form::open([
    'method' => 'PUT',
    'route' => ['unidades_medida.update', $umdEdit->id],
    'class' => 'mt-2',
    'autocomplete' => 'off',
    'id' => 'formEditUmd_' . $umdEdit->id,
    ])!!}
    @csrf

    {{-- {{ Form::hidden('id_umd', isset($umdEdit) ? $umdEdit->id : null, ['class' => '', 'id' => 'id_umd']) }} --}}

    <div class="rounded-top" style="border: solid 1px #337AB7;">
        <div class="rounded-top text-white text-center" style="background-color: #337AB7; border: solid 1px #337AB7;">
            <h5 class="m-1">Crear Nueva Unidad De Medida</h5>
        </div>

        {{-- ====================================================== --}}
        {{-- ====================================================== --}}

        <div class="modal-body p-0 m-0">
            <div class="p-3 d-flex flex-column">
                <div>
                    <label for="descripcion_umd">Unidad de Medida<span class="text-danger"> *</span></label>
                    {{ Form::text('descripcion_umd', isset($umdEdit) ? $umdEdit->descripcion : null, [
                        'id' => 'descripcion_umd',
                        'class' => 'form-control',
                        'required' => true,
                        'minlength' => 3,
                        'maxlength' => 100,
                        'pattern' => "^[A-Za-zÁÉÍÓÚáéíóúÑñ\s'-]{3,100}$",
                        'title' => "Debe contener solo letras, espacios, guiones o apóstrofes (mínimo 3 caracteres)",
                        'placeholder' => "Ingrese Unidad de Medida"
                    ]) }}
                </div>

                <div class="mt-3">
                    <label for="abreviatura_umd">Abreviatura Unidad de Medida<span class="text-danger"> *</span></label>
                    {{ Form::text('abreviatura_umd', isset($umdEdit) ? $umdEdit->abreviatura : null, [
                        'id' => 'abreviatura_umd',
                        'class' => 'form-control',
                        'required' => true,
                        'minlength' => 2,
                        'maxlength' => 100,
                        'pattern' => "^[A-Za-zÁÉÍÓÚáéíóúÑñ\s'-]{2,100}$",
                        'title' => "Debe contener solo letras, espacios, guiones o apóstrofes (mínimo 2 caracteres)",
                        'placeholder' => "Ingrese Abreviatura Unidad de Medida"
                    ]) }}
                </div>
            </div>
        </div> {{-- fin modal-body --}}
    </div> {{-- fin rounded-top --}}

    {{-- ====================================================== --}}
    {{-- ====================================================== --}}

    <!-- Contenedor para el GIF -->
    <div id="loadingIndicatorEditUmd_{{$umdEdit->id}}" class="loadingIndicator">
        <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
    </div>

    {{-- ====================================================== --}}
    {{-- ====================================================== --}}

    <div class="d-flex justify-content-center mt-3">
        <button type="submit" class="btn btn-success me-3" id="btn_editar_umd_{{$umdEdit->id}}">
            <i class="fa fa-floppy-o"></i> Editar Umd
        </button>

        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn_cancelar_umd_{{$umdEdit->id}}">
            <i class="fa fa-times"></i> Cancelar
        </button>
    </div>
{!! Form::close() !!}
{{-- FINAL Modal Editar Uniddad Medida --}}
