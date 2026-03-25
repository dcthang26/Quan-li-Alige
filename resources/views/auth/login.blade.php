@extends('client.layout.app')
@section('title', 'Đăng nhập')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-body p-5">
                    <h1 class="text-center mb-4"><i class="fas fa-sign-in-alt"></i> Đăng Nhập</h1>

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

                    <form action="{{ APP_URL }}/login" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            <i class="fas fa-sign-in-alt"></i> Đăng nhập
                        </button>
                    </form>

                    <div class="text-center">
                        <p>Quên mật khẩu? <a href="{{ APP_URL }}/forgot-password">Click vào đây</a></p>
                        <p>Chưa có tài khoản? <a href="{{ APP_URL }}/register">Đăng ký ngay</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
