@extends('layouts.app')
@section('title', 'Unidades de Medida')
@section('css')
    <style>
        .btn-circle {
            padding-left: 0.3rem !important;
            padding-right: 0.3rem !important;
            padding-top: 0.0rem !important;
            padding-bottom: 0.0rem !important;
        }
    </style>
@stop

@section('content')
    <div class="d-flex p-0">
        <div class="p-0 sidebar-container">
            @include('layouts.sidebarmenu')
        </div>

        <div class="p-3 d-flex flex-column content-container">
            <div class="d-flex justify-content-between pe-3 mt-2 mb-2">
                <div class="">
                    <button class="btn text-white" style="background-color:#337AB7" data-bs-toggle="modal" data-bs-target="#modalCrearUmd">
                        Crear Unidad de Medida
                    </button>
                </div>
            </div>

            @include('unidades_medida.modal_crear_umd')

            <div class="p-0" style="border: solid 1px #337AB7; border-radius: 5px;">
                <h5 class="border rounded-top text-white text-center pt-2 pb-2 m-0" style="background-color: #337AB7">
                    Listar Unidades de Medida
                </h5>

                <div class="col-12 p-3" id="">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered w-100 mb-0" id="tbl_umd" aria-describedby="umd">
                            <thead>
                                <tr class="header-table text-centerr align-middle">
                                    <th class="align-middle">Id</th>
                                    <th class="align-middle">Descripción</th>
                                    <th class="align-middle">Abreviatura</th>
                                    {{-- <th class="align-middle">Estado</th> --}}
                                    <th class="align-middle">Opciones</th>
                                </tr>
                            </thead>
                            {{-- ============================== --}}
                            <tbody>
                                @foreach ($unidadesMedida as $unidadMedida)
                                    <tr class="text-centerr align-middle">
                                        <td class="align-middle">{{ $unidadMedida->id }}</td>
                                        <td class="align-middle">{{ $unidadMedida->descripcion }}</td>
                                        <td class="align-middle">{{ $unidadMedida->abreviatura }}</td>
                                        {{-- <td class="align-middle">{{ $unidadMedida->estado }}</td> --}}

                                        <td class="align-middle">
                                            <button class="btn btn-success rounded-circle btn-circle btn-editar-umd"
                                                data-id="{{ $unidadMedida->id }}" title="Editar Umd"
                                            >
                                                <i class="fa fa-pencil-square-o"></i>
                                            </button>
                                        </td>

                                        {{-- @if ($unidadMedida->estado_id == 1 || $unidadMedida->estado_id == '1')
                                            <td class="align-middle">
                                                <button class="btn btn-success rounded-circle btn-circle btn-editar-umd"
                                                    data-id="{{ $unidadMedida->id }}" title="Editar Umd"
                                                >
                                                    <i class="fa fa-pencil-square-o"></i>
                                                </button>
                                                <button class="btn btn-danger rounded-circle btn-circle btn-cambiar-estado"
                                                    data-id="{{ $unidadMedida->id }}" title="Cambiar Estado Umd">
                                                    <i class="fa fa-solid fa-recycle"></i>
                                                </button>
                                            </td>
                                        @else
                                            <td class="align-middle">
                                                <button class="btn btn-danger rounded-circle btn-circle btn-cambiar-estado"
                                                    data-id="{{ $unidadMedida->id }}" title="Cambiar Estado">
                                                    <i class="fa fa-solid fa-recycle"></i>
                                                </button>
                                            </td>
                                        @endif --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> {{-- FIN div_ --}}
            </div> {{-- FIN div_ --}}
        </div>
    </div>

    {{-- INICIO Modal EDITAR UNIDAD DE MEDIDA --}}
    <div class="modal fade" id="modalEditarUmd" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content p-3" id="modalEditarUmdContent">
                {{-- El contenido AJAX se cargará aquí --}}
            </div> {{-- modal-content --}}
        </div> {{-- modal-dialog --}}
    </div> {{-- modal fade --}}
    {{-- FINAL Modal EDITAR UNIDAD DE MEDIDA --}}

    {{-- ==================================================================================================== --}}

    {{-- INICIO Modal ESTADO UNIDAD DE MEDIDA --}}
    <div class="modal fade" id="modalCambiarEstadoUmd" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content p-3" id="modalCambiarEstadoUmdContent">
                {{-- El contenido AJAX se cargará aquí --}}
            </div> {{-- FIN modal-content --}}
        </div> {{-- FIN modal-dialog --}}
    </div> {{-- FIN modal --}}
    {{-- FINAL Modal ESTADO UNIDAD DE MEDIDA --}}
@stop

{{-- ==================================================================================================== --}}
{{-- ==================================================================================================== --}}

@section('scripts')
    <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('DataTables/Buttons-2.3.4/js/buttons.html5.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // INICIO DataTable Lista Unidades de medida
            $("#tbl_umd").DataTable({
                dom: 'Blfrtip',
                "infoEmpty": "No hay registros",
                stripe: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                bSort: true,
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
                "pageLength": 10,
                "scrollX": true,
            });
            // CIERRE DataTable Lista Unidades de medida

            // ===========================================================

            // formCrearUmd para cargar gif en el submit
            $(document).on("submit", "form[id^='formCrearUmd']", function(e) {
                const form = $(this);
                const submitButton = form.find('button[type="submit"]');
                const cancelButton = form.find('button[type="button"]');
                const loadingIndicator = form.find("div[id^='loadingIndicatorUmdStore']");

                // Mostrar Spinner
                loadingIndicator.show();

                // Dessactivar Botones
                cancelButton.prop("disabled", true);
                submitButton.prop("disabled", true).html("Procesando... <i class='fa fa-spinner fa-spin'></i>");
            });

            // ===========================================================

            $(document).on('click', '.btn-editar-umd', function () {
                const idUmd = $(this).data('id');

                $.ajax({
                    url: `/unidades_medida/${idUmd}/edit`,
                    type: 'GET',
                    data: {
                        '_token': "{{ csrf_token() }}",
                        tipo_modal: 'editar_umd'
                    },
                    beforeSend: function () {
                        $('#modalEditarUmd').modal('show');
                        $('#modalEditarUmdContent').html('<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Cargando...</div>');
                    },
                    success: function (html) {
                        $('#modalEditarUmdContent').html(html);

                    },
                    error: function () {
                        $('#modalEditarUmdContent').html('<div class="alert alert-danger">Error al cargar el formulario.</div>');
                    }
                });
            });

            // ===========================================================
            // ===========================================================

            // formEditarProducto para cargar gif en el submit
            $(document).on("submit", "form[id^='formEditUmd_']", function(e) {
                const form = $(this);
                const formId = form.attr('id'); // Obtenemos el ID del formulario
                const id = formId.split('_')[1]; // Obtener el ID del formulario desde el ID del formulario

                // Capturar spinner y btns
                const loadingIndicator = $(`#loadingIndicatorEditUmd_${id}`);
                const submitButton = $(`#btn_editar_umd_${id}`);
                const cancelButton = $(`#btn_cancelar_umd_${id}`);

                // Desactivar btns
                submitButton.prop("disabled", true).html("Procesando... <i class='fa fa-spinner fa-spin'></i>");
                cancelButton.prop("disabled", true);
                loadingIndicator.show();
            });

            // ===========================================================
            // ===========================================================

            $(document).on('click', '.btn-cambiar-estado', function() {
                const idProducto = $(this).data('id');

                $.ajax({
                    url: `/unidades_medida/${id}/destroy`,
                    type: 'POST',
                    data: {
                        '_token': "{{ csrf_token() }}",
                        tipo_modal: 'estado_umd'
                    },
                    beforeSend: function() {
                        $('#modalCambiarEstadoUmd').modal('show');
                        $('#modalCambiarEstadoUmdContent').html(
                            '<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Cargando...</div>'
                        );
                    },
                    success: function(html) {
                        $('#modalCambiarEstadoUmdContent').html(html);
                    },
                    error: function() {
                        $('#modalCambiarEstadoUmdContent').html(
                            '<div class="alert alert-danger">Error al cargar el formulario.</div>'
                        );
                    }
                });
            });

            // ===========================================================
            // ===========================================================

            // Botón de submit de editar Umd
            $(document).on("submit", "form[id^='formCambiarEstadoUmd_']", function(e) {
                const form = $(this);
                const formId = form.attr('id'); // Obtenemos el ID del formulario
                const id = formId.split('_')[1]; // Obtener el ID del formulario desde el ID del formulario

                // Capturar spinner y btns dinámicamente
                const loadingIndicator = $(`#loadingIndicatorEstadoUmd_${id}`);
                const submitButton = $(`#btn_cambiar_estado_umd_${id}`);
                const cancelButton = $(`#btn_cancelar_estado_umd_${id}`);

                // Deshabilitar btns
                submitButton.prop("disabled", true).html("Procesando... <i class='fa fa-spinner fa-spin'></i>");
                cancelButton.prop("disabled", true);

                // Cargar spinner
                loadingIndicator.show();
            });
        }); //FIN Document.ready
    </script>
@stop
