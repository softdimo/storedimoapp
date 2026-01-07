<div class="p-0" style="border: solid 1px #337AB7; border-radius: 5px 5px 0 0;">
    <h5 class="border rounded-top text-white text-center pt-2 pb-2 m-0" style="background-color: #337AB7">Registrar
        Usuarios (Obligatorios * )</h5>

    <div class="row m-0 p-3" id="div_campos_usuarios">
        {!! Form::hidden('id_usuario', null, [
            'class' => '',
            'id' => 'id_usuario',
            'required' => 'required',
        ]) !!}

        <div class="col-12 col-md-3 mt-3">
            <div class="form-group d-flex flex-column">
                <label for="id_tipo_persona" class="form-label">Tipo persona <span class="text-danger">*</span></label>
                {!! Form::select('id_tipo_persona', collect(['' => 'Seleccionar...'])->union($tipos_empleado), null, [
                    'class' => 'form-select select2',
                    'id' => 'id_tipo_persona',
                    'required' => 'required',
                ]) !!}
            </div>
        </div>

        <div class="col-12 col-md-3 mt-3">
            <div class="form-group d-flex flex-column">
                <label for="id_tipo_documento" class="form-label">Tipo de documento <span
                        class="text-danger">*</span></label>
                {!! Form::select('id_tipo_documento', collect(['' => 'Seleccionar...'])->union($tipos_documento_usuario), null, [
                    'class' => 'form-select select2',
                    'id' => 'id_tipo_documento',
                    'required' => 'required',
                ]) !!}
            </div>
        </div>

        {{-- ======================= --}}

        <div class="col-12 col-md-3 mt-3">
            <div class="form-group d-flex flex-column">
                <label for="identificacion" class="form-label">Número de documento <span
                        class="text-danger">*</span></label>
                {!! Form::text('identificacion', null, [
                    'class' => 'form-control',
                    'id' => 'identificacion',
                    'minlength' => 6,
                    'required' => 'required',
                ]) !!}
                <small id="documento-error" class="text-danger d-none">Este documento ya está registrado.</small>
            </div>
        </div>

        <div class="col-12 col-md-3 mt-3">
            <div class="form-group d-flex flex-column">
                <label for="nombre_usuario" class="form-label">Nombres <span class="text-danger">*</span></label>
                {!! Form::text('nombre_usuario', null, [
                    'class' => 'form-control',
                    'id' => 'nombre_usuario',
                    'required' => 'required',
                    'pattern' => '^[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]{2,30}$',
                    'title' => 'Solo letras y espacios. Mínimo 2 y máximo 30 caracteres.',
                    'maxlength' => 30,
                ]) !!}
            </div>
        </div>

        {{-- ======================= --}}

        <div class="col-12 col-md-3 mt-4">
            <div class="form-group d-flex flex-column">
                <label for="apellido_usuario" class="form-label">Apellidos <span class="text-danger">*</span></label>
                {!! Form::text('apellido_usuario', null, [
                    'class' => 'form-control',
                    'id' => 'apellido_usuario',
                    'required' => 'required',
                    'pattern' => '^[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]{2,30}$',
                    'title' => 'Solo letras y espacios. Mínimo 2 y máximo 30 caracteres.',
                    'maxlength' => 30,
                ]) !!}
            </div>
        </div>

        {{-- ======================= --}}

        <div class="col-12 col-md-3 mt-4">
            <div class="form-group d-flex flex-column">
                <label for="numero_telefono" class="form-label">Número de teléfono</label>
                {!! Form::text('numero_telefono', null, [
                    'class' => 'form-control',
                    'id' => 'numero_telefono',
                    'maxlength' => 10,
                    'minlength' => 7,
                    'inputmode' => 'numeric',
                    'pattern' => '^[0-9]*$',
                ]) !!}
                <span id="telefono-error" class="text-danger d-none mt-1"></span>
            </div>
        </div>

        {{-- ======================= --}}

        <div class="col-12 col-md-3 mt-4">
            <div class="form-group d-flex flex-column">
                <label for="celular" class="form-label">
                    Número de Celular
                    <span class="text-danger"> *</span>
                </label>
                {!! Form::text('celular', null, [
                    'class' => 'form-control',
                    'id' => 'celular',
                    'required' => 'required',
                    'inputmode' => 'numeric'
                ]) !!}
                <span id="celular-error" class="text-danger d-none mt-1" style="font-size: 0.85rem;"></span>
            </div>
        </div>
        
        {{-- ======================= --}}

        <div class="col-12 col-md-3 mt-4">
            <div class="form-group d-flex flex-column">
                <label for="email" class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                {!! Form::email('email', null, [
                    'class' => 'form-control',
                    'id' => 'email',
                    'required' => 'required',
                    'pattern' => '^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$',
                    'title' => 'Por favor, ingresa un correo electrónico válido',
                ]) !!}
                <small id="email-error" class="text-danger d-none">Este correo ya está registrado.</small>
            </div>
        </div>

        {{-- ======================= --}}

        <div class="col-12 col-md-3 mt-4">
            <div class="form-group d-flex flex-column">
                <label for="id_genero" class="form-label">Género<span class="text-danger">*</span></label>
                {!! Form::select('id_genero', collect(['' => 'Seleccionar...'])->union($generos), null, [
                    'class' => 'form-select select2',
                    'id' => 'id_genero',
                    'required' => 'required',
                ]) !!}
            </div>
        </div>

        {{-- ======================= --}}

        <div class="col-12 col-md-3 mt-4">
            <div class="form-group d-flex flex-column">
                <label for="direccion" class="form-label">Dirección</label>
                {!! Form::text('direccion', null, [
                    'class' => 'form-control',
                    'id' => 'direccion',
                    'pattern' => '^[a-zA-Z0-9\s\#\-\.\,\/]{5,100}$',
                    'title' =>
                        'Ingrese una dirección válida (solo letras, números y caracteres como # - . , /). Mínimo 5 y máximo 100 caracteres.',
                    'maxlength' => 100,
                    'minlength' => 5,
                ]) !!}
            </div>
        </div>

        {{-- ======================= --}}

        <div class="col-12 col-md-3 mt-4">
            <div class="form-group d-flex flex-column">
                <label for="id_rol" class="form-label">Rol<span class="text-danger">*</span></label>
                {!! Form::select('id_rol', collect(['' => 'Seleccionar...'])->union($roles), null, [
                    'class' => 'form-select select2',
                    'id' => 'id_rol',
                    'required' => 'required',
                ]) !!}
            </div>
        </div>

        {{-- ======================= --}}

        @if (@session('id_empresa') == 5)
            <div class="col-12 col-md-3 mt-4">
                <div class="form-group d-flex flex-column">
                    <label for="id_empresa" class="form-label">Empresa<span class="text-danger">*</span></label>
                    {!! Form::select('id_empresa', collect(['' => 'Seleccionar...'])->union($empresas), null, [
                        'class' => 'form-select select2',
                        'id' => 'id_empresa',
                        'required' => 'required',
                    ]) !!}
                </div>
            </div>
        @endif

        {{-- ======================= --}}

        <div class="col-12 col-md-3 mt-4">
            <div class="form-group d-flex flex-column">
                <label for="id_estado" class="form-label">Estado<span class="text-danger">*</span></label>
                {!! Form::select('id_estado', collect(['' => 'Seleccionar...'])->union($estados), 1, [
                    'class' => 'form-select select2',
                    'id' => 'id_estado',
                    'required' => 'required',
                ]) !!}
            </div>
        </div>

        {{-- ======================= --}}

        <div class="col-12 col-md-3 mt-4">
            <div class="form-group d-flex flex-column">
                <label for="fecha_contrato" class="form-label">Fecha contrato<span class="text-danger">*</span></label>
                {!! Form::date('fecha_contrato', null, [
                    'class' => 'form-control',
                    'id' => 'fecha_contrato',
                    'required' => 'required',
                    'onkeydown' => 'return false'
                ]) !!}
            </div>
        </div>

        {{-- ======================= --}}

        <div class="col-12 col-md-3 mt-4" id="div_fecha_terminacion_contrato">
            <div class="form-group d-flex flex-column">
                <label for="fecha_terminacion_contrato" class="form-label">Fecha terminación contrato<span
                        class="text-danger">*</span></label>
                {!! Form::date('fecha_terminacion_contrato', null, [
                    'class' => 'form-control',
                    'id' => 'fecha_terminacion_contrato',
                    'onkeydown' => 'return false'
                ]) !!}
            </div>
        </div>
    </div> {{-- FIN div_campos_usuarios --}}
</div> {{-- FIN div_crear_usuario --}}
