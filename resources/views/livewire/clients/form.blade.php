@include('commont.modalHead')
<div class="row">
    <div class="col-sm-12 col-md-6">
        <label>NOMBRE DEL CLIENTES*</label>
        <div class="input-group">
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej:Norma Hernandez" maxlength="25">
        </div>
        @error('name')
        <span class="text-danger er">{{$message}}</span>
        @enderror
    </div>

    <div class="col-sm-12 col-md-6">
        <label>DIRECCION *</label>
        <div class="input-group">
            <input type="text" wire:model.lazy="direc" class="form-control" placeholder="ej: Huejutla " maxlength="25">
        </div>
        @error('direc')
        <span class="text-danger er">{{$message}}</span>
        @enderror
    </div>
    <div class="col-sm-12 col-md-6">
        <label>TELEFONO *</label>
        <div class="input-group">
            <input type="tel" wire:model.lazy="tel" class="form-control" placeholder="7711.." maxlength="25">
        </div>
        @error('tel')
        <span class="text-danger er">{{$message}}</span>
        @enderror
    </div>
    <div class="col-sm-12 col-md-6">
        <label>CORREO ELECTRONICO *</label>
        <div class="input-group">
            <input type="email" wire:model.lazy="correo" class="form-control" placeholder="nombre@gmail.com *" maxlength="25">
        </div>
        @error('correo')
        <span class="text-danger er">{{$message}}</span>
        @enderror
    </div>
</div>

@include('commont.modalFooter')