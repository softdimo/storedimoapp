@extends('layouts.app')
@section('title', 'Proveedores')

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
                    <a href="{{ route('proveedores.create') }}" class="btn text-white" style="background-color:#337AB7">Crear
                        Proveedor</a>
                </div>

                <div class="text-end">
                    <a href="#" role="button" title="Ayuda" class="text-blue" data-bs-toggle="modal"
                        data-bs-target="#modalAyudaListarProveedores">
                        <i class="fa fa-question-circle fa-2x" aria-hidden="false" title="Ayuda"
                            style="color: #337AB7"></i>
                    </a>
                </div>
            </div>

            {{-- =============================================================== --}}
            {{-- =============================================================== --}}

            <div class="modal fade" id="modalAyudaListarProveedores" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" data-keyboard ="false" data-backdrop = "static">
                <div class="modal-dialog" style="min-width: 60%;">
                    <div class="modal-content p-3">
                        <div class="modal-body p-0 rounded-top" style="border: solid 1px #337AB7; mw-50">
                            <div class="row">
                                <div class="col-12">
                                    <div class="rounded-top text-white text-center p-2"
                                        style="background-color: #337AB7; border: solid 1px #337AB7;">
                                        <span class="modal-title"><strong>Ayuda de Listar Proveedores</strong></span>
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
                                                <ol>Tener en cuenta a la hora de modificar un proveedor lo siguiente:
                                                    <li class="text-justify">Todos los campos que poseen el asterisco (*)
                                                        son obligatorios, por lo tanto sino se diligencian, el sistema no le
                                                        dejará seguir.</li>
                                                    <li class="text-justify">Al cambiar un proveedor natural a proveedor
                                                        jurídico, se le solicitará los datos adicionales de la empresa,
                                                        todos obligatorios.</li>
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
                    Proveedores</h5>

                <div class="col-12 p-3" id="">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered w-100 mb-0" id="tbl_proveedores"
                            aria-describedby="proveedores">
                            <thead>
                                <tr class="header-table text-center">
                                    <th>Tipo Proveedor</th>
                                    <th>Empresa</th>
                                    <th>Nit empresa</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Identificación</th>
                                    <th>Celular</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            {{-- ============================== --}}
                            <tbody>
                                @foreach ($resProveedoresIndex as $proveedor)
                                    <tr class="text-center">
                                        <td>{{ $proveedor->tipo_persona }}</td>
                                        <td>{{ $proveedor->proveedor_juridico }}</td>
                                        <td>{{ $proveedor->nit_proveedor }}</td>
                                        <td>{{ $proveedor->nombres_proveedor }}</td>
                                        <td>{{ $proveedor->apellidos_proveedor }}</td>
                                        <td>{{ $proveedor->identificacion }}</td>
                                        <td>{{ $proveedor->celular_proveedor }}</td>
                                        <td>{{ $proveedor->estado }}</td>
                                        <td>
                                            <button type="button"
                                                class="btn btn-success rounded-circle btn-circle btn-editar-proveedor"
                                                title="Editar Proveedor" data-id="{{ $proveedor->id_proveedor }}">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> {{-- FIN div_campos_usuarios --}}
            </div> {{-- FIN div_crear_usuario --}}

        </div>
    </div>

    {{-- =============================================================== --}}
    {{-- =============================================================== --}}
    {{-- =============================================================== --}}

    {{-- INICIO Modal EDITAR PROVEEDOR --}}
    <div class="modal fade" id="modalEditarProveedor" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" style="max-width: 55%;">
            <div class="modal-content p-3" id="modalEditarProveedorContent">
                {{-- El contenido AJAX se cargará aquí --}}
            </div> {{-- modal-content --}}
        </div> {{-- modal-dialog --}}
    </div>
    {{-- FINAL Modal EDITAR PROVEEDOR  --}}
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('scripts')
    <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('DataTables/Buttons-2.3.4/js/buttons.html5.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // INICIO DataTable Lista Proveedores
            $("#tbl_proveedores").DataTable({
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

            // CIERRE DataTable Lista Proveedores

            // ===========================================================================================
            // ===========================================================================================

            // Botón de submit de editar Proveedor
            $(document).on("submit", "form[id^='formEditarProveedor_']", function(e) {
                const form = $(this);
                const formId = form.attr('id'); // Obtenemos el ID del formulario
                const id = formId.split('_')[1]; // Obtener el ID del formulario desde el ID del formulario

                // Capturar el spinner y btns dinámicamente
                const submitButton = $(`#btn_editar_proveedor_${id}`);
                const cancelButton = $(`#btn_cancelar_proveedor_${id}`);
                const loadingIndicator = $(`#loadingIndicatorEditProveedor_${id}`);

                // Deshabilitar botones
                cancelButton.prop("disabled", true);
                submitButton.prop("disabled", true).html(
                    "Procesando... <i class='fa fa-spinner fa-spin'></i>");

                // Cargar Spinner
                loadingIndicator.show();
            });

            // ===========================================================================================
            // ===========================================================================================

            $(document).on('click', '.btn-editar-proveedor', function() {
                const idProveedor = $(this).data('id');

                $.ajax({
                    url: `proveedor_edit/${idProveedor}`,
                    type: 'GET',
                    beforeSend: function() {
                        $('#modalEditarProveedor').modal('show');
                        $('#modalEditarProveedorContent').html(
                            '<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Cargando...</div>'
                        );
                    },
                    success: function(html) {
                        $('#modalEditarProveedorContent').html(html);

                        // Reinicializar select2 si lo usas en el modal
                        $('#modalEditarProveedor .select2').select2({
                            dropdownParent: $('#modalEditarProveedor'),
                            placeholder: 'Seleccionar...',
                            width: '100%',
                            allowClear: false
                        });

                        // Inicializar intlTelInput para el campo celular en el modal
                        initIntlPhone("#celular");

                        // Inicializar función de validación de número de teléfono
                        initPhoneValidation("#numero_telefono", "#telefono-error");
                        initPhoneValidation("#telefono_empresa", "#telefono-error-juridico");

                        

                        // Buscar el select dentro del modal
                        let modal = $('#modalEditarProveedor');
                        let selectTipoPersona = modal.find('[id^=id_tipo_persona_]');

                        if (selectTipoPersona.length > 0) { // Al cargar el modal
                            let idTipoPersona = selectTipoPersona
                                .val(); // Obtener el valor actual del select

                            // Buscar los elementos dentro de este modal
                            let divIdentificacion = modal.find('[id^=div_identificacion]');
                            let inputIdentificacion = modal.find('[id^=identificacion]');

                            let divNombresPersona = modal.find('[id^=div_nombres_persona]');
                            let inputNombresPersona = modal.find('[id^=nombres_persona]');

                            let divApellidosPersona = modal.find('[id^=div_apellidos_persona]');
                            let inputApellidosPersona = modal.find('[id^=apellidos_persona]');

                            let divNumeroTelefono = modal.find('[id^=div_numero_telefono]');
                            let inputNumeroTelefono = modal.find('[id^=numero_telefono]');

                            let divCelular = modal.find('[id^=div_celular]');
                            let inputCelular = modal.find('[id^=celular]');

                            let divEmail = modal.find('[id^=div_email]');
                            let inputEmail = modal.find('[id^=email]');

                            let divDireccion = modal.find('[id^=div_direccion]');
                            let inputDireccion = modal.find('[id^=direccion]');

                            let divIdGenero = modal.find('[id^=div_id_genero]');
                            let inputIdGenero = modal.find('[id^=id_genero]');

                            let divProveedorJuridico = modal.find(
                                '[id^=div_proveedor_juridico]');
                            let inputNitEmpresa = modal.find('[id^=nit_empresa]');
                            let inputNombreEmpresa = modal.find('[id^=nombre_empresa]');
                            let inputTelefonoEmpresa = modal.find('[id^=telefono_empresa]');

                            // Ocultar o mostrar al cargar el modal
                            if (idTipoPersona == 4) {
                                divIdentificacion.hide('slow');
                                inputIdentificacion.removeAttr('required');

                                divNombresPersona.hide('slow');
                                inputNombresPersona.removeAttr('required');

                                divApellidosPersona.hide('slow');
                                inputApellidosPersona.removeAttr('required');

                                divNumeroTelefono.hide('slow');
                                inputNumeroTelefono.removeAttr('required');

                                divCelular.removeClass('mt-4');

                                divIdGenero.hide('slow');
                                inputIdGenero.removeAttr('required');

                                divProveedorJuridico.show('slow');
                                inputNitEmpresa.attr('required', true);
                                inputNombreEmpresa.attr('required', true);
                                inputTelefonoEmpresa.attr('required', true);
                            } else {
                                divIdentificacion.show('slow');
                                inputIdentificacion.attr('required', true);

                                divNombresPersona.show('slow');
                                inputNombresPersona.attr('required', true);

                                divApellidosPersona.show('slow');
                                inputApellidosPersona.attr('required', true);

                                divNumeroTelefono.show('slow');
                                inputNumeroTelefono.removeAttr('required', true);

                                divCelular.addClass('mt-4');

                                divIdGenero.show('slow');
                                inputIdGenero.attr('required', true);

                                divProveedorJuridico.hide('slow');
                                inputNitEmpresa.removeAttr('required');
                                inputNombreEmpresa.removeAttr('required');
                                inputTelefonoEmpresa.removeAttr('required');
                            }

                            // ===================================================

                            // Al cambiar el tipo de persona
                            selectTipoPersona.change(function() {
                                let idTipoPersona = selectTipoPersona
                                    .val(); // Obtener el valor actual del select al cambiar

                                let modal = $(
                                    '#modalEditarProveedor'
                                ); // Asegurar que buscamos dentro del modal correcto
                                // let modal = $(this).closest('[id^="modalEditarProveedor_"]'); // Asegurar que buscamos dentro del modal correcto

                                let divIdentificacion = modal.find(
                                    '[id^=div_identificacion]');
                                let inputIdentificacion = modal.find(
                                    '[id^=identificacion]');

                                let divNombresPersona = modal.find(
                                    '[id^=div_nombres_persona]');
                                let inputNombresPersona = modal.find(
                                    '[id^=nombres_persona]');

                                let divApellidosPersona = modal.find(
                                    '[id^=div_apellidos_persona]');
                                let inputApellidosPersona = modal.find(
                                    '[id^=apellidos_persona]');

                                let divNumeroTelefono = modal.find(
                                    '[id^=div_numero_telefono]');
                                let inputNumeroTelefono = modal.find(
                                    '[id^=numero_telefono]');

                                let divCelular = modal.find('[id^=div_celular]');
                                let inputCelular = modal.find('[id^=celular]');

                                let divEmail = modal.find('[id^=div_email]');
                                let inputEmail = modal.find('[id^=email]');

                                let divDireccion = modal.find('[id^=div_direccion]');
                                let inputDireccion = modal.find('[id^=direccion]');

                                let divIdGenero = modal.find('[id^=div_id_genero]');
                                let inputIdGenero = modal.find('[id^=id_genero]');

                                let divProveedorJuridico = modal.find(
                                    '[id^=div_proveedor_juridico]');
                                let inputNitEmpresa = modal.find('[id^=nit_empresa]');
                                let inputNombreEmpresa = modal.find(
                                    '[id^=nombre_empresa]');
                                let inputTelefonoEmpresa = modal.find(
                                    '[id^=telefono_empresa]');

                                if (idTipoPersona == 4) { // Proveedor-juridico
                                    divIdentificacion.hide('slow');
                                    inputIdentificacion.removeAttr('required');

                                    divNombresPersona.hide('slow');
                                    inputNombresPersona.removeAttr('required');

                                    divApellidosPersona.hide('slow');
                                    inputApellidosPersona.removeAttr('required');

                                    divNumeroTelefono.hide('slow');
                                    inputNumeroTelefono.removeAttr('required');

                                    divCelular.show('slow');
                                    divCelular.removeClass('mt-4');
                                    inputCelular.attr('required', true);

                                    divEmail.show('slow');
                                    inputEmail.attr('required', true);

                                    divDireccion.show('slow');
                                    inputDireccion.attr('required', true);

                                    divIdGenero.hide('slow');
                                    inputIdGenero.removeAttr('required');

                                    divProveedorJuridico.show('slow');
                                    inputNitEmpresa.attr('required', true);
                                    inputNombreEmpresa.attr('required', true);
                                    inputTelefonoEmpresa.attr('required', true);
                                } else {
                                    divIdentificacion.show('slow');
                                    inputIdentificacion.attr('required', true);

                                    divNombresPersona.show('slow');
                                    inputNombresPersona.attr('required', true);

                                    divApellidosPersona.show('slow');
                                    inputApellidosPersona.attr('required', true);

                                    divNumeroTelefono.show('slow');
                                    inputNumeroTelefono.removeAttr('required', true);

                                    divCelular.show('slow');
                                    divCelular.addClass('mt-4');
                                    inputCelular.attr('required', true);

                                    divEmail.show('slow');
                                    inputEmail.attr('required', true);

                                    divDireccion.show('slow');
                                    inputDireccion.attr('required', true);

                                    divIdGenero.show('slow');
                                    inputIdGenero.attr('required', true);

                                    divProveedorJuridico.hide('slow');
                                    inputNitEmpresa.removeAttr('required');
                                    inputNombreEmpresa.removeAttr('required');
                                    inputTelefonoEmpresa.removeAttr('required');
                                }
                            }); // FIN Tipo Persona Jurídica
                        } // FIN selectTipoPersona.length > 0
                    }, // FIN success
                    error: function() {
                        $('#modalEditarProveedorContent').html(
                            '<div class="alert alert-danger">Error al cargar el formulario.</div>'
                        );
                    }
                }); // FIN $.ajax
            }); // FIN $(document).on('click', '.btn-editar-proveedor
        }); // FIN document.ready
    </script>
@stop
