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
				<a href="{{ route('kitchenDashboard') }}" class="nav-link active">
					<i class="nav-icon fa fa-home"></i>
					<p>
						صفحه اصلی
					</p>
				 </a>
			</li>
          <li class="nav-item">
              <a href="{{ route('getOrders') }}" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p> لیست سفارشات </p>
              </a>
          </li>

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