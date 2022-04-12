<div class="row sales layout-top-spacing">

    <div class="col-sm-12 ">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title"><b> MODULO DE INFORMES</b></h4>
            </div>
            <div class="widget-content">
                <a class="btn btn-dark">Deudores</a>
                <a class="btn btn-dark">Meripuntos</a>
                <a class="btn btn-dark" href="{{ url('produc_baj/pdf')}}" target="_black">Productos Bajos</a>
                <a class="btn btn-dark">Generar catalogo de Productos</a>
                <a class="btn btn-dark">Catalogo de Productos</a>
            </div>
            <br>
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped  mt-1">
                        <thead class="text-white" style="background: #226F">
                            <tr>
                                <th class="table-th text-white">NOMBRE</th>
                                <th class="table-th text-white text-center">CODIGO BARRA</th>

                                <th class="table-th text-white text-center">STOCK</th>

                                <th class="table-th text-white text-center">CATEGORIA</th>
                                <th class="table-th text-white text-center">IMAGEN</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
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