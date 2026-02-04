@extends('layouts.app')
@section('title', 'Usuarios')

@section('css')
    {{-- <link rel="stylesheet" href="{{ asset('css/custom.css') }}"> --}}
    <style>
        .btn-circle {
            padding-left: 0.3rem !important;
            padding-right: 0.3rem !important;
            padding-top: 0.0rem !important;
            padding-bottom: 0.0rem !important;
        }

        .modal-clave {
            top: auto !important;
            left: auto !important;
        }

        .jquery-modal {
            display: none;
        }
    </style>
@stop

@section('content')
    <div class="d-flex p-0">
        <div class="p-0 sidebar-container">
            @include('layouts.sidebarmenu')
        </div>

        <div class="p-3 d-flex flex-column content-container">
            <div class="d-flex justify-content-between pe-3 mt-3 mb-2">
                <div class="">
                    <a href="{{ route('usuarios.create') }}" class="btn text-white" style="background-color:#337AB7">Crear
                        Usuario</a>
                </div>

                <div class="text-end">
                    <a href="#" role="button" title="Ayuda" class="text-blue" data-bs-toggle="modal"
                        data-bs-target="#modalAyudaListarUsuarios">
                        <i class="fa fa-question-circle fa-2x" aria-hidden="false" title="Ayuda"
                            style="color: #337AB7"></i>
                    </a>
                </div>
            </div>

            <div class="modal fade" id="modalAyudaListarUsuarios" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" data-keyboard ="false" data-backdrop = "static">
                <div class="modal-dialog" style="min-width: 75%;">
                    <div class="modal-content p-3">
                        <div class="modal-body p-0 rounded-top" style="border: solid 1px #337AB7; mw-50">
                            <div class="row">
                                <div class="col-12">
                                    <div class="rounded-top text-white text-center p-2"
                                        style="background-color: #337AB7; border: solid 1px #337AB7;">
                                        <span class="modal-title fs-5"><strong>Ayuda de Listar Empleados</strong></span>
                                    </div>
                                    <div class="p-3">
                                        <p class="text-justify">Señor usuario en esta vista usted se va a encontrar con
                                            diferentes opciones ubicadas al lado izquierdo de la tabla, cada una con una
                                            acción diferente, esas opciones son:
                                        </p>

                                        <ul>
                                            <li><strong>Opcion de Modificación:</strong>
                                                <ol>Tener en cuenta a la hora de modificar un empleado lo siguiente:
                                                    <li class="text-justify">Todos los campos que poseen el asterisco (*)
                                                        son obligatorios, por lo tanto sino se diligencian,
                                                        el sistema no le dejará seguir.</li>
                                                    <li class="text-justify">Los campos nombre de usuario y email no pueden
                                                        ser idénticos a datos ya registrados.</li>
                                                    <li class="text-justify">Al cambiar un empleado temporal a vinculado, el
                                                        campo fecha de contrato cargará la fecha actual inicialmente, si
                                                        usted desea cambiar esa fecha, está no puede ser menor ni superior a
                                                        los 3 meses.</li>
                                                </ol>
                                                <br>
                                            </li>
                                            <li><strong>Opción de Cambio de Contraseña:</strong>
                                                <ol>Tener en cuenta a la hora de cambiar una contraseña lo siguente:
                                                    <li class="text-justify">La longitud de la contraseña debe ser mayor a 4
                                                        caracteres.</li>
                                                    <li class="text-justify">Ambos campos deben coincidir.</li>
                                                </ol>
                                            </li>
                                        </ul>
                                        <p class="text-justify">Por seguridad el empleado rol administrador no se le
                                            permitirá el cambio de estado</p>
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

            {{-- ======================================================================= --}}
            {{-- ======================================================================= --}}

            <div class="p-0" style="border: solid 1px #337AB7; border-radius: 5px;">
                <h5 class="border rounded-top text-white text-center pt-2 pb-2 m-0" style="background-color: #337AB7">Listar
                    Usuarios
                </h5>

                {{-- <div class="row pe-3 mt-3">
                    <div class="col-12 d-flex justify-content-end">
                        <a href="{{ route('usuarios.create') }}" class="btn text-white"
                            style="background-color:#337AB7">Crear Usuario</a>
                    </div>
                </div> --}}

                <div class="col-12 p-3" id="">
                    <div class="{{-- table-responsive --}}">
                        <table class="table table-striped table-bordered w-100 mb-0" id="tbl_usuarios"
                            aria-describedby="users-usuarios">
                            <thead>
                                <tr class="header-table text-center align-middle">
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Usuario</th>
                                    <th>Tipo Documento</th>
                                    <th>Identificación</th>
                                    <th>Correo</th>
                                    <th>Rol</th>
                                    <th>Empresa</th>
                                    <th>Tipo Persona</th>
                                    <th>Número Teléfono</th>
                                    <th>Celular</th>
                                    <th>Dirección</th>
                                    <th>Género</th>
                                    <th>Fecha Contrato</th>
                                    <th>Estado</th>
                                    <th>Terminación Contrato</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            {{-- ============================== --}}
                            <tbody>
                                @foreach ($usuarioIndex as $usuario)
                                    <tr class="text-center align-middle">
                                        <td>{{ $usuario->nombre_usuario }}</td>
                                        <td>{{ $usuario->apellido_usuario }}</td>
                                        <td>{{ $usuario->usuario }}</td>
                                        <td>{{ $usuario->tipo_documento }}</td>
                                        <td>{{ $usuario->identificacion }}</td>
                                        <td>{{ $usuario->email }}</td>
                                        <td>{{ $usuario->rol }}</td>
                                        <td>{{ $usuario->nombre_empresa }}</td>
                                        <td>{{ $usuario->tipo_persona }}</td>
                                        <td>{{ $usuario->numero_telefono }}</td>
                                        <td>{{ $usuario->celular }}</td>
                                        <td>{{ $usuario->direccion }}</td>
                                        <td>{{ $usuario->genero }}</td>
                                        <td>{{ $usuario->fecha_contrato }}</td>
                                        <td>
                                            @if($usuario->id_estado == 1)
                                                <span class="badge text-bg-success">{{ $usuario->estado }}</span>
                                            @else
                                                <span class="badge text-bg-danger">{{ $usuario->estado }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $usuario->fecha_terminacion_contrato }}</td>
                                        <td>
                                            <button type="button"
                                                class="btn btn-success rounded-circle btn-circle btn-editar-usuario"
                                                title="Editar Usuario" data-id="{{ $usuario->id_usuario }}">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </button>

                                            <button type="button"
                                                class="btn btn-warning rounded-circle btn-circle btn-cambiar-clave"
                                                title="Cambiar contraseña" data-id="{{ $usuario->id_usuario }}">
                                                <i class="fa fa-key"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- <div class="mt-5 mb-2 d-flex justify-content-center">
                        <button class="btn rounded-2 me-3 text-white" type="submit" style="background-color: #286090">
                            <i class="fa fa-file-pdf-o"></i>
                            Reporte PDF de Usuarios 1
                        </button>
                    </div> -->
                </div> {{-- FIN div_campos_usuarios --}}
            </div> {{-- FIN div_crear_usuario --}}
        </div>
    </div>

    {{-- INICIO Modal CAMBIAR CONTRASEÑA --}}
    <div class="modal fade" id="modalCambiarClave" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content p-3" id="modalCambiarClaveContent">
                {{-- El contenido AJAX se cargará aquí --}}
            </div>
        </div>
    </div>
    {{-- FINAL Modal CAMBIAR CONTRASEÑA --}}

    {{-- INICIO Modal EDITAR USUARIO --}}
    <div class="modal fade" id="modalEditarUsuario" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" style="min-width: 60%">
            <div class="modal-content p-3" id="modalEditarUsuarioContent">
                {{-- El contenido AJAX se cargará aquí --}}
            </div> {{-- modal-content --}}
        </div> {{-- modal-dialog --}}
    </div>
    {{-- FINAL Modal EDITAR USUARIO --}}
@stop

@section('scripts')
    <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('DataTables/Buttons-2.3.4/js/buttons.html5.min.js') }}"></script>

    <script>
        $(document).ready(function() {

            $('.select2').select2({
                // placeholder: "Seleccionar...",
                allowClear: false,
                width: '100%'
            });

            $('.select2').on('select2:open', function (e) {
                // Buscamos el input de búsqueda dentro del contenedor de Select2 y le damos foco
                document.querySelector('.select2-search__field').focus();
            });

            // INICIO DataTable Lista Usuarios
            $("#tbl_usuarios").DataTable({
                dom: 'Blfrtip',
                infoEmpty: "No hay registros",
                stripe: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
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
                pageLength: 10,
                scrollX: true
            });

            // CIERRE DataTable Lista Usuarios

            // ===========================================================================================

            function validatePassword(nuevaClaveValor) {
                let regex =
                    /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&+\-/_¿¡#.,:;=~^(){}\[\]<>`|"'])[A-Za-z\d@$!%*?&+\-/_¿¡#.,:;=~^(){}\[\]<>`|"']{6,}$/;
                if (!regex.test(nuevaClaveValor)) {
                    return "La contraseña debe tener al menos una letra mayúscula, una letra minúscula, un número, un carácter especial, y ser de al menos 6 caracteres.";
                }
                return null;
            }

            // formCambiarClave para cargar gif en el submit
            $(document).on("submit", "form[id^='formCambiarClave_']", function(e) {
                e.preventDefault(); // Evita el envío si hay errores

                const form = $(this);
                const formId = form.attr('id'); // Obtenemos el ID del formulario
                const id = formId.split('_')[1]; // Obtener el ID del formulario desde el ID del formulario

                // Identificar campos de nueva clave y confirmación
                const nuevaClave = `#nueva_clave_${id}`;
                const confirmarClave = `#confirmar_clave_${id}`;

                let nuevaClaveValor = $(nuevaClave).val();
                let confirmarClaveValor = $(confirmarClave).val();

                if (nuevaClaveValor.trim() === '' || confirmarClaveValor.trim() === '') {
                    Swal.fire('Cuidado!', 'Ambos campos de contraseña deben estar diligenciados!',
                        'warning');
                    return;
                }

                if (nuevaClaveValor !== confirmarClaveValor) {
                    Swal.fire('Error!', 'Las contraseñas no coinciden!', 'error');
                    return;
                }

                // Validación de la seguridad de la contraseña
                let errorMessage = validatePassword(nuevaClaveValor);

                if (errorMessage) {
                    Swal.fire('Error!', errorMessage, 'error');
                    return;
                }

                // Deshabilitar campos
                $(nuevaClave).prop("readonly", true);
                $(confirmarClave).prop("readonly", true);

                // Capturar el indicador de carga y botones dinámicamente
                const submitButton = $(`#btn_editar_clave_${id}`);
                const cancelButton = $(`#btn_cancelar_clave_${id}`);
                const loadingIndicator = $(`#loadingIndicatorEditClave_${id}`);

                // Lógica del botón
                loadingIndicator.show();
                cancelButton.prop("disabled", true);
                submitButton.prop("disabled", true).html(
                    "Procesando... <i class='fa fa-spinner fa-spin'></i>");

                // Enviar formulario manualmente
                this.submit();
            });

            // ===========================================================================================

            // Evita permitir que el enter active el submit
            $(document).on('keypress', 'form[id^="formEditarUsuario_"]', function (e) {
                if (e.key === 'Enter' && !$(e.target).is('button[type="submit"]')) {
                    e.preventDefault();
                    return false;
                }
            });

            // Botón de submit de editar usuario
            $(document).on("submit", "form[id^='formEditarUsuario_']", function(e) {

                const form = $(this);
                const formId = form.attr('id'); // Obtenemos el ID del formulario
                const id = formId.split('_')[1]; // Obtener el ID del formulario desde el ID del formulario

                // Capturar el indicador de carga dinámicamente
                const loadingIndicator = $(`#loadingIndicatorEditUser_${id}`);

                // Capturar el botón de submit dinámicamente
                const submitButton = $(`#btn_editar_user_${id}`);

                // Capturar el botón de cancelar
                const cancelButton = $(`#btn_cancelar_user_${id}`);

                // Lógica del botón
                submitButton.prop("disabled", true).html(
                    "Procesando... <i class='fa fa-spinner fa-spin'></i>"
                );

                // Lógica del botón cancelar
                cancelButton.prop("disabled", true);
                loadingIndicator.show();
            });

            // ===========================================================================================

            $(document).on('click', '.btn-editar-usuario', function() {
                const idUsuario = $(this).data('id');

                $.ajax({
                    url: `/usuarios/${idUsuario}/edit`,
                    type: 'GET',
                    data: {
                        tipo_modal: 'editar_usuario'
                    },
                    beforeSend: function() {
                        $('#modalEditarUsuario').modal('show');
                        $('#modalEditarUsuarioContent').html(
                            '<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Cargando...</div>'
                        );
                    },
                    success: function(html) {
                        $('#modalEditarUsuarioContent').html(html);

                        // Reinicializar select2 si lo usas en el modal
                        $('#modalEditarUsuario .select2').select2({
                            dropdownParent: $('#modalEditarUsuario'),
                            placeholder: 'Seleccionar...',
                            width: '100%',
                            allowClear: false
                        });

                        // Inicializar intlTelInput para el campo celular en el modal
                        initIntlPhone("#celular");

                        // Inicializar función de validación de número de teléfono
                        initPhoneValidation("#numero_telefono", "#telefono-error");



                        // Buscar el select dentro del modal
                        let modal = $('#modalEditarUsuario');
                        let selectEstado = modal.find('[id^=id_estado_]');

                        if (selectEstado.length > 0) {
                            let idEstado = selectEstado
                                .val(); // Obtener el valor actual del select

                            // Buscar los elementos dentro de este modal
                            let divFechaTerminacion = modal.find(
                                '[id^=div_fecha_terminacion_contrato]');
                            let inputFechaTerminacion = modal.find(
                                '[id^=fecha_terminacion_contrato]');

                            // Aplicar la lógica de ocultar o mostrar
                            if (idEstado == 1 || idEstado == '') {
                                divFechaTerminacion.hide();
                                inputFechaTerminacion.removeAttr('required');
                                inputFechaTerminacion.val('');
                            } else {
                                divFechaTerminacion.show();
                                inputFechaTerminacion.attr('required', 'required');
                            }

                            // Al cambiar el tipo de persona
                            selectEstado.change(function() {
                                let idEstado = selectEstado
                                    .val(); // Obtener el valor actual del select al cambiar

                                let modal = $(
                                    '#modalEditarUsuario'
                                ); // Asegurar que buscamos dentro del modal correcto

                                // Buscar los elementos dentro de este modal
                                let divFechaTerminacion = modal.find(
                                    '[id^=div_fecha_terminacion_contrato]');
                                let inputFechaTerminacion = modal.find(
                                    '[id^=fecha_terminacion_contrato]');

                                if (idEstado == 1) { // Activo
                                    divFechaTerminacion.hide();
                                    inputFechaTerminacion.removeAttr('required');
                                    inputFechaTerminacion.val('');
                                } else if (idEstado == 2) { // Inactivo
                                    divFechaTerminacion.show('slow');
                                    inputFechaTerminacion.attr('required', 'required');
                                } else { // Seleccionar...
                                    divFechaTerminacion.hide();
                                    inputFechaTerminacion.removeAttr('required');
                                }
                            }); // FIN Cambio de Estado
                        } // FIN selectEstado.length > 0
                    }, // FIN success
                    error: function() {
                        $('#modalEditarUsuarioContent').html(
                            '<div class="alert alert-danger">Error al cargar el formulario.</div>'
                        );
                    }
                }); // FIN $.ajax
            }); // FIN $(document).on('click', '.btn-editar-usuario

            // ===========================================================================================

            $(document).on('click', '.btn-cambiar-clave', function() {
                const idUsuario = $(this).data('id');

                $.ajax({
                    url: `/usuarios/${idUsuario}/edit`,
                    type: 'GET',
                    data: {
                        tipo_modal: 'cambiar_clave'
                    },
                    beforeSend: function() {
                        $('#modalCambiarClave').modal('show');
                        $('#modalCambiarClaveContent').html(
                            '<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Cargando...</div>'
                        );
                    },
                    success: function(html) {
                        $('#modalCambiarClaveContent').html(html);
                    }, // FIN success
                    error: function() {
                        $('#modalCambiarClaveContent').html(
                            '<div class="alert alert-danger">Error al cargar el formulario.</div>'
                        );
                    }
                }); // FIN $.ajax
            }); // FIN $(document).on('click', '.btn-cambiar_clave
        }); // FIN document.ready
    </script>
@stop
