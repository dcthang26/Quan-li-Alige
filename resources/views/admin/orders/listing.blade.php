@extends('layouts.app')
@section('title', 'Quản lý Đơn hàng')
@section('css')
<style>
:root {
    --primary: #6366f1;
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
    box-shadow: 0 8px 32px rgba(15,23,42,0.25);
    animation: slideDown 0.5s ease;
}
.page-header h4 { margin: 0; font-size: 1.6rem; font-weight: 700; }
.page-header p  { margin: 4px 0 0; opacity: 0.7; font-size: 0.88rem; }

.stats-row {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 14px;
    margin-bottom: 24px;
    animation: fadeUp 0.5s ease 0.1s both;
}
.stat-card {
    background: var(--card);
    border-radius: 16px;
    padding: 16px 18px;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    transition: transform 0.2s;
    cursor: default;
}
.stat-card:hover { transform: translateY(-3px); }
.stat-dot {
    width: 10px; height: 10px;
    border-radius: 50%;
    flex-shrink: 0;
}
.stat-label { font-size: 0.75rem; color: var(--muted); font-weight: 500; }
.stat-value { font-size: 1.4rem; font-weight: 800; color: var(--text); line-height: 1; }

.filter-card {
    background: var(--card);
    border-radius: 16px;
    padding: 18px 24px;
    margin-bottom: 20px;
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    animation: fadeUp 0.5s ease 0.15s both;
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}
.filter-label { font-size: 0.82rem; font-weight: 600; color: var(--muted); white-space: nowrap; }
.status-filter-btn {
    padding: 6px 16px;
    border-radius: 20px;
    border: 1.5px solid var(--border);
    background: white;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    color: var(--muted);
}
.status-filter-btn:hover, .status-filter-btn.active {
    border-color: currentColor;
    color: var(--text);
    background: #f8fafc;
}

.table-card {
    background: var(--card);
    border-radius: 20px;
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    overflow: hidden;
    animation: fadeUp 0.5s ease 0.2s both;
}
.table-card table { margin: 0; }
.table-card thead th {
    background: #f8fafc;
    color: var(--muted);
    font-size: 0.72rem;
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
    font-size: 0.88rem;
}
.table-card tbody tr:last-child td { border-bottom: none; }

.order-id {
    font-weight: 800;
    font-size: 0.9rem;
    color: var(--text);
    background: #f1f5f9;
    padding: 4px 10px;
    border-radius: 8px;
    display: inline-block;
}
.customer-name { font-weight: 600; color: var(--text); }
.customer-email { font-size: 0.78rem; color: var(--muted); }

.price-tag {
    font-weight: 800;
    font-size: 0.95rem;
    color: #059669;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    white-space: nowrap;
}
.status-pending    { background: #fef3c7; color: #92400e; }
.status-processing { background: #dbeafe; color: #1e40af; }
.status-shipping   { background: #cffafe; color: #155e75; }
.status-completed  { background: #d1fae5; color: #065f46; }
.status-cancelled  { background: #fee2e2; color: #991b1b; }

.status-select-wrap select {
    border: 1.5px solid var(--border);
    border-radius: 10px;
    padding: 6px 10px;
    font-size: 0.8rem;
    font-weight: 600;
    background: white;
    cursor: pointer;
    transition: border-color 0.2s;
    min-width: 150px;
}
.status-select-wrap select:focus { border-color: var(--primary); outline: none; }

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
.action-btn.view   { background: #dbeafe; color: #1d4ed8; }
.action-btn.view:hover   { background: #1d4ed8; color: white; transform: scale(1.1); }
.action-btn.delete { background: #fee2e2; color: #dc2626; }
.action-btn.delete:hover { background: #dc2626; color: white; transform: scale(1.1); }

.empty-state { text-align:center; padding:60px 20px; color:var(--muted); }
.empty-state i { font-size:3rem; margin-bottom:12px; opacity:0.4; display:block; }

.table-footer {
    padding: 14px 24px;
    border-top: 1px solid var(--border);
    background: #f8fafc;
    font-size: 0.82rem;
    color: var(--muted);
}

@keyframes slideDown { from { opacity:0; transform:translateY(-20px); } to { opacity:1; transform:translateY(0); } }
@keyframes fadeUp    { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
@keyframes rowIn     { from { opacity:0; transform:translateX(-10px); } to { opacity:1; transform:translateX(0); } }
</style>
@endsection
@section('content')

@php
$statusMap = [
    'pending'    => ['label'=>'Chờ xác nhận', 'class'=>'status-pending',    'icon'=>'fa-clock',        'dot'=>'#f59e0b'],
    'processing' => ['label'=>'Chuẩn bị hàng','class'=>'status-processing', 'icon'=>'fa-box',          'dot'=>'#3b82f6'],
    'shipping'   => ['label'=>'Đang giao',     'class'=>'status-shipping',   'icon'=>'fa-truck',        'dot'=>'#06b6d4'],
    'completed'  => ['label'=>'Hoàn thành',    'class'=>'status-completed',  'icon'=>'fa-check-circle', 'dot'=>'#10b981'],
    'cancelled'  => ['label'=>'Đã hủy',        'class'=>'status-cancelled',  'icon'=>'fa-times-circle', 'dot'=>'#ef4444'],
];
$counts = [];
foreach($statusMap as $k => $v) {
    $counts[$k] = count(array_filter($orders, fn($o) => ($o->status ?? 'pending') === $k));
}
@endphp

{{-- Header --}}
<div class="page-header">
    <div>
        <h4><i class="fas fa-receipt me-2"></i>Quản lý Đơn hàng</h4>
        <p>Theo dõi và xử lý tất cả đơn hàng trong hệ thống</p>
    </div>
    <div style="text-align:right">
        <div style="font-size:2rem;font-weight:800">{{ count($orders) }}</div>
        <div style="opacity:0.7;font-size:0.82rem">Tổng đơn hàng</div>
    </div>
</div>

{{-- Stats --}}
<div class="stats-row">
    @foreach($statusMap as $key => $info)
    <div class="stat-card">
        <div class="stat-dot" style="background:{{ $info['dot'] }}"></div>
        <div>
            <div class="stat-label">{{ $info['label'] }}</div>
            <div class="stat-value">{{ $counts[$key] }}</div>
        </div>
    </div>
    @endforeach
</div>

{{-- Filter --}}
<div class="filter-card">
    <span class="filter-label"><i class="fas fa-filter me-1"></i>Lọc:</span>
    <button class="status-filter-btn active" onclick="filterTable('all',this)">Tất cả</button>
    @foreach($statusMap as $key => $info)
    <button class="status-filter-btn" onclick="filterTable('{{ $key }}',this)"
        style="--c:{{ $info['dot'] }}">
        <i class="fas {{ $info['icon'] }} me-1"></i>{{ $info['label'] }}
        <span style="background:{{ $info['dot'] }};color:white;border-radius:10px;padding:1px 7px;font-size:0.7rem;margin-left:4px">{{ $counts[$key] }}</span>
    </button>
    @endforeach
</div>

{{-- Table --}}
<div class="table-card">
    <table class="table" id="ordersTable">
        <thead>
            <tr>
                <th style="width:90px">Mã đơn</th>
                <th>Khách hàng</th>
                <th style="width:140px">Tổng tiền</th>
                <th style="width:200px">Trạng thái</th>
                <th style="width:160px">Ngày đặt</th>
                <th style="width:90px;text-align:center">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @if(count($orders) > 0)
                @foreach($orders as $i => $order)
                @php $status = $order->status ?? 'pending'; $cur = $statusMap[$status] ?? $statusMap['pending']; @endphp
                <tr data-status="{{ $status }}" style="animation-delay:{{ $i * 0.04 }}s">
                    <td>
                        <span class="order-id">{{ $i + 1 }}</span>
                    </td>
                    <td>
                        <div class="customer-name">{{ $order->user_name ?? 'Khách vãng lai' }}</div>
                        <div class="customer-email">{{ $order->user_email ?? '—' }}</div>
                    </td>
                    <td>
                        <span class="price-tag">{{ number_format($order->total ?? 0) }}đ</span>
                    </td>
                    <td>
                        @if($status === 'cancelled')
                            <span class="status-badge {{ $cur['class'] }}">
                                <i class="fas {{ $cur['icon'] }}"></i>{{ $cur['label'] }}
                            </span>
                        @else
                        <div class="status-select-wrap">
                            <form method="POST" action="{{ APP_URL }}/admin/orders/{{ $order->id }}/status">
                                <input type="hidden" name="redirect" value="/admin/orders">
                                <select name="status" onchange="this.form.submit()">
                                    @foreach($statusMap as $val => $info)
                                    <option value="{{ $val }}" {{ $status === $val ? 'selected' : '' }}>{{ $info['label'] }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                        @endif
                    </td>
                    <td style="color:var(--muted);font-size:0.8rem">
                        <i class="fas fa-calendar me-1"></i>{{ date('d/m/Y', strtotime($order->created_at ?? 'now')) }}<br>
                        <span style="font-size:0.75rem">{{ date('H:i', strtotime($order->created_at ?? 'now')) }}</span>
                    </td>
                    <td>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ APP_URL }}/admin/orders/{{ $order->id }}" class="action-btn view" title="Xem chi tiết">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form method="POST" action="{{ APP_URL }}/admin/orders/{{ $order->id }}/delete" style="display:inline"
                                onsubmit="return confirm('Xóa đơn hàng #{{ $order->id }}?')">
                                <button type="submit" class="action-btn delete" title="Xóa">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            @else
            <tr>
                <td colspan="6">
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <div style="font-size:1rem;font-weight:600;color:var(--text)">Chưa có đơn hàng nào</div>
                        <div style="font-size:0.85rem;margin-top:4px">Đơn hàng sẽ xuất hiện khi khách hàng đặt mua</div>
                    </div>
                </td>
            </tr>
            @endif
        </tbody>
    </table>
    <div class="table-footer">
        Tổng cộng <strong>{{ count($orders) }}</strong> đơn hàng
    </div>
</div>

@endsection
@section('js')
<script>
function filterTable(status, btn) {
    document.querySelectorAll('.status-filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('#ordersTable tbody tr[data-status]').forEach(row => {
        row.style.display = (status === 'all' || row.dataset.status === status) ? '' : 'none';
    });
}
</script>
@endsection
