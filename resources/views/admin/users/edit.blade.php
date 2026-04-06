@extends('layouts.app')
@section('title', 'Chỉnh Sửa User')
@section('css')
<style>
:root {
    --primary: #6366f1;
    --primary-dark: #4f46e5;
    --success: #10b981;
    --danger: #ef4444;
    --warning: #f59e0b;
    --bg: #f1f5f9;
    --card: #ffffff;
    --text: #1e293b;
    --muted: #94a3b8;
    --border: #e2e8f0;
}
body { background: var(--bg); }

.form-page-wrap {
    max-width: 580px;
    margin: 0 auto;
    animation: fadeUp 0.5s ease;
}
.form-page-header {
    background: linear-gradient(135deg, #f59e0b 0%, #f97316 100%);
    border-radius: 20px 20px 0 0;
    padding: 24px 32px;
    color: white;
    display: flex;
    align-items: center;
    gap: 20px;
}
@php
    $colors = ['#6366f1','#8b5cf6','#ec4899','#f59e0b','#10b981','#3b82f6'];
    $avatarColor = $colors[$user->id % count($colors)];
    $initials = strtoupper(substr($user->name, 0, 1));
@endphp
.avatar-lg {
    width: 60px; height: 60px;
    border-radius: 50%;
    background: rgba(255,255,255,0.25);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem;
    font-weight: 800;
    color: white;
    flex-shrink: 0;
    border: 3px solid rgba(255,255,255,0.4);
}
.header-info h4 { margin: 0; font-size: 1.2rem; font-weight: 700; }
.header-info p  { margin: 3px 0 0; opacity: 0.85; font-size: 0.82rem; }

.form-body {
    background: var(--card);
    border-radius: 0 0 20px 20px;
    padding: 32px;
    box-shadow: 0 8px 32px rgba(245,158,11,0.1);
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
.section-title::after { content:''; flex:1; height:1px; background:var(--border); }

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
.input-wrap .toggle-pw {
    position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
    color: var(--muted); cursor: pointer; font-size: 0.9rem;
    transition: color 0.2s;
}
.input-wrap .toggle-pw:hover { color: var(--primary); }
.field-hint { font-size: 0.78rem; color: var(--muted); margin-top: 5px; }

.pw-section {
    background: linear-gradient(135deg, #fffbeb, #fef3c7);
    border: 1.5px solid #fde68a;
    border-radius: 14px;
    padding: 20px;
    margin-bottom: 24px;
}
.pw-section-title {
    font-size: 0.82rem;
    font-weight: 700;
    color: #92400e;
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.pw-section-hint {
    font-size: 0.78rem;
    color: #b45309;
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.meta-box {
    background: #f0fdf4;
    border: 1.5px solid #bbf7d0;
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 0.82rem;
    color: #166534;
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 24px;
}

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
.role-icon { width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0; }
.role-icon.admin { background:#fee2e2;color:#dc2626; }
.role-icon.user  { background:#d1fae5;color:#059669; }
.role-name { font-weight:700;font-size:0.88rem;color:var(--text); }
.role-desc { font-size:0.75rem;color:var(--muted); }

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
.btn-cancel:hover { background: #f1f5f9; color: var(--text); }
.btn-submit {
    flex: 2;
    padding: 12px;
    border-radius: 12px;
    border: none;
    background: linear-gradient(135deg, #f59e0b, #f97316);
    color: white;
    font-weight: 700;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.2s;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    box-shadow: 0 4px 14px rgba(245,158,11,0.35);
}
.btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(245,158,11,0.45); }

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

@keyframes fadeUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
</style>
@endsection
@section('content')

@php
    $colors = ['#6366f1','#8b5cf6','#ec4899','#f59e0b','#10b981','#3b82f6'];
    $avatarColor = $colors[$user->id % count($colors)];
    $initials = strtoupper(substr($user->name, 0, 1));
@endphp

<div class="form-page-wrap">
    <div class="form-page-header">
        <div class="avatar-lg" style="background:{{ $avatarColor }}">{{ $initials }}</div>
        <div class="header-info">
            <h4>{{ $user->name }}</h4>
            <p><i class="fas fa-envelope me-1"></i>{{ $user->email }}</p>
            <p><i class="fas fa-hashtag me-1"></i>ID: {{ $user->id }}</p>
        </div>
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

        <div class="meta-box">
            <i class="fas fa-calendar-check"></i>
            <span>Tài khoản tạo lúc: <strong>{{ date('d/m/Y H:i:s', strtotime($user->created_at)) }}</strong></span>
        </div>

        <form action="{{ APP_URL }}/admin/users/update/{{ $user->id }}" method="POST">

            <div class="section-title"><i class="fas fa-id-card"></i> Thông tin cơ bản</div>

            <div class="field-group">
                <label>Tên hiển thị <span class="req">*</span></label>
                <div class="input-wrap">
                    <input type="text" name="name" placeholder="Nhập tên người dùng"
                        value="{{ $_SESSION['old_data']['name'] ?? $user->name }}" required>
                    <i class="fas fa-user field-icon"></i>
                </div>
            </div>

            <div class="field-group">
                <label>Địa chỉ Email <span class="req">*</span></label>
                <div class="input-wrap">
                    <input type="email" name="email" placeholder="example@email.com"
                        value="{{ $_SESSION['old_data']['email'] ?? $user->email }}" required>
                    <i class="fas fa-envelope field-icon"></i>
                </div>
            </div>

            <div class="pw-section">
                <div class="pw-section-title"><i class="fas fa-key"></i> Đổi mật khẩu (tùy chọn)</div>
                <div class="pw-section-hint"><i class="fas fa-info-circle"></i> Để trống nếu không muốn thay đổi mật khẩu</div>

                <div class="field-group" style="margin-bottom:14px">
                    <label>Mật khẩu mới</label>
                    <div class="input-wrap">
                        <input type="password" name="password" id="pw1" placeholder="Nhập mật khẩu mới">
                        <i class="fas fa-lock field-icon"></i>
                        <i class="fas fa-eye toggle-pw" onclick="togglePw('pw1',this)"></i>
                    </div>
                    <div class="field-hint">Tối thiểu 6 ký tự</div>
                </div>

                <div class="field-group" style="margin-bottom:0">
                    <label>Xác nhận mật khẩu mới</label>
                    <div class="input-wrap">
                        <input type="password" name="confirm_password" id="pw2" placeholder="Nhập lại mật khẩu mới">
                        <i class="fas fa-lock field-icon"></i>
                        <i class="fas fa-eye toggle-pw" onclick="togglePw('pw2',this)"></i>
                    </div>
                </div>
            </div>

            <div class="section-title"><i class="fas fa-shield-alt"></i> Vai trò</div>

            <div class="role-grid">
                <div>
                    <input type="radio" name="role" id="role_user" value="user" class="role-option"
                        {{ ($_SESSION['old_data']['role'] ?? $user->role) == 'user' ? 'checked' : '' }}>
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
                        {{ ($_SESSION['old_data']['role'] ?? $user->role) == 'admin' ? 'checked' : '' }}>
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
                <button type="submit" name="submit" value="1" class="btn-submit">
                    <i class="fas fa-save"></i> Lưu thay đổi
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
