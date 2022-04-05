<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title text-center"><b>CORTE DE CAJA</b></h4>
            </div>
            <div class="widget-content">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label for="">Usuario *</label>
                            <select class="form-control" wire:model="userid">

                                @foreach($users as $u)
                                <option value="0"></option>
                                <option value="{{$u->id}}"> {{$u->name}} </option>
                                @endforeach
                            </select>
                            @error('userid')<span class="text-danger er">{{$message}}</span>@enderror
                        </div>
                        <button wire:click.prevent="venta_dia" type="button" class="btn btn-dark"> CONSULTAR VENTAS DEL DIA</button>
                    </div>



                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label>Fecha Inicial *</label>
                            <input type="date" wire:model="fromDate" value="<?php echo date("Y-m-d"); ?>" class="form-control">
                            @error('fromDate')<span class="text-danger er">{{$message}}</span>@enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label>Fecha Final *</label>
                            <input type="date" wire:model="toDate" class="form-control">
                            @error('toDate')<span class="text-danger er">{{$message}}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="">Tipo venta*</label>
                            <select class="form-control" wire:model="tipo_v">
                                <option value="0">General</option>
                                <option value="1">Pagados</option>
                                <option value="2">Credito</option>
                                <option value="3">Canjeos</option>
                            </select>
                        </div>

                    </div>

                    <div class="col-sm-12 col-md-3">

                        @if($userid >0 && $fromDate !=null && $toDate !=null)
                        <button wire:click.prevent="Consultar" type="button" class="btn btn-dark"> Consultar</button>
                        @endif
                    </div>
                </div>

            </div>

            <div class="row mt-5">
                <div class="col-sm-12 col-md-4 mbmobile">
                    <div class="connect-sorting bg-dark">
                        <h5 class="text-white">Pagos efectivo:$ {{$ef}} </h5>
                        <br>
                        <h5 class="text-white">Tarjeta de credito:$ {{$trj}} </h5>
                        <br>
                        <h5 class="text-white">Articulos: {{$items}} </h5>


                    </div>
                    <br>
                    <div class="connect-sorting" style="background: #4E9F3D;">
                        <h5 class="text-white">Abonos:$ {{$abonos}} </h5>
                        <br>
                        <h5 class="text-white">canjeos:$ {{$m}} </h5>

                    </div>
                    <br>
                    <div class="connect-sorting" style="background: #0C7B93;">

                        <h5 class="text-white">Subtotal venta:$ {{number_format($total,2)}} </h5>
                        <br>
                        <h5 class="text-white">Totales Netos:$ {{$nt}} </h5>
                    </div>
                    <br>

                    <button wire:click.prevent="Print()" type="button" class="btn btn-dark btn-block {{count($sales) <1 ? 'disabled' : ''}}">Imprirmir</button>

                </div>

                <div class="col-sm-12 col-md-8">
                    <div class="table-resposive">
                        <table class="table table-bordered table-striped mt-1">
                            <thead class="text-white" style="background:#3B3F4C;">
                                <tr>
                                    <th class="table-th text-center text-white"> Folio*</th>
                                    <th class="table-th text-center text-white">Total*</th>
                                    <th class="table-th text-center text-white"> Cant_Art*</th>
                                    <th class="table-th text-center text-white">Fecha*</th>
                                    <th class="table-th text-center text-white">Estado Pag*</th>
                                    <th class="table-th text-center text-white"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(empty($sales)) <tr>
                                    <td colspan="6">
                                        <h6 class="text-center">
                                            No Hay Ventas Para La Fecha Seleccionada
                                        </h6>
                                    </td>
                                    </tr>
                                    @endif

                                    @foreach($sales as $row)
                                    <tr>
                                        <td class="text-center">
                                            <h6> {{$row->id}} </h6>
                                        </td>
                                        <td class="text-center">
                                            <h6>$ {{ number_format($row->total,2)}} </h6>
                                        </td>
                                        <td class="text-center">
                                            <h6> {{$row->items}} </h6>
                                        </td>
                                        <td class="text-center">
                                            <h6> {{$row->created_at}} </h6>
                                        </td>
                                        <td class="text-center">
                                            <h6>{{$row->estado}} </h6>
                                        </td>
                                        <td class="text-center">
                                            <button wire:click.prevent="viewDeatails({{$row}})" class="btn btn-dark btn-sm"> Detalles <i class="fast fa-list"></i> </button>
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
    @include('livewire.cashout.modalDetails')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('show-modal', Msg => {
            $('#modal-details').modal('show')
            noty(Msg)
        });
    })
</script>