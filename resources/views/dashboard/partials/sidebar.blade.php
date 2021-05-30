<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <span class="brand-text font-weight-light" style="margin-right: 25px">پنل مدیریت</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <div>
            <!-- Sidebar user panel (optional) -->
            <div class="row" style="text-align: center !important;">

                <div class="photo">
                    <img src="{{asset('images/user.png')}}" id="user_img" style="width: 130px
                         !important;height: 130px !important;
                          margin-right: 40px;
                           border-radius: 50%;
                            padding: 15px">
                </div>
            </div>
            <div class="row" style="border-bottom: 1px solid #80808087;padding-bottom: 15px">
                <div class="info">
                    @auth
                        <a href="#">
                            <strong style="margin-right: 55px;">کاربر : {{Auth()->user()->user_name}}</strong>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">

                    <li>
                        <a href="{{ route('adminDashboard') }}" class="nav-link active">
                            <i class="nav-icon fa fa-home"></i>
                            <p>
                                صفحه اصلی
                            </p>
                        </a>
                    </li>

                    <li class="nav-item has-treeview collapse show ">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-location-arrow"></i>
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
                            <i class="nav-icon fa fa-file-archive-o"></i>
                            <p>
                                مدیریت مِنویی غذایی
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
                                    <p> افزودن مِنویی غذایی </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('menus.index') }}" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p> لیست مِنویی غذایی </p>
                                </a>
                            </li>
                        </ul>
                    </li>  <!-- /.dropdown-menu -->

                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-refresh"></i>
                            <p>
                                بخش گزارشات
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('reportAll') }}" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p> گزارش کلی </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('reportInside') }}" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p> گزارش سفارشات داخلی </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('reportOutside') }}" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p> گزارش سفارشات بیرونی </p>
                                </a>
                            </li>

                        </ul>
                    </li>  <!-- /.dropdown-menu -->
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-cogs"></i>
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
                            <i class="nav-icon fa fa-power-off"></i>
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
@section('style')
    <style>
        .nav-item ul{
            display: none;
        }

        .nav-item.menu-open ul{
            display: block;
        }
    </style>
@endsection

