@extends('client.layout.app')
@section('title', 'Đặt hàng thành công')
@section('content')

<div class="text-center py-5">
    <div class="mb-4" style="font-size:5rem; color:var(--blue)">
        <i class="fas fa-check-circle"></i>
    </div>
    <h2 class="fw-bold mb-2">Đặt hàng thành công!</h2>
    <p class="text-muted mb-1">Cảm ơn bạn đã mua hàng. Đơn hàng <strong>#{{ $orderId }}</strong> đã được ghi nhận.</p>
    <p class="text-muted mb-4">Chúng tôi sẽ liên hệ xác nhận trong thời gian sớm nhất.</p>

    <div class="card mx-auto mb-4" style="max-width:480px; border:none; border-radius:16px; box-shadow:0 4px 24px rgba(21,101,192,.12)">
        <div class="card-body p-4 text-start">
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Mã đơn hàng</span>
                <span class="fw-bold">#{{ $orderId }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Người nhận</span>
                <span class="fw-semibold">{{ $info['receiver_name'] }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Số điện thoại</span>
                <span>{{ $info['phone'] }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Địa chỉ</span>
                <span class="text-end" style="max-width:240px">{{ $info['address'] }}, {{ $info['district'] }}, {{ $info['city'] }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Thanh toán</span>
                <span>{{ $info['payment_method'] === 'cod' ? 'Thanh toán khi nhận hàng' : 'Chuyển khoản ngân hàng' }}</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between">
                <span class="fw-bold">Tổng tiền</span>
                <span class="fw-bold fs-5" style="color:var(--blue)">{{ number_format($total) }}đ</span>
            </div>
        </div>
    </div>

    <div class="d-flex gap-3 justify-content-center flex-wrap">
        <a href="{{ APP_URL }}/user/orders" class="btn btn-primary px-4">
            <i class="fas fa-box me-2"></i>Xem đơn hàng
        </a>
        <a href="{{ APP_URL }}list" class="btn btn-outline-primary px-4">
            <i class="fas fa-store me-2"></i>Tiếp tục mua sắm
        </a>
    </div>
</div>

@endsection
