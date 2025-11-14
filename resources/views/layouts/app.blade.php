<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'V-PeSDI PLWDs Database'))</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Custom CSS -->
        <style>
            :root {
                --primary-green: #28a745;
                --dark-bg: #212529;
            }
            
            .btn-primary {
                background-color: var(--primary-green);
                border-color: var(--primary-green);
            }
            
            .btn-primary:hover {
                background-color: #218838;
                border-color: #1e7e34;
            }
            
            .text-primary {
                color: var(--primary-green) !important;
            }
            
            .bg-primary {
                background-color: var(--primary-green) !important;
            }
            
            .border-primary {
                border-color: var(--primary-green) !important;
            }
            
            .card {
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            }
            
            .sidebar {
                position: fixed;
                top: 56px;
                bottom: 0;
                left: -100%;
                z-index: 1050;
                padding: 0;
                box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
                background: linear-gradient(180deg, var(--dark-bg) 0%, #343a40 100%);
                overflow-y: auto;
                width: 280px;
                transition: left 0.3s ease-in-out;
            }
            
            .sidebar.show {
                left: 0;
            }
            
            .sidebar-overlay {
                position: fixed;
                top: 56px;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1040;
                display: none;
            }
            
            .sidebar-overlay.show {
                display: block;
            }
            
            .sidebar-toggle {
                position: fixed;
                top: 65px;
                left: 10px;
                z-index: 1030;
                background-color: var(--primary-green);
                border: none;
                border-radius: 5px;
                padding: 8px 12px;
                color: white;
                cursor: pointer;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            }
            
            .sidebar-toggle:hover {
                background-color: #218838;
            }
            
            /* Add left margin to main content when sidebar is visible */
            @media (min-width: 768px) {
                .sidebar {
                    left: 0;
                    width: 25%; /* col-md-3 */
                }
                .sidebar-toggle {
                    display: none;
                }
                .sidebar-overlay {
                    display: none !important;
                }
                .main-content-with-sidebar {
                    margin-left: 25% !important;
                    width: 75% !important;
                }
            }
            
            @media (min-width: 992px) {
                .sidebar {
                    width: 16.666667%; /* col-lg-2 */
                }
                .main-content-with-sidebar {
                    margin-left: 16.666667% !important;
                    width: 83.333333% !important;
                }
            }
            
            .main-content-with-sidebar {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
            
            .sidebar .nav-link {
                color: rgba(255, 255, 255, 0.8);
                padding: 0.75rem 1rem;
                margin-bottom: 0.25rem;
                border-left: 3px solid transparent;
            }
            
            .sidebar .nav-link:hover {
                color: white;
                background-color: rgba(40, 167, 69, 0.2);
                border-left-color: var(--primary-green);
            }
            
            .sidebar .nav-link.active {
                color: white;
                background-color: rgba(40, 167, 69, 0.3);
                border-left-color: var(--primary-green);
            }
            
            .sidebar .nav-link i {
                margin-right: 0.5rem;
                width: 20px;
            }

            /* Submenu styles */
            .sidebar .submenu {
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease-out;
                background-color: rgba(0, 0, 0, 0.2);
            }

            .sidebar .submenu.show {
                max-height: 500px;
                transition: max-height 0.4s ease-in;
            }

            .sidebar .submenu .nav-link {
                padding-left: 3rem;
                font-size: 0.9rem;
            }

            .sidebar .nav-link .dropdown-arrow {
                float: right;
                transition: transform 0.3s ease;
            }

            .sidebar .nav-link .dropdown-arrow.rotate {
                transform: rotate(180deg);
            }
            
            .navbar {
                background: linear-gradient(135deg, var(--dark-bg) 0%, var(--primary-green) 100%);
            }
            
            .stat-card {
                border-left: 4px solid var(--primary-green);
            }
        </style>

        @yield('styles')

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('dashboard') }}">
                    <i class="fas fa-users"></i> V-PeSDI PLWDs Database
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle"></i> {{ Auth::user()->name ?? Auth::user()->email }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(Auth::user()->role === 'plwd')
                                    <li>
                                        <a class="dropdown-item" href="{{ route('plwd.profile.edit') }}">
                                            <i class="fas fa-user-edit"></i> Edit Profile
                                        </a>
                                    </li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main>
            @auth
                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'plwd')
                    <!-- Sidebar Toggle Button (Mobile Only) -->
                    <button class="sidebar-toggle" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <!-- Sidebar Overlay (Mobile Only) -->
                    <div class="sidebar-overlay" id="sidebarOverlay"></div>
                    
                    <div class="container-fluid">
                        <div class="row">
                            @if(Auth::user()->role === 'admin')
                                @include('components.admin-sidebar')
                            @elseif(Auth::user()->role === 'plwd')
                                @include('components.plwd-sidebar')
                            @endif
                            
                            <div class="col-md-9 col-lg-10 main-content-with-sidebar px-4 py-4">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                @else
                    @yield('content')
                @endif
            @else
                @yield('content')
            @endauth
        </main>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
        <!-- Sidebar Toggle Script -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const sidebarToggle = document.getElementById('sidebarToggle');
                const sidebar = document.querySelector('.sidebar');
                const sidebarOverlay = document.getElementById('sidebarOverlay');
                
                if (sidebarToggle && sidebar && sidebarOverlay) {
                    // Toggle sidebar on button click
                    sidebarToggle.addEventListener('click', function() {
                        sidebar.classList.toggle('show');
                        sidebarOverlay.classList.toggle('show');
                    });
                    
                    // Close sidebar when clicking on overlay
                    sidebarOverlay.addEventListener('click', function() {
                        sidebar.classList.remove('show');
                        sidebarOverlay.classList.remove('show');
                    });
                    
                    // Close sidebar when clicking on a link (mobile only)
                    const sidebarLinks = sidebar.querySelectorAll('.nav-link');
                    sidebarLinks.forEach(link => {
                        link.addEventListener('click', function() {
                            if (window.innerWidth < 768) {
                                sidebar.classList.remove('show');
                                sidebarOverlay.classList.remove('show');
                            }
                        });
                    });
                }
            });
        </script>
        
        @yield('scripts')
        @stack('scripts')
    </body>
</html>
