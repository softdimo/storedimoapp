{{-- INICIO Modal MODIFICAR PRODUCTO --}}
{!! Form::open([
    'method' => 'POST',
    'route' => ['producto_update'],
    'class' => 'm-0 p-0',
    'autocomplete' => 'off',
    'id' => 'formEditarProducto_' . $productoEdit->id_producto,
    'enctype' => 'multipart/form-data',
    'file' => true]) !!}
    @csrf
    <div class="rounded-top" style="border: solid 1px #337AB7;">
        <div class="rounded-top text-white text-center"
            style="background-color: #337AB7; border: solid 1px #337AB7;">
            <h5 class="m-1">Modificar Producto (Obligatorios *)</h5>
        </div>

        {{-- ====================================================== --}}
        {{-- ====================================================== --}}

        <div class="modal-body p-0 m-0">
            <div class="row m-0 pt-2 pb-4">
                <div class="col-12 col-md-2">
                    <div class="form-group d-flex flex-column">
                        <label for="idProductoEdit" class=""
                            style="font-size: 15px">Código<span
                                class="text-danger"></span></label>
                        {{ Form::text('idProductoEdit', isset($productoEdit) ? $productoEdit->id_producto : null, ['class' => 'form-control bg-secondary-subtle', 'id' => 'idProductoEdit', 'required' => 'required', 'readonly' => true]) }}
                    </div>
                </div>
                {{-- =================== --}}
                <div class="col-12 col-md-5">
                    <div class="form-group d-flex flex-column">
                        <label for="nombreProductoEdit" class=""
                            style="font-size: 15px">Nombre Producto<span
                                class="text-danger">*</span></label>
                        {{ Form::text('nombreProductoEdit', isset($productoEdit) ? $productoEdit->nombre_producto : null, ['class' => 'form-control', 'id' => 'nombreProductoEdit', 'required' => 'required']) }}
                    </div>
                </div>
                {{-- =================== --}}
                <div class="col-12 col-md-5">
                    <div class="form-group d-flex flex-column">
                        <label for="categoriaEdit" class=""
                            style="font-size: 15px">Categoría<span
                                class="text-danger">*</span></label>
                        {!! Form::select(
                            'categoriaEdit',
                            collect(['' => 'Seleccionar...'])->union($categorias),
                            isset($productoEdit) ? $productoEdit->id_categoria : null,
                            ['class' => 'form-select select2', 'id' => 'categoriaEdit', 'required' => 'required'],
                        ) !!}
                    </div>
                </div>

                <div class="col-12 col-md-6 mt-md-3">
                    <div class="form-group d-flex flex-column">
                        <label for="proveedorEdit" class=""
                            style="font-size: 15px">Proveedor<span
                                class="text-danger">*</span></label>
                        {!! Form::select(
                            'proveedorEdit',
                            collect(['' => 'Seleccionar...'])->union($proveedores),
                            isset($productoEdit) ? $productoEdit->id_proveedor : null,
                            ['class' => 'form-select select2', 'id' => 'proveedorEdit', 'required' => 'required'],
                        ) !!}
                    </div>
                </div>
                {{-- =================== --}}
                <div class="col-12 col-md-6 mt-md-3">
                    <div class="form-group d-flex flex-column">
                        <label for="descripcionEdit" class=""
                            style="font-size: 15px">Descripción</label>
                        {{ Form::textarea('descripcionEdit', isset($productoEdit) ? $productoEdit->descripcion : null, ['class' => 'form-control', 'id' => 'descripcionEdit', 'rows' => 2, 'style' => 'resize: none;']) }}
                    </div>
                </div>
                {{-- =================== --}}

                <div class="col-12 col-md-6 mt-md-3">
                    <div class="form-group d-flex flex-column file-container">
                        <label for="imagen_producto" class="">Imagen
                            <span class="text-danger">(jpg, jpeg, png o webp.)</span>
                        </label>
                        <div class="div-file">
                            {!! Form::file('imagenProductoEdit', ['class' => 'form-control file', 'id' => 'imagenProductoEdit_' . $productoEdit->id_producto, 'onchange' => 'displaySelectedFile("imagenProductoEdit_' . $productoEdit->id_producto . '","selected_imagen_producto_' . $productoEdit->id_producto . '")',
                            'accept' => 'image/jpg,image/jpeg,image/png,image/webp']) !!}
                        </div>
                        <span id="selected_imagen_producto_{{ $productoEdit->id_producto }}" class="text-danger hidden"></span>
                    </div>
                </div>
                {{-- =================== --}}
                <div class="col-12 col-md-4 mt-md-3">
                    <div class="form-group d-flex flex-column">
                        <label for="precioUnitarioEdit" class=""
                            style="font-size: 15px">Precio Unitario<span
                                class="text-danger">*</span></label>
                        {{ Form::number('precioUnitarioEdit', isset($productoEdit) ? $productoEdit->precio_unitario : null, ['class' => 'form-control', 'id' => 'precioUnitarioEdit', 'required' => 'required']) }}
                    </div>
                </div>
                {{-- =================== --}}
                <div class="col-12 col-md-4 mt-md-3">
                    <div class="form-group d-flex flex-column">
                        <label for="precioDetalEdit" class=""
                            style="font-size: 15px">Precio Detal<span
                                class="text-danger">*</span></label>
                        {{ Form::number('precioDetalEdit', isset($productoEdit) ? $productoEdit->precio_detal : null, ['class' => 'form-control', 'id' => 'precioDetalEdit', 'required' => 'required']) }}
                    </div>
                </div>
                {{-- =================== --}}
                <div class="col-12 col-md-4 mt-md-3">
                    <div class="form-group d-flex flex-column">
                        <label for="precioPorMayorEdit" class=""
                            style="font-size: 15px">Precio x Mayor
                            <span class="text-danger">*</span>
                        </label>
                        {{ Form::number('precioPorMayorEdit', isset($productoEdit) ? $productoEdit->precio_por_mayor : null, ['class' => 'form-control', 'id' => 'precioPorMayorEdit', 'required' => 'required']) }}
                    </div>
                </div>
                {{-- =================== --}}
                <div class="col-12 col-md-4 mt-md-3">
                    <div class="form-group d-flex flex-column">
                        <label for="stockMinimoEdit" class=""
                            style="font-size: 15px">Stock Mínimo<span
                            class="text-danger">*</span></label>
                        {{ Form::number('stockMinimoEdit', isset($productoEdit) ? $productoEdit->stock_minimo : null, [
                            'class' => 'form-control', 
                            'id' => 'stockMinimoEdit', 
                            'required' => 'required',
                            'min' => 1,
                            'max' => 999999,
                            'oninput' => 'validity.valid||(value=\'\');',
                            'step' => '1',
                            'title' => 'El stock mínimo debe ser un número entero mayor o igual a 1',
                            'onkeypress' => 'return event.charCode >= 48 && event.charCode <= 57'
                            ]) }}
                    </div>
                </div>
                {{-- =================== --}}
                <div class="col-12 col-md-4 mt-md-3">
                    <div class="form-group d-flex flex-column">
                        <label for="referenciaEdit" class=""
                            style="font-size: 15px">Referencia<span
                                class="text-danger">*</span></label>
                        {{ Form::text('referenciaEdit', isset($productoEdit) ? $productoEdit->referencia : null, ['class' => 'form-control', 'id' => 'referenciaEdit', 'required' => 'required']) }}
                    </div>
                </div>
                {{-- =================== --}}
                <div class="col-12 col-md-4 mt-md-3">
                    <div class="form-group d-flex flex-column">
                        <label for="fechaVencimientoEdit" class=""
                            style="font-size: 15px">Fecha Vencimiento</label>
                        {{ Form::date('fechaVencimientoEdit', isset($productoEdit) ? $productoEdit->fecha_vencimiento : null, ['class' => 'form-control', 'id' => 'fechaVencimientoEdit','onkeydown' => 'return false']) }}
                    </div>
                </div>

                <div class="col-12 col-md-4 mt-md-3">
                    <div class="form-group d-flex flex-column">
                        <label for="id_umdEdit" class="">Unidad de Medida <span class="text-danger">*</span></label>
                        {!! Form::select('id_umdEdit',
                            collect(['' => 'Seleccionar...'])->union($umd),
                            isset($productoEdit) ? $productoEdit->id_umd : null, [
                            'class' => 'form-select select2',
                            'id' => 'id_umdEdit',
                            'required' => 'required',
                        ]) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ====================================================== --}}
    {{-- ====================================================== --}}

    <!-- Contenedor para el GIF -->
    <div id="loadingIndicatorEditProducto_{{ $productoEdit->id_producto }}"
        class="loadingIndicator">
        <img src="{{ asset('imagenes/loading.gif') }}"
            alt="Procesando...">
    </div>

    {{-- ====================================================== --}}
    {{-- ====================================================== --}}

    <div class="d-flex justify-content-center mt-3">
        <button type="submit" title="Modificar"
            class="btn btn-success me-3"
            id="btn_editar_producto_{{ $productoEdit->id_producto }}">
            <i class="fa fa-floppy-o" aria-hidden="true"> Modificar</i>
        </button>

        <button type="button" title="Cancelar" class="btn btn-secondary"
            data-bs-dismiss="modal"
            id="btn_cancelar_producto_{{ $productoEdit->id_producto }}">
            <i class="fa fa-remove" aria-hidden="true"> Cancelar</i>
        </button>
    </div>
{!! Form::close() !!}
{{-- FINAL Modal MODIFICAR PRODUCTO --}}
