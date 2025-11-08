@extends('layouts.app')
@section('title', 'Pago a Empleados')

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
                <h5 class="border rounded-top text-white text-center pt-2 pb-2 m-0" style="background-color: #337AB7">Listar Pagos</h5>
            
                <div class="col-12 p-3" id="">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered w-100 mb-0" id="tbl_pago_empleados" aria-describedby="pago_empleados">
                            <thead>
                                <tr class="header-table text-center">
                                    <th>Identificación</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Tipo Empleado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            {{-- ============================== --}}
                            <tbody>
                                @foreach ($pagoEmpleadosIndex as $pagoEmpleado)
                                    @php
                                    @endphp
                                    <tr class="text-center">
                                        <td>{{$pagoEmpleado->tipo_documento}} - {{$pagoEmpleado->tipo_documento}}</td>
                                        <td>{{$pagoEmpleado->nombre_usuario}}</td>
                                        <td>{{$pagoEmpleado->apellido_usuario}}</td>
                                        <td>{{$pagoEmpleado->tipo_persona}}</td>
                                        <td>
                                            <button title="Detalles Pago" class="btn rounded-circle btn-circle text-white" style="background-color: #286090" data-bs-toggle="modal" data-bs-target="#modalDetallesPago_{{$pagoEmpleado->id_pago_empleado}}">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </button>
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
                            Reporte Pagos
                        </button>
                    </div> -->
                </div> {{-- FIN div_campos_usuarios --}}
            </div> {{-- FIN div_crear_usuario --}}
        </div> {{-- p-3 d-flex flex-column --}}
    </div> {{-- FIN content d-flex --}}
    
    {{-- =============================================================== --}}
    {{-- =============================================================== --}}

    @foreach ($pagoEmpleadosIndex as $pagoEmpleado)
        <!-- INICIO Modal Detalle Pago -->
        <div class="modal fade" id="modalDetallesPago_{{$pagoEmpleado->id_pago_empleado}}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" style="max-width: 80%;">
            <div class="modal-dialog">
                <div class="modal-content p-3">
                    <div class="rounded-top" style="border: solid 1px #337AB7;">
                        <div class="rounded-top text-white text-center" style="background-color: #337AB7; border: solid 1px #337AB7;">
                            <h5>Detalle Pago de:</h5>
                        </div>

                        <div class="modal-body p-0 m-0">
                            <div class="row m-0">
                                <div class="col-12 p-3 pt-1">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered m-100 mb-0" aria-describedby="entradas" id="tbl_detalles_pago">
                                            <thead>
                                                <tr class="header-table text-center">
                                                    <th>Fecha Pago</th>
                                                    <th>Tipo Pago</th>
                                                    <th>Valor en Ventas</th>
                                                    <th>Comisiones</th>
                                                    <th>Prima</th>
                                                    <th>Vacaciones</th>
                                                    <th>Cesantias</th>
                                                    <th>Valor Total</th>
                                                    <th>Estado</th>
                                                    <th>Opción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center">
                                                    <td>{{$pagoEmpleado->fecha_pago}}</td>
                                                    <td>{{$pagoEmpleado->tipo_pago}}</td>
                                                    <td>{{$pagoEmpleado->valor_ventas}}</td>
                                                    <td>{{$pagoEmpleado->valor_comision}}</td>
                                                    <td>{{$pagoEmpleado->cantidad_dias}}</td>
                                                    <td>{{$pagoEmpleado->valor_vacaciones}}</td>
                                                    <td>{{$pagoEmpleado->valor_cesantias}}</td>
                                                    <td>{{$pagoEmpleado->valor_total}}</td>
                                                    <td>{{$pagoEmpleado->estado}}</td>
                                                    <td>
                                                        <button title="Anular" class="btn btn-danger rounded-circle btn-circle text-white" data-bs-toggle="modal" data-bs-target="#modalAnularPago_{{$pagoEmpleado->id_pago_empleado}}">
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
                            <button type="button" class="btn btn-primary btn-md active pull-right" data-bs-dismiss="modal" style="background-color: #337AB7;" id="btnDetallePago">
                                <i class="fa fa-check-circle"> Aceptar</i>
                            </button>
                        </div>
                    </div>
                </div> <!-- FIN modal-content -->
            </div> <!-- FIN modal-dialog -->
        </div> <!-- FIN Modal Detalle Pago -->
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
            // INICIO DataTable Pago empleados
            $("#tbl_pago_empleados").DataTable({
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
                "pageLength": 10,
            });
            // CIERRE DataTable Pago empleados

            // ===================================================
            // ===================================================

            // INICIO DataTable Detalles Pago
            var tblDetallePago = $("#tbl_detalles_pago").DataTable({
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
            $('#modalDetallesPago_').on('shown.bs.modal', function () {
                tblDetallePago.columns.adjust();
            });
            // CIERRE DataTable Detalles Pago
            
            // ===================================================
            // ===================================================

        });
    </script>
@stop


