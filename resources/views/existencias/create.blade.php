@extends('layouts.app')
@section('title', 'Registrar Bajas')

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('css')
    {{-- <link rel="stylesheet" href="{{ asset('css/custom.css') }}"> --}}
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

            <div class="d-flex justify-content-between pe-3 mt-3 mb-2">
                <div class="">
                    <a href="{{ route('bajas_index') }}" class="btn text-white"
                        style="background-color:#337AB7">Bajas</a>
                </div>
                <div class="">
                    <a href="#" role="button" title="Ayuda" class="text-blue" data-bs-toggle="modal"
                        data-bs-target="#modalAyudaRegistrarBajas">
                        <i class="fa fa-question-circle fa-2x" aria-hidden="false" title="Ayuda"
                            style="color: #337AB7"></i>
                    </a>
                </div>
            </div>

            <div class="modal fade" id="modalAyudaRegistrarBajas" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" data-keyboard ="false" data-backdrop = "static">
                <div class="modal-dialog" style="min-width: 60%;">
                    <div class="modal-content p-3">
                        <div class="modal-body p-0 rounded-top" style="border: solid 1px #337AB7; mw-50">
                            <div class="row">
                                <div class="col-12">
                                    <div class="rounded-top text-white text-center p-2"
                                        style="background-color: #337AB7; border: solid 1px #337AB7;">
                                        <span class="modal-title fs-4"><strong>Ayuda de Registrar Bajas</strong></span>
                                    </div>
                                    {{-- =========================== --}}
                                    <div class="p-3">
                                        <p class="text-justify">Tener en cuenta para el registro de la baja lo siguiente:
                                        </p>

                                        <ol>
                                            <li class="text-justify">Todos los campos que tienen el asterisco (*) son
                                                obligatorios, por lo tanto si no se diligencian el sistema no le dejará
                                                seguir.</li>
                                            <li class="text-justify">En el campo de producto, para una mayor agilidad se
                                                recomienda usar la pistola para leer el código del producto y así asociarlo
                                                mas fácil y rápido.</li>
                                            <li class="text-justify">En caso de que se haya equivocado en una cantidad o en
                                                un producto en el momento de agregar, con el icono de color rojo con forma
                                                de basurero, se puede quitar la selección inicial.</li>
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
                <h5 class="border rounded-top text-white text-center pt-2 pb-2 m-0" style="background-color: #337AB7">
                    Registrar Bajas</h5>

                {!! Form::open([
                    'method' => 'POST',
                    'route' => ['baja_store'],
                    'class' => '',
                    'autocomplete' => 'off',
                    'id' => 'formRegistrarBajas',
                ]) !!}
                @csrf

                <div class="d-flex flex-column flex-md-row justify-content-between p-3">
                    <div class="w-100-div w-48 mb-auto" style="border: solid 1px #337AB7; border-radius: 5px;">
                        <h5 class="border rounded-top text-white p-2" style="background-color: #337AB7">Información de la
                            Baja</h5>

                        <div class="p-3 d-flex flex-column" id="form_bajas" style="height: 50%;">
                            <div>
                                <label for="tipo_baja" class="form-label">Tipo de Baja <span
                                        class="text-danger">*</span></label>
                                {{ Form::select('tipo_baja', collect(['' => 'Seleccionar...'])->union($tipos_baja), null, ['class' => 'form-select select2', 'id' => 'tipo_baja']) }}
                            </div>

                            <div class="mt-3">
                                <label for="producto" class="form-label">Producto <span class="text-danger">*</span></label>
                                {{ Form::select('producto', collect(['' => 'Seleccionar...'])->union($productos), null, ['class' => 'form-select select2', 'id' => 'producto']) }}
                            </div>

                            <div class="mt-3">
                                <label for="categoria" class="form-label">Categoría <span class="text-danger">*</span></label>
                                {{ Form::text('categoria', null, ['class' => 'form-control bg-secondary-subtle', 'id' => 'categoria', 'readonly']) }}
                                {{ Form::hidden('id_categoria', null, ['class' => 'form-control', 'id' => 'id_categoria']) }}
                            </div>

                            <div class="mt-3">
                                <label for="cantidad" class="form-label">Cantidad <span class="text-danger">*</span></label>
                                {!! Form::text('cantidad', null, [
                                    'class' => 'form-control',
                                    'id' => 'cantidad',
                                    'required' => 'required',
                                    'pattern' => '^[0-9]+$',
                                    'title' => 'La cantidad debe ser un número entero positivo',
                                    'min' => '1',
                                    'onkeypress' => 'return event.charCode >= 48 && event.charCode <= 57',
                                    'placeholder' => 'Ej: 10',
                                ]) !!}
                            </div>

                            <div class="mt-3">
                                <label for="observaciones" class="form-label">Observaciones <span
                                        class="text-danger">*</span></label>
                                {!! Form::text('observaciones', null, [
                                    'class' => 'form-control',
                                    'id' => 'observaciones',
                                    'required' => 'required',
                                    'pattern' => '^[a-zA-Z0-9ÁÉÍÓÚáéíóúÑñ\s\-_.,;:()]{5,255}$',
                                    'title' =>
                                        'Las observaciones deben contener entre 10 y 255 caracteres. Puede incluir letras, números y caracteres especiales como -_.,;:()',
                                    'maxlength' => '255',
                                    'minlength' => '5',
                                    'placeholder' => 'Ej: Producto dañado',
                                ]) !!}
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                <button type="button" class="btn rounded-2 me-3 text-white"
                                    style="background-color: #337AB7" id="btn_add_baja">
                                    <i class="fa fa-plus plus"></i>
                                    Agregar
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="w-100-div w-48 mt-5 mt-md-0" style="border: solid 1px #337AB7; border-radius: 5px;">
                        <h5 class="border rounded-top text-white p-2 m-0" style="background-color: #337AB7">Verificación
                        </h5>

                        <div class="table-responsive p-3 d-flex flex-column justify-content-between h-100" style="">
                            <table class="table table-striped table-bordered w-100 mb-0" id="tbl_bajas"
                                aria-describedby="categorias">
                                <thead>
                                    <tr class="header-table text-center">
                                        <th>Tipo de Baja</th>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Categoria</th>
                                        <th>Opción</th>
                                    </tr>
                                </thead>
                                {{-- ============================== --}}
                                <tbody>
                                    <tr class="text-center"></tr>
                                </tbody>
                            </table>
                            {{-- ========================================== --}}
                            <div id="loadingIndicatorRegistrarBajas" class="loadingIndicator">
                                <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
                            </div>

                            <div class="d-flex justify-content-end mb-5" style="">
                                <button type="submit" class="btn btn-success rounded-2 me-3" id="guardarBajas">
                                    <i class="fa fa-floppy-o"></i>
                                    Dar de Baja
                                </button>
                            </div>
                        </div>
                    </div> {{-- FIN div_ --}}
                </div> {{-- FIN div principal info baja y verificación --}}
                {!! Form::close() !!}
            </div> {{-- FIN div_ --}}
        </div>
    </div>
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('scripts')
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

            // ===================================================================================
            // ===================================================================================

            // 1️⃣ Al cargar la página: desactivar el botón
            $('#guardarBajas').prop('disabled', true);

            // Función para verificar filas y habilitar/deshabilitar botón
            // Cuenta únicamente las filas reales que hemos creado dinámicamente:
            // las que tienen el atributo name="row_<indice>"
            function verificarFilasBajas() {
                let filasReales = $('#tbl_bajas tbody tr[name^="row_"]').length;
                if (filasReales > 0) {
                    $('#guardarBajas').prop('disabled', false);
                } else {
                    $('#guardarBajas').prop('disabled', true);
                }
            }

            // ===================================================================================
            // ===================================================================================

            $("#cantidad").blur(function() {
                let idProducto = $('#producto').val();
                let cantidad = $('#cantidad').val();

                $.ajax({
                    url: "{{ route('query_valores_producto') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'id_producto': idProducto
                    },
                    success: function(respuesta) {

                        if (respuesta.cantidad == null || respuesta.cantidad < cantidad) {
                            Swal.fire('Cuidado!',
                                'Este producto no tiene existencia disponible para dar de baja. Cantidad disponible en inventario: ' + (respuesta.cantidad ?? 0),
                                'warning')
                            $('#cantidad').val('');
                        }
                    }
                });
            });
            
            // ===================================================================================
            // ===================================================================================

            // Pasamos la lista completa de productos con categoría desde el backend
            let productosData = @json($productosData);

            $('#producto').on('change', function() {
                let id = $(this).val();
                let producto = productosData.find(p => p.id_producto == id);
                $('#categoria').val(producto ? producto.categoria : '');
                $('#id_categoria').val(producto ? producto.id_categoria : '');
            });

            // ===================================================================================
            // ===================================================================================

            

            // INICIO - Función para agregar fila x fila cada producto para dar de baja
            $("#btn_add_baja").click(function() {

                let idtipoBaja = $('#tipo_baja').val();
                let tipoBaja = $('#tipo_baja option:selected').text();
                let idProducto = $('#producto').val();
                let producto = $('#producto option:selected').text();
                let idCategoria = $('#id_categoria').val();
                let categoria = $('#categoria').val();
                let cantidad = $('#cantidad').val();
                let observaciones = $('#observaciones').val();

                if (tipoBaja == '' || producto == '' || cantidad == '' || observaciones == '') {
                    Swal.fire(
                        'Cuidado!',
                        'Todos los campos son obligatorios!',
                        'error'
                    );
                } else {
                    // var indiceSiguienteFila = $('#tbl_bajas tr').length;
                    var indiceSiguienteFila = $('#tbl_bajas tbody tr[name^="row_"]').length;

                    // Crear una fila para la tabla
                    let fila = `
                        <tr class="" name="row_${indiceSiguienteFila}">
                            <td class="text-center">${tipoBaja}</td>
                            <td class="text-center">${producto}</td>
                            <td class="text-center">${cantidad}</td>
                            <td class="text-center">${categoria}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger rounded-circle btn-delete-baja" data-id="${indiceSiguienteFila}" title="Eliminar" style="background-color:red;">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;

                    // $('#tbl_bajas').append(fila);
                    $('#tbl_bajas tbody').append(fila);

                    // Agregar inputs hidden dentro del formulario
                    let hiddenInputs = `
                        <div id="input_group_${indiceSiguienteFila}">
                            <input type="hidden" name="id_tipo_baja[]" value="${idtipoBaja}">
                            <input type="hidden" name="id_producto[]" value="${idProducto}">
                            <input type="hidden" name="cantidad_baja[]" value="${cantidad}">
                            <input type="hidden" name="id_categoria_baja[]" value="${idCategoria}">
                            <input type="hidden" name="observaciones_baja[]" value="${observaciones}">
                        </div>
                    `;

                    $("#formRegistrarBajas").append(hiddenInputs);

                    $('#tipo_baja').val('').trigger('change');
                    $('#producto').val('').trigger('change');
                    
                    $('#cantidad').val('');
                    $('#observaciones').val('');

                    // 2️⃣ Ejecutar la verificación después de agregar una baja
                    verificarFilasBajas();
                }
            });
            // FIN - Función para agregar fila x fila cada producto para dar de baja

            // ===================================================================================
            // ===================================================================================

            // Capturar cualquier intento de envío del formulario y evitarlo si no es manual
            $("#formRegistrarBajas").on("submit", function(event) {
                // Si el submit no fue activado por el botón "Guardar", lo prevenimos
                if (!event.originalEvent || event.originalEvent.submitter.id !== "guardarBajas") {
                    event.preventDefault();
                    return;
                }

            });

            $("#guardarBajas").click(function() {
                $("#formRegistrarBajas").off("submit").submit(); // Forzar el envío del formulario
            });

            // Delegación de eventos para eliminar fila y evitar submit
            $(document).on('click', '.btn-delete-baja', function(event) {
                event.preventDefault(); // Evita el submit
                event.stopPropagation(); // Detiene propagación

                let idBaja = $(this).data('id'); // Obtiene el ID de la fila
                $(`tr[name="row_${idBaja}"]`).remove(); // Elimina la fila de la tabla
                $(`#input_group_${idBaja}`).remove(); // Elimina los inputs hidden

                // 3️⃣ Ejecutar la verificación después de eliminar una baja
                verificarFilasBajas();
            });

            // ===================================================================================
            // ===================================================================================

            // formRegistrarBajas para cargar gif en el submit
            $(document).on("submit", "form[id^='formRegistrarBajas']", function(e) {
                const form = $(this);
                const submitButton = form.find('button[type="submit"]');
                const loadingIndicator = form.find("div[id^='loadingIndicatorRegistrarBajas']"); // Busca el GIF del form actual

                // Dessactivar Submit y Cancel
                submitButton.prop("disabled", true).html("Procesando... <i class='fa fa-spinner fa-spin'></i>");

                // Mostrar Spinner
                loadingIndicator.show();
            });

            // =========================================================================
            // =========================================================================
            // =========================================================================

        }); // FIN document.ready
    </script>
@stop
