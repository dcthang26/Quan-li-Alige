@extends('layouts.app')
@section('title', 'Quản lý Tài khoản Users')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Quản lý Tài khoản Users</h4>
    <a href="{{ APP_URL }}/admin/users/add" class="btn btn-success btn-sm">
        <i class="fa fa-plus"></i> Thêm User
    </a>
</div>

{{-- Bộ lọc --}}
<form method="GET" action="{{ APP_URL }}/admin/users" class="row g-2 mb-3">
    <div class="col-md-5">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Tìm theo tên, email..." value="{{ $keyword ?? '' }}">
            <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
            @if(!empty($keyword) || !empty($filterRole))
            <a href="{{ APP_URL }}/admin/users" class="btn btn-outline-secondary"><i class="fa fa-times"></i></a>
            @endif
        </div>
    </div>
    <div class="col-md-3">
        <select name="role" class="form-select" onchange="this.form.submit()">
            <option value="">-- Tất cả Role --</option>
            <option value="admin" {{ ($filterRole ?? '') === 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="user"  {{ ($filterRole ?? '') === 'user'  ? 'selected' : '' }}>User</option>
        </select>
    </div>
</form>

@if(!empty($keyword) || !empty($filterRole))
<p class="text-muted mb-2">
    Tìm thấy <strong>{{ $total }}</strong> user
    @if(!empty($keyword)) &mdash; từ khóa: <strong>"{{ $keyword }}"</strong> @endif
    @if(!empty($filterRole)) &mdash; role: <strong>{{ $filterRole }}</strong> @endif
</p>
@endif

<div style="overflow-x:auto;">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width:50px">ID</th>
                <th>Tên User</th>
                <th>Email</th>
                <th style="width:90px">Role</th>
                <th style="width:160px">Ngày Tạo</th>
                <th style="width:90px">Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @if(count($users) > 0)
                @foreach($users as $item)
                <tr>
                    <td class="text-center"><strong>#{{ $item->id }}</strong></td>
                    <td><strong>{{ $item->name }}</strong></td>
                    <td><a href="mailto:{{ $item->email }}" style="text-decoration:none">{{ $item->email }}</a></td>
                    <td class="text-center">
                        @if($item->role == 'admin')
                            <span class="badge bg-danger">ADMIN</span>
                        @else
                            <span class="badge bg-success">USER</span>
                        @endif
                    </td>
                    <td><small class="text-muted">{{ date('d/m/Y H:i', strtotime($item->created_at)) }}</small></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ APP_URL }}/admin/users/edit/{{ $item->id }}" class="btn btn-primary btn-sm" title="Chỉnh sửa">
                                <i class="fa fa-edit"></i>
                            </a>
                            @if($item->id != 1)
                            <form action="{{ APP_URL }}/admin/users/delete/{{ $item->id }}" method="POST" style="display:inline;">
                                <button type="submit" class="btn btn-danger btn-sm" title="Xóa"
                                    onclick="return confirm('Xóa user {{ $item->name }}?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                            @else
                            <span class="btn btn-danger btn-sm disabled" title="Không thể xóa admin chính">
                                <i class="fa fa-trash"></i>
                            </span>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            @else
            <tr>
                <td colspan="6" class="text-center py-4 text-muted">
                    <i class="fa fa-inbox fa-2x d-block mb-2"></i>Không có user nào
                </td>
            </tr>
            @endif
        </tbody>
    </table>
</div>

{{-- Phân trang --}}
@if($totalPages > 1)
<nav>
    <ul class="pagination pagination-sm justify-content-center">
        <li class="page-item {{ $page <= 1 ? 'disabled' : '' }}">
            <a class="page-link" href="?page={{ $page - 1 }}&q={{ $keyword }}&role={{ $filterRole }}">
                <i class="fa fa-chevron-left"></i>
            </a>
        </li>
        @for($i = 1; $i <= $totalPages; $i++)
        <li class="page-item {{ $i == $page ? 'active' : '' }}">
            <a class="page-link" href="?page={{ $i }}&q={{ $keyword }}&role={{ $filterRole }}">{{ $i }}</a>
        </li>
        @endfor
        <li class="page-item {{ $page >= $totalPages ? 'disabled' : '' }}">
            <a class="page-link" href="?page={{ $page + 1 }}&q={{ $keyword }}&role={{ $filterRole }}">
                <i class="fa fa-chevron-right"></i>
            </a>
        </li>
    </ul>
</nav>
@endif

{{-- Thống kê --}}
<div class="text-muted small mt-2">
    Hiển thị {{ count($users) }} / {{ $total }} user &nbsp;|&nbsp;
    Trang {{ $page }}/{{ $totalPages }}
</div>

@endsection
