<div class="row sales layout-top-spacing">

    <div class="col-sm-12 ">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title"><b> INFORMACION | PERFIL DE LA EMPRESA</b></h4>
                <ul class="tabs tab-pills">
                    <!-- @can('Crear_categoria') -->
                    <!-- <li><a href="javascript:void(0);" class="bg-dark btn-block" data-toggle="modal" data-target="#modalxd">CARGAR DATOS DE LA EMPRESA</a></li> -->
                    <!-- @endcan -->
                </ul>
            </div>

            <div class="widget-content">


                <div class="table-responsive">
                    <table class="table table-bordered table-striped  mt-1">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <a href="javascript:void(0);" class="btn btn-dark btn-block" data-toggle="modal" data-target="#modalxd"> CARGAR DATOS DE LA EMPRESA</a>

                                <th class="table-th text-white">NOM/EMPRESA</th>
                                <th class="table-th text-white text-center">EMAIL</th>
                                <th class="table-th text-white text-center">TEL/CELULAR</th>
                                <th class="table-th text-white text-center">UBICACION</th>
                                <th class="table-th text-white  text-center">FACEBOOK</th>
                                <th class="table-th text-white  text-center">CODIGO/POS</th>
                                <th class="table-th text-center text-white">IMAGEN</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inf as $d)
                            <tr>
                                <td>
                                    <h6>{{$d->empresa}}</h6>
                                </td>
                                <td>
                                    <h6 class="text-center ">{{$d->correo}}</h6>
                                </td>
                                <td>
                                    <h6 class="text-center">{{$d->tel}}</h6>
                                </td>
                                <td>
                                    <h6 class="text-center">{{$d->face}}</h6>
                                </td>
                                <td>
                                    <h6 class="text-center">{{$d->ubicacion}}</h6>
                                </td>
                                <td>
                                    <h6 class="text-center">{{$d->codigopostal}}</h6>
                                </td>
                                <td class="text-center">
                                    <span>
                                        <img src=" {{asset('storage/datos/' . $d->image )}}" onclick="ShowImg('{{ asset('storage/datos/' . $d->image) }}','{{$d->empresa}}')" height="70" width="80" class="rounded zom" alt="no-image">
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
    @include('livewire.form')
</div>




<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('show-modal', msg => {
            $('#modalxd').modal('show');
            noty(msg)
        });
        window.livewire.on('inf-added', msg => {
            $('#modalxd').modal('hide');
            noty(msg)
        });
        window.livewire.on('category-updated', msg => {
            $('#modalxd').modal('hide');
            noty(msg)
        });
    });
</script>