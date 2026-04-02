@extends('layouts.app')
@section('title', 'Chi tiết Đơn hàng')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Chi tiết đơn hàng #{{ $order->id }}</h2>
    <a href="{{ APP_URL }}/admin/orders" class="btn btn-secondary btn-sm">
        <i class="fa fa-arrow-left"></i> Quay lại
    </a>
</div>

@php
    $statusMap = [
        'pending'    => ['label' => 'Chờ xác nhận', 'badge' => 'warning', 'text' => 'dark', 'icon' => 'fa-clock'],
        'processing' => ['label' => 'Chuẩn bị hàng', 'badge' => 'primary', 'text' => 'white', 'icon' => 'fa-box'],
        'shipping'   => ['label' => 'Đang giao',     'badge' => 'info',    'text' => 'dark',  'icon' => 'fa-truck'],
        'completed'  => ['label' => 'Hoàn thành',    'badge' => 'success', 'text' => 'white', 'icon' => 'fa-check-circle'],
        'cancelled'  => ['label' => 'Đã hủy',        'badge' => 'danger',  'text' => 'white', 'icon' => 'fa-times-circle'],
    ];
    $cur = $statusMap[$order->status] ?? ['label' => $order->status, 'badge' => 'secondary', 'text' => 'white', 'icon' => 'fa-circle'];
@endphp

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card mb-4">
            <div class="card-header fw-semibold"><i class="fa fa-user me-2"></i>Thông tin khách hàng</div>
            <div class="card-body">
                <p class="mb-1"><strong>Tên:</strong> {{ $order->user_name ?? 'Khách vãng lai' }}</p>
                <p class="mb-0"><strong>Email:</strong> {{ $order->user_email ?? '-' }}</p>
            </div>
        </div>
        <div class="card">
            <div class="card-header fw-semibold"><i class="fa fa-receipt me-2"></i>Thông tin đơn hàng</div>
            <div class="card-body">
                <p class="mb-1"><strong>Mã đơn:</strong> #{{ $order->id }}</p>
                <p class="mb-1"><strong>Tổng tiền:</strong> <span class="text-primary fw-bold">{{ number_format($order->total ?? 0) }}đ</span></p>
                <p class="mb-1"><strong>Ngày đặt:</strong> {{ date('d/m/Y H:i', strtotime($order->created_at ?? 'now')) }}</p>
                <p class="mb-0"><strong>Trạng thái hiện tại:</strong>
                    <span class="badge bg-{{ $cur['badge'] }} text-{{ $cur['text'] }} ms-1">
                        <i class="fas {{ $cur['icon'] }} me-1"></i>{{ $cur['label'] }}
                    </span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card border-primary">
            <div class="card-header bg-primary text-white fw-semibold"><i class="fa fa-edit me-2"></i>Cập nhật trạng thái</div>
            <div class="card-body">
                @if($order->status === 'cancelled')
                    <div class="alert alert-danger mb-0 d-flex align-items-center gap-2">
                        <i class="fas fa-times-circle fa-lg"></i>
                        <span>Đơn hàng này đã bị hủy, không thể thay đổi trạng thái.</span>
                    </div>
                @else
                <form method="POST" action="{{ APP_URL }}/admin/orders/{{ $order->id }}/status">
                    <input type="hidden" name="redirect" value="/admin/orders/{{ $order->id }}">
                    <div class="mb-3">
                        @foreach($statusMap as $val => $info)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="status" id="status_{{ $val }}" value="{{ $val }}" {{ $order->status === $val ? 'checked' : '' }}>
                            <label class="form-check-label d-flex align-items-center gap-2" for="status_{{ $val }}">
                                <span class="badge bg-{{ $info['badge'] }} text-{{ $info['text'] }}">
                                    <i class="fas {{ $info['icon'] }} me-1"></i>{{ $info['label'] }}
                                </span>
                            </label>
                        </div>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="fa fa-save me-2"></i>Lưu trạng thái</button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
