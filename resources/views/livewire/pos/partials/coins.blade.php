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
                <h6 class="mb-2">CLIENTES <span class="text-danger er"> <a href="{{url('Client')}}">Registrar Nuevo</a></span></h6>
                <div class="form-group">

                    <select wire:model='client_id' name="" class="form-control" required>

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

                        <option value="0">Pago en efectivo</option>
                        <option value="1">A Credito</option>
                        <option value="2">Tarjeta de credito</option>
                        <option value="3">Meripuntos</option>
                    </select>
                    @error('client_id')<span class="text-danger er">{{$message}}</span>@enderror
                </div>
            </div>

            <div class="connect-sorting-content mt-4">
                <div class="card simple-title-task ui-sortable-handle">
                    <div class="card-body">
                        @if($tipopago==0)
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
                        @elseif($tipopago==1)
                        <div class="input-group input-group-md mb-3">

                            <div class="input-group-prepend">
                                <button wire:click.prevent="Abonar({{$efectivo}})" class="btn btn-dark btn-block den">Abonar $:</button>
                            </div>

                            <input type="number" id="cash" wire:model="efectivo" placeholder="$0.00" class="form-control text-center" value="{{$efectivo}}">


                            <div class="input-group-append">
                                <span wire:click="$set('efectivo', 0)" class="input-group-text" style="background: #3B3F5C;color:white">
                                    <i class="fas fa-backspace fa-2x"></i>
                                </span>

                            </div>
                        </div>
                        @if ($efectivo > 0)
                        <h4 class="text-muted">Resta: ${{number_format($change,2)}}</h4>
                        <!-- <div class="row justify-content-between">

                            <div class="col-sm-12 col-md-12 col-lg-6">

                                <button wire:click.prevent="saveSale" class="btn btn-dark btn-block">
                                    GUARDAR </button>

                            </div>

                        </div> -->
                        @else
                        <h4 class="text-muted">Resta: $</h4>

                        @endif
                        <!-- este es el de tarjeta de credito -->

                        @endif
                        <!-- aqui termnina tarjeta credito -->

                        <div class="row justify-content-between">
                            <div class="col-sm-12 col-md-12 col-lg-6">

                                @if ($total> 0)
                                <button onclick="Confirm('','clearCart','¿SEGURO DE ELIMINAR EL CARRITO?')" class="btn btn-dark mtmobile">
                                    CANCELAR
                                </button>
                                @endif
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-6">
                                @if ($tipopago==0 && $efectivo >= $total && $total > 0)
                                <button wire:click.prevent="saveSale" wire:click="" class="btn btn-dark btn-md btn-block">
                                    GUARDAR </button>
                                @endif
                                @if ($tipopago==1&&$efectivo >0)
                                <button wire:click.prevent="saveSale" class="btn btn-dark btn-md btn-block">
                                    Pago a Credito </button>
                                @endif
                                @if ($tipopago==2&&$total>0)
                                <button wire:click.prevent="saveSale" class="btn btn-dark btn-md btn-block">
                                    Pago Tarjeta </button>
                                @endif

                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12 mt-4">
                                <a class="btn btn-dark btn-block {{count($cart) <1 ? 'disabled' : '' }} {{$cangeo == 1 ? 'disabled' : '' }}" href="{{ url('cotizacion/pdf' . '/' . $total . '/'
                                 . $itemsQuantity) }}" target="_black">Generar cotizacion</a>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12 mt-4">
                                <a style="background: #F76E11" class="btn btn-dark btn-block {{$client_id ==5 ? 'disabled' : '' }} " wire:click.prevent="saveMeri">Canjear Puntos</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('modal-show', msg => {
            $('#Modal2').modal('show');
        });
        window.livewire.on('modal-hide', msg => {
            $('#theModal2').modal('hide');
        });
        window.livewire.on('hidden.bs.modal', msg => {
            $('.er').css('display', 'none');
        });
        livewire.on('cotizacion', action => {
            $('#coti').val('');
        });
        livewire.on('print-ticket', ($idventa, $total, $items) => {
            // $('#theModal').modal('hide');

            window.open('uwu/pdf' + '/' + $idventa + '/' + $total + '/' + $items);
            //  url('cotizacion/pdf' . '/' . $total . '/'. $itemsQuantity)

        })
    })
</script>
