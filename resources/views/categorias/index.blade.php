@extends('layouts.app')
@section('title', 'Categorias')

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
            <div class="text-end mb-2">
                <a href="#" role="button" title="Ayuda" class="help-icon-modern" data-bs-toggle="modal"
                    data-bs-target="#modalAyudaCategorias">
                    <i class="fa fa-question-circle fa-2x" aria-hidden="false" title="Ayuda"></i>
                </a>
            </div>

            <div class="modal fade" id="modalAyudaCategorias" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                data-keyboard ="false" data-backdrop = "static">
                <div class="modal-dialog" style="min-width: 60%;">
                    <div class="modal-content p-3">
                        <div class="modal-body p-0 rounded-top" style="border: solid 1px #337AB7; mw-50">
                            <div class="row">
                                <div class="col-12">
                                    <div class="rounded-top text-white text-center p-2"
                                        style="background-color: #337AB7; border: solid 1px #337AB7;">
                                        <span class="modal-title"><strong>Ayuda de Gestionar Categorías</strong></span>
                                    </div>
                                    {{-- =========================== --}}
                                    <div class="p-3">
                                        <p class="text-justify">Señor usuario en esta vista usted se va a encontrar varios
                                            paneles, los cuales hacen diferentes acciones cada uno, esos paneles son:</p>

                                        <ul>
                                            <li><strong>Panel de Registro:</strong>
                                                <ol>Tener en cuenta a la hora de registrar una categoría lo siguiente.
                                                    <li class="text-justify">Todos los campos que poseen el asterisco (*)
                                                        son obligatorios, por lo tanto sino se diligencian, el sistema no le
                                                        dejará seguir.</li>
                                                    <li class="text-justify">No ingresar nombres ya existentes en la base de
                                                        datos.</li>
                                                </ol>
                                                <br>
                                            </li>
                                            <li><strong>Panel de Modificación:</strong>
                                                <ol>En este panel se listarán todas las categorías registradas.
                                                    <br>
                                                    Tener en cuenta para la modificación de una categoría lo siguiente:
                                                    <li class="text-justify">No ingresar nombres ya existentes en la base de
                                                        datos.</li>
                                                    <li class="text-justify">Los nombres ingresados deben contener por lo
                                                        menos 3 caracteres.</li>
                                                </ol>
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
                                    <i class="fa fa-check-circle"> Aceptar</i>
                                </button>
                            </div>
                        </div>
                    </div> {{-- FIN modal-content --}}
                </div> {{-- FIN modal-dialog --}}
            </div> {{-- FIN modalAyudaModificacionProductos --}}

            {{-- =============================================================== --}}
            {{-- =============================================================== --}}

            <div class="page-title-modern">
                <i class="fa fa-tags"></i>
                <span>Gestionar Categorías</span>
            </div>

            <div class="d-flex flex-column flex-lg-row gap-3 categorias-panels">
                <div class="card-modern" style="width: 100%; max-width: 340px;">
                    <div class="card-modern-header">
                        <i class="fa fa-plus-circle"></i>
                        <span>Registrar Categoría</span>
                    </div>

                    {!! Form::open([
                        'method' => 'POST',
                        'route' => ['categorias.store'],
                        'class' => 'mt-0',
                        'autocomplete' => 'off',
                        'id' => 'formCrearCategoria',
                    ]) !!}
                    @csrf

                    <div class="p-4 form-modern">
                        <div>
                            <label for="categoria">Nombre Categoría<span class="text-danger"> *</span></label>
                            {!! Form::text('categoria', null, [
                                'class' => 'form-control',
                                'id' => 'categoria',
                                'required' => 'required',
                                'minlength' => '3',
                                'maxlength' => '100',
                                'pattern' => "^[A-Za-zÁÉÍÓÚáéíóúÑñ\s'-]{3,100}$",
                                'title' => 'Debe contener solo letras, espacios, guiones o apóstrofes (mínimo 3 caracteres)',
                                'placeholder' => 'Ingrese nombre de categoría',
                            ]) !!}
                        </div>

                        {{-- ====================================================== --}}
                        {{-- ====================================================== --}}

                        <!-- Contenedor para el GIF -->
                        <div id="loadingIndicatorCrearCategoria" class="loadingIndicator">
                            <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
                        </div>

                        {{-- ====================================================== --}}
                        {{-- ====================================================== --}}

                        <div class="d-flex justify-content-center mt-3">
                            <button type="submit" class="btn-modern-success">
                                <i class="fa fa-floppy-o"></i>
                                Guardar
                            </button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>

                <div class="card-modern flex-grow-1">
                    <div class="card-modern-header">
                        <i class="fa fa-list"></i>
                        <span>Listar Categorías</span>
                    </div>

                    <div class="p-3">
                        <table class="table table-modern w-100 mb-0" id="tbl_categorias"
                            aria-describedby="categorias">
                            <thead>
                                <tr class="text-center align-middle">
                                    <th>Código</th>
                                    <th>Nombre Categoría</th>
                                    <th>Estado</th>
                                    <th>Modificar</th>
                                </tr>
                            </thead>
                            {{-- ============================== --}}
                            <tbody>
                                @foreach ($categorias as $categoria)
                                    <tr class="text-center align-middle">
                                        <td>{{ $categoria->id_categoria }}</td>
                                        <td>{{ $categoria->categoria }}</td>
                                        <td>
                                            @if(strtolower($categoria->estado ?? '') == 'activo')
                                                <span class="badge text-bg-success">{{ $categoria->estado }}</span>
                                            @elseif($categoria->estado)
                                                <span class="badge text-bg-danger">{{ $categoria->estado }}</span>
                                            @endif
                                        </td>

                                        @if ($categoria->id_estado == 1 || $categoria->id_estado == '1')
                                            <td>
                                                <button type="button" class="btn btn-success rounded-circle btn-circle btn-editar-categoria" title="Modificar" data-id="{{$categoria->id_categoria}}">
                                                    <i class="fa fa-pencil-square-o"></i>
                                                </button>

                                                {{-- ============================== --}}
                                                <button class="btn btn-danger rounded-circle btn-circle btn-cambiar-estado" title="Cambiar Estado" data-id="{{$categoria->id_categoria}}">
                                                    <i class="fa fa-solid fa-recycle"></i>
                                                </button>
                                            </td>
                                        @else
                                            <td>
                                                {{-- ============================== --}}
                                                <button class="btn btn-danger rounded-circle btn-circle btn-cambiar-estado" title="Cambiar Estado" data-id="{{$categoria->id_categoria}}">
                                                    <i class="fa fa-solid fa-recycle"></i>
                                                </button>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> {{-- FIN div_ --}}
            </div>
        </div>
    </div>

    {{-- =============================================================== --}}
    {{-- =============================================================== --}}
    {{-- =============================================================== --}}

    {{-- INICIO Modal EDITAR CATEGORÍA --}}
    <div class="modal fade" id="modalEditarCategoria" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content p-3" id="modalEditarCategoriaContent">
                {{-- El contenido AJAX se cargará aquí --}}
            </div>
        </div>
    </div>
    {{-- FINAL Modal EDITAR CATEGORÍA --}}

    {{-- =============================================================== --}}
    {{-- =============================================================== --}}

    {{-- INICIO Modal ESTADO CATEGORIA --}}
    <div class="modal fade" id="modalCambiarEstadoCategoria" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" >
        <div class="modal-dialog">
            <div class="modal-content p-3" id="modalCambiarEstadoCategoriaContent">
                {{-- El contenido AJAX se cargará aquí --}}
            </div> {{-- FIN modal-content --}}
        </div> {{-- FIN modal-dialog --}}
    </div> {{-- FIN modal --}}
    {{-- FINAL Modal ESTADO CATEGORÍA --}}
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('scripts')
    <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('DataTables/Buttons-2.3.4/js/buttons.html5.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // INICIO DataTable Lista Categorías
            $("#tbl_categorias").DataTable({
                dom: 'Blfrtip',
                "infoEmpty": "No hay registros",
                stripe: true,
                bSort: true,
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o"></i> Excel',
                        className: 'btn btn-modern-excel mr-3',
                        customize: function(xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            $('row:first c', sheet).attr('s', '42');
                        }
                    }
                ],
                "pageLength": 10,
                "scrollX": true,
            });
            // CIERRE DataTable Lista Categorías

            // ======================================================
            // ======================================================

            $(document).on('select2:open', function(e) {
                const searchField = document.querySelector('.select2-search__field');
                if (searchField) {
                    setTimeout(function() {
                        searchField.focus();
                    }, 10); // Un pequeño delay ayuda a que el buscador se renderice
                }
            });

            // ======================================================
            // ======================================================

            // formCrearCategoria para cargar gif en el submit
            $(document).on("submit", "form[id^='formCrearCategoria']", function(e) {
                const form = $(this);
                const submitButton = form.find('button[type="submit"]');
                // const cancelButton = form.find('button[type="button"]');
                const loadingIndicator = form.find("div[id^='loadingIndicatorCrearCategoria']"); // Busca el GIF del form actual

                // Dessactivar Submit y Cancel
                submitButton.prop("disabled", true).html("Procesando... <i class='fa fa-spinner fa-spin'></i>");
                // cancelButton.prop("disabled", true);

                // Mostrar Spinner
                loadingIndicator.show();

                // Readonly para el campo categoría
                const idCategoriaField = form.find("#categoria").prop("readonly", true);
            });

            // ======================================================
            // ======================================================

            $(document).on('click', '.btn-editar-categoria', function () {
                const idCategoria = $(this).data('id');

                $.ajax({
                    url: `categoria_edit/${idCategoria}`,
                    type: 'GET',
                    data: {
                        '_token': "{{ csrf_token() }}",
                        tipo_modal: 'editar'
                    },
                    beforeSend: function () {
                        $('#modalEditarCategoria').modal('show');
                        $('#modalEditarCategoriaContent').html('<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Cargando...</div>');
                    },
                    success: function (html) {
                        $('#modalEditarCategoriaContent').html(html);

                    },
                    error: function () {
                        $('#modalEditarCategoriaContent').html('<div class="alert alert-danger">Error al cargar el formulario.</div>');
                    }
                });
            });

            // ======================================================
            // ======================================================

            // formEditarCategoria para cargar gif en el submit
            $(document).on("submit", "form[id^='formEditarCategoria_']", function(e) {
                const form = $(this);
                const formId = form.attr('id'); // Obtenemos el ID del formulario
                const id = formId.split('_')[1]; // Obtener el ID del formulario desde el ID del formulario

                // Capturar spinner y btns
                const loadingIndicator = $(`#loadingIndicatorEditCategoria_${id}`);
                const submitButton = $(`#btn_editar_categoria_${id}`);
                const cancelButton = $(`#btn_editar_cancelar_${id}`);

                // Desactivar btns
                submitButton.prop("disabled", true).html("Procesando... <i class='fa fa-spinner fa-spin'></i>");
                cancelButton.prop("disabled", true);
                loadingIndicator.show();

                // Readonly para el campo nueva clave
                const idCategoria = $(`#id_categoria_${id}`).prop("readonly", true);
                const categoria = $(`#categoria_${id}`).prop("readonly", true);
            });

            // ======================================================
            // ======================================================

            $(document).on('click', '.btn-cambiar-estado', function () {
                const idCategoria = $(this).data('id');

                $.ajax({
                    url: `categoria_edit/${idCategoria}`,
                    type: 'GET',
                    data: {
                        '_token': "{{ csrf_token() }}",
                        tipo_modal: 'estado'
                    },
                    beforeSend: function () {
                        $('#modalCambiarEstadoCategoria').modal('show');
                        $('#modalCambiarEstadoCategoriaContent').html('<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Cargando...</div>');
                    },
                    success: function (html) {
                        $('#modalCambiarEstadoCategoriaContent').html(html);

                    },
                    error: function () {
                        $('#modalCambiarEstadoCategoriaContent').html('<div class="alert alert-danger">Error al cargar el formulario.</div>');
                    }
                });
            });

            // Botón de submit de cambiar estado de categoría
            $(document).on("submit", "form[id^='formCambiarEstadoCategoria_']", function(e) {
                const form = $(this);
                const formId = form.attr('id'); // Obtenemos el ID del formulario
                const id = formId.split('_')[1]; // Obtener el ID del formulario desde el ID del formulario

                // Capturar spinner y btns dinámicamente
                const loadingIndicator = $(`#loadingIndicatorEstadoCategoria_${id}`);
                const submitButton = $(`#btn_cambiar_estado_categoria_${id}`);
                const cancelButton = $(`#btn_cancelar_estado_categoria_${id}`);

                // Deshabilitar btns
                cancelButton.prop("disabled", true);
                submitButton.prop("disabled", true).html("Procesando... <i class='fa fa-spinner fa-spin'></i>");

                // Cargar spinner
                loadingIndicator.show();
            });
        });
    </script>
@stop