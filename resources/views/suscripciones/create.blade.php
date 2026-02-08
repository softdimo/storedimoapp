@extends('layouts.app')
@section('title', 'Crear Suscripción')

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
            <div class="d-flex justify-content-between pe-3 mt-3 mb-3">
                <div class="">
                    <a href="{{ route('suscripciones.index') }}" class="btn text-white"
                        style="background-color:#337AB7">Suscripciones
                    </a>
                </div>
            </div>

            {{-- =============================================================== --}}
            {{-- =============================================================== --}}

            <div class="p-0" style="border: solid 1px #337AB7; border-radius: 5px 5px 0 0;">
                <h5 class="border rounded-top text-white text-center pt-2 pb-2 m-0" style="background-color: #337AB7">
                    Crear Suscripción (Obligatorios * )
                </h5>

                {!! Form::open([
                    'method' => 'POST',
                    'route' => ['suscripciones.store'],
                    'class' => 'mt-2',
                    'autocomplete' => 'off',
                    'id' => 'formCrearSuscripcion',
                    ]) !!}
                    @csrf

                    @include('suscripciones.fields_suscripciones')

                    {{-- ========================================================= --}}
                    {{-- ========================================================= --}}

                    <!-- Contenedor para el GIF -->
                    <div id="loadingIndicatorStore" class="loadingIndicator">
                        <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
                    </div>

                    {{-- ========================================================= --}}
                    {{-- ========================================================= --}}

                    <div class="mt-4 mb-3 d-flex justify-content-center">
                        <button type="submit" class="btn btn-success rounded-2 me-3">
                            <i class="fa fa-floppy-o"></i>
                            Crear
                        </button>
                    </div>
                {!! Form::close() !!}
            </div> {{-- FIN div principal --}}
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
                allowClear: false,
                width: '100%'
            });

            $('.select2').on('select2:open', function (e) {
                // Buscamos el input de búsqueda dentro del contenedor de Select2 y le damos foco
                document.querySelector('.select2-search__field').focus();
            });

            // ==============================================================
            // ==============================================================

            $('#div_dias_trial').hide();
            $('#div_valor_mensual').hide();
            $('#div_valor_trimestral').hide();
            $('#div_valor_semestral').hide();
            $('#div_valor_anual').hide();
            $('#div_descripcion_plan').hide();
            $('#div_id_tipo_pago').hide();

            // ==============================================================
            // ==============================================================

            const planesData = @json($planesData);
            console.log('planesData cargados:', planesData);

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

            // ==============================================================
            // ==============================================================

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
                    $('#formCrearSuscripcion').find('#fecha_inicial').val(hoy).trigger('change');

                    // 3. Calcular días (asegurate que plan.dias_trial sea un número)
                    let diasTrial = $('#dias_trial').val();
                    const dias = (plan && plan.dias_trial) ? parseInt(plan.dias_trial) : diasTrial;

                    // 4. Calcular fecha final
                    const fechaFin = sumarDias(hoy, dias);
                    console.log('fechaInicial:', hoy);
                    console.log('fechaFin:', fechaFin);
                    
                    // 5. Asignar fecha final
                    $('#formCrearSuscripcion').find('#fecha_final').val(fechaFin).trigger('change');
                    
                    // AGREGAR: Bloquear escritura para que no modifiquen los 15 días
                    $('#formCrearSuscripcion').find('#fecha_inicial').attr('readonly', true).addClass('bg-secondary-subtle').trigger('change');
                    $('#formCrearSuscripcion').find('#fecha_final').attr('readonly', true).addClass('bg-secondary-subtle').trigger('change');

                    // Asignar 10 a estado Trial
                    // $('#formCrearSuscripcion').find('#id_estado_suscripcion').val(1).trigger('change');
                    
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

                    $('#formCrearSuscripcion').find('#fecha_inicial').val('').trigger('change');
                    $('#formCrearSuscripcion').find('#fecha_final').val('').trigger('change');

                    // AGREGAR: Permitir escritura nuevamente
                    $('#formCrearSuscripcion').find('#fecha_inicial').removeAttr('readonly').removeClass('bg-secondary-subtle');
                    $('#formCrearSuscripcion').find('#fecha_final').removeAttr('readonly').removeClass('bg-secondary-subtle');

                    $('#formCrearSuscripcion').find('#id_estado_suscripcion').val('').trigger('change');

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

                    $('#formCrearSuscripcion').find('#fecha_inicial').val('').trigger('change');
                    $('#formCrearSuscripcion').find('#fecha_final').val('').trigger('change');

                    $('#valor_suscripcion').val('');

                    // AGREGAR: Limpiar atributos por si acaso
                    $('#formCrearSuscripcion').find('#fecha_inicial').removeAttr('readonly').removeClass('bg-secondary-subtle');
                    $('#formCrearSuscripcion').find('#fecha_final').removeAttr('readonly').removeClass('bg-secondary-subtle');

                    $('#formCrearSuscripcion').find('#id_estado_suscripcion').val('').trigger('change');
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

                // Calcular días (asegurate que plan.dias_trial sea un número)
                let diasMensual = 30;
                let diasTrimestral = 90;
                let diasSemestral = 180;
                let diasAnual = 365;

                // Obtener fecha de hoy
                const hoy = obtenerHoy();

                let fechaFin = '';

                if (idTipoPago == 7) { // Mensual
                    valorSuscripcion.val(valorMensual);
                    fechaFin = sumarDias(hoy, diasMensual);

                } else if (idTipoPago == 8) { // Trimestral
                    valorSuscripcion.val(valorTrimestral);
                    fechaFin = sumarDias(hoy, diasTrimestral);

                } else if (idTipoPago == 9) { // Semestral
                    valorSuscripcion.val(valorSemestral);
                    fechaFin = sumarDias(hoy, diasSemestral);

                } else if (idTipoPago == 6) { // Anual
                    valorSuscripcion.val(valorAnual);
                    fechaFin = sumarDias(hoy, diasAnual);
                    
                } else {
                    valorSuscripcion.val('');
                }

                // Asignar a fecha inicial y fechfinal
                $('#formCrearSuscripcion').find('#fecha_inicial').val(hoy).trigger('change');
                $('#formCrearSuscripcion').find('#fecha_final').val(fechaFin).trigger('change');

                $('#formCrearSuscripcion').find('#id_estado_suscripcion').val(1).trigger('change');
            });

            // ==============================================================
            // ==============================================================

            // Evita permitir que el enter active el submit
            $(document).on('keypress', 'form[id^="formCrearSuscripcion"]', function (e) {
                if (e.key === 'Enter' && !$(e.target).is('button[type="submit"]')) {
                    e.preventDefault();
                    return false;
                }
            });

            // ===================================================================================

            // formCrearUsuario para cargar gif en el submit
            $("form").on("submit", function(e) {
                const form = $(this);
                const submitButton = form.find('button[type="submit"]');
                const loadingIndicator = form.find("div[id^='loadingIndicatorStore']");

                // Dessactivar Botones
                submitButton.prop("disabled", true).html("Procesando... <i class='fa fa-spinner fa-spin'></i>");

                // Mostrar Spinner
                loadingIndicator.show();
            });
        }); // FIN document.readey
    </script>
@stop
