<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quản lý</title>

    <!-- Google Font: Source Sans Pro -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('asset/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{asset('asset/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- iCheck -->
    {{-- <link rel="stylesheet" href="{{asset('asset/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}"> --}}
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{asset('asset/plugins/jqvmap/jqvmap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('asset/plugins/css/adminlte.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('asset/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('asset/plugins/daterangepicker/daterangepicker.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('asset/plugins/summernote/summernote-bs4.min.css')}}">
    <!-- jQuery -->
    <script src="{{asset('asset/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('asset/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('asset/plugins/select2/css/select2.min.css')}}">
    @yield('header_scripts')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->


        <!-- Navbar -->
        @include('admin.includes.header')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('admin.includes.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper content-header">
            <div class="container">
                @yield('content')
            </div>
        </div>
        <!-- /.content-wrapper -->
        @include('admin.includes.footer')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->


    <script src="{{asset('asset/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <script src="{{asset('asset/plugins/sparklines/sparkline.js')}}"></script>
    <script src="{{asset('asset/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
    <script src="{{asset('asset/plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('asset/plugins/daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{asset('asset/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <script src="{{asset('asset/plugins/summernote/summernote-bs4.min.js')}}"></script>
    <script src="{{asset('asset/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
    <script src="{{asset('asset/plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('asset/plugins/js/adminlte.js')}}"></script>
    <script>
        $(function() {
            if($('.select2').length){
                $('.select2').select2()
            }
        });
    </script>
    @yield('footer_scripts')
</body>

</html>