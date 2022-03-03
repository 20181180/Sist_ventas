<div wire:ignore.self class="modal fade" id="theModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white text-center">
                    <b class="text-center"> FORMULARIO DE BUSQUEDA</b>
                </h5>
                <h6 class="text-center text-warnig" wire:loading>POR FAVOR ESPERE...</h6>
            </div>
            <br>
            @include('commont.searchbox')
            <div class="modal-body">

                <div class="widget-content">

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped  mt-1">
                            <thead class="text-white" style="background: #2666CF">
                                <tr>
                                    <th class="table-th text-white text-center">NOMBRE</th>
                                    <th class="table-th text-white">IMAGEN</th>
                                    <th class="table-th text-white text-center">CODIGO BARRA</th>
                                    <th class="table-th text-white text-center">AGREGAR</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)

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
                                        <h6 class="text-center">{{$product->barcode}}</h6>
                                    </td>

                                    <td class="text-center">
                                        <a href="javascript:void(0);" type="text" wire:click.prevent="ScanCode({{$product->barcode}})" class="btn btn-dark mtmobile" title="Edit">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /* window.livewire.on('category-added', msg => {
                 $('#theModal').modal('hide');
             });
             window.livewire.on('category-updated', msg => {
                 $('#theModal').modal('hide');
             });*/
        });
    </script>