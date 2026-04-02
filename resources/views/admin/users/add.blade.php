@extends('layouts.app')
@section('title', 'Thêm User Mới')
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
        margin-bottom: 30px;
        color: #333;
        text-align: center;
    }
    
    .required {
        color: #dc3545;
    }
    
    .password-info {
        background-color: #e7f3ff;
        border-left: 4px solid #2196F3;
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 4px;
        font-size: 13px;
        color: #1565c0;
    }
</style>

<div class="form-container">
    <div class="form-title">Thêm User Mới</div>
    
    <div class="password-info">
        <i class="fa fa-info-circle"></i> <strong>Yêu cầu mật khẩu:</strong> Tối thiểu 6 ký tự
    </div>
    
    <form action="{{ APP_URL }}/admin/users/store" method="POST">
        <!-- Tên User -->
        <div class="form-group">
            <label for="name">Tên User <span class="required">*</span></label>
            <input type="text" 
                   id="name" 
                   name="name" 
                   value="{{ $_SESSION['old_data']['name'] ?? '' }}"
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
                   value="{{ $_SESSION['old_data']['email'] ?? '' }}"
                   placeholder="Nhập email"
                   required>
            <small>Email phải là duy nhất trong hệ thống</small>
        </div>
        
        <!-- Mật khẩu -->
        <div class="form-group">
            <label for="password">Mật Khẩu <span class="required">*</span></label>
            <input type="password" 
                   id="password" 
                   name="password" 
                   placeholder="Nhập mật khẩu"
                   required>
            <small>Tối thiểu 6 ký tự</small>
        </div>
        
        <!-- Xác nhận Mật khẩu -->
        <div class="form-group">
            <label for="confirm_password">Xác Nhận Mật Khẩu <span class="required">*</span></label>
            <input type="password" 
                   id="confirm_password" 
                   name="confirm_password" 
                   placeholder="Nhập lại mật khẩu"
                   required>
        </div>
        
        <!-- Role -->
        <div class="form-group">
            <label for="role">Vai Trò <span class="required">*</span></label>
            <select id="role" name="role" required>
                <option value="user" {{ ($_SESSION['old_data']['role'] ?? '') == 'user' ? 'selected' : '' }}>User (Khách hàng)</option>
                <option value="admin" {{ ($_SESSION['old_data']['role'] ?? '') == 'admin' ? 'selected' : '' }}>Admin (Quản trị viên)</option>
            </select>
            <small>Chọn vai trò cho user</small>
        </div>
        
        <!-- Nút hành động -->
        <div class="form-actions">
            <a href="{{ APP_URL }}/admin/users" class="btn btn-secondary">
                <i class="fa fa-times"></i> Hủy
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> Thêm User
            </button>
        </div>
    </form>
</div>

@php 
// Xóa old_data sau khi hiển thị
unset($_SESSION['old_data']); 
@endphp

@endsection
