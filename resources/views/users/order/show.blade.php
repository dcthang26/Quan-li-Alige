@extends('client.layout.app')
@section('title', 'Chi tiết đơn hàng #' . $order->id)
@section('content')

<div class="page-banner d-flex align-items-center gap-3">
    <i class="fas fa-receipt fa-2x"></i>
    <div>
        <h4 class="mb-0 fw-bold">Chi tiết đơn hàng #{{ $order->id }}</h4>
        <small class="opacity-75">{{ date('d/m/Y H:i', strtotime($order->created_at)) }}</small>
    </div>
</div>

@php
    $statusMap = [
        'pending'    => ['label' => 'Chờ xác nhận', 'class' => 'status-pending',    'icon' => 'fa-clock'],
        'processing' => ['label' => 'Chuẩn bị hàng','class' => 'status-processing', 'icon' => 'fa-box'],
        'shipping'   => ['label' => 'Đang giao',    'class' => 'status-shipping',   'icon' => 'fa-truck'],
        'completed'  => ['label' => 'Hoàn thành',   'class' => 'status-completed',  'icon' => 'fa-check-circle'],
        'cancelled'  => ['label' => 'Đã hủy',       'class' => 'status-cancelled',  'icon' => 'fa-times-circle'],
    ];
    $steps = ['pending', 'processing', 'shipping', 'completed'];
    $currentIndex = array_search($order->status, $steps);
    $s = $statusMap[$order->status] ?? ['label' => $order->status, 'class' => 'status-pending', 'icon' => 'fa-circle'];
@endphp

{{-- Timeline trạng thái --}}
@if($order->status !== 'cancelled')
<div class="card border-0 shadow-sm rounded-4 mb-4 p-4">
    <div class="d-flex justify-content-between align-items-start position-relative">
        <div class="progress position-absolute" style="top:20px;left:10%;right:10%;height:4px;z-index:0">
            <div class="progress-bar bg-primary" style="width:{{ $currentIndex === false ? 0 : ($currentIndex / (count($steps)-1)) * 100 }}%"></div>
        </div>
        @foreach($steps as $i => $step)
        @php
            $done = $currentIndex !== false && $i <= $currentIndex;
            $info = $statusMap[$step];
        @endphp
        <div class="text-center flex-fill position-relative" style="z-index:1">
            <div class="mx-auto d-flex align-items-center justify-content-center rounded-circle mb-2"
                 style="width:42px;height:42px;background:{{ $done ? '#1565C0' : '#e0e0e0' }};color:{{ $done ? '#fff' : '#999' }}">
                <i class="fas {{ $info['icon'] }}"></i>
            </div>
            <small class="fw-semibold" style="color:{{ $done ? '#1565C0' : '#999' }}">{{ $info['label'] }}</small>
        </div>
        @endforeach
    </div>
</div>
@else
<div class="alert alert-danger d-flex align-items-center gap-2 rounded-4">
    <i class="fas fa-times-circle fa-lg"></i> Đơn hàng này đã bị hủy.
</div>
@endif

<div class="row g-4">
    {{-- Thông tin đơn --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-primary text-white rounded-top-4 fw-semibold">
                <i class="fas fa-shopping-bag me-2"></i>Sản phẩm trong đơn
            </div>
            <div class="card-body p-0">
                <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
                    <span class="text-muted">Mã đơn hàng</span>
                    <strong>#{{ $order->id }}</strong>
                </div>
                <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
                    <span class="text-muted">Ngày đặt</span>
                    <strong>{{ date('d/m/Y H:i', strtotime($order->created_at)) }}</strong>
                </div>
                <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
                    <span class="text-muted">Trạng thái</span>
                    <span class="status-badge {{ $s['class'] }}"><i class="fas {{ $s['icon'] }} me-1"></i>{{ $s['label'] }}</span>
                </div>
                <div class="p-4 d-flex justify-content-between align-items-center">
                    <span class="text-muted">Tổng tiền</span>
                    <strong class="fs-5" style="color:#1565C0">{{ number_format($order->total) }}đ</strong>
                </div>
            </div>
        </div>
    </div>

    {{-- Hành động --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h6 class="fw-bold mb-3">Hành động</h6>
            @if($order->status === 'pending')
            <form action="{{ APP_URL }}/user/orders/{{ $order->id }}/cancel" method="POST" onsubmit="return confirm('Hủy đơn hàng này?')">
                <button type="submit" class="btn btn-outline-danger w-100 mb-2"><i class="fas fa-times me-2"></i>Hủy đơn hàng</button>
            </form>
            @endif
            <a href="{{ APP_URL }}/user/orders" class="btn btn-outline-secondary w-100"><i class="fas fa-arrow-left me-2"></i>Quay lại</a>
        </div>
    </div>
</div>

@endsection
