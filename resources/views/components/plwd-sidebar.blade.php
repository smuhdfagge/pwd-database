<!-- PLWD Sidebar -->
<div class="col-md-3 col-lg-2 px-0 sidebar">
    <div class="py-4">
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('plwd.dashboard') ? 'active' : '' }}" href="{{ route('plwd.dashboard') }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('plwd.profile.edit') ? 'active' : '' }}" href="{{ route('plwd.profile.edit') }}">
                <i class="fas fa-user-edit"></i> Edit Profile
            </a>
            <a class="nav-link {{ request()->routeIs('opportunities.index') ? 'active' : '' }}" href="{{ route('opportunities.index') }}">
                <i class="fas fa-briefcase"></i> Opportunities
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
