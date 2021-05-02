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
	<div class="col-md-8 col-sm-12">
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
											<th> # </th>
											<th>نام </th>
											<th>قیمت</th>
											<th>تعداد</th>
											<th>پروسس</th>
										</tr>
									</thead>
									<tbody>
										@foreach($food as $index => $f)
											<tr>
												<td>{{ $index + 1 }}</td>
												<td id="name" menu_id="{{ $f->menu_id }}">{{ $f-> name }}</td>
												<td id="price">{{ $f-> price }}</td>
												<td id="amount">
													<input type="number" 
														   name="amount"
														   id="amount"
														   class="amount"
														   value="1"
														   placeholder="تعداد"
														   />
												</td>
												<td class="process"><span class="text-info">افزودن</span></td>
											</tr>
										@endforeach
									</tbody>
									<tfoot>
										<tr>
											<th> # </th>
											<th>نام </th>
											<th>قیمت</th>
											<th>تعداد</th>
											<th>پروسس</th>
										</tr>
									</tfoot>
								</table>
							</div>
							<div class="tab-pane fade" id="drink" role="tabpanel" aria-labelledby="nav-profile-tab">
								<table class="table" cellspacing="0">
									<thead>
										<tr>
											<th> # </th>
											<th>نام </th>
											<th>قیمت</th>
											<th>تعداد</th>
											<th>پروسس</th>
										</tr>
									</thead>
									<tbody>
										@foreach($drink as $index => $f)
											<tr>
												<td>{{ $index + 1 }}</td>
												<td id="name" menu_id="{{ $f->menu_id }}">{{ $f-> name }}</td>
												<td id="price">{{ $f-> price }}</td>
												<td id="amount">
													<input type="number" 
														   name="amount"
														   id="amount"
														   class="amount"
														   value="1"
														   placeholder="تعداد"
														   />
												</td>
												<td class="process"><span class="text-info">افزودن</span></td>
											</tr>
										@endforeach
									</tbody>
									<tfoot>
										<tr>
											<th> # </th>
											<th>نام </th>
											<th>قیمت</th>
											<th>تعداد</th>
											<th>پروسس</th>
										</tr>
									</tfoot>
								</table>
							</div>
							<div class="tab-pane fade" id="icecream" role="tabpanel" aria-labelledby="nav-contact-tab">
								<table class="table" cellspacing="0">
									<thead>
										<tr>
											<th> # </th>
											<th>نام </th>
											<th>قیمت</th>
											<th>تعداد</th>
											<th>پروسس</th>
										</tr>
									</thead>
									<tbody>
										@foreach($icecream as $index => $f)
											<tr>
												<td>{{ $index + 1 }}</td>
												<td id="name" menu_id="{{ $f->menu_id }}">{{ $f-> name }}</td>
												<td id="price">{{ $f-> price }}</td>
												<td id="amount">
													<input type="number" 
														   name="amount"
														   id="amount"
														   class="amount"
														   value="1"
														   placeholder="تعداد"
														   />
												</td>
												<td class="process"><span class="text-info">افزودن</span></td>
											</tr>
										@endforeach
									</tbody>
									<tfoot>
										<tr>
											<th> # </th>
											<th>نام </th>
											<th>قیمت</th>
											<th>تعداد</th>
											<th>پروسس</th>
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
	<div class="col-md-4 col-sm-12">
		<div class="card">
			<div class="card-header">سفارش در حال اجرا</div>
			<div class="card-body">
				<form id="order">
					@csrf
					<table class="table table-bordered">
						<tr>
							<th> اسم سفارش </th>
							<th> تعداد </th>
							<th> قیمت </th>
						</tr>
						<tr class="order_row">
							<td id="order_name">
								<span> چیپس </span>
							</td>
							<td id="order_amount">
								<span>۲</span>
							</td>
							<td id="order_price">
								<span> ۲۰۰ </span>
							</td>
						</tr>	
					</table>
				</form>
			</div>
		</div>
	</div> <!--/col-->
</div> <!--/row-->

@endsection

@section('style')
  <style>
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
  </style>
@endsection

@section('script')
<script type="text/javascript">
   jQuery(document).ready(function(){
	   
   });
</script>
@endsection