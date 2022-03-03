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
                                <th class="table-th text-white">CLIENTES</th>
                                <th class="table-th text-center text-white">DIRECCION</th>
                                <th class="table-th text-center text-white">TELEFONO</th>
                                <th class="table-th text-center text-white">CORREO ELECTRONICO</th>
                                <th class="table-th text-center text-white">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($cliente as $c)
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

                                <td class="text-center">
                                    <a href="javascript:void(0);" wire:click="Edit({{$c->id}})" class="btn btn-dark mtmobile" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="javascript:void(0);" onclick="Confirm('{{$c->id}}')" class="btn btn-dark" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$cliente->links()}}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.clients.form')
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