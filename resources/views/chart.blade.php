@extends('layouts.app')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        .dashboard-wrapper {
            font-family: 'Kanit', sans-serif;
            background-color: #f1f5f9; /* Slate 100 */
            min-height: 100vh;
            padding: 2.5rem;
        }

        /* การ์ดสถิติแบบใหม่ */
        .stat-card-premium {
            background: white;
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.04);
            padding: 1.8rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .stat-card-premium:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .stat-card-premium::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 6px; height: 100%;
            background: linear-gradient(to bottom, #4f46e5, #8b5cf6);
        }

        .stat-label { color: #64748b; font-size: 0.9rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }
        .stat-main-value { font-size: 3.5rem; font-weight: 800; color: #1e293b; line-height: 1; margin: 10px 0; }

        /* ตารางและคอนเทนเนอร์ */
        .glass-panel {
            background: white;
            border-radius: 24px;
            border: 1px solid rgba(255,255,255,0.8);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
        }

        .modern-table { width: 100%; border-collapse: separate; border-spacing: 0 8px; }
        .modern-table thead th {
            background: transparent;
            color: #64748b;
            text-transform: uppercase;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 1rem 1.5rem;
            border: none;
        }
        .modern-table tbody tr {
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            transition: 0.2s;
        }
        .modern-table tbody tr:hover { transform: scale(1.005); background: #f8fafc; }
        .modern-table td {
            padding: 1.2rem 1.5rem;
            border-top: 1px solid #f1f5f9;
            border-bottom: 1px solid #f1f5f9;
        }
        .modern-table td:first-child { border-left: 1px solid #f1f5f9; border-radius: 12px 0 0 12px; }
        .modern-table td:last-child { border-right: 1px solid #f1f5f9; border-radius: 0 12px 12px 0; }

        /* Avatar ย่อ */
        .avatar-sm {
            width: 35px; height: 35px;
            background: #e2e8f0;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; color: #475569; font-size: 0.8rem;
        }

        .btn-modern {
            border-radius: 12px;
            padding: 0.7rem 1.5rem;
            font-weight: 600;
            transition: 0.3s;
        }
    </style>

    <div class="dashboard-wrapper">
        <div class="d-flex justify-content-between align-items-end mb-5" data-aos="fade-down">
            <div>
                <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill mb-2">Analytics Dashboard</span>
                <h1 class="fw-bold text-slate-900 m-0">วิเคราะห์โครงสร้างสมาชิก</h1>
                <p class="text-muted m-0"><i class="bi bi-clock-history me-1"></i> ข้อมูลอัปเดตล่าสุดเมื่อ: {{ now()->format('H:i') }} น.</p>
            </div>
            <div class="no-print">
                <button onclick="location.reload()" class="btn btn-white btn-modern shadow-sm border me-2">
                    <i class="bi bi-arrow-clockwise text-primary"></i>
                </button>
                <a href="{{ route('chart.pdf') }}" class="btn btn-dark btn-modern shadow-lg">
                    <i class="bi bi-file-earmark-pdf-fill me-2"></i> Export Report
                </a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="stat-card-premium mb-4" data-aos="fade-right">
                    <div class="stat-label">Total Active Members</div>
                    <div class="stat-main-value">{{ number_format($totalUsers) }}</div>
                    <div class="d-flex align-items-center text-success small fw-bold">
                        <span class="bg-success-subtle p-1 rounded-circle me-2">
                            <i class="bi bi-caret-up-fill"></i>
                        </span>
                        เติบโตขึ้นจากเดือนที่ผ่านมา
                    </div>
                </div>

                <div class="glass-panel" data-aos="fade-right" data-aos-delay="100">
                    <h6 class="fw-bold mb-4 d-flex justify-content-between">
                        <span>ผู้สมัครล่าสุด</span>
                        <i class="bi bi-person-plus text-muted"></i>
                    </h6>
                    @foreach ($allUsers->take(5) as $user)
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar-sm me-3">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold text-dark small">{{ $user->name }}</div>
                                <div style="font-size: 0.75rem" class="text-muted">{{ $user->email }}</div>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-light text-dark rounded-pill border" style="font-size: 0.65rem;">
                                    {{ $user->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-8">
                <div class="stat-card-premium h-100" data-aos="fade-left">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold m-0">แนวโน้มการเติบโตรายเดือน</h5>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light border rounded-pill px-3">ปี 2026 <i class="bi bi-chevron-down ms-1"></i></button>
                        </div>
                    </div>
                    <div id="modernChart" style="height: 380px;"></div>
                </div>
            </div>
        </div>

        <div class="row mt-5" data-aos="fade-up">
            <div class="col-12">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-dark text-white rounded-3 p-2 me-3">
                        <i class="bi bi-table"></i>
                    </div>
                    <h4 class="fw-bold m-0">ฐานข้อมูลสมาชิกทั้งหมด</h4>
                </div>
                
                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>ชื่อ-นามสกุล</th>
                                <th>ข้อมูลติดต่อ</th>
                                <th>วันที่เข้าร่วม</th>
                                <th class="text-end">สถานะเวลา</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allUsers as $index => $user)
                                <tr>
                                    <td class="text-center text-muted small">
                                        {{ ($allUsers->currentPage() - 1) * $allUsers->perPage() + $index + 1 }}
                                    </td>
                                    <td>
                                        <div class="fw-bold text-slate-700">{{ $user->name }}</div>
                                    </td>
                                    <td>
                                        <div class="text-muted small"><i class="bi bi-envelope me-1"></i> {{ $user->email }}</div>
                                    </td>
                                    <td>
                                        <div class="text-slate-600"><i class="bi bi-calendar3 me-2"></i>{{ $user->created_at->format('d M Y') }}</div>
                                    </td>
                                    <td class="text-end">
                                        <span class="text-primary fw-bold p-2 bg-primary-subtle rounded-3" style="font-size: 0.85rem;">
                                            {{ $user->created_at->format('H:i') }} น.
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 no-print d-flex justify-content-between align-items-center">
                    <p class="text-muted small">แสดงผล {{ $allUsers->count() }} รายการ จากทั้งหมด {{ $totalUsers }}</p>
                    <div>{{ $allUsers->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true });

        var userData = @json($usersCount);
        Highcharts.chart('modernChart', {
            chart: {
                type: 'areaspline',
                style: { fontFamily: 'Kanit' },
                backgroundColor: 'transparent',
                spacingTop: 20
            },
            title: { text: null },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                gridLineWidth: 0,
                lineColor: '#e2e8f0'
            },
            yAxis: {
                title: { text: null },
                gridLineColor: '#f1f5f9',
                labels: { style: { color: '#94a3b8' } }
            },
            tooltip: {
                backgroundColor: '#1e293b',
                style: { color: '#ffffff' },
                borderRadius: 12,
                shared: true,
                useHTML: true,
                headerFormat: '<small>{point.key}</small><table>',
                pointFormat: '<tr><td style="color: {series.color}; padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y} คน</b></td></tr>',
                footerFormat: '</table>'
            },
            plotOptions: {
                areaspline: {
                    fillColor: {
                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                        stops: [
                            [0, 'rgba(79, 70, 229, 0.2)'],
                            [1, 'rgba(79, 70, 229, 0)']
                        ]
                    },
                    marker: {
                        radius: 4,
                        fillColor: '#ffffff',
                        lineColor: '#4f46e5',
                        lineWidth: 2
                    },
                    lineColor: '#4f46e5',
                    lineWidth: 4
                }
            },
            series: [{
                name: 'สมาชิกใหม่',
                data: userData,
                shadow: {
                    color: 'rgba(79, 70, 229, 0.1)',
                    width: 10,
                    offsetX: 0,
                    offsetY: 5
                }
            }],
            credits: { enabled: false }
        });
    </script>
@endsection