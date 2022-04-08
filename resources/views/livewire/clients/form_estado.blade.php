<div wire:ignore.self class="modal fade" id="Modalesuwu" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white text-center">
                    <b class="text-center">FORMULARIO DE ESTADO</b>
                </h5>
                <h6 class="text-center text-warnig" style="color: white;" wire:loading>POR FAVOR ESPERE...</h6>
            </div>
            <br>



            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <label>NOMBRE DEL CLIENTE*</label>
                        <div class="input-group">
                            <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej:Norma Hernandez" disabled maxlength="25">
                        </div>
                        @error('name')
                        <span class="text-danger er">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <label>DIRECCION *</label>
                        <div class="input-group">
                            <input type="text" wire:model.lazy="direc" class="form-control" placeholder="ej: Huejutla" disabled maxlength="25">
                        </div>
                        @error('direc')
                        <span class="text-danger er">{{$message}}</span>
                        @enderror
                    </div>
                    @if($saldo >= 1)
                    <div class="col-sm-12 col-md-6">
                        <label>SALDO DEUDA *</label>
                        <div class="input-group">
                            <input type="number" wire:model.lazy="saldo" class="form-control" disabled maxlength="23">
                        </div>
                        @error('saldo')
                        <span class="text-danger er">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <label>TIPO DE PAGO *</label>
                        <div class="form-group">

                            <select wire:model='tipopago' name="" class="form-control" required>
                                <option value="0" disabled>ElEGIR</option>
                                <option value="1">ABONAR</option>
                                <option value="2">LIQUIDAR</option>

                            </select>
                            @error('client_id')<span class="text-danger er">{{$message}}</span>@enderror
                        </div>
                    </div>
                    @else
                    <div class="col-sm-12 col-md-10">
                        <br>
                        <br>
                        <h5 class="text-center">!! POR EL MOMENTO NO CUENTA CON ESTA INACTIVO LO SENTIMOS ..¡¡</h5>
                    </div>
                    @endif

                    @if($tipopago==1)
                    <div class="col-sm-12 col-md-6">
                        <label>CANTIDAD A ABONAR *</label>
                        <div class="input-group">
                            <input type="number" wire:model.lazy="efectivo" class="form-control" placeholder="Digite el monto a abonar" maxlength="23">
                        </div>
                        @error('saldo')
                        <span class="text-danger er">{{$message}}</span>
                        @enderror
                    </div>
                    @endif
                </div>

                <div class="modal-footer">
                    <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info" data-dismiss="modal">
                        CERRAR
                    </button>

                </div>

            </div>
        </div>
    </div>