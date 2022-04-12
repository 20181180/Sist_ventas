<div class="row sales layout-top-spacing">

	<div class="col-sm-12 ">
		<div class="widget widget-chart-one">
			<div class="widget-heading">
				<h4 class="card-title"><b>{{$componentName}} | {{$pageTitle}}</b></h4>
				<ul class="tabs">
					<h6>
						Productos Existentes:
						<label for="" style="color: #2666CF;"> {{$Pro_t}} en inventario.</label>
					</h6>

				</ul>
                <ul class="tabs">

					<h6>Costo total BD:<label for="" style="color: #2666CF;"> ${{$precioTotal}} MXNS</label></h6>

				</ul>
                <ul class="tabs">

					<h6>Productos en Alerta:<a href="javascript:void(0);" style="background-color: #cf2626;" data-toggle="modal" data-target="#ModalAlertas">Productos</a></h6>

				</ul>
				<ul class="tabs tab-pills">
					<li><a href="javascript:void(0);" title="Registrar Productos" class="tabmenu " style="background-color: #2666CF;" data-toggle="modal" data-target="#theModal"><i class="fa fa-plus-circle" aria-hidden="true" style="font-size:22px;"></i>Agregar</a></li>
				</ul>

			</div>
			@include('commont.searchbox')
			<div class="widget-content">

				<div class="table-responsive">
					<table class="table table-bordered table-striped  mt-1">
						<thead class="text-white" style="background: #2666CF">
							<tr>
								<th class="table-th text-white">NOMBRE</th>
								<th class="table-th text-white text-center">CODIGO BARRA</th>
								<th class="table-th text-white text-center">PRECIO</th>
								<th class="table-th text-white text-center">STOCK</th>
								<th class="table-th text-white text-center">INV. MIN</th>
								<th class="table-th text-white text-center">CATEGORIA</th>
								<th class="table-th text-white text-center">IMAGEN</th>
								<th class="table-th text-white text-center">ACTIONS</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($products as $product)


							<tr class="{{$product->stock <= $product->alerts ? 'table-primary' : ''}}">
								<td>
									<h6>{{$product->name}}</h6>
								</td>
								<td>
									<h6 class="text-center">{{$product->barcode}}</h6>
								</td>
								<td>
									<h6 class="text-center">${{$product->price}}</h6>
								</td>
								<td>
									<h6 class="text-center">{{$product->stock}}</h6>
								</td>
								<td>
									<h6 class="text-center">{{$product->alerts}}</h6>
								</td>
								<td>
									<h6 class="text-center">{{$product->category}}</h6>
								</td>

								<td class="text-center">
									<span>
										<img src=" {{asset('storage/' . $product->imagen )}}" onclick="ShowImg('{{ asset('storage/' . $product->imagen) }}','{{$product->name}}')" height="70" width="80" class="rounded zom" alt="no-image">
									</span>
								</td>

								<td class="text-center">
									<a href="javascript:void(0);" wire:click.prevent="Edit({{$product->id}})" class="btn btn-dark mtmobile" title="Edit">
										<i class="fas fa-edit"></i>
									</a>

									<a href="javascript:void(0);" onclick="Confirm('{{$product->id}}')" class="btn btn-dark" title="Delete">
										<i class="fas fa-trash"></i>
									</a>

									<a href="javascript:void(0);" wire:click.prevent="Stock_New({{$product->id}})" class="btn" style="background-color: #9EDE73;color:white" title="Ingresar mas productos">
										<i class="fa fa-cubes" aria-hidden="true"></i>
									</a>

								</td>

							</tr>
							@endforeach


						</tbody>
					</table>
					{{ $products->links() }}
				</div>
			</div>
		</div>
        @include('livewire.products.tabla_alertasP')
	</div>

	@include('livewire.products.form')
</div>
@include('livewire.products.add_stock')
<script>
	document.addEventListener('DOMContentLoaded', function() {

		window.livewire.on('product-added', msg => {
			$('#theModal').modal('hide');
			noty(msg)
		});
		window.livewire.on('product-no', msg => {
			$('#theModal').modal('hide');
			noty(msg)
		});
		window.livewire.on('product-updated', msg => {
			$('#theModal').modal('hide');
		});
		window.livewire.on('product-deleted', msg => {
			//noty
		});
		window.livewire.on('modal-show', msg => {
			$('#theModal').modal('show');
		});
		window.livewire.on('modal-hide', msg => {
			$('#theModal').modal('hide');
		});
		window.livewire.on('hidden.bs.modal', msg => {
			$('.er').css('display', 'none');
		});
		window.livewire.on('add_stock', msg => {
			$('#Modal2').modal('show');
			noty(msg)
		});

		window.livewire.on('Abono-uwu', msg => {
			$('#Modal2').modal('hide');
		});
		window.livewire.on('sale-error', Msg => {
			$('#Modal2').modal('hide');
			noty(Msg)
		})

		window.livewire.on('stok_sucess', Msg => {
			$('#Modal2').modal('hide');
			noty(Msg)
		})
	})

	function Confirm(id) {

		swal({
			title: 'CONFIRMAR',
			text: '¿DESEA ELIMINAR EL REGISTRO?',
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
