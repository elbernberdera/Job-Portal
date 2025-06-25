

<style>
.sidebar-gradient-bg {
    background: linear-gradient(135deg,rgb(11, 13, 134), #2d5193), url("{{ asset('assets/static/image/image2.png') }}");
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
}
</style>

<aside class="main-sidebar sidebar-dark-success elevation-4 sidebar-gradient-bg">
      <!-- Brand Logo -->
      <a href="{{ route('admin.dashboard') }}" class="brand-link" style="display: flex; justify-content: center; align-items: center;">
        <img src="{{ asset('assets/static/image/image3.png') }}"
             alt="Logo"
             style="width: 110px; height: 80px; " />
      </a>

       <!-- Sidebar -->
    <div class="sidebar" style="color: #000!important;">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <!-- Optionally add a user image here -->
            </div>
            <div class="info">
                <a href="#" class="d-block" style="color: #fbf8f8!important; font-weight: 30px; text-decoration: none;">
                    {{ Auth::user()->first_name ?? '' }} {{ Auth::user()->last_name ?? '' }}
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
              <a href="{{ route('hr.dashboard') }}" class="nav-link {% if request.resolver_match.url_name == '' %}bg-success text-white{% endif %}" style="color: #fdfafa!important;">
                <i class="nav-icon fas fa-home" style="color: #fbf8f8!important;"></i>
                <p>Home</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('job_vacancies') }}" class="nav-link {% if request.resolver_match.url_name == '' %}bg-success text-white{% endif %}" style="color: #fdfafa!important;">
                <i class="nav-icon fas fa-users" style="color: #fbf8f8!important;"></i>
                <p>Job Vacancies</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="" class="nav-link {% if request.resolver_match.url_name == '' %}bg-success text-white{% endif %}" style="color: #fdfafa!important;">
                <i class="nav-icon fas fa-users" style="color: #fbf8f8!important;"></i>
                <p>Qualified applicant</p>
              </a>
            </li>


                <!-- Add more nav-items here as needed -->
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
      <!-- /.sidebar -->
    </aside>
