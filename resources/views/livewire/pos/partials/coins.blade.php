<div class="row mt-3">
    <div class="col-sm-12">
        <div class="connect-sorting">

            <h5 class="text-center mb-2">DENOMINACIONES</h5>
            <div class="container">
                <div class="row">
                    @foreach ($denominations as $d)
                    <div class="col-sm mt-2">
                        <button wire:click.prevent="ACash({{$d->value}})" class="btn btn-dark btn-block den">
                            {{ $d->value >0 ? '$' . number_format($d->value,2, '.', '') : 'Exacto'}}
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-3">
                <h6 class="mb-2">CLIENTES</h6>
                <div class="form-group">

                    <select wire:model='client_id' name="" class="form-control" required>
                        <option value="0" disabled>Elegir</option>
                        @foreach ($clientes as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </select>
                    @error('client_id')<span class="text-danger er">{{$message}}</span>@enderror
                </div>
            </div>
            <div class="mt-3">
                <h6 class="mb-2">TIPO DE PAGO</h6>
                <div class="form-group">

                    <select wire:model='tipopago' name="" class="form-control" required>
                        <option value="0" disabled>Tipo de pago</option>
                        <option value="1">Tarjeta de credito</option>
                        <option value="2">A Credito</option>
                    </select>
                    @error('client_id')<span class="text-danger er">{{$message}}</span>@enderror
                </div>
            </div>

            <div class="connect-sorting-content mt-4">
                <div class="card simple-title-task ui-sortable-handle">
                    <div class="card-body">
                        <div class="input-group input-group-md mb-3">

                            <div class="input-group-prepend">
                                <button wire:click.prevent="ACashAmano({{$efectivo}})" class="btn btn-dark btn-block den">
                                    Efectivo$:
                                </button>
                            </div>

                            <input type="number" id="cash" wire:model="efectivo" placeholder="$0.00" class="form-control text-center" value="{{$efectivo}}">


                            <div class="input-group-append">
                                <span wire:click="$set('efectivo', 0)" class="input-group-text" style="background: #3B3F5C;color:white">
                                    <i class="fas fa-backspace fa-2x"></i>
                                </span>

                            </div>
                        </div>

                        @if ($efectivo >= $total && $total > 0)
                        <h4 class="text-muted">Cambio: ${{number_format($change,2)}}</h4>

                        @else
                        <h4 class="text-muted">Cambio: $0.00</h4>

                        @endif
                        <div class="row justify-content-between">
                            <div class="col-sm-12 col-md-12 col-lg-6">

                                @if ($total> 0)
                                <button onclick="Confirm('','clearCart','¿SEGURO DE ELIMINAR EL CARRITO?')" class="btn btn-dark mtmobile">
                                    CANCELAR C
                                </button>
                                @endif
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-6">
                                @if ($efectivo >= $total && $total > 0)
                                <button wire:click.prevent="saveSale" class="btn btn-dark btn-md btn-block">
                                    GUARDAR Zs </button>
                                @endif
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12 mt-4">
                                <a class="btn btn-dark btn-block {{count($cart) <1 ? 'disabled' : '' }} {{$cangeo == 1 ? 'disabled' : '' }}" href="{{ url('cotizacion/pdf' . '/' . $total . '/'
                                 . $itemsQuantity) }}" target="_black">Generar cotizacion</a>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12 mt-4">
                                <a style="background: #F76E11" class="btn btn-dark btn-block {{$client_id <1 ? 'disabled' : '' }} " wire:click.prevent="saveMeri">Canjear Puntos</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--comentario-->