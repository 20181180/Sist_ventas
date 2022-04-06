<div wire:ignore.self class="modal fade" id="Modal2" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white text-center">
                    <b class="text-center">Agregar productos al stock</b>
                </h5>
                <h6 class="text-center text-warnig" style="color: white;" wire:loading>POR FAVOR ESPERE...</h6>
            </div>
            <br>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <label>NOMBRE DEL CLIENTE*</label>
                        <div class="input-group">
                            <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej:Norma Hernandez" disabled maxlength="25">
                        </div>
                        @error('name')
                        <span class="text-danger er">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <label>CANTIDAD EXISTENTE *</label>
                        <div class="input-group ">
                            <input type="text" wire:model.lazy="stock" class="form-control text-center" disabled maxlength="25">
                        </div>

                    </div>

                    <div class="col-sm-12 col-md-4">
                        <label> CANTIDAD A INGRESAR*</label>
                        <div class="input-group">
                            <input type="number" wire:model="stock_ing" class="form-control" placeholder="Ejemplo: 10" maxlength="23">
                        </div>
                        @error('stock_ing')
                        <span class="text-danger er">{{$message}}</span>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info" data-dismiss="modal">
                        CERRAR
                    </button>
                    @if($stock_ing > 0)
                    <button type="button" wire:click.prevent="goUpdate()" style="color:white" class="btn  btn-dark">
                        GUARDAR <i class="fas fa-coins" style="font-size:20px;"></i>
                    </button>
                    @endif
                </div>

            </div>
        </div>
    </div>