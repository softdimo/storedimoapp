{{-- INICIO Modal EDITAR USUARIO --}}
{!! Form::model($usuario, [
    'method' => 'PUT',
    'route' => ['usuarios.update', $usuario->id_usuario],
    'class' => 'mt-2',
    'autocomplete' => 'off',
    'id' => 'formEditarUsuario_' . $usuario->id_usuario,
]) !!}
@csrf
<div class="rounded-top text-white text-center" style="background-color: #337AB7; border: solid 1px #337AB7;">
    <h5 class="m-0 pt-1 pb-1">Editar Usuario</h5>
</div>

{{ Form::hidden('id_usuario', isset($usuario) ? $usuario->id_usuario : null, ['class' => '', 'id' => 'id_usuario']) }}

{{-- ====================================================== --}}
{{-- ====================================================== --}}

<div class="modal-body p-0 m-0" style="border: solid 1px #337AB7;">
    <div class="row m-2">
        <div class="col-12 col-md-4">
            <div class="form-group d-flex flex-column">
                <label for="id_tipo_persona" class="" style="font-size: 15px">Tipo Usuario
                    <span class="text-danger">*</span></label>
                {{ Form::select(
                    'id_tipo_persona',
                    collect(['' => 'Seleccionar...'])->union($tipos_empleado),
                    isset($usuario) ? $usuario->id_tipo_persona : null,
                    ['class' => 'form-select select2', 'id' => 'id_tipo_persona', 'required' => 'required'],
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
                    isset($usuario) ? $usuario->id_tipo_documento : null,
                    ['class' => 'form-select select2', 'id' => 'id_tipo_documento'],
                ) !!}
            </div>
        </div>
        {{-- ======================= --}}
        <div class="col-12 col-md-4">
            <div class="form-group d-flex flex-column">
                <label for="identificacion" class="" style="font-size: 15px">Número de documento
                    <span class="text-danger">*</span></label>
                {{ Form::text('identificacion', isset($usuario) ? $usuario->identificacion : null, [
                    'class' => 'form-control',
                    'id' => 'identificacion',
                    'required' => 'required',
                    'minlength' => 6,
                ]) }}
            </div>
        </div>
    </div>

    {{-- ============================================== --}}

    <div class="row m-2">
        <div class="col-12 col-md-4">
            <div class="form-group d-flex flex-column">
                <label for="nombre_usuario" class="" style="font-size: 15px">Nombre Usuario
                    <span class="text-danger">*</span></label>
                {{ Form::text('nombre_usuario', isset($usuario) ? $usuario->nombre_usuario : null, [
                    'class' => 'form-control',
                    'id' => 'nombre_usuario',
                    'required' => 'required',
                    'pattern' => '^[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]{2,50}$',
                    'title' => 'Solo letras y espacios. Mínimo 2 y máximo 50 caracteres.',
                    'maxlength' => 50,
                ]) }}
            </div>
        </div>
        {{-- ======================= --}}
        <div class="col-12 col-md-4">
            <div class="form-group d-flex flex-column">
                <label for="apellido_usuario" class="" style="font-size: 15px">Apellido Usuario
                    <span class="text-danger">*</span></label>
                {{ Form::text('apellido_usuario', isset($usuario) ? $usuario->apellido_usuario : null, [
                    'class' => 'form-control',
                    'id' => 'apellido_usuario',
                    'required' => 'required',
                    'pattern' => '^[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]{2,50}$',
                    'title' => 'Solo letras y espacios. Mínimo 2 y máximo 50 caracteres.',
                    'maxlength' => 50,
                ]) }}
            </div>
        </div>
        {{-- ======================= --}}
        <div class="col-12 col-md-4">
            <div class="form-group d-flex flex-column">
                <label for="celular" class="" style="font-size: 15px">Celular
                    <span class="text-danger">*</span>
                </label>
                {{ Form::text('celular', isset($usuario) ? $usuario->celular : null, [
                    'class' => 'form-control',
                    'id' => 'celular',
                    'required' => 'required',
                    'title' => 'Debe ser un número de celular válido, sin indicativos, entre 7 y 15 dígitos.',
                    'maxlength' => 15,
                    'minlength' => 7,
                ]) }}
            </div>
        </div>

    </div>

    {{-- ============================================== --}}

    <div class="row m-2">

        <div class="col-12 col-md-3">
            <div class="form-group d-flex flex-column">
                <label for="numero_telefono" class="" style="font-size: 15px">Número Teléfono</label>
                {{ Form::text('numero_telefono', isset($usuario) ? $usuario->numero_telefono : null, [
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
        <div class="col-12 col-md-3">
            <div class="form-group d-flex flex-column">
                <label for="email" class="" style="font-size: 15px">Correo
                    <span class="text-danger">*</span></label>
                {{ Form::email('email', isset($usuario) ? $usuario->email : null, [
                    'class' => 'form-control',
                    'id' => 'email',
                    'required' => 'required',
                    'pattern' => '^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$',
                    'title' => 'Por favor, ingresa un correo electrónico válido',
                ]) }}
            </div>
        </div>
        {{-- ======================= --}}
        <div class="col-12 col-md-3">
            <div class="form-group d-flex flex-column">
                <label for="id_rol" class="" style="font-size: 15px">Rol
                    <span class="text-danger">*</span>
                </label>
                @php
                    $rolesFinales = (session('id_empresa') == 5) ? $roles : $rolesTenant;
                @endphp

                {!! Form::select(
                    'id_rol',
                    collect(['' => 'Seleccionar...'])->union($rolesFinales),
                    isset($usuario) ? $usuario->id_rol : null,
                    ['class' => 'form-select select2', 'id' => 'id_rol'],
                ) !!}
            </div>
        </div>
        {{-- ======================= --}}
        @if (@session('id_empresa') == 5)
            <div class="col-12 col-md-3">
                <div class="form-group d-flex flex-column">
                    <label for="id_empresa" class="" style="font-size: 15px">Empresa
                        <span class="text-danger">*</span>
                    </label>
                    {!! Form::select(
                        'id_empresa',
                        collect(['' => 'Seleccionar...'])->union($empresas),
                        isset($usuario) ? $usuario->id_empresa : null,
                        ['class' => 'form-select select2', 'id' => 'id_empresa'],
                    ) !!}
                </div>
            </div>
        @endif
    </div>

    {{-- ============================================== --}}

    <div class="row m-2">
        <div class="col-12 col-md-3">
            <div class="form-group d-flex flex-column">
                <label for="direccion" class="" style="font-size: 15px">Dirección</label>
                {{ Form::text('direccion', isset($usuario) ? $usuario->direccion : null, [
                    'class' => 'form-control',
                    'id' => 'direccion',
                    'pattern' => '^[a-zA-Z0-9\s\#\-\.\,\/]{5,100}$',
                    'title' =>
                        'Ingrese una dirección válida (solo letras, números y caracteres como # - . , /). Mínimo 5 y máximo 100                                                  caracteres.',
                    'maxlength' => 100,
                    'minlength' => 5,
                ]) }}
            </div>
        </div>
        {{-- ======================= --}}
        <div class="col-12 col-md-3">

            <div class="form-group d-flex flex-column">
                <label for="id_genero" class="" style="font-size: 15px">Género
                    <span class="text-danger">*</span></label>
                {!! Form::select(
                    'id_genero',
                    collect(['' => 'Seleccionar...'])->union($generos),
                    isset($usuario) ? $usuario->id_genero : null,
                    ['class' => 'form-select select2', 'id' => 'id_genero'],
                ) !!}
            </div>


        </div>
        {{-- ======================= --}}
        <div class="col-12 col-md-3">
            <div class="form-group d-flex flex-column">
                <label for="id_estado" class="" style="font-size: 15px">Estado
                    <span class="text-danger">*</span>
                </label>
                {!! Form::select(
                    'id_estado',
                    collect(['' => 'Seleccionar...'])->union($estados),
                    isset($usuario) ? $usuario->id_estado : null,
                    ['class' => 'form-select select2', 'id' => 'id_estado_' . $usuario->id_usuario],
                ) !!}
            </div>
        </div>
        {{-- ======================= --}}
        <div class="col-12 col-md-3">
            <div class="form-group d-flex flex-column">
                <label for="fecha_contrato" class="">Fecha
                    contrato
                    <span class="text-danger">*</span>
                </label>
                {!! Form::date('fecha_contrato', isset($usuario) ? $usuario->fecha_contrato : null, [
                    'class' => 'form-control',
                    'id' => 'fecha_contrato',
                    'required' => 'required',
                    'onkeydown' => 'return false'
                ]) !!}
            </div>
        </div>
        {{-- ======================= --}}
        <div class="col-12 col-md-3" id="div_fecha_terminacion_contrato_{{ $usuario->id_usuario }}">
            <div class="form-group d-flex flex-column">
                <label for="fecha_terminacion_contrato" class="">Fecha terminación contrato
                    <span class="text-danger">*</span>
                </label>
                {!! Form::date('fecha_terminacion_contrato', isset($usuario) ? $usuario->fecha_terminacion_contrato : null, [
                    'class' => 'form-control',
                    'id' => 'fecha_terminacion_contrato_' . $usuario->id_usuario,
                    'onkeydown' => 'return false'
                ]) !!}
            </div>
        </div>
    </div>
</div> {{-- FIN modal-body --}}

{{-- ====================================================== --}}
{{-- ====================================================== --}}

<div class="modal-footer d-block mt-0 border border-0">
    <!-- Contenedor para el GIF -->
    <div id="loadingIndicatorEditUser_{{ $usuario->id_usuario }}" class="loadingIndicator">
        <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
    </div>

    {{-- ====================================================== --}}
    {{-- ====================================================== --}}

    <div class="d-flex justify-content-center mt-3">
        <button id="btn_editar_user_{{ $usuario->id_usuario }}" type="submit" class="btn btn-success me-3"
            title="Guardar Configuración">
            <i class="fa fa-floppy-o" aria-hidden="true">
                Modificar</i>
        </button>

        <button id="btn_cancelar_user_{{ $usuario->id_usuario }}" type="button" class="btn btn-secondary"
            title="Cancelar" data-bs-dismiss="modal">
            <i class="fa fa-times" aria-hidden="true"> Cancelar</i>
        </button>
    </div>
</div> {{-- modal-footer --}}
{!! Form::close() !!}
{{-- FINAL Modal EDITAR USUARIO --}}
