@extends('layouts.app')
@section('title', 'Préstamos a Vencer')

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
            z-index: 10;
            background-color: transparent;
        }
    </style>
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('content')
    <div class="d-flex p-0">
        <div class="p-0" style="width: 20%">
            @include('layouts.sidebarmenu')
        </div>

        {{-- ======================================================================= --}}
        {{-- ======================================================================= --}}

        <div class="p-3 d-flex flex-column" style="width: 80%">
            <div class="p-0" style="border: solid 1px #337AB7; border-radius: 5px;">
                <h5 class="border rounded-top text-white text-center pt-2 pb-2 m-0" style="background-color: #337AB7">Listar Préstamos Empleados</h5>
            
                <div class="col-12 p-3" id="">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered w-100 mb-0" id="tbl_prestamo_empleados_vencer" aria-describedby="prestamo_empleados_vencer">
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
                                @foreach ($prestamosVencer as $prestamoVencer)
                                    <tr class="text-center">
                                        <td class="text-danger">{{$prestamoVencer->identificacion}}</td>
                                        <td class="text-danger">{{$prestamoVencer->nombre_usuario}}</td>
                                        <td class="text-danger">{{$prestamoVencer->apellido_usuario}}</td>
                                        <td class="text-danger">{{$prestamoVencer->tipo_persona}}</td>
                                        <td>
                                            <button class="btn rounded-circle btn-circle text-white" title="Detalles Préstamo" style="background-color: #286090" data-bs-toggle="modal" data-bs-target="#modalPrestamoVencer_{{$prestamoVencer->id_prestamo}}">
                                                <i class="fa fa-eye"></i>
                                            </button>

                                            <!-- <button class="btn btn-success rounded-circle btn-circle text-white" title="Generar PDF">
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
                        <button class="btn rounded-2 me-3 text-white" type="submit" style="background-color: #204D74">
                            <i class="fa fa-file-pdf-o"></i>
                            Reporte Préstamos
                        </button>
                    </div> -->
                </div> {{-- FIN div_campos_usuarios --}}
            </div> {{-- FIN div_crear_usuario --}}
        </div> {{-- FIN div 80%  --}}
    </div> {{-- FIN content d-flex p-0 --}}
    
    {{-- =============================================================== --}}
    {{-- =============================================================== --}}
    {{-- =============================================================== --}}

    @foreach ($prestamosVencer as $prestamoVencer)
        <!-- INICIO Modal VER DETALLES PRÉSTAMO VENCER -->
        <div class="modal fade" id="modalPrestamoVencer_{{$prestamoVencer->id_prestamo}}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" style="max-width: 80%;">
            <div class="modal-dialog">
                <div class="modal-content p-3">

                    {!! Form::hidden('id_prestamo', isset($prestamoVencer) ? $prestamoVencer->id_prestamo : null, ['class' => '', 'id' => 'id_prestamo', 'required']) !!}
                    {!! Form::hidden('id_usuario', isset($prestamoVencer) ? $prestamoVencer->id_usuario : null, ['class' => '', 'id' => 'id_usuario', 'required']) !!}

                    <div class="rounded-top" style="border: solid 1px #337AB7;">
                        <div class="rounded-top text-white text-center" style="background-color: #337AB7; border: solid 1px #337AB7;">
                            <h5>Detalle de Préstamos de: {{$prestamoVencer->nombre_usuario}} {{$prestamoVencer->apellido_usuario}}</h5>
                        </div>

                        <div class="modal-body m-0">
                            <div class="row m-0">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered m-100 mb-0" aria-describedby="entradas" id="tbl_detalle_prestamos">
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
                                                    <td>{{$prestamoVencer->tipo_documento}}</td>
                                                    <td>{{$prestamoVencer->identificacion}}</td>
                                                    <td>{{$prestamoVencer->fecha_prestamo}}</td>
                                                    <td>{{$prestamoVencer->fecha_limite}}</td>
                                                    <td>{{$prestamoVencer->valor_prestamo}}</td>
                                                    <td>{{$prestamoVencer->valor_prestamo}}</td>
                                                    <td>{{$prestamoVencer->descripcion}}</td>
                                                    <td>{{$prestamoVencer->valor_prestamo}}</td>
                                                    <td>{{$prestamoVencer->valor_prestamo}}</td>
                                                    <td>
                                                        <button title="Abonar" class="btn btn-warning rounded-circle btn-circle text-white" data-bs-toggle="modal" data-bs-target="#modalAbonarPrestamo_{{$prestamoVencer->id_prestamo}}">
                                                            <i class="fa fa-money"></i>
                                                        </button>

                                                        <button title="Modificar Préstamo" class="btn btn-success rounded-circle btn-circle text-white" data-bs-toggle="modal" data-bs-target="#modalModificarPrestamo_{{$prestamoVencer->id_prestamo}}">
                                                            <i class="fa-pencil-square-o"></i>
                                                        </button>

                                                        <button title="Ver abonos" class="btn btn-primary rounded-circle btn-circle text-white" data-bs-toggle="modal" data-bs-target="#modalVerAbonos_{{$prestamoVencer->id_prestamo}}">
                                                            <i class="fa fa-eye"></i>
                                                        </button>

                                                        <button title="Cambiar Estado" class="btn btn-danger rounded-circle btn-circle text-white" data-bs-toggle="modal" data-bs-target="#modalCambiarEstadoPrestamo_{{$prestamoVencer->id_prestamo}}">
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

                    {{-- ====================================================== --}}
                    {{-- ====================================================== --}}

                    <div class="row mt-3">
                        <div class="col-12">
                            <button type="button" class="btn btn-primary btn-md active pull-right" data-bs-dismiss="modal" style="background-color: #337AB7;" id="btnDetallePrestamoVencer_{{$prestamoVencer->id_prestamo}}">
                                <i class="fa fa-check-circle" aria-hidden="true"> Aceptar</i>
                            </button>
                        </div>
                    </div>
                </div> <!-- FIN modal-content -->
            </div> <!-- FIN modal-dialog -->
        </div> <!-- FIN Modal VER DETALLES PRÉSTAMO VENCER -->

        {{-- =============================================================== --}}
        {{-- =============================================================== --}}

        <!-- INICIO Modal ABONO Préstamo -->
        <div class="modal fade" id="modalAbonarPrestamo_{{$prestamoVencer->id_prestamo}}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content p-3">
                    {!! Form::open([
                        'method' => 'POST',
                        'route' => ['prestamos.store'],
                        'class' => 'mt-0',
                        'autocomplete' => 'off',
                        'id' => 'formAbonoPrestamo_'.$prestamoVencer->id_usuario,
                        ]) !!}
                        @csrf

                        {!! Form::hidden('id_prestamo', isset($prestamoVencer) ? $prestamoVencer->id_prestamo : null, ['class' => '', 'id' => 'id_prestamo', 'required']) !!}
                        {!! Form::hidden('id_usuario', isset($prestamoVencer) ? $prestamoVencer->id_usuario : null, ['class' => '', 'id' => 'id_usuario', 'required']) !!}

                        <div class="rounded-top" style="border: solid 1px #337AB7;">
                            <div class="rounded-top text-white text-center" style="background-color: #337AB7; border: solid 1px #337AB7;">
                                <h5>Abono a Préstamos de: {{$prestamoVencer->nombre_usuario}} {{$prestamoVencer->apellido_usuario}}</h5>
                            </div>

                            <div class="modal-body m-0">
                                <div class="row m-0">
                                    <div class="col-12 col-md-6">
                                        <label for="valor_prestamo" class="fw-bold" style="font-size: 12px">Valor Préstamo <span class="text-danger">*</span></label>
                                        {!! Form::text('valor_prestamo', isset($prestamoVencer) ? $prestamoVencer->valor_prestamo : null, ['class' => 'form-control bg-secondary-subtle', 'id' => 'valor_prestamo', 'required', 'readonly']) !!}
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label for="valor_pendiente" class="fw-bold" style="font-size: 12px">Valor Pendiente <span class="text-danger">*</span></label>
                                        {!! Form::text('valor_pendiente', null, ['class' => 'form-control bg-secondary-subtle', 'id' => 'valor_pendiente', 'required', 'readonly']) !!}
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
                        <div id="loadingIndicatorAbonoPrestamo_{{$prestamoVencer->id_prestamo}}" class="loadingIndicator">
                            <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
                        </div>

                        {{-- ====================================================== --}}
                        {{-- ====================================================== --}}

                        <div class="modal-footer border-0 justify-content-center">
                            <div class="">
                                <button type="submit" class="btn btn-success" id="btn_abono_prestamo_{{$prestamoVencer->id_prestamo}}">
                                    <i class="fa fa-floppy-o"> Guardar</i>
                                </button>
                            </div>

                            <div class="">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="btn_cancelar_abono_{{$prestamoVencer->id_prestamo}}">
                                    <i class="fa fa-remove">  Cancelar</i>
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
        <div class="modal fade" id="modalModificarPrestamo_{{$prestamoVencer->id_prestamo}}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content p-3">
                    {!! Form::open([
                        'method' => 'POST',
                        'route' => ['prestamos.store'],
                        'class' => 'mt-0',
                        'autocomplete' => 'off',
                        'id' => 'formModificarPrestamo_'.$prestamoVencer->id_usuario,
                        ]) !!}
                        @csrf

                        {!! Form::hidden('id_prestamo', isset($prestamoVencer) ? $prestamoVencer->id_prestamo : null, ['class' => '', 'id' => 'id_prestamo', 'required']) !!}
                        {!! Form::hidden('id_usuario', isset($prestamoVencer) ? $prestamoVencer->id_usuario : null, ['class' => '', 'id' => 'id_usuario', 'required']) !!}

                        <div class="rounded-top" style="border: solid 1px #337AB7;">
                            <div class="rounded-top text-white text-center" style="background-color: #337AB7; border: solid 1px #337AB7;">
                                <h5>Modificar Fecha Límite</h5>
                            </div>

                            <div class="modal-body m-0">
                                <div class="row m-0">
                                    <div class="col-12 col-md-6">
                                        <label for="fecha_limite" class="fw-bold" style="font-size: 12px">
                                            Fecha Límite <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group" id="calendar-addon" style="cursor: pointer;">
                                            <span class="input-group-text">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                            {!! Form::date('fecha_limite', null, ['class' => 'form-control', 'id' => 'fecha_limite', 'required','onkeydown' => 'return false']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- FIN modal-body -->
                        </div> <!-- FIN rounded-top -->

                        {{-- ====================================================== --}}
                        {{-- ====================================================== --}}

                        <!-- Contenedor para el GIF -->
                        <div id="loadingIndicatorFechaLimite_{{$prestamoVencer->id_prestamo}}" class="loadingIndicator">
                            <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
                        </div>

                        {{-- ====================================================== --}}
                        {{-- ====================================================== --}}

                        <div class="modal-footer border-0 justify-content-center">
                            <div class="">
                                <button type="submit" class="btn btn-success" id="btn_fecha_limite_{{$prestamoVencer->id_prestamo}}">
                                    <i class="fa fa-floppy-o"> Modificar</i>
                                </button>
                            </div>

                            <div class="">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="btn_cancelar_fecha_{{$prestamoVencer->id_prestamo}}">
                                    <i class="fa fa-remove">  Cancelar</i>
                                </button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div> <!-- FIN modal-content -->
            </div> <!-- FIN modal-dialog -->
        </div> <!-- FIN Modal MODIFICAR Préstamo -->

        {{-- =============================================================== --}}
        {{-- =============================================================== --}}

        
        {{-- =============================================================== --}}
        {{-- =============================================================== --}}

        <!-- INICIO Modal VER DETALLES ABONO Préstamo -->
        <div class="modal fade" id="modalVerAbonos_{{$prestamoVencer->id_prestamo}}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content p-3">
                    <div class="rounded-top" style="border: solid 1px #337AB7;">
                        <div class="rounded-top text-white text-center" style="background-color: #337AB7; border: solid 1px #337AB7;">
                            <h5>Detalle Abonos de: {{$prestamoVencer->nombre_usuario}} {{$prestamoVencer->apellido_usuario}}</h5>
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
                                                    <td>{{$prestamoVencer->fecha_prestamo}}</td>
                                                    <td>{{$prestamoVencer->valor_prestamo}}</td>
                                                    <td>
                                                        <button title="Abonar" class="btn btn-warning rounded-circle btn-circle text-white" data-bs-toggle="modal" data-bs-target="#modalEditarAbono_{{$prestamoVencer->id_prestamo}}">
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

                    <div class="modal-footer border-0 justify-content-center">
                        <div class="col-12">
                            <button type="button" class="btn btn-primary btn-md active pull-right" style="background-color: #337AB7;" data-bs-dismiss="modal" id="btnDetalleAbonos_{{$prestamoVencer->id_prestamo}}">
                                <i class="fa fa-check-circle" aria-hidden="true"> Aceptar</i>
                            </button>
                        </div>
                    </div>
                </div> <!-- FIN modal-content -->
            </div> <!-- FIN modal-dialog -->
        </div> <!-- FIN Modal VER DETALLES ABONO Préstamo -->
        
        {{-- =============================================================== --}}
        {{-- =============================================================== --}}

        {{-- INICIO Modal ESTADO PRÉSTAMO --}}
        <div class="modal fade" id="modalCambiarEstadoPrestamo_{{$prestamoVencer->id_prestamo}}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content p-3">
                    {!! Form::open([
                        'method' => 'POST',
                        'route' => ['cambiar_estado_producto'],
                        'class' => 'mt-2',
                        'autocomplete' => 'off',
                        'id' => 'formCambiarEstadoPrestamo_' . $prestamoVencer->id_prestamo]) !!}
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

                            {{ Form::hidden('id_prestamo', isset($prestamoVencer) ? $prestamoVencer->id_prestamo : null, ['class' => '', 'id' => 'id_prestamo']) }}
                        </div>

                        {{-- ====================================================== --}}
                        {{-- ====================================================== --}}

                        <!-- Contenedor para el GIF -->
                        <div id="loadingIndicatorEstadoPrestamo_{{$prestamoVencer->id_prestamo}}"
                            class="loadingIndicator">
                            <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
                        </div>

                        {{-- ====================================================== --}}
                        {{-- ====================================================== --}}

                        <div class="modal-footer border-0 d-flex justify-content-around mt-3">
                            <button type="submit" id="btn_cambiar_estado_prestamo_{{$prestamoVencer->id_prestamo}}"
                                class="btn btn-success" title="Guardar Configuración">
                                <i class="fa fa-floppy-o" aria-hidden="true"> Modificar</i>
                            </button>

                            <button type="button" id="btn_cancelar_estado_prestamo_{{$prestamoVencer->id_prestamo}}"
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
            // INICIO DataTable Préstamos por vencer
            $("#tbl_prestamo_empleados_vencer").DataTable({
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
            // CIERRE DataTable Préstamos por vencer

            // ==============================================

            // INICIO DataTable Detalles Préstamo empleados
            var tblDetallesPrestamo = $("#tbl_detalle_prestamos").DataTable({
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
            $('#modalPrestamoVencer_{{$prestamoVencer->id_prestamo}}').on('shown.bs.modal', function () {
                tblDetallesPrestamo.columns.adjust();
            });
            // CIERRE DataTable Detalles Préstamo empleados

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
            $('#modalVerAbonos_{{$prestamoVencer->id_prestamo}}').on('shown.bs.modal', function () {
                tblVerAbonos.columns.adjust();
            });
            // CIERRE DataTable Ver Abonos

            // ==============================================

            let fechaInput = document.getElementById('fecha_limite');
            let calendarIcon = document.getElementById('calendar-addon');

            // Verificamos si el navegador soporta showPicker()
            if (fechaInput.showPicker) {
                calendarIcon.addEventListener('click', function() {
                    fechaInput.focus(); // Forzamos el enfoque en el input dentro del modal
                    setTimeout(() => fechaInput.showPicker(), 50); // Pequeño delay para evitar bloqueo
                });
            } else {
                console.warn("showPicker() no es compatible con este navegador.");
            }

            // ==============================================

            $(document).on("submit", "form[id^='formAbonoPrestamo_']", function(e) {
                const form = $(this);
                const formId = form.attr('id'); // Obtenemos el ID del formulario
                const id = formId.split('_')[1]; // Obtener el ID del formulario desde el ID del formulario

                // Capturar el spinner y btns dinámicamente
                const loadingIndicator = $(`#loadingIndicatorAbonoPrestamo_${id}`);
                const submitButton = $(`#btn_abono_prestamo_${id}`);
                const cancelButton = $(`#btn_cancelar_abono_${id}`);

                // Deshabilitar botones
                cancelButton.prop("disabled", true);
                submitButton.prop("disabled", true).html("Procesando... <i class='fa fa-spinner fa-spin'></i>");

                // Cargar Spinner
                loadingIndicator.show();
            });
            
            // ==============================================

            $(document).on("submit", "form[id^='formModificarPrestamo_']", function(e) {
                const form = $(this);
                const formId = form.attr('id'); // Obtenemos el ID del formulario
                const id = formId.split('_')[1]; // Obtener el ID del formulario desde el ID del formulario

                // Capturar el spinner y btns dinámicamente
                const loadingIndicator = $(`#loadingIndicatorFechaLimite_${id}`);
                const submitButton = $(`#btn_fecha_limite_${id}`);
                const cancelButton = $(`#btn_cancelar_fecha_${id}`);

                // Deshabilitar botones
                cancelButton.prop("disabled", true);
                submitButton.prop("disabled", true).html("Procesando... <i class='fa fa-spinner fa-spin'></i>");

                // Cargar Spinner
                loadingIndicator.show();
            });

            // ==============================================
            
            $(document).on("submit", "form[id^='formCambiarEstadoPrestamo_']", function(e) {
                const form = $(this);
                const formId = form.attr('id'); // Obtenemos el ID del formulario
                const id = formId.split('_')[1]; // Obtener el ID del formulario desde el ID del formulario

                // Capturar el spinner y btns dinámicamente
                const loadingIndicator = $(`#loadingIndicatorEstadoPrestamo_${id}`);
                const submitButton = $(`#btn_cambiar_estado_prestamo_${id}`);
                const cancelButton = $(`#btn_cancelar_estado_prestamo_${id}`);

                // Deshabilitar botones
                cancelButton.prop("disabled", true);
                submitButton.prop("disabled", true).html("Procesando... <i class='fa fa-spinner fa-spin'></i>");

                // Cargar Spinner
                loadingIndicator.show();
            });

            // ==============================================



        });
    </script>
@stop


