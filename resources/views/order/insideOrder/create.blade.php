@extends('order.layouts.app')
@section('main_content')
<div class="content-header">
  <div class="container-fluid">
	<div class="row mb-2">
	  <div class="col-sm-12">
		<h1 class="m-0 text-dark text-center"> ثبت سفارشات داخلی </h1>
	  </div><!-- /.col -->
	</div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

<div class="row">
	<div class="col-md-7 col-sm-12">
		<section id="tabs" class="project-tab">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<nav>
							<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
								<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#food" role="tab" aria-controls="nav-home" aria-selected="true">فست فوت</a>
								<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#drink" role="tab" aria-controls="nav-profile" aria-selected="false">نوشیدنی</a>
								<a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#icecream" role="tab" aria-controls="nav-contact" aria-selected="false">بستنی</a>
							</div>
						</nav>
						<div class="tab-content" id="nav-tabContent">
							<div class="tab-pane fade show active" id="food" role="tabpanel" aria-labelledby="nav-home-tab">
								<table class="table" cellspacing="0">
									<thead>
										<tr>
											<th>نام </th>
											<th style="width: 18% !important;">قیمت</th>
											<th style="width: 18% !important;">تعداد</th>
											<th style="width: 18% !important;">پروسس</th>
										</tr>
									</thead>
									<tbody>
										@foreach($food as $index => $f)
											<tr>
												<td id="name" menu_id="{{ $f->menu_id }}">{{ $f-> name }}</td>
												<td id="price" style="width: 18% !important;">{{ $f-> price }}</td>
												<td id="amount" style="width: 18% !important;">
													<input type="number" 
														   name="amount"
														   id="amount"
														   class="amount"
														   value="1"
														   placeholder="تعداد"
														   />
												</td>
												<td style="width: 18% !important;" class="process "><button class="fa fa-plus"></button></td>
											</tr>
										@endforeach
									</tbody>
									<tfoot>
										<tr>

											<th>نام </th>
											<th style="width: 18% !important;">قیمت</th>
											<th style="width: 18% !important;">تعداد</th>
											<th style="width: 18% !important;">پروسس</th>
										</tr>
									</tfoot>
								</table>
							</div>
							<div class="tab-pane fade" id="drink" role="tabpanel" aria-labelledby="nav-profile-tab">
								<table class="table" cellspacing="0">
									<thead>
										<tr>

											<th>نام </th>
											<th style="width: 18% !important;">قیمت</th>
											<th style="width: 18% !important;">تعداد</th>
											<th style="width: 18% !important;">پروسس</th>
										</tr>
									</thead>
									<tbody>
										@foreach($drink as $index => $f)
											<tr>
												<td id="name" menu_id="{{ $f->menu_id }}">{{ $f-> name }}</td>
												<td style="width: 18% !important;" id="price">{{ $f-> price }}</td>
												<td style="width: 18% !important;" id="amount">
													<input type="number" 
														   name="amount"
														   id="amount"
														   class="amount"
														   value="1"
														   placeholder="تعداد"
														   />
												</td>
												<td style="width: 18% !important;" class="process "><button class="fa fa-plus"></button></td>
											</tr>
										@endforeach
									</tbody>
									<tfoot>
										<tr>
											<th>نام </th>
											<th style="width: 18% !important;">قیمت</th>
											<th style="width: 18% !important;">تعداد</th>
											<th style="width: 18% !important;">پروسس</th>
										</tr>
									</tfoot>
								</table>
							</div>
							<div class="tab-pane fade" id="icecream" role="tabpanel" aria-labelledby="nav-contact-tab">
								<table class="table" cellspacing="0">
									<thead>
										<tr>
											<th>نام </th>
											<th style="width: 18% !important;">قیمت</th>
											<th style="width: 18% !important;">تعداد</th>
											<th style="width: 18% !important;">پروسس</th>
										</tr>
									</thead>
									<tbody>
										@foreach($icecream as $index => $f)
											<tr>

												<td id="name" menu_id="{{ $f->menu_id }}">{{ $f-> name }}</td>
												<td style="width: 18% !important;" id="price">{{ $f-> price }}</td>
												<td style="width: 18% !important;" id="amount">
													<input type="number" 
														   name="amount"
														   id="amount"
														   class="amount"
														   value="1"
														   placeholder="تعداد"
														   />
												</td>
												<td style="width: 18% !important;" class="process "><button class="fa fa-plus"></button></td>
											</tr>
										@endforeach
									</tbody>
									<tfoot>
										<tr>
											<th>نام </th>
											<th style="width: 18% !important;">قیمت</th>
											<th style="width: 18% !important;">تعداد</th>
											<th style="width: 18% !important;">پروسس</th>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div> <!--/col-->
	<div class="col-md-5 col-sm-12">
		<div class="card">
			<div class="card-header">سفارش در حال اجرا</div>
			<div class="card-body">
				<form id="order" method="post" action="{{ route('orders.store') }}">
				
					<input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">
					<table class="table table-bordered">
						<tr>
							<th> اسم سفارش </th>
							<th > تعداد </th>
							<th> قیمت فی </th>
							<th> لغو </th>
						</tr>
					</table>
					
					<div class="form-group">
						قیمت کل : <span class="total_price"> 0 </span>
					</div>
					
					<div class="form-group">
						<select class="form-control" name="table_order" id="table_order" class="table_order">
							<option value=""> انتخاب میز </option>
							@foreach($tables as $table)
								<option value="{{ $table->location_id }}"> {{ $table->name}} </option>	
							@endforeach
						</select>
					</div>
					
					<div class="form-group">
						<button class="btn btn-success btn-xs pull-left" id="submit_order">ارسال</button>
					</div>
					
					<div class="form-group" id="er_mssages">
						@if ($errors->any())
							<div class="alert alert-danger">
								<ul>
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif
					</div>
				</form>
			</div> <!--/card-body-->
			</div>
		</div>
	</div> <!--/col-->
</div> <!--/row-->

@endsection

@section('style')
  <style>
	#er_mssages{
		clear:both;
	}
	.tab-content input#amount{
		width:100%;
	}
	.fa-minus, .fa-plus{
	  cursor:pointer;
	}
	.process{
		cursor:pointer
	}
	.card-body{
		padding: 0.5rem;
	}
	#order .form-group{
		display:flex;
	}
	#order .form-group .count{
		margin: 0 5px;
		padding-top: 5px;
	}
	#order .form-group .price{
		margin: 0 5px;
		padding-top: 5px;
	}
	.project-tab {
		
	}
	.project-tab #tabs{
		background: #007b5e;
		color: #eee;
	}
	.project-tab #tabs h6.section-title{
		color: #eee;
	}
	.project-tab #tabs .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
		color: #0062cc;
		background-color: transparent;
		border-color: transparent transparent #f3f3f3;
		border-bottom: 3px solid !important;
		font-size: 16px;
		font-weight: bold;
	}
	.project-tab .nav-link {
		border: 1px solid transparent;
		border-top-left-radius: .25rem;
		border-top-right-radius: .25rem;
		color: #0062cc;
		font-size: 16px;
		font-weight: 600;
	}
	.project-tab .nav-link:hover {
		border: none;
	}
	.project-tab thead{
		background: #f3f3f3;
		color: #333;
	}
	.project-tab a{
		text-decoration: none;
		color: #333;
		font-weight: 600;
	}
	.tab-content table{
		display:table;
	}
	.tab-content table th,.tab-content table td{
		display: table-cell;
		max-width: 0;
		text-align: center;
	}
	#discount{
		width:70px;
	}
	.order_cancel span{
		color:red;
		cursor: pointer;
	}
	.alert{
		position: fixed;
		bottom: 0;
		z-index: 10;
		left: 20px;
	}
	.alert button{
		margin-left: 5px;
	}
  </style>
@endsection

@section('script')
<script type="text/javascript">
   jQuery(document).ready(function(){
	   
	   var total = 0;
	   jQuery('.process').click(function(){
		   
			var order_name = jQuery(this).siblings('#name').text();
			var order_id = jQuery(this).siblings('#name').attr('menu_id');
			var order_price = jQuery(this).siblings('#price').text();
			var order_amount = jQuery(this).siblings('#amount').children('input#amount').val();

			jQuery('#order table').append(
				'<tr class="order_row">'
					+'<td id="order_name">'
						+'<input type="hidden" name="menu_id[]" id="menu_id_field" class="menu_id_field" value='+order_id+'>'
						+'<span>'+ order_name +'</span>'
					+'</td>'
					+'<td id="order_amount">'
						+'<span>'+ order_amount +'</span>'
						+'<input type="hidden" name="order_amount[]" id="order_amount_field" class="order_amount_field" value='+order_amount+'>'
					+'</td>'
					+'<td id="order_price">'
						+'<span>'+ order_price +'</span>'
						+'<input type="hidden" name="order_price[]" id="order_price_field" class="order_price_field" value='+order_price+'>'
					+'</td>'
					+'<td class="order_cancel" onclick="this.parentElement.remove()">'
						+'<span class="fa fa-trash"><span>'
					+'</td>'
				+'</tr>'
			); // append to the form
			
			total = (parseInt(total) + (order_amount * order_price));
		    $(".total_price").html(total);
			
	   }); // end or process order function
	   	   
	   jQuery(document).on('click', '.order_cancel', function(){
		
		   var order_price = jQuery(this).siblings('#order_price').children('span').text();
		   var order_amount = jQuery(this).siblings('#order_amount').children('span').text();
		   
		   total = (parseInt(total) - (order_amount * order_price));
		   $(".total_price").html(total);
		
	  });
	  jQuery("#table_order").select2({
		  dir: "rtl"
		});
		

	  	$('form#order').submit(function(eventObj) {
		    $(this).append('<input type="hidden" name="total" value="'+ total +'" /> ');
		    return true;
		});

   });

</script>
@endsection