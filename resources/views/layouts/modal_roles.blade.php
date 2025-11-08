{{-- INICIO Modal Crear Roles --}}
<div class="modal fade" id="modal_crear_roles"
    tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-3">
            <div class="rounded-top" style="border: solid 1px #337AB7;">
                <div class="rounded-top text-white text-center" 
                        style="background-color: #337AB7; border: solid 1px #337AB7;">
                    <h5>Creación de Roles</h5>
                </div>

                {!! Form::open(['method' => 'POST', 'route' => ['crear_rol'],
                                'class' => 'm-0 p-0', 'autocomplete' => 'off',
                                'id' => 'formCrearRol',
                            ]) !!}
                @csrf
                    <div class="modal-body p-0 m-0">
                        <div class="row m-0 pt-4 pb-4">

                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-md-offset-3">
                                <div class="form-group d-flex flex-column">
                                    <label for="nombre_role" class="" 
                                            style="font-size: 15px">Nombre Rol <span class="text-danger">*</span></label>
                                    {{ Form::text('role', null, ['class'=>'form-control', 'id'=>'role', 
                                            'placeholder'=>'Ingrese el Rol', 'required'])}}
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">

                        <div id="loadingIndicatorStore" class="loadingIndicator">
                            <img src="{{asset('imagenes/loading.gif')}}" alt="Procesando...">
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            <button type="submit" class="btn btn-success btn-sm me-3" title="Guardar Rol" id="btn_crear_rol">
                                <i class="fa fa-floppy-o"> Guardar</i>
                            </button>

                            <button type="button" class="btn btn-secondary btn-sm" title="Cancelar" data-bs-dismiss="modal" id="btn_cancelar_rol">
                                <i class="fa fa-close"> Cancelar</i>
                            </button>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
{{-- FINAL Modal Crear Roles --}}