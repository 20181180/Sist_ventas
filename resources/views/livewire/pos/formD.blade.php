<div wire:ignore.self class="modal fade" id="Modal2" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white text-center">
                    <b class="text-center">CANJEAR MERIPUNTOS</b>
                </h5>
                <h6 class="text-center text-warnig" style="color: white;" wire:loading>POR FAVOR ESPERE...</h6>
            </div>
            <br>
            <div class="widget-content">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <h6 class="text">CLIENTES</h6>
                        <div class="form-group">
                            <select wire:model='client_id' class="form-control">
                                <option value="0" disabled>Elegir cliente</option>
                                @foreach ($clientes as $c)
                                <option value="{{$c->id}}">{{$c->name}}</option>
                                @endforeach
                            </select>
                            @error('client_id')<span class="text-danger er">{{$message}}</span>@enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-5 p-4">
                        @if($client_id >0)
                        <button wire:click.prevent="Consultar" style="background: #F78812;color:#fff" type="button" class="btn"> CONSULTAR </button>
                        @endif
                    </div>
                    <div class="col-sm">
                        <h5 class="text mt-3"> MERIPUNTOS:$ {{$puntos}}</h5>
                    </div>
                </div>
            </div>


            <div class="modal-body">
                <div class="widget-content">

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped  mt-1">
                            <thead class="text-white" style="background: #F58634">
                                <tr>
                                    <th class="table-th text-white text-center">NOMBRE</th>
                                    <th class="table-th text-white">IMAGEN</th>
                                    <th class="table-th text-white">CODIGO</th>
                                    <th class="table-th text-white text-center">ACCION</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if(count($datosxd) == 0) <tr>
                                    <td colspan="5">
                                        <h6 class="text-center">
                                            No Hay Productos..
                                        </h6>
                                    </td>
                                </tr>
                                @endif


                                @foreach ($datosxd as $product)
                                <tr>
                                    <td>
                                        <h6 class="text">{{$product->name}}</h6>
                                    </td>

                                    <td>
                                        <span>
                                            <img src=" {{asset('storage/' . $product->imagen )}}" height="70" width="80" class="rounded zom" alt="no-image">
                                        </span>
                                    </td>
                                    <td>
                                        <h6 class="text">{{$product->barcode}}</h6>
                                    </td>

                                    <td class="text-center">
                                        <a href="javascript:void(0);" type="text" wire:click.prevent="decreaseMeri({{$product->id}})" class="btn btn-dark mtmobile" title="Edit">
                                            <i class="fas fa-minus"></i>
                                        </a>
                                        <a href="javascript:void(0);" type="text" wire:click.prevent="$emit('Canjear',{{$product->barcode}})" class="btn btn-dark mtmobile" title="Edit">
                                            <i class="fa fa-cart-plus"></i>
                                        </a>
                                    </td>
                                </tr>

                                @endforeach
                            </tbody>
                        </table>

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