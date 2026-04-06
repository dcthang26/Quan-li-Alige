@extends('layouts.app')
@section('title', 'Quản lý Users')
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
    --shadow: 0 4px 24px rgba(99,102,241,0.08);
}
body { background: var(--bg); }

.page-header {
    background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 60%, #3b82f6 100%);
    border-radius: 20px;
    padding: 28px 32px;
    margin-bottom: 28px;
    color: white;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 8px 32px rgba(29,78,216,0.25);
    animation: slideDown 0.5s ease;
}
.page-header h4 { margin: 0; font-size: 1.6rem; font-weight: 700; letter-spacing: -0.5px; }
.page-header p { margin: 4px 0 0; opacity: 0.85; font-size: 0.9rem; }

.btn-add {
    background: white;
    color: var(--primary);
    border: none;
    padding: 10px 22px;
    border-radius: 12px;
    font-weight: 700;
    font-size: 0.9rem;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    white-space: nowrap;
}
.btn-add:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.2); color: var(--primary-dark); }

.stats-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 24px;
    animation: fadeUp 0.5s ease 0.1s both;
}
.stat-card {
    background: var(--card);
    border-radius: 16px;
    padding: 20px 24px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    transition: transform 0.2s;
}
.stat-card:hover { transform: translateY(-3px); }
.stat-icon {
    width: 52px; height: 52px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem;
    flex-shrink: 0;
}
.stat-icon.purple { background: #ede9fe; color: #7c3aed; }
.stat-icon.green  { background: #d1fae5; color: #059669; }
.stat-icon.red    { background: #fee2e2; color: #dc2626; }
.stat-label { font-size: 0.8rem; color: var(--muted); font-weight: 500; }
.stat-value { font-size: 1.6rem; font-weight: 800; color: var(--text); line-height: 1; }

.filter-card {
    background: var(--card);
    border-radius: 16px;
    padding: 20px 24px;
    margin-bottom: 20px;
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    animation: fadeUp 0.5s ease 0.2s both;
}
.search-wrap {
    position: relative;
}
.search-wrap .fa-search {
    position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
    color: var(--muted); font-size: 0.9rem;
}
.search-wrap input {
    padding-left: 40px;
    border-radius: 12px;
    border: 1.5px solid var(--border);
    height: 44px;
    font-size: 0.9rem;
    transition: border-color 0.2s, box-shadow 0.2s;
    width: 100%;
}
.search-wrap input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
    outline: none;
}
.filter-select {
    border-radius: 12px;
    border: 1.5px solid var(--border);
    height: 44px;
    font-size: 0.9rem;
    padding: 0 14px;
    transition: border-color 0.2s;
    width: 100%;
    background: white;
}
.filter-select:focus { border-color: var(--primary); outline: none; box-shadow: 0 0 0 3px rgba(99,102,241,0.12); }

.btn-search {
    background: var(--primary);
    color: white;
    border: none;
    border-radius: 12px;
    height: 44px;
    padding: 0 20px;
    font-weight: 600;
    transition: all 0.2s;
    white-space: nowrap;
}
.btn-search:hover { background: var(--primary-dark); transform: translateY(-1px); }
.btn-clear {
    background: #f1f5f9;
    color: var(--muted);
    border: 1.5px solid var(--border);
    border-radius: 12px;
    height: 44px;
    padding: 0 16px;
    transition: all 0.2s;
    text-decoration: none;
    display: flex; align-items: center;
}
.btn-clear:hover { background: #e2e8f0; color: var(--text); }

.table-card {
    background: var(--card);
    border-radius: 20px;
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    overflow: hidden;
    animation: fadeUp 0.5s ease 0.3s both;
}
.table-card table { margin: 0; }
.table-card thead th {
    background: #f8fafc;
    color: var(--muted);
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    padding: 14px 20px;
    border-bottom: 1px solid var(--border);
    border-top: none;
}
.table-card tbody tr {
    transition: background 0.15s;
    animation: rowIn 0.4s ease both;
}
.table-card tbody tr:hover { background: #f8fafc; }
.table-card tbody td {
    padding: 14px 20px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
    font-size: 0.9rem;
}
.table-card tbody tr:last-child td { border-bottom: none; }

.user-avatar {
    width: 38px; height: 38px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 0.95rem;
    color: white;
    flex-shrink: 0;
}
.user-name { font-weight: 600; color: var(--text); font-size: 0.9rem; }
.user-email { font-size: 0.8rem; color: var(--muted); }

.badge-role {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.5px;
}
.badge-admin { background: #ede9fe; color: #7c3aed; }
.badge-user  { background: #d1fae5; color: #059669; }

.action-btn {
    width: 34px; height: 34px;
    border-radius: 10px;
    border: none;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 0.85rem;
    transition: all 0.2s;
    text-decoration: none;
    cursor: pointer;
}
.action-btn.edit   { background: #ede9fe; color: #7c3aed; }
.action-btn.edit:hover   { background: #7c3aed; color: white; transform: scale(1.1); }
.action-btn.delete { background: #fee2e2; color: #dc2626; }
.action-btn.delete:hover { background: #dc2626; color: white; transform: scale(1.1); }
.action-btn.disabled-del { background: #f1f5f9; color: #cbd5e1; cursor: not-allowed; }

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: var(--muted);
}
.empty-state i { font-size: 3rem; margin-bottom: 12px; opacity: 0.4; display: block; }

.pagination-wrap {
    display: flex; align-items: center; justify-content: space-between;
    padding: 16px 24px;
    border-top: 1px solid var(--border);
    background: #f8fafc;
}
.pagination { margin: 0; }
.page-link {
    border-radius: 10px !important;
    margin: 0 2px;
    border: 1.5px solid var(--border);
    color: var(--text);
    font-size: 0.85rem;
    padding: 6px 12px;
    transition: all 0.2s;
}
.page-item.active .page-link { background: var(--primary); border-color: var(--primary); color: white; }
.page-link:hover { background: var(--primary); border-color: var(--primary); color: white; }

.result-info { font-size: 0.82rem; color: var(--muted); }

@keyframes slideDown { from { opacity:0; transform:translateY(-20px); } to { opacity:1; transform:translateY(0); } }
@keyframes fadeUp    { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
@keyframes rowIn     { from { opacity:0; transform:translateX(-10px); } to { opacity:1; transform:translateX(0); } }
</style>
@endsection
@section('content')

@php
    $totalUsers = $total;
    $totalAdmin = count(array_filter($users, fn($u) => $u->role === 'admin'));
    $totalUser  = count(array_filter($users, fn($u) => $u->role === 'user'));
@endphp

{{-- Header --}}
<div class="page-header">
    <div>
        <h4><i class="fas fa-users me-2"></i>Quản lý Users</h4>
        <p>Quản lý tài khoản và phân quyền người dùng</p>
    </div>
    <a href="{{ APP_URL }}/admin/users/add" class="btn-add">
        <i class="fas fa-user-plus"></i> Thêm User
    </a>
</div>

{{-- Stats --}}
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon purple"><i class="fas fa-users"></i></div>
        <div>
            <div class="stat-label">Tổng Users</div>
            <div class="stat-value">{{ $total }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red"><i class="fas fa-user-shield"></i></div>
        <div>
            <div class="stat-label">Admin</div>
            <div class="stat-value">{{ $totalAdmin }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-user"></i></div>
        <div>
            <div class="stat-label">Khách hàng</div>
            <div class="stat-value">{{ $totalUser }}</div>
        </div>
    </div>
</div>

{{-- Filter --}}
<div class="filter-card">
    <form method="GET" action="{{ APP_URL }}/admin/users">
        <div class="d-flex gap-3 align-items-center flex-wrap">
            <div class="search-wrap flex-grow-1" style="min-width:220px">
                <i class="fas fa-search"></i>
                <input type="text" name="q" placeholder="Tìm theo tên, email..." value="{{ $keyword ?? '' }}">
            </div>
            <select name="role" class="filter-select" style="width:180px" onchange="this.form.submit()">
                <option value="">Tất cả vai trò</option>
                <option value="admin" {{ ($filterRole ?? '') === 'admin' ? 'selected' : '' }}>🛡 Admin</option>
                <option value="user"  {{ ($filterRole ?? '') === 'user'  ? 'selected' : '' }}>👤 User</option>
            </select>
            <button class="btn-search" type="submit"><i class="fas fa-search me-1"></i>Tìm</button>
            @if(!empty($keyword) || !empty($filterRole))
            <a href="{{ APP_URL }}/admin/users" class="btn-clear"><i class="fas fa-times me-1"></i>Xóa lọc</a>
            @endif
        </div>
    </form>
    @if(!empty($keyword) || !empty($filterRole))
    <div class="mt-2" style="font-size:0.82rem;color:var(--muted)">
        Tìm thấy <strong style="color:var(--text)">{{ $total }}</strong> kết quả
        @if(!empty($keyword)) &mdash; từ khóa: <strong>"{{ $keyword }}"</strong>@endif
        @if(!empty($filterRole)) &mdash; vai trò: <strong>{{ $filterRole }}</strong>@endif
    </div>
    @endif
</div>

{{-- Table --}}
<div class="table-card">
    <table class="table">
        <thead>
            <tr>
                <th style="width:60px">ID</th>
                <th>Người dùng</th>
                <th style="width:100px">Vai trò</th>
                <th style="width:160px">Ngày tạo</th>
                <th style="width:100px;text-align:center">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @if(count($users) > 0)
                @foreach($users as $i => $item)
                @php
                    $colors = ['#6366f1','#8b5cf6','#ec4899','#f59e0b','#10b981','#3b82f6'];
                    $color  = $colors[$item->id % count($colors)];
                    $initials = strtoupper(substr($item->name, 0, 1));
                @endphp
                <tr style="animation-delay: {{ $i * 0.05 }}s">
                    <td><span style="font-weight:700;color:var(--muted);font-size:0.8rem">#{{ $item->id }}</span></td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="user-avatar" style="background:{{ $color }}">{{ $initials }}</div>
                            <div>
                                <div class="user-name">{{ $item->name }}</div>
                                <div class="user-email">{{ $item->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($item->role == 'admin')
                            <span class="badge-role badge-admin"><i class="fas fa-shield-alt me-1"></i>Admin</span>
                        @else
                            <span class="badge-role badge-user"><i class="fas fa-user me-1"></i>User</span>
                        @endif
                    </td>
                    <td style="color:var(--muted);font-size:0.82rem">
                        <i class="fas fa-calendar-alt me-1"></i>{{ date('d/m/Y H:i', strtotime($item->created_at)) }}
                    </td>
                    <td>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ APP_URL }}/admin/users/edit/{{ $item->id }}" class="action-btn edit" title="Chỉnh sửa">
                                <i class="fas fa-pen"></i>
                            </a>
                            @if($item->id != 1)
                            <form action="{{ APP_URL }}/admin/users/delete/{{ $item->id }}" method="POST" style="display:inline">
                                <button type="submit" class="action-btn delete" title="Xóa"
                                    onclick="return confirm('Xóa user {{ $item->name }}?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @else
                            <span class="action-btn disabled-del" title="Không thể xóa admin chính">
                                <i class="fas fa-lock"></i>
                            </span>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            @else
            <tr>
                <td colspan="5">
                    <div class="empty-state">
                        <i class="fas fa-users-slash"></i>
                        <div style="font-size:1rem;font-weight:600;color:var(--text)">Không tìm thấy user nào</div>
                        <div style="font-size:0.85rem;margin-top:4px">Thử thay đổi bộ lọc hoặc thêm user mới</div>
                    </div>
                </td>
            </tr>
            @endif
        </tbody>
    </table>

    @if($totalPages > 1)
    <div class="pagination-wrap">
        <div class="result-info">Hiển thị {{ count($users) }} / {{ $total }} user &nbsp;·&nbsp; Trang {{ $page }}/{{ $totalPages }}</div>
        <nav>
            <ul class="pagination pagination-sm">
                <li class="page-item {{ $page <= 1 ? 'disabled' : '' }}">
                    <a class="page-link" href="?page={{ $page-1 }}&q={{ $keyword }}&role={{ $filterRole }}"><i class="fas fa-chevron-left"></i></a>
                </li>
                @for($i = 1; $i <= $totalPages; $i++)
                <li class="page-item {{ $i == $page ? 'active' : '' }}">
                    <a class="page-link" href="?page={{ $i }}&q={{ $keyword }}&role={{ $filterRole }}">{{ $i }}</a>
                </li>
                @endfor
                <li class="page-item {{ $page >= $totalPages ? 'disabled' : '' }}">
                    <a class="page-link" href="?page={{ $page+1 }}&q={{ $keyword }}&role={{ $filterRole }}"><i class="fas fa-chevron-right"></i></a>
                </li>
            </ul>
        </nav>
    </div>
    @else
    <div class="pagination-wrap">
        <div class="result-info">Hiển thị {{ count($users) }} / {{ $total }} user</div>
    </div>
    @endif
</div>
@endsection
