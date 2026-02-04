{{-- INICIO Modal EDITAR CLIENTE --}}
{!! Form::model($persona, [
    'method' => 'PUT',
    'route' => ['personas.update', $persona->id_persona],
    'class' => 'mt-2',
    'autocomplete' => 'off',
    'id' => 'formEditarCliente_' . $persona->id_persona,
]) !!}
    @csrf
    <div class="rounded-top text-white text-center align-middle"
        style="background-color: #337AB7; border: solid 1px #337AB7;">
        <h5 class="m-1">Editar Cliente</h5>
    </div>

    {{ Form::hidden('id_persona', isset($persona) ? $persona->id_persona : null, ['class' => '', 'id' => 'id_persona']) }}

    {{-- ====================================================== --}}
    {{-- ====================================================== --}}

    <div class="modal-body p-0 m-0" style="border: solid 1px #337AB7;">
        <div class="row m-4">
            <div class="col-12 col-md-4">
                <div class="form-group d-flex flex-column">
                    <label for="id_tipo_persona" class=""
                        style="font-size: 15px">Tipo Cliente
                        <span class="text-danger">*</span></label>
                    {{ Form::select(
                        'id_tipo_persona',
                        collect(['' => 'Seleccionar...'])->union($tipos_cliente),
                        isset($persona) ? $persona->id_tipo_persona : null,
                        [
                            'class' => 'form-select select2',
                            'id' => 'id_tipo_persona_' . $persona->id_tipo_persona,
                            'required' => 'required',
                        ],
                    ) }}
                </div>
            </div>
            {{-- ======================= --}}
            <div class="col-12 col-md-4">
                <div class="form-group d-flex flex-column">
                    <label for="id_tipo_documento" class=""
                        style="font-size: 15px">Tipo de documento
                        <span class="text-danger">*</span></label>
                    {!! Form::select(
                        'id_tipo_documento',
                        collect(['' => 'Seleccionar...'])->union($tipos_documento),
                        isset($persona) ? $persona->id_tipo_documento : null,
                        [
                            'class' => 'form-select select2',
                            'id' => 'id_tipo_documento',
                            'required' => 'required',
                        ],
                    ) !!}
                </div>
            </div>
            {{-- ======================= --}}
            <div class="col-12 col-md-4" id="div_identificacion">
                <div class="form-group d-flex flex-column">
                    <label for="identificacion" class=""
                        style="font-size: 15px">Número de documento
                        <span class="text-danger">*</span></label>
                    {{ Form::text('identificacion', isset($persona) ? $persona->identificacion : null, [
                        'class' => 'form-control',
                        'id' => 'identificacion',
                        'required' => 'required',
                        'minlength' => 6,
                        'maxlength' => 10,
                    ]) }}
                </div>
            </div>
            {{-- ======================= --}}
            <div class="col-12 col-md-4 mt-4" id="div_nombres_persona">
                <div class="form-group d-flex flex-column">
                    <label for="nombre_usuario" class=""
                        style="font-size: 15px">Nombres
                        <span class="text-danger">*</span></label>
                    {{ Form::text('nombres_persona', isset($persona) ? $persona->nombres_persona : null, [
                        'class' => 'form-control',
                        'id' => 'nombres_persona',
                        'required' => 'required',
                        'pattern' => '^[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]{2,50}$',
                        'title' => 'Solo letras y espacios. Mínimo 2 y máximo 50 caracteres.',
                        'maxlength' => 50,
                    ]) }}
                </div>
            </div>
            {{-- ======================= --}}
            <div class="col-12 col-md-4 mt-4"
                id="div_apellidos_persona">
                <div class="form-group d-flex flex-column">
                    <label for="apellido_usuario" class=""
                        style="font-size: 15px">Apellidos
                        <span class="text-danger">*</span>
                    </label>
                    {{ Form::text('apellidos_persona', isset($persona) ? $persona->apellidos_persona : null, [
                        'class' => 'form-control',
                        'id' => 'apellidos_persona',
                        'required' => 'required',
                        'pattern' => '^[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]{2,50}$',
                        'title' => 'Solo letras y espacios. Mínimo 2 y máximo 50 caracteres.',
                        'maxlength' => 50,
                    ]) }}
                </div>
            </div>
            {{-- ======================= --}}
            <div class="col-12 col-md-4 mt-4"
                id="div_numero_telefono">
                <div class="form-group d-flex flex-column">
                    <label for="numero_telefono" class=""
                        style="font-size: 15px">Número Teléfono</label>
                    {{ Form::text('numero_telefono', isset($persona) ? $persona->numero_telefono : null, [
                        'class' => 'form-control',
                        'id' => 'numero_telefono',
                        'title' => 'Debe tener entre 7 y 10 dígitos.',
                        'maxlength' => 10,
                        'minlength' => 7,
                    ]) }}
                <span id="telefono-error" class="text-danger d-none mt-1"></span>
                </div>
            </div>
            {{-- ======================= --}}
            <div class="col-12 col-md-4 mt-4" id="div_celular">
                <div class="form-group d-flex flex-column">
                    <label for="celular" class=""
                        style="font-size: 15px">Celular
                        <span class="text-danger">*</span>
                    </label>
                    {{ Form::text('celular', isset($persona) ? $persona->celular : null, [
                        'class' => 'form-control',
                        'id' => 'celular',
                        'required' => 'required',
                        'title' => 'Debe ser un número de celular válido, sin indicativos, entre 7 y 15 dígitos.',
                        'maxlength' => 15,
                        'minlength' => 7,
                    ]) }}
                </div>
            </div>
            {{-- ======================= --}}

            {{-- <div class="col-12 col-md-4 mt-4" id="div_id_estado">
                <div class="form-group d-flex flex-column">
                    <label for="id_estado" class=""
                        style="font-size: 15px">Estado
                        <span class="text-danger">*</span>
                    </label>
                    {!! Form::select(
                        'id_estado',
                        collect(['' => 'Seleccionar...'])->union($estados),
                        isset($persona) ? $persona->id_estado : null,
                        [
                            'class' => 'form-select select2',
                            'id' => 'id_estado_' . $persona->id_estado,
                            'required' => 'required',
                        ],
                    ) !!}
                </div>
            </div> --}}

            {{-- ======================= --}}
            <div class="col-12 col-md-4 mt-4" id="div_id_genero">
                <div class="form-group d-flex flex-column">
                    <label for="id_genero" class=""
                        style="font-size: 15px">Género
                        <span class="text-danger">*</span></label>
                    {!! Form::select(
                        'id_genero',
                        collect(['' => 'Seleccionar...'])->union($generos),
                        isset($persona) ? $persona->id_genero : null,
                        ['class' => 'form-select select2', 'id' => 'id_genero', 'required' => 'required'],
                    ) !!}
                </div>
            </div>
            {{-- ======================= --}}
            <div class="col-12 col-md-4 mt-4" id="div_direccion">
                <div class="form-group d-flex flex-column">
                    <label for="direccion" class=""
                        style="font-size: 15px">Dirección</label>
                    {{ Form::text('direccion', isset($persona) ? $persona->direccion : null, [
                        'class' => 'form-control',
                        'id' => 'direccion',
                        // 'required' => 'required',
                        'pattern' => '^[a-zA-Z0-9\s\#\-\.\,\/]{5,100}$',
                        'title' =>
                            'Ingrese una dirección válida (solo letras, números y caracteres como # - . , /). Mínimo 5 y máximo 100 caracteres.',
                        'maxlength' => 100,
                        'minlength' => 5,
                    ]) }}
                </div>
            </div>
            {{-- ======================= --}}

            <div class="col-12 col-md-4 mt-4" id="div_email">
                <div class="form-group d-flex flex-column">
                    <label for="email" class=""
                        style="font-size: 15px">Correo
                        <span class="text-danger">*</span></label>
                    {{ Form::email('email', isset($persona) ? $persona->email : null, [
                        'class' => 'form-control',
                        'id' => 'email',
                        'required' => 'required',
                        'pattern' => '^[a-zA-Z0-9._%+\\-]+@[a-zA-Z0-9.\\-]+\\.[a-zA-Z]{2,}$',
                        'title' => 'Por favor, ingresa un correo electrónico válido',
                    ]) }}
                </div>
            </div>

        </div>
    </div> {{-- FIN modal-body --}}

    {{-- ====================================================== --}}
    {{-- ====================================================== --}}

    <div class="modal-footer d-block mt-0 border border-0">
        <!-- Contenedor para el GIF -->
        <div id="loadingIndicatorEditCliente_{{ $persona->id_persona }}"
            class="loadingIndicator">
            <img src="{{ asset('imagenes/loading.gif') }}"
                alt="Procesando...">
        </div>

        {{-- ====================================================== --}}
        {{-- ====================================================== --}}

        <div class="d-flex justify-content-center mt-2">
            <button type="submit"
                id="btn_editar_cliente_{{ $persona->id_persona }}"
                class="btn btn-success me-3">
                <i class="fa fa-floppy-o" aria-hidden="true">
                    Modificar</i>
            </button>

            <button
                id="btn_cancelar_cliente_{{ $persona->id_persona }}"
                type="button" class="btn btn-secondary"
                data-bs-dismiss="modal">
                <i class="fa fa-times" aria-hidden="true">
                    Cancelar</i>
            </button>
        </div>
    </div> {{-- modal-footer --}}
{!! Form::close() !!}
