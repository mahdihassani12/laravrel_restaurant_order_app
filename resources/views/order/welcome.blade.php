@extends('order.layouts.app')
@section('main_content')
<div class="content-header">
  <div class="container-fluid">
	<div class="row mb-2">
	  <div class="col-sm-12">
		<h1 class="m-0 text-dark text-center"> صفحه اصلی ثبت سفارش </h1>
	  </div><!-- /.col -->
	</div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

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
								</tr>
							</thead>
							<tbody>
								@foreach($food as $index => $f)
									<tr>
										<td>{{ $index + 1 }}</td>
										<td>{{ $f-> name }}</td>
										<td>{{ $f-> price }}</td>
									</tr>
								@endforeach
							</tbody>
							<tfoot>
								<tr>
									<th> # </th>
									<th>نام </th>
									<th>قیمت</th>
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
								</tr>
							</thead>
							<tbody>
								@foreach($drink as $index => $f)
									<tr>
										<td>{{ $index + 1 }}</td>
										<td>{{ $f-> name }}</td>
										<td>{{ $f-> price }}</td>
									</tr>
								@endforeach
							</tbody>
							<tfoot>
								<tr>
									<th> # </th>
									<th>نام </th>
									<th>قیمت</th>
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
								</tr>
							</thead>
							<tbody>
								@foreach($icecream as $index => $f)
									<tr>
										<td>{{ $index + 1 }}</td>
										<td>{{ $f-> name }}</td>
										<td>{{ $f-> price }}</td>
									</tr>
								@endforeach
							</tbody>
							<tfoot>
								<tr>
									<th> # </th>
									<th>نام </th>
									<th>قیمت</th>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection

@section('style')
  <style>
	.project-tab {
		padding: 10%;
		margin-top: -8%;
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
	table{
		display:table;
	}
	table th, table td{
		display: table-cell;
		max-width: 0;
		text-align: center;
	}
  </style>
@endsection

@section('script')
<script type="text/javascript">
   
</script>
@endsection