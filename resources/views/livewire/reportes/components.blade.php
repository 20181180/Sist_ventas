<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget">
            <div class="widget-heading">
                <h4 class="card-title text-center"><b> {{$componentName}} </b></h4>
            </div>
            <div class="widget-contend">
                <div class="row">
                    <div class="col-sm-12 col-md-3">

                        <div class="row">
                            <div class="col-sm-12">
                                <h6>Elige el usuario *</h6>
                                <div class="form-gropup">
                                    <select wire:model="userId" class="form-control">
                                        <option value="0">Todos</option>
                                        @foreach($users as $u)
                                        <option value="{{$u->id}}">{{$u->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <h6>Tipo de reporte a generar *</h6>
                                <div class="form-gropup">
                                    <select wire:model="reportType" class="form-control">
                                        <option value="0">Ventas del día</option>
                                        <option value="1">Ventas por fecha</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12 mt-2">
                                <h6>Fecha de Incio *</h6>
                                <div class="form-group">
                                    <input type="text" wire:model="dateFrom" class="form-control flatpickr" placeholder="Elige una Fecha*">
                                </div>
                            </div>

                            <div class="col-sm-12 mt-2">
                                <h6>Fecha Hasta *</h6>
                                <div class="form-group">
                                    <input type="text" wire:model="dateTo" class="form-control flatpickr" placeholder="Elige una Fecha*">
                                </div>
                            </div>

                            <div class="col-sm-12 mt-2">
                                <button wire:click="$refresh" class="btn btn-dark btn-block">
                                    Generar Consulta
                                </button>
                            </div>
                            <div class="col-sm-12 mt-2">


                                <a class="btn btn-dark btn-block {{count($data) <1 ? 'disabled':''}} " href="{{ url('report/pdf' . '/' . $userId . '/' . '' . $reportType . '/' . $dateFrom . '/' . $dateTo) }}" target="_black">Generar archivo PDF</a>

                                <a class="btn btn-dark btn-block {{count($data) <1 ? 'disabled':''}}" href="{{ url('report/excel' . '/' . $userId . '/' . '' . $reportType . '/' . $dateFrom . '/' . $dateTo) }}" target="_black">Exportar A Excel</a>

                            </div>
                        </div>
                    </div>
                    <!--tabla de los resultados encontrados-->
                    <div class="col-sm-12 col-md-9">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped  mt-1">
                                <thead class="text-white" style="background: #3B3F5C">
                                    <tr>
                                        <th class="table-th text-white text-center">CLAVE</th>
                                        <th class="table-th text-white text-center">TOTAL</th>
                                        <th class="table-th text-white text-center">CANT_ART</th>
                                        <th class="table-th text-white text-center">STATUS</th>
                                        <th class="table-th text-white text-center">USUARIO</th>
                                        <th class="table-th text-white text-center">FECHA</th>
                                        <th class="table-th text-white text-center" width="50px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($data) <1 )
                                        <tr><td colspan="7">
                                            <h5>No hay resultados.</h5>
                                        </td></tr>
                                        @endif

                                        @foreach($data as $d)
                                        <tr>
                                            <td class="text-center">
                                                <h6>{{$d->id}}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>$ {{number_format( $d->total,2)}} </h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{$d->items}}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{$d->estado}}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{$d->user}}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{\Carbon\Carbon::parse($d->created_at)->format('d-m-Y') }}</h6>
                                            </td>

                                            <td class="text-center" width="50px">
                                                <button wire:click.prevent="getDetails({{$d->id}}) " class="btn btn-dark btn-sm">
                                                    <i class="fas fa-list"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!-- Fin de la tabla-->
                </div>
            </div>
        </div>
    </div>
    @include('livewire.reportes.sales-detail')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function()
    {
        flatpickr(document.getElementsByClassName('flatpickr'),{
            enableTime: false,
            dateFormat: 'Y-m-d',
            locale: {
                firstDayofWeek: 1,
                weekdays: {
                    shorthand: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
                    longhand: [
                    "Domingo",
                    "Lunes",
                    "Martes",
                    "Miércoles",
                    "Jueves",
                    "Viernes",
                    "Sábado",
                    ],
                },
                months: {
                    shorthand: [
                    "Ene",
                    "Feb",
                    "Mar",
                    "Abr",
                    "May",
                    "Jun",
                    "Jul",
                    "Ago",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dic",
                    ],
                    longhand: [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre",
                    ],
                },

            }
        })

        window.livewire.on('show-modal', Msg =>{
            $('#modalDetails').modal('show')
        })

    })
</script>
