<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <span class="brand-text font-weight-light">پنل مدیریت</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <div>
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="info">
            @auth
				<a href="#">
					<strong>کاربر : {{Auth()->user()->user_name}}</strong>
				</a>
			@endif
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
		  
			<li>
				<a href="{{ route('adminDashboard') }}" class="nav-link active">
					<i class="nav-icon fa fa-home"></i>
					<p>
						صفحه اصلی
					</p>
				 </a>
			</li>
			
			<li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-dashboard"></i>
                <p>
                  مدیریت موقعیت
                  <i class="right fa fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('floors.create') }}" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p> افزودن طبقه ها </p>
                  </a>
                </li>
				<li class="nav-item">
                  <a href="{{ route('floors.index') }}" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p> لیست طبقه ها </p>
                  </a>
                </li>
				<li class="nav-item">
                  <a href="{{ route('tables.create') }}" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p> افزودن میز </p>
                  </a>
                </li>
				<li class="nav-item">
                  <a href="{{ route('tables.index') }}" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p> لیست میزها </p>
                  </a>
                </li>
              </ul>
            </li>  <!-- /.dropdown-menu -->
			
			<li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-dashboard"></i>
                <p>
                  مدیریت مینوی غذایی
                  <i class="right fa fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('categories.create') }}" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p> افزودن دسته </p>
                  </a>
                </li>
				<li class="nav-item">
                  <a href="{{ route('categories.index') }}" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p> لیست دسته ها </p>
                  </a>
                </li>
				<li class="nav-item">
                  <a href="{{ route('menus.create') }}" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p> افزودن مینویی غذایی </p>
                  </a>
                </li>
				<li class="nav-item">
                  <a href="{{ route('menus.index') }}" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p> لیست مینویی غذایی </p>
                  </a>
                </li>
              </ul>
            </li>  <!-- /.dropdown-menu -->
			
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-dashboard"></i>
                <p>
                  تنظیمات
                  <i class="right fa fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('users.create') }}" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p> افزودن کاربر </p>
                  </a>
                </li>
				<li class="nav-item">
                  <a href="{{ route('users.index') }}" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p> لیست کاربر </p>
                  </a>
                </li>
              </ul>
            </li>  <!-- /.dropdown-menu -->
			<li class="nav-item">
              <a href="{{ route('logout') }}" class="nav-link">
                <i class="nav-icon fa fa-dashboard"></i>
                <p>
                  خروج
                </p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
    </div>
    <!-- /.sidebar -->
  </aside>