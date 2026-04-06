@extends('layouts.app')
@section('title', 'Thêm User Mới')
@section('css')
<style>
:root {
    --primary: #6366f1;
    --primary-dark: #4f46e5;
    --success: #10b981;
    --danger: #ef4444;
    --bg: #f1f5f9;
    --card: #ffffff;
    --text: #1e293b;
    --muted: #94a3b8;
    --border: #e2e8f0;
}
body { background: var(--bg); }

.form-page-wrap {
    max-width: 560px;
    margin: 0 auto;
    animation: fadeUp 0.5s ease;
}
.form-page-header {
    background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 60%, #3b82f6 100%);
    border-radius: 20px 20px 0 0;
    padding: 28px 32px;
    color: white;
    text-align: center;
}
.form-page-header .icon-wrap {
    width: 64px; height: 64px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.6rem;
    margin: 0 auto 12px;
    backdrop-filter: blur(4px);
}
.form-page-header h4 { margin: 0; font-size: 1.4rem; font-weight: 700; }
.form-page-header p  { margin: 4px 0 0; opacity: 0.85; font-size: 0.88rem; }

.form-body {
    background: var(--card);
    border-radius: 0 0 20px 20px;
    padding: 32px;
    box-shadow: 0 8px 32px rgba(99,102,241,0.1);
}

.form-section {
    margin-bottom: 24px;
}
.section-title {
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--muted);
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.section-title::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--border);
}

.field-group { margin-bottom: 18px; }
.field-group label {
    display: block;
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 7px;
}
.field-group label .req { color: var(--danger); margin-left: 2px; }

.input-wrap { position: relative; }
.input-wrap .field-icon {
    position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
    color: var(--muted); font-size: 0.9rem; pointer-events: none;
    transition: color 0.2s;
}
.input-wrap input,
.input-wrap select {
    width: 100%;
    padding: 11px 14px 11px 40px;
    border: 1.5px solid var(--border);
    border-radius: 12px;
    font-size: 0.9rem;
    color: var(--text);
    background: #f8fafc;
    transition: all 0.2s;
    box-sizing: border-box;
}
.input-wrap input:focus,
.input-wrap select:focus {
    border-color: var(--primary);
    background: white;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
    outline: none;
}
.input-wrap input:focus ~ .field-icon,
.input-wrap select:focus ~ .field-icon { color: var(--primary); }
.input-wrap .toggle-pw {
    position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
    color: var(--muted); cursor: pointer; font-size: 0.9rem;
    transition: color 0.2s;
}
.input-wrap .toggle-pw:hover { color: var(--primary); }
.field-hint { font-size: 0.78rem; color: var(--muted); margin-top: 5px; }

.info-box {
    background: linear-gradient(135deg, #ede9fe, #e0e7ff);
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 0.82rem;
    color: #5b21b6;
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 24px;
}
.info-box i { margin-top: 1px; flex-shrink: 0; }

.role-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}
.role-option { display: none; }
.role-label {
    border: 2px solid var(--border);
    border-radius: 14px;
    padding: 14px 16px;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 12px;
    background: #f8fafc;
}
.role-label:hover { border-color: var(--primary); background: #f5f3ff; }
.role-option:checked + .role-label {
    border-color: var(--primary);
    background: #ede9fe;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
}
.role-icon {
    width: 40px; height: 40px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}
.role-icon.admin { background: #fee2e2; color: #dc2626; }
.role-icon.user  { background: #d1fae5; color: #059669; }
.role-name  { font-weight: 700; font-size: 0.88rem; color: var(--text); }
.role-desc  { font-size: 0.75rem; color: var(--muted); }

.form-actions {
    display: flex;
    gap: 12px;
    margin-top: 28px;
}
.btn-cancel {
    flex: 1;
    padding: 12px;
    border-radius: 12px;
    border: 1.5px solid var(--border);
    background: white;
    color: var(--muted);
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
    text-align: center;
    transition: all 0.2s;
    display: flex; align-items: center; justify-content: center; gap: 8px;
}
.btn-cancel:hover { background: #f1f5f9; color: var(--text); border-color: #cbd5e1; }
.btn-submit {
    flex: 2;
    padding: 12px;
    border-radius: 12px;
    border: none;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: white;
    font-weight: 700;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.2s;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    box-shadow: 0 4px 14px rgba(99,102,241,0.35);
}
.btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(99,102,241,0.45); }
.btn-submit:active { transform: translateY(0); }

.alert-errors {
    background: #fef2f2;
    border: 1.5px solid #fecaca;
    border-radius: 12px;
    padding: 14px 16px;
    margin-bottom: 20px;
    font-size: 0.85rem;
    color: #dc2626;
}
.alert-errors ul { margin: 6px 0 0; padding-left: 18px; }
.alert-errors li { margin-bottom: 3px; }

@keyframes fadeUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
</style>
@endsection
@section('content')

<div class="form-page-wrap">
    <div class="form-page-header">
        <div class="icon-wrap"><i class="fas fa-user-plus"></i></div>
        <h4>Thêm User Mới</h4>
        <p>Tạo tài khoản người dùng trong hệ thống</p>
    </div>

    <div class="form-body">
        @if(isset($_SESSION['errors']) && !empty($_SESSION['errors']))
        <div class="alert-errors">
            <i class="fas fa-exclamation-circle me-2"></i><strong>Có lỗi xảy ra:</strong>
            <ul>
                @foreach($_SESSION['errors'] as $err)<li>{{ $err }}</li>@endforeach
            </ul>
        </div>
        @php unset($_SESSION['errors']); @endphp
        @endif

        <div class="info-box">
            <i class="fas fa-info-circle"></i>
            <span>Mật khẩu tối thiểu <strong>6 ký tự</strong>. Email phải là duy nhất trong hệ thống.</span>
        </div>

        <form action="{{ APP_URL }}/admin/users/store" method="POST">

            <div class="section-title"><i class="fas fa-id-card"></i> Thông tin cơ bản</div>

            <div class="field-group">
                <label>Tên hiển thị <span class="req">*</span></label>
                <div class="input-wrap">
                    <input type="text" name="name" placeholder="Nhập tên người dùng"
                        value="{{ $_SESSION['old_data']['name'] ?? '' }}" required>
                    <i class="fas fa-user field-icon"></i>
                </div>
                <div class="field-hint">Tối thiểu 2 ký tự</div>
            </div>

            <div class="field-group">
                <label>Địa chỉ Email <span class="req">*</span></label>
                <div class="input-wrap">
                    <input type="email" name="email" placeholder="example@email.com"
                        value="{{ $_SESSION['old_data']['email'] ?? '' }}" required>
                    <i class="fas fa-envelope field-icon"></i>
                </div>
                <div class="field-hint">Email phải là duy nhất trong hệ thống</div>
            </div>

            <div class="section-title" style="margin-top:24px"><i class="fas fa-lock"></i> Bảo mật</div>

            <div class="field-group">
                <label>Mật khẩu <span class="req">*</span></label>
                <div class="input-wrap">
                    <input type="password" name="password" id="pw1" placeholder="Nhập mật khẩu" required>
                    <i class="fas fa-lock field-icon"></i>
                    <i class="fas fa-eye toggle-pw" onclick="togglePw('pw1',this)"></i>
                </div>
                <div class="field-hint">Tối thiểu 6 ký tự</div>
            </div>

            <div class="field-group">
                <label>Xác nhận mật khẩu <span class="req">*</span></label>
                <div class="input-wrap">
                    <input type="password" name="confirm_password" id="pw2" placeholder="Nhập lại mật khẩu" required>
                    <i class="fas fa-lock field-icon"></i>
                    <i class="fas fa-eye toggle-pw" onclick="togglePw('pw2',this)"></i>
                </div>
            </div>

            <div class="section-title" style="margin-top:24px"><i class="fas fa-shield-alt"></i> Vai trò</div>

            <div class="role-grid">
                <div>
                    <input type="radio" name="role" id="role_user" value="user" class="role-option"
                        {{ ($_SESSION['old_data']['role'] ?? 'user') == 'user' ? 'checked' : '' }}>
                    <label for="role_user" class="role-label">
                        <div class="role-icon user"><i class="fas fa-user"></i></div>
                        <div>
                            <div class="role-name">User</div>
                            <div class="role-desc">Khách hàng</div>
                        </div>
                    </label>
                </div>
                <div>
                    <input type="radio" name="role" id="role_admin" value="admin" class="role-option"
                        {{ ($_SESSION['old_data']['role'] ?? '') == 'admin' ? 'checked' : '' }}>
                    <label for="role_admin" class="role-label">
                        <div class="role-icon admin"><i class="fas fa-shield-alt"></i></div>
                        <div>
                            <div class="role-name">Admin</div>
                            <div class="role-desc">Quản trị viên</div>
                        </div>
                    </label>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ APP_URL }}/admin/users" class="btn-cancel">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-user-plus"></i> Tạo tài khoản
                </button>
            </div>
        </form>
    </div>
</div>

@php unset($_SESSION['old_data']); @endphp

@endsection
@section('js')
<script>
function togglePw(id, icon) {
    const input = document.getElementById(id);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
@endsection
