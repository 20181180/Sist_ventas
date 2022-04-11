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
                        <label>CORREO *</label>
                        <div class="input-group">
                            <input type="text" wire:model.lazy="correo" class="form-control" placeholder="ej: jj@gmail.com " disabled maxlength="50">
                        </div>
                        @error('direc')
                        <span class="text-danger er">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <label>ESTADO CLIENTE*</label>
                        <label class="check">
                            <input type="checkbox" wire:change="estadoClient($('#p' + {{$selected_id
                            }}).is(':checked'), {{ $selected_id }})"
                            id="p{{ $selected_id }}"
                            value="{{$selected_id}}"
                            class="new-control-input "
                            {{$estadoC == 'activo' ? 'checked' : ''}}
                            {{$saldo > 0 ? 'disabled' : ''}}
                            >
                              <span class="check-1"></span>
                          </label>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info" data-dismiss="modal">
                        CERRAR
                    </button>

                </div>

            </div>
        </div>
    </div>
