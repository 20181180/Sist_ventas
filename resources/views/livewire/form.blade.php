<div wire:ignore.self class="modal fade" id="modalxd" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white text-center">
                    <b class="text-center"> FORMULARIO DE BUSQUEDA</b>
                </h5>
                <h6 class="text-center text-warnig" wire:loading>POR FAVOR ESPERE...</h6>
            </div>
            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-8">
                        <div class="form-group">
                            <label>Nombre de la empresa *</label>
                            <input type="text" wire:model.lazy="empresa" class="form-control" title="Nombre de Oficial.">
                            @error('empresa')
                            <span class="text-danger er">{{$message}}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>Correo electronico *</label>
                            <input type="email" wire:model.lazy="correo" class="form-control" title="Ingrese el correo de la empresa.">
                            @error('correo')
                            <span class="text-danger er">{{$message}}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>Telefono *</label>
                            <input type="tel" wire:model="tel" title="Telefono de la empresa" class="form-control">
                            @error('tel')
                            <span class="text-danger er">{{$message}}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>Facebook *</label>
                            <input type="text" wire:model.lazy="face" title="Red social" class="form-control">
                            @error('face')
                            <span class="text-danger er">{{$message}}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>Ubicacion *</label>
                            <input type="text" wire:model.lazy="direc" class="form-control" title="Donde se encuentra la empresa">
                            @error('direc')
                            <span class="text-danger er">{{$message}}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>Codigo Postal *</label>
                            <input type="number" wire:model.lazy="cp" class="form-control" title="Codigo al que pertenece el lugar.">
                            @error('cp')
                            <span class="text-danger er">{{$message}}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="col-sm-12 col-md-8">
                        <label>Cargar imagen *</label>
                        <div class="form-group custom-file">
                            <input id="fileName" type="file" required class="custom-file-input form-control" wire:model="image" accept="image/png, image/jpeg">
                            <label class="custom-file-label"> Imagen</label>
                            @error('image')
                            <span class="text-danger er">{{$message}}</span>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info" data-dismiss="modal">
                        CERRAR
                    </button>
                    <button type="button" wire:click.prevent="Store()" class="btn btn-dark close-modal">
                        GUARDAR
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /* window.livewire.on('category-added', msg => {
                 $('#theModal').modal('hide');
             });
             window.livewire.on('category-updated', msg => {
                 $('#theModal').modal('hide');
             });*/
        });
    </script>