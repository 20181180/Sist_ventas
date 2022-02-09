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
                                <h5>X</h5>
                            </div>
                        </div>

                        @if ($efectivo >= $total && $total > 0)
                        <h4 class="text-muted">Cambio: ${{number_format($change,2)}}</h4>
                        <h4 class="text-muted">Meripuntos:{{$puntos}}</h4>
                        @else
                        <h4 class="text-muted">Cambio: $0.00</h4>
                        <h4 class="text-muted">Meripuntos:$0.00</h4>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--comentario-->