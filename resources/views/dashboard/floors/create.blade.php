@extends('dashboard.layouts.app')
@section('main_content')
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0 text-dark">افزودن طبقات رستورانت</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
		
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-sm-12">
				<div class="card">
					<div class="card-header"> افزودن طبقه جدید </div>
					<div class="card-body">
						<form method="post" action="{{ route('floors.store') }}">
							@csrf
							
							<div class="form-group">
								<label for="floor_name"> نام طبقه </label>
								<input type="text" 
									   name="floor_name" 
									   id="floor_name" 
									   placeholder="نام طبقه"
									   class="form-control" 
									   autocomplete="off"
									   />
								@error('floor_name')<p class="text-danger">{{ $message }}</p>@enderror
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