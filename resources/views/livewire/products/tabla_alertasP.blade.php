<div wire:ignore.self class="modal fade" id="ModalAlertas" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white text-center">
                    <b class="text-center">PRODUCTOS EN ALERTA DE STOCK</b>
                </h5>
                <h6 class="text-center text-warnig" style="color: white;" wire:loading>POR FAVOR ESPERE...</h6>
            </div>
            <br>
            <div class="widget-content">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <input type="text" wire:model="searchAlert" placeholder="Busca algo aqui" class="form-control">

                    </div>
                    <div class="col-sm-12 col-md-5 p-4">

                    </div>
                    <div class="col-sm">


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
                                    <th class="table-th text-white">STOCK</th>
                                    <th class="table-th text-white">INV MIN</th>
                                    <th class="table-th text-white text-center">ACCION</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if(count($productsA) == 0) <tr>
                                    <td colspan="6">
                                        <h6 class="text-center">
                                            No Hay Productos..
                                        </h6>
                                    </td>
                                </tr>
                                @endif


                                @foreach ($productsA as $product)
                                <tr>
                                    <td>
                                        <h6 class="text">{{$product->name}}</h6>
                                    </td>

                                    <td>
                                        <span>
                                            <img src=" {{asset('storage/' . $product->imagen )}}" onclick="ShowImg('{{ asset('storage/' . $product->imagen) }}','{{$product->name}}')" height="70" width="80" class="rounded zom" alt="no-image">
                                        </span>
                                    </td>
                                    <td>
                                        <h6 class="text">{{$product->barcode}}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text">{{$product->stock}}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text">{{$product->alerts}}</h6>
                                    </td>

                                    <td class="text-center">
                                        <input type="number" id="r{{$product->id}}" wire:change="goUpdate({{$product->id}}, $('#r' + {{$product->id}}).val())" style="width:28%;height: 35px;" class="rounded" >

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
