<div class="card">
	<div class="card-header" id="head{{ $order->order_id }}">
	  <h5 class="mb-0">
	  	<button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{ $order->order_id }}" aria-expanded="true" aria-controls="collapseOne">
			<a href="{{ route('getSearchDetails',$order->order_id) }}">
				سفارش : {{ $order->table->name }} - شماره سفارش : {{ $order->identity }}
			</a>
		</button>
	  </h5>
	</div>

	<div id="collapse{{ $order->order_id }}" class="collapse show" aria-labelledby="head{{ $order->order_id }}" data-parent="#accordion">
	  <div class="card-body">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>مشخصه</th>
						<th>اسم سفارش</th>
						<th>نوعیت سفارش</th>
						<th>تعداد سفارش</th>
					</tr>
				</thead>
				<tbody>
					@foreach($insideOrders as $index => $inside)
						<tr>
							<td>{{ $index + 1 }}</td>
							<td>{{ $inside->menu->name }}</td>
							<td>{{ $inside->menu->category->name }}</td>
							<td>{{ $inside->order_amount }}</td>
						</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<th>مشخصه</th>
						<th>اسم سفارش</th>
						<th>تعداد سفارش</th>
						<th>نوعیت سفارش</th>
					</tr>
				</tfoot>
			</table>
	  </div>
	</div>
  </div> <!-- /card -->