<div wire:ignore.self class="modal fade" id="ModalClientesInactivos" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white text-center">
                    <b class="text-center">CLIENTES INACTIVOS</b>
                </h5>
                <h6 class="text-center text-warnig" style="color: white;" wire:loading>POR FAVOR ESPERE...</h6>
            </div>
            <br>
            <div class="widget-content">
                <div class="row">
                    {{-- PUEDES PONER AQUI ALGO --}}
                </div>
            </div>


            <div class="modal-body">
                <div class="widget-content">

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped  mt-1">
                            <thead class="text-white" style="background: #F58634">
                                <tr>
                                    <th class="table-th text-white text-center">NOMBRE</th>
                                    <th class="table-th text-white">DIRECCION</th>
                                    <th class="table-th text-white">CORREO</th>
                                    <th class="table-th text-white text-center">ESTADO CLIENTE</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if(count($inactivosCli) == 0) <tr>
                                    <td colspan="6">
                                        <h6 class="text-center">
                                            No Hay Clientes Inactivos..
                                        </h6>
                                    </td>
                                </tr>
                                @endif


                                @foreach ($inactivosCli as $product)
                                <tr>
                                    <td>
                                        <h6 class="text">{{$product->name}}</h6>
                                    </td>

                                    <td>
                                        <span>
                                            <h6 class="text">{{$product->address}}</h6>
                                        </span>
                                    </td>
                                    <td>
                                        <h6 class="text">{{$product->email}}</h6>
                                    </td>


                                    <td class="text-center">
                                        <div class="col-sm-12 col-md-12">
                                            <label class="check">
                                                <input type="checkbox" wire:change="estadoClient($('#p' + {{$product->id
                                                }}).is(':checked'), {{$product->id}} )"
                                                id="p{{ $product->id }}"
                                                value="{{$product->id}}"
                                                class="new-control-input "
                                                >
                                                  <span class="check-1"></span>
                                              </label>
                                        </div>

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
