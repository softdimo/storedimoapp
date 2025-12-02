<div class="p-0" style="border: solid 1px #337AB7; border-radius: 5px 5px 0 0;">
    <h5 class="border rounded-top text-white text-center pt-2 pb-2 m-0" style="background-color: #337AB7">
        Editar Suscripción (Obligatorios * )
    </h5>

    <div class="row m-0 p-3" id="div_campos_usuarios">
        {{-- {!! Form::hidden('id_suscripcion', null, [
            'class' => '',
            'id' => 'id_suscripcion',
            'required' => 'required',
        ]) !!} --}}

        <div class="col-12 col-md-3 mt-3">
            <div class="form-group d-flex flex-column">
                <label for="id_empresa_suscrita" class="form-label">Empresa <span class="text-danger">*</span></label>
                {!! Form::select('id_empresa_suscrita', collect(['' => 'Seleccionar...'])->union($empresas), old('id_empresa_suscrita', isset($suscripcionEdit) ? $suscripcionEdit->id_empresa_suscrita : null), [
                    'class' => 'form-select select2',
                    'id' => 'id_empresa_suscrita',
                    'required' => 'required',
                ]) !!}
            </div>
        </div>

        {{-- ======================= --}}
        {{-- ======================= --}}

        <div class="col-12 col-md-3 mt-3">
            <div class="form-group d-flex flex-column">
                <label for="id_plan_suscrito" class="form-label">Plan <span class="text-danger">*</span></label>
                {!! Form::select('id_plan_suscrito', collect(['' => 'Seleccionar...'])->union($planes), old('id_plan_suscrito', isset($suscripcionEdit) ? $suscripcionEdit->id_plan_suscrito : null), [
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
                {{-- {!! Form::text('valor_mensual', old('valor_mensual', isset($suscripcionEdit) ? $suscripcionEdit->valor_mensual : null), [ --}}
                {!! Form::text('valor_mensual', null), [
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
                {{-- {!! Form::text('valor_trimestral', old('valor_trimestral', isset($suscripcionEdit) ? $suscripcionEdit->valor_trimestral : null), [ --}}
                {!! Form::text('valor_trimestral', null), [
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
                {{-- {!! Form::text('valor_semestral', old('valor_semestral', isset($suscripcionEdit) ? $suscripcionEdit->valor_semestral : null), [ --}}
                {!! Form::text('valor_semestral', null), [
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
                {{-- {!! Form::text('valor_anual', old('valor_anual', isset($suscripcionEdit) ? $suscripcionEdit->valor_anual : null), [ --}}
                {!! Form::text('valor_anual', null), [
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
                {!! Form::text('descripcion_plan', old('descripcion_plan', isset($suscripcionEdit) ? $suscripcionEdit->descripcion_plan : null), [
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
                {!! Form::text('dias_trial', old('dias_trial', isset($suscripcionEdit) ? $suscripcionEdit->dias_trial : 15), [
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
                {!! Form::select('id_tipo_pago', collect(['' => 'Seleccionar...'])->union($tipos_pago_suscripcion), old('id_tipo_pago', isset($suscripcionEdit) ? $suscripcionEdit->id_tipo_pago : null), [
                    'class' => 'form-select select2',
                    'id' => 'id_tipo_pago'
                ]) !!}
            </div>
        </div>

        {{-- ======================= --}}
        
        <div class="col-12 col-md-3 mt-3">
            <div class="form-group d-flex flex-column">
                <label for="valor_suscripcion" class="form-label">Valor Suscripción</label>
                {!! Form::text('valor_suscripcion', old('valor_suscripcion', isset($suscripcionEdit) ? $suscripcionEdit->valor_suscripcion : null), [
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
                {!! Form::date('fecha_inicial', old('fecha_inicial', isset($suscripcionEdit) ? $suscripcionEdit->fecha_inicial : null), [
                    'class' => 'form-control',
                    'id' => 'fecha_inicial',
                    'required' => 'required',
                    // 'onkeydown' => 'return false',
                ]) !!}
            </div>
        </div>

        {{-- ======================= --}}

        <div class="col-12 col-md-3 mt-3">
            <div class="form-group d-flex flex-column">
                <label for="fecha_final" class="form-label">Fecha Final<span class="text-danger">*</span></label>
                {!! Form::date('fecha_final', old('fecha_final', isset($suscripcionEdit) ? $suscripcionEdit->fecha_final : null), [
                    'class' => 'form-control',
                    'id' => 'fecha_final',
                    'required' => 'required'
                    // 'onkeydown' => 'return false',
                ]) !!}
            </div>
        </div>

        {{-- ======================= --}}

        <div class="col-12 col-md-3 mt-3">
            <div class="form-group d-flex flex-column">
                <label for="id_estado_suscripcion" class="form-label">Estado<span class="text-danger">*</span></label>
                {!! Form::select('id_estado_suscripcion', collect(['' => 'Seleccionar...'])->union($estados_suscripciones), old('id_estado_suscripcion', isset($suscripcionEdit) ? $suscripcionEdit->id_estado_suscripcion : null), [
                    'class' => 'form-select select2',
                    'id' => 'id_estado_suscripcion',
                    'required' => 'required',
                ]) !!}
            </div>
        </div>

        {{-- ======================= --}}
        
        <div class="col-12 col-md-3 mt-3">
            <div class="form-group d-flex flex-column">
                <label for="fecha_cancelacion" class="form-label">Fecha Cancelación</label>
                {!! Form::date('fecha_cancelacion', old('fecha_cancelacion', isset($suscripcionEdit) ? $suscripcionEdit->fecha_cancelacion : null), ['class' => 'form-control', 'id' => 'fecha_cancelacion']) !!}
            </div>
        </div>

        {{-- ======================= --}}

        <div class="col-12 col-md-3 mt-3">
            <div class="d-flex flex-column justify-content-center align-items-center">
                <label for="renovacion_automatica" class="form-check-label">Renovación Automática</label>
                {{-- {!! Form::checkbox('renovacion_automatica', 1, false, ['class' => 'form-check-input','id' => 'renovacion_automatica','style' => 'margin-top: 1.25em;']) !!} --}}

                {!! Form::checkbox(
                    'renovacion_automatica',
                    1, // Valor que se envía si está marcado
                    old('renovacion_automatica', isset($suscripcionEdit) ? $suscripcionEdit->renovacion_automatica : false),
                    [
                        'class' => 'form-check-input',
                        'id' => 'renovacion_automatica',
                        'style' => 'margin-top: 1.25em;'
                    ]
                ) !!}
            </div>
        </div>

        {{-- ======================= --}}
        
        <div class="col-12 mt-3">
            <div class="form-group d-flex flex-column">
                <label for="observaciones_suscripcion" class="form-label">Observaciones Suscripción</label>
                {!! Form::textarea('observaciones_suscripcion', old('observaciones_suscripcion', isset($suscripcionEdit) ? $suscripcionEdit->observaciones_suscripcion : null), [
                    'class' => 'form-control',
                    'id' => 'observaciones_suscripcion',
                    'rows' => 3
                ]) !!}
            </div>
        </div>
    </div> {{-- FIN div_campos_usuarios --}}
</div> {{-- FIN div_crear_usuario --}}
