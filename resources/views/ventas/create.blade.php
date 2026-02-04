@extends('layouts.app')
@section('title', 'Registrar Ventas')

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
            <div class="d-flex justify-content-between pe-3 mt-2 mb-2">
                <div class="">
                    <a href="{{ route('ventas.index') }}" class="btn text-white" style="background-color:#337AB7">Ventas</a>
                </div>

                <div class="text-end">
                    <a href="#" role="button" title="Ayuda" class="text-blue" data-bs-toggle="modal"
                        data-bs-target="#modalAyudaRegistrarVentas">
                        <i class="fa fa-question-circle fa-2x" aria-hidden="false" title="Ayuda"
                            style="color: #337AB7"></i>
                    </a>
                </div>
            </div>


            <div class="modal fade" id="modalAyudaRegistrarVentas" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" data-keyboard ="false" data-backdrop = "static">
                <div class="modal-dialog" style="min-width: 60%;">
                    <div class="modal-content p-3">
                        <div class="modal-body p-0 rounded-top" style="border: solid 1px #337AB7; mw-50">
                            <div class="row">
                                <div class="col-12">
                                    <div class="rounded-top text-white text-center p-2"
                                        style="background-color: #337AB7; border: solid 1px #337AB7;">
                                        <span class="modal-title fs-4"><strong>Ayuda de Ventas</strong></span>
                                    </div>
                                    {{-- =========================== --}}
                                    <div class="p-3">
                                        <p class="text-justify">Señor usuario para una mayor agilidad en el registro de la
                                            venta tener en cuenta lo siguiente:</p>

                                        <ol>
                                            <li class="text-justify">En el campo de producto se recomienda el uso de la
                                                pistola lectora de código de barras, para leer el código del producto para
                                                una asociación más ágil y rápida.</li>
                                            <li class="text-justify">Los campos marcados con asterisco (*) son obligatorios,
                                                por lo tanto sino se diligencian, el sistema no dejará seguir.</li>
                                            <li class="text-justify">Cliente que se asocie y sea frecuente tomará por
                                                defecto el precio al por mayor.</li>
                                            <li class="text-justify">Cliente que ya tenga un crédito registrado en el
                                                sistema, no se le dejará realizar otra Venta a crédito.</li>
                                            <li class="text-justify">El descuento ingresarlo en pesos.</li>
                                            <li class="text-justify">Para poder realizarle un descuento a un cliente, el
                                                total de la venta deberá superar el valor configurado por el administrador.
                                            </li>
                                            <li class="text-justify">Toda venta a crédito solo tendrá un límite de pago de
                                                los días calendario configurado por el administrador.</li>
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
                    Registrar Ventas</h5>

                {!! Form::open([
                    'method' => 'POST',
                    'route' => ['ventas.store'],
                    'class' => '',
                    'autocomplete' => 'off',
                    'id' => 'formRegistrarVenta',
                ]) !!}
                @csrf

                {{ Form::hidden('id_tipo_persona', null, ['class' => '', 'id' => 'id_tipo_persona', 'required']) }}

                <div class="d-flex flex-column flex-md-row justify-content-between p-3">
                    <div class="w-100-div w-48 mb-auto" style="border: solid 1px #337AB7; border-radius: 5px;">
                        <h5 class="border rounded-top text-white p-2" style="background-color: #337AB7">Cliente <span
                                class="text-danger">*</span></h5>
                        {{-- ============================================================== --}}
                        <div class="p-2 d-flex justify-content-between">
                            <div class="col-12">
                                {{ Form::select(
                                    'cliente_venta',
                                    collect(['' => 'Seleccionar...'])->union(
                                        collect($clientes_ventas)->mapWithKeys(fn($cliente, $id) => [$id => $cliente['nombre']]),
                                    ),
                                    null,
                                    ['class' => 'form-select select2', 'id' => 'cliente_venta', 'required'],
                                ) }}
                            </div>
                        </div>
                        {{-- ============================================================== --}}
                        <h5 class="border rounded-top text-white p-2" style="background-color: #337AB7">Producto <span
                                class="text-danger">*</span></h5>
                        {{-- ============================================================== --}}
                        <div class="p-3 d-flex justify-content-between" id="" style="">
                            <div class="col-md-12">
                                {{ Form::select('producto_venta', collect(['' => 'Seleccionar...'])->union($productos), null, ['class' => 'form-select select2', 'id' => 'producto_venta']) }}
                            </div>

                            {{-- <div class="col-md-1">
                                <button type="button" class="btn rounded-2 text-white" style="background-color: #337AB7"
                                    title="Registrar Producto" data-bs-toggle="modal"
                                    data-bs-target="#modal_registroProducto">
                                    <i class="fa fa-plus plus"></i>
                                </button>
                            </div> --}}
                        </div>
                        {{-- ============================================================== --}}
                        <div class="d-flex justify-content-center p-3">
                            <table class="table table-striped table-bordered w-100 mb-0" id="tbl_ventas"
                                aria-describedby="ventas">
                                <thead>
                                    <tr class="header-table text-center">
                                        <th>Precio Unitario</th>
                                        <th>Precio Detal</th>
                                        <th>Precio por Mayor</th>
                                        <th>Aplicar Precio Al por Mayor</th>
                                    </tr>
                                </thead>
                                {{-- ============================== --}}
                                <tbody>
                                    <tr class="text-center align-middle">
                                        <td>$ <span id="p_unitario_venta"></span></td>
                                        <td>$ <span id="p_detal_venta"></span></td>
                                        <td>$ <span id="p_x_mayor_venta"></span></td>
                                        <td id="td_aplicar_x_mayor_venta">
                                            {{ Form::checkbox('aplicar_x_mayor_venta', null, ['class' => 'form-control', 'id' => 'aplicar_x_mayor_venta']) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        {{-- ============ --}}
                        <div class="form-group p-3 id="cant">
                            <label for="cantidad_venta" class="fw-bold">Cantidad <span class="text-danger">*</span></label>
                            <div class="row align-items-center p-0 m-0">
                                <div class="col-8 p-0 m-0">
                                    {!! Form::text('cantidad_venta', null, [
                                        'class' => 'form-control rounded-end-0',
                                        'id' => 'cantidad_venta',
                                        'min' => '1',
                                        'maxlength' => '4',
                                        'pattern' => '^[0-9]+$',
                                        'inputmode' => 'numeric',
                                        'min' => '0',
                                        'title' => 'Ingrese un valor numérico entero mayor o igual a 0',
                                        'oninput' => "this.value = this.value.replace(/[^0-9]/g, '')",
                                    ]) !!}
                                </div>

                                <div class="col-4 m-0 p-0">
                                    <span class="form-control rounded-start-0 text-center" style="background-color: #EEEEEE">
                                        Unidades (<span id="cantidad_producto" class="text-success fw-bold"></span>)
                                    </span>
                                </div>
                            </div>
                        </div>
                        {{-- ============ --}}
                        <!-- Contenedor para el GIF -->
                        <div id="loadingIndicatorAgregarVenta" class="loadingIndicator" style="display: none;">
                            <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
                        </div>
                        {{-- ============ --}}
                        <div class="p-3 d-flex justify-content-end">
                            <button type="button" class="btn btn-primary active pull-right" id="btnAgregarVenta"
                                title="Agregar">
                                <i class="fa fa-plus plus"></i>
                                Agregar
                            </button>
                        </div>
                    </div> {{-- FIN div_izquierdo registrar ventas (cliente, producto y add producto) --}}

                    {{-- ============================================================== --}}
                    {{-- ============================================================== --}}
                    {{-- ============================================================== --}}

                    <div class="w-100-div w-48 mt-5 mt-md-0">
                        <div class="m-0 p-0" style="border: solid 1px #337AB7; border-radius: 5px;">
                            <h5 class="border rounded-top text-white p-2 m-0" style="background-color: #337AB7">Detalle
                                Venta: <span id="clienteVenta"></span></h5>

                            <div class="">
                                <div class="table-responsive p-3 d-flex flex-column justify-content-between h-100"
                                    style="">
                                    <table class="table table-striped table-bordered w-100 mb-0" id="tabla_detalle_venta"
                                        aria-describedby="ventas">
                                        <thead>
                                            <tr class="header-table text-center">
                                                <th>Producto</th>
                                                <th>Cantidad</th>
                                                <th>subtotal</th>
                                                <th>Ganancia</th>
                                                <th>Opción</th>
                                            </tr>
                                        </thead>
                                        {{-- ============================== --}}
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>

                                <div class="p-2" style="background-color: #F5F5F5; border-top: 1px solid #ddd;">
                                    <div class="d-flex rounded-end" style="border: 1px solid #ddd;">
                                        <p class="p-1 m-0 fw-bold w-25">Subtotal: $</p>
                                        {!! Form::text('sub_total_venta', null, [
                                            'class' => 'form-control w-75 bg-success-subtle',
                                            'id' => 'sub_total_venta',
                                            'required',
                                            'readonly',
                                        ]) !!}
                                    </div>

                                    {{-- <div class="d-flex mt-2 mb-2 rounded-end" style="border: 1px solid #ddd;">
                                            <p class="p-1 m-0 fw-bold w-25">Descuento: $</p>
                                            {!! Form::text('descuento_total_venta', null, [
                                                'class' => 'form-control w-75 bg-success-subtle',
                                                'id' => 'descuento_total_venta',
                                                'readonly',
                                            ]) !!}
                                        </div> --}}

                                    <div class="d-flex rounded-end" style="border: 1px solid #ddd;">
                                        <p class="p-1 m-0 fw-bold w-25">Total: $</p>
                                        {!! Form::text('total_venta', null, [
                                            'class' => 'form-control w-75 bg-success-subtle',
                                            'id' => 'total_venta',
                                            'required',
                                            'readonly',
                                        ]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- ========================== --}}
                        <div class="mt-3 row m-0 p-2" style="border: solid 1px #337AB7; border-radius: 5px;">
                            <div class="col-12 col-md-6 d-flex flex-column">
                                <div class="form-group">
                                    <label for="tipo_pago" class="fw-bold">Tipo de Pago
                                        <span class="text-danger">*</span>
                                    </label>

                                    {!! Form::select('tipo_pago', collect(['' => 'Seleccionar...'])->union($tipos_pago_ventas), 1, [
                                        'class' => 'form-select select2',
                                        'id' => 'tipo_pago',
                                        'required',
                                    ]) !!}
                                </div>
                            </div>

                            {{-- <div class="col-12 col-md-6 d-flex flex-column d-none" id="div_plazo_credito">
                                <label for="plazo_credito" class="fw-bold">Días Plazo Crédito<span
                                        class="text-danger">*</span></label>
                                {!! Form::number('plazo_credito', null, ['class' => 'form-control', 'id' => 'plazo_credito', 'required']) !!}
                            </div> --}}

                            {{-- <div class="col-12 col-md-6 d-flex flex-column">
                                    <label for="descuento" class="fw-bold">Descuento en Pesos <span
                                            class="text-danger">*</span></label>
                                    {!! Form::text('descuento', null, [
                                        'class' => 'form-control',
                                        'id' => 'descuento',
                                        'required' => 'required',
                                        'pattern' => '^[0-9]+$',
                                        'inputmode' => 'numeric',
                                        'min' => '0',
                                        'title' => 'Ingrese un valor numérico entero mayor o igual a 0',
                                        'oninput' => "this.value = this.value.replace(/[^0-9]/g, '')",
                                    ]) !!}
                                </div> --}}
                        </div>

                        {{-- ====================================================== --}}
                        {{-- ====================================================== --}}

                        <!-- Contenedor para el GIF -->
                        <div id="loadingIndicatorRegistrarVenta" class="loadingIndicator">
                            <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
                        </div>

                        {{-- ====================================================== --}}
                        {{-- ====================================================== --}}

                        <div class="d-flex justify-content-end mt-4 p-3" style="">
                            <button type="submit" class="btn btn-success rounded-2 me-3" id="btn_registar_venta">
                                <i class="fa fa-floppy-o"></i>
                                Vender
                            </button>
                        </div>
                    </div> {{-- FIN div_derecho (Detalle Venta) --}}
                </div> {{-- FIN div_lateral derecho interno registrar ventas, cubre ambos --}}
                {!! Form::close() !!}
            </div> {{-- FIN div_registrar ventas (cubre ambos --}}
        </div> {{-- FIN div_contenido 80% --}}
    </div> {{-- FIN div_ppal (sidemarmenu y contenido derecho del 80%) --}}

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
                    'id' => 'formCrearProductoVenta',
                    'name' => 'crearProductoVenta',
                ]) !!}
                @csrf

                <div class="modal-body pt-0">
                    <div class="rounded-top" style="background-color: #337AB7; border: solid 1px #337AB7;">
                        <h6 class="text-white p-2 m-0 text-center">Registrar Producto (Obligatorios *)</h6>
                    </div>

                    {{-- =================================== --}}

                    <div class="p-3" style="border: solid 1px #337AB7;" id="campos_producto">
                        <div class="row">
                            {!! Form::hidden('form_ventas', 'crearProductoVenta') !!}

                            <div class="col-12 col-md-4">
                                <label for="nombre_producto" class="fw-bold" style="font-size: 12px">Nombre Producto<span
                                        class="text-danger">*</span>
                                </label>
                                {!! Form::text('nombre_producto', null, [
                                    'class' => 'form-control',
                                    'id' => 'nombre_producto',
                                    'required' => 'required',
                                    'pattern' => '^[a-zA-ZÁÉÍÓÚáéíóúÑñ0-9\s\-_.,&()]{2,100}$',
                                    'title' =>
                                        'El nombre del producto debe tener entre 2 y 100 caracteres. Puede incluir letras, números, espacios y algunos caracteres especiales como -_.,&()',
                                    'maxlength' => '100',
                                    'minlength' => '2',
                                ]) !!}
                            </div>

                            <div class="col-12 col-md-4">
                                <label for="id_categoria" class="fw-bold" style="font-size: 12px">Categoría <span
                                        class="text-danger">*</span></label>
                                {!! Form::select('id_categoria', collect(['' => 'Seleccionar...'])->union($categorias), null, [
                                    'class' => 'form-select select2 select2-categoria',
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
                                    'title' => 'Ingrese solo números enteros positivos',
                                    'inputmode' => 'numeric',
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
                                    'title' => 'Ingrese solo números enteros positivos',
                                    'inputmode' => 'numeric',
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
                                    'title' => 'Ingrese solo números enteros positivos',
                                    'inputmode' => 'numeric',
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
                <div id="loadingIndicatorCrearProductoVenta" class="loadingIndicator">
                    <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
                </div>

                {{-- ====================================================== --}}
                {{-- ====================================================== --}}

                <div class="modal-footer border-0 d-flex justify-content-center mt-0">
                    <button type="submit" class="btn btn-success me-3"><i class="fa fa-floppy-o"> Guardar</i></button>

                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        <i class="fa fa-remove"> Cancelar</i>
                    </button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    {{-- FINAL MODAL REGISTRAR PRODUCTO --}}

    {{-- INICIO Modal Ayuda de Registrar Productos --}}
    <div class="modal fade" id="mod_ayuda_registroProducto" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog">
            <div class="modal-content p-3">
                <div class="modal-header d-none"></div>

                <div class="modal-body ">
                    <div class="rounded-top" style="background-color: #337AB7; border: solid 1px #337AB7;">
                        <h6 class="text-white p-2 m-0 text-center">Ayuda de Registrar Productos</h6>
                    </div>

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

                <div class="modal-footer border-0 justify-content-end">
                    <button type="button" class="btn text-white" style="background-color:#204d74"
                        data-bs-dismiss="modal"><i class="fa fa-check-circle" aria-hidden="true"> Aceptar</i></button>
                </div>
            </div>
        </div>
    </div>
    {{-- FINAL MODAL Ayuda de Registrar Productos --}}

    {{-- INICIO Modal Ayuda Modificar Precios --}}
    <div class="modal fade" id="mod_ayuda_precios" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog">
            <div class="modal-content p-3">
                <div class="modal-header d-none"></div>

                <div class="modal-body ">
                    <div class="rounded-top" style="background-color: #337AB7; border: solid 1px #337AB7;">
                        <h6 class="text-white p-2 m-0 text-center">Ayuda Modificación Precios</h6>
                    </div>

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

                <div class="modal-footer border-0 justify-content-end">
                    <button type="button" class="btn text-white" style="background-color:#204d74"
                        data-bs-dismiss="modal"><i class="fa fa-check-circle" aria-hidden="true"> Aceptar</i></button>
                </div>
            </div>
        </div>
    </div>
    {{-- FINAL MODAL Ayuda Modificar Precios --}}
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

            $(document).on('shown.bs.modal', '.modal', function() {
                $(this).find('.select2').select2({
                    dropdownParent: $(this),
                    placeholder: 'Seleccionar...',
                    width: '100%',
                    allowClear: false
                });
            });

            let idProducto = $('#producto_venta').val();

            if (idProducto == '') {
                $('#p_unitario_venta').html(0);
                $('#p_detal_venta').html(0);
                $('#p_x_mayor_venta').html(0);
                $('#btnAgregarVenta').prop("disabled", true);
            }

            // INICIO - Consulta de los precios del productos
            $('#producto_venta').change(function() {
                let idProducto = $('#producto_venta').val();

                let btn = $('#btnAgregarVenta');
                let spinner = $("#loadingIndicatorAgregarVenta");
                let btnRegistarVenta = $('#btn_registar_venta');

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
                            $('#p_unitario_venta').html(0);
                            $('#p_detal_venta').html(0);
                            $('#p_x_mayor_venta').html(0);
                            $('#cantidad_producto').html(0);
                            // Desactivar botón
                            spinner.show();
                            btn.prop("disabled", true).html(`<i class="fa fa-spinner fa-spin"></i> Procesando...`);
                            $('#cantidad_venta').val('');

                            btnRegistarVenta.prop('disabled', true);
                            
                        },
                        success: function(respuesta) {
                            setTimeout(() => {
                                $('#p_unitario_venta').html(respuesta.precio_unitario);
                                $('#p_detal_venta').html(respuesta.precio_detal);
                                $('#p_x_mayor_venta').html(respuesta.precio_por_mayor);
                                $('#cantidad_producto').html(respuesta.cantidad);

                                let idProducto = respuesta.id_producto;

                                // NUEVO: restar del stock disponible lo ya agregado del mismo producto
                                let cantidadAgregada = 0;
                                if (Array.isArray(productosAgregados) && productosAgregados.length) {
                                    productosAgregados.forEach(p => {
                                        if (String(p.idProductoVenta) === String(idProducto)) {
                                            cantidadAgregada += (parseInt(p.cantidad) || 0);
                                        }
                                    });
                                }
                                let disponible = (parseInt(respuesta.cantidad) || 0) - cantidadAgregada;
                                if (disponible < 0) disponible = 0;
                                $('#cantidad_producto').html(disponible);

                                spinner.hide();
                                btn.prop("disabled", false).html(`<i class="fa fa-plus plus"></i> Agregar`);
                                btnRegistarVenta.prop('disabled', false);
                            }, 1000);
                        },
                        error: function(xhr, status, error) {
                            spinner.hide();
                            btn.prop("disabled", false).html(
                                `<i class="fa fa-plus plus"></i> Agregar`);
                        }
                    });
                } else {
                    $('#p_unitario_venta').html(0);
                    $('#p_detal_venta').html(0);
                    $('#p_x_mayor_venta').html(0);
                    $('#cantidad_producto').html(0);
                }
            });
            // FIN - Consulta de los precios del productos

            // INICIO - Validar la cantidad ingresada vs la cantidad disponible para vender el producto
            $('#cantidad_venta').blur(function() {
                let cantidadVenta = parseInt($('#cantidad_venta').val().trim()) || 0;
                let cantidadProducto = parseInt($('#cantidad_producto').text().trim()) || 0;

                if (cantidadVenta > cantidadProducto) {
                    Swal.fire('Cuidado!', 'No puedes vender más de la cantidad disponible.!', 'warning');
                    $('#cantidad_venta').val(''); // Limpiar cantidad a vender
                    return;
                }
            });
            // FIN - Validar la cantidad ingresada vs la cantidad disponible para vender el producto

            // ===================================================================================
            // ===================================================================================

            $('#td_aplicar_x_mayor_venta').hide();
            $('input[name="aplicar_x_mayor_venta"]').removeAttr('required');
            $('input[name="aplicar_x_mayor_venta"]').prop('checked', false);
            $('input[name="aplicar_x_mayor_venta"]').removeAttr('disabled');

            let aplicarXMayorVenta = $('#aplicar_x_mayor_venta').is(':checked');

            if (aplicarXMayorVenta == false) {
                aplicarXMayorVenta = $('input[name="aplicar_x_mayor_venta"]').removeAttr('checked');
            }

            var clientesInfo = @json($clientes_ventas);

            $('#cliente_venta').change(function() {
                let idCliVenta = $(this).val(); // Obtiene el ID de la persona seleccionada

                if (idCliVenta && clientesInfo[idCliVenta]) {
                    let tipoPersona = clientesInfo[idCliVenta].tipo; // Obtiene id_tipo_persona

                    $('#id_tipo_persona').val(tipoPersona);

                    if (tipoPersona == 5) {
                        $('#td_aplicar_x_mayor_venta').show();
                        $('input[name="aplicar_x_mayor_venta"]').attr('required');
                        $('input[name="aplicar_x_mayor_venta"]').prop('checked', true);
                        $('input[name="aplicar_x_mayor_venta"]').attr('disabled', true);
                    } else {
                        $('#td_aplicar_x_mayor_venta').hide();
                        $('input[name="aplicar_x_mayor_venta"]').removeAttr('required');
                        $('input[name="aplicar_x_mayor_venta"]').prop('checked', false);
                        $('input[name="aplicar_x_mayor_venta"]').removeAttr('disabled');
                    }
                } else {
                    $('#td_aplicar_x_mayor_venta').hide();
                    $('input[name="aplicar_x_mayor_venta"]').removeAttr('required');
                    $('input[name="aplicar_x_mayor_venta"]').prop('checked', false);
                }
            });

            // ===================================================================================
            // ===================================================================================

            // INICIO DataTable
            let tablaDetalleVenta = $('#tabla_detalle_venta').DataTable({
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
            });
            // CIERRE DataTable

            // ===================================================================================
            // ===================================================================================

            // INICIO - Función agregar datos de las ventas
            let productosAgregados = [];

            $("#btnAgregarVenta").click(function() {
                const btn = $(this);
                let spinner = $("#loadingIndicatorAgregarVenta");

                let idTipoClienteVenta = $('#cliente_venta').val();
                let clienteVenta = $('#cliente_venta option:selected').text();

                let idProductoVenta = $('#producto_venta').val();
                let productoVenta = $('#producto_venta option:selected').text();

                let pUnitarioVenta = parseFloat($('#p_unitario_venta').text());
                let pDetalVenta = parseFloat($('#p_detal_venta').text());
                let pxMayorVenta = parseFloat($('#p_x_mayor_venta').text());
                let cantidadVenta = parseInt($('#cantidad_venta').val());
                let aplicarMayor = $('input[name="aplicar_x_mayor_venta"]').is(':checked')

                if (!idTipoClienteVenta || !idProductoVenta || !cantidadVenta || cantidadVenta <= 0) {
                    Swal.fire('Cuidado!',
                        'Todos los campos son obligatorios y la cantidad debe ser mayor a 0!', 'error');
                    return;
                }

                $('#clienteVenta').html(clienteVenta);

                let valorSubTotal = aplicarMayor ? cantidadVenta * pxMayorVenta :
                    cantidadVenta * pDetalVenta;

                let ganancia = aplicarMayor ? (cantidadVenta * pxMayorVenta) - (pUnitarioVenta*cantidadVenta) :
                    (cantidadVenta * pDetalVenta) - (pUnitarioVenta*cantidadVenta);

                if (aplicarMayor) {
                    pDetalVenta = '';
                } else {
                    pxMayorVenta = '';
                }

                let producto = {
                    idProductoVenta: idProductoVenta,
                    nombre: productoVenta,
                    cantidad: cantidadVenta,
                    pUnitarioVenta: pUnitarioVenta,
                    pDetalVenta: pDetalVenta,
                    pxMayorVenta: pxMayorVenta,
                    subtotal: valorSubTotal,
                    ganancia: ganancia,
                };
                productosAgregados.push(producto);

                actualizarDetalleVenta();

                let valorVenta = $('#total_venta').val();
                let btnRegistarVenta = $('#btn_registar_venta');

                if (valorVenta == '' || valorVenta == '0' || valorVenta == 0 ) {
                    btnRegistarVenta.prop('disabled', true);
                } else {
                    btnRegistarVenta.prop('disabled', false);
                }

                // Limpia los campos después de agregar un producto exitosamente
                $('#cantidad_venta').attr('required');

                $('#producto_venta').val('').trigger('change'); // Reiniciar selección de producto

                $('#p_unitario_venta').html(0); // Resetear precio detal
                $('#p_detal_venta').html(0); // Resetear precio detal
                $('#p_x_mayor_venta').html(0); // Resetear precio mayorista

                $('#cantidad_venta').val(''); // Limpiar cantidad
                $('#cantidad_producto').html(0); // Limpiar cantidad disponible
            });
            // FIN - Función agregar datos de las ventas

            // ===================================================================================
            // ===================================================================================

            function actualizarDetalleVenta() {
                tablaDetalleVenta.clear().draw();

                let detalleHTML = "";
                let totalVenta = 0;

                productosAgregados.forEach((producto, index) => {
                    detalleHTML += `
                        <tr id="row_${index}">
                            <td class="text-center align-middle">${producto.nombre}</td>
                            <td class="text-center align-middle">${producto.cantidad}</td>
                            <td class="text-center align-middle">$${producto.subtotal}</td>
                            <td class="text-center align-middle">$${producto.ganancia}</td>
                            <td class="text-center align-middle">
                                <button type="button" onclick="eliminarProducto(${index})" class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash text-white"></i>
                                </button>
                            </td>

                            <input type="hidden" name="id_producto_venta[]" value="${producto.idProductoVenta}">
                            <input type="hidden" name="cantidad_venta[]" value="${producto.cantidad}">
                            <input type="hidden" name="p_unitario_venta[]" value="${producto.pUnitarioVenta}">
                            <input type="hidden" name="p_detal_venta[]" value="${producto.pDetalVenta}">
                            <input type="hidden" name="p_mayor_venta[]" value="${producto.pxMayorVenta}">
                            <input type="hidden" name="subtotal_venta[]" value="${producto.subtotal}">
                            <input type="hidden" name="ganancia[]" value="${producto.ganancia}">
                        </tr>
                    `;

                    totalVenta += producto.subtotal;
                });

                $('#tabla_detalle_venta tbody').html(detalleHTML);
                $('#sub_total_venta').val(totalVenta);
                $('#total_venta').val(totalVenta);
            }

            window.eliminarProducto = function(index) {
                productosAgregados.splice(index, 1);
                actualizarDetalleVenta();
                $('#producto_venta').val('').trigger('change'); // Reiniciar selección de producto
                $('#p_unitario_venta').html(0); // Resetear precio unitario
                $('#p_detal_venta').html(0); // Resetear precio detal
                $('#p_x_mayor_venta').html(0); // Resetear precio mayorista
                $('#cantidad_venta').val(''); // Limpiar cantidad
                $('#cantidad_producto').html(0); // Limpiar cantidad disponible

                let valorVenta = $('#total_venta').val();
                let btnRegistarVenta = $('#btn_registar_venta');

                if (valorVenta == '' || valorVenta == '0' || valorVenta == 0 ) {
                    btnRegistarVenta.prop('disabled', true);
                } else {
                    btnRegistarVenta.prop('disabled', false);
                }
            };

            // ===================================================================================
            // ===================================================================================

            $('#tipo_pago').on('change', function() {

                let tipoPago = $('#tipo_pago').val();

                if (tipoPago == 2) {
                    $('#div_plazo_credito').removeClass('d-none');
                    $('#plazo_credito').attr('required');
                } else {
                    $('#div_plazo_credito').addClass('d-none');
                    $('#plazo_credito').removeAttr('required');
                }
            });

            // ===================================================================================
            // ===================================================================================

            let valorVenta = $('#total_venta').val();
            let btnRegistarVenta = $('#btn_registar_venta');

            if (valorVenta == '' || valorVenta == '0' || valorVenta == 0 ) {
                btnRegistarVenta.prop('disabled', true);
            } else {
                btnRegistarVenta.prop('disabled', false);
            }

            // ===================================================================================
            // ===================================================================================

            // loadingIndicatorCrearProductoVenta para cargar gif en el submit
            $(document).on("submit", "form[id^='formCrearProductoVenta']", function(e) {
                const form = $(this);
                const submitButton = form.find('button[type="submit"]');
                const cancelButton = form.find('button[type="button"]');
                const loadingIndicator = form.find("div[id^='loadingIndicatorCrearProductoVenta']");

                // Dessactivar Submit y Cancel
                submitButton.prop("disabled", true).html(
                    "Procesando... <i class='fa fa-spinner fa-spin'></i>");
                cancelButton.prop("disabled", true);

                // Cargar Spinner
                loadingIndicator.show();
            });

            // ===================================================================================
            // ===================================================================================

            // loadingIndicatorRegistrarVenta para cargar gif en el submit
            $(document).on("submit", "form[id^='formRegistrarVenta']", function(e) {
                const form = $(this);
                const submitButton = form.find('button[type="submit"]');
                const loadingIndicator = form.find("div[id^='loadingIndicatorRegistrarVenta']");

                // Evitar múltiples envíos
                if (form.data("submitted") === true) {
                    e.preventDefault();
                    return false; // No deja enviar otra vez
                }

                form.data("submitted", true); // Marca como ya enviado

                // Retirar required de Aregar Venta
                $('#cantidad_venta').removeAttr('required');

                // Desactivar botón y mostrar su spinner
                submitButton.prop("disabled", true).html("Procesando... <i class='fa fa-spinner fa-spin'></i>");

                // Cargar Spinner
                loadingIndicator.show();
            });

            // ===================================================================================
            // ===================================================================================
        }); // FIN document.ready
    </script>
@stop
