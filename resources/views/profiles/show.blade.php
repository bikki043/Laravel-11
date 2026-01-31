@extends('profiles.layout')
@include('layouts.navbar')

@section('content')
<style>
    /* คุมโทนสีและฟอนต์ */
    :root { --primary-indigo: #4f46e5; --soft-slate: #f8fafc; }
    
    .master-wrapper { animation: fadeIn 0.6s ease-out; }
    
    /* Profile Header & Glass Effect */
    .profile-header-card {
        background: white; border-radius: 30px; border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.04); overflow: hidden;
    }
    
    .top-banner {
        height: 140px;
        background: linear-gradient(120deg, #4f46e5 0%, #7c3aed 100%);
        position: relative;
    }

    /* Avatar Squircle */
    .avatar-main {
        width: 160px; height: 160px; object-fit: cover;
        border-radius: 50px; border: 6px solid white;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        background: white; margin-top: -80px; position: relative;
    }

    /* Data Blocks */
    .data-card {
        background: var(--soft-slate); border-radius: 20px;
        padding: 20px; transition: 0.3s; border: 1px solid #eef2f6;
    }
    .data-card:hover { 
        background: white; border-color: var(--primary-indigo);
        box-shadow: 0 10px 20px rgba(79, 70, 229, 0.08); transform: translateY(-3px);
    }
    .icon-box {
        width: 40px; height: 40px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 12px; font-size: 1.2rem;
    }

    /* Progress Bar (Profile Completion) */
    .progress { height: 8px; border-radius: 10px; background: #e2e8f0; }
    .progress-bar { background: linear-gradient(90deg, #4f46e5, #7c3aed); border-radius: 10px; }
</style>

<div class="container py-5 master-wrapper">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('profiles.index') }}" class="text-decoration-none text-primary fw-bold">Directory</a></li>
                        <li class="breadcrumb-item active">Personal Identity</li>
                    </ol>
                </nav>
                <a href="{{ route('profiles.index') }}" class="btn btn-light rounded-pill px-4 shadow-sm border small fw-bold">
                    <i class="bi bi-arrow-left me-2"></i>Back
                </a>
            </div>

            <div class="profile-header-card">
                <div class="top-banner"></div>
                
                <div class="card-body px-4 px-md-5 pb-5">
                    <div class="row">
                        <div class="col-md-4 text-center text-md-start">
                            <img src="{{ $profile->image ? asset('images/' . $profile->image) : 'https://ui-avatars.com/api/?background=4f46e5&color=fff&size=200&name='.urlencode($profile->name) }}" 
                                 class="avatar-main" alt="Admin Image">
                            
                            <div class="mt-3">
                                <h2 class="fw-bold text-dark mb-1">{{ $profile->name }}</h2>
                                <p class="text-muted small mb-3">System Administrator Level 1</p>
                                
                                <div class="d-flex justify-content-center justify-content-md-start gap-2">
                                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-bold">
                                        <i class="bi bi-patch-check-fill me-1"></i> Active
                                    </span>
                                </div>
                            </div>

                            <div class="mt-5 text-start d-none d-md-block">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="small fw-bold text-muted">Profile Strength</span>
                                    <span class="small fw-bold text-primary">85%</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 85%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8 mt-4 mt-md-0 pt-md-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="data-card">
                                        <div class="icon-box bg-primary-subtle text-primary"><i class="bi bi-envelope-at"></i></div>
                                        <div class="text-muted small fw-bold text-uppercase mb-1">Email System</div>
                                        <div class="fw-bold text-dark">{{ $profile->email }}</div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="data-card">
                                        <div class="icon-box bg-info-subtle text-info"><i class="bi bi-fingerprint"></i></div>
                                        <div class="text-muted small fw-bold text-uppercase mb-1">Unique UID</div>
                                        <div class="fw-bold text-dark">#{{ str_pad($profile->id, 6, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="data-card d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box bg-warning-subtle text-warning mb-0 me-3"><i class="bi bi-calendar-check"></i></div>
                                            <div>
                                                <div class="text-muted small fw-bold text-uppercase">Joined Since</div>
                                                <div class="fw-bold text-dark">{{ $profile->created_at->format('l, d F Y') }}</div>
                                            </div>
                                        </div>
                                        <div class="text-end d-none d-sm-block">
                                            <div class="text-muted small">Account Tenure</div>
                                            <div class="badge bg-dark rounded-pill">{{ $profile->created_at->diffForHumans(null, true) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5 d-flex gap-2">
                                <a href="{{ route('profiles.edit', $profile->id) }}" class="btn btn-primary px-5 py-3 fw-bold shadow" style="border-radius: 18px; background: #4f46e5; border: none;">
                                    <i class="bi bi-pencil-square me-2"></i> Edit Profile
                                </a>
                                <button onclick="window.print()" class="btn btn-white px-4 py-3 border fw-bold text-muted" style="border-radius: 18px;">
                                    <i class="bi bi-printer me-2"></i> Print
                                </button>
                            </div>
                        </div>
                    </div> </div> </div> <p class="text-center mt-4 text-muted small">
                <i class="bi bi-lock-fill me-1"></i> Data encrypted and secured by Enterprise Security System
            </p>
        </div>
    </div>
</div>
@endsection