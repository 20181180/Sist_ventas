<div class="connect-sorting">


    <div class="connect-sorting-content">

        <div class="card simple-title-task ui-sortable-handle">
            <div class="widget-heading">
                <ul class="tabs tab-pills">
                    <li><a href="javascript:void(0);" class="tabmenu " style="background-color: #2666CF;" data-toggle="modal" data-target="#theModal">Agregar</a></li>
                </ul>
            </div>

            <div class="card-body">
                <div class="form-inline">
                    @if($cheked==0)
                    <button wire:click.prevent="SyncAll()" type="button" class="btn btn-dark mbmobile inblock mr-5 {{count($cart) <1 ? 'disabled' : '' }} ">Sincronizar Todos</button>
                    @else
                    <button wire:click.prevent="SyncDel()" type="button" class="btn btn-dark mbmobile  mr-5 {{count($cart) <1 ? 'disabled' : '' }} ">Revocar Todos</button>
                    @endif
                </div>
                <br>


                @if ($total > 0)
                <div class="table-responsive tblscroll" style="max-height: 650px; overflow:hidden">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th width="10%" class="table-th text-white">Mayoreo</th>
                                <th class="table-th text-left text-white">Imagen</th>
                                <th class="table-th text-left text-white">DESCRIPCION</th>
                                <th class="table-th text-center text-white">PRECIO</th>
                                <th width="13%" class="table-th text-center text-white">CANTIDAD</th>
                                <th class="table-th text-center text-white">IMPORTE</th>
                                <th class="table-th text-center text-white">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart as $item)
                            <tr>
                                <td class="text-center">
                                    <div class="n-check">
                                        <label class="new-control new-checkbox checkbox-primary">
                                            <input type="checkbox" wire:change="SyncPermiso($('#p' + {{$item->id
                                            }}).is(':checked'), '{{$item->id}}')" id="p{{ $item->id }}" value="{{$item->id}}" class="new-control-input" {{$cheked == 1 ? 'checked' : ''}}>
                                            <span class="new-control-indicator"></span>
                                            <h6>M</h6>
                                        </label>
                                    </div>
                                </td>
                                <td class="text-center table-th">
                                    @if (count($item->attributes) > 0)
                                    <span>
                                        <img class="zom" src="{{ asset('storage/products/' . $item->attributes[0]) }}" alt="imagen de items" height="90" width="90" class="rounded">
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    <h6>{{$item->name}}</h6>
                                </td>
                                <td class="text-center">${{number_format($item->price,2)}}</td>
                                <td>
                                    <input type="number" id="r{{$item->id}}" wire:change="updateQty({{$item->id}},$('#p' + {{$item->id}}).is(':checked'), $('#r' + {{$item->id}}).val())" style="font-size: 1rem!important" class="form-control text-center" value="{{$item->quantity}}">
                                </td>
                                <td class="text-center">
                                    <h6>
                                        ${{number_format($item->price * $item->quantity, 2)}}
                                    </h6>
                                </td>
                                <td class="text-center">
                                    <button onclick="Confirm('{{$item->id}}', 'removeItem', '¿CONFIRMAS ELIMINAR EL REGISTRO?')" class="btn btn-dark mbmobile">
                                        <i class="fas fa-trash-alt"> </i>
                                    </button>
                                    <button wire:click.prevent="decreaseQty({{$item->id}})" class="btn btn-dark mbmobile">
                                        <i class="fas fa-minus"> </i>
                                    </button>
                                    <button id="p{{$item->id}}" wire:click.prevent="increaseQty({{$item->id}},$('#p' + {{$item->id
                                    }}).is(':checked'))" class="btn btn-dark mbmobile">
                                        <i class="fa fa-cart-plus"></i>
                                    </button>
                                </td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <h5 class="text-center text-muted">Agregar items a la venta</h5>
                @endif

                <div wire:loading.inline wire:target="saveSale">
                    <h4 class="text-danger text-center">
                        Procesando venta, espere un momento...
                    </h4>
                </div>

            </div>
        </div>
    </div>
    @include('livewire.pos.form')
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('product-added', msg => {
            $('#theModal').modal('hide');
        });
        window.livewire.on('product-updated', msg => {
            $('#theModal').modal('hide');
        });
        window.livewire.on('product-deleted', msg => {
            //noty
        });
        window.livewire.on('modal-show', msg => {
            $('#theModal').modal('show');
        });
        window.livewire.on('modal-hide', msg => {
            $('#theModal').modal('hide');
        });
        window.livewire.on('hidden.bs.modal', msg => {
            $('.er').css('display', 'none');
        });
    })
</script>