@extends('dashboard.layouts.app')
@section('main_content')
		
	<div class="container-fluid pt-5">
		<div class="row">
			<div class="col-md-8 col-sm-12">
				<div class="card">
				  <div class="card-header">
					<h3 class="card-title">لیست دسته ها</h3>
				  </div>
				  <!-- /.card-header -->
				  <div class="card-body p-0">
					<table class="table table-condensed table-bordered">
					  <thead>
							<tr>
								<td>مشخصه</td>
								<td>نام دسته</td>
								<td>عملیات</td>
							</tr>
						</thead>
						<tbody>
						  @foreach($categories as $index => $category)
							<tr>
							  <td>{{ $index + 1 }}</td>
							  <td>{{ $category->name }}</td>
							  <td>
									<a href="{{ route('categories.edit',$category->category_id) }}"><i class="fa fa-edit"></i></a>
									/
									<form method="post" 
										  id="form_delete"
										  action="{{ route('categories.destroy',$category->category_id) }}">
										@csrf
										@method('delete')
										<button type="submit">
											<i class="fa fa-trash"></i>
										</button>
									</form>
							  </td>
							</tr>	
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<td>مشخصه</td>
								<td>نام دسته</td>
								<td>عملیات</td>
							</tr>
						</tfoot>
					</table>
				  </div>
				  <!-- /.card-body -->
				</div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div>
	
@endsection

@section('style')
  <style>
	.alert{
		position: fixed;
		bottom: 0;
		z-index: 10;
		left: 20px;
	}
	.alert button{
		margin-left: 5px;
	}
	.fa-edit{
		color:blue;
	}
	.fa-trash{
		color:red;
	}
  </style>
@endsection

@section('script')
<script type="text/javascript">
   
</script>
@endsection