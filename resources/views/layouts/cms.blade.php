<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Bimbo</title>
  <link rel="icon" href="{{ asset('/') }}/bbu.png">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="base-url" content="{{ url('') }}">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('admin/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('admin/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('admin/bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
   <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('admin/bower_components/select2/dist/css/select2.min.css') }}"></script>
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('admin/dist/css/AdminLTE.min.css') }}">
   <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('admin/dist/css/skins/_all-skins.min.css') }}">
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset('admin/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
  <!-- sweetalert2 -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/sweetalert/sweetalert.css') }}">
  <style>
  	.mt-5
	{
		margin-top: 5px;
	}
	.mb-5
	{
		margin-bottom: 5px;
	}
  </style>
  @stack('style')
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="{{ url('/home') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>B</b>BM</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Bimbo</b>App</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ asset('demo_user.png') }}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ Auth::User()->username }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{ asset('demo_user.png') }}" class="img-circle" alt="User Image">

                <p>
                  {{ Auth::User()->username }} - {{ Auth::User()->facility_code }}
                  <small>Member since Nov. {{ Auth::User()->create_user }}</small>
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{ url('/logout') }}" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset('demo_user.png') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::User()->username }}</p>
        </div>
      </div>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
      	@if(Auth::User()->role_id=="1")
        <li class="{{ (request()->is('manufacturingreceipts*')) ? 'active' : '' }}">
          <a href="{{ url('/manufacturingreceipts') }}">
            <i class="fa fa-industry"></i> <span>Manufacturing Receipts</span>
          </a>
        </li>
        @endif
        @if(Auth::User()->role_id=="1")
        <li class="{{ (request()->is('owmitem*')) ? 'active' : '' }}">
          <a href="{{ url('/owmitem') }}">
            <i class="fa fa-university"></i> <span>Warehouse Items</span>
          </a>
        </li>
        @endif
        @if(Auth::User()->role_id=="1" || Auth::User()->role_id=="2")
        <li class="{{ (request()->is('processreceipts*')) ? 'active' : '' }}">
          <a href="{{ url('/processreceipts') }}">
            <i class="fa fa-refresh"></i> <span>Process Receipts</span>
          </a>
        </li>
        @endif
        @if(Auth::User()->role_id=="1")
        <li class="{{ (request()->is('freezerlpn*')) ? 'active' : '' }}">
          <a href="{{ url('/freezerlpn') }}">
            <i class="fa fa-columns"></i> <span>Freezer LPN</span>
          </a>
        </li>
        @endif
        @if(Auth::User()->role_id=="1")
        <li class="{{ (request()->is('order*')) ? 'active' : '' }}">
          <a href="{{ url('/order') }}">
            <i class="fa fa-shopping-cart"></i> <span>Order</span>
          </a>
        </li>
        @endif
        @if(Auth::User()->role_id=="1")
        <li class="{{ (request()->is('print_report*')) ? 'active' : '' }}">
          <a href="{{ url('/completions_report') }}">
            <i class="fa fa-file"></i> <span>Completions Report</span>
          </a>
        </li>
        @endif
        @if(Auth::User()->is_admin=="1")
        <li class="{{ (request()->is('users*')) ? 'active' : '' }}">
          <a href="{{ url('users') }}">
            <i class="fa fa-users"></i> <span>User Management</span>
          </a>
        </li>
        <li class="{{ (request()->is('parameter*')) ? 'active' : '' }}">
          <a href="{{ url('parameter') }}">
            <i class="fa fa-cog"></i> <span>Parameter</span>
          </a>
        </li>
        @endif
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      @yield('content-header')
    </section>
    
    
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    
    @if ($message = Session::get('exp-error'))
        <div class="alert alert-error">
            <p>{{ $message }}</p>
        </div>
    @endif

    <!-- Main content -->
    <section class="content">
    @yield('content')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0
    </div>
    <strong>Copyright &copy; 2020 <a href="#">Bimbo App</a>.</strong> All rights
    reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{ asset('admin/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('admin/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('admin/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('admin/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('admin/bower_components/datatables.net/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('admin/bower_components/datatables.net/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('admin/bower_components/datatables.net/js/jszip.min.js') }}"></script> 
<script src="{{ asset('admin/bower_components/datatables.net/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('admin/bower_components/datatables.net/js/buttons.print.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('admin/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<!-- date-range-picker -->
<script src="{{ asset('admin/bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('admin/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('admin/dist/js/adminlte.min.js') }}"></script>
<script src="{{ asset('admin/plugins/sweetalert/sweetalert.min.js') }}"></script>

<script>
	$('.select2').select2();
</script>
@stack('scripts')
</body>
</html>
