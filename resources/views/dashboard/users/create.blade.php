@extends('dashboard.layouts.app')
@section('main_content')
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0 text-dark"> افزودن کاربر جدید </h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
		
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-sm-12">
				<div class="card">
					<div class="card-header"> افزودن کاربر </div>
					<div class="card-body">
						<form method="POST" action="{{ route('users.store') }}" 
                                            class="register-form" id="register-form">

                             @csrf               
                            <div class="form-group">
                                <label for="name">نام کاربر</label>
                                <input type="text" 
									   name="name" 
									   id="name"
									   class="form-control"
									   autocomplete="off" 
									   placeholder="نام"/>
                                @error('name')<p class="text-danger">{{ $message }}</p>@enderror
                            </div>
                            <div class="form-group">
                                <label for="email">ایمیل</label>
                                <input type="email" 
									   name="email" 
									   id="email"
									   class="form-control"		
									   autocomplete="off" 
                                       placeholder="ایمیل آدرس"/>
                                @error('email')<p class="text-danger">{{ $message }}</p>@enderror
                            </div>
							<div class="form-group">
								<label for="role">نقش کاربری</label>
								<select name="role" class="form-control" id="role">
									<option value=" "> انتخاب نقش کاربری </option>
									<option value="admin"> مدیر  کل </option>
									<option value="kitchen"> آشپزخانه </option>	
									<option value="accountant"> حسابداری </option>	
									<option value="order"> ثبت سفارش </option>	
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