@extends('layouts.app')
@section('title', 'Registrar Préstamos Empleados')

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

        <div class="p-3 content-container">
            <div class="text-end">
                <a href="#" role="button" title="Ayuda" class="text-blue" data-bs-toggle="modal" data-bs-target="#modalAyudaRegistrarVentas">
                    <i class="fa fa-question-circle fa-2x" aria-hidden="false" title="Ayuda" style="color: #337AB7"></i>
                </a>
            </div>

            <div class="modal fade" id="modalAyudaRegistrarVentas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard ="false" data-backdrop = "static" style="max-width: 55%;">
                <div class="modal-dialog">
                    <div class="modal-content p-3">
                        <div class="modal-body p-0 rounded-top" style="border: solid 1px #337AB7; mw-50">
                            <div class="row">
                                <div class="col-12">
                                    <div class="rounded-top text-white text-center p-2" style="background-color: #337AB7; border: solid 1px #337AB7;">
                                        <span class="modal-title fs-4"><strong>Ayuda Préstamos</strong></span>
                                    </div>
                                    {{-- =========================== --}}
                                    <div class="p-3">
                                        <p class="text-justify">Tener en cuenta para el registro de los préstamos lo siguiente:</p>
    
                                        <ol>
                                            <li class="text-justify">El préstamo solo se le podrá registrar al empleado fijo.</li>
                                            <li class="text-justify">Los empleados que se encuentren inhabilitados no se les podrá registrar un préstamo.</li>
                                            <li class="text-justify">Los empleados que tengan préstamos en estado pendiente no se les podrá registrar otro préstamo.</li>
                                            <li class="text-justify">El valor del préstamo no puede ser mayor a $ 1,000.000 .</li>
                                        </ol>
                                    </div> {{--FINpanel-body --}}
                                </div> {{--FIN col-12 --}}
                            </div> {{--FIN modal-body .row --}}
                        </div> {{--FIN modal-body --}}
                        {{-- =========================== --}}
                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="button" class="btn btn-primary btn-md active pull-right" data-bs-dismiss="modal" style="background-color: #337AB7;">
                                    <i class="fa fa-check-circle" aria-hidden="true">&nbsp;Aceptar</i>
                                </button>
                            </div>
                        </div>
                    </div> {{--FIN modal-content --}}
                </div> {{--FIN modal-dialog --}}
            </div> {{--FIN modalAyudaModificacionProductos --}}

            {{-- =============================================================== --}}
            {{-- =============================================================== --}}

            <div class="p-0" style="border: solid 1px #337AB7; border-radius: 5px;">
                <h5 class="border rounded-top text-white text-center pt-2 pb-2 m-0" style="background-color: #337AB7">Registrar Préstamos</h5>
            
                <div class="col-12 p-3" id="">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered w-100 mb-0" id="tbl_registrar_prestamo" aria-describedby="registrar_prestamo">
                            <thead>
                                <tr class="header-table text-center">
                                    <th>Número Documento</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Tipo Empleado</th>
                                    <th>Estado</th>
                                    <th>Realizar Préstamo</th>
                                </tr>
                            </thead>
                            {{-- ============================== --}}
                            <tbody>
                                @foreach ($usuariosPrestamosCreate as $usuarioPrestamo)
                                    <tr class="text-center">
                                        <td>{{$usuarioPrestamo->identificacion}}</td>
                                        <td>{{$usuarioPrestamo->nombre_usuario}}</td>
                                        <td>{{$usuarioPrestamo->apellido_usuario}}</td>
                                        <td>{{$usuarioPrestamo->tipo_persona}}</td>
                                        <td>{{$usuarioPrestamo->estado}}</td>
                                        <td>
                                            <button class="btn rounded-circle btn-circle text-white" title="Registrar Préstamo" style="background-color: #286090" data-bs-toggle="modal" data-bs-target="#modalRegistrarPrestamo_{{$usuarioPrestamo->id_usuario}}">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                        </td>

                                        {{-- INICIO Modal Registrar Préstamo --}}
                                        <div class="modal fade" id="modalRegistrarPrestamo_{{$usuarioPrestamo->id_usuario}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
                                            <div class="modal-dialog">
                                                <div class="modal-content p-3">
                                                    <div class="modal-header justify-content-between border-0 pb-1">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    {{-- ====================================================== --}}
                                                    {{-- ====================================================== --}}

                                                    <div class="modal-body pt-0">
                                                        <div class="rounded-top" style="background-color: #337AB7; border: solid 1px #337AB7;">
                                                            <h6 class="text-white p-2 m-0 text-center">Registrar Préstamo</h6>
                                                        </div>

                                                        {{-- =================================== --}}

                                                        {!! Form::open([
                                                            'method' => 'POST',
                                                            'route' => ['prestamos.store'],
                                                            'class' => 'mt-0',
                                                            'autocomplete' => 'off',
                                                            'id' => 'formRegistrarPrestamo_'.$usuarioPrestamo->id_usuario,
                                                            ]) !!}
                                                            @csrf

                                                            {!! Form::hidden('id_usuario', isset($usuarioPrestamo) ? $usuarioPrestamo->id_usuario : null, ['class' => 'form-control', 'id' => 'id_usuario', 'required']) !!}

                                                            <div class="p-3" style="border: solid 1px #337AB7;" id="precios">
                                                                <div class="row">
                                                                    <div class="col-12 col-md-6">
                                                                        <label for="identificacion" class="fw-bold" style="font-size: 12px">Identificación <span class="text-danger">*</span></label>
                                                                        {!! Form::text('identificacion', isset($usuarioPrestamo) ? $usuarioPrestamo->identificacion : null, ['class' => 'form-control bg-secondary-subtle', 'id' => 'identificacion', 'required', 'readonly' => 'readonly']) !!}
                                                                    </div>

                                                                    <div class="col-12 col-md-6">
                                                                        <label for="id_tipo_persona" class="fw-bold" style="font-size: 12px">Tipo Empleado <span class="text-danger">*</span></label>
                                                                        {!! Form::text('id_tipo_persona', isset($usuarioPrestamo) ? $usuarioPrestamo->tipo_persona : null, ['class' => 'form-control bg-secondary-subtle', 'id' => 'id_tipo_persona', 'required', 'readonly' => 'readonly']) !!}
                                                                    </div>

                                                                    <div class="col-12 col-md-6 mt-3">
                                                                        <label for="fecha_prestamo" class="fw-bold" style="font-size: 12px">Fecha Préstamo <span class="text-danger">*</span></label>
                                                                        {!! Form::date('fecha_prestamo', null, ['class' => 'form-control', 'id' => 'fecha_prestamo', 'required', 'onkeydown' => 'return false',]) !!}
                                                                    </div>

                                                                    <div class="col-12 col-md-6 mt-3">
                                                                        <label for="fecha_limite" class="fw-bold" style="font-size: 12px">Fecha Límite <span class="text-danger">*</span></label>
                                                                        {!! Form::date('fecha_limite', null, ['class' => 'form-control', 'id' => 'fecha_limite', 'required', 'onkeydown' => 'return false',]) !!}
                                                                    </div>

                                                                    <div class="col-12 col-md-6 mt-3">
                                                                        <label for="valor_prestamo" class="fw-bold" style="font-size: 12px">Valor Préstamo <span class="text-danger">*</span></label>
                                                                        {!! Form::text('valor_prestamo', null, ['class' => 'form-control', 'id' => 'valor_prestamo', 'required']) !!}
                                                                    </div>

                                                                    <div class="col-12 col-md-6 mt-3">
                                                                        <label for="descripcion" class="fw-bold" style="font-size: 12px">Descripción <span class="text-danger">*</span></label>
                                                                        {!! Form::textarea('descripcion', null, ['class' => 'form-control', 'id' => 'descripcion', 'required','rows'=>'2']) !!}
                                                                    </div>
                                                                </div>
                                                            </div> {{-- FIN campos precios --}}
                                                        </div> {{-- FIN modal-body --}}

                                                        {{-- ====================================================== --}}
                                                        {{-- ====================================================== --}}

                                                        <!-- Contenedor para el GIF -->
                                                        <div id="loadingIndicatorRegistrarPrestamo_{{$usuarioPrestamo->id_usuario}}" class="loadingIndicator">
                                                            <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
                                                        </div>

                                                        {{-- ====================================================== --}}
                                                        {{-- ====================================================== --}}

                                                        <div class="modal-footer border-0 justify-content-center">
                                                            <div class="">
                                                                <button type="submit" class="btn btn-success" id="btn_registar_prestamo_{{$usuarioPrestamo->id_usuario}}">
                                                                    <i class="fa fa-floppy-o" aria-hidden="true"> Registrar</i>
                                                                </button>
                                                            </div>

                                                            <div class="">
                                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="btn_cancelar_prestamo_{{$usuarioPrestamo->id_usuario}}">
                                                                    <i class="fa fa-remove" aria-hidden="true">  Cancelar</i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    {!! Form::close() !!}
                                                </div> {{-- FIN modal-content --}}
                                            </div> {{-- FIN modal-dialog --}}
                                        </div> {{-- FINAL MODAL Registrar Préstamo --}}
                                    </tr>
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
            // INICIO DataTable Usuarios Préstamo
            $("#tbl_registrar_prestamo").DataTable({
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
            }); // CIERRE DataTable Usuarios Préstamo

            // =========================================================

            // formCambiarClave para cargar gif en el submit
            $(document).on("submit", "form[id^='formRegistrarPrestamo_']", function(e) {
                const form = $(this);
                const formId = form.attr('id'); // Obtenemos el ID del formulario
                const id = formId.split('_')[1]; // Obtener el ID del formulario desde el ID del formulario

                // Capturar Spinner y btns dinámicamente
                const loadingIndicator = $(`#loadingIndicatorRegistrarPrestamo_${id}`);
                const submitButton = $(`#btn_registar_prestamo_${id}`);
                const cancelButton = $(`#btn_cancelar_prestamo_${id}`);

                // Desactivar btns
                submitButton.prop("disabled", true).html("Procesando... <i class='fa fa-spinner fa-spin'></i>");
                cancelButton.prop("disabled", true);

                // Cargar Spinner
                loadingIndicator.show();
            });
        }); // FIN document.ready
    </script>
@stop


