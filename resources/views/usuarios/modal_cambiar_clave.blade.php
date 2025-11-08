
{!! Form::open([
    'method' => 'POST',
    'route' => ['cambiar_clave'],
    'class' => 'mt-2',
    'autocomplete' => 'off',
    'id' => 'formCambiarClave_' . $usuario->id_usuario,
]) !!}
    @csrf
    <div class="" style="border: solid 1px #337AB7;">
        <div class="rounded-top text-white text-center"
            style="background-color: #337AB7; border: solid 1px #337AB7;">
            <h5>Cambiar Contraseña de:
                {{ $usuario->identificacion . ' - ' . $usuario->nombre_usuario . ' ' . $usuario->apellido_usuario }}
            </h5>
        </div>

        {{ Form::hidden('id_usuario', isset($usuario) ? $usuario->id_usuario : null, ['class' => '', 'id' => 'id_usuario', 'required' => 'required']) }}

        {{-- ====================================================== --}}
        {{-- ====================================================== --}}

        <div class="modal-body p-0 m-0">
            <div class="row m-0 pt-4 pb-4">
                <div class="col-12 col-md-6">
                    <div class="form-group d-flex flex-column">
                        <label for="nueva_clave" class=""
                            style="font-size: 15px">Nueva Contraseña<span
                                class="text-danger">*</span></label>
                        {{ Form::text('nueva_clave', null, ['class' => 'form-control', 'id' => 'nueva_clave_' . $usuario->id_usuario, 'placeholder' => 'Contraseña', 'required' => 'required']) }}
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="form-group d-flex flex-column">
                        <label for="confirmar_clave" class=""
                            style="font-size: 15px">Confirmar
                            Contraseña<span
                                class="text-danger">*</span></label>
                        {{ Form::text('confirmar_clave', null, ['class' => 'form-control', 'id' => 'confirmar_clave_' . $usuario->id_usuario, 'placeholder' => 'Confirmar Contraseña', 'required' => 'required']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ====================================================== --}}
    {{-- ====================================================== --}}

    <!-- Contenedor para el GIF -->
    <div id="loadingIndicatorEditClave_{{ $usuario->id_usuario }}"
        class="loadingIndicator">
        <img src="{{ asset('imagenes/loading.gif') }}"
            alt="Procesando...">
    </div>

    {{-- ====================================================== --}}
    {{-- ====================================================== --}}

    <div class="d-flex justify-content-center mt-2">
        <button type="submit" title="Guardar Configuración"
            class="btn btn-success me-3"
            id="btn_editar_clave_{{ $usuario->id_usuario }}">
            <i class="fa fa-floppy-o" aria-hidden="true"> Modificar</i>
        </button>


        <button type="button" title="Cancelar" class="btn btn-secondary"
            id="btn_cancelar_clave_{{ $usuario->id_usuario }}"
            data-bs-dismiss="modal">
            <i class="fa fa-times" aria-hidden="true"> Cancelar</i>
        </button>
    </div>
{!! Form::close() !!}
{{-- FINAL Modal CAMBIAR CONTRASEÑA --}}
