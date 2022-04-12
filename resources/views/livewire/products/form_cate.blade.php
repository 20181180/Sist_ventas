<div wire:ignore.self class="modal fade" id="theModalCate" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>Categoria</b>| Crear
                </h5>
                <h6 class="text-center text-warnig" wire:loading>POR FAVOR ESPERE...</h6>
            </div>
            <div class="modal-body">



<div class="row">

    <div class="col-sm-12">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <span class="fas fa-edit">

                    </span>
                </span>

            </div>
            <input type="text" wire:model.lazy="namecate" class="form-control" placeholder="ej: Categoria">
        </div>
        @error('namecate')
        <span class="text-danger er">{{$message}}</span>
        @enderror
    </div>

    <div class="col-sm-12 mt-3">
        <div class="form-group custom-file">
            <input type="file" class="custom-file-input form-control" wire:model="imagecate" accept="image/x-png, image/gif, image/jpeg">
            <label class="custom-file-label"> Imagen {{$imagecate}}</label>
            @error('imagecate')
            <span class="text-danger er">{{$message}}</span>
            @enderror
        </div>
    </div>

</div>

<div class="modal-footer">
    <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info" data-dismiss="modal">
        CERRAR
    </button>

    <button type="button" wire:click.prevent="Cate()" class="btn btn-dark close-modal">
        GUARDAR
    </button>


</div>
</div>
</div>
</div>
