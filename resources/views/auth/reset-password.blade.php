@extends('client.layout.app')
@section('title', 'Tạo mật khẩu mới')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-body p-5">
                    <h1 class="text-center mb-4"><i class="fas fa-lock"></i> Tạo Mật Khẩu Mới</h1>

                    <p class="text-center text-muted mb-4">Nhập mật khẩu mới cho tài khoản của bạn</p>

                    @if(isset($_SESSION['error']))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ $_SESSION['error'] }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @php unset($_SESSION['error']); @endphp
                    @endif

                    @if(isset($_SESSION['success']))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ $_SESSION['success'] }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @php unset($_SESSION['success']); @endphp
                    @endif

                    <form action="{{ APP_URL }}/reset-password" method="POST">
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu mới</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu mới (tối thiểu 6 ký tự)" required>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Xác nhận mật khẩu</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Nhập lại mật khẩu mới" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100 mb-3">
                            <i class="fas fa-save"></i> Cập nhật mật khẩu
                        </button>
                    </form>

                    <div class="text-center">
                        <p><a href="{{ APP_URL }}/login">Quay lại đăng nhập</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection