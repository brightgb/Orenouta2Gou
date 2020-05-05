<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('adminlte.title', 'AdminLTE 2'))</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ asset('adminlte/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('adminlte/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skin -->
    <link rel="stylesheet" href="/adminlte/css/skins/skin-{{ config('adminlte.skin', 'blue') }}.min.css">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/jQueryUI/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/css/select2.min.css') }}">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">

    @yield('css')

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-{{ config('adminlte.skin', 'blue') }} sidebar-mini">
<div class="wrapper">

    <!-- Main Header -->
    @include('layout.admin.admin_header')

    <!-- Left side column. contains the logo and sidebar -->
    @include('layout.admin.admin_sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="margin-top: 30px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h3>@yield('content_header')</h3>
        </section>

        <!-- Main content -->
        <section class="content">

            @yield('content')

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->
<!-- Vue.js -->
<script src="{{ asset('js/lib/axios.min.js') }}"></script>
<script src="{{ asset('vue-croppa/vue.js') }}"></script>
<script src="{{ asset('js/lib/underscore-min.js') }}"></script>
<script src="{{ asset('js/admin/moment.js') }}"></script>
<!-- jQuery 2.1.4 -->
<script src="{{ asset('adminlte/plugins/jQuery/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/jQuery/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/jQuery/select2.full.min.js') }}" defer></script>
<!-- Bootstrap 3.3.5 -->
<script src="{{ asset('adminlte/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('vendor/adminlte/dist/js/app.min.js') }}"></script>

<script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('adminlte/plugins/datepicker/moment.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datepicker/bootstrap-datetimepicker.min.js') }}"></script>

@yield('js')

</body>
</html>