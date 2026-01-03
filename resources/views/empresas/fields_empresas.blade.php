@php
    use Illuminate\Support\Facades\Crypt;
@endphp
<div class="m-0 p-3" id="div_campos_empresas">
    <div class="row">
        <div class="col-12 col-md-3">
            <div class="form-group d-flex flex-column">
                <label for="nit_empresa" class="form-label">Nit Empresa<span class="text-danger">*</span></label>
                {!! Form::text('nit_empresa', old('nit_empresa', isset($empresa) ? $empresa->nit_empresa : null), [
                    'class' => 'form-control',
                    'id' => 'nit_empresa',
                    'required' => 'required',
                    'maxlength' => '9',
                    'title' => 'Ingrese un NIT válido de 9 dígitos, sin guion ni dígito verificador',
                ]) !!}
                <span id="nit-error" class="text-danger d-none mt-1"></span>
            </div>
        </div>

        {{-- ======================= --}}

        <div class="col-12 col-md-3">
            <div class="form-group d-flex flex-column">
                <label for="nombre_empresa" class="form-label">Nombre Empresa
                    <span class="text-danger">*</span>
                </label>
                {!! Form::text('nombre_empresa', old('nombre_empresa', isset($empresa) ? $empresa->nombre_empresa : null), [
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
                <label for="telefono_empresa" class="form-label">Teléfono Empresa
                    <span class="text-danger">*</span>
                </label>
                {!! Form::text('telefono_empresa', old('telefono_empresa', isset($empresa) ? $empresa->telefono_empresa : null), [
                    'class' => 'form-control',
                    'id' => 'telefono_empresa',
                    'required' => 'required',
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
                {!! Form::text('celular_empresa', old('celular_empresa', isset($empresa) ? $empresa->celular_empresa : null), [
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
                {!! Form::email('email_empresa', old('email_empresa', isset($empresa) ? $empresa->email_empresa : null), [
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
                {!! Form::text('direccion_empresa', old('direccion_empresa', isset($empresa) ? $empresa->direccion_empresa : null), [
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
        
        {{-- <div class="col-12 col-md-3 mt-3" id="div_app_key">
            <div class="form-group d-flex flex-column">
                <label for="app_key" class="form-label">APP KEY
                    <span class="text-danger">*</span>
                </label>
                {!! Form::text('app_key', old('app_key', isset($empresa) ? Crypt::decrypt($empresa->app_key) : null), [
                    'class' => 'form-control',
                    'id' => 'app_key',
                    'required' => 'required',
                ]) !!}
            </div>
        </div> --}}

        {{-- ======================= --}}
        
        {{-- <div class="col-12 col-md-3 mt-3" id="div_app_url">
            <div class="form-group d-flex flex-column">
                <label for="app_url" class="form-label">APP URL
                    <span class="text-danger">*</span>
                </label>
                {!! Form::text('app_url', old('app_url', isset($empresa) ? $empresa->app_url : null), [
                    'class' => 'form-control',
                    'id' => 'app_url',
                    'required' => 'required',
                ]) !!}
            </div>
        </div> --}}

        {{-- ======================= --}}
        
        <div class="col-12 col-md-3 mt-3" id="div_db_connection">
            <div class="form-group d-flex flex-column">
                <label for="id_tipo_bd" class="form-label">Db Connection
                    <span class="text-danger">*</span>
                </label>
                {!! Form::select('id_tipo_bd', collect(['' => 'Seleccionar...'])->union($tipos_bd), old('id_tipo_bd', isset($empresa) ? $empresa->id_tipo_bd : 1), [
                    'class' => 'form-select',
                    'id' => 'id_tipo_bd',
                    'required' => 'required',
                ]) !!}
            </div>
        </div>

        {{-- ======================= --}}
        
        <div class="col-12 col-md-3 mt-3" id="div_app_url">
            <div class="form-group d-flex flex-column">
                <label for="db_host" class="form-label">Db Host
                    <span class="text-danger">*</span>
                </label>
                {!! Form::text('db_host', old('db_host', isset($empresa) ? Crypt::decrypt($empresa->db_host) : 'localhost'), [
                    'class' => 'form-control bg-dark-subtle',
                    'id' => 'db_host',
                    'required' => 'required',
                    'readonly' => 'readonly',
                ]) !!}
            </div>
        </div>

        {{-- ======================= --}}
        
        <div class="col-12 col-md-3 mt-3" id="div_db_database">
            <div class="form-group d-flex flex-column">
                <label for="db_database" class="form-label">DbDatabase pre(u524250720_)
                    <span class="text-danger">*</span>
                </label>
                {!! Form::text('db_database', old('db_database', isset($empresa) ? Crypt::decrypt($empresa->db_database) : null), [
                    'class' => 'form-control',
                    'id' => 'db_database',
                    'required' => 'required',
                ]) !!}
            </div>
        </div>

        {{-- ======================= --}}

        <div class="col-12 col-md-3 mt-3" id="div_db_username">
            <div class="form-group d-flex flex-column">
                <label for="db_username" class="form-label">DbUser pre(u524250720_)
                    <span class="text-danger">*</span>
                </label>
                {!! Form::text('db_username', old('db_username', isset($empresa) ? Crypt::decrypt($empresa->db_username) : null), [
                    'class' => 'form-control',
                    'id' => 'db_username',
                    'required' => 'required',
                ]) !!}
            </div>
        </div>

        {{-- ======================= --}}
        
        <div class="col-12 col-md-3 mt-3" id="div_db_password">
            <div class="form-group d-flex flex-column">
                <label for="db_password" class="form-label">Db Password
                    <span class="text-danger">*</span>
                </label>
                {!! Form::text('db_password', old('db_password', isset($empresa) ? Crypt::decrypt($empresa->db_password) : null), [
                    'class' => 'form-control',
                    'id' => 'db_password',
                    'required' => 'required',
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

        {{-- ======================= --}}

        <div class="col-12 col-md-3 mt-3" id="div_id_estado">
            <div class="form-group d-flex flex-column">
                <label for="id_estado" class="form-label">Estado
                    <span class="text-danger">*</span>
                </label>
                {!! Form::select('id_estado', collect(['' => 'Seleccionar...'])->union($estados), old('id_estado', isset($empresa) ? $empresa->id_estado : 1), [
                    'class' => 'form-select',
                    'id' => 'id_estado',
                    'required' => 'required',
                ]) !!}
            </div>
        </div>
    </div>
</div> {{-- FIN div_campos_empresas --}}
    