<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login | Database System</title>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; font-family: 'Kanit', sans-serif; height: 100vh; display: flex; align-items: center; justify-content: center; margin: 0; position: relative; }
        
        /* Widget เวลาสีฟ้า */
        .admin-time-widget { 
            position: absolute; top: 20px; right: 20px; background: #fff; padding: 12px 25px; 
            border: 1px solid #dee2e6; border-left: 5px solid #007bff; /* สีฟ้า Dashboard */
            box-shadow: 0 4px 6px rgba(0,0,0,0.05); min-width: 220px; 
        }
        .widget-date { font-size: 0.95rem; font-weight: 600; color: #495057; border-bottom: 1px solid #eee; pb: 5px; mb: 5px; }
        .widget-time { font-size: 1.3rem; font-weight: 700; color: #007bff; }

        /* กล่อง Login สีฟ้า */
        .login-box { width: 420px; background: #fff; border-top: 4px solid #007bff; box-shadow: 0 10px 25px rgba(0,0,0,0.1); border-radius: 4px; }
        .card-header { padding: 35px 20px 10px; text-align: center; border: none; }
        .card-header h3 { font-weight: 700; color: #333; letter-spacing: -0.5px; }
        
        .btn-admin { background-color: #007bff; border: none; height: 50px; font-weight: 600; font-size: 1.1rem; border-radius: 4px; color: white; transition: 0.3s; }
        .btn-admin:hover { background-color: #0056b3; box-shadow: 0 4px 8px rgba(0,123,255,0.3); }
        
        .input-group-text { background-color: #f8f9fa; border-right: none; color: #adb5bd; }
        .form-control { border-left: none; height: 50px; border-radius: 0 4px 4px 0; }
        .form-control:focus { box-shadow: none; border-color: #dee2e6; }
    </style>
</head>
<body>

    <div class="admin-time-widget">
        <div class="widget-date"><i class="far fa-calendar-check me-2"></i>{{ now()->format('d / m / Y') }}</div>
        <div class="widget-time"><i class="far fa-clock me-2"></i><span id="liveClock">{{ now()->format('H:i:s') }}</span></div>
    </div>

    <div class="login-box">
        <div class="card-header">
            <h3>ADMIN LOGIN</h3>
            <p class="text-muted small">ระบบจัดการข้อมูลปี 2026</p>
        </div>
        <div class="card-body px-4 pb-5">
            <form action="{{ route('login.authenticate') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="Email Address" required autofocus>
                </div>
                <div class="input-group mb-4">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-admin w-100">SIGN IN</button>
            </form>
            <div class="text-center mt-4">
                <a href="{{ route('register') }}" class="text-decoration-none small text-primary fw-bold">สมัครสมาชิกใหม่</a>
            </div>
        </div>
    </div>

    <script>
        setInterval(() => {
            const now = new Date();
            document.getElementById('liveClock').textContent = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0') + ':' + now.getSeconds().toString().padStart(2, '0');
        }, 1000);
    </script>
</body>
</html>