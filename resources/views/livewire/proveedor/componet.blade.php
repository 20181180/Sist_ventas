<div class="row sales layout-top-spacing">

    <div class="col-sm-12 ">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title"><b>{{$componentName}} | {{$pageTitle}}</b></h4>
                <ul class="tabs tab-pills">

                    <li><a href="javascript:void(0);" class="tabmenu bg-dark" data-toggle="modal" data-target="#theModal">Agregar</a></li>

                </ul>
            </div>

            @include('commont.searchbox')

            <div class="widget-content">


                <div class="table-responsive">
                    <table class="table table-bordered table-striped  mt-1">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-white">PROVEEDOR</th>
                                <th class="table-th text-center text-white">DIRECCION</th>
                                <th class="table-th text-center text-white">TELEFONO</th>
                                <th class="table-th text-center text-white">EMPRESA</th>
                                <th class="table-th text-center text-white">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($proveedor as $p)
                            <tr>
                                <td>
                                    <h6>{{$p->name}}</h6>
                                </td>
                                <td>
                                    <h6>{{$p->address}}</h6>
                                </td>
                                <td>
                                    <h6>{{$p->phone}}</h6>
                                </td>
                                <td>
                                    <h6>{{$p->taxpayer_id}}</h6>
                                </td>

                                <td class="text-center">
                                    <a href="javascript:void(0);" wire:click="Edit({{$p->id}})" class="btn btn-dark mtmobile" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="javascript:void(0);" onclick="Confirm('{{$p->id}}')" class="btn btn-dark" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$proveedor->links()}}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.proveedor.form')
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

    });

    function Confirm(id) {

        swal({
            title: 'CONFIRMAR',
            text: '¿CONFIRMAS ELIMINAR EL REGISTRO?',
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