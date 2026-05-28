<div class="p-0" style="border: solid 1px #337AB7; border-radius: 5px 5px 0 0;">
    <h5 class="border rounded-top text-white text-center pt-2 pb-2 m-0" style="background-color: #337AB7">
        Crear Suscripción Empresa (Obligatorios * )
    </h5>

    {!! Form::open([
        'method' => 'POST',
        'route' => ['suscripcion_empresa.store'],
        'class' => 'mt-2',
        'autocomplete' => 'off',
        'id' => 'formCrearSuscripcionEmpresaLanding',
        'enctype' => 'multipart/form-data',
        'file' => true]) !!}
        @csrf

        <div class="m-0 p-3" id="div_campos_empresas">
            <div class="row">
                <div class="col-12 col-md-3" id="div_id_tipo_documento">
                    <div class="form-group d-flex flex-column">
                        <label for="id_tipo_documento" class="form-label">Tipo Documento
                            <span class="text-danger">*</span>
                        </label>
                        {!! Form::select('id_tipo_documento', collect(['' => 'Seleccionar...'])->union($tipos_documento), old('id_tipo_documento', null), [
                            'class' => 'form-select select2',
                            'id' => 'id_tipo_documento',
                            'required' => 'required',
                        ]) !!}
                    </div>
                </div>

                {{-- ======================= --}}

                <div class="col-12 col-md-3" id="div_nit_empresa">
                    <div class="form-group d-flex flex-column">
                        <label for="nit_empresa" class="form-label">Nit (Con dígito verificador)<span class="text-danger">*</span></label>
                        {!! Form::text('nit_empresa', old('nit_empresa', null), [
                            'class' => 'form-control',
                            'id' => 'nit_empresa',
                            'required' => 'required',
                            'maxlength' => '10',
                            'title' => 'Ingrese un NIT válido de 10 dígitos incluyendo el de verificación, sin guión',
                        ]) !!}
                        <span id="nit-error" class="text-danger d-none mt-1"></span>
                    </div>
                </div>

                {{-- ======================= --}}
                
                <div class="col-12 col-md-3" id="div_ident_empresa_natural">
                    <div class="form-group d-flex flex-column">
                        <label for="ident_empresa_natural" class="form-label">Id Persona Natural<span class="text-danger">*</span></label>
                        {!! Form::text('ident_empresa_natural', old('ident_empresa_natural', null), [
                            'class' => 'form-control',
                            'id' => 'ident_empresa_natural',
                            'required' => 'required',
                            // 'maxlength' => '9',
                            'title' => 'Ingrese una Identificación válida',
                        ]) !!}
                        <span id="ident-natural-error" class="text-danger d-none mt-1"></span>
                    </div>
                </div>

                {{-- ======================= --}}

                <div class="col-12 col-md-3">
                    <div class="form-group d-flex flex-column">
                        <label for="nombre_empresa" class="form-label">Nombre Empresa
                            <span class="text-danger">*</span>
                        </label>
                        {!! Form::text('nombre_empresa', old('nombre_empresa', null), [
                            'class' => 'form-control',
                            'id' => 'nombre_empresa',
                            'required' => 'required',
                            'pattern' => '^[a-zA-ZÁÉÍÓÚÑáéíóúñ0-9\s\.,&\-]{2,100}$',
                            'title' => 'El nombre puede incluir letras, números, espacios y algunos caracteres como ., - &',
                            'maxlength' => 100,
                        ]) !!}
                    </div>
                </div>

                {{-- ======================= --}}

                <div class="col-12 col-md-3">
                    <div class="form-group d-flex flex-column">
                        <label for="telefono_empresa" class="form-label">Teléfono Empresa</label>
                        {!! Form::text('telefono_empresa', old('telefono_empresa', null), [
                            'class' => 'form-control',
                            'id' => 'telefono_empresa',
                            'title' => 'Debe tener entre 7 y 10 dígitos.',
                            'maxlength' => 10,
                            'minlength' => 7,
                        ]) !!}
                        <span id="telefono-error" class="text-danger d-none mt-1"></span>
                    </div>
                </div>

                {{-- ======================= --}}

                <div class="col-12 col-md-3" id="div_celular">
                    <div class="form-group d-flex flex-column">
                        <label for="celular_empresa" class="form-label">Número de Celular
                            <span class="text-danger">*</span>
                        </label>
                        {!! Form::text('celular_empresa', old('celular_empresa', null), [
                            'class' => 'form-control',
                            'id' => 'celular_empresa',
                            'required' => 'required',
                            'title' => 'Debe ser un número de celular válido, sin indicativos, entre 7 y 15 dígitos.',
                            'maxlength' => 15,
                            'minlength' => 7,
                        ]) !!}
                    </div>
                </div>

                {{-- ======================= --}}

                <div class="col-12 col-md-3 mt-3" id="div_email">
                    <div class="form-group d-flex flex-column">
                        <label for="email_empresa" class="form-label">Correo Electrónico
                            <span class="text-danger">*</span>
                        </label>
                        {!! Form::email('email_empresa', old('email_empresa', null), [
                            'class' => 'form-control',
                            'id' => 'email_empresa',
                            'required' => 'required',
                            'oninput' => 'validarEmail(this)',
                        ]) !!}
                        <span id="error_email" class="text-danger"></span>
                    </div>
                </div>

                {{-- ======================= --}}

                <div class="col-12 col-md-3 mt-3" id="div_direccion">
                    <div class="form-group d-flex flex-column">
                        <label for="direccion_empresa" class="form-label">Dirección
                            <span class="text-danger">*</span>
                        </label>
                        {!! Form::text('direccion_empresa', old('direccion_empresa', null), [
                            'class' => 'form-control',
                            'id' => 'direccion_empresa',
                            'pattern' => '^[a-zA-Z0-9\s\#\-\.\,\/]{5,100}$',
                            'title' => 'Ingrese una dirección válida (solo letras, números y caracteres como # - . , /). Mínimo 5 y máximo 100 caracteres.',
                            'maxlength' => 100,
                            'minlength' => 5,
                        ]) !!}
                    </div>
                </div>

                {{-- ======================= --}}
                
                <div class="col-12 col-md-3 mt-3">
                    <div class="form-group d-flex flex-column file-container">
                        <label for="logo_empresa" class="form-label">Logo
                            <span class="text-danger">(jpg, jpeg, png o webp)</span>
                        </label>
                        <div class="div-file">
                            {!! Form::file('logo_empresa', [
                                'class' => 'form-control file',
                                'id' => 'logo_empresa',
                                'onchange' => 'displaySelectedFile("logo_empresa","selected_logo_empresa")',
                                'accept' => 'image/jpg,image/jpeg,image/png,image/webp',
                            ]) !!}
                        </div>
                        <span id="selected_logo_empresa" class="text-danger hidden"></span>
                    </div>
                </div>
            </div>
        </div> {{-- FIN div_campos_empresas --}}

        <hr class="ms-3 me-3">

        {{-- ========================================================= --}}
        {{-- ========================================================= --}}

        {{-- INICIO CAMPOS SUSCRIPCIÓN --}}

        <div class="m-0 pt-0 pe-3 pb-3 ps-3">
            <div class="row">
                <div class="col-12 col-md-3 mt-3">
                    <div class="form-group d-flex flex-column">
                        <label for="id_plan_suscrito" class="form-label">Plan <span class="text-danger">*</span></label>
                        {!! Form::select('id_plan_suscrito', collect(['' => 'Seleccionar...'])->union($planes), old('id_plan_suscrito', null), [
                            'class' => 'form-select select2',
                            'id' => 'id_plan_suscrito',
                            'required' => 'required',
                        ]) !!}
                    </div>
                </div>
            
                {{-- ======================= --}}
            
                <div class="col-12 col-md-3 mt-3" id="div_valor_mensual">
                    <div class="form-group d-flex flex-column">
                        <label for="valor_mensual" class="form-label">Valor Mensual</label>
                        {!! Form::text('valor_mensual', null, [
                            'class' => 'form-control bg-secondary-subtle',
                            'id' => 'valor_mensual',
                            'readonly' => true
                        ]) !!}
                    </div>
                </div>
            
                {{-- ======================= --}}
            
                <div class="col-12 col-md-3 mt-3" id="div_valor_trimestral">
                    <div class="form-group d-flex flex-column">
                        <label for="valor_trimestral" class="form-label">Valor Trimestral</label>
                        {!! Form::text('valor_trimestral', null, [
                            'class' => 'form-control bg-secondary-subtle',
                            'id' => 'valor_trimestral',
                            'readonly' => true
                        ]) !!}
                    </div>
                </div>
            
                {{-- ======================= --}}
            
                <div class="col-12 col-md-3 mt-3" id="div_valor_semestral">
                    <div class="form-group d-flex flex-column">
                        <label for="valor_semestral" class="form-label">Valor Semestral</label>
                        {!! Form::text('valor_semestral', null, [
                            'class' => 'form-control bg-secondary-subtle',
                            'id' => 'valor_semestral',
                            'readonly' => true
                        ]) !!}
                    </div>
                </div>
                
                {{-- ======================= --}}
            
                <div class="col-12 col-md-3 mt-3" id="div_valor_anual">
                    <div class="form-group d-flex flex-column">
                        <label for="valor_anual" class="form-label">Valor Anual</label>
                        {!! Form::text('valor_anual', null, [
                            'class' => 'form-control bg-secondary-subtle',
                            'id' => 'valor_anual',
                            'readonly' => true
                        ]) !!}
                    </div>
                </div>
                
                {{-- ======================= --}}
            
                <div class="col-12 col-md-3 mt-3" id="div_descripcion_plan">
                    <div class="form-group d-flex flex-column">
                        <label for="descripcion_plan" class="form-label">Descripción Plan</label>
                        {!! Form::text('descripcion_plan', null, [
                            'class' => 'form-control bg-secondary-subtle',
                            'id' => 'descripcion_plan',
                            'readonly' => true
                        ]) !!}
                    </div>
                </div>
            
                {{-- ======================= --}}
                {{-- ======================= --}}
                
                <div class="col-12 col-md-3 mt-3" id="div_dias_trial">
                    <div class="form-group d-flex flex-column">
                        <label for="dias_trial" class="form-label">Días Trial</label>
                        {!! Form::text('dias_trial', old('dias_trial', 15), [
                            'class' => 'form-control bg-info',
                            'id' => 'dias_trial',
                            'readonly' => true
                        ]) !!}
                    </div>
                </div>
            
                {{-- ======================= --}}
            
                <div class="col-12 col-md-3 mt-3" id="div_id_tipo_pago">
                    <div class="form-group d-flex flex-column">
                        <label for="id_tipo_pago" class="form-label">Modalidad Suscripción<span class="text-danger">*</span></label>
                        {!! Form::select('id_tipo_pago', collect(['' => 'Seleccionar...'])->union($tipos_pago_suscripcion), old('id_tipo_pago', null), [
                            'class' => 'form-select',
                            'id' => 'id_tipo_pago'
                        ]) !!}
                    </div>
                </div>
            
                {{-- ======================= --}}
                
                <div class="col-12 col-md-3 mt-3">
                    <div class="form-group d-flex flex-column">
                        <label for="valor_suscripcion" class="form-label">Valor Suscripción</label>
                        {!! Form::text('valor_suscripcion', old('valor_suscripcion', null), [
                            'class' => 'form-control bg-success-subtle',
                            'id' => 'valor_suscripcion',
                            'readonly' => true
                        ]) !!}
                    </div>
                </div>
            
                {{-- ======================= --}}
                
                <div class="col-12 col-md-3 mt-3">
                    <div class="form-group d-flex flex-column">
                        <label for="fecha_inicial" class="form-label">Fecha Inicial<span class="text-danger">*</span></label>
                        {!! Form::date('fecha_inicial', old('fecha_inicial', null), [
                            'class' => 'form-control',
                            'id' => 'fecha_inicial',
                            'required' => 'required',
                            'onkeydown' => 'return false'
                        ]) !!}
                    </div>
                </div>
            
                {{-- ======================= --}}
            
                <div class="col-12 col-md-3 mt-3">
                    <div class="form-group d-flex flex-column">
                        <label for="fecha_final" class="form-label">Fecha Final<span class="text-danger">*</span></label>
                        {!! Form::date('fecha_final', old('fecha_final', null), [
                            'class' => 'form-control',
                            'id' => 'fecha_final',
                            'required' => 'required',
                            'onkeydown' => 'return false'
                        ]) !!}
                    </div>
                </div>
            </div> {{-- FIN Row --}}
        </div> {{-- FIN div SUSCRIPCIÓN --}}

        {{-- ========================================================= --}}
        {{-- ========================================================= --}}

        <!-- Contenedor para el GIF -->
        <div id="loadingIndicatorEmpresaSuscripcionStore" class="loadingIndicator">
            <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
        </div>

        {{-- ========================================================= --}}
        {{-- ========================================================= --}}

        <div class="mt-5 mb-2 d-flex justify-content-center">
            <button type="submit" class="btn btn-success rounded-2 me-3">
                <i class="fa fa-floppy-o"></i>
                Guardar
            </button>
        </div>
    {!! Form::close() !!}
</div> {{-- FIN div_crear_empresa --}}
