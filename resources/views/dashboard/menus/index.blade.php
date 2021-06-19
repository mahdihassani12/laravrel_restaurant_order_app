@extends('dashboard.layouts.app')
@section('main_content')
		
<div class="content-header">
  <div class="container-fluid">
	<div class="row mb-2">
	  <div class="col-sm-12">
		<h1 class="m-0 text-dark text-center"> لیست مِنوها </h1>
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
						@foreach($categories as $key=> $category)
							<a @if($category->category_id==1)class="nav-item nav-link active"
							   @else class="nav-item nav-link" @endif id="nav-home-tab" data-toggle="tab"
							   href="#food{{$key}}" category_id = "{{$category->category_id}}"
							   role="tab" aria-controls="nav-home"
							   aria-selected="true">{{$category->name}}</a>
						@endforeach
					</div>
				</nav>
				<div class="tab-content" id="nav-tabContent" >
					<div class="tab-pane fade show active" id="food" role="tabpanel" aria-labelledby="nav-home-tab">
						<table class="table" cellspacing="0">
							<thead>
								<tr>
									<th> # </th>
									<th>نام </th>
									<th>قیمت</th>
									<th>عملیات</th>
								</tr>
							</thead>
							<tbody id="tbody">
							@foreach($menu as $index => $f)
								<tr>
									<td>{{ $index + 1 }}</td>
									<td>{{ $f-> name }}</td>
									<td>{{ $f-> price }}</td>
									<td>
										<a href="{{ route('menus.edit',$f->menu_id) }}"><i class="fa fa-edit"></i></a>
										/
										<form method="post"
											  id="form_delete"
											  action="{{ route('menus.destroy',$f->menu_id) }}">
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
									<th> # </th>
									<th>نام </th>
									<th>قیمت</th>
									<th>عملیات</th>
								</tr>
							</tfoot>
						</table>
						<div id="pagination">
							{{$menu->links()}}
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</section>
	
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
    $(document).ready(function(){
        $('a.nav-item').click(function () {

            var id=$(this).attr('category_id')
            $.ajax({
                type: "GET",
                url: "getMenus",
                data: {
                    'id':id
                },
                success: function (msg) {
                    $("#tbody").empty();
                    $("#tbody").html(msg);

                }
            });
        })

        var url = document.location.toString();
        if (url.match('#')) {
            $('.nav-tabs a[href="#' + url.split('#')[1] + '"]')[0].click();
        }

        //To make sure that the page always goes to the top
        setTimeout(function () {
            window.scrollTo(0, 0);
        },200);

    });
</script>
@endsection