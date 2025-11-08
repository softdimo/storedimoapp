{{-- INICIO Modal Crear Permisos --}}
<div class="modal fade" id="modal_crear_permiso"
    tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-3">
            <div class="rounded-top" style="border: solid 1px #337AB7;">
                <div class="rounded-top text-white text-center" 
                        style="background-color: #337AB7; border: solid 1px #337AB7;">
                    <h5>Creación de Permisos</h5>
                </div>

                {!! Form::open(['method' => 'POST', 'route' => ['crear_permiso'],
                                'class' => 'm-0 p-0', 'autocomplete' => 'off',
                                'id' => 'formCrearPermiso',
                            ]) !!}
                @csrf
                    <div class="modal-body p-0 m-0">
                        <div class="row m-0 pt-4 pb-4">

                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-md-offset-3">
                                <div class="form-group d-flex flex-column">
                                    <label for="nombre_role" class=""
                                            style="font-size: 15px">Nombre Permiso <span class="text-danger">*</span></label>
                                    {{ Form::text('permission', null, ['class'=>'form-control', 'id'=>'permission', 
                                            'placeholder'=>'Ingrese el Permiso', 'required'])}}
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">

                        <div id="loadingIndicatorStore" class="loadingIndicator">
                            <img src="{{asset('imagenes/loading.gif')}}" alt="Procesando...">
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            <button type="submit" class="btn btn-success btn-sm me-3" title="Guardar Rol" id="btn_crear_permiso">
                                <i class="fa fa-floppy-o"> Guardar</i>
                            </button>

                            <button type="button" class="btn btn-secondary btn-sm" title="Cancelar" data-bs-dismiss="modal" id="btn_cancelar_permiso">
                                <i class="fa fa-close"> Cancelar</i>
                            </button>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
{{-- FINAL Modal Crear Permisos --}}