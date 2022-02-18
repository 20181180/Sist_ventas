<div class="row">
    <div class="col-sm-12">
        <div>
            <div class="connect-sorting">

                <h5 class="text-center mb-3">
                    RESUMEN DE VENTA
                </h5>
                <div class="connect-sorting-content">
                    <div class="card simple-title-task ui-sortable-handle">
                        <div class="card-body">

                            <div class="task-header">
                                <div>
                                    <h2>TOTAL: ${{number_format($total,2)}}</h2>
                                    <input type="hidden" value="{{$total}}" id="hiddenTotal">
                                </div>
                                <div>
                                    <h5 class="text-muted mt-3">ARTICULOS: {{$itemsQuantity}}</h5>
                                </div>
                                <div>
                                    <h5 class="text-muted mt-3"> MERIPUNTOS:{{$puntos}}</h5>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>