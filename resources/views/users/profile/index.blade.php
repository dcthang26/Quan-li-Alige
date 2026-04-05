@extends('client.layout.app')
@section('title', 'Hồ sơ cá nhân')
@section('content')

{{-- Hero --}}
<div class="profile-hero mb-4 rounded-4">
    <div class="text-center">
        <form action="{{ APP_URL }}/user/profile/avatar" method="POST" enctype="multipart/form-data" id="avatarForm">
            <div class="avatar-wrap mx-auto mb-3">
                @if(!empty($_SESSION['user']->avatar))
                    <img src="{{ APP_URL }}/{{ $_SESSION['user']->avatar }}" class="avatar-img" alt="avatar" id="avatarPreview">
                @else
                    <div class="avatar-circle" id="avatarPreview">{{ strtoupper(substr($_SESSION['user']->name, 0, 1)) }}</div>
                @endif
                <label for="avatarInput" class="avatar-edit-btn" title="Đổi ảnh">
                    <i class="fas fa-camera"></i>
                </label>
                <input type="file" id="avatarInput" name="avatar" accept="image/*" class="d-none">
            </div>
        </form>
        <h4 class="mb-1">{{ $_SESSION['user']->name }}</h4>
        <span class="badge-role">{{ ucfirst($_SESSION['user']->role) }}</span>
    </div>
</div>

<div class="row g-4">
    {{-- Thông tin cá nhân --}}
    <div class="col-lg-8">
        <div class="card profile-card">
            <div class="card-header"><i class="fas fa-user me-2"></i>Thông tin cá nhân</div>
            <div class="card-body p-4">
                @if(session_flash('success'))
                    <div class="alert alert-success">{{ session_flash('success') }}</div>
                @endif
                @if(session_flash('error'))
                    <div class="alert alert-danger">{{ session_flash('error') }}</div>
                @endif

                <form action="{{ APP_URL }}/user/profile/update" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="info-label mb-1">Họ tên</label>
                            <input type="text" name="name" class="form-control" value="{{ $_SESSION['user']->name }}">
                        </div>
                        <div class="col-md-6">
                            <label class="info-label mb-1">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $_SESSION['user']->email }}">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-blue px-4"><i class="fas fa-save me-1"></i>Lưu thay đổi</button>
                        </div>
                    </div>
                </form>

                <hr class="my-4">

                <h6 class="fw-bold mb-3"><i class="fas fa-lock me-2 text-primary"></i>Đổi mật khẩu</h6>
                <form action="{{ APP_URL }}/user/profile/change-password" method="POST">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="info-label mb-1">Mật khẩu hiện tại</label>
                            <input type="password" name="current_password" class="form-control" placeholder="••••••">
                        </div>
                        <div class="col-md-4">
                            <label class="info-label mb-1">Mật khẩu mới</label>
                            <input type="password" name="new_password" class="form-control" placeholder="••••••">
                        </div>
                        <div class="col-md-4">
                            <label class="info-label mb-1">Xác nhận mật khẩu</label>
                            <input type="password" name="confirm_password" class="form-control" placeholder="••••••">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-outline-primary px-4"><i class="fas fa-key me-1"></i>Đổi mật khẩu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Thống kê nhanh --}}
    <div class="col-lg-4">
        <div class="card profile-card h-100">
            <div class="card-header"><i class="fas fa-chart-bar me-2"></i>Tổng quan</div>
            <div class="card-body p-4 d-flex flex-column gap-3">
                <div class="stat-box">
                    <div class="stat-num">{{ $orderCount ?? 0 }}</div>
                    <div class="stat-label">Đơn hàng</div>
                </div>
                <div class="stat-box">
                    <div class="stat-num">{{ $cartCount ?? 0 }}</div>
                    <div class="stat-label">Sản phẩm trong giỏ</div>
                </div>
                <a href="{{ APP_URL }}/user/orders" class="btn btn-blue w-100"><i class="fas fa-box me-1"></i>Xem đơn hàng</a>
                <a href="{{ APP_URL }}/user/cart" class="btn btn-outline-primary w-100"><i class="fas fa-shopping-cart me-1"></i>Xem giỏ hàng</a>
            </div>
        </div>
    </div>
</div>
@endsection
