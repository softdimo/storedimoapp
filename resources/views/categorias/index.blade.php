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
            <div class="text-end">
                <a href="#" role="button" title="Ayuda" class="text-blue" data-bs-toggle="modal"
                    data-bs-target="#modalAyudaCategorias">
                    <i class="fa fa-question-circle fa-2x" aria-hidden="false" title="Ayuda" style="color: #337AB7"></i>
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

            <div class="p-0" style="border: solid 1px #337AB7; border-radius: 5px;">
                <h5 class="border rounded-top text-white text-center pt-2 pb-2 m-0" style="background-color: #337AB7">
                    Gestionar Categorías</h5>

                <div class="d-flex justify-content-between p-3">
                    <div class="col-12 mb-auto" style="border: solid 1px #337AB7; border-radius: 5px; width:30%">
                        <h5 class="border rounded-top text-white p-2" style="background-color: #337AB7">Registrar Categoría
                        </h5>

                        {!! Form::open([
                            'method' => 'POST',
                            'route' => ['categorias.store'],
                            'class' => 'mt-2',
                            'autocomplete' => 'off',
                            'id' => 'formCrearCategoria',
                        ]) !!}
                        @csrf

                        <div class="p-3 d-flex flex-column" style="height: 50%;">
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

                            <div class="d-flex justify-content-center mt-3 ">
                                <button type="submit" class="btn btn-success rounded-2 me-3">
                                    <i class="fa fa-floppy-o"></i>
                                    Guardar
                                </button>

                                {{-- <button type="button" class="btn btn-danger rounded-2">
                                        <i class="fa fa-remove"></i>
                                        Cancelar
                                    </button> --}}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>

                    <div class="col-12" style="border: solid 1px #337AB7; border-radius: 5px;; width:68%">
                        <h5 class="border rounded-top text-white p-2 m-0" style="background-color: #337AB7">Listar
                            Categorías</h5>

                        <div class="table-responsive p-3">
                            <table class="table table-striped table-bordered w-100 mb-0" id="tbl_categorias"
                                aria-describedby="categorias">
                                <thead>
                                    <tr class="header-table text-center">
                                        <th>Código</th>
                                        <th>Nombre Categoría</th>
                                        <th>Estado</th>
                                        <th>Modificar</th>
                                    </tr>
                                </thead>
                                {{-- ============================== --}}
                                <tbody>
                                    @foreach ($categorias as $categoria)
                                        <tr class="text-center">
                                            <td>{{ $categoria->id_categoria }}</td>
                                            <td>{{ $categoria->categoria }}</td>
                                            <td>{{ $categoria->estado }}</td>

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
            </div> {{-- FIN div_ --}}
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
            </div> {{-- FIN modal-content --}}
        </div> {{-- FIN modal-dialog --}}
    </div> {{-- FIN modal --}}
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
            // CIERRE DataTable Lista Categorías

            // ======================================================
            // ======================================================

            // formCrearCategoria para cargar gif en el submit
            $(document).on("submit", "form[id^='formCrearCategoria']", function(e) {
                const form = $(this);
                const submitButton = form.find('button[type="submit"]');
                // const cancelButton = form.find('button[type="button"]');
                const loadingIndicator = form.find(
                    "div[id^='loadingIndicatorCrearCategoria']"); // Busca el GIF del form actual

                // Dessactivar Submit y Cancel
                submitButton.prop("disabled", true).html(
                    "Procesando... <i class='fa fa-spinner fa-spin'></i>");
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
                submitButton.prop("disabled", true).html(
                    "Procesando... <i class='fa fa-spinner fa-spin'></i>");
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
                submitButton.prop("disabled", true).html(
                    "Procesando... <i class='fa fa-spinner fa-spin'></i>");
                cancelButton.prop("disabled", true);

                // Cargar spinner
                loadingIndicator.show();
            });
        });
    </script>
@stop
