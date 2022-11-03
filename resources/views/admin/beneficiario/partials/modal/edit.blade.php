
<div class="modal fade" id="ModulosEdit" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
    <div class="modal-dialog modal-centered modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalgridLabel">Grid Modals</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="main-form" >
                 
                     <input type="hidden" id="_token" value="{{ csrf_token() }}">
                                        <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group mt-1">
                      <label>Titular</label>
                      <input type="text" disabled class="form-control" id="titular_form">
                    </div>
                  </div>
                    <div class="col-lg-4">
                        <div class="form-group mt-3">
                            <label>Nombres</label>
                             <input type="text" name="tx_nombres" class="form-control input-sm" placeholder="Ingresa los nombres " id="tx_nombres_titular">
                             <span class="missing_alert text-danger" id="tx_nombres_alert"></span>
                        </div>
                    </div>
                  <div class="col-lg-4">
                      <div class="form-group mt-3">
                      <label>Apellidos</label>
                       <input type="text" name="tx_apellidos" class="form-control input-sm" placeholder="Ingresa los apellidos" id="tx_apellidos_titular">
                       <span class="missing_alert text-danger" id="tx_apellidos_alert"></span>
                    </div> 
                  </div>
                  <div class="col-lg-4">
                      <div class="form-group mt-3">
                      <label>Cédula</label>
                       <input type="text" name="cedula" class="form-control input-sm" placeholder="Ingresa la cédula " id="nu_cedula_titular">
                       <span class="missing_alert text-danger" id="nu_cedula_alert"></span>
                    </div>
                  </div>
                   <div class="col-lg-12 text-center">
                      <div class="form-group mt-4">
                      <label for="status">Estado del beneficiario</label>
                      <div class="checkbox icheck">
                        <label>
                          <input type="radio" name="status" value="1" checked> Activo&nbsp;&nbsp;
                          <input type="radio" name="status" value="0"> Deshabilitado
                        </label>
                      </div>
                    </div>
                  </div>

                </div>
                 <button type="submit" class="btn btn-primary float-right" id="boton">
                         <i class="float-left far fa-save text-white" id="ajax-icon"></i> <span class="text-white ml-1">{{ __('Guardar datos') }}</span>
                         </button>   
                </form>
            </div>
        </div>
    </div>
</div>