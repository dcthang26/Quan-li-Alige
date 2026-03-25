@extends('client.layout.app')
@section('title', 'Quên mật khẩu')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-body p-5">
                    <h1 class="text-center mb-4"><i class="fas fa-key"></i> Quên Mật Khẩu</h1>

                    <p class="text-center text-muted mb-4">Nhập tên tài khoản của bạn để tạo mật khẩu mới</p>

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

                    <form action="{{ APP_URL }}/forgot-password" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Tên tài khoản</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Nhập tên tài khoản" required>
                        </div>

                        <button type="submit" class="btn btn-warning w-100 mb-3">
                            <i class="fas fa-check"></i> Xác thực tài khoản
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
