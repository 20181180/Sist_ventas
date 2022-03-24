@include('commont.modalHead')
<div class="row">
    <div class="col-sm-12 col-md-8">
        <div class="form-group">
            <label>Nombre *</label>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej: producto">
            @error('name')
            <span class="text-danger er">{{$message}}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Codigo barras *</label>
            <input type="text" wire:model.lazy="barcode" class="form-control" placeholder="ej: 46545564">
            @error('barcode')
            <span class="text-danger er">{{$message}}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Costo *</label>
            <input type="number" wire:model="cost" class="form-control" placeholder="ej: 0.00">
            @error('cost')
            <span class="text-danger er">{{$message}}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Precio Menudeo *</label>
            <input type="number" wire:model.lazy="price" value=" {{$price}} " class="form-control" disabled>
            @error('price')
            <span class="text-danger er">{{$message}}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Precio Mayoreo *</label>
            <input type="number" data-type="currency" wire:model.lazy="price_m" value="{{$price_m}}" class="form-control" disabled>
            @error('price_m')
            <span class="text-danger er">{{$message}}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Stock *</label>
            <input type="number" wire:model.lazy="stock" class="form-control" placeholder="ej: 0">
            @error('stock')
            <span class="text-danger er">{{$message}}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Alertas / Inv. Min *</label>
            <input type="number" wire:model.lazy="alerts" class="form-control" placeholder="ej: 0">
            @error('alerts')
            <span class="text-danger er">{{$message}}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Categoria *</label>
            <select wire:model='categoryid' name="" class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                @foreach ($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
            @error('categoryid')<span class="text-danger er">{{$message}}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-8">
        <div class="form-group custom-file">
            <input type="file" required class="custom-file-input form-control" wire:model="image" accept="image/x-png, image/git, image/jpeg">
            <label class="custom-file-label"> Imagen {{$image}}</label>
            @error('image')
            <span class="text-danger er">{{$message}}</span>
            @enderror
        </div>
    </div>

</div>
@include('commont.modalFooter')