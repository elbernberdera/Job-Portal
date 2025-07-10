<style>
.sidebar-gradient-bg {
  background: linear-gradient(135deg,rgb(6, 10, 204),rgb(114, 143, 239)), url("{{ asset('assets/static/image/image2.png') }}");
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
}
  .active-custom {
    background: #fff !important;
    color: #007bff !important;
  }
  .active-custom .nav-icon {
    color: #007bff !important;
  }
</style>

<aside class="main-sidebar sidebar-dark-success elevation-4 sidebar-gradient-bg">
      <!-- Brand Logo -->
      <!-- <a href="{{ route('admin.dashboard') }}" class="brand-link" style="display: flex; justify-content: center; align-items: center;">
        <img src="{{ asset('assets/static/image/image3.png') }}"
             alt="Logo"
             style="width: 110px; height: 80px; " />
      </a> -->

       <!-- Sidebar -->
    <div class="sidebar" style="color: #000!important;">
    <div class="user-panel mt-4 pb-4 mb-4 d-flex flex-column align-items-center">
            <div class="position-relative" style="width: 120px; height: 120px;">
                <img
                    src="{{ Auth::user()->profile_image ? asset('storage/profile_images/' . Auth::user()->profile_image) : asset('assets/images/image7.png') }}"
                    alt=""
                    class="rounded-circle"
                    style="width: 100%; height: 100%; object-fit: cover; border: 4px solid #fff;"
                >
                <form id="profileImageForm" action="{{ route('user.profile.upload') }}" method="POST" enctype="multipart/form-data" style="position: absolute; bottom: 0; right: 0;">
                    @csrf
                    <label for="profileImageInput" style="cursor: pointer;">
                        <span style="background: #1abc9c; border-radius: 50%; padding: 8px;">
                            <i class="fa fa-camera" style="color: #fff;"></i>
                        </span>
                        <input type="file" id="profileImageInput" name="profile_image" accept="image/*" capture="user" style="display: none;" onchange="document.getElementById('profileImageForm').submit();">
                    </label>
                </form>
            </div>
            <div class="info mt-2">
                <a href="" class="d-block" style="color: #fbf8f8!important; font-weight: bold; text-decoration: none; text-transform: capitalize;">
                    {{ Auth::user()->first_name ?? '' }} {{ Auth::user()->last_name ?? '' }}
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
              <a href="{{ route('hr.dashboard') }}"
                 class="nav-link {{ request()->routeIs('hr.dashboard') ? 'active-custom' : '' }}"
                 style="{{ request()->routeIs('hr.dashboard') ? 'background: #fff; color: #007bff !important;' : 'color: #fdfafa!important;' }}">
                <i class="nav-icon fas fa-home" style="{{ request()->routeIs('hr.dashboard') ? 'color: #007bff !important;' : 'color: #fbf8f8!important;' }}"></i>
                <p>Home</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('job_vacancies') }}"
                 class="nav-link {{ request()->routeIs('job_vacancies') ? 'active-custom' : '' }}"
                 style="{{ request()->routeIs('job_vacancies') ? 'background: #fff; color: #007bff !important;' : 'color: #fdfafa!important;' }}">
                <i class="nav-icon fas fa-users" style="{{ request()->routeIs('job_vacancies') ? 'color: #007bff !important;' : 'color: #fbf8f8!important;' }}"></i>
                <p>Job Vacancies</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('hr.qualified-applicants') }}"
                 class="nav-link {{ request()->routeIs('hr.qualified-applicants') ? 'active-custom' : '' }}"
                 style="{{ request()->routeIs('hr.qualified-applicants') ? 'background: #fff; color: #007bff !important;' : 'color: #fdfafa!important;' }}">
                <i class="nav-icon fas fa-user-check" style="{{ request()->routeIs('hr.qualified-applicants') ? 'color: #007bff !important;' : 'color: #fbf8f8!important;' }}"></i>
                <p>Qualified Applicants</p>
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
