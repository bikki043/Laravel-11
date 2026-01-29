<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - LMS System</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AdminLTE CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --primary-color: #1f2937;
            --secondary-color: #374151;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3f4f6;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background: var(--primary-color);
            color: white;
            padding: 20px;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }

        .sidebar-logo {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-link {
            color: #d1d5db;
            text-decoration: none;
            padding: 12px 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 5px;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .nav-link:hover {
            background: var(--secondary-color);
            color: white;
        }

        .nav-link.active {
            background: #3b82f6;
            color: white;
        }

        .main-content {
            margin-left: 250px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-size: 18px;
            font-weight: 600;
            color: var(--primary-color);
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #3b82f6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .content {
            padding: 2rem;
            flex: 1;
        }

        .card {
            border: none;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            border-radius: 8px;
        }

        .card-header {
            background: white;
            border-bottom: 2px solid #e5e7eb;
            padding: 15px 20px;
            font-weight: 600;
            color: var(--primary-color);
        }

        .btn-primary {
            background: #3b82f6;
            border: none;
            border-radius: 5px;
        }

        .btn-primary:hover {
            background: #2563eb;
        }

        .table {
            background: white;
            border-radius: 8px;
        }

        .table thead {
            background: #f3f4f6;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .stat-value {
            font-size: 32px;
            font-weight: bold;
            color: #3b82f6;
        }

        .stat-label {
            color: #6b7280;
            font-size: 14px;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .main-content {
                margin-left: 0;
            }

            .content {
                padding: 1rem;
            }
        }
    </style>

    @yield('styles')
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-logo">
                <i class="fas fa-graduation-cap"></i> LMS
            </div>

            <nav>
                <a href="{{ route('dashboard') }}" class="nav-link @if(Route::is('dashboard')) active @endif">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                <a href="{{ route('students.index') }}" class="nav-link @if(Route::is('students.*')) active @endif">
                    <i class="fas fa-user-graduate"></i> Students
                </a>
                <a href="{{ route('teachers.index') }}" class="nav-link @if(Route::is('teachers.*')) active @endif">
                    <i class="fas fa-chalkboard-user"></i> Teachers
                </a>
                <a href="{{ route('profiles.index') }}" class="nav-link @if(Route::is('profiles.*')) active @endif">
                    <i class="fas fa-address-card"></i> Profiles
                </a>
                <a href="{{ route('chart.index') }}" class="nav-link @if(Route::is('chart.index')) active @endif">
                    <i class="fas fa-chart-line"></i> User Growth Chart
                </a>

                <hr style="border-color: #4b5563; margin: 20px 0;">

                <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Navbar -->
            <div class="navbar">
                <div class="navbar-brand">@yield('breadcrumb', 'Dashboard')</div>
                <div class="navbar-user">
                    <span>Welcome, {{ auth()->user()->name ?? 'User' }}</span>
                    <div class="user-avatar">{{ substr(auth()->user()->name ?? 'U', 0, 1) }}</div>
                </div>
            </div>

            <!-- Content -->
            <div class="content">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @yield('scripts')
</body>
</html>
