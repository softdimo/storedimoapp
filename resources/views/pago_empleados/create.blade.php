@extends('layouts.app')
@section('title', 'Registrar Pagos')

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('css')
    {{-- <link rel="stylesheet" href="{{ asset('css/custom.css') }}"> --}}
    <style>
        .btn-circle {
            padding-left: 0.3rem !important;
            padding-right: 0.3rem !important;
            padding-top: 0.0rem !important;
            padding-bottom: 0.0rem !important;
        }

        .totales {
            padding: 10px 15px;
            background-color: #f5f5f5;
            border-top: 1px solid #ddd;
            border-bottom-right-radius: 3px;
            border-bottom-left-radius: 3px;
        }
    </style>
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

        <div class="p-3 d-flex flex-column content-container">
            <div class="text-end">
                <a href="#" role="button" title="Ayuda" class="text-blue" data-bs-toggle="modal" data-bs-target="#modalAyudaRegistrarPagos">
                    <i class="fa fa-question-circle fa-2x" aria-hidden="false" title="Ayuda" style="color: #337AB7"></i>
                </a>
            </div>

            <div class="modal fade" id="modalAyudaRegistrarPagos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard ="false" data-backdrop = "static" style="max-width: 55%;">
                <div class="modal-dialog">
                    <div class="modal-content p-3">
                        <div class="modal-body p-0 rounded-top" style="border: solid 1px #337AB7; mw-50">
                            <div class="row">
                                <div class="col-12">
                                    <div class="rounded-top text-white text-center p-2" style="background-color: #337AB7; border: solid 1px #337AB7;">
                                        <span class="modal-title fs-4"><strong>Ayuda Registro de Pagos</strong></span>
                                    </div>
                                    {{-- =========================== --}}
                                    <div class="p-3">
                                        <p class="text-justify">Señor usuario tener en cuenta estas recomendaciones a la hora de registrar un pago:</p>
    
                                        <ol>
                                            <li class="text-justify">Dependiendo el tipo de pago y el tipo de empleado se habilitan o inhabilitan campos.</li>
                                            <li class="text-justify">Los campos marcados con asterisco (*) son obligatorios, por lo tanto si no se diligencian el sistema no dejará seguir.</li>
                                            <li class="text-justify">El campo valor prima solo se activará cuando el sistema se encuentre en las fechas del 15 al 30 de Junio y del 15 al 30 de Diciembre.</li>
                                            <li class="text-justify">Al registrar un pago final, si el empleado no ha cumplido el año de labores los diferentes valores como prima, cesantías, vacaciones, etc. se pagarán de forma proporcional de acuerdo a los días laborados desde la fecha de contrato hasta la fecha de ese pago.</li>
                                        </ol>
                                    </div> {{--FINpanel-body --}}
                                </div> {{--FIN col-12 --}}
                            </div> {{--FIN modal-body .row --}}
                        </div> {{--FIN modal-body --}}
                        {{-- =========================== --}}
                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="button" class="btn btn-primary btn-md active pull-right" data-bs-dismiss="modal" style="background-color: #337AB7;">
                                    <i class="fa fa-check-circle">&nbsp;Aceptar</i>
                                </button>
                            </div>
                        </div>
                    </div> {{--FIN modal-content --}}
                </div> {{--FIN modal-dialog --}}
            </div> {{--FIN modalAyudaModificacionProductos --}}

            {{-- =============================================================== --}}
            {{-- =============================================================== --}}

            <div class="p-0" style="border: solid 1px #337AB7; border-radius: 5px;">
                <h5 class="border rounded-top text-white text-center pt-2 pb-2 m-0" style="background-color: #337AB7">Registrar Pagos</h5>
            
                <div class="col-12 p-3" id="">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered w-100 mb-0" id="tbl_registrar_pagos" aria-describedby="registrar_pagos">
                            <thead>
                                <tr class="header-table text-center">
                                    <th>Número Documento</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Tipo Empleado</th>
                                    <th>Estado</th>
                                    <th>Registrar Pago</th>
                                </tr>
                            </thead>
                            {{-- ============================== --}}
                            <tbody>
                                @foreach ($pagoEmpleadosCreate as $pagoEmpleado)
                                    <tr class="text-center">
                                        <td>{{$pagoEmpleado->identificacion}}</td>
                                        <td>{{$pagoEmpleado->nombre_usuario}}</td>
                                        <td>{{$pagoEmpleado->apellido_usuario}}</td>
                                        <td>{{$pagoEmpleado->tipo_persona}}</td>
                                        <td>{{$pagoEmpleado->estado}}</td>
                                        <td>
                                            <button class="btn rounded-circle btn-circle text-white" title="Registrar Pago" style="background-color: #286090" data-bs-toggle="modal" data-bs-target="#modalRegistrarPago_{{$pagoEmpleado->id_usuario}}">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    {{-- INICIO Modal REGISTRAR PAGO --}}
                                    <div class="modal fade" id="modalRegistrarPago_{{$pagoEmpleado->id_usuario}}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" style="max-width: 70%;max-height: 90vh !important">
                                        <div class="modal-dialog">
                                            <div class="modal-content p-3">
                                                {!! Form::open([
                                                    'method' => 'POST',
                                                    'route' => ['pago_empleados.store'],
                                                    'class' => 'mt-2',
                                                    'autocomplete' => 'off',
                                                    'id' => 'formRegistrarPago_'.$pagoEmpleado->id_usuario]) !!}
                                                    @csrf

                                                    <div class="rounded-top" style="border: solid 1px #337AB7;">
                                                        <div class="rounded-top text-white text-center"
                                                            style="background-color: #337AB7; border: solid 1px #337AB7;">
                                                            <h5>Registrar Pago</h5>
                                                        </div>

                                                        {!! Form::hidden('id_usuario', isset($pagoEmpleado) ? $pagoEmpleado->id_usuario : null, ['class' => '', 'id' => 'id_usuario', 'required']) !!}

                                                        <div class="modal-body m-0">
                                                            <div class="row m-0">
                                                                <div class="col-12 col-md-4" id="div_identificacion">
                                                                    <label for="identificacion" class="fw-bold" style="font-size: 12px">Identificación <span class="text-danger"></span></label>
                                                                    {!! Form::text('identificacion', isset($pagoEmpleado) ? $pagoEmpleado->identificacion : null, ['class' => 'form-control bg-dark-subtle', 'id' => 'identificacion', 'required', 'readonly']) !!}
                                                                </div>
                            
                                                                <div class="col-12 col-md-4" id="div_nombres">
                                                                    <label for="nombre_usuario" class="fw-bold" style="font-size: 12px">Nombres <span class="text-danger"></span></label>
                                                                    {!! Form::text('nombre_usuario', isset($pagoEmpleado) ? $pagoEmpleado->nombre_usuario . ' ' . $pagoEmpleado->apellido_usuario : null, ['class' => 'form-control bg-dark-subtle', 'id' => 'nombre_usuario', 'readonly']) !!}
                                                                </div>
                            
                                                                <div class="col-12 col-md-4" id="div_tipo_empleado">
                                                                    <label for="tipo_empleado" class="fw-bold" style="font-size: 12px">Tipo Empleado <span class="text-danger"></span></label>
                                                                    {!! Form::text('tipo_empleado', isset($pagoEmpleado) ? $pagoEmpleado->tipo_persona : null, ['class' => 'form-control bg-dark-subtle', 'id' => 'tipo_empleado', 'readonly']) !!}
                                                                </div>

                                                                <div class="col-12 col-md-4 mt-3" id="div_valor_base">
                                                                    <label for="valor_base" class="fw-bold" style="font-size: 12px">Valor Base <span class="text-danger">*</span></label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">$</span>
                                                                        {!! Form::text('valor_base', null, ['class' => 'form-control bg-dark-subtle', 'id' => 'valor_base', 'readonly']) !!}
                                                                    </div>
                                                                </div>

                                                                <div class="col-12 col-md-4 mt-3" id="div_fecha_inicio_labores">
                                                                    <label for="fecha_inicio_labores" class="fw-bold" style="font-size: 12px">
                                                                        Fecha inicio de labores <span class="text-danger">*</span>
                                                                    </label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">
                                                                            <i class="fa fa-calendar"></i>
                                                                        </span>
                                                                        {!! Form::text('fecha_inicio_labores', null, ['class' => 'form-control', 'id' => 'fecha_inicio_labores']) !!}
                                                                    </div>
                                                                </div>

                                                                <div class="col-12 col-md-4 mt-3" id="div_fecha_final_labores">
                                                                    <label for="fecha_final_labores" class="fw-bold" style="font-size: 12px">
                                                                        Finalización de labores <span class="text-danger">*</span>
                                                                    </label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">
                                                                            <i class="fa fa-calendar"></i>
                                                                        </span>
                                                                        {!! Form::text('fecha_final_labores', null, ['class' => 'form-control', 'id' => 'fecha_final_labores']) !!}
                                                                    </div>
                                                                </div>

                                                                <div class="col-12 col-md-4 mt-3" id="div_id_tipo_pago">
                                                                    <label for="id_tipo_pago" class="fw-bold" style="font-size: 12px">Tipo Pago <span class="text-danger">*</span></label>
                                                                    {{ Form::select('id_tipo_pago', collect(['' => 'Seleccionar...'])->union($tipos_pago_nomina), isset($usuarioPrestamo) ? $usuarioPrestamo->id_tipo_persona : 4, ['class' => 'form-select', 'id' => 'id_tipo_pago','required'=>'required']) }}
                                                                </div>

                                                                <div class="col-12 col-md-4 mt-3" id="div_id_periodo_pago">
                                                                    <label for="id_periodo_pago" class="fw-bold" style="font-size: 12px">Periodo Pago <span class="text-danger">*</span></label>
                                                                    {{ Form::select('id_periodo_pago', collect(['' => 'Seleccionar...'])->union($periodos_pago), isset($usuarioPrestamo) ? $usuarioPrestamo->id_tipo_persona : null, ['class' => 'form-select', 'id' => 'id_periodo_pago']) }}
                                                                </div>

                                                                <div class="col-12 col-md-4 mt-3" id="div_cantidad_dias">
                                                                    <label for="cantidad_dias" class="fw-bold" style="font-size: 12px">Días a pagar <span class="text-danger">*</span></label>
                                                                    {!! Form::number('cantidad_dias', null, ['class' => 'form-control', 'id' => 'cantidad_dias','required'=>'required', 'min'=>'0', 'max'=>'30','oninput' => "if(this.value > 30) this.value = 30;"]) !!}
                                                                </div>

                                                                <div class="col-12 col-md-4 mt-3" id="div_total_dias_pagar">
                                                                    <label for="total_dias_pagar" class="fw-bold" style="font-size: 12px">Total dias a pagar <span class="text-danger">*</span></label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">$</span>
                                                                        {!! Form::text('total_dias_pagar', null, ['class' => 'form-control bg-dark-subtle', 'id' => 'total_dias_pagar', 'readonly']) !!}
                                                                        <span class="input-group-btn">
                                                                            <button class="input-group-text" type="button" id="idBtnCalcularPagoEnLiquidacion" onclick="calcularElPagoNormalEnLiquidacion()" style="background-color: #E0F8E0"> <b>Calcular</b>
                                                                            </button>
                                                                        </span>
                                                                    </div>
                                                                </div>

                                                                <div class="col-12 col-md-4 mt-3" id="div_id_porcentaje_comision">
                                                                    <label for="id_porcentaje_comision" class="fw-bold" style="font-size: 12px">Porcentaje Comisión <span class="text-danger">*</span></label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">%</span>
                                                                        {{ Form::select('id_porcentaje_comision', collect(['' => 'Seleccionar...'])->union($porcentajes_comision), isset($usuarioPrestamo) ? $usuarioPrestamo->id_porcentaje_comision : null, ['class' => 'form-select', 'id' => 'id_porcentaje_comision']) }}
                                                                    </div>
                                                                </div>

                                                                <div class="col-12 col-md-4 mt-3" id="div_valor_dia">
                                                                    <label for="valor_dia" class="fw-bold" style="font-size: 12px">Valor día <span class="text-danger">*</span></label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">$</span>
                                                                        {!! Form::text('valor_dia', null, ['class' => 'form-control', 'id' => 'valor_dia']) !!}
                                                                    </div>
                                                                </div>

                                                                <div class="col-12 col-md-4 mt-3" id="div_fecha_ultimo_pago">
                                                                    <label for="fecha_ultimo_pago" class="fw-bold" style="font-size: 12px">
                                                                        Fecha último pago <span class="text-danger">*</span>
                                                                    </label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">
                                                                            <i class="fa fa-calendar"></i>
                                                                        </span>
                                                                        {!! Form::text('fecha_ultimo_pago', null, ['class' => 'form-control', 'id' => 'fecha_ultimo_pago']) !!}
                                                                    </div>
                                                                </div>

                                                                <div class="col-12 col-md-6 mt-3" id="div_valor_ventas">
                                                                    <label for="valor_ventas" class="fw-bold" style="font-size: 12px">Valor ventas</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">$</span>
                                                                        {!! Form::text('valor_ventas', null, ['class' => 'form-control', 'id' => 'valor_ventas']) !!}
                                                                        <button type="button" class="input-group-text" onclick="traervalorVentas()"><span class="fa fa-search-plus"></span></button>
                                                                        <button type="button" class="input-group-text" onclick="limpiarCampos()"><span class="fa fa-trash-o"></span></button>
                                                                    </div>
                                                                </div>

                                                                <div class="col-12 col-md-6 mt-3" id="div_pendiente_prestamos">
                                                                    <label for="pendiente_prestamos" class="fw-bold" style="font-size: 12px">Pendiente de Préstamos</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">$</span>
                                                                        {!! Form::text('pendiente_prestamos', null, ['class' => 'form-control', 'id' => 'pendiente_prestamos']) !!}
                                                                        <button type="button" class="input-group-text" onclick="traervalorprestamopen()"><span class="fa fa-search-plus"></span></button>
                                                                        <button type="button" class="input-group-text" onclick="limpiarCampos()"><span class="fa fa-trash-o"></span></button>
                                                                    </div>
                                                                </div>
                                                            </div> <!-- FIN modal-body .row Campos registrar pago -->

                                                            {{-- ====================================================== --}}

                                                            <div class="rounded-top mt-5" style="border: solid 1px #337AB7;">
                                                                <div class="rounded-top text-white text-center"
                                                                    style="background-color: #337AB7; border: solid 1px #337AB7;">
                                                                    <h5>PAGO TOTAL</h5>
                                                                </div>

                                                                <div class="row p-3">
                                                                    <div class="col-12 col-md-4" id="div_salario_neto">
                                                                        <h5 class="fw-bold totales">
                                                                            Salario Neto:
                                                                            {!! Form::hidden('salario_neto', null, ['class' => '', 'id' => 'salario_neto']) !!}
                                                                            <span id="salario_neto"></span>
                                                                        </h5>
                                                                    </div>

                                                                    <div class="col-12 col-md-4" id="div_vacaciones">
                                                                        <h5 class="fw-bold totales">
                                                                            Vacaciones:
                                                                            {!! Form::hidden('vacaciones', null, ['class' => '', 'id' => 'vacaciones']) !!}
                                                                            <span id="vacaciones"></span>
                                                                        </h5>
                                                                    </div>

                                                                    <div class="col-12 col-md-4" id="div_comisiones">
                                                                        <h5 class="fw-bold totales">
                                                                            Comisiones:
                                                                            {!! Form::hidden('comisiones', null, ['class' => '', 'id' => 'comisiones']) !!}
                                                                            <span id="comisiones"></span>
                                                                        </h5>
                                                                    </div>

                                                                    <div class="col-12 col-md-4" id="div_cesantias">
                                                                        <h5 class="fw-bold totales">
                                                                            Comisiones:
                                                                            {!! Form::hidden('cesantias', null, ['class' => '', 'id' => 'cesantias']) !!}
                                                                            <span id="cesantias"></span>
                                                                        </h5>
                                                                    </div>

                                                                    <div class="col-12 col-md-4" id="div_total">
                                                                        <h5 class="fw-bold totales">
                                                                            Total:
                                                                            {!! Form::hidden('total', null, ['class' => '', 'id' => 'total']) !!}
                                                                            <span id="total"></span>
                                                                        </h5>
                                                                    </div>
                                                                </div>

                                                                {{-- =========================== --}}

                                                                <div class="row mt-3 me-3 mb-3">
                                                                    <div class="col-12">
                                                                        <button type="button" class="btn btn-primary btn-md active pull-right" style="background-color: #337AB7;">
                                                                            <i class="fa fa-building"> Calcular</i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> <!-- FIN modal-body -->

                                                        {{-- ====================================================== --}}
                                                        {{-- ====================================================== --}}

                                                        <!-- Contenedor para el GIF -->
                                                        <div id="loadingIndicatorRegistrarPago_{{$pagoEmpleado->id_usuario}}"
                                                            class="loadingIndicator">
                                                            <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
                                                        </div>

                                                        {{-- ====================================================== --}}
                                                        {{-- ====================================================== --}}

                                                        <div class="modal-footer border-0 d-flex justify-content-around">
                                                            <button type="submit" id="btn_registrar_pago_{{$pagoEmpleado->id_usuario}}"
                                                                class="btn btn-success" title="Guardar Configuración">
                                                                <i class="fa fa-floppy-o"> Guardar</i>
                                                            </button>

                                                            <button type="button" id="btn_cancelar_pago_{{$pagoEmpleado->id_usuario}}"
                                                                class="btn btn-secondary" title="Cancelar"
                                                                data-bs-dismiss="modal">
                                                                <i class="fa fa-times"> Cancelar</i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                {!! Form::close() !!}
                                            </div> {{-- FIN modal-content --}}
                                        </div> {{-- FIN modal-dialog --}}
                                    </div> {{-- FIN modal --}}
                                    {{-- FINAL Modal REGISTRAR PAGO --}}
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('scripts')
    <script src="{{asset('DataTables/datatables.min.js')}}"></script>
    <script src="{{asset('DataTables/Buttons-2.3.4/js/buttons.html5.min.js')}}"></script>

    <script>
        $( document ).ready(function() {
            // INICIO DataTable REGISTRAR PAGOS
            $("#tbl_registrar_pagos").DataTable({
                dom: 'Blfrtip',
                "infoEmpty": "No hay registros",
                stripe: true,
                "bSort": false,
                "buttons": [
                    {
                        extend: 'copyHtml5',
                        text: 'Copiar',
                        className: 'waves-effect waves-light btn-rounded btn-sm btn-primary',
                        init: function(api, node, config) {
                            $(node).removeClass('dt-button')
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        text: 'Excel',
                        className: 'waves-effect waves-light btn-rounded btn-sm btn-primary mr-3',
                        customize: function( xlsx ) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            $('row:first c', sheet).attr( 's', '42' );
                        }
                    }
                ],
                "pageLength": 10,
                "scrollX": true,
            });
            // CIERRE DataTable REGISTRAR PAGOS

            // ==========================================================
            // ==========================================================
            
            $(document).on('shown.bs.modal', '[id^="modalRegistrarPago_"]', function () {
                // Buscar el select dentro del modal
                let modal = $(this); // Guardamos la referencia del modal
                let selectTipoPago = modal.find('[id^=id_tipo_pago]');

                if (selectTipoPago.length > 0) { // Al cargar el modal
                    let inputIdTipoPago = selectTipoPago.val(); // Obtener el valor actual del select

                    // Buscar los elementos dentro de este modal
                    let divIdentificacion = modal.find('[id^=div_identificacion]');
                    let identificacion = modal.find('[id^=identificacion]');

                    let divNombres = modal.find('[id^=div_nombres]');
                    let nombres = modal.find('[id^=nombre_usuario]');

                    let divTipoEmpleado = modal.find('[id^=div_tipo_empleado]');
                    let tipoEmpleado = modal.find('[id^=tipo_empleado]');

                    let divIdTipoPago = modal.find('[id^=div_id_tipo_pago]');
                    let idTipoPago = modal.find('[id^=id_tipo_pago]');

                    let divIdPeriodoPago = modal.find('[id^=div_id_periodo_pago]');
                    let idPeriodoPago = modal.find('[id^=id_periodo_pago]');

                    let divIdPorcentajeComision = modal.find('[id^=div_id_porcentaje_comision]');
                    let idPorcentajeComision = modal.find('[id^=id_porcentaje_comision]');

                    let divValorDia = modal.find('[id^=div_valor_dia]');
                    let valorDia = modal.find('[id^=valor_dia]');

                    let divValorVentas = modal.find('[id^=div_valor_ventas]');
                    let valorVentas = modal.find('[id^=valor_ventas]');

                    let divValorBase = modal.find('[id^=div_valor_base]');
                    let valorBase = modal.find('[id^=valor_base]');

                    let divFechaInicioLabores = modal.find('[id^=div_fecha_inicio_labores]');
                    let fechaInicioLabores = modal.find('[id^=fecha_inicio_labores]');

                    let divFechaFinalLabores = modal.find('[id^=div_fecha_final_labores]');
                    let fechaFinalLabores = modal.find('[id^=fecha_final_labores]');

                    let divTotalDiasPagar = modal.find('[id^=div_total_dias_pagar]');
                    let totalDiasPagar = modal.find('[id^=total_dias_pagar]');

                    let divPendientePrestamos = modal.find('[id^=div_pendiente_prestamos]');
                    let pendientePrestamos = modal.find('[id^=pendiente_prestamos]');

                    let divVacaciones = modal.find('[id^=div_vacaciones]');
                    let vacaciones = modal.find('[id^=vacaciones]');

                    let divCesantias = modal.find('[id^=div_cesantias]');
                    let cesantias = modal.find('[id^=cesantias]');

                    let divSalarioNeto = modal.find('[id^=div_salario_neto]');
                    let salarioNeto = modal.find('[id^=salario_neto]');

                    let divComisiones = modal.find('[id^=div_comisiones]');
                    let comisiones = modal.find('[id^=comisiones]');

                    // Ocultar o mostrar al cargar el modal
                    divValorBase.hide();
                    valorBase.removeAttr('required');
                    divFechaInicioLabores.hide();
                    fechaInicioLabores.removeAttr('required');
                    divFechaFinalLabores.hide();
                    fechaFinalLabores.removeAttr('required');
                    divTotalDiasPagar.hide();
                    totalDiasPagar.removeAttr('required');
                    divPendientePrestamos.hide();
                    pendientePrestamos.removeAttr('required');

                    divVacaciones.hide();
                    vacaciones.removeAttr('required');
                    divCesantias.hide();
                    cesantias.removeAttr('required');

                    divSalarioNeto.show();
                    salarioNeto.attr('required');
                    divComisiones.show();
                    comisiones.attr('required');

                    idPeriodoPago.val('2');
                    

                    // ===================================================

                    // Al cambiar el tipo de persona
                    selectTipoPago.change(function () {
                        let inputIdTipoPago = selectTipoPago.val(); // Obtener el valor actual del select al cambiar

                        let modal = $(this).closest('[id^="modalRegistrarPago_"]'); // Asegurar que buscamos dentro del modal correcto

                        let divIdentificacion = modal.find('[id^=div_identificacion]');
                        let identificacion = modal.find('[id^=identificacion]');

                        let divNombres = modal.find('[id^=div_nombres]');
                        let nombres = modal.find('[id^=nombre_usuario]');

                        let divTipoEmpleado = modal.find('[id^=div_tipo_empleado]');
                        let tipoEmpleado = modal.find('[id^=tipo_empleado]');

                        let divIdTipoPago = modal.find('[id^=div_id_tipo_pago]');
                        let idTipoPago = modal.find('[id^=id_tipo_pago]');

                        let divIdPeriodoPago = modal.find('[id^=div_id_periodo_pago]');
                        let idPeriodoPago = modal.find('[id^=id_periodo_pago]');

                        let divIdPorcentajeComision = modal.find('[id^=div_id_porcentaje_comision]');
                        let idPorcentajeComision = modal.find('[id^=id_porcentaje_comision]');

                        let divValorDia = modal.find('[id^=div_valor_dia]');
                        let valorDia = modal.find('[id^=valor_dia]');

                        let divValorVentas = modal.find('[id^=div_valor_ventas]');
                        let valorVentas = modal.find('[id^=valor_ventas]');

                        let divValorBase = modal.find('[id^=div_valor_base]');
                        let valorBase = modal.find('[id^=valor_base]');

                        let divFechaInicioLabores = modal.find('[id^=div_fecha_inicio_labores]');
                        let fechaInicioLabores = modal.find('[id^=fecha_inicio_labores]');

                        let divFechaFinalLabores = modal.find('[id^=div_fecha_final_labores]');
                        let fechaFinalLabores = modal.find('[id^=fecha_final_labores]');

                        let divTotalDiasPagar = modal.find('[id^=div_total_dias_pagar]');
                        let totalDiasPagar = modal.find('[id^=total_dias_pagar]');

                        let divPendientePrestamos = modal.find('[id^=div_pendiente_prestamos]');
                        let pendientePrestamos = modal.find('[id^=pendiente_prestamos]');

                        let divVacaciones = modal.find('[id^=div_vacaciones]');
                        let vacaciones = modal.find('[id^=vacaciones]');

                        let divCesantias = modal.find('[id^=div_cesantias]');
                        let cesantias = modal.find('[id^=cesantias]');

                        let divSalarioNeto = modal.find('[id^=div_salario_neto]');
                        let salarioNeto = modal.find('[id^=salario_neto]');

                        let divComisiones = modal.find('[id^=div_comisiones]');
                        let comisiones = modal.find('[id^=comisiones]');

                        if (inputIdTipoPago == 5) { // Pago Final
                            divIdentificacion.show();
                            identificacion.attr('required');

                            divNombres.show('slow');
                            nombres.attr('required');

                            divTipoEmpleado.show();
                            tipoEmpleado.attr('required');

                            divIdTipoPago.show();
                            idTipoPago.attr('required');

                            divIdPeriodoPago.hide();
                            idPeriodoPago.removeAttr('required');
                            idPeriodoPago.val('');

                            divIdPorcentajeComision.show();
                            idPorcentajeComision.removeAttr('required');

                            divValorDia.hide();
                            valorDia.removeAttr('required');

                            divValorVentas.hide();
                            valorVentas.removeAttr('required');

                            divValorBase.show();
                            valorBase.attr('required');

                            divFechaInicioLabores.show();
                            fechaInicioLabores.attr('required');

                            divFechaFinalLabores.show();
                            fechaFinalLabores.attr('required');

                            divTotalDiasPagar.show();
                            totalDiasPagar.attr('required');
                            
                            divPendientePrestamos.show();
                            pendientePrestamos.attr('required');

                            divVacaciones.show();
                            vacaciones.attr('required');

                            divCesantias.show();
                            cesantias.attr('required');

                            divSalarioNeto.hide();
                            salarioNeto.removeAttr('required');

                            divComisiones.hide();
                            comisiones.removeAttr('required');
                            
                        } else {
                            divIdentificacion.show();
                            identificacion.attr('required');

                            divNombres.show('slow');
                            nombres.attr('required');

                            divTipoEmpleado.show();
                            tipoEmpleado.attr('required');

                            divIdTipoPago.show();
                            idTipoPago.attr('required');

                            divIdPeriodoPago.show();
                            idPeriodoPago.attr('required');
                            idPeriodoPago.val('2');

                            divIdPorcentajeComision.show();
                            idPorcentajeComision.removeAttr('required');

                            divValorDia.show();
                            valorDia.attr('required');

                            divValorVentas.show();
                            valorVentas.attr('required');

                            divValorBase.hide();
                            valorBase.removeAttr('required');
                            divFechaInicioLabores.hide();
                            fechaInicioLabores.removeAttr('required');
                            divFechaFinalLabores.hide();
                            fechaFinalLabores.removeAttr('required');
                            divTotalDiasPagar.hide();
                            totalDiasPagar.removeAttr('required');
                            divPendientePrestamos.hide();
                            pendientePrestamos.removeAttr('required');

                            divVacaciones.hide();
                            vacaciones.removeAttr('required');

                            divCesantias.hide();
                            cesantias.removeAttr('required');

                            divSalarioNeto.show();
                            salarioNeto.attr('required');

                            divComisiones.show();
                            comisiones.attr('required');
                        }
                    }); // FIN Tipo Persona Jurídica
                } // FIN selectTipoPersona.length > 0
            }); // FIN '[id^="modalEditarProveedor_"]').on('shown.bs.modal'

            // ==========================================================
            // ==========================================================

            // formRegistrarPago_ para cargar gif en el submit
            $(document).on("submit", "form[id^='formRegistrarPago_']", function(e) {
                const form = $(this);
                const formId = form.attr('id'); // Obtenemos el ID del formulario
                const id = formId.split('_')[1]; // Obtener el ID del formulario desde el ID del formulario

                // Capturar Spinner y btns dinámicamente
                const loadingIndicator = $(`#loadingIndicatorRegistrarPago_${id}`);
                const submitButton = $(`#btn_registrar_pago_${id}`);
                const cancelButton = $(`#btn_cancelar_pago_${id}`);

                // Desactivar btns
                submitButton.prop("disabled", true).html("Procesando... <i class='fa fa-spinner fa-spin'></i>");
                cancelButton.prop("disabled", true);

                // Cargar Spinner
                loadingIndicator.show();
            });

            // ==========================================================
            // ==========================================================
            
            // Re-inicializar Select2 cuando se abre el modal
            $(document).on('shown.bs.modal', '[id^="modalRegistrarPago"]', function () {
                let modal = $(this); // Guardamos la referencia del modal
                let selectElements = modal.find('.select2'); // Seleccionamos TODOS los selects con la clase select2 dentro del modal

                if (selectElements.length > 0) {
                    selectElements.each(function () {
                        $(this).select2({
                            dropdownParent: modal, // 📌 Desplegar opciones en el modal
                            allowClear: true
                        });

                        // Forzar la opción vacía al borrar
                        $(this).on('select2:clear', function () {
                            $(this).val('').trigger('change');
                        });
                    });
                }
            });

            // ==========================================================
            // ==========================================================

            function calcularSalario(){
                
            }

        });
    </script>
@stop


