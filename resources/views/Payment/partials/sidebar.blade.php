<style>
    .nav-item ul{
        display: none;
    }

    .nav-item.menu-open ul{
        display: block;
    }
</style>
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
                        <a href="{{ route('kitchenDashboard') }}" class="nav-link active">
                            <i class="nav-icon fa fa-home"></i>
                            <p>
                                صفحه اصلی
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('paymentInsideList') }}" class="nav-link">
                            <i class="fa fa-outdent"></i>
                            <p> لیست سفارشات داخلی </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('paymentOutsideList') }}" class="nav-link">
                            <i class="fa fa-indent"></i>
                            <p> لیست سفارشات بیرونی</p>
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

<script>
    $(document).ready(function(){
        $('.has-treeview > a').click(function () {
            if($(this).parent().hasClass("menu-open")){
                $('.nav-item').removeClass("menu-open");
            }else{
                $('.nav-item').removeClass("menu-open");
                $(this).parent().addClass("menu-open");
            }
        });
    });
</script>