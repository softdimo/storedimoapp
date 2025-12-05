<div class="p-0" style="border: solid 1px #337AB7; border-radius: 5px 5px 0 0;">
    <h5 class="border rounded-top text-white text-center pt-2 pb-2 m-0" style="background-color: #337AB7">
        Registrar Planes (Obligatorios * )
    </h5>

    <div class="row m-0 p-3" id="div_campos_plaes">
        <div class="col-12 col-md-3 mt-3">
            <div class="form-group d-flex flex-column">
                <label for="nombre_plan" class="form-label">Nombre Plan
                    <span class="text-danger">*</span>
                </label>
                {!! Form::text('nombre_plan', old('nombre_plan', $planEdit?->nombre_plan ?? null), [
                    'class' => 'form-control',
                    'id' => 'nombre_plan',
                    'required' => 'required'
                ]) !!}
            </div>
        </div>

        {{-- ======================= --}}

        <div class="col-12 col-md-3 mt-3">
            <div class="form-group d-flex flex-column">
                <label for="valor_mensual" class="form-label">Valor Mensual
                    <span class="text-danger">*</span>
                </label>
                {!! Form::text('valor_mensual', old('valor_mensual', $planEdit?->valor_mensual ?? null), [
                    'class' => 'form-control',
                    'id' => 'valor_mensual',
                    'required' => 'required',
                ]) !!}
            </div>
        </div>
        
        {{-- ======================= --}}

        <div class="col-12 col-md-3 mt-3">
            <div class="form-group d-flex flex-column">
                <label for="valor_trimestral" class="form-label">Valor Trimestral
                    <span class="text-danger">*</span>
                </label>
                {!! Form::text('valor_trimestral', old('valor_trimestral', $planEdit?->valor_trimestral ?? null), [
                    'class' => 'form-control',
                    'id' => 'valor_trimestral',
                    'required' => 'required',
                ]) !!}
            </div>
        </div>
        
        {{-- ======================= --}}

        <div class="col-12 col-md-3 mt-3">
            <div class="form-group d-flex flex-column">
                <label for="valor_semestral" class="form-label">Valor Semestral
                    <span class="text-danger">*</span>
                </label>
                {!! Form::text('valor_semestral', old('valor_semestral', $planEdit?->valor_semestral ?? null), [
                    'class' => 'form-control',
                    'id' => 'valor_semestral',
                    'required' => 'required',
                ]) !!}
            </div>
        </div>
        
        {{-- ======================= --}}

        <div class="col-12 col-md-3 mt-3">
            <div class="form-group d-flex flex-column">
                <label for="valor_anual" class="form-label">Valor Anual
                    <span class="text-danger">*</span>
                </label>
                {!! Form::text('valor_anual', old('valor_anual', $planEdit?->valor_anual ?? null), [
                    'class' => 'form-control',
                    'id' => 'valor_anual',
                    'required' => 'required',
                ]) !!}
            </div>
        </div>
        
        {{-- ======================= --}}

        <div class="col-12 col-md-3 mt-3">
            <div class="form-group d-flex flex-column">
                <label for="descripcion_plan" class="form-label">Descripción
                    <span class="text-danger">*</span>
                </label>
                {!! Form::text('descripcion_plan', old('descripcion_plan', $planEdit?->descripcion_plan ?? null), [
                    'class' => 'form-control',
                    'id' => 'descripcion_plan',
                    'required' => 'required',
                ]) !!}
            </div>
        </div>

        {{-- ======================= --}}

        <div class="col-12 col-md-3 mt-3">
            <div class="form-group d-flex flex-column">
                <label for="id_estado_plan" class="form-label">id_estado_plan
                    <span class="text-danger">*</span>
                </label>
                {!! Form::select('id_estado_plan', collect(['' => 'Seleccionar...'])->union($estados), old('id_estado_plan', $planEdit->id_estado_plan ?? null), [
                    'class' => 'form-select select2',
                    'id' => 'id_estado_plan',
                    'required' => 'required',
                ]) !!}
            </div>
        </div>
    </div> {{-- FIN div_campos_planes --}}
</div> {{-- FIN div_crear_planes --}}
