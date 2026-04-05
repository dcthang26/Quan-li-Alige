@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

@php
$statusMap = [
    'pending'    => ['label' => 'Chờ xác nhận', 'color' => 'warning',  'icon' => 'fa-clock'],
    'processing' => ['label' => 'Chuẩn bị hàng','color' => 'primary',  'icon' => 'fa-box'],
    'shipping'   => ['label' => 'Đang giao',     'color' => 'info',     'icon' => 'fa-truck'],
    'completed'  => ['label' => 'Hoàn thành',    'color' => 'success',  'icon' => 'fa-check-circle'],
    'cancelled'  => ['label' => 'Đã hủy',        'color' => 'danger',   'icon' => 'fa-times-circle'],
];
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold"><i class="fas fa-tachometer-alt me-2 text-primary"></i>Dashboard</h4>
    <small class="text-muted"><i class="fas fa-calendar me-1"></i>{{ date('d/m/Y H:i') }}</small>
</div>

{{-- ── KPI Cards ── --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-2">
        <div class="card border-0 shadow-sm h-100" style="border-left:4px solid #198754!important">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small mb-1">Doanh thu</div>
                        <div class="fw-bold fs-6 text-success">{{ number_format($totalRevenue) }}đ</div>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-success bg-opacity-10" style="width:40px;height:40px">
                        <i class="fas fa-dollar-sign text-success"></i>
                    </div>
                </div>
                <small class="text-muted">Đơn hoàn thành</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-2">
        <div class="card border-0 shadow-sm h-100" style="border-left:4px solid #0d6efd!important">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small mb-1">Đơn hàng</div>
                        <div class="fw-bold fs-5 text-primary">{{ $totalOrders }}</div>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary bg-opacity-10" style="width:40px;height:40px">
                        <i class="fas fa-receipt text-primary"></i>
                    </div>
                </div>
                <small class="text-warning"><i class="fas fa-clock me-1"></i>{{ $pendingOrders }} chờ xử lý</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-2">
        <div class="card border-0 shadow-sm h-100" style="border-left:4px solid #6f42c1!important">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small mb-1">Sản phẩm</div>
                        <div class="fw-bold fs-5" style="color:#6f42c1">{{ $totalProducts }}</div>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:40px;height:40px;background:rgba(111,66,193,.1)">
                        <i class="fas fa-box" style="color:#6f42c1"></i>
                    </div>
                </div>
                <small class="text-danger"><i class="fas fa-exclamation-triangle me-1"></i>{{ $lowStock }} sắp hết</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-2">
        <div class="card border-0 shadow-sm h-100" style="border-left:4px solid #0dcaf0!important">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small mb-1">Khách hàng</div>
                        <div class="fw-bold fs-5 text-info">{{ $totalUsers }}</div>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-info bg-opacity-10" style="width:40px;height:40px">
                        <i class="fas fa-users text-info"></i>
                    </div>
                </div>
                <small class="text-muted">Tài khoản user</small>
            </div>
        </div>
    </div>
</div>

{{-- ── Charts row ── --}}
<div class="row g-3 mb-4">
    {{-- Doanh thu 6 tháng --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-3 pb-0">
                <h6 class="fw-bold mb-0"><i class="fas fa-chart-bar me-2 text-primary"></i>Doanh thu 6 tháng gần nhất</h6>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="100"></canvas>
            </div>
        </div>
    </div>
    {{-- Trạng thái đơn hàng --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-3 pb-0">
                <h6 class="fw-bold mb-0"><i class="fas fa-chart-pie me-2 text-primary"></i>Trạng thái đơn hàng</h6>
            </div>
            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                <canvas id="statusChart" style="max-height:200px"></canvas>
                <div class="mt-3 w-100">
                    @foreach($orderStatus as $s)
                    @php $info = $statusMap[$s->status] ?? ['label'=>$s->status,'color'=>'secondary','icon'=>'fa-circle']; @endphp
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="badge bg-{{ $info['color'] }} bg-opacity-75">{{ $info['label'] }}</span>
                        <strong>{{ $s->total }}</strong>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── Bottom row ── --}}
<div class="row g-3">
    {{-- Top sản phẩm --}}
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-3 pb-0">
                <h6 class="fw-bold mb-0"><i class="fas fa-exclamation-triangle text-warning me-2"></i>Sản phẩm sắp hết hàng</h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Sản phẩm</th>
                            <th class="text-center">Tồn kho</th>
                            <th class="text-end pe-3">Giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topProducts as $i => $p)
                        <tr>
                            <td class="ps-3">
                                @if($i == 0) <span class="badge bg-danger">!</span>
                                @elseif($i == 1) <span class="badge bg-warning text-dark">!</span>
                                @else <span class="text-muted">{{ $i+1 }}</span>
                                @endif
                            </td>
                            <td class="text-truncate" style="max-width:140px">
                                <a href="{{ APP_URL }}/admin/products/show/{{ $p->id }}" class="text-decoration-none">{{ $p->name }}</a>
                            </td>
                            <td class="text-center">
                                <span class="badge {{ $p->quantity == 0 ? 'bg-danger' : 'bg-warning text-dark' }}">{{ $p->quantity }}</span>
                            </td>
                            <td class="text-end pe-3 text-success fw-semibold">{{ number_format($p->price) }}đ</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted py-3">Không có sản phẩm nào</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Đơn hàng mới nhất --}}
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-3 pb-0 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0"><i class="fas fa-receipt text-primary me-2"></i>Đơn hàng mới nhất</h6>
                <a href="{{ APP_URL }}/admin/orders" class="btn btn-outline-primary btn-sm py-0">Xem tất cả</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <tbody>
                        @forelse($recentOrders as $o)
                        @php $info = $statusMap[$o->status] ?? ['label'=>$o->status,'color'=>'secondary','icon'=>'fa-circle']; @endphp
                        <tr>
                            <td class="ps-3"><a href="{{ APP_URL }}/admin/orders/{{ $o->id }}" class="fw-semibold text-decoration-none">#{{ $o->id }}</a></td>
                            <td class="text-truncate" style="max-width:100px"><small>{{ $o->user_name ?? 'Khách' }}</small></td>
                            <td><span class="badge bg-{{ $info['color'] }} bg-opacity-75" style="font-size:.7rem">{{ $info['label'] }}</span></td>
                            <td class="text-end pe-3 text-success fw-semibold"><small>{{ number_format($o->total) }}đ</small></td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted py-3">Chưa có đơn hàng</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
@php
    $months   = array_map(fn($r) => $r->month,   $revenueChart);
    $revenues = array_map(fn($r) => (float)$r->revenue, $revenueChart);
    $statusLabels = array_map(fn($s) => ($statusMap[$s->status]['label'] ?? $s->status), $orderStatus);
    $statusData   = array_map(fn($s) => (int)$s->total, $orderStatus);
    $statusColors = array_map(fn($s) => [
        'pending'=>'#ffc107','processing'=>'#0d6efd','shipping'=>'#0dcaf0',
        'completed'=>'#198754','cancelled'=>'#dc3545'
    ][$s->status] ?? '#6c757d', $orderStatus);
@endphp

// Revenue bar chart
new Chart(document.getElementById('revenueChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($months) !!},
        datasets: [{
            label: 'Doanh thu (đ)',
            data: {!! json_encode($revenues) !!},
            backgroundColor: 'rgba(13,110,253,.7)',
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { ticks: { callback: v => (v/1000000).toFixed(1) + 'M' } }
        }
    }
});

// Status doughnut chart
new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($statusLabels) !!},
        datasets: [{
            data: {!! json_encode($statusData) !!},
            backgroundColor: {!! json_encode($statusColors) !!},
            borderWidth: 2,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        cutout: '65%',
    }
});
</script>
@endsection
