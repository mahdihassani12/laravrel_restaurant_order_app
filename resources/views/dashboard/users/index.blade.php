@extends('dashboard.layouts.app')
@section('main_content')
		
	<div class="container-fluid pt-5">
		<div class="row">
			<div class="col-md-8 col-sm-12">
				<div class="card">
				  <div class="card-header">
					<h3 class="card-title">لیست کاربران</h3>
				  </div>
				  <!-- /.card-header -->
				  <div class="card-body p-0">
					<table class="table table-condensed table-bordered">
					  <thead>
							<tr>
								<td>مشخصه</td>
								<td>نام کاربر</td>
								<td>ایمیل</td>
								<td>نقش کاربری</td>
								<td>عملیات</td>
							</tr>
						</thead>
						<tbody>
						  @foreach($users as $index => $user)
							<tr>
							  <td>{{ $index + 1 }}</td>
							  <td>{{ $user->user_name }}</td>
							  <td>{{ $user->email }}</td>
							  <td>{{ $user->role }}</td>
							  <td>
									<a href="{{ route('users.edit',$user->user_id) }}"><i class="fa fa-edit"></i></a>
									/
									<form method="post" 
										  id="form_delete"
										  action="{{ route('users.destroy',$user->user_id) }}">
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
								<td>نام کاربر</td>
								<td>ایمیل</td>
								<td>نقش کاربری</td>
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