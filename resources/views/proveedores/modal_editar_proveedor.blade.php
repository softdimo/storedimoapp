{{-- INICIO Modal EDITAR PROVEEDOR --}}
{!! Form::model($proveedorEdit, [
    'method' => 'PUT',
    'route' => ['proveedores.update', $proveedorEdit->id_proveedor],
    'class' => 'mt-2',
    'autocomplete' => 'off',
    'id' => 'formEditarProveedor_' . $proveedorEdit->id_proveedor,
]) !!}
@csrf

<div class="rounded-top text-white text-center" style="background-color: #337AB7; border: solid 1px #337AB7;">
    <h5 class="m-0 pt-1 pb-1">Editar Proveedor</h5>
</div>

{{ Form::hidden('id_proveedor', isset($proveedorEdit) ? $proveedorEdit->id_proveedor : null, ['class' => '', 'id' => 'id_proveedor']) }}

{{-- ====================================================== --}}
{{-- ====================================================== --}}

<div class="modal-body p-0 m-0" style="border: solid 1px #337AB7;">
    <div class="row m-4">
        <div class="col-12 col-md-4">
            <div class="form-group d-flex flex-column">
                <label for="id_tipo_persona" class="" style="font-size: 15px">Tipo Proveedor
                    <span class="text-danger">*</span></label>
                {{ Form::select(
                    'id_tipo_persona',
                    collect(['' => 'Seleccionar...'])->union($tipos_proveedor),
                    isset($proveedorEdit) ? $proveedorEdit->id_tipo_persona : null,
                    [
                        'class' => 'form-select select2',
                        'id' => 'id_tipo_persona_' . $proveedorEdit->id_tipo_persona,
                        'required' => 'required',
                    ],
                ) }}
            </div>
        </div>
        {{-- ======================= --}}
        <div class="col-12 col-md-4">
            <div class="form-group d-flex flex-column">
                <label for="id_tipo_documento" class="" style="font-size: 15px">Tipo de documento
                    <span class="text-danger">*</span></label>
                {!! Form::select(
                    'id_tipo_documento',
                    collect(['' => 'Seleccionar...'])->union($tipos_documento),
                    isset($proveedorEdit) ? $proveedorEdit->id_tipo_documento : null,
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
                <label for="identificacion" class="" style="font-size: 15px">Número de documento</label>
                {{ Form::text('identificacion', isset($proveedorEdit) ? $proveedorEdit->identificacion : null, [
                    'class' => 'form-control',
                    'id' => 'identificacion',
                    'required' => 'required',
                    'pattern' => '^[0-9]{6,10}$',
                    'title' => 'El número de documento debe contener entre 6 y 10 dígitos numéricos',
                    'minlength' => '6',
                    'maxlength' => '10',
                    'onkeypress' => 'return event.charCode >= 48 && event.charCode <= 57',
                ]) }}
            </div>
        </div>
        {{-- ======================= --}}
        <div class="col-12 col-md-4 mt-4" id="div_nombres_persona">
            <div class="form-group d-flex flex-column">
                <label for="nombre_usuario" class="" style="font-size: 15px">Nombres <span
                        class="text-danger">*</span></label>
                {{ Form::text('nombres_proveedor', isset($proveedorEdit) ? $proveedorEdit->nombres_proveedor : null, [
                    'class' => 'form-control',
                    'id' => 'nombres_persona',
                    'required' => 'required',
                    'pattern' => '^[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]{2,50}$',
                    'title' => 'Los nombres deben contener solo letras y espacios, con una longitud entre 2 y 50 caracteres',
                    'maxlength' => '50',
                    'minlength' => '2',
                    'onkeypress' =>
                        'return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32) || (event.charCode >= 160 && event.charCode <= 165)',
                ]) }}
            </div>
        </div>
        {{-- ======================= --}}
        <div class="col-12 col-md-4 mt-4" id="div_apellidos_persona">
            <div class="form-group d-flex flex-column">
                <label for="apellidos_persona" class="" style="font-size: 15px">Apellidos <span
                        class="text-danger">*</span></label>
                {{ Form::text('apellidos_proveedor', isset($proveedorEdit) ? $proveedorEdit->apellidos_proveedor : null, [
                    'class' => 'form-control',
                    'id' => 'apellidos_persona',
                    'required' => 'required',
                    'pattern' => '^[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]{2,50}$',
                    'title' => 'Los apellidos deben contener solo letras y espacios, con una longitud entre 2 y 50 caracteres',
                    'maxlength' => '50',
                    'minlength' => '2',
                    'onkeypress' =>
                        'return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32) || (event.charCode >= 160 && event.charCode <= 165)',
                ]) }}
            </div>
        </div>
        {{-- ======================= --}}
        <div class="col-12 col-md-4 mt-4" id="div_numero_telefono">
            <div class="form-group d-flex flex-column">
                <label for="numero_telefono" class="" style="font-size: 15px">Número Teléfono</label>
                {{ Form::text('telefono_proveedor', isset($proveedorEdit) ? $proveedorEdit->telefono_proveedor : null, [
                    'class' => 'form-control',
                    'id' => 'numero_telefono',
                    'title' => 'El número de teléfono debe contener entre 7 y 10 dígitos numéricos',
                    'maxlength' => '10',
                    'minlength' => '7',
                    'onkeypress' => 'return event.charCode >= 48 && event.charCode <= 57',
                ]) }}
                <span id="telefono-error" class="text-danger d-none mt-1"></span>
            </div>
        </div>
        {{-- ======================= --}}
        <div class="col-12 col-md-4 mt-4" id="div_celular">
            <div class="form-group d-flex flex-column">
                <label for="celular" class="" style="font-size: 15px">Celular <span
                        class="text-danger">*</span></label>
                {{ Form::text('celular_proveedor', isset($proveedorEdit) ? $proveedorEdit->celular_proveedor : null, [
                    'class' => 'form-control',
                    'id' => 'celular',
                    'required' => 'required',
                    'title' => 'El número de celular debe contener exactamente 10 dígitos numéricos',
                    'maxlength' => '10',
                    'minlength' => '10',
                    'onkeypress' => 'return event.charCode >= 48 && event.charCode <= 57',
                ]) }}
            </div>
        </div>
        {{-- ======================= --}}
        <div class="col-12 col-md-4 mt-4" id="div_email">
            <div class="form-group d-flex flex-column">
                <label for="email" class="" style="font-size: 15px">Correo <span
                        class="text-danger">*</span></label>
                {{ Form::email('email_proveedor', isset($proveedorEdit) ? $proveedorEdit->email_proveedor : null, [
                    'class' => 'form-control',
                    'id' => 'email',
                    'required' => 'required',
                    'pattern' => '^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$',
                    'title' => 'Ingrese un correo electrónico válido (ejemplo: nombre@dominio.com)',
                    'maxlength' => '255',
                    'placeholder' => 'ejemplo@dominio.com',
                ]) }}
            </div>
        </div>
        {{-- ======================= --}}
        <div class="col-12 col-md-4 mt-4" id="div_id_genero">
            <div class="form-group d-flex flex-column">
                <label for="id_genero" class="" style="font-size: 15px">Género
                    <span class="text-danger">*</span></label>
                {!! Form::select(
                    'id_genero',
                    collect(['' => 'Seleccionar...'])->union($generos),
                    isset($proveedorEdit) ? $proveedorEdit->id_genero : null,
                    ['class' => 'form-select select2', 'id' => 'id_genero'],
                ) !!}
            </div>
        </div>
        {{-- ======================= --}}
        <div class="col-12 col-md-4 mt-4" id="div_direccion">
            <div class="form-group d-flex flex-column">
                <label for="direccion" class="" style="font-size: 15px">Dirección</label>
                {{ Form::text('direccion_proveedor', isset($proveedorEdit) ? $proveedorEdit->direccion_proveedor : null, [
                    'class' => 'form-control',
                    'id' => 'direccion',
                    'pattern' => '^[a-zA-Z0-9ÁÉÍÓÚáéíóúÑñ\s\-_#.,]{5,255}$',
                    'title' =>
                        'La dirección debe contener entre 5 y 255 caracteres. Puede incluir letras, números y caracteres especiales como -_#.,',
                    'maxlength' => '255',
                    'minlength' => '5',
                    'placeholder' => 'Ej: Calle 123 # 45-67',
                ]) }}
            </div>
        </div>
        {{-- ======================= --}}
        <div class="col-12 col-md-4 mt-4" id="div_id_estado">
            <div class="form-group d-flex flex-column">
                <label for="id_estado" class="" style="font-size: 15px">Estado
                    <span class="text-danger">*</span>
                </label>
                {!! Form::select(
                    'id_estado',
                    collect(['' => 'Seleccionar...'])->union($estados),
                    isset($proveedorEdit) ? $proveedorEdit->id_estado : null,
                    [
                        'class' => 'form-select select2',
                        'id' => 'id_estado_' . $proveedorEdit->id_estado,
                    ],
                ) !!}
            </div>
        </div>
    </div>

    {{-- ============================================== --}}

    <div class="row m-4" id="div_proveedor_juridico">
        <div class="col-12 col-md-4">
            <div class="form-group d-flex flex-column">
                <label for="nit_empresa" class="form-label">Nit Proveedor<span class="text-danger">*</span></label>
                {!! Form::text('nit_proveedor', isset($proveedorEdit) ? $proveedorEdit->nit_proveedor : null, [
                    'class' => 'form-control',
                    'id' => 'nit_empresa',
                    'required' => 'required',
                    'pattern' => '^[0-9]{7,10}$',
                    'title' => 'El NIT debe tener entre 7 y 10 dígitos numéricos incluyendo el dígito de verificación',
                    'minlength' => '7',
                    'maxlength' => '10',
                    'placeholder' => 'Ejemplo: 123456789',
                    'onkeypress' => 'return event.charCode >= 48 && event.charCode <= 57',
                ]) !!}
            </div>
        </div>

        {{-- ======================= --}}

        <div class="col-12 col-md-4">
            <div class="form-group d-flex flex-column">
                <label for="nombre_empresa" class="form-label">Nombre Proveedor<span
                        class="text-danger">*</span></label>
                {!! Form::text('proveedor_juridico', isset($proveedorEdit) ? $proveedorEdit->proveedor_juridico : null, [
                    'class' => 'form-control',
                    'id' => 'nombre_empresa',
                    'required' => 'required',
                    'pattern' => '^[a-zA-Z0-9ÁÉÍÓÚáéíóúÑñ\s\-_&.,]{2,100}$',
                    'title' =>
                        'El nombre del proveedor debe contener entre 2 y 100 caracteres. Puede incluir letras, números y caracteres especiales como -_&.,',
                    'maxlength' => '100',
                    'minlength' => '2',
                    'placeholder' => 'Ej: Empresa Distribuidora S.A.',
                ]) !!}
            </div>
        </div>

        {{-- ======================= --}}

        <div class="col-12 col-md-4">
            <div class="form-group d-flex flex-column">
                <label for="telefono_empresa" class="form-label">Teléfono Proveedor<span
                        class="text-danger">*</span></label>
                {!! Form::text('telefono_juridico', isset($proveedorEdit) ? $proveedorEdit->telefono_juridico : null, [
                    'class' => 'form-control',
                    'id' => 'telefono_empresa',
                    'required' => 'required',
                    'title' => 'El número de teléfono debe contener entre 7 y 10 dígitos numéricos',
                    'maxlength' => '10',
                    'minlength' => '7',
                    'onkeypress' => 'return event.charCode >= 48 && event.charCode <= 57',
                ]) !!}
                <span id="telefono-error-juridico" class="text-danger d-none mt-1"></span>

            </div>
        </div>
    </div>
</div> {{-- FIN modal-body --}}

{{-- ====================================================== --}}
{{-- ====================================================== --}}

<div class="modal-footer d-block mt-0 border border-0">
    <!-- Contenedor para el GIF -->
    <div id="loadingIndicatorEditProveedor_{{ $proveedorEdit->id_proveedor }}" class="loadingIndicator">
        <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
    </div>

    {{-- ====================================================== --}}
    {{-- ====================================================== --}}

    <div class="d-flex justify-content-center mt-3">
        <button id="btn_cancelar_proveedor_{{ $proveedorEdit->id_proveedor }}" type="button"
            class="btn btn-secondary me-3" data-bs-dismiss="modal">
            <i class="fa fa-times" aria-hidden="true"> Cancelar</i>
        </button>

        <button type="submit" id="btn_editar_proveedor_{{ $proveedorEdit->id_proveedor }}" class="btn btn-success">
            <i class="fa fa-floppy-o" aria-hidden="true">
                Modificar</i>
        </button>
    </div>
</div> {{-- modal-footer --}}
{!! Form::close() !!}
{{-- FINAL Modal EDITAR PROVEEDOR  --}}
