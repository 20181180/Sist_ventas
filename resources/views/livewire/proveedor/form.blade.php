@include('commont.modalHead')
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
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej:Norma Hernandez" maxlength="25">
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

@include('commont.modalFooter')