<style>
    /* ปรับแต่ง Navbar ให้เข้ากับธีม Admin */
    .navbar-admin {
        background-color: #ffffff;
        border-bottom: 3px solid #007bff; /* เส้นฟ้าล่างแบบเดียวกับหน้า Login */
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        padding: 0.8rem 1rem;
    }

    .navbar-admin .navbar-brand {
        font-weight: 700;
        color: #343a40;
        letter-spacing: -0.5px;
    }

    .navbar-admin .nav-link {
        font-weight: 600;
        color: #495057;
        padding: 0.5rem 1.2rem !important;
        transition: all 0.2s;
    }

    .navbar-admin .nav-link:hover, 
    .navbar-admin .nav-link.active {
        color: #007bff !important;
    }

    /* ปุ่มย้อนกลับ Dashboard */
    .btn-dashboard {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        color: #343a40;
        font-weight: 600;
        border-radius: 4px; /* เหลี่ยมขึ้น */
        margin-right: 15px;
        transition: 0.2s;
    }

    .btn-dashboard:hover {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
    }

    /* Search Box แบบ Admin */
    .search-admin .form-control {
        border-radius: 4px 0 0 4px;
        border: 1px solid #ced4da;
    }

    .search-admin .btn {
        border-radius: 0 4px 4px 0;
        font-weight: 600;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-admin mb-4">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('profiles.index') }}">
            <img src="{{ asset('images/ez.png') }}" alt="Logo" width="35" height="35" class="rounded-circle me-2 border shadow-sm">
            <span class="d-none d-sm-inline">PROFILES</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="btn btn-dashboard nav-link" href="{{ url('/dashboard') }}">
                        <i class="fas fa-arrow-left me-1"></i> Dashboard
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('profiles') ? 'active' : '' }}" href="{{ route('profiles.index') }}">
                        <i class="fas fa-users me-1"></i> Profiles
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('profiles/create') ? 'active' : '' }}" href="{{ route('profiles.create') }}">
                        <i class="fas fa-plus-square me-1"></i> Create New Profile  
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-cog me-1"></i> Management
                    </a>
                    <ul class="dropdown-menu border-0 shadow-lg">
                        <li><a class="dropdown-item" href="#">User Logs</a></li>
                        <li><a class="dropdown-item" href="#">System Status</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger fw-bold" href="#">Maintenance</a></li>
                    </ul>
                </li>
            </ul>

            <div class="d-flex align-items-center">
                <form class="d-flex search-admin me-3" role="search">
                    <input class="form-control" type="search" placeholder="Search data..." aria-label="Search">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>

                <div class="dropdown">
                    <button class="btn btn-dark btn-sm dropdown-toggle fw-bold px-3 py-2" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-1"></i> MY ACCOUNT
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li><a class="dropdown-item" href="#">Profile Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger fw-bold">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>