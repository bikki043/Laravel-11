<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - LMS System</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --sidebar-bg: #1e293b;
            --sidebar-hover: #334155;
            --accent-color: #3b82f6;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: #f8fafc;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            color: white;
            position: fixed;
            height: 100vh;
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar-logo {
            padding: 25px;
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.5px;
            background: rgba(0,0,0,0.1);
        }

        .nav-link {
            color: #94a3b8;
            padding: 12px 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: 0.2s;
            border-left: 4px solid transparent;
        }

        .nav-link:hover {
            background: var(--sidebar-hover);
            color: white;
        }

        .nav-link.active {
            background: rgba(59, 130, 246, 0.1);
            color: var(--accent-color);
            border-left-color: var(--accent-color);
            font-weight: 600;
        }

        /* Top Navbar */
        .main-content { margin-left: 260px; min-height: 100vh; }
        
        .top-navbar {
            background: white;
            height: 70px;
            padding: 0 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .user-dropdown-btn {
            background: none;
            border: none;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 5px 10px;
            border-radius: 50px;
            transition: 0.2s;
        }

        .user-dropdown-btn:hover { background: #f1f5f9; }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e2e8f0;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
            border-radius: 12px;
            padding: 8px;
            min-width: 200px;
        }

        .dropdown-item {
            padding: 10px 15px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="sidebar">
            <div class="sidebar-logo d-flex align-items-center gap-2 text-white">
                <div class="bg-primary p-2 rounded-3">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <span>LMS Pro</span>
            </div>

            <nav class="mt-3">
                <a href="{{ route('dashboard') }}" class="nav-link @if(Route::is('dashboard')) active @endif">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>
                <a href="{{ route('students.index') }}" class="nav-link @if(Route::is('students.*')) active @endif">
                    <i class="fas fa-user-graduate"></i> Students
                </a>
                <a href="{{ route('teachers.index') }}" class="nav-link @if(Route::is('teachers.*')) active @endif">
                    <i class="fas fa-chalkboard-teacher"></i> Teachers
                </a>
                <a href="{{ route('profiles.index') }}" class="nav-link @if(Route::is('profiles.*')) active @endif">
                    <i class="fas fa-id-card"></i> Profiles
                </a>
                <a href="{{ route('chart.index') }}" class="nav-link @if(Route::is('chart.index')) active @endif">
                    <i class="fas fa-chart-pie"></i> Growth Chart
                </a>
            </nav>
        </div>

        <div class="main-content">
            <header class="top-navbar">
                <div class="fw-bold text-secondary text-uppercase small">
                    <i class="fas fa-chevron-right me-2 text-primary"></i>@yield('breadcrumb', 'Overview')
                </div>

                <div class="dropdown">
                    <button class="user-dropdown-btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <div class="text-end d-none d-sm-block">
                            <div class="fw-bold small text-dark" style="line-height: 1">{{ auth()->user()->name }}</div>
                            <span class="text-muted" style="font-size: 10px;">Administrator</span>
                        </div>
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0D6EFD&color=fff" class="user-avatar">
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li><h6 class="dropdown-header">Manage Account</h6></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user-circle text-muted"></i> Profile Settings</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-shield-alt text-muted"></i> Security</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </header>

            <main class="p-4">
                @if (session('success'))
                    <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>