@extends('dashboard.layouts.app')
@section('main_content')
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0 text-dark">ویرایش میزهای رستورانت</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
		
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-sm-12">
				<div class="card">
					<div class="card-header"> ویرایش میز </div>
					<div class="card-body">
						<form method="post" action="{{ route('tables.update',$table->location_id) }}">
							@method('put')
							@csrf
							<div class="form-group">
								<label for="name"> نام میز </label>
								<input type="text" 
									   name="name" 
									   id="name" 
									   value="{{ $table->name }}"
									   class="form-control" 
									   autocomplete="off"
									   />
								@error('name')<p class="text-danger">{{ $message }}</p>@enderror
							</div>
							
							<div class="form-group">
								<label for="floor">نام طبقه</label>
								<select class="form-control" id="floor" name="floor">
									<option value=""> انتخاب طبقه </option>
									@foreach($floors as $floor)
										<option value="{{ $floor->floor_id }}" {{ $table->floor->floor_id == $floor->floor_id ? 'selected':' '}} >{{ $floor->floor_name }}</option>
									@endforeach
								</select>
								@error('floor')<p class="text-danger">{{ $message }}</p>@enderror
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