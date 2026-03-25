@extends('layouts.app')
@section('title', 'Chỉnh Sửa User')
@section('content')

<style>
    .form-container {
        max-width: 500px;
        margin: 0 auto;
        padding: 30px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
    }
    
    .form-group input,
    .form-group select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }
    
    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
    }
    
    .form-group small {
        display: block;
        margin-top: 5px;
        color: #6c757d;
    }
    
    .alert {
        border-radius: 5px;
        padding: 12px 15px;
        margin-bottom: 20px;
    }
    
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    .alert-danger ul {
        margin: 0;
        padding-left: 20px;
    }
    
    .alert-danger li {
        margin: 5px 0;
    }
    
    .form-actions {
        display: flex;
        gap: 10px;
        justify-content: space-between;
        margin-top: 30px;
    }
    
    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }
    
    .btn-primary {
        background-color: #007bff;
        color: white;
    }
    
    .btn-primary:hover {
        background-color: #0056b3;
    }
    
    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }
    
    .btn-secondary:hover {
        background-color: #545b62;
    }
    
    .form-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 10px;
        color: #333;
        text-align: center;
    }
    
    .user-info {
        text-align: center;
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 25px;
    }
    
    .required {
        color: #dc3545;
    }
    
    .password-section {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 4px;
        margin-bottom: 20px;
        border-left: 4px solid #ffc107;
    }
    
    .password-section h6 {
        margin: 0 0 15px 0;
        color: #333;
        font-size: 14px;
    }
    
    .divider {
        height: 1px;
        background-color: #e9ecef;
        margin: 20px 0;
    }
</style>

<div class="form-container">
    <div class="form-title">Chỉnh Sửa Thông Tin User</div>
    
    <div class="user-info">
        <p style="margin: 0;">
            <i class="fa fa-user-circle"></i> {{ $user->name }} 
            <br>
            <small>(ID: #{{ $user->id }})</small>
        </p>
    </div>
    
    <!-- Hiển thị lỗi validation -->
    @if(isset($_SESSION['errors']))
        <div class="alert alert-danger">
            <strong><i class="fa fa-exclamation-circle"></i> Lỗi:</strong>
            <ul>
                @foreach($_SESSION['errors'] as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @php unset($_SESSION['errors']); @endphp
    @endif
    
    <form action="{{ APP_URL }}/admin/users/update/{{ $user->id }}" method="POST">
        <!-- Tên User -->
        <div class="form-group">
            <label for="name">Tên User <span class="required">*</span></label>
            <input type="text" 
                   id="name" 
                   name="name" 
                   value="{{ $_SESSION['old_data']['name'] ?? $user->name }}"
                   placeholder="Nhập tên user"
                   required>
            <small>Tên phải có ít nhất 2 ký tự</small>
        </div>
        
        <!-- Email -->
        <div class="form-group">
            <label for="email">Email <span class="required">*</span></label>
            <input type="email" 
                   id="email" 
                   name="email" 
                   value="{{ $_SESSION['old_data']['email'] ?? $user->email }}"
                   placeholder="Nhập email"
                   required>
            <small>Email phải là duy nhất trong hệ thống</small>
        </div>
        
        <!-- Phần đổi mật khẩu -->
        <div class="password-section">
            <h6><i class="fa fa-lock"></i> Đổi Mật Khẩu (Tùy Chọn)</h6>
            <p style="margin: 0 0 15px 0; color: #666; font-size: 13px;">
                Để không đổi mật khẩu, hãy bỏ trống các trường dưới
            </p>
            
            <!-- Mật khẩu mới -->
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="password">Mật Khẩu Mới</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       placeholder="Nhập mật khẩu mới (nếu muốn đổi)">
                <small>Tối thiểu 6 ký tự. Để trống nếu không muốn đổi</small>
            </div>
            
            <!-- Xác nhận Mật khẩu -->
            <div class="form-group">
                <label for="confirm_password">Xác Nhận Mật Khẩu Mới</label>
                <input type="password" 
                       id="confirm_password" 
                       name="confirm_password" 
                       placeholder="Nhập lại mật khẩu mới">
                <small>Phải khớp với mật khẩu mới</small>
            </div>
        </div>
        
        <div class="divider"></div>
        
        <!-- Role -->
        <div class="form-group">
            <label for="role">Vai Trò <span class="required">*</span></label>
            <select id="role" name="role" required>
                <option value="user" {{ ($_SESSION['old_data']['role'] ?? $user->role) == 'user' ? 'selected' : '' }}>User (Khách hàng)</option>
                <option value="admin" {{ ($_SESSION['old_data']['role'] ?? $user->role) == 'admin' ? 'selected' : '' }}>Admin (Quản trị viên)</option>
            </select>
            <small>Chọn vai trò cho user</small>
        </div>
        
        <!-- Thông tin thêm -->
        <div style="background-color: #f0f7ff; padding: 12px; border-radius: 4px; margin: 20px 0; font-size: 13px; color: #1565c0;">
            <i class="fa fa-info-circle"></i> <strong>Ngày tạo:</strong> {{ date('d/m/Y H:i:s', strtotime($user->created_at)) }}
        </div>
        
        <!-- Nút hành động -->
        <div class="form-actions">
            <a href="{{ APP_URL }}/admin/users" class="btn btn-secondary">
                <i class="fa fa-times"></i> Hủy
            </a>
            <button type="hidden" name="submit" value="1" style="display: none;"></button>
            <button type="submit" name="submit" value="1" class="btn btn-primary">
                <i class="fa fa-save"></i> Cập Nhật
            </button>
        </div>
    </form>
</div>

@php 
// Xóa old_data sau khi hiển thị
unset($_SESSION['old_data']); 
@endphp

@endsection
