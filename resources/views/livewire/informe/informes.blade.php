<div class="row sales layout-top-spacing">

    <div class="col-sm-12 ">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title"><b> MODULO DE INFORMES</b></h4>
            </div>
            <div class="widget-content">
                <a class="btn btn-dark" wire:click="client_deud()">Deudores</a>
                <a class="btn btn-dark" wire:click="meri()">Meripuntos</a>

                <a class="btn btn-dark" wire:click="pro_bajos()">Productos Bajos</a>

                <a class="btn btn-dark" wire:click="pro_exis()">Productos Existentes</a>

            </div>
            <br>
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped  mt-1">
                        @if($estado==0)

                        <thead class="text-white" style="background: #226F">

                            <tr>
                                <a class="btn btn-dark btn-block {{count($products) <1 ? 'disabled' : '' }}" href="{{ url('catalogo/pdf')}}" target="_black">GENERAR PDF DE CATALOGO DE PRODUCTOS</a>
                                <br>
                                <th class="table-th text-white">NOMBRE</th>
                                <th class="table-th text-white text-center">CODIGO BARRA</th>
                                <th class="table-th text-white text-center">CATEGORIA</th>
                                <th class="table-th text-white text-center">IMAGEN</th>

                            </tr>
                        </thead>
                        <tbody>
                            @if(count($products) <1 ) <tr>
                                <td class="text-center" colspan="5">
                                    <h5>No hay resultados.</h5>
                                </td>
                                </tr>
                                @endif


                                @foreach ($products as $product)
                                <tr>
                                    <td>
                                        <h6>{{$product->name}}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{$product->barcode}}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{$product->category}}</h6>
                                    </td>

                                    <td class="text-center">
                                        <span>
                                            <img src=" {{asset('storage/' . $product->imagen )}}" onclick="ShowImg('{{ asset('storage/' . $product->imagen) }}','{{$product->name}}')" height="70" width="80" class="rounded zom" alt="no-image">
                                        </span>
                                    </td>

                                </tr>

                                @endforeach

                        </tbody>
                        @elseif($estado == 3)
                        <thead class="text-white" style="background: #226F">
                            <tr>
                                <a class="btn btn-dark btn-block {{count($prod_bj) <1 ? 'disabled' : '' }}" href=" {{ url('produc_baj/pdf')}}" target="_black">GENERAR PDF DE PRODUCTOS BAJOS</a>
                                <br>
                                <th class="table-th text-white">NOMBRE</th>
                                <th class="table-th text-white text-center">CODIGO BARRA</th>

                                <th class="table-th text-white text-center">STOCK</th>

                                <th class="table-th text-white text-center">CATEGORIA</th>
                                <th class="table-th text-white text-center">IMAGEN</th>

                            </tr>
                        </thead>
                        <tbody>
                            @if(count($prod_bj) <1 ) <tr>
                                <td class="text-center" colspan="5">
                                    <h5>No hay resultados.</h5>
                                </td>
                                </tr>
                                @endif

                                @foreach ($prod_bj as $product)
                                <tr>
                                    <td>
                                        <h6>{{$product->name}}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{$product->barcode}}</h6>
                                    </td>

                                    <td>
                                        <h6 class="text-center">{{$product->stock}}</h6>
                                    </td>

                                    <td>
                                        <h6 class="text-center">{{$product->category}}</h6>
                                    </td>

                                    <td class="text-center">
                                        <span>
                                            <img src=" {{asset('storage/' . $product->imagen )}}" onclick="ShowImg('{{ asset('storage/' . $product->imagen) }}','{{$product->name}}')" height="70" width="80" class="rounded zom" alt="no-image">
                                        </span>
                                    </td>

                                </tr>

                                @endforeach
                        </tbody>
                        @elseif($estado == 1)
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <a class="btn btn-dark btn-block {{count($deu) <1 ? 'disabled' : '' }}" href="{{ url('report/excel')}}" target="_black">GENERAR EXCEL DEUDORES</a>

                                <th class="table-th text-white">CLIENTE</th>
                                <th class="table-th text-center text-white">DIRECCION</th>
                                <th class="table-th text-center text-white">TELEFONO</th>
                                <th class="table-th text-center text-white">CORREO ELECTRONICO</th>
                                <th class="table-th text-center text-white">SALDO</th>

                            </tr>
                        </thead>
                        <tbody>

                            @foreach($deu as $c)
                            <tr>
                                <td>
                                    <h6>{{$c->name}}</h6>
                                </td>
                                <td>
                                    <h6 class="text-center ">{{$c->address}}</h6>
                                </td>
                                <td>
                                    <h6 class="text-center">{{$c->phone}}</h6>
                                </td>
                                <td>
                                    <h6 class="text-center">{{$c->email}}</h6>
                                </td>
                                <td>
                                    <h6 class="text-center">$ {{$c->saldo}}</h6>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        @elseif($estado==2)
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <a class="btn btn-dark btn-block {{count($deu) <1 ? 'disabled' : '' }}" href="#" target="_black">GENERAR PDF DE MERIPUNTOS</a>

                                <th class="table-th text-white">CLIENTE</th>
                                <th class="table-th text-center text-white">DIRECCION</th>
                                <th class="table-th text-center text-white">CORREO ELECTRONICO</th>
                                <th class="table-th text-center text-white">MERIPUNTOS</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($deu as $c)
                            <tr>
                                <td>
                                    <h6>{{$c->name}}</h6>
                                </td>
                                <td>
                                    <h6 class="text-center ">{{$c->address}}</h6>
                                </td>

                                <td>
                                    <h6 class="text-center">{{$c->email}}</h6>
                                </td>
                                <td>
                                    <h6 class="text-center">$ {{$c->meripuntos}}</h6>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        @elseif($estado==4)
                        <thead class="text-white" style="background: #226F">
                            <tr>
                                <a class="btn btn-dark btn-block {{count($prod_exi) <1 ? 'disabled' : '' }}" href="#" target="_black">GENERAR PDF DE PRODUCTOS EXISTENTES</a>
                                <br>
                                <th class="table-th text-white">NOMBRE</th>
                                <th class="table-th text-white text-center">CODIGO BARRA</th>

                                <th class="table-th text-white text-center">STOCK</th>

                                <th class="table-th text-white text-center">CATEGORIA</th>
                                <th class="table-th text-white text-center">IMAGEN</th>

                            </tr>
                        </thead>
                        <tbody>
                            @if(count($prod_exi) <1 ) <tr>
                                <td class="text-center" colspan="5">
                                    <h5>No hay resultados.</h5>
                                </td>
                                </tr>
                                @endif

                                @foreach ($prod_exi as $product)
                                <tr>
                                    <td>
                                        <h6>{{$product->name}}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{$product->barcode}}</h6>
                                    </td>

                                    <td>
                                        <h6 class="text-center">{{$product->stock}}</h6>
                                    </td>

                                    <td>
                                        <h6 class="text-center">{{$product->category}}</h6>
                                    </td>

                                    <td class="text-center">
                                        <span>
                                            <img src=" {{asset('storage/' . $product->imagen )}}" onclick="ShowImg('{{ asset('storage/' . $product->imagen) }}','{{$product->name}}')" height="70" width="80" class="rounded zom" alt="no-image">
                                        </span>
                                    </td>

                                </tr>

                                @endforeach
                        </tbody>
                        @endif

                    </table>

                </div>
            </div>

        </div>

    </div>

</div>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show');
            noty(msg)
        });
        window.livewire.on('pro-added', msg => {
            $('#theModal').modal('hide');

        });
        window.livewire.on('item-updated', msg => {
            $('#theModal').modal('hide');
            noty(msg)
        });
        window.livewire.on('abono-client', msg => {
            $('#Modal2').modal('show');
        });

        window.livewire.on('Abono-uwu', msg => {
            $('#Modal2').modal('hide');
        });
        window.livewire.on('sale-error', Msg => {
            $('#Modal2').modal('hide');
            noty(Msg)
        })
        window.livewire.on('item-deleted', Msg => {
            $('#Modal2').modal('hide');
            noty(Msg)
        })
        window.livewire.on('modal-estadocliente', msg => {
            $('#Modalesuwu').modal('show');
            noty(Msg)
        });

    });

    function Confirm(id) {

        swal({
            title: 'CONFIRMAR',
            text: '¿CONFIRMAS INACTIVAR EL REGISTRO?',
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#fff',
            confirmButtonColor: '#3b3f5c',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('deleteRow', id)
                swal.close()
            }
        });

    }
</script>