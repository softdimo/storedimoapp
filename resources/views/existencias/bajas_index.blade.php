@extends('layouts.app')
@section('title', 'Listar Bajas')

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
            <div class="d-flex justify-content-between pe-3 mt-2 mb-2">
                <div class="">
                    <a href="{{ route('existencias.create') }}" class="btn text-white"
                        style="background-color:#337AB7">Registrar Bajas</a>
                </div>
                <div class="text-end">
                    <a href="#" role="button" title="Ayuda" class="text-blue" data-bs-toggle="modal"
                        data-bs-target="#modalAyudaListarBajas">
                        <i class="fa fa-question-circle fa-2x" aria-hidden="false" title="Ayuda"
                            style="color: #337AB7"></i>
                    </a>
                </div>
            </div>

            <div class="modal fade" id="modalAyudaListarBajas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                data-keyboard ="false" data-backdrop = "static">
                <div class="modal-dialog" style="min-width: 60%;">
                    <div class="modal-content p-3">
                        <div class="modal-body p-0 rounded-top" style="border: solid 1px #337AB7; mw-50">
                            <div class="row">
                                <div class="col-12">
                                    <div class="rounded-top text-white text-center p-2"
                                        style="background-color: #337AB7; border: solid 1px #337AB7;">
                                        <span class="modal-title fs-4"><strong>Ayuda de Listar Bajas</strong></span>
                                    </div>
                                    {{-- =========================== --}}
                                    <div class="p-3">
                                        <p class="text-justify">En esta sección solo se mostrará más detalladamente la
                                            información de la baja que fue registrada, pero en caso de querer anular una
                                            baja tener en cuenta la siguiente recomendación.</p>

                                        <ol>
                                            <li class="text-justify">Una baja solo podrá ser anulada el mismo día en fue
                                                registrada</li>
                                            <li class="text-justify">En las fechas del reporte de las bajas, evitar ingresar
                                                fechas mayores o menores a los 3 meses.</li>
                                        </ol>
                                    </div> {{-- FINpanel-body --}}
                                </div> {{-- FIN col-12 --}}
                            </div> {{-- FIN modal-body .row --}}
                        </div> {{-- FIN modal-body --}}
                        {{-- =========================== --}}
                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="button" class="btn btn-primary btn-md active pull-right"
                                    data-bs-dismiss="modal" style="background-color: #337AB7;">
                                    <i class="fa fa-check-circle" aria-hidden="true">&nbsp;Aceptar</i>
                                </button>
                            </div>
                        </div>
                    </div> {{-- FIN modal-content --}}
                </div> {{-- FIN modal-dialog --}}
            </div> {{-- FIN modalAyudaModificacionProductos --}}

            {{-- =============================================================== --}}
            {{-- =============================================================== --}}

            <div class="p-0" style="border: solid 1px #337AB7; border-radius: 5px;">
                <h5 class="border rounded-top text-white text-center pt-2 pb-2 m-0" style="background-color: #337AB7">Listar
                    Bajas</h5>

                <div class="col-12 p-3" id="">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered w-100 mb-0" id="tbl_bajas"
                            aria-describedby="bajas">
                            <thead>
                                <tr class="header-table text-centerr align-middle">
                                    <th>Código Bajas</th>
                                    <th>Empleado Responsable Baja</th>
                                    <th>Fecha Baja</th>
                                    <th>Estado</th>
                                    <th>Ver Detalles</th>
                                </tr>
                            </thead>
                            {{-- ============================== --}}
                            <tbody>
                                @foreach ($bajasIndex as $baja)
                                    <tr class="text-centerr align-middle">
                                        <td>{{ $baja->id_baja }}</td>
                                        <td>{{ $baja->nombres_usuario }}</td>
                                        <td>{{ $baja->fecha_baja }}</td>
                                        <td>{{ $baja->estado }}</td>
                                        <td>
                                            <a href="#" role="button"
                                                class="btn rounded-circle btn-circle text-white btn-detalle-baja"
                                                title="Ver Detalles" style="background-color: #286090"
                                                data-id="{{ $baja->id_baja }}">
                                                <i class="fa fa-eye"></i>
                                            </a>
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
                        <button type="button" class="btn rounded-2 me-3 text-white" style="background-color: #286090"
                            data-bs-toggle="modal" data-bs-target="#modalReporteBajas">
                            <i class="fa fa-file-pdf-o"></i>
                            Reporte Bajas
                        </button>
                    </div> -->
                </div> {{-- FIN div_campos_usuarios --}}
            </div> {{-- FIN div_crear_usuario --}}
        </div>
    </div> {{-- FIN contenedor principal --}}

    {{-- =============================================================== --}}
    {{-- =============================================================== --}}
    {{-- =============================================================== --}}

    <!-- {{-- INICIO Modal REPORTE VENTAS --}}
    <div class="modal fade" id="modalReporteBajas" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content p-3">
                <div class="rounded-top" style="border: solid 1px #337AB7;">
                    {!! Form::open([
                        'method' => 'POST',
                        'route' => ['reporte_bajas_pdf'],
                        'class' => '',
                        'autocomplete' => 'off',
                        'id' => 'formReporteVentasPdf',
                        'target' => '_blank', // 👉 Abrir en nueva pestaña
                    ]) !!}
                    @csrf

                    <div class="rounded-top text-white text-center"
                        style="background-color: #337AB7; border: solid 1px #337AB7;">
                        <h5>Reporte Bajas</h5>
                    </div>

                    <div class="modal-body m-0">
                        <div class="row m-0">
                            <div class="col-12 col-md-6">
                                <label for="fecha_inicial" class="fw-bold" style="font-size: 12px">
                                    Fecha Inicial <span class="text-danger">*</span>
                                </label>
                                <div class="input-group" id="calendar_addon_inicial" style="cursor: pointer;">
                                    {!! Form::date('fecha_inicial', null, ['class' => 'form-control', 'id' => 'fecha_inicial', 'required']) !!}
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
                                    {!! Form::date('fecha_final', null, ['class' => 'form-control', 'id' => 'fecha_final', 'required', 'max' => \Carbon\Carbon::today()->format('Y-m-d')]) !!}
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div> <!-- FIN modal-body -->

                    {{-- ====================================================== --}}
                    {{-- ====================================================== --}}
<!-- 
                    <div class="modal-footer border-0 d-flex justify-content-center mt-3">
                        <button type="submit" id="btn_reporte_ventas" class="btn btn-success">
                            <i class="fa fa-file-pdf-o"> Generar</i>
                        </button>
                    </div>
                    {!! Form::close() !!}
                </div> {{-- FIN Div rounded-top --}}

                {{-- ====================================================== --}}
                {{-- ====================================================== --}}

                <div class="row mt-3">
                    <div class="col-12">
                        <button type="button" class="btn btn-primary btn-md active pull-right"
                            style="background-color: #6c757d;" data-bs-dismiss="modal">
                            <i class="fa fa-times"> Cerrar</i>
                        </button>
                    </div>
                </div>
            </div> {{-- FIN modal-content --}}
        </div> {{-- FIN modal-dialog --}}
    </div> {{-- FIN modal --}}
    {{-- FINAL Modal REPORTE VENTAS --}} -->

    {{-- =============================================================== --}}
    {{-- =============================================================== --}}
    {{-- =============================================================== --}}

    {{-- INICIO Modal DETALLE BAJA --}}
    <div class="modal fade" id="modalDetalleBaja" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog" style="min-width: 50%">
            <div class="modal-content p-3" id="modalDetalleBajaContent">
                {{-- El contenido AJAX se cargará aquí --}}
            </div>
        </div>
    </div>
    {{-- FINAL Modal DETALLE BAJA --}}
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('scripts')
    <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('DataTables/Buttons-2.3.4/js/buttons.html5.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // INICIO DataTable Bajas
            $("#tbl_bajas").DataTable({
                dom: 'Blfrtip',
                "infoEmpty": "No hay registros",
                stripe: true,
                bSort: false,
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Excel',
                        className: 'btn btn-sm btn-success mr-3',
                        customize: function(xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            $('row:first c', sheet).attr('s', '42');
                        }
                    }
                ],
                "pageLength": 25,
                "scrollX": true,
            });
            // CIERRE DataTable Bajas

            // ============================================================
            // ============================================================
            // ============================================================

            $(document).on('shown.bs.modal', '#modalReporteBajas', function() {
                let modal = $(this); // Referencia del modal

                function configurarCalendario(inputId, iconoId) {
                    let inputFecha = modal.find(`#${inputId}`);
                    let iconoCalendario = modal.find(`#${iconoId}`);

                    if (inputFecha.length > 0) {
                        // Abre el calendario al hacer clic en el input
                        inputFecha.on("focus", function() {
                            if (typeof this.showPicker === "function") {
                                this.showPicker();
                            }
                        });

                        // Abre el calendario al hacer clic en el icono
                        iconoCalendario.on("mousedown touchstart", function(event) {
                            event.preventDefault();
                            if (typeof inputFecha[0].showPicker === "function") {
                                inputFecha[0].showPicker();
                            }
                        });
                    }
                }

                // Configura ambos campos de fecha dentro del modal
                configurarCalendario("fecha_inicial", "calendar_addon_inicial");
                configurarCalendario("fecha_final", "calendar_addon_final");
            });

            // ============================================================
            // ============================================================
            // ============================================================

            $(document).on('click', '.btn-detalle-baja', function() {
                const idBaja = $(this).data('id');

                $.ajax({
                    url: `baja/${idBaja}`,
                    type: 'GET',
                    beforeSend: function() {
                        $('#modalDetalleBajaContent').html(
                            '<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Cargando...</div>'
                        );
                        $('#modalDetalleBaja').modal('show');
                    },
                    success: function(html) {
                        $('#modalDetalleBajaContent').html(html);

                        // INICIO DataTable Detalle Bajas
                        $("#tblDetalleBaja").DataTable({
                            dom: 'Blfrtip',
                            "infoEmpty": "No hay registros",
                            stripe: true,
                            bSort: false,
                            buttons: [
                                {
                                    extend: 'excelHtml5',
                                    text: 'Excel',
                                    className: 'btn btn-sm btn-success mr-3',
                                    customize: function(xlsx) {
                                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                                        $('row:first c', sheet).attr('s', '42');
                                    }
                                }
                            ],
                            "pageLength": 25,
                            "scrollX": true,
                        });
                        // CIERRE DataTable Detalle Bajas
                    },
                    error: function() {
                        $('#modalDetalleBajaContent').html(
                            '<div class="alert alert-danger">Error al cargar el formulario.</div>'
                        );
                    }
                });
            });


        }); // FIN document.ready
    </script>
@stop
