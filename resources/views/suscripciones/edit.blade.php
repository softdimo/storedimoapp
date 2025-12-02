@extends('layouts.app')
@section('title', 'Editar Suscripción')

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('css')

@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('content')
    <div class="d-flex p-0">
        <div class="p-0 sidebar-container">
            @include('layouts.sidebarmenu')
        </div>

        {{-- ======================================================================= --}}
        {{-- ======================================================================= --}}

        <div class="p-3 content-container">
            <div class="d-flex justify-content-between pe-3 mt-3">
                <div class="">
                    <a href="{{ route('suscripciones.index') }}" class="btn text-white"
                        style="background-color:#337AB7">Suscripciones</a>
                </div>
            </div>

            {{-- =============================================================== --}}
            {{-- =============================================================== --}}

            {!! Form::open([
                'method' => 'PUT',
                'route' => ['suscripciones.update', $suscripcionEdit->id_suscripcion],
                'class' => 'mt-2',
                'autocomplete' => 'off',
                'id' => 'formEditarSuscripcion_' . $suscripcionEdit->id_suscripcion ]) !!}
                @csrf

                @include('suscripciones.fields_suscripciones')

                {{-- ========================================================= --}}
                {{-- ========================================================= --}}

                <!-- Contenedor para el GIF -->
                <div id="loadingIndicatorEditarSuscripcion_{{ $suscripcionEdit->id_suscripcion }}" class="loadingIndicator">
                    <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
                </div>

                {{-- ========================================================= --}}
                {{-- ========================================================= --}}

                <div class="mt-4 mb-0 d-flex justify-content-center">
                    <button type="submit" class="btn btn-success rounded-2 me-3" id="btn_editar_suscripcion_{{ $suscripcionEdit->id_suscripcion }}">
                        <i class="fa fa-floppy-o"> Editar</i>
                    </button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                // placeholder: "Seleccionar...",
                allowClear: false,
                width: '100%'
            });

            // ==============================================================
            // ==============================================================

            // 1. DEFINICIÓN DEL SELECTOR DINÁMICO DEL FORMULARIO
            // Usamos Blade para obtener el ID de la suscripción y construir el selector
            const suscripcionId = '{{ $suscripcionEdit->id_suscripcion }}';
            const formSelector = '#formEditarSuscripcion_' + suscripcionId;

            // 2. OBTENER EL ID DEL PLAN AL CARGAR LA PÁGINA (uso directo del ID del Select)
            const idPlan = $(formSelector).find('#id_plan_suscrito').val();
            console.log('idPlan', idPlan); // Verifica que obtenga el ID correcto

            // ==============================================================
            // ==============================================================

            // CACHÉ DE DATOS ORIGINALES DEL SERVIDOR
            // Almacenamos los valores que vienen de $suscripcionEdit para poder
            // restaurarlos si el usuario regresa al plan original.
            const originalSuscripcionData = {
                fecha_inicial: $(formSelector).find('#fecha_inicial').val(),
                fecha_final: $(formSelector).find('#fecha_final').val(),
                id_estado_suscripcion: $(formSelector).find('#id_estado_suscripcion').val(),
                dias_trial: $('#dias_trial').val() // Este campo es único, selector directo es suficiente
            };
            console.log('Datos originales cargados:', originalSuscripcionData);

            // ==============================================================
            // ==============================================================

            const planesData = @json($planesData);
            const plan = planesData[idPlan] ?? planesData[String(idPlan)] ?? null;

            console.log('planesData cargados:', planesData);

            // ==============================================================

            // 3. FUNCIÓN DE INICIALIZACIÓN (llamada al cargar la página)
            function inicializarFormulario(idPlan) {
                const plan = planesData[idPlan] ?? planesData[String(idPlan)] ?? null;
            
                // asignar valores a los inputs (si plan es null, dejar vacío)
                if (idPlan == 1) {

                    $('#div_dias_trial').show();

                    $('#valor_mensual').val('');
                    $('#div_valor_mensual').hide('slow');

                    $('#valor_trimestral').val('');
                    $('#div_valor_trimestral').hide('slow');

                    $('#valor_semestral').val('');
                    $('#div_valor_semestral').hide('slow');

                    $('#valor_anual').val('');
                    $('#div_valor_anual').hide('slow');

                    $('#descripcion_plan').val('');
                    $('#div_descripcion_plan').hide('slow');

                    $('#div_id_tipo_pago').hide();
                    $('#id_tipo_pago').removeAttr('required');
                    $('#id_tipo_pago').val('').trigger('change'); // Reiniciar selección

                    $('#valor_suscripcion').val(0);
                    
                } else if (idPlan != 1 && idPlan != '') {

                    if (plan) {

                        $('#div_dias_trial').hide();

                        $('#div_valor_mensual').show();
                        $('#valor_mensual').val(plan.valor_mensual ?? '');

                        $('#div_valor_trimestral').show();
                        $('#valor_trimestral').val(plan.valor_trimestral ?? '');

                        $('#div_valor_semestral').show();
                        $('#valor_semestral').val(plan.valor_semestral ?? '');

                        $('#div_valor_anual').show();
                        $('#valor_anual').val(plan.valor_anual ?? '');

                        $('#div_descripcion_plan').show();
                        $('#descripcion_plan').val(plan.descripcion_plan ?? '');

                        $('#div_id_tipo_pago').show();
                        $('#id_tipo_pago').attr('required');
                        $('#valor_suscripcion').val('');

                        // $('#formEditarSuscripcion').find('#fecha_inicial').val('').trigger('change');
                        // $('#formEditarSuscripcion').find('#fecha_final').val('').trigger('change');

                        // AGREGAR: Permitir escritura nuevamente
                        $('#formEditarSuscripcion').find('#fecha_inicial').removeAttr('readonly').removeClass('bg-secondary-subtle');
                        $('#formEditarSuscripcion').find('#fecha_final').removeAttr('readonly').removeClass('bg-secondary-subtle');

                        // $('#formEditarSuscripcion').find('#id_estado_suscripcion').val('').trigger('change');
                    }

                } else {

                    $('#div_dias_trial').hide();

                    $('#valor_mensual').val('');
                    $('#div_valor_mensual').hide('slow');

                    $('#valor_trimestral').val('');
                    $('#div_valor_trimestral').hide('slow');

                    $('#valor_semestral').val('');
                    $('#div_valor_semestral').hide('slow');

                    $('#valor_anual').val('');
                    $('#div_valor_anual').hide('slow');

                    $('#descripcion_plan').val('');
                    $('#div_descripcion_plan').hide('slow');

                    $('#div_id_tipo_pago').hide();
                    $('#id_tipo_pago').removeAttr('required');
                    // $('#id_tipo_pago').val('').trigger('change');

                    // $('#formEditarSuscripcion').find('#fecha_inicial').val('').trigger('change');
                    // $('#formEditarSuscripcion').find('#fecha_final').val('').trigger('change');

                    $('#valor_suscripcion').val('');

                    // AGREGAR: Limpiar atributos por si acaso
                    $('#formEditarSuscripcion').find('#fecha_inicial').removeAttr('readonly').removeClass('bg-secondary-subtle');
                    $('#formEditarSuscripcion').find('#fecha_final').removeAttr('readonly').removeClass('bg-secondary-subtle');

                    // $('#formEditarSuscripcion').find('#id_estado_suscripcion').val('').trigger('change');
                }
            }

            // ==============================================================
            // ==============================================================

            // LLAMADA INICIAL AL CARGAR
            if (idPlan) {
                inicializarFormulario(idPlan);
                // También dispara la lógica de tipo de pago si ya hay uno seleccionado
                $('#id_tipo_pago').trigger('change');
            }

            // ==============================================================
            // ==============================================================

            // Función para obtener fecha LOCAL en formato YYYY-MM-DD
            function obtenerHoy() {
                const fecha = new Date();
                const year = fecha.getFullYear();
                const month = String(fecha.getMonth() + 1).padStart(2, '0'); // Meses van de 0-11
                const day = String(fecha.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

            // Función para sumar días respetando la zona horaria local
            function sumarDias(fechaString, dias) {
                // Truco: Al crear date con string "YYYY-MM-DD" javascript lo asume UTC a veces.
                // Mejor crearlo y ajustar componentes.
                const fecha = new Date(fechaString + 'T00:00:00'); // Forzamos hora local inicio día
                fecha.setDate(fecha.getDate() + parseInt(dias));
                
                const year = fecha.getFullYear();
                const month = String(fecha.getMonth() + 1).padStart(2, '0');
                const day = String(fecha.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

            // Usar jQuery + eventos de Select2 para máxima compatibilidad
            $('#id_plan_suscrito').on('change select2:select', function (e) {
                // obtener valor (siempre string)
                const idPlan = $(this).val();

                // obtener objeto del plan (las claves en planesData son strings; si no, convertimos)
                const plan = planesData[idPlan] ?? planesData[String(idPlan)] ?? null;

                // asignar valores a los inputs (si plan es null, dejar vacío)
                if (idPlan == 1) {

                    $('#div_dias_trial').show();

                    $('#valor_mensual').val('');
                    $('#div_valor_mensual').hide('slow');

                    $('#valor_trimestral').val('');
                    $('#div_valor_trimestral').hide('slow');

                    $('#valor_semestral').val('');
                    $('#div_valor_semestral').hide('slow');

                    $('#valor_anual').val('');
                    $('#div_valor_anual').hide('slow');

                    $('#descripcion_plan').val('');
                    $('#div_descripcion_plan').hide('slow');

                    $('#div_id_tipo_pago').hide();
                    $('#id_tipo_pago').removeAttr('required');
                    $('#id_tipo_pago').val('').trigger('change'); // Reiniciar selección

                    $('#valor_suscripcion').val(0);

                    // 1. Obtener fecha de hoy
                    const hoy = obtenerHoy();
                    
                    // 2. Asignar a fecha inicial
                    $('#formEditarSuscripcion').find('#fecha_inicial').val(hoy).trigger('change');

                    // 3. Calcular días (asegurate que plan.dias_trial sea un número)
                    let diasTrial = $('#dias_trial').val();
                    const dias = (plan && plan.dias_trial) ? parseInt(plan.dias_trial) : diasTrial;

                    // 4. Calcular fecha final
                    const fechaFin = sumarDias(hoy, dias);
                    console.log('fechaInicial:', hoy);
                    console.log('fechaFin:', fechaFin);
                    
                    // 5. Asignar fecha final
                    $('#formEditarSuscripcion').find('#fecha_final').val(fechaFin).trigger('change');
                    
                    // ====================================================================
                    // RESTAURAR LOS VALORES ORIGINALES AL VOLVER A TRIAL
                    // ====================================================================
                    $(formSelector).find('#fecha_inicial').val(originalSuscripcionData.fecha_inicial).trigger('change');
                    $(formSelector).find('#fecha_final').val(originalSuscripcionData.fecha_final).trigger('change');
                    
                    // Bloquear escritura y clase
                    $(formSelector).find('#fecha_inicial').attr('readonly', true).addClass('bg-secondary-subtle').trigger('change');
                    $(formSelector).find('#fecha_final').attr('readonly', true).addClass('bg-secondary-subtle').trigger('change');

                    // Restaurar estado
                    $(formSelector).find('#id_estado_suscripcion').val(originalSuscripcionData.id_estado_suscripcion).trigger('change');
                    // $(formSelector).find('#id_estado_suscripcion').val(10).trigger('change');
                    
                    // El valor de la suscripción es 0 en trial, esto se mantiene.
                    $('#valor_suscripcion').val(0);
                    
                } else if (idPlan != 1 && idPlan != '') {

                    $('#div_dias_trial').hide();

                    $('#div_valor_mensual').show();
                    $('#valor_mensual').val(plan.valor_mensual ?? '');

                    $('#div_valor_trimestral').show();
                    $('#valor_trimestral').val(plan.valor_trimestral ?? '');

                    $('#div_valor_semestral').show();
                    $('#valor_semestral').val(plan.valor_semestral ?? '');

                    $('#div_valor_anual').show();
                    $('#valor_anual').val(plan.valor_anual ?? '');

                    $('#div_descripcion_plan').show();
                    $('#descripcion_plan').val(plan.descripcion_plan ?? '');

                    $('#div_id_tipo_pago').show();
                    $('#id_tipo_pago').attr('required');
                    $('#valor_suscripcion').val('');

                    $(formSelector).find('#fecha_inicial').val('').trigger('change');
                    $(formSelector).find('#fecha_final').val('').trigger('change');

                    $(formSelector).find('#fecha_inicial').removeAttr('readonly').removeClass('bg-secondary-subtle');
                    $(formSelector).find('#fecha_final').removeAttr('readonly').removeClass('bg-secondary-subtle');

                    $(formSelector).find('#id_estado_suscripcion').val('').trigger('change');

                } else {

                    $('#div_dias_trial').hide();

                    $('#valor_mensual').val('');
                    $('#div_valor_mensual').hide('slow');

                    $('#valor_trimestral').val('');
                    $('#div_valor_trimestral').hide('slow');

                    $('#valor_semestral').val('');
                    $('#div_valor_semestral').hide('slow');

                    $('#valor_anual').val('');
                    $('#div_valor_anual').hide('slow');

                    $('#descripcion_plan').val('');
                    $('#div_descripcion_plan').hide('slow');

                    $('#div_id_tipo_pago').hide();
                    $('#id_tipo_pago').removeAttr('required');
                    $('#id_tipo_pago').val('').trigger('change'); // Reiniciar selección

                    $(formSelector).find('#fecha_inicial').val('').trigger('change');
                    $(formSelector).find('#fecha_final').val('').trigger('change');

                    $('#valor_suscripcion').val('');

                    // LIMPIEZA DE ATRIBUTOS, Usar el selector dinámico para limpiar readonly
                    $(formSelector).find('#fecha_inicial').removeAttr('readonly').removeClass('bg-secondary-subtle');
                    $(formSelector).find('#fecha_final').removeAttr('readonly').removeClass('bg-secondary-subtle');

                    // LIMPIEZA DE ESTADO, Usar el selector dinámico
                    $(formSelector).find('#id_estado_suscripcion').val('').trigger('change');
                    $(formSelector).find('#observaciones_suscripcion').val('');
                }
            });

            // ==============================================================
            // ==============================================================

            $('#id_tipo_pago').on('change select2:select', function (e) {

                const idTipoPago = $(this).val();
                console.log(idTipoPago);
                

                let valorMensual = $('#valor_mensual').val();
                let valorTrimestral = $('#valor_trimestral').val();
                let valorSemestral = $('#valor_semestral').val();
                let valorAnual = $('#valor_anual').val();

                let valorSuscripcion = $('#valor_suscripcion');

                if (idTipoPago == 7) {
                    valorSuscripcion.val(valorMensual);
                } else if (idTipoPago == 8) {
                    valorSuscripcion.val(valorTrimestral);
                } else if (idTipoPago == 9) {
                    valorSuscripcion.val(valorSemestral);
                } else if (idTipoPago == 6) {
                    valorSuscripcion.val(valorAnual);
                } else {
                    valorSuscripcion.val('');
                }
            });

            // ==============================================================
            // ==============================================================

            // Evita permitir que el enter active el submit
            $(document).on('keypress', 'form[id^="formEditarSuscripcion_"]', function (e) {
                if (e.key === 'Enter' && !$(e.target).is('button[type="submit"]')) {
                    e.preventDefault();
                    return false;
                }
            });

            // ==============================================================
            // ==============================================================

            // formEditarSuscripcion para cargar gif en el submit
            $(document).on("submit", "form[id^='formEditarSuscripcion_']", function(e) {
                const form = $(this);
                const formId = form.attr('id'); // Obtenemos el ID del formulario
                const id = formId.split('_')[1]; // Obtener el ID del formulario desde el ID del formulario

                // Capturar el indicador de carga dinámicamente
                const submitButton = $(`#btn_editar_suscripcion_${id}`);
                const loadingIndicator = $(`#loadingIndicatorEditarSuscripcion_${id}`);

                // Lógica del botón
                submitButton.prop("disabled", true).html(
                    "Procesando... <i class='fa fa-spinner fa-spin'></i>"
                );

                // Cargar Spinner
                loadingIndicator.show();
            });
        }); // FIN document.readey
    </script>
@stop
