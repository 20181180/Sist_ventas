<div wire:ignore.self class="modal fade" id="theModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white text-center">
                    <b class="text-center">FORMULARIO DE BUSQUEDA</b>
                </h5>
                <h6 class="text-center text-warnig" wire:loading>POR FAVOR ESPERE...</h6>
            </div>
            <br>
            @include('commont.searchbox')
            <div class="modal-body">
                <div class="widget-content">
                    <select wire:model='Modaltipo_precio' name="" class="form-control">
                        <option value="0" >Precio unitario</option>
                        <option value="1">Precio Mayoreo</option>
                        @role('Admin')<option value="2">Costo</option>@endcan
                    </select>
                    <div class="table-responsive">

                        <table class="table tblscroll table-bordered table-striped  mt-1">
                            <thead class="text-white" style="background: #2666CF">
                                <tr>
                                    <th class="table-th text-white text-center">NOMBRE</th>
                                    <th class="table-th text-white">IMAGEN</th>
                                    <th class="table-th text-white text-center">CODIGO BARRA</th>
                                    <th class="table-th text-white text-center">PRECIO</th>
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
                                    <td>
                                        @if($Modaltipo_precio==1)
                                            <h6 class="text-center">${{$product->price_mayoreo}}</h6>
                                        @elseif($Modaltipo_precio==2)
                                        <h6 class="text-center">${{$product->cost}}</h6>
                                        @elseif($Modaltipo_precio==0)
                                        <h6 class="text-center">${{$product->price}}</h6>
                                        @endif

                                    </td>
                                    <td class="text-center">
                                        <input type="number" id="r{{$product->id}}" wire:keydown.enter.prevent="ScanCode('{{$product->barcode}}',$('#r' + '{{$product->id}}').val())" style="width:28%;height: 35px;" class="rounded" >

                                        <a href="javascript:void(0);" type="text"  wire:click.prevent="ScanCode('{{$product->barcode}}','1')" class="btn btn-dark mtmobile" title="Edit">
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
            livewire.on('scan-ok', action => {
            $('#r').val('1');
            });
            /* window.livewire.on('category-added', msg => {
                 $('#theModal').modal('hide');
             });
             window.livewire.on('category-updated', msg => {
                 $('#theModal').modal('hide');
             });*/
        });
    </script>
