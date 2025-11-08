@extends('layouts.app')
@section('title', 'Registrar Entradas')

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
                    <a href="{{ route('entradas.index') }}" class="btn text-white" style="background-color:#337AB7">Compras</a>
                </div>

                <div class="text-end">
                    <a href="#" role="button" title="Ayuda" class="text-blue" data-bs-toggle="modal"
                        data-bs-target="#modalAyudaRegistrarEntradas">
                        <i class="fa fa-question-circle fa-2x" aria-hidden="false" title="Ayuda"
                            style="color: #337AB7"></i>
                    </a>
                </div>
            </div>

            <div class="modal fade" id="modalAyudaRegistrarEntradas" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" data-keyboard ="false" data-backdrop = "static">
                <div class="modal-dialog" style="min-width: 60%;">
                    <div class="modal-content p-3">
                        <div class="modal-body p-0 rounded-top" style="border: solid 1px #337AB7; mw-50">
                            <div class="row">
                                <div class="col-12">
                                    <div class="rounded-top text-white text-center p-2"
                                        style="background-color: #337AB7; border: solid 1px #337AB7;">
                                        <span class="modal-title fs-4"><strong>Ayuda de Compras</strong></span>
                                    </div>
                                    {{-- =========================== --}}
                                    <div class="p-3">
                                        <p class="text-justify">Señor usuario para una mayor agilidad en el registro tener
                                            en cuenta lo siguiente:</p>

                                        <ol>
                                            <li class="text-justify">En el campo de producto se recomienda el uso de la
                                                pistola lectora de código de barras, para leer el código del producto para
                                                una asociación más ágil y rápida.</li>
                                            <li class="text-justify">Los campos marcados con asterisco (*) son obligatorios,
                                                por lo tanto sino se diligencian, el sistema no dejará seguir.</li>
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
                    Registrar Compras</h5>

                {!! Form::open([
                    'method' => 'POST',
                    'route' => ['entradas.store'],
                    'class' => '',
                    'autocomplete' => 'off',
                    'id' => 'formRegistrarCompra',
                ]) !!}
                @csrf

                <div class="d-flex flex-column flex-md-row justify-content-between p-3">
                    <div class="w-100-div w-48 mb-auto" style="border: solid 1px #337AB7; border-radius: 5px;">
                        <h5 class="border rounded-top text-white p-2" style="background-color: #337AB7">Proveedor <span
                                class="text-danger">*</span></h5>
                        {{-- ============================================================== --}}
                        {{ Form::select('id_tipo_proveedor', collect(['' => 'Seleccionar...'])->union($proveedores_compras), null, ['class' => 'form-select select2 select2-spaced', 'id' => 'id_tipo_proveedor', 'style' => 'width:90%; margin:auto']) }}

                        {{-- ============================================================== --}}

                        <h5 class="border rounded-top text-white p-2 mt-3" style="background-color: #337AB7">Producto 
                            <span class="text-danger">*</span>
                        </h5>
                        {{-- ============================================================== --}}
                        <div class="pt-3 pe-2 pb-3 ps-3 d-flex justify-content-between" id="" style="">
                            <div class="d-flex justify-content-center w-100">
                                {{ Form::select('id_producto', collect(['' => 'Seleccionar...'])->union($productos_compras), null, ['class' => 'form-select select2', 'id' => 'id_producto']) }}
                            </div>

                            {{-- <div class="d-flex justify-content-center w-25">
                                <button type="button" class="btn rounded-2 text-white" style="background-color: #337AB7"
                                    title="Registrar producto" data-bs-toggle="modal"
                                    data-bs-target="#modal_registroProducto">
                                    <i class="fa fa-plus plus"></i>
                                </button>
                            </div> --}}
                        </div>
                        {{-- ============================================================== --}}
                        <div class="row p-3">
                            <div class="col-md-4 text-center">
                                <strong for="form-control fw-bold">Precio Unitario</strong>
                                <p id="precio">$ <span class="" id="p_unitario"></span></p>
                            </div>
                            {{-- ============ --}}
                            <div class="col-md-4 text-center">
                                <strong for="form-control fw-bold">Precio al Detal</strong>
                                <p id="precio2">$ <span class="" id="p_detal"></span></p>
                            </div>
                            {{-- ============ --}}
                            <div class="col-md-4 text-center">
                                <strong for="form-control fw-bold">Precio por Mayor</strong>
                                <p id="precio3">$ <span class="" id="p_x_mayor"></span></p>
                            </div>
                            {{-- ============ --}}
                            {{-- <div class="col-md-3 text-center">
                                <button type="button" title="Modificar Precios Producto" data-bs-toggle="modal"
                                    data-bs-target="#modalModificarPrecios" class="btn btn-success btn-circle">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"
                                        title="Modificar Precios Producto"></i>
                                </button>
                            </div> --}}
                        </div>
                        {{-- ============ --}}
                        <div class="form-group p-3" id="cant">
                            <label for="">Cantidad <span class="text-danger">*</span></label>

                            {!! Form::number('cantidad', null, [
                                'class' => 'form-control',
                                'id' => 'cantidad',
                                'min' => '1',
                                'maxlength' => '4',
                            ]) !!}
                        </div>
                        {{-- ============ --}}
                        <!-- Contenedor para el GIF -->
                        <div id="loadingIndicatorAgregarCompra" class="loadingIndicator" style="display: none;">
                            <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
                        </div>
                        {{-- ============ --}}
                        <div class="p-3 d-flex justify-content-end">
                            <button type="button" class="btn btn-primary" id="btn_add_entrada" title="Agregar Entrada">
                                <i class="fa fa-plus plus"></i> Agregar
                            </button>
                        </div>
                    </div>
                    {{-- ============================================================== --}}
                    <div class="w-100-div w-48 mt-5 mt-md-0" style="border: solid 1px #337AB7; border-radius: 5px;">
                        <h5 class="border rounded-top text-white p-2 m-0" style="background-color: #337AB7">Detalle
                            Compras: <span id="proveedorCompra"></span></h5>

                        <div class="">
                            <div class="table-responsive p-3 d-flex flex-column justify-content-between h-100"
                                style="">
                                <table class="table table-striped table-bordered w-100 mb-0" id="tbl_compras"
                                    aria-describedby="compras">
                                    <thead>
                                        <tr class="header-table text-center">
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Subtotal <br> <small style="font-size:10px" class="mt-0">P Unitario x Cantidad</small></th>
                                            <th>Opción</th>
                                        </tr>
                                    </thead>
                                    {{-- ============================== --}}
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                            {{-- ============ --}}

                            <div class="mt-3 p-3 d-flex" style="background-color: #F5F5F5">
                                <h3 class="col-3 text-center align-content-center">Total: $</h3>
                                {!! Form::text('valor_compra', null, ['class' => 'form-control w-100 fs-4', 'id' => 'valor_compra', 'required', 'readonly']) !!}
                            </div>

                            {{-- ============ --}}

                            <!-- Contenedor para el GIF -->
                            <div id="loadingIndicatorCrearEntrada" class="loadingIndicator">
                                <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
                            </div>

                            {{-- ============ --}}

                            <div class="d-flex justify-content-end mb-5 p-3" style="">
                                <button type="submit" class="btn btn-success rounded-2 me-3" id="btn_registar_compra">
                                    <i class="fa fa-floppy-o"></i>
                                    Comprar
                                </button>
                            </div>
                        </div>
                    </div> {{-- FIN div_detalle-entradas --}}
                </div>
                {!! Form::close() !!}
            </div> {{-- FIN div_crear_compra --}}
        </div>
    </div>

    {{-- ==================================================================================== --}}
    {{-- ==================================================================================== --}}
    {{-- ==================================================================================== --}}
    {{-- ==================================================================================== --}}
    {{-- ==================================================================================== --}}

    {{-- INICIO MODAL REGISTRAR PRODUCTO --}}
    <div class="modal fade" id="modal_registroProducto" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog">
            <div class="modal-content p-3">
                <div class="modal-header justify-content-between border-0 pb-1">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#mod_ayuda_registroProducto" title="Ayuda Registrar producto">
                        <i class="fa fa-question" aria-hidden="true" title="Ayuda"></i>
                    </button>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- ====================================================== --}}
                {{-- ====================================================== --}}

                {!! Form::open([
                    'method' => 'POST',
                    'route' => ['productos.store'],
                    'class' => 'mt-2',
                    'autocomplete' => 'off',
                    'id' => 'formCrearProductoEntrada',
                    'name' => 'crearProductoEntrada',
                ]) !!}
                @csrf

                <div class="modal-body pt-0">
                    <div class="rounded-top" style="background-color: #337AB7; border: solid 1px #337AB7;">
                        <h6 class="text-white p-2 m-0 text-center">Registrar Producto (Obligatorios *)</h6>
                    </div>

                    {{-- =================================== --}}

                    <div class="p-3" style="border: solid 1px #337AB7;" id="campos_producto">
                        <div class="row">
                            {!! Form::hidden('form_entradas', 'crearProductoEntrada') !!}

                            <div class="col-12 col-md-4">
                                <label for="nombre_producto" class="fw-bold" style="font-size: 12px">Nombre Producto
                                    <span class="text-danger">*</span></label>
                                {!! Form::text('nombre_producto', null, [
                                    'class' => 'form-control',
                                    'id' => 'nombre_producto',
                                    'required' => 'required',
                                    'pattern' => '^[A-Za-záéíóúÁÉÍÓÚñÑ0-9\s]{3,100}$',
                                    'title' =>
                                        'El nombre debe tener entre 3 y 100 caracteres, solo letras, números y espacios. No se permiten caracteres especiales.',
                                    'maxlength' => '100',
                                    'minlength' => '3',
                                    'oninput' => "this.value = this.value.replace(/[^A-Za-záéíóúÁÉÍÓÚñÑ0-9\s]/g, '')",
                                ]) !!}
                            </div>

                            <div class="col-12 col-md-4">
                                <label for="categoria" class="fw-bold" style="font-size: 12px">Categoría <span
                                        class="text-danger">*</span></label>
                                {!! Form::select('id_categoria', collect(['' => 'Seleccionar...'])->union($categorias), null, [
                                    'class' => 'form-select select2',
                                    'id' => 'id_categoria',
                                    'required' => 'required',
                                ]) !!}
                            </div>

                            <div class="col-12 col-md-4">
                                <label for="precio_unitario" class="fw-bold" style="font-size: 12px">Precio Unitario
                                    <span class="text-danger">*</span></label>
                                {!! Form::text('precio_unitario', null, [
                                    'class' => 'form-control',
                                    'id' => 'precio_unitario',
                                    'required' => 'required',
                                    'pattern' => '^[0-9]+$',
                                    'title' => 'Ingrese un número entero mayor a 0',
                                    'oninput' => "this.value = this.value.replace(/[^0-9]/g, '')",
                                ]) !!}
                            </div>

                            <div class="col-12 col-md-4 mt-3">
                                <label for="precio_detal" class="fw-bold" style="font-size: 12px">Precio Detal <span
                                        class="text-danger">*</span></label>
                                {!! Form::text('precio_detal', null, [
                                    'class' => 'form-control',
                                    'id' => 'precio_detal',
                                    'required' => 'required',
                                    'pattern' => '^[0-9]+$',
                                    'title' => 'Ingrese un número entero mayor a 0',
                                    'oninput' => "this.value = this.value.replace(/[^0-9]/g, '')",
                                ]) !!}
                            </div>

                            <div class="col-12 col-md-4 mt-3">
                                <label for="precio_por_mayor" class="fw-bold" style="font-size: 12px">Precio Por
                                    Mayor<span class="text-danger">*</span></label>
                                {!! Form::text('precio_por_mayor', null, [
                                    'class' => 'form-control',
                                    'id' => 'precio_por_mayor',
                                    'required' => 'required',
                                    'pattern' => '^[0-9]+$',
                                    'title' => 'Ingrese un número entero mayor a 0',
                                    'oninput' => "this.value = this.value.replace(/[^0-9]/g, '')",
                                ]) !!}
                            </div>

                            <div class="col-12 col-md-4 mt-3">
                                <label for="stock_minimo" class="fw-bold" style="font-size: 12px">Stock Mínimo <span
                                        class="text-danger">*</span></label>
                                {!! Form::number('stock_minimo', null, [
                                    'class' => 'form-control',
                                    'id' => 'stock_minimo',
                                    'required' => 'required',
                                    'min' => '0',
                                    'step' => '1',
                                    'oninput' => 'this.value = Math.round(this.value)',
                                    'title' => 'Ingrese un número entero igual o mayor a 0',
                                ]) !!}
                            </div>
                        </div> {{-- FIN row nombre producto, categoría, precio unitario, precio detal, precio x mayor, stock mínimo --}}
                    </div> {{-- FIN campos_producto --}}
                </div> {{-- FIN modal-body --}}

                {{-- ====================================================== --}}
                {{-- ====================================================== --}}

                <!-- Contenedor para el GIF -->
                <div id="loadingIndicatorCrearProducto" class="loadingIndicator">
                    <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
                </div>

                {{-- ====================================================== --}}
                {{-- ====================================================== --}}

                <div class="modal-footer border-0 d-flex justify-content-center">
                    <button type="submit" class="btn btn-success me-3" name="crearProductoEntrada"><i
                            class="fa fa-floppy-o"> Guardar</i></button>

                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa fa-remove">
                            Cancelar</i></button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    {{-- FINAL MODAL REGISTRAR PRODUCTO --}}

    {{-- ==================================================================================== --}}
    {{-- ==================================================================================== --}}
    {{-- ==================================================================================== --}}

    {{-- INICIO Modal Ayuda de Registrar Productos --}}
    <div class="modal fade" id="mod_ayuda_registroProducto" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog">
            <div class="modal-content p-3">
                <div class="modal-header d-none"></div>

                {{-- ====================================================== --}}
                {{-- ====================================================== --}}

                <div class="modal-body ">
                    <div class="rounded-top" style="background-color: #337AB7; border: solid 1px #337AB7;">
                        <h6 class="text-white p-2 m-0 text-center">Ayuda de Registrar Productos</h6>
                    </div>

                    {{-- =================================== --}}

                    <div class="p-3" style="border: solid 1px #337AB7;" id="campos_producto">
                        <div class="row">
                            <div class="col-12">
                                <p class="">Señor usuario a la hora de realizar un registro de un producto tener en
                                    cuenta las siguientes recomendaciones:</p>

                                <ol>
                                    <li>Los campos marcados con asterisco (*) son obligatorios, por o tanto sino se llenan
                                        el sistema no le dejará seguir.</li>
                                    <li>Evitar ingresar nombres de productos ya existentes.</li>
                                    <li>El precio unitario no puede ser mayor al precio al detal y precio al por mayor.</li>
                                    <li>El precio al detal no puede ser menor al precio al por mayor.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ====================================================== --}}
                {{-- ====================================================== --}}

                <div class="modal-footer border-0 justify-content-end">
                    <button type="button" class="btn text-white" style="background-color:#204d74"
                        data-bs-dismiss="modal"><i class="fa fa-check-circle" aria-hidden="true"> Aceptar</i></button>
                </div>
            </div>
        </div>
    </div>
    {{-- FINAL MODAL Ayuda de Registrar Productos --}}

    {{-- ==================================================================================== --}}
    {{-- ==================================================================================== --}}
    {{-- ==================================================================================== --}}

    {{-- INICIO Modal Modificar Precios --}}
    <div class="modal fade" id="modalModificarPrecios" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog">
            <div class="modal-content p-3">
                <div class="modal-header justify-content-between border-0 pb-1">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#mod_ayuda_precios" title="Ayuda Modificar Precios">
                        <i class="fa fa-question" aria-hidden="true" title="Ayuda"></i>
                    </button>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- ====================================================== --}}
                {{-- ====================================================== --}}

                <div class="modal-body pt-0">
                    <div class="rounded-top" style="background-color: #337AB7; border: solid 1px #337AB7;">
                        <h6 class="text-white p-2 m-0 text-center">Modificar Precios (Obligatorios *)</h6>
                    </div>

                    {{-- =================================== --}}

                    {!! Form::open([
                        'method' => 'POST',
                        'route' => ['producto_update'],
                        'class' => 'mt-0',
                        'autocomplete' => 'off',
                        'id' => 'formEditarProductoEntrada',
                        'name' => 'crearProductoEntrada',
                    ]) !!}
                    @csrf

                    {!! Form::hidden('idProductoEdit', null, ['class' => 'form-control', 'id' => 'idProductoEdit', 'required']) !!}

                    {!! Form::hidden('form_editar_precios_entradas', 'formEditarPreciosEntradas') !!}

                    <div class="p-3" style="border: solid 1px #337AB7;" id="precios">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <label for="precioUnitarioEdit" class="fw-bold" style="font-size: 12px">Precio Unitario
                                    <span class="text-danger">*</span></label>
                                {!! Form::text('precioUnitarioEdit', null, [
                                    'class' => 'form-control',
                                    'id' => 'precioUnitarioEdit',
                                    'required' => 'required',
                                    'pattern' => '^[0-9]+$',
                                    'title' => 'Ingrese solo números enteros positivos',
                                    'inputmode' => 'numeric',
                                    'oninput' => "this.value = this.value.replace(/[^0-9]/g, '')",
                                ]) !!}
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="precioDetalEdit" class="fw-bold" style="font-size: 12px">Precio Detal <span
                                        class="text-danger">*</span></label>
                                {!! Form::text('precioDetalEdit', null, [
                                    'class' => 'form-control',
                                    'id' => 'precioDetalEdit',
                                    'required' => 'required',
                                    'pattern' => '^[0-9]+$',
                                    'title' => 'Ingrese solo números enteros positivos',
                                    'inputmode' => 'numeric',
                                    'oninput' => "this.value = this.value.replace(/[^0-9]/g, '')",
                                ]) !!}
                            </div>

                            <div class="col-12 col-md-6 mt-3">
                                <label for="precioPorMayorEdit" class="fw-bold" style="font-size: 12px">Precio al por
                                    Mayor <span class="text-danger">*</span></label>
                                {!! Form::text('precioPorMayorEdit', null, [
                                    'class' => 'form-control',
                                    'id' => 'precioPorMayorEdit',
                                    'required' => 'required',
                                    'pattern' => '^[0-9]+$',
                                    'title' => 'Ingrese solo números enteros positivos',
                                    'inputmode' => 'numeric',
                                    'oninput' => "this.value = this.value.replace(/[^0-9]/g, '')",
                                ]) !!}
                            </div>
                        </div>
                    </div> {{-- FIN campos precios --}}

                    {{-- ====================================================== --}}
                    {{-- ====================================================== --}}

                    <!-- Contenedor para el GIF -->
                    <div id="loadingIndicatorEditarProducto" class="loadingIndicator">
                        <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
                    </div>

                    {{-- ====================================================== --}}
                    {{-- ====================================================== --}}

                    <div class="modal-footer border-0 d-flex justify-content-center">
                        <button type="submit" class="btn btn-success me-3">
                            <i class="fa fa-floppy-o"> Modificar</i>
                        </button>

                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            <i class="fa fa-remove"> Cancelar</i>
                        </button>
                    </div>
                    {!! Form::close() !!}
                </div> {{-- FIN modal-body --}}
            </div> {{-- FIN modal-content --}}
        </div> {{-- FIN modal-dialog --}}
    </div> {{-- FINAL MODAL Modificar Precios --}}

    {{-- ==================================================================================== --}}
    {{-- ==================================================================================== --}}
    {{-- ==================================================================================== --}}

    {{-- INICIO Modal Ayuda Modificar Precios --}}
    <div class="modal fade" id="mod_ayuda_precios" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog">
            <div class="modal-content p-3">
                <div class="modal-header d-none"></div>

                {{-- ====================================================== --}}
                {{-- ====================================================== --}}

                <div class="modal-body ">
                    <div class="rounded-top" style="background-color: #337AB7; border: solid 1px #337AB7;">
                        <h6 class="text-white p-2 m-0 text-center">Ayuda Modificación Precios</h6>
                    </div>

                    {{-- =================================== --}}

                    <div class="p-3" style="border: solid 1px #337AB7;" id="campos_producto">
                        <div class="row">
                            <div class="col-12">
                                <p class="">Tener en cuenta para la modificación de los precios lo siguiente:</p>

                                <ol>
                                    <li>El precio unitario no puede ser mayor precio al detal y precio al por mayor.</li>
                                    <li>El precio al por mayor no puede ser menor al precio unitario, y tampoco mayor al
                                        precio al detal.</li>
                                    <li>El precio al detal debe ser mayor al precio al por mayor y al precio unitario.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ====================================================== --}}
                {{-- ====================================================== --}}

                <div class="modal-footer border-0 justify-content-end">
                    <button type="button" class="btn text-white" style="background-color:#204d74"
                        data-bs-dismiss="modal"><i class="fa fa-check-circle" aria-hidden="true"> Aceptar</i></button>
                </div>
            </div>
        </div>
    </div>
    {{-- FINAL MODAL Ayuda Modificar Precios --}}
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

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

            // ===================================================================================
            // ===================================================================================

            let idProducto = $('#id_producto').val();

            if (idProducto == '') {
                $('#p_unitario').html(0);
                $('#p_detal').html(0);
                $('#p_x_mayor').html(0);
                $('#btn_add_entrada').prop("disabled", true);
            }

            // ===================================================================================
            // ===================================================================================

            // INICIO - Validación Formulario Creación de Bajas de productos
            $('#id_producto').change(function() {
                let idProducto = $('#id_producto').val();

                let btn = $('#btn_add_entrada');
                let spinner = $("#loadingIndicatorAgregarCompra");

                if (idProducto != '') {
                    $.ajax({
                        async: true,
                        url: "{{ route('query_valores_producto') }}",
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'id_producto': idProducto
                        },
                        beforeSend: function() {
                            $('#p_unitario').html(0);
                            $('#p_detal').html(0);
                            $('#p_x_mayor').html(0);
                            // Desactivar botón
                            spinner.show();
                            btn.prop("disabled", true).html(
                                `<i class="fa fa-spinner fa-spin"></i> Procesando...`);
                        },
                        success: function(respuesta) {

                            if (idProducto == '') {
                                $('#p_unitario').html(0);
                                $('#p_detal').html(0);
                                $('#p_x_mayor').html(0);
                            } else {
                                setTimeout(() => {
                                    $('#p_unitario').html(respuesta.precio_unitario);
                                    $('#p_detal').html(respuesta.precio_detal);
                                    $('#p_x_mayor').html(respuesta.precio_por_mayor);

                                    $('#idProductoEdit').val(respuesta.id_producto);
                                    $('#precioUnitarioEdit').val(respuesta
                                        .precio_unitario);
                                    $('#precioDetalEdit').val(respuesta.precio_detal);
                                    $('#precioPorMayorEdit').val(respuesta
                                        .precio_por_mayor);

                                    $('#id_producto_compra').val(respuesta.id_producto);

                                    spinner.hide();
                                    btn.prop("disabled", false).html(
                                        `<i class="fa fa-plus plus"></i> Agregar`);
                                }, 1000);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error:", error);
                            spinner.hide();
                            btn.prop("disabled", false).html(
                                `<i class="fa fa-plus plus"></i> Agregar`);
                        }
                    });
                } else {
                    $('#p_unitario').html(0);
                    $('#p_detal').html(0);
                    $('#p_x_mayor').html(0);
                    $('#btn_add_entrada').prop("disabled", true);
                } // FIN if (idProducto != '')
            }); // FIN - Validación Formulario Creación de Bajas de productos $('#id_producto').change(function()

            // ===================================================================================
            // ===================================================================================

            // Modal modal_registroProducto (Store)
            $(document).on('shown.bs.modal', '[id^="modal_registroProducto"]', function() {

                $(this).find('.select2').select2({
                    dropdownParent: $(this),
                    placeholder: 'Seleccionar...',
                    width: '100%',
                    allowClear: false
                });

                // Buscar los elementos dentro de este modal
                let modal = $(this); // Guardamos la referencia del modal
                let inputPrecioUnitario = modal.find('[id^=precio_unitario]');
                let inputPrecioDetal = modal.find('[id^=precio_detal]');
                let inputPrecioPorMayor = modal.find('[id^=precio_por_mayor]');

                if (inputPrecioUnitario.length > 0) { // Al cargar el modal
                    // Valido que el precio unitario sea menor que el precio al detal
                    inputPrecioDetal.on("blur", function() {
                        let precioUnitario = parseFloat(inputPrecioUnitario.val()) || 0;
                        let precioDetal = parseFloat(inputPrecioDetal.val()) || 0;

                        if (precioUnitario >= precioDetal) {
                            Swal.fire(
                                'Cuidado!',
                                'El precio unitario debe ser menor que el precio al detal!',
                                'warning'
                            )
                            inputPrecioDetal.val('');
                        }
                    });

                    // ===================================================

                    // Valido que el precio por mayor sea mayor que el unitario y menor que el precio al detal
                    inputPrecioPorMayor.blur(function() {
                        let precioUnitario = parseFloat(inputPrecioUnitario.val()) || 0;
                        let precioDetal = parseFloat(inputPrecioDetal.val()) || 0;
                        let precioPorMayor = parseFloat(inputPrecioPorMayor.val()) || 0;

                        if (precioPorMayor <= precioUnitario || precioPorMayor >= precioDetal) {
                            Swal.fire(
                                'Cuidado!',
                                'El precio al por mayor debe ser superior al precio unitario y menor que el precio al detal!',
                                'warning'
                            )
                            inputPrecioPorMayor.val('');
                        }
                    });
                } // FIN inputPrecioUnitario.length > 0
            }); // FIN '[id^="modal_registroProducto"]').on('shown.bs.modal'

            // ===================================================================================
            // ===================================================================================

            // Modal modalModificarPrecios (Update)
            $(document).on('shown.bs.modal', '[id^="modalModificarPrecios"]', function() {
                // Buscar los elementos dentro de este modal
                let modal = $(this); // Guardamos la referencia del modal
                let inputPrecioUnitarioEdit = modal.find('[id^=precioUnitarioEdit]');
                let inputPrecioDetalEdit = modal.find('[id^=precioDetalEdit]');
                let inputPrecioPorMayorEdit = modal.find('[id^=precioPorMayorEdit]');

                if (inputPrecioUnitarioEdit.length > 0) { // Al cargar el modal
                    // Valido que el precio unitario sea menor que el precio al detal
                    inputPrecioDetalEdit.on("blur", function() {
                        let precioUnitario = parseFloat(inputPrecioUnitarioEdit.val()) || 0;
                        let precioDetal = parseFloat(inputPrecioDetalEdit.val()) || 0;

                        if (precioUnitario >= precioDetal) {
                            Swal.fire(
                                'Cuidado!',
                                'El precio unitario debe ser menor que el precio al detal!',
                                'warning'
                            )
                            inputPrecioDetalEdit.val('');
                        }
                    });

                    // ===================================================

                    // Valido que el precio por mayor sea mayor que el unitario y menor que el precio al detal
                    inputPrecioPorMayorEdit.blur(function() {
                        let precioUnitario = parseFloat(inputPrecioUnitarioEdit.val()) || 0;
                        let precioDetal = parseFloat(inputPrecioDetalEdit.val()) || 0;
                        let precioPorMayor = parseFloat(inputPrecioPorMayorEdit.val()) || 0;

                        if (precioPorMayor <= precioUnitario || precioPorMayor >= precioDetal) {
                            Swal.fire(
                                'Cuidado!',
                                'El precio al por mayor debe ser superior al precio unitario y menor que el precio al detal!',
                                'warning'
                            )
                            inputPrecioPorMayorEdit.val('');
                        }
                    });
                } // FIN inputPrecioUnitario.length > 0
            }); // FIN '[id^="modalModificarPrecios"]').on('shown.bs.modal'

            // ===================================================================================
            // ===================================================================================

            // INICIO DataTable
            let tablaCompras = $('#tbl_compras').DataTable({
                dom: 'lrtip',
                infoEmpty: 'No hay registros',
                stripe: true,
                bSort: false,
                autoWidth: false,
                scrollX: true,
                pageLength: 10,
                responsive: true,
                language: {
                    emptyTable: "No hay productos agregados"
                }
            }); // CIERRE DataTable

            // ===================================================================================
            // ===================================================================================

            // INICIO - Función para agregar fila x fila cada producto para comprar
            let totalVenta = 0;
            let indiceSiguienteFila = 0;

            $("#btn_add_entrada").click(function() {

                let spinner = $("#loadingIndicatorAgregarCompra");

                let idTipoProveedor = $('#id_tipo_proveedor').val();
                let tipoProveedor = $('#id_tipo_proveedor option:selected').text();

                let idProducto = $('#id_producto').val();
                let productoCompra = $('#id_producto option:selected').text();

                let pUnitario = parseFloat($('#p_unitario').text());
                let cantidad = parseInt($('#cantidad').val());

                if (!idTipoProveedor || !idProducto || !cantidad) {
                    Swal.fire(
                        'Cuidado!',
                        'Todos los campos son obligatorios!',
                        'error'
                    );
                    return;
                }

                $('#proveedorCompra').html(tipoProveedor);

                let valorSubTotal = pUnitario * cantidad;
                totalVenta += valorSubTotal; // Acumular total

                // Crear una fila para la tabla
                let fila = `
                    <tr class="" id="row_${indiceSiguienteFila}">
                        <td class="text-center">${productoCompra}</td>
                        <td class="text-center">${cantidad}</td>
                        <td class="text-center">${valorSubTotal}</td>
                        <td class="text-center">
                            <button type="button" data-id="${indiceSiguienteFila}" class="btn btn-danger btn-sm btn-eliminar-fila" style="background-color:red;">
                                <i class="fa fa-trash text-white"></i>
                            </button>
                        </td>
                    </tr>
                `;

                tablaCompras.row.add($(fila)).draw();

                // Agregar inputs hidden dentro del formulario
                let hiddenInputs = `
                    <div id="input_group_${indiceSiguienteFila}">
                        <input type="hidden" name="id_producto_compra[]" value="${idProducto}">
                        <input type="hidden" name="p_unitario_compra[]" value="${pUnitario}">
                        <input type="hidden" name="cantidad_compra[]" value="${cantidad}">
                        <input type="hidden" name="subtotal_compra[]" value="${valorSubTotal}">
                    </div>
                `;

                $("#formRegistrarCompra").append(hiddenInputs);

                // Actualizar total
                $('#valor_compra').val(totalVenta);

                let valorCompra = $('#valor_compra').val();
                let btnRegistarCompra = $('#btn_registar_compra');
                console.log(valorCompra);
                

                if (valorCompra == '' || valorCompra == '0' || valorCompra == 0 ) {
                    btnRegistarCompra.prop('disabled', true);
                } else {
                    btnRegistarCompra.prop('disabled', false);
                }

                $('#cantidad').attr('required');

                $('#id_producto').val('').trigger('change'); // Reiniciar selección de producto
                $('#p_unitario').html(0); // Resetear precio unitario
                $('#p_detal').html(0); // Resetear precio detal
                $('#p_x_mayor').html(0); // Resetear precio mayorista
                $('#cantidad').val(''); // Limpiar cantidad

                spinner.hide();

                indiceSiguienteFila++;
            });
            // FIN - Función para agregar fila x fila cada producto para comprar

            // ===================================================================================
            // ===================================================================================

            $(document).on('click', '.btn-eliminar-fila', function() {
                let idFila = $(this).data('id');
                let row = $(`#row_${idFila}`);
                let subtotalTexto = row.find('td:nth-child(3)').text().trim();
                let subtotal = parseFloat(subtotalTexto) || 0;

                totalVenta -= subtotal;
                $('#valor_compra').val(totalVenta);

                let btnRegistarCompra = $('#btn_registar_compra');
                if (totalVenta <= 0) {
                    btnRegistarCompra.prop('disabled', true);
                    totalVenta = 0; // Evita negativos
                    $('#valor_compra').val(0);
                } else {
                    btnRegistarCompra.prop('disabled', false);
                }

                // ✅ Eliminar correctamente la fila desde DataTables
                tablaCompras.row(row).remove().draw();

                // ✅ También eliminar los inputs ocultos
                $(`#input_group_${idFila}`).remove();
            });


            // $(document).on('click', '.btn-eliminar-fila', function() {
            //     let idFila = $(this).data('id');

            //     // Obtener texto del subtotal y convertir a número
            //     let subtotalTexto = $(`#row_${idFila} td:nth-child(3)`).text().trim();
            //     let subtotal = parseFloat(subtotalTexto);

            //     if (isNaN(subtotal)) {
            //         console.warn(
            //             `No se pudo obtener el subtotal de la fila ${idFila}. Valor leído: "${subtotalTexto}"`
            //         );
            //         subtotal = 0;
            //     }

            //     // Restar subtotal del total acumulado
            //     totalVenta -= subtotal;
            //     $('#valor_compra').val(totalVenta);

            //     let valorCompra = $('#valor_compra').val();
            //     let btnRegistarCompra = $('#btn_registar_compra');
            //     console.log(valorCompra);
                

            //     if (valorCompra == '' || valorCompra == '0' || valorCompra == 0 ) {
            //         btnRegistarCompra.prop('disabled', true);
            //     } else {
            //         btnRegistarCompra.prop('disabled', false);
            //     }

            //     // Eliminar fila y sus inputs ocultos
            //     $(`#row_${idFila}`).remove();
            //     $(`#input_group_${idFila}`).remove();
            // });

            // ===================================================================================
            // ===================================================================================

            // formCrearProducto para cargar gif en el submit
            $(document).on("submit", "form[id^='formCrearProducto']", function(e) {
                const form = $(this);
                const submitButton = form.find('button[type="submit"]');
                const cancelButton = form.find('button[type="button"]');
                const loadingIndicator = form.find(
                    "div[id^='loadingIndicatorCrearProducto']"); // Busca el GIF del form actual

                // Dessactivar Submit y Cancel
                submitButton.prop("disabled", true).html(
                    "Procesando... <i class='fa fa-spinner fa-spin'></i>");
                cancelButton.prop("disabled", true);

                // Mostrar Spinner
                loadingIndicator.show();
            });

            // ===================================================================================
            // ===================================================================================

            // formEditarProductoEntrada para cargar gif en el submit
            $(document).on("submit", "form[id^='formEditarProductoEntrada']", function(e) {
                const form = $(this);
                const submitButton = form.find('button[type="submit"]');
                const cancelButton = form.find('button[type="button"]');
                const loadingIndicator = form.find(
                    "div[id^='loadingIndicatorEditarProducto']"); // Busca el GIF del form actual

                // Dessactivar Submit y Cancel
                submitButton.prop("disabled", true).html(
                    "Procesando... <i class='fa fa-spinner fa-spin'></i>");
                cancelButton.prop("disabled", true);

                // Mostrar Spinner
                loadingIndicator.show();
            });

            // ===================================================================================
            // ===================================================================================

            let valorCompra = $('#valor_compra').val();
            let btnRegistarCompra = $('#btn_registar_compra');
            console.log(valorCompra);
            

            if (valorCompra == '' || valorCompra == '0' || valorCompra == 0 ) {
                btnRegistarCompra.prop('disabled', true);
            } else {
                btnRegistarCompra.prop('disabled', false);
            }

            // ===================================================================================
            // ===================================================================================

            // formRegistrarCompra para cargar gif en el submit
            $(document).on("submit", "form[id^='formRegistrarCompra']", function(e) {
                const form = $(this);
                const submitButton = form.find('button[type="submit"]');
                const loadingIndicator = form.find("div[id^='loadingIndicatorCrearEntrada']");

                // Evitar múltiples envíos
                if (form.data("submitted") === true) {
                    e.preventDefault();
                    return false; // No deja enviar otra vez
                }

                form.data("submitted", true); // Marca como ya enviado
                
                // Retirar required de Aregar Compra
                $('#cantidad').removeAttr('required');

                // Desactivar botón y mostrar su spinner
                submitButton.prop("disabled", true).html("Procesando... <i class='fa fa-spinner fa-spin'></i>");

                // Mostrar Spinner
                loadingIndicator.show();
            });
        }); // FIN document.ready
    </script>
@stop
