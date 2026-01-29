<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>System Registration</title>

    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #e9ecef; /* สีเทาพื้นฐานของ Admin Panel */
            font-family: 'Kanit', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative; /* เพื่อให้กล่องเวลาอ้างอิงตำแหน่งได้ */
        }

        /* 1. กล่องเวลา (มุมขวาบน) - ดีไซน์แบบ Widget */
        .admin-time-widget {
            position: absolute;
            top: 20px;
            right: 20px;
            background: #fff;
            padding: 10px 20px;
            border: 1px solid #ced4da; /* เส้นขอบคมๆ */
            border-left: 5px solid #343a40; /* แถบสีเข้มด้านซ้ายสไตล์ AdminLTE */
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            min-width: 200px;
            z-index: 999;
        }

        .widget-date {
            font-size: 1rem;
            font-weight: 600;
            color: #495057;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 5px;
            margin-bottom: 5px;
        }

        .widget-time {
            font-size: 1.2rem;
            font-weight: 700;
            color: #007bff; /* สีน้ำเงินมาตรฐาน */
        }

        /* 2. กล่องฟอร์ม (ตรงกลาง) - ดีไซน์แบบ Card */
        .login-box {
            width: 450px;
            background: #fff;
            border-top: 3px solid #007bff; /* เส้นสีด้านบนกล่อง */
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #f4f4f4;
            padding: 20px;
            text-align: center;
        }

        .card-header h3 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
            color: #343a40;
        }

        .card-body {
            padding: 30px;
        }

        /* Input Fields แบบ Admin (เหลี่ยมและมีไอคอน) */
        .input-group-text {
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            border-right: none;
            color: #6c757d;
        }

        .form-control {
            border: 1px solid #ced4da;
            border-left: none; /* เอาเส้นซ้ายออกเพื่อให้เชื่อมกับไอคอน */
            border-radius: 0 4px 4px 0; /* มนแค่นิดเดียว */
            height: 45px;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #80bdff;
        }
        
        /* ใส่เส้นซ้ายกลับมาตอน Focus */
        .form-control:focus + .input-group-text, 
        .form-control:focus {
            border-left: 1px solid #80bdff;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 4px; /* เหลี่ยม */
            font-weight: 600;
            padding: 10px;
        }

        .btn-primary:hover {
            background-color: #0069d9;
        }

    </style>
</head>
<body>

    <div class="admin-time-widget">
        <div class="widget-date">
            <i class="far fa-calendar-alt me-2"></i> {{ now()->format('d/m/Y') }}
        </div>
        <div class="widget-time">
            <i class="far fa-clock me-2"></i> <span id="liveClock">{{ now()->format('H:i:s') }}</span>
        </div>
    </div>

    <div class="login-box">
        <div class="card-header">
            <h3>REGISTER SYSTEM</h3>
            <small class="text-muted">ลงทะเบียนผู้ใช้งานใหม่ 2026</small>
        </div>
        <div class="card-body">
            <form action="{{ route('register') }}" method="post">
                @csrf

                <div class="mb-3 input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                </div>

                <div class="mb-3 input-group">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                </div>

                <div class="mb-3 input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>

                <div class="mb-4 input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Retype Password" required>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-user-plus me-1"></i> Register
                        </button>
                    </div>
                </div>

                <div class="mt-3 text-center">
                    <a href="{{ route('login') }}" class="text-secondary text-decoration-none small">
                        มีบัญชีอยู่แล้ว? 
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            const timeString = now.getHours().toString().padStart(2, '0') + ':' + 
                               now.getMinutes().toString().padStart(2, '0') + ':' + 
                               now.getSeconds().toString().padStart(2, '0');
            const el = document.getElementById('liveClock');
            if(el) el.textContent = timeString;
        }
        setInterval(updateClock, 1000);
    </script>

</body>
</html>