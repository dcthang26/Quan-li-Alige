@extends('client.layout.app')
@section('title', 'Thanh toán')
@section('content')

<div class="page-banner d-flex align-items-center gap-3 mb-4">
    <i class="fas fa-credit-card fa-2x"></i>
    <div>
        <h4 class="mb-0 fw-bold">Thanh toán</h4>
        <small class="opacity-75">Kiểm tra và xác nhận đơn hàng</small>
    </div>
</div>

{{-- Stepper --}}
<div class="d-flex align-items-center gap-2 mb-4">
    <span class="badge rounded-pill bg-secondary px-3 py-2"><i class="fas fa-shopping-cart me-1"></i>Giỏ hàng</span>
    <i class="fas fa-chevron-right text-muted"></i>
    <span class="badge rounded-pill px-3 py-2" style="background:var(--blue)"><i class="fas fa-credit-card me-1"></i>Thanh toán</span>
    <i class="fas fa-chevron-right text-muted"></i>
    <span class="badge rounded-pill bg-secondary px-3 py-2"><i class="fas fa-check me-1"></i>Hoàn tất</span>
</div>

<form action="{{ APP_URL }}/user/checkout/confirm" method="POST">
<div class="row g-4">

    {{-- Thông tin giao hàng --}}
    <div class="col-lg-7">
        <div class="card profile-card mb-4">
            <div class="card-header"><i class="fas fa-map-marker-alt me-2"></i>Thông tin giao hàng</div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="info-label mb-1">Họ tên người nhận</label>
                        <input type="text" name="receiver_name" class="form-control"
                            value="{{ $_SESSION['user']->name }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="info-label mb-1">Số điện thoại</label>
                        <input type="tel" name="phone" class="form-control" placeholder="0xxxxxxxxx" required>
                    </div>
                    <div class="col-12">
                        <label class="info-label mb-1">Địa chỉ</label>
                        <input type="text" name="address" class="form-control" placeholder="Số nhà, tên đường" required>
                    </div>
                    <div class="col-md-6">
                        <label class="info-label mb-1">Quận / Huyện</label>
                        <input type="text" name="district" class="form-control" placeholder="Quận / Huyện" required>
                    </div>
                    <div class="col-md-6">
                        <label class="info-label mb-1">Tỉnh / Thành phố</label>
                        <input type="text" name="city" class="form-control" placeholder="Tỉnh / Thành phố" required>
                    </div>
                    <div class="col-12">
                        <label class="info-label mb-1">Ghi chú</label>
                        <textarea name="note" class="form-control" rows="2" placeholder="Ghi chú cho người giao hàng (không bắt buộc)"></textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Phương thức thanh toán --}}
        <div class="card profile-card">
            <div class="card-header"><i class="fas fa-wallet me-2"></i>Phương thức thanh toán</div>
            <div class="card-body p-4">
                <div class="d-flex flex-column gap-3">
                    <label class="payment-option d-flex align-items-center gap-3 p-3 rounded-3 border" style="cursor:pointer">
                        <input type="radio" name="payment_method" value="cod" checked class="form-check-input mt-0">
                        <i class="fas fa-money-bill-wave fa-lg text-success"></i>
                        <div>
                            <div class="fw-semibold">Thanh toán khi nhận hàng (COD)</div>
                            <small class="text-muted">Trả tiền mặt khi nhận được hàng</small>
                        </div>
                    </label>
                    <label class="payment-option d-flex align-items-center gap-3 p-3 rounded-3 border" style="cursor:pointer">
                        <input type="radio" name="payment_method" value="bank" class="form-check-input mt-0">
                        <i class="fas fa-university fa-lg" style="color:var(--blue)"></i>
                        <div>
                            <div class="fw-semibold">Chuyển khoản ngân hàng</div>
                            <small class="text-muted">Chuyển khoản trước khi giao hàng</small>
                        </div>
                    </label>
                </div>
            </div>
        </div>
    </div>

    {{-- Tóm tắt đơn hàng --}}
    <div class="col-lg-5">
        <div class="card summary-card">
            <div class="card-header"><i class="fas fa-receipt me-2"></i>Đơn hàng của bạn</div>
            <div class="card-body p-4">
                @php $total = 0; @endphp
                @foreach($cart as $item)
                @php $total += $item['price'] * $item['quantity']; @endphp
                <div class="d-flex align-items-center gap-3 mb-3">
                    @if(!empty($item['image']))
                        <img src="{{ APP_URL }}{{ $item['image'] }}" class="product-thumb" alt="{{ $item['name'] }}">
                    @else
                        <div class="product-thumb-placeholder"><i class="fas fa-image"></i></div>
                    @endif
                    <div class="flex-grow-1">
                        <div class="fw-semibold text-truncate" style="max-width:160px">{{ $item['name'] }}</div>
                        <small class="text-muted">x{{ $item['quantity'] }}</small>
                    </div>
                    <div class="fw-bold" style="color:var(--blue)">{{ number_format($item['price'] * $item['quantity']) }}đ</div>
                </div>
                @endforeach

                <hr>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Tạm tính</span>
                    <span>{{ number_format($total) }}đ</span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted">Phí vận chuyển</span>
                    <span class="text-success fw-semibold">Miễn phí</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <span class="fw-bold fs-5">Tổng cộng</span>
                    <span class="summary-total">{{ number_format($total) }}đ</span>
                </div>

                <button type="submit" class="btn-checkout">
                    <i class="fas fa-check-circle me-2"></i>Xác nhận đặt hàng
                </button>
                <a href="{{ APP_URL }}/user/cart" class="btn btn-outline-secondary w-100 mt-2">
                    <i class="fas fa-arrow-left me-1"></i>Quay lại giỏ hàng
                </a>
            </div>
        </div>
    </div>

</div>
</form>
@endsection
