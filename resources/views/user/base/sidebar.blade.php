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
      <!-- <a href="{{ route('admin.dashboard') }}" class="brand-link" style="display: flex; justify-content: center; align-items: center;">
        <img src="{{ asset('assets/static/image/image3.png') }}"
             alt="Logo"
             style="width: 110px; height: 80px; " />
      </a> -->

       <!-- Sidebar -->
    <div class="sidebar" style="color: #000!important;">
        <!-- Sidebar user panel (optional) -->
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
                <a href="{{ route('user.profile') }}" class="d-block" style="color: #fbf8f8!important; font-weight: bold; text-decoration: none; text-transform: capitalize;">
                    {{ Auth::user()->first_name ?? '' }} {{ Auth::user()->last_name ?? '' }}
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
              <a href="{{ route('user.dashboard') }}" class="nav-link {% if request.resolver_match.url_name == '' %}bg-success text-white{% endif %}" style="color: #fdfafa!important;">
                <i class="nav-icon fas fa-home" style="color: #fbf8f8!important;"></i>
                <p>Home</p>
              </a>
            </li>

            <li class="nav-item">
             
            </li>


                <!-- Add more nav-items here as needed -->
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
      <!-- /.sidebar -->
    </aside>
