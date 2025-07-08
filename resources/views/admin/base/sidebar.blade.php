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
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'bg-success text-white' : '' }}" style="color: #fdfafa!important;">
                        <i class="nav-icon fas fa-tachometer-alt" style="color: #fbf8f8!important;"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- User Management Section -->
                <li class="nav-item has-treeview {{ request()->routeIs('admin.applicants*') || request()->routeIs('admin.hr-accounts*') || request()->routeIs('admin.admin-accounts*') || request()->routeIs('admin.accounts*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link" style="color: #fdfafa!important;">
                        <i class="nav-icon fas fa-users-cog" style="color: #fbf8f8!important;"></i>
                        <p>
                            User Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <!-- Applicants -->
                        <li class="nav-item">
                            <a href="{{ route('admin.applicants') }}" class="nav-link {{ request()->routeIs('admin.applicants*') ? 'bg-success text-white' : '' }}" style="color: #fdfafa!important;">
                                <i class="far fa-circle nav-icon" style="color: #fbf8f8!important;"></i>
                                <p>Applicants</p>
                            </a>
                        </li>
                        
                        <!-- HR Accounts -->
                        <li class="nav-item">
                            <a href="{{ route('admin.hr-accounts') }}" class="nav-link {{ request()->routeIs('admin.hr-accounts*') ? 'bg-success text-white' : '' }}" style="color: #fdfafa!important;">
                                <i class="far fa-circle nav-icon" style="color: #fbf8f8!important;"></i>
                                <p>HR Accounts</p>
                            </a>
                        </li>
                        
                        <!-- Admin Accounts -->
                        <li class="nav-item">
                            <a href="{{ route('admin.admin-accounts') }}" class="nav-link {{ request()->routeIs('admin.admin-accounts*') ? 'bg-success text-white' : '' }}" style="color: #fdfafa!important;">
                                <i class="far fa-circle nav-icon" style="color: #fbf8f8!important;"></i>
                                <p>Admin Accounts</p>
                            </a>
                        </li>
                        
                        <!-- All Users (Legacy) -->
                        <li class="nav-item">
                            <a href="{{ route('admin.accounts') }}" class="nav-link {{ request()->routeIs('admin.accounts') ? 'bg-success text-white' : '' }}" style="color: #fdfafa!important;">
                                <i class="far fa-circle nav-icon" style="color: #fbf8f8!important;"></i>
                                <p>All Users</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Job Management -->
                <li class="nav-item">
                    <a href="{{ route('admin.job_positions.index') }}" class="nav-link {{ request()->routeIs('admin.job_positions*') ? 'bg-success text-white' : '' }}" style="color: #fdfafa!important;" title="View, approve, edit, or remove job posts from HRs">
                        <i class="nav-icon fas fa-file-alt" style="color: #fbf8f8!important;"></i>
                        <p>Job Post Management</p>
                    </a>
                </li>

                <!-- System Settings / Configuration -->
                <li class="nav-item has-treeview {{ request()->routeIs('admin.system-settings*') || request()->routeIs('admin.site-config*') || request()->routeIs('admin.job-categories*') || request()->routeIs('admin.locations*') || request()->routeIs('admin.industries*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link" style="color: #fdfafa!important;">
                        <i class="nav-icon fas fa-cogs" style="color: #fbf8f8!important;"></i>
                        <p>
                            System Settings
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <!-- Site Configuration -->
                        <li class="nav-item">
                            <a href="{{ route('admin.site-config') }}" class="nav-link {{ request()->routeIs('admin.site-config*') ? 'bg-success text-white' : '' }}" style="color: #fdfafa!important;">
                                <i class="far fa-circle nav-icon" style="color: #fbf8f8!important;"></i>
                                <p>Site Configuration</p>
                            </a>
                        </li>
                        
                        <!-- Job Categories -->
                        <li class="nav-item">
                            <a href="{{ route('admin.job-categories') }}" class="nav-link {{ request()->routeIs('admin.job-categories*') ? 'bg-success text-white' : '' }}" style="color: #fdfafa!important;">
                                <i class="far fa-circle nav-icon" style="color: #fbf8f8!important;"></i>
                                <p>Job Categories</p>
                            </a>
                        </li>
                        
                        <!-- Locations -->
                        <li class="nav-item">
                            <a href="{{ route('admin.locations') }}" class="nav-link {{ request()->routeIs('admin.locations*') ? 'bg-success text-white' : '' }}" style="color: #fdfafa!important;">
                                <i class="far fa-circle nav-icon" style="color: #fbf8f8!important;"></i>
                                <p>Locations</p>
                            </a>
                        </li>
                        
                        <!-- Industries -->
                        <li class="nav-item">
                            <a href="{{ route('admin.industries') }}" class="nav-link {{ request()->routeIs('admin.industries*') ? 'bg-success text-white' : '' }}" style="color: #fdfafa!important;">
                                <i class="far fa-circle nav-icon" style="color: #fbf8f8!important;"></i>
                                <p>Industries</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- System Logs -->
                <li class="nav-item">
                    <a href="{{ route('admin.logs') }}" class="nav-link {{ request()->routeIs('admin.logs*') ? 'bg-success text-white' : '' }}" style="color: #fdfafa!important;">
                        <i class="nav-icon fas fa-clipboard-list" style="color: #fbf8f8!important;"></i>
                        <p>System Logs</p>
                    </a>
                </li>


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
      <!-- /.sidebar -->
    </aside>
