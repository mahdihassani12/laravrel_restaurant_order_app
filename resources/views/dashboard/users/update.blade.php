@extends('dashboard.layouts.app')
@section('main_content')
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0 text-dark">ویرایش کاربر</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
		
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-sm-12">
				<div class="card">
					<div class="card-header"> ویرایش کاربر </div>
					<div class="card-body">
						<form method="post" action="{{ route('users.update',$user->user_id) }}">
							@method('put')
							@csrf
							<div class="form-group">
                                <label for="name">نام کاربر</label>
                                <input type="text" 
									   name="name" 
									   id="name"
									   class="form-control"
									   autocomplete="off" 
									   value="{{ $user->user_name }}"/>
                                @error('name')<p class="text-danger">{{ $message }}</p>@enderror
                            </div>
                            <div class="form-group">
                                <label for="email">ایمیل</label>
                                <input type="email" 
									   name="email" 
									   id="email"
									   class="form-control"		
									   autocomplete="off" 
                                       value="{{ $user->email }}"/>
                                @error('email')<p class="text-danger">{{ $message }}</p>@enderror
                            </div>
							<div class="form-group">
								<label for="role">نقش کاربری</label>
								<select name="role" class="form-control" id="role">
									<option value=" "> انتخاب نقش کاربری </option>
									<option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}> مدیر  کل </option>
									<option value="kitchen" {{ $user->role == 'kitchen' ? 'selected' : '' }}> آشپزخانه </option>	
									<option value="accountant" {{ $user->role == 'accountant' ? 'selected' : '' }}> حسابداری </option>	
									<option value="order" {{ $user->role == 'order' ? 'selected' : '' }}> ثبت سفارش </option>	
								</select>
                                @error('role')<p class="text-danger">{{ $message }}</p>@enderror
							</div>
                            <div class="form-group">
                                <label for="pass">پسورد</label>
                                <input type="password" 
									   name="pass" 
									   id="pass" 
									   class="form-control"
									   autocomplete="off" 
                                       placeholder="پسورد"/>
                                @error('pass')<p class="text-danger">{{ $message }}</p>@enderror
                            </div>
							<div class="form-group">
                                <label for="new_pass">پسورد جدید</label>
                                <input type="password" 
									   name="new_pass" 
									   id="new_pass" 
									   class="form-control"
									   autocomplete="off" 
                                       placeholder="پسورد جدید"/>
                                @error('new_pass')<p class="text-danger">{{ $message }}</p>@enderror
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="btn btn-primary btn-xs form-submit" value="ثبت نام"/>
                            </div>
							
						</form>
					</div>
				</div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div>
	
@endsection

@section('style')
  <style>
	
  </style>
@endsection

@section('script')
<script type="text/javascript">
   
</script>
@endsection