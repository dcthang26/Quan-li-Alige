@extends('layouts.app')
@section('title', 'Quản lý Tài khoản Users')
@section('content')

<style>
    .user-management-header {
        margin-bottom: 30px;
    }
    
    .btn-group {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    
    .alert {
        border-radius: 5px;
        padding: 12px 15px;
        margin-bottom: 20px;
    }
    
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    .badge {
        padding: 5px 10px;
        border-radius: 3px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .badge-admin {
        background-color: #dc3545;
        color: white;
    }
    
    .badge-user {
        background-color: #28a745;
        color: white;
    }
    
    .table-actions {
        display: flex;
        gap: 5px;
    }
    
    .table-actions form {
        display: inline;
    }
    
    .btn-sm {
        padding: 5px 10px;
        font-size: 12px;
    }
    
    .btn-primary {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 3px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-primary:hover {
        background-color: #0056b3;
    }
    
    .btn-danger {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 3px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-danger:hover {
        background-color: #c82333;
    }
    
    .btn-success {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 3px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-success:hover {
        background-color: #218838;
    }
    
    .table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
    }
    
    .table thead {
        background-color: #f8f9fa;
    }
    
    .table th,
    .table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    
    .table tr:hover {
        background-color: #f5f5f5;
    }
    
    .table-bordered {
        border: 1px solid #ddd;
    }
    
    .table-bordered th,
    .table-bordered td {
        border: 1px solid #ddd;
    }
    
    .text-center {
        text-align: center;
    }
    
    .text-muted {
        color: #6c757d;
    }
</style>

<div class="user-management-header">
    <div class="btn-group">
        <h2 style="margin: 0; flex: 1;">Quản lý Tài khoản Users</h2>
        <a href="{{ APP_URL }}/admin/users/add" class="btn btn-success">
            <i class="fa fa-plus"></i> Thêm User Mới
        </a>
    </div>
</div>

<!-- Hiển thị thông báo thành công -->
@if(isset($_SESSION['success']))
    <div class="alert alert-success">
        <i class="fa fa-check-circle"></i> {{ $_SESSION['success'] }}
    </div>
    @php unset($_SESSION['success']); @endphp
@endif

<!-- Hiển thị lỗi -->
@if(isset($_SESSION['errors']))
    <div class="alert alert-danger">
        @foreach($_SESSION['errors'] as $error)
            <div>
                <i class="fa fa-exclamation-circle"></i> {{ $error }}
            </div>
        @endforeach
    </div>
    @php unset($_SESSION['errors']); @endphp
@endif

<!-- Bảng danh sách users -->
<div style="overflow-x: auto;">
    <table class="table table-bordered">
        <thead>
            <tr style="background-color: #f8f9fa;">
                <th style="width: 50px;">ID</th>
                <th style="width: 150px;">Tên User</th>
                <th style="width: 200px;">Email</th>
                <th style="width: 80px;">Role</th>
                <th style="width: 180px;">Ngày Tạo</th>
                <th style="width: 150px;">Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @if(count($users) > 0)
                @foreach ($users as $item)
                <tr>
                    <td class="text-center"><strong>#{{ $item->id }}</strong></td>
                    <td>
                        <strong>{{ $item->name }}</strong>
                    </td>
                    <td>
                        <a href="mailto:{{ $item->email }}" style="text-decoration: none;">{{ $item->email }}</a>
                    </td>
                    <td class="text-center">
                        @if($item->role == 'admin')
                            <span class="badge badge-admin">ADMIN</span>
                        @else
                            <span class="badge badge-user">USER</span>
                        @endif
                    </td>
                    <td>
                        <small class="text-muted">
                            {{ date('d/m/Y H:i', strtotime($item->created_at)) }}
                        </small>
                    </td>
                    <td>
                        <div class="table-actions">
                            <a href="{{ APP_URL }}/admin/users/edit/{{ $item->id }}" 
                               class="btn btn-primary btn-sm" 
                               title="Chỉnh sửa">
                                <i class="fa fa-edit"></i> Sửa
                            </a>
                            @if($item->id != 1)
                            <form action="{{ APP_URL }}/admin/users/delete/{{ $item->id }}" 
                                  method="POST" 
                                  style="display:inline;">
                                <button type="submit" 
                                        class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Bạn chắc chắn muốn xóa user này?\n\nTên: {{ $item->name }}\nEmail: {{ $item->email }}');" 
                                        title="Xóa">
                                    <i class="fa fa-trash"></i> Xóa
                                </button>
                            </form>
                            @else
                            <span class="btn btn-danger btn-sm" style="opacity: 0.5; cursor: not-allowed;" title="Không thể xóa admin chính">
                                <i class="fa fa-trash"></i> Xóa
                            </span>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            @else
            <tr>
                <td colspan="6" class="text-center" style="padding: 30px;">
                    <p style="color: #999; margin: 0;">
                        <i class="fa fa-inbox" style="font-size: 24px; margin-bottom: 10px; display: block;"></i>
                        Chưa có user nào
                    </p>
                </td>
            </tr>
            @endif
        </tbody>
    </table>
</div>

<!-- Thống kê -->
<div style="margin-top: 30px; padding: 15px; background-color: #f8f9fa; border-radius: 5px;">
    <h5 style="margin-top: 0;">Thống kê:</h5>
    <p style="margin: 5px 0;">
        <strong>Tổng số users:</strong> {{ count($users) }}
        <span style="margin-left: 30px;">
            <strong>Admin:</strong> 
            <span style="color: #dc3545;">{{ count(array_filter($users, fn($u) => $u->role == 'admin')) }}</span>
        </span>
        <span style="margin-left: 30px;">
            <strong>Users thường:</strong> 
            <span style="color: #28a745;">{{ count(array_filter($users, fn($u) => $u->role == 'user')) }}</span>
        </span>
    </p>
</div>

@endsection
