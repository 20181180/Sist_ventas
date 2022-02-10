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
            <label>Telefono *</label>
            <input type="text" wire:model.lazy="phone" class="form-control" placeholder="ej: 231 423 5798" maxlength="10">
            @error('phone')
            <span class="text-danger er">{{$message}}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Email *</label>
            <input type="text" wire:model.lazy="email" class="form-control" placeholder="ej: ejemplo@ejemplo.com">
            @error('email')
            <span class="text-danger er">{{$message}}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Contraseña *</label>
            <input type="password"  wire:model.lazy="password" class="form-control" placeholder="ej: ********">
            @error('password')
            <span class="text-danger er">{{$message}}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Estatus *</label>
            <select wire:model.lazy='status' name="" class="form-control">
                <option value="Elegir" selected>Elegir</option>
                <option value="Active" selected>Activo</option>
                <option value="Locked" selected>Bloqueado</option>
            </select>
            @error('status')<span class="text-danger er">{{$message}}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Asignar Rol *</label>
            <select wire:model='profile' name="" class="form-control">
                <option value="Elegir" selected>Elegir</option>
                @foreach ($roles as $role)
                <option value="{{$role->name}}" selected>{{$role->name}}</option>
                @endforeach
            </select>
            @error('profile')<span class="text-danger er">{{$message}}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group custom-file">

            <input  type="file" required class="custom-file-input form-control"
             wire:model="image" accept="image/x-png, image/git, image/jpeg">

            <label class="custom-file-label"> Imagen de Perfil {{$image}}</label>
            @error('image')
            <span class="text-danger er">{{$message}}</span>
            @enderror
        </div>
    </div>


</div>
@include('commont.modalFooter')
