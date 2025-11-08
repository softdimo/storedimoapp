<!-- Modal Crear Unidad de Medida -->
<div class="modal fade" id="modalCrearUmd" tabindex="-1" aria-labelledby="modalCrearUmdLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-3">
            {!! Form::open([
                'method' => 'POST',
                'route' => ['unidades_medida.store'],
                'class' => 'mt-2',
                'autocomplete' => 'off',
                'id' => 'formCrearUmdProducto'])!!}
                @csrf

                {{ Form::hidden('tipoFormCrearUmd', 'formCrearUmdProducto', ['class' => 'form-control', 'id' => 'formCrearUmdProducto']) }}

                <div class="rounded-top" style="border: solid 1px #337AB7;">
                    <div class="rounded-top text-white text-center" style="background-color: #337AB7; border: solid 1px #337AB7;">
                        <h5 class="m-1">Crear Nueva Unidad De Medida</h5>
                    </div>

                    {{-- ====================================================== --}}
                    {{-- ====================================================== --}}

                    <div class="modal-body p-0 m-0">
                        <div class="p-3 d-flex flex-column">
                            <div>
                                <label for="umd">Unidad de Medida<span class="text-danger"> *</span></label>
                                <input type="text" name="umd" id="umd" class="form-control" required
                                    minlength="3" maxlength="100" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s'-]{3,100}$"
                                    title="Debe contener solo letras, espacios, guiones o apóstrofes (mínimo 3 caracteres)"
                                    placeholder="Ingrese Unidad de Medida">
                            </div>
    
                            <div class="mt-3">
                                <label for="abreviatura_umd">Abreviatura Unidad de Medida<span class="text-danger"> *</span></label>
                                <input type="text" name="abreviatura_umd" id="abreviatura_umd" class="form-control" required
                                    minlength="2" maxlength="100" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s'-]{2,100}$"
                                    title="Debe contener solo letras, espacios, guiones o apóstrofes (mínimo 2 caracteres)"
                                    placeholder="Ingrese Abreviatura Unidad de Medida">
                            </div>
                        </div>
                    </div> {{-- fin modal-body --}}
                </div> {{-- fin rounded-top --}}
        
                {{-- ====================================================== --}}
                {{-- ====================================================== --}}

                <!-- Contenedor para el GIF -->
                <div id="loadingIndicatorUmdStore" class="loadingIndicator">
                    <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
                </div>

                {{-- ====================================================== --}}
                {{-- ====================================================== --}}

                <div class="d-flex justify-content-center mt-3">
                    <button type="submit" class="btn btn-success me-3">
                        <i class="fa fa-floppy-o"></i> Crear Umd
                    </button>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-times"></i> Cancelar
                    </button>
                </div>
            {!! Form::close() !!}
        </div> {{-- fin modal-content --}}
    </div> {{-- fin modal-dialog --}}
</div> {{-- fin modal fade --}}
{{-- FINAL Modal Crear Uniddad Medida --}}
