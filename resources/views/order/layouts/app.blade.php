<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>پنل مدیریت | شروع سریع</title>
  <link rel="stylesheet" href="{{ asset('/assets/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/assets/css/adminlte.min.css') }}">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap-rtl.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/assets/css/custom-style.css') }}">
  <link rel="stylesheet" href="{{ asset('/assets/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/assets/custom/custom.css') }}">
  <link rel="stylesheet" href="{{asset('assets/datatables/media/css/dataTables.bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/datatables/extensions/Responsive/css/responsive.bootstrap.min.css')}}">
  @yield('style')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

@include('order.partials.header')

@include('order.partials.sidebar')  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">

        @include('order.messages.messages')

        @yield('main_content')

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@include('order.partials.footer')
</div>
<!-- ./wrapper -->

<script src="{{ asset('/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/assets/js/adminlte.min.js') }}"></script>

<script src="{{ asset('/assets/js/select2.min.js') }}"></script>
<script src="{{asset('assets/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('assets/datatables/media/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/datatables/media/js/buttons.flash.min.js')}}"></script>
<script src="{{asset('assets/datatables/media/js/jszip.min.js')}}"></script>
<script src="{{asset('assets/datatables/media/js/vfs_fonts.js')}}"></script>
<script src="{{asset('assets/datatables/media/js/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/datatables/media/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/datatables/media/js/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/datatables/extensions/Responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/datatables/extensions/Responsive/js/responsive.bootstrap.min.js')}}"></script>
  @yield('script')
</body>
</html>