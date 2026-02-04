@extends('layouts.app')
@section('title', 'Clientes')

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

            <div class="d-flex justify-content-between pe-3 mt-3 mb-2">
                <div class="">
                    <a href="{{ route('personas.create') }}" class="btn text-white" style="background-color:#337AB7">Crear
                        Clientes</a>
                </div>

                <div class="text-end">
                    <a href="#" role="button" title="Ayuda" class="text-blue" data-bs-toggle="modal"
                        data-bs-target="#modalAyudaListarClientes">
                        <i class="fa fa-question-circle fa-2x" aria-hidden="false" title="Ayuda"
                            style="color: #337AB7"></i>
                    </a>
                </div>
            </div>

            {{-- =============================================================== --}}
            {{-- =============================================================== --}}

            <div class="modal fade" id="modalAyudaListarClientes" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" data-keyboard ="false" data-backdrop = "static">
                <div class="modal-dialog">
                    <div class="modal-content p-3">
                        <div class="modal-body p-0 rounded-top" style="border: solid 1px #337AB7; mw-50">
                            <div class="row">
                                <div class="col-12">
                                    <div class="rounded-top text-white text-center p-2"
                                        style="background-color: #337AB7; border: solid 1px #337AB7;">
                                        <span class="modal-title"><strong>Ayuda de Listar Clientes</strong></span>
                                    </div>
                                    {{-- =========================== --}}
                                    <div class="p-3">
                                        <p class="text-justify">Señor usuario en esta vista usted se va a encontrar con
                                            diferentes opciones ubicadas al lado izquierdo de la tabla, cada una con una
                                            acción diferente, pero en esta ocasión solo se le orientará sobre el icono
                                            verde, que pertenece a la opción de modificación:
                                        </p>

                                        <ul>
                                            <li><strong>Opcion de Modificación:</strong>
                                                <ol>Tener en cuenta a la hora de modificar un Cliente lo siguiente:
                                                    <li class="text-justify">Todos los campos que poseen el asterisco (*)
                                                        son obligatorios, por lo tanto sino se diligencian, el sistema no le
                                                        dejará seguir.</li>
                                                </ol>
                                                <br>
                                            </li>
                                        </ul>
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
                    Clientes
                </h5>

                <div class="col-12 p-3" id="">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered w-100 mb-0" id="tbl_clientes"
                            aria-describedby="clientes">
                            <thead>
                                <tr class="header-table text-center align-middle">
                                    <th>Tipo Cliente</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Identificación</th>
                                    <th>Celular</th>
                                    {{-- <th>Estado</th> --}}
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            {{-- ============================== --}}
                            <tbody>
                                @foreach ($personaIndex as $persona)
                                    @if ($persona->id_tipo_persona == 5 || $persona->id_tipo_persona == 6)
                                        <tr class="text-center align-middle">
                                            <td>{{ $persona->tipo_persona }}</td>
                                            <td>{{ $persona->nombres_persona }}</td>
                                            <td>{{ $persona->apellidos_persona }}</td>
                                            <td>{{ $persona->identificacion }}</td>
                                            <td>{{ $persona->celular }}</td>
                                            {{-- <td>{{ $persona->estado }}</td> --}}
                                            <td>
                                                <button type="button"
                                                    class="btn btn-success rounded-circle btn-circle btn-editar-cliente"
                                                    title="Editar Cliente" data-id="{{ $persona->id_persona }}">
                                                    <i class="fa fa-pencil-square-o"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> {{-- FIN div --}}
            </div> {{-- FIN div --}}
        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- ========================================================= --}}

    {{-- INICIO Modal EDITAR CLIENTE --}}
    <div class="modal fade" id="modalEditarCliente" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" style="min-width: 60%">
            <div class="modal-content p-3" id="modalEditarClienteContent">
                {{-- El contenido AJAX se cargará aquí --}}
            </div> {{-- modal-content --}}
        </div> {{-- modal-dialog --}}
    </div>
    {{-- FINAL Modal EDITAR PROVEEDOR --}}
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('scripts')
    <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('DataTables/Buttons-2.3.4/js/buttons.html5.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // INICIO DataTable Lista Clientes
            $("#tbl_clientes").DataTable({
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
                "pageLength": 25,
                "scrollX": true,
            });
            // CIERRE DataTable Lista Clientes

            // ===========================================================================================

            $(document).on('select2:open', function(e) {
                const searchField = document.querySelector('.select2-search__field');
                if (searchField) {
                    setTimeout(function() {
                        searchField.focus();
                    }, 10); // Un pequeño delay ayuda a que el buscador se renderice
                }
            });

            // ===========================================================================================

            // Evita permitir que el enter active el submit
            $(document).on('keypress', 'form[id^="formEditarCliente_"]', function (e) {
                if (e.key === 'Enter' && !$(e.target).is('button[type="submit"]')) {
                    e.preventDefault();
                    return false;
                }
            });

            // ===========================================================================================

            $(document).on('click', '.btn-editar-cliente', function() {
                const idCliente = $(this).data('id');

                $.ajax({
                    url: `/personas/${idCliente}/edit`,
                    type: 'GET',
                    beforeSend: function() {
                        $('#modalEditarCliente').modal('show');
                        $('#modalEditarClienteContent').html(
                            '<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Cargando...</div>'
                        );
                    },
                    success: function(html) {
                        $('#modalEditarClienteContent').html(html);

                        // Inicializar intlTelInput para el campo celular en el modal
                        initIntlPhone("#celular");

                        // Inicializar función de validación de número de teléfono
                        initPhoneValidation("#numero_telefono", "#telefono-error");

                    }, // FIN success
                    error: function() {
                        $('#modalEditarClienteContent').html(
                            '<div class="alert alert-danger">Error al cargar el formulario.</div>'
                        );
                    }
                }); // FIN $.ajax
            }); // FIN $(document).on('click', '.btn-editar-cliente

            // ===========================================================================================

            // Botón de submit de editar Cliente
            $(document).on("submit", "form[id^='formEditarCliente_']", function(e) {
                const form = $(this);
                const formId = form.attr('id'); // Obtenemos el ID del formulario
                const id = formId.split('_')[1]; // Obtener el ID del formulario desde el ID del formulario

                // Capturar el spinner y btns dinámicamente
                const loadingIndicator = $(`#loadingIndicatorEditCliente_${id}`);
                const submitButton = $(`#btn_editar_cliente_${id}`);
                const cancelButton = $(`#btn_cancelar_cliente_${id}`);

                // Deshabilitar botones
                cancelButton.prop("disabled", true);
                submitButton.prop("disabled", true).html(
                    "Procesando... <i class='fa fa-spinner fa-spin'></i>");

                // Cargar Spinner
                loadingIndicator.show();
            });
        }); // FIN document.ready
    </script>
@stop
