@extends('dashboard.layouts.app')
@section('main_content')
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0 text-dark">ویرایش دسته های مینوی غذایی</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
		
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-sm-12">
				<div class="card">
					<div class="card-header"> ویرایش دسته </div>
					<div class="card-body">
						<form method="post" action="{{ route('categories.update',$category->category_id) }}">
							@method('put')
							@csrf
							<div class="form-group">
								<label for="name"> نام دسته </label>
								<input type="text" 
									   name="name" 
									   id="name" 
									   value="{{ $category->name }}"
									   class="form-control" 
									   autocomplete="off"
									   />
								@error('name')<p class="text-danger">{{ $message }}</p>@enderror
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