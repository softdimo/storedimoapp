<div class="p-0" style="border: solid 1px #337AB7; border-radius: 5px 5px 0 0;">
    <h5 class="border rounded-top text-white text-center pt-2 pb-2 m-0" style="background-color: #337AB7">Registrar
        Productos (Obligatorios * )</h5>

        
    <div class="row m-0 p-3" id="div_campos_productos">

    <div class="col-12 col-md-3">
        <div class="form-group d-flex flex-column">
            <label for="id_proveedor" class="form-label">Proveedor <span class="text-danger">*</span></label>
            {!! Form::select('id_proveedor', collect(['' => 'Seleccionar...'])->union($proveedores), null, [
                'class' => 'form-select select2',
                'id' => 'id_proveedor',
                'required' => 'required',
            ]) !!}
        </div>
    </div>

    <div class="col-12 col-md-3">
        <div class="form-group d-flex flex-column">
            <label for="referencia" class="form-label">Referencia <span class="text-danger">*</span></label>
            {!! Form::text('referencia', null, [
                'class' => 'form-control',
                'id' => 'referencia',
                'required' => 'required',
                'pattern' => '^[a-zA-Z0-9\-_#]{2,50}$',
                'title' => 'La referencia debe tener entre 2 y 50 caracteres. Puede incluir letras, números y los caracteres especiales - _ #',
                'maxlength' => '50',
                'minlength' => '2'
            ]) !!}
            <small id="reference-error" class="text-danger d-none">Esta referencia ya existe.</small>
        </div>
    </div>

        <div class="col-12 col-md-3">
            <div class="form-group d-flex flex-column">
                <label for="nombre_producto" class="form-label">Nombre Producto <span class="text-danger">*</span></label>
                {!! Form::text('nombre_producto', null, [
                    'class' => 'form-control',
                    'id' => 'nombre_producto',
                    'required' => 'required',
                    'pattern' => '^[a-zA-ZÁÉÍÓÚáéíóúÑñ0-9\s\-_.,&()]{2,100}$',
                    'title' => 'El nombre del producto debe tener entre 2 y 100 caracteres. Puede incluir letras, números, espacios y algunos caracteres especiales como -_.,&()',
                    'maxlength' => '100',
                    'minlength' => '2'
                ]) !!}
            </div>
        </div>

        {{-- ======================= --}}

        <div class="col-12 col-md-3 d-flex align-items-end gap-2">
            <div class="form-group flex-grow-1">
                <label for="id_categoria" class="form-label">Categoría <span class="text-danger">*</span></label>
                {!! Form::select('id_categoria', collect(['' => 'Seleccionar...'])->union($categorias), null, [
                    'class' => 'form-select select2',
                    'id' => 'id_categoria',
                    'required' => 'required',
                ]) !!}
            </div>
            <button type="button" class="btn rounded-2 text-white h-90 px-2" style="background-color: #337AB7; margin-bottom: 1px"
                title="Crear Categoría" data-bs-toggle="modal"
                data-bs-target="#modal_crear_categoria">
                <i class="fa fa-plus plus"></i>
            </button>
        </div>

        {{-- ======================= --}}

        <div class="col-12 col-md-3 mt-3">
            <div class="form-group d-flex flex-column">
                <label for="precio_unitario" class="form-label">Precio Unitario <span
                        class="text-danger">*</span></label>
                {!! Form::number('precio_unitario', null, [
                    'class' => 'form-control',
                    'id' => 'precio_unitario',
                    'required' => 'required',
                    'min' => 0,
                    'oninput' => 'validity.valid||(value=\'\');',
                ]) !!}
            </div>
        </div>

        {{-- ======================= --}}

        <div class="col-12 col-md-3 mt-3">
            <div class="form-group d-flex flex-column">
                <label for="precio_detal" class="form-label">Precio al Detal <span class="text-danger">*</span></label>
                {!! Form::number('precio_detal', null, [
                    'class' => 'form-control',
                    'id' => 'precio_detal',
                    'required' => 'required',
                    'min' => 0,
                    'oninput' => 'validity.valid||(value=\'\');',
                ]) !!}
            </div>
        </div>

        {{-- ======================= --}}

        <div class="col-12 col-md-3 mt-3">
            <div class="form-group d-flex flex-column">
                <label for="precio_por_mayor" class="form-label">Precio al por Mayor <span
                        class="text-danger">*</span></label>
                {!! Form::number('precio_por_mayor', null, [
                    'class' => 'form-control',
                    'id' => 'precio_por_mayor',
                    'required' => 'required',
                    'min' => 0,
                    'oninput' => 'validity.valid||(value=\'\');',
                ]) !!}
            </div>
        </div>

        {{-- ======================= --}}

        <div class="col-12 col-md-3 mt-3">
            <div class="form-group d-flex flex-column">
                <label for="descripcion" class="form-label">Descripción</label>
                {!! Form::text('descripcion', null, [
                    'class' => 'form-control', 
                    'id' => 'descripcion',
                    'pattern' => '^[a-zA-ZÁÉÍÓÚáéíóúÑñ0-9\s\-_.,;:()&]{0,255}$',
                    'title' => 'La descripción puede incluir letras, números, espacios y caracteres especiales como -_.,;:()&. Máximo 255 caracteres.',
                    'maxlength' => '255'
                ]) !!}
            </div>
        </div>

        {{-- ======================= --}}

        <div class="col-12 col-md-3 mt-3" id="">
            <div class="form-group d-flex flex-column">
                <label for="stock_minimo" class="form-label">Stock Mínimo <span class="text-danger">*</span></label>
                {!! Form::number('stock_minimo', null, [
                    'class' => 'form-control',
                    'id' => 'stock_minimo',
                    'required' => 'required',
                    'min' => 1,
                    'max' => 999999,
                    'oninput' => 'validity.valid||(value=\'\');',
                    'step' => '1',
                    'title' => 'El stock mínimo debe ser un número entero mayor o igual a 1',
                    'onkeypress' => 'return event.charCode >= 48 && event.charCode <= 57'
                ]) !!}
            </div>
        </div>

        <div class="col-12 col-md-3 d-flex align-items-end gap-2">
            <div class="form-group flex-grow-1">
                <label for="id_umd" class="form-label">Unidad de Medida <span class="text-danger">*</span></label>
                {!! Form::select('id_umd', collect(['' => 'Seleccionar...'])->union($umd), null, [
                    'class' => 'form-select select2',
                    'id' => 'id_umd',
                    'required' => 'required',
                ]) !!}
            </div>

            <button type="button" class="btn rounded-2 text-white h-90 px-2" style="background-color: #337AB7; margin-bottom: 1px"
                title="Crear UMD" data-bs-toggle="modal"
                data-bs-target="#modalCrearUmd">
                <i class="fa fa-plus plus"></i>
            </button>
        </div>

        {{-- ======================= --}}

        <div class="col-12 col-md-3 mt-3" id="">
            <div class="form-group d-flex flex-column">
                <label for="fecha_vencimiento" class="form-label">Fecha Vencimiento</label>
                {!! Form::date('fecha_vencimiento', null, ['class' => 'form-control', 'id' => 'fecha_vencimiento']) !!}
            </div>
        </div>

        {{-- ======================= --}}

        <div class="col-12 col-md-3 mt-3">
            <div class="form-group d-flex flex-column file-container">
                <label for="imagen_producto" class="form-label">Imagen
                    <span class="text-danger">(jpg, jpeg, png o webp.)</span>
                </label>
                <div class="div-file">
                    {!! Form::file('imagen_producto', [
                        'class' => 'form-control file',
                        'id' => 'imagen_producto',
                        'onchange' => 'displaySelectedFile("imagen_producto","selected_imagen_producto")',
                        'accept' => 'image/jpg,image/jpeg,image/png,image/webp',
                    ]) !!}
                </div>
                <span id="selected_imagen_producto" class="text-danger hidden"></span>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- ========================================================= --}}
        {{-- ========================================================= --}}
        {{-- ========================================================= --}}

        <!-- Contenedor para el GIF -->
        <div id="loadingIndicatorCrearProducto" class="loadingIndicator">
            <img src="{{ asset('imagenes/loading.gif') }}" alt="Procesando...">
        </div>

        {{-- ====================================================== --}}
        {{-- ====================================================== --}}

        <div class="mt-5 mb-2 d-flex justify-content-center">
            <button type="submit" class="btn btn-success rounded-2 me-3">
                <i class="fa fa-floppy-o"></i>
                Guardar
            </button> 
        </div>
    </div> {{-- FIN div_campos_productos --}}
</div> {{-- FIN div_crear_productos --}}
