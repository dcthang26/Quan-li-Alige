@extends('client.layout.app')
@section('title', 'Đăng ký')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-body p-5">
                    <h1 class="text-center mb-4"><i class="fas fa-user-plus"></i> Đăng Ký</h1>

                    <form action="{{ APP_URL }}/register" method="POST" id="registerForm" novalidate>
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên đầy đủ</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên của bạn" required>
                            <div class="invalid-feedback">Vui lòng nhập tên của bạn.</div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email" required>
                            <div class="invalid-feedback" id="emailFeedback">Email không hợp lệ.</div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Tối thiểu 8 ký tự, 1 chữ hoa, 1 số" required>
                            <div class="progress mt-1" style="height:6px;display:none" id="strengthBar">
                                <div class="progress-bar" id="strengthFill" style="width:0%"></div>
                            </div>
                            <small id="strengthText" class="form-text"></small>
                            <div class="invalid-feedback" id="passwordFeedback">Mật khẩu phải có ít nhất 8 ký tự, 1 chữ hoa và 1 số.</div>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Xác nhận mật khẩu</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Nhập lại mật khẩu" required>
                            <div class="invalid-feedback" id="confirmFeedback">Mật khẩu không khớp.</div>
                        </div>

                        <button type="submit" class="btn btn-success w-100 mb-3">
                            <i class="fas fa-user-plus"></i> Đăng ký
                        </button>
                    </form>

                    <script>
                    (function () {
                        const pw = document.getElementById('password');
                        const bar = document.getElementById('strengthBar');
                        const fill = document.getElementById('strengthFill');
                        const text = document.getElementById('strengthText');

                        pw.addEventListener('input', function () {
                            const v = this.value;
                            if (!v) { bar.style.display = 'none'; text.textContent = ''; return; }
                            bar.style.display = 'flex';
                            let score = 0;
                            if (v.length >= 8) score++;
                            if (/[A-Z]/.test(v)) score++;
                            if (/[0-9]/.test(v)) score++;
                            if (/[^A-Za-z0-9]/.test(v)) score++;
                            const levels = [
                                { w: '25%', cls: 'bg-danger',  label: 'Rất yếu' },
                                { w: '50%', cls: 'bg-warning', label: 'Yếu' },
                                { w: '75%', cls: 'bg-info',    label: 'Trung bình' },
                                { w: '100%',cls: 'bg-success', label: 'Mạnh' },
                            ];
                            const lvl = levels[score - 1] || levels[0];
                            fill.style.width = lvl.w;
                            fill.className = 'progress-bar ' + lvl.cls;
                            text.textContent = 'Độ mạnh: ' + lvl.label;
                            text.className = 'form-text ' + lvl.cls.replace('bg-', 'text-');
                        });

                        document.getElementById('registerForm').addEventListener('submit', function (e) {
                            let valid = true;

                            const name = document.getElementById('name');
                            name.classList.toggle('is-invalid', !name.value.trim());
                            if (!name.value.trim()) valid = false;

                            const email = document.getElementById('email');
                            const emailOk = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value);
                            email.classList.toggle('is-invalid', !emailOk);
                            if (!emailOk) valid = false;

                            const pwVal = pw.value;
                            const pwOk = pwVal.length >= 8 && /[A-Z]/.test(pwVal) && /[0-9]/.test(pwVal);
                            pw.classList.toggle('is-invalid', !pwOk);
                            if (!pwOk) valid = false;

                            const cp = document.getElementById('confirm_password');
                            const cpOk = cp.value === pwVal && cp.value !== '';
                            cp.classList.toggle('is-invalid', !cpOk);
                            if (!cpOk) valid = false;

                            if (!valid) e.preventDefault();
                        });

                        document.getElementById('confirm_password').addEventListener('input', function () {
                            const ok = this.value === pw.value;
                            this.classList.toggle('is-invalid', !ok);
                            this.classList.toggle('is-valid', ok && this.value !== '');
                        });
                    })();
                    </script>

                    <div class="text-center">
                        <p>Đã có tài khoản? <a href="{{ APP_URL }}/login">Đăng nhập tại đây</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
