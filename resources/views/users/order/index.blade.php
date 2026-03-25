@extends('client.layout.app')
@section('title', 'Đơn hàng của tôi')
@section('content')

<div class="page-banner d-flex align-items-center gap-3">
    <i class="fas fa-box fa-2x"></i>
    <div>
        <h4 class="mb-0 fw-bold">Đơn hàng của tôi</h4>
        <small class="opacity-75">Theo dõi trạng thái đơn hàng</small>
    </div>
</div>

{{-- Filter tabs --}}
<ul class="nav filter-tabs gap-2 mb-4">
    <li class="nav-item"><a class="nav-link {{ ($status ?? 'all') === 'all' ? 'active' : '' }}" href="{{ APP_URL }}/user/orders">Tất cả</a></li>
    <li class="nav-item"><a class="nav-link {{ ($status ?? '') === 'pending' ? 'active' : '' }}" href="{{ APP_URL }}/user/orders?status=pending">Chờ xác nhận</a></li>
    <li class="nav-item"><a class="nav-link {{ ($status ?? '') === 'processing' ? 'active' : '' }}" href="{{ APP_URL }}/user/orders?status=processing">Chuẩn bị hàng</a></li>
    <li class="nav-item"><a class="nav-link {{ ($status ?? '') === 'shipping' ? 'active' : '' }}" href="{{ APP_URL }}/user/orders?status=shipping">Đang giao</a></li>
    <li class="nav-item"><a class="nav-link {{ ($status ?? '') === 'completed' ? 'active' : '' }}" href="{{ APP_URL }}/user/orders?status=completed">Hoàn thành</a></li>
    <li class="nav-item"><a class="nav-link {{ ($status ?? '') === 'cancelled' ? 'active' : '' }}" href="{{ APP_URL }}/user/orders?status=cancelled">Đã hủy</a></li>
</ul>

@if(!empty($orders) && count($orders) > 0)
    @foreach($orders as $order)
    <div class="order-card card">
        <div class="order-header">
            <div>
                <span class="order-id"><i class="fas fa-hashtag"></i>{{ $order->id }}</span>
                <span class="order-date ms-3"><i class="fas fa-calendar-alt me-1"></i>{{ date('d/m/Y H:i', strtotime($order->created_at)) }}</span>
            </div>
            <div class="d-flex align-items-center gap-3">
                @php
                    $statusMap = [
                        'pending'    => ['label' => 'Chờ xác nhận', 'class' => 'status-pending'],
                        'processing' => ['label' => 'Chuẩn bị hàng',  'class' => 'status-processing'],
                        'shipping'   => ['label' => 'Đang giao',       'class' => 'status-shipping'],
                        'completed'  => ['label' => 'Hoàn thành',      'class' => 'status-completed'],
                        'cancelled'  => ['label' => 'Đã hủy',          'class' => 'status-cancelled'],
                    ];
                    $s = $statusMap[$order->status] ?? ['label' => ucfirst($order->status), 'class' => 'status-pending'];
                @endphp
                <span class="status-badge {{ $s['class'] }}">{{ $s['label'] }}</span>
                <span class="order-total">{{ number_format($order->total) }}đ</span>
            </div>
        </div>
        <div class="order-body d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="text-muted" style="font-size:.9rem">
                <i class="fas fa-info-circle me-1 text-primary"></i>
                Đơn hàng #{{ $order->id }} — Tổng: <strong class="text-dark">{{ number_format($order->total) }}đ</strong>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ APP_URL }}/user/orders/{{ $order->id }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye me-1"></i>Xem chi tiết</a>
                @if($order->status === 'pending')
                <form action="{{ APP_URL }}/user/orders/{{ $order->id }}/cancel" method="POST" onsubmit="return confirm('Hủy đơn hàng này?')">
                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-times me-1"></i>Hủy đơn</button>
                </form>
                @endif
            </div>
        </div>
    </div>
    @endforeach
@else
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body empty-orders">
        <i class="fas fa-box-open d-block"></i>
        <h5 class="fw-bold text-dark mb-2">Chưa có đơn hàng nào</h5>
        <p class="mb-4">Hãy mua sắm và đặt hàng ngay hôm nay!</p>
        <a href="{{ APP_URL }}list" class="btn btn-primary px-5"><i class="fas fa-store me-2"></i>Mua sắm ngay</a>
    </div>
</div>
@endif
@endsection
