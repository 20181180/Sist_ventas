<div wire:ignore.self class="modal fade" id="ModalProveedores" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>Proveedor</b>| Crear
                </h5>
                <h6 class="text-center text-warnig" wire:loading>POR FAVOR ESPERE...</h6>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <label>NOMBRE*</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <span class="fas fa-edit">
                                    </span>
                                </span>
                            </div>
                            <input type="text" wire:model.lazy="prov" class="form-control" placeholder="ej:Norma Hernandez" maxlength="25">
                        </div>
                        @error('name')
                        <span class="text-danger er">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <label>DIRECCION *</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <span class="fas fa-edit">
                                    </span>
                                </span>
                            </div>
                            <input type="text" wire:model.lazy="direc" class="form-control" placeholder="ej:Huejutla" maxlength="25">
                        </div>
                        @error('direc')
                        <span class="text-danger er">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label>TELEFONO *</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <span class="fas fa-edit">
                                    </span>
                                </span>
                            </div>
                            <input type="text" wire:model.lazy="tel" class="form-control" placeholder="ej:7711.." maxlength="25">
                        </div>
                        @error('tel')
                        <span class="text-danger er">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label>EMPRESA *</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <span class="fas fa-edit">
                                    </span>
                                </span>
                            </div>
                            <input type="text" wire:model.lazy="empresa" class="form-control" placeholder="ej:voltec" maxlength="25">
                        </div>
                        @error('empresa')
                        <span class="text-danger er">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click.prevent="resetpro()" class="btn btn-dark close-btn text-info" data-dismiss="modal">
                        CERRAR
                    </button>

                    <button type="button" wire:click.prevent="Proveedor()" class="btn btn-dark close-modal">
                        GUARDAR
                    </button>


                </div>
            </div>
        </div>
    </div>