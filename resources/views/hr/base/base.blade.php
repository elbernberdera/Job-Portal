<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <title>DICT JOB PORTAL</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/static/images/image1.png') }}">
  
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/static/fontawesome-free/css/all.min.css') }}">
  
  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="{{ asset('assets/static/dist/css/adminlte.min.css') }}">
  
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('assets/static/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  
  <!-- DataTables CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
  
  @yield('custom_css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

  <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="margin-right: 20px;">
          <i class="fas fa-user"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown" style="right: 60px;">
          <li><hr class="dropdown-divider"></li>
          <li>
            <a href="{{ route('update_profile_hr') }}" class="dropdown-item">
              <i class="fas fa-user-edit mr-2"></i> Update Profile
            </a>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
            <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="fas fa-power-off mr-2"></i> Logout
            </a>
          </li>
          <li><hr class="dropdown-divider"></li>
        </ul>
      </li>
    </ul>

    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    @include('hr.base.sidebar', ['user' => $user ?? null, 'id' => $id ?? null])

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

    <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">
                @yield('page_title')
              </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <!-- <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li> -->
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      @yield('main_content')
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @include('hr.base.footer')

    
  </div>
  <!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('assets/static/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- AdminLTE App -->
<script src="{{ asset('assets/static/dist/js/adminlte.js') }}"></script>

<!-- DataTables -->
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>

<!-- Initialize DataTables -->
<script>
    $(document).ready(function() {
        $('#user_Table').DataTable({
            dom: 'Bfrtip',
            buttons: ['pdf', 'print'],
            responsive: true,
            pageLength: 10,
            order: [[0, 'asc']]
        });
    });
</script>

{{-- For Custom JS --}}
@yield('custom_js')

</body>
</html>
