<div wire:ignore.self class="modal fade" id="Modal2" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white text-center">
                    <b class="text-center">BUSCAR COTIZACION</b>
                </h5>
                <h6 class="text-center text-warnig" wire:loading>POR FAVOR ESPERE...</h6>
            </div>
            <br>
            <div class="row justify-content-between">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text input-gp">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                        <input type="text" wire:model="searchD" placeholder="Busca algo aqui" class="form-control">
                    </div>
                </div>
            </div>

            <div class="modal-body">
                <div class="widget-content">

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped  mt-1">
                            <thead class="text-white" style="background: #2666CF">
                                <tr>
                                    <th class="table-th text-white text-center">NOMBRE</th>
                                    <th class="table-th text-white">IMAGEN</th>
                                    <th class="table-th text-white">CANTIDAD</th>
                                    <th class="table-th text-white text-center">AGREGAR</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cotiza as $product)
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
                                        <h6 class="text">{{$product->quantity}}</h6>
                                    </td>

                                    <td class="text-center">
                                        <a href="javascript:void(0);" type="text" wire:click.prevent="ScanCode({{$product->name}})" class="btn btn-dark mtmobile" title="Edit">
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