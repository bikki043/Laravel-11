@extends('layouts.app')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        /* ปรับพื้นหลังเนื้อหาให้ดูแพง ไม่ทับเมนูซ้าย */
        .dashboard-wrapper {
            font-family: 'Kanit', sans-serif;
            background-color: #f8f9fa;
            min-height: 100vh;
            padding: 2rem;
        }

        /* Card ดีไซน์ทันสมัยแบบ Solid */
        .stat-card {
            background: #ffffff;
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            transition: transform 0.2s;
        }

        .stat-title {
            color: #6c757d;
            font-size: 1rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .stat-value {
            font-size: 3rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0.5rem 0;
        }

        /* ตาราง Modern Solid */
        .table-container {
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .modern-table {
            width: 100%;
            border-collapse: collapse;
        }

        .modern-table thead {
            background: #1e293b;
            color: #ffffff;
        }

        .modern-table th {
            padding: 1.2rem;
            font-weight: 400;
            font-size: 1rem;
            text-align: left;
        }

        .modern-table td {
            padding: 1.2rem;
            border-bottom: 1px solid #f1f5f9;
            font-size: 1rem;
            color: #334155;
        }

        .modern-table tr:hover {
            background-color: #f8fafc;
        }

        .btn-action {
            border-radius: 8px;
            font-weight: 600;
            padding: 0.6rem 1.2rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Badge สถานะ */
        .badge-new {
            background: #dcfce7;
            color: #166534;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
        }
    </style>

    <div class="dashboard-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold text-dark m-0">ระบบวิเคราะห์ข้อมูลสมาชิก</h2>
                <p class="text-muted m-0">Dashboard แสดงผลตามเวลาจริง (เรียงลำดับล่าสุด)</p>
            </div>
            <div class="no-print">
                <button onclick="location.reload()" class="btn btn-outline-dark btn-action">
                    <i class="bi bi-arrow-clockwise"></i> รีเฟรชข้อมูล
                </button>
                <button onclick="window.print()" class="btn btn-dark btn-action ms-2">
                    <i class="bi bi-printer"></i> ออกรายงาน PDF
                </button>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="stat-card mb-4 border-start border-primary border-5">
                    <div class="stat-title">สมาชิกทั้งหมดในระบบ</div>
                    <div class="stat-value">{{ number_format($totalUsers) }}</div>
                    <div class="text-success small fw-bold">
                        <i class="bi bi-graph-up"></i> ข้อมูลอัปเดตปี 2026
                    </div>
                </div>

                <div class="stat-card">
                    <h5 class="fw-bold mb-4">ผู้สมัครล่าสุด</h5>
                    @foreach ($allUsers->take(5) as $user)
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom border-light">
                            <div>
                                <div class="fw-bold text-dark">{{ $user->name }}</div>
                                <div class="small text-muted">{{ $user->email }}</div>
                            </div>
                            <span class="badge-new">{{ $user->created_at->diffForHumans() }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-8">
                <div class="stat-card h-100">
                    <h5 class="fw-bold mb-4">สถิติการสมัครสมาชิกรายเดือน (Growth Chart)</h5>
                    <div id="modernChart" style="height: 400px; width: 100%;"></div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <h4 class="fw-bold mb-4">รายชื่อสมาชิกทั้งหมด (เรียงลำดับใหม่ไปเก่า)</h4>
                <div class="table-container">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th width="80">ลำดับ</th>
                                <th>ชื่อ-นามสกุล</th>
                                <th>อีเมล</th>
                                <th>วันที่สมัคร</th>
                                <th>เวลา</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allUsers as $index => $user)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="fw-bold">{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>

                                    <td class="align-middle">
                                        <div class="fw-bold" style="font-size: 1.1rem; color: #1e293b;">
                                            {{ $user->created_at->format('d/m/Y') }}
                                        </div>
                                        <div class="text-primary fw-semibold small">
                                            เวลา {{ $user->created_at->format('H:i:s') }} น.
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script>
        var userData = @json($usersCount);
        Highcharts.chart('modernChart', {
            chart: {
                type: 'area',
                style: {
                    fontFamily: 'Kanit'
                },
                backgroundColor: 'transparent'
            },
            title: {
                text: null
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                gridLineWidth: 0
            },
            yAxis: {
                title: {
                    text: null
                },
                gridLineColor: '#f1f5f9'
            },
            plotOptions: {
                area: {
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, 'rgba(13, 110, 253, 0.2)'],
                            [1, 'rgba(13, 110, 253, 0)']
                        ]
                    },
                    marker: {
                        radius: 5,
                        backgroundColor: '#fff',
                        lineColor: '#0d6efd',
                        lineWidth: 2
                    },
                    lineColor: '#0d6efd',
                    lineWidth: 3
                }
            },
            series: [{
                name: 'สมัครสมาชิก',
                data: userData
            }],
            credits: {
                enabled: false
            }
        });
    </script>
@endsection
