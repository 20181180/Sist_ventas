<div class="row sales layout-top-spacing">

    <div class="col-sm-12 ">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title"><b>{{$componentName}} | {{$pageTitle}}</b></h4>
                <ul class="tabs tab-pills">

                    <li><a href="javascript:void(0);" class="tabmenu bg-dark" data-toggle="modal" data-target="#theModal"><i class="fas fa-user-astronaut" style="font-size:22px;"></i> Agregar</a></li>
                </ul>
            </div>

            @include('commont.searchbox')
            <button class=" btn  text-white  mr-5" data-toggle="modal" data-target="#ModalClientesInactivos" style="background: #2666CF">Clientes Inactivos</button>
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped  mt-1">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-white">CLIENTES</th>
                                <th class="table-th text-center text-white">DIRECCION</th>
                                <th class="table-th text-center text-white">TELEFONO</th>
                                <th class="table-th text-center text-white">CORREO ELECTRONICO</th>
                                <th class="table-th text-center text-white">SALDO</th>
                                <th class="table-th text-center text-white">LIMITE</th>
                                <th class="table-th text-center text-white">MERIPUNTOS</th>
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
                                <td>
                                    <h6 class="text-center">$ {{$c->saldo}}</h6>
                                </td>
                                <td>
                                    <h6 class="text-center">$ {{$c->limite}}</h6>
                                </td>
                                <td>
                                    <h6 class="text-center">M {{$c->meripuntos}}</h6>
                                </td>

                                <td class="text-center">
                                    <a href="javascript:void(0);" wire:click="Edit({{$c->client_id}})" class="btn btn-dark mtmobile" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="javascript:void(0);" onclick="Confirm('{{$c->client_id}}')" class="btn btn-dark" title="Delete">
                                        BLOQUEAR
                                        <!-- <i class="fas fa-trash"></i> -->
                                    </a>

                                    <a href="javascript:void(0);" wire:click="Pay({{$c->client_id}})" class="btn mtmobile" style="background-color: #21BF73;color:white" title="Pay">
                                        ABONAR
                                        <i class="fas fa-light fa-piggy-bank" style="font-size:22px;"></i>
                                    </a>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$cliente->links()}}
                </div>
            </div>
            @include('livewire.clients.form_inactivos')
        </div>
        @include('livewire.clients.form_estado')
    </div>
    @include('livewire.clients.form')
</div>

@include('livewire.clients.pay')

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
            text: '??CONFIRMAS INACTIVAR EL REGISTRO?',
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
