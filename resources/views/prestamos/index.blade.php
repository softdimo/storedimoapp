@extends('layouts.app')
@section('title', 'Préstamo Empleados')

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

        /* Oculta el icono de calendario nativo en Chrome, Safari y Edge */
        input[type="date"]::-webkit-calendar-picker-indicator {
            display: none;
            -webkit-appearance: none;
        }

        /* Oculta el icono en Firefox */
        input[type="date"]::-moz-calendar-picker-indicator {
            display: none;
        }

        /* Para navegadores que aún muestran el ícono nativo */
        input[type="date"] {
            position: relative;
            z-index: 2;
            background-color: transparent;
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
            {{-- <div class="text-end">
                <a href="#" class="text-blue">
                    <i class="fa fa-question-circle fa-2x" aria-hidden="false" title="Ayuda" style="color: #337AB7"></i>
                </a>
            </div> --}}

            {{-- =============================================================== --}}
            {{-- =============================================================== --}}

            <div class="p-0" style="border: solid 1px #337AB7; border-radius: 5px;">
                <h5 class="border rounded-top text-white text-center pt-2 pb-2 m-0" style="background-color: #337AB7">Listar Préstamos</h5>
            
                <div class="col-12 p-3" id="">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered w-100 mb-0" id="tbl_prestamo_empleados" aria-describedby="prestamo_empleados">
                            <thead>
                                <tr class="header-table text-center">
                                    <th>Identificación</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Tipo Empleado</th>
                                    <th>Ver Detalles</th>
                                </tr>
                            </thead>
                            {{-- ============================== --}}
                            <tbody>
                                @foreach ($prestamosIndex as $prestamo)
                                    <tr class="text-center">
                                        <td>{{$prestamo->tipo_documento}} - {{$prestamo->identificacion}}</td>
                                        <td>{{$prestamo->nombre_usuario}}</td>
                                        <td>{{$prestamo->apellido_usuario}}</td>
                                        <td>{{$prestamo->tipo_persona}}</td>
                                        <td>
                                            <button title="Detalles Préstamo" class="btn rounded-circle btn-circle text-white" style="background-color: #286090" data-bs-toggle="modal" data-bs-target="#modalDetallePrestamo_{{$prestamo->id_prestamo}}">
                                                <i class="fa fa-eye"></i>
                                            </button>

                                            <!-- <button title="Generar PDF" class="btn btn-success rounded-circle btn-circle text-white" id="modalPdfPrestamo_{{$prestamo->id_prestamo}}">
                                                <i class="fa fa-file-pdf-o"></i>
                                            </button> -->
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- ========================================================= --}}
                    {{-- ========================================================= --}}
                    {{-- ========================================================= --}}
                    {{-- ========================================================= --}}
            
                    <!-- <div class="mt-5 mb-2 d-flex justify-content-center">
                        <button type="submit" class="btn rounded-2 me-3 text-white" style="background-color: #204D74" data-bs-toggle="modal" data-bs-target="#modalReportePrestamos">
                            <i class="fa fa-file-pdf-o"></i>
                            Reporte Préstamos
                        </button>
                    </div> -->
                </div> {{-- FIN div_col-12 p-3 --}}
            </div> {{-- FIN div_p-0 --}}
        </div> {{-- FIN width: 80% --}}
    </div> {{-- FIN content d-flex p-0 --}}

    {{-- =============================================================== --}}
    {{-- =============================================================== --}}

    {{-- INICIO Modal REPORTE PRÉSTAMOS --}}
    <div class="modal fade" id="modalReportePrestamos" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content p-3">
                <div class="rounded-top" style="border: solid 1px #337AB7;">
                    <div class="rounded-top text-white text-center"
                        style="background-color: #337AB7; border: solid 1px #337AB7;">
                        <h5>Reporte Préstamos</h5>
                    </div>

                    <div class="modal-body m-0">
                        <div class="row m-0">
                            <div class="col-12 col-md-6">
                                <label for="fecha_inicial" class="fw-bold" style="font-size: 12px">
                                    Fecha Inicial <span class="text-danger">*</span>
                                </label>
                                <div class="input-group" id="calendar_addon_inicial" style="cursor: pointer;">
                                    {!! Form::date('fecha_inicial', null, ['class' => 'form-control', 'id' => 'fecha_inicial', 'required','onkeydown' => 'return false']) !!}
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="fecha_final" class="fw-bold" style="font-size: 12px">
                                    Fecha Final <span class="text-danger">*</span>
                                </label>
                                <div class="input-group" id="calendar_addon_final" style="cursor: pointer;">
                                    {!! Form::date('fecha_final', null, ['class' => 'form-control', 'id' => 'fecha_final', 'required','onkeydown' => 'return false','onkeydown' => 'return false']) !!}
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div> <!-- FIN modal-body -->

                    {{-- ====================================================== --}}
                    {{-- ====================================================== --}}

                    <!-- <div class="modal-footer border-0 d-flex justify-content-center mt-3">
                        <button type="submit" id="btn_reporte_prestamos"
                            class="btn btn-success" title="Guardar Configuración">
                            <i class="fa fa-file-pdf-o"> Generar Reporte</i>
                        </button>
                    </div> -->
                </div> {{-- FIN Div rounded-top --}}

                {{-- ====================================================== --}}
                {{-- ====================================================== --}}

                <div class="row mt-3">
                    <div class="col-12">
                        <button type="button" class="btn btn-primary btn-md active pull-right" style="background-color: #337AB7;" data-bs-dismiss="modal" id="btnReportePrestamos">
                            <i class="fa fa-check-circle"> Aceptar</i>
                        </button>
                    </div>
                </div>
            </div> {{-- FIN modal-content --}}
        </div> {{-- FIN modal-dialog --}}
    </div> {{-- FIN modal --}}
    {{-- FINAL Modal REPORTE PRÉSTAMOS--}}

    {{-- =============================================================== --}}
    {{-- =============================================================== --}}

    @foreach ($prestamosIndex as $prestamo)
        <!-- INICIO Modal Detalle Préstamo -->
        <div class="modal fade" id="modalDetallePrestamo_{{$prestamo->id_prestamo}}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" style="max-width: 80%;">
            <div class="modal-dialog">
                <div class="modal-content p-3">
                    <div class="rounded-top" style="border: solid 1px #337AB7;">
                        <div class="rounded-top text-white text-center" style="background-color: #337AB7; border: solid 1px #337AB7;">
                            <h5>Detalle Préstamo Empleado: {{$prestamo->nombre_usuario}} {{$prestamo->apellido_usuario}}</h5>
                        </div>

                        <div class="modal-body p-0 m-0">
                            <div class="row m-0">
                                <div class="col-12 p-3 pt-1">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered m-100 mb-0" aria-describedby="entradas" id="tbl_detalles_prestamo">
                                            <thead>
                                                <tr class="header-table text-center">
                                                    <th>Tipo de Documento</th>
                                                    <th>Identificación</th>
                                                    <th>Fecha Préstamo</th>
                                                    <th>Fecha Límite</th>
                                                    <th>Valor del Préstamo</th>
                                                    <th>Total Abono</th>
                                                    <th>Valor Pendiente</th>
                                                    <th>Descripción</th>
                                                    <th>Estado Préstamo</th>
                                                    <th>Opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center">
                                                    <td>{{$prestamo->tipo_documento}}</td>
                                                    <td>{{$prestamo->identificacion}}</td>
                                                    <td>{{$prestamo->fecha_prestamo}}</td>
                                                    <td>{{$prestamo->fecha_limite}}</td>
                                                    <td>{{$prestamo->valor_prestamo}}</td>
                                                    <td>{{$prestamo->valor_prestamo}}</td>
                                                    <td>{{$prestamo->descripcion}}</td>
                                                    <td>{{$prestamo->valor_prestamo}}</td>
                                                    <td>{{$prestamo->valor_prestamo}}</td>
                                                    <td>
                                                        <button title="Abonar" class="btn btn-warning rounded-circle btn-circle text-white" data-bs-toggle="modal" data-bs-target="#modalAbonoPrestamo_{{$prestamo->id_prestamo}}">
                                                            <i class="fa fa-money"></i>
                                                        </button>

                                                        <button title="Modificar Préstamo" class="btn btn-success rounded-circle btn-circle text-white" data-bs-toggle="modal" data-bs-target="#modalModificarPrestamo_{{$prestamo->id_prestamo}}">
                                                            <i class="fa-pencil-square-o"></i>
                                                        </button>

                                                        <button title="Ver abonos" class="btn btn-primary rounded-circle btn-circle text-white" data-bs-toggle="modal" data-bs-target="#modalVerAbonos_{{$prestamo->id_prestamo}}">
                                                            <i class="fa fa-eye"></i>
                                                        </button>

                                                        <button title="Cambiar Estado" class="btn btn-danger rounded-circle btn-circle text-white" data-bs-toggle="modal" data-bs-target="#modalCambiarEstadoPrestamo_{{$prestamo->id_prestamo}}">
                                                            <i class="fa fa-refresh"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- FIN modal-body -->
                    </div> <!-- FIN rounded-top -->

                    <div class="row mt-3">
                        <div class="col-12">
                            <button type="button" class="btn btn-primary btn-md active pull-right" data-bs-dismiss="modal" style="background-color: #337AB7;" id="btnDetallePrestamo_{{$prestamo->id_prestamo}}">
                                <i class="fa fa-check-circle" aria-hidden="true"> Aceptar</i>
                            </button>
                        </div>
                    </div>
                </div> <!-- FIN modal-content -->
            </div> <!-- FIN modal-dialog -->
        </div> <!-- FIN Modal Detalle Préstamo -->

        {{-- =============================================================== --}}
        {{-- =============================================================== --}}

        <!-- INICIO Modal ABONO Préstamo -->
        <div class="modal fade" id="modalAbonoPrestamo_{{$prestamo->id_prestamo}}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content p-3">
                    {!! Form::open([
                        'method' => 'POST',
                        'route' => ['prestamos.store'],
                        'class' => 'mt-0',
                        'autocomplete' => 'off',
                        'id' => 'formAbonoPrestamo_'.$prestamo->id_usuario,
                        ]) !!}
                        @csrf

                        {!! Form::hidden('id_prestamo', isset($prestamo) ? $prestamo->id_prestamo : null, ['class' => '', 'id' => 'id_prestamo', 'required']) !!}
                        {!! Form::hidden('id_usuario', isset($prestamo) ? $prestamo->id_usuario : null, ['class' => '', 'id' => 'id_usuario', 'required']) !!}

                        <div class="rounded-top" style="border: solid 1px #337AB7;">
                            <div class="rounded-top text-white text-center" style="background-color: #337AB7; border: solid 1px #337AB7;">
                                <h5>Abono a Préstamos de: {{$prestamo->nombre_usuario}} {{$prestamo->apellido_usuario}}</h5>
                            </div>

                            <div class="modal-body m-0">
                                <div class="row m-0">
                                    <div class="col-12 col-md-6">
                                        <label for="valor_prestamo" class="fw-bold" style="font-size: 12px">Valor Préstamo <span class="text-danger">*</span></label>
                                        {!! Form::text('valor_prestamo', isset($prestamo) ? $prestamo->valor_prestamo : null, ['class' => 'form-control', 'id' => 'valor_prestamo', 'required']) !!}
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label for="valor_pendiente" class="fw-bold" style="font-size: 12px">Valor Pendiente <span class="text-danger">*</span></label>
                                        {!! Form::text('valor_pendiente', null, ['class' => 'form-control', 'id' => 'valor_pendiente', 'required']) !!}
                                    </div>

                                    <div class="col-12 col-md-6 mt-3">
                                        <label for="valor_abono" class="fw-bold" style="font-size: 12px">Valor Abono <span class="text-danger">*</span></label>
                                        {!! Form::text('valor_abono', null, ['class' => 'form-control', 'id' => 'valor_abono', 'required']) !!}
                                    </div>
                                </div>
                            </div> <!-- FIN modal-body -->
                        </div> <!-- FIN rounded-top -->

                        {{-- ====================================================== --}}
                        {{-- ====================================================== --}}

                        <!-- Contenedor para el GIF -->
                        <div id="loadingIndicatorAbonoPrestamo_{{$prestamo->id_prestamo}}" class="loadingIndicator">
                            <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
                        </div>

                        {{-- ====================================================== --}}
                        {{-- ====================================================== --}}

                        <div class="modal-footer border-0 justify-content-center">
                            <div class="">
                                <button type="submit" class="btn btn-success" id="btn_abono_prestamo_{{$prestamo->id_prestamo}}">
                                    <i class="fa fa-floppy-o" aria-hidden="true"> Registrar</i>
                                </button>
                            </div>

                            <div class="">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="btn_cancelar_abono_{{$prestamo->id_prestamo}}">
                                    <i class="fa fa-remove" aria-hidden="true">  Cancelar</i>
                                </button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div> <!-- FIN modal-content -->
            </div> <!-- FIN modal-dialog -->
        </div> <!-- FIN Modal ABONO Préstamo -->
        
        {{-- =============================================================== --}}
        {{-- =============================================================== --}}

        <!-- INICIO Modal MODIFICAR Préstamo -->
        <div class="modal fade" id="modalModificarPrestamo_{{$prestamo->id_prestamo}}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content p-3">
                    {!! Form::open([
                        'method' => 'POST',
                        'route' => ['prestamos.store'],
                        'class' => 'mt-0',
                        'autocomplete' => 'off',
                        'id' => 'formAbonoPrestamo_'.$prestamo->id_usuario,
                        ]) !!}
                        @csrf

                        {!! Form::hidden('id_prestamo', isset($prestamo) ? $prestamo->id_prestamo : null, ['class' => '', 'id' => 'id_prestamo', 'required']) !!}
                        {!! Form::hidden('id_usuario', isset($prestamo) ? $prestamo->id_usuario : null, ['class' => '', 'id' => 'id_usuario', 'required']) !!}

                        <div class="rounded-top" style="border: solid 1px #337AB7;">
                            <div class="rounded-top text-white text-center" style="background-color: #337AB7; border: solid 1px #337AB7;">
                                <h5>Modificar Fecha Límite</h5>
                            </div>

                            <div class="modal-body m-0">
                                <div class="row m-0">
                                    <div class="col-12 col-md-6">
                                        <label for="valor_prestamo" class="fw-bold" style="font-size: 12px">Fecha Límite <span class="text-danger">*</span></label>
                                        {!! Form::date('fecha_limite', isset($prestamo) ? $prestamo->fecha_limite : null, ['class' => 'form-control', 'id' => 'fecha_limite', 'required','onkeydown' => 'return false']) !!}
                                    </div>
                                </div>
                            </div> <!-- FIN modal-body -->
                        </div> <!-- FIN rounded-top -->

                        {{-- ====================================================== --}}
                        {{-- ====================================================== --}}

                        <!-- Contenedor para el GIF -->
                        <div id="loadingIndicatorFechaLimite_{{$prestamo->id_prestamo}}" class="loadingIndicator">
                            <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
                        </div>

                        {{-- ====================================================== --}}
                        {{-- ====================================================== --}}

                        <div class="modal-footer border-0 justify-content-center">
                            <div class="">
                                <button type="submit" class="btn btn-success" id="btn_fecha_limite_{{$prestamo->id_prestamo}}">
                                    <i class="fa fa-floppy-o" aria-hidden="true"> Modificar</i>
                                </button>
                            </div>

                            <div class="">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="btn_cancelar_fecha_{{$prestamo->id_prestamo}}">
                                    <i class="fa fa-remove" aria-hidden="true">  Cancelar</i>
                                </button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div> <!-- FIN modal-content -->
            </div> <!-- FIN modal-dialog -->
        </div> <!-- FIN Modal MODIFICAR Préstamo -->

        {{-- =============================================================== --}}
        {{-- =============================================================== --}}

        <!-- INICIO Modal VER DETALLES ABONO Préstamo -->
        <div class="modal fade" id="modalVerAbonos_{{$prestamo->id_prestamo}}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content p-3">
                    {!! Form::open([
                        'method' => 'POST',
                        'route' => ['prestamos.store'],
                        'class' => 'mt-0',
                        'autocomplete' => 'off',
                        'id' => 'formAbonoPrestamo_'.$prestamo->id_usuario,
                        ]) !!}
                        @csrf

                        {!! Form::hidden('id_prestamo', isset($prestamo) ? $prestamo->id_prestamo : null, ['class' => '', 'id' => 'id_prestamo', 'required']) !!}
                        {!! Form::hidden('id_usuario', isset($prestamo) ? $prestamo->id_usuario : null, ['class' => '', 'id' => 'id_usuario', 'required']) !!}

                        <div class="rounded-top" style="border: solid 1px #337AB7;">
                            <div class="rounded-top text-white text-center" style="background-color: #337AB7; border: solid 1px #337AB7;">
                                <h5>Detalle Abonos de: {{$prestamo->nombre_usuario}} {{$prestamo->apellido_usuario}}</h5>
                            </div>

                            <div class="modal-body m-0">
                                <div class="row m-0">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered m-100 mb-0" aria-describedby="entradas" id="tbl_ver_abonos">
                                                <thead>
                                                    <tr class="header-table text-center">
                                                        <th>Fecha Abono</th>
                                                        <th>Valor</th>
                                                        <th>Opciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="text-center">
                                                        <td>{{$prestamo->fecha_prestamo}}</td>
                                                        <td>{{$prestamo->valor_prestamo}}</td>
                                                        <td>
                                                            <button title="Abonar" class="btn btn-warning rounded-circle btn-circle text-white" data-bs-toggle="modal" data-bs-target="#modalEditarAbono_{{$prestamo->id_prestamo}}">
                                                                <i class="fa fa-money"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- FIN modal-body -->
                        </div> <!-- FIN rounded-top -->

                        {{-- ====================================================== --}}
                        {{-- ====================================================== --}}

                        <!-- Contenedor para el GIF -->
                        <div id="loadingIndicatorVerAbonos_{{$prestamo->id_prestamo}}" class="loadingIndicator">
                            <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
                        </div>

                        {{-- ====================================================== --}}
                        {{-- ====================================================== --}}

                        <div class="modal-footer border-0 justify-content-center">
                            <div class="col-12">
                                <button type="button" class="btn btn-primary btn-md active pull-right" style="background-color: #337AB7;" data-bs-dismiss="modal" id="btnDetalleAbonos_{{$prestamo->id_prestamo}}">
                                    <i class="fa fa-check-circle" aria-hidden="true"> Aceptar</i>
                                </button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div> <!-- FIN modal-content -->
            </div> <!-- FIN modal-dialog -->
        </div> <!-- FIN Modal VER DETALLES ABONO Préstamo -->

        {{-- =============================================================== --}}
        {{-- =============================================================== --}}

        {{-- INICIO Modal ESTADO PRÉSTAMO --}}
        <div class="modal fade" id="modalCambiarEstadoPrestamo_{{$prestamo->id_prestamo}}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content p-0">
                    {!! Form::open([
                        'method' => 'POST',
                        'route' => ['cambiar_estado_producto'],
                        'class' => 'mt-2',
                        'autocomplete' => 'off',
                        'id' => 'formCambiarEstadoProducto_' . $prestamo->id_prestamo]) !!}
                        @csrf

                        <div class="rounded-top" style="border: solid 1px #337AB7;">
                            <div class="rounded-top text-white text-center"
                                style="background-color: #337AB7; border: solid 1px #337AB7;">
                                <h5>Cambiar estado del préstamo</h5>
                            </div>

                            <div class="modal-body m-0">
                                <div class="mt-4 mb-4 text-center">
                                    <span class="text-danger fs-5">¿Realmente desea cambiar el estado del préstamo?</span>
                                </div>
                            </div> <!-- FIN modal-body -->

                            {{ Form::hidden('id_prestamo', isset($prestamo) ? $prestamo->id_prestamo : null, ['class' => '', 'id' => 'id_prestamo']) }}
                        </div>

                        {{-- ====================================================== --}}
                        {{-- ====================================================== --}}

                        <!-- Contenedor para el GIF -->
                        <div id="loadingIndicatorEstadoPrestamo_{{$prestamo->id_prestamo}}"
                            class="loadingIndicator">
                            <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
                        </div>

                        {{-- ====================================================== --}}
                        {{-- ====================================================== --}}

                        <div class="modal-footer border-0 d-flex justify-content-around mt-3">
                            <button type="submit" id="btn_cambiar_estado_prestamo_{{$prestamo->id_prestamo}}"
                                class="btn btn-success" title="Guardar Configuración">
                                <i class="fa fa-floppy-o" aria-hidden="true"> Modificar</i>
                            </button>

                            <button type="button" id="btn_cancelar_estado_prestamo_{{$prestamo->id_prestamo}}"
                                class="btn btn-secondary" title="Cancelar"
                                data-bs-dismiss="modal">
                                <i class="fa fa-times" aria-hidden="true"> Cancelar</i>
                            </button>
                        </div>
                    {!! Form::close() !!}
                </div> {{-- FIN modal-content --}}
            </div> {{-- FIN modal-dialog --}}
        </div> {{-- FIN modal --}}
        {{-- FINAL Modal ESTADO PRÉSTAMO--}}
    @endforeach
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('scripts')
    <script src="{{asset('DataTables/datatables.min.js')}}"></script>
    <script src="{{asset('DataTables/Buttons-2.3.4/js/buttons.html5.min.js')}}"></script>

    <script>
        $( document ).ready(function() {
            // INICIO DataTable Préstamo empleados
            $("#tbl_prestamo_empleados").DataTable({
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
            // CIERRE DataTable Préstamo empleados

            // ==============================================
            // ==============================================

            // INICIO DataTable Detalles Préstamo empleados
            var tableDetalles = $("#tbl_detalles_prestamo").DataTable({
                dom: 'Blfrtip',
                "infoEmpty": "No hay registros",
                stripe: true,
                "bSort": false,
                "autoWidth": false,
                "scrollX": true,
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
                "pageLength": 10
            });

            // Ajustar columnas cuando el modal se muestra
            $('#modalDetallePrestamo_{{$prestamo->id_prestamo}}').on('shown.bs.modal', function () {
                tableDetalles.columns.adjust();
            });
            // CIERRE DataTable Detalles Préstamo empleados

            // ==============================================
            // ==============================================

            // INICIO DataTable  Ver Abonos
            var tblVerAbonos = $("#tbl_ver_abonos").DataTable({
                dom: 'Blfrtip',
                "infoEmpty": "No hay registros",
                stripe: true,
                "bSort": false,
                "autoWidth": false,
                "scrollX": true,
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
                "pageLength": 10
            });

            // Ajustar columnas cuando el modal se muestra
            $('#modalVerAbonos_{{$prestamo->id_prestamo}}').on('shown.bs.modal', function () {
                tblVerAbonos.columns.adjust();
            });
            // CIERRE DataTable Ver Abonos

            // ==============================================
            // ==============================================

            $(document).on('shown.bs.modal', '#modalReportePrestamos', function () {
                let modal = $(this); // Referencia del modal

                function configurarCalendario(inputId, iconoId) {
                    let inputFecha = modal.find(`#${inputId}`);
                    let iconoCalendario = modal.find(`#${iconoId}`);

                    if (inputFecha.length > 0) {
                        // Abre el calendario al hacer clic en el input
                        inputFecha.on("focus", function () {
                            if (typeof this.showPicker === "function") {
                                this.showPicker();
                            }
                        });

                        // Abre el calendario al hacer clic en el icono
                        iconoCalendario.on("mousedown touchstart", function (event) {
                            event.preventDefault();
                            if (typeof inputFecha[0].showPicker === "function") {
                                inputFecha[0].showPicker();
                            }
                        });

                        // Evento para asegurarse de que la fecha se refleje
                        inputFecha.on("change", function () {
                        });
                    }
                }

                // Configura ambos campos de fecha dentro del modal
                configurarCalendario("fecha_inicial", "calendar_addon_inicial");
                configurarCalendario("fecha_final", "calendar_addon_final");
            });
        }); // FIN document.ready
    </script>
@stop
