<!-- Admin Sidebar -->
<div class="col-md-3 col-lg-2 px-0 sidebar">
    <div class="py-4">
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                <i class="fas fa-user-friends"></i> All Users
            </a>
            <a class="nav-link {{ request()->routeIs('admin.plwds.*') ? 'active' : '' }}" href="{{ route('admin.plwds.index') }}">
                <i class="fas fa-users"></i> PLWD Profiles
            </a>
            <a class="nav-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}" href="{{ route('admin.reports') }}">
                <i class="fas fa-chart-bar"></i> Reports
            </a>
            <a class="nav-link {{ request()->routeIs('admin.audit-logs') ? 'active' : '' }}" href="{{ route('admin.audit-logs') }}">
                <i class="fas fa-history"></i> Audit Logs
            </a>
            <hr class="text-white">
            <!-- Configure Menu with Submenu -->
            <a class="nav-link {{ request()->routeIs('admin.disability-types') || request()->routeIs('admin.education-levels') || request()->routeIs('admin.skills') ? 'active' : '' }}" 
               href="javascript:void(0);" 
               onclick="toggleSubmenu(event)">
                <i class="fas fa-cog"></i> Configure
                <i class="fas fa-chevron-down dropdown-arrow"></i>
            </a>
            <div class="submenu {{ request()->routeIs('admin.disability-types') || request()->routeIs('admin.education-levels') || request()->routeIs('admin.skills') ? 'show' : '' }}">
                <a class="nav-link {{ request()->routeIs('admin.disability-types') ? 'active' : '' }}" href="{{ route('admin.disability-types') }}">
                    <i class="fas fa-list"></i> Disability Types
                </a>
                <a class="nav-link {{ request()->routeIs('admin.education-levels') ? 'active' : '' }}" href="{{ route('admin.education-levels') }}">
                    <i class="fas fa-graduation-cap"></i> Education Levels
                </a>
                <a class="nav-link {{ request()->routeIs('admin.skills') ? 'active' : '' }}" href="{{ route('admin.skills') }}">
                    <i class="fas fa-tools"></i> Skills
                </a>
            </div>
            
            <a class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}" href="{{ route('admin.settings') }}">
                <i class="fas fa-sliders-h"></i> Settings
            </a>
            <hr class="text-white">
            <form method="POST" action="{{ route('logout') }}" class="px-3">
                @csrf
                <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </nav>
    </div>
</div>

<script>
    function toggleSubmenu(event) {
        event.preventDefault();
        const link = event.currentTarget;
        const submenu = link.nextElementSibling;
        const arrow = link.querySelector('.dropdown-arrow');
        
        // Toggle submenu
        submenu.classList.toggle('show');
        arrow.classList.toggle('rotate');
    }
</script>
