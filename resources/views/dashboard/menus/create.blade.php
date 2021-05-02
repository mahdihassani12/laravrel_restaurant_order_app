@extends('dashboard.layouts.app')
@section('main_content')
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0 text-dark"> افزودن مینویی غذایی </h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
		
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-sm-12">
				<div class="card">
					<div class="card-header"> افزودن مینویی جدید </div>
					<div class="card-body">
						<form method="post" action="{{ route('menus.store') }}">
							@csrf
							
							<div class="form-group">
								<label for="name"> نام مینو </label>
								<input type="text" 
									   name="name" 
									   id="name" 
									   placeholder="نام مینو"
									   class="form-control" 
									   autocomplete="off"
									   />
								@error('name')<p class="text-danger">{{ $message }}</p>@enderror
							</div>
							
							<div class="form-group">
								<label for="price"> قیمت </label>
								<input type="number" 
									   name="price"
									   class="form-control"
									   id="price"
									   placeholder="قیمت"
									   autocomplete="off"
									   />
								@error('price')<p class="text-danger">{{ $message }}</p>@enderror
							</div>
							
							<div class="form-group">
								<label for="category"> انتخاب دسته </label>
								<select class="form-control" name="category" id="category">
									<option value=""> دسته غذایی را انتخاب کنید </option>
									@foreach($categories as $category)
										<option value="{{ $category->category_id }}">{{ $category->name }}</option>
									@endforeach
								</select>	
							</div>
							
							<div class="form-group">
								<button type="submit" class="btn btn-primary btn-xs"> ارسال </button>
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