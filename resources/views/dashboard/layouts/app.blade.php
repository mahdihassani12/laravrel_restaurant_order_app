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
  <link rel="stylesheet" href="{{ asset('/assets/custom/custom.css') }}">
  @yield('style')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

@include('dashboard.partials.header')

@include('dashboard.partials.sidebar')  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">

        @include('dashboard.messages.messages')

        @yield('main_content')

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@include('dashboard.partials.footer')
</div>
<!-- ./wrapper -->

<script src="{{ asset('/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/assets/js/adminlte.min.js') }}"></script>
  @yield('script')
</body>
</html>