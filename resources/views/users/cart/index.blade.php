@extends('client.layout.app')
@section('title', 'Giỏ hàng')
@section('content')

<div class="page-banner d-flex align-items-center gap-3">
    <i class="fas fa-shopping-cart fa-2x"></i>
    <div>
        <h4 class="mb-0 fw-bold">Giỏ hàng của bạn</h4>
        <small class="opacity-75">{{ count($cart ?? []) }} sản phẩm</small>
    </div>
</div>

@if(session_flash('success'))
    <div class="alert alert-success alert-dismissible fade show"><i class="fas fa-check-circle me-2"></i>{{ session_flash('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

@if(!empty($cart) && count($cart) > 0)
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <table class="table cart-table mb-0">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Tên</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart as $item)
                        <tr>
                            <td>
                                @if(!empty($item['image']))
                                    <img src="{{ APP_URL }}{{ $item['image'] }}" class="product-thumb" alt="{{ $item['name'] }}">
                                @else
                                    <div class="product-thumb-placeholder"><i class="fas fa-image"></i></div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $item['name'] }}</div>
                                <small class="text-muted">ID: #{{ $item['id'] }}</small>
                            </td>
                            <td class="price-col">{{ number_format($item['price']) }}đ</td>
                            <td>
                                <form action="{{ APP_URL }}/user/cart/update" method="POST" class="d-flex align-items-center gap-1">
                                    <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="qty-input">
                                    <button type="submit" class="btn btn-sm btn-outline-primary px-2"><i class="fas fa-sync-alt"></i></button>
                                </form>
                            </td>
                            <td class="price-col fw-bold">{{ number_format($item['price'] * $item['quantity']) }}đ</td>
                            <td>
                                <form action="{{ APP_URL }}/user/cart/remove" method="POST">
                                    <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                    <button type="submit" class="btn-remove" title="Xóa"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-3 d-flex gap-2">
            <a href="{{ APP_URL }}list" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i>Tiếp tục mua</a>
            <form action="{{ APP_URL }}/user/cart/clear" method="POST">
                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Xóa toàn bộ giỏ hàng?')"><i class="fas fa-trash me-1"></i>Xóa tất cả</button>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card summary-card">
            <div class="card-header"><i class="fas fa-receipt me-2"></i>Tóm tắt đơn hàng</div>
            <div class="card-body p-4">
                @php $total = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart)); @endphp
                <div class="summary-row"><span class="text-muted">Tạm tính</span><span>{{ number_format($total) }}đ</span></div>
                <div class="summary-row"><span class="text-muted">Phí vận chuyển</span><span class="text-success">Miễn phí</span></div>
                <div class="d-flex justify-content-between align-items-center mt-3 mb-4">
                    <span class="fw-bold">Tổng cộng</span>
                    <span class="summary-total">{{ number_format($total) }}đ</span>
                </div>
                <a href="{{ APP_URL }}/user/checkout" class="btn-checkout">
                    <i class="fas fa-credit-card me-2"></i>Đặt hàng ngay
                </a>
            </div>
        </div>
    </div>
</div>
@else
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body empty-cart">
        <i class="fas fa-shopping-cart d-block"></i>
        <h5 class="fw-bold text-dark mb-2">Giỏ hàng trống</h5>
        <p class="mb-4">Bạn chưa có sản phẩm nào trong giỏ hàng.</p>
        <a href="{{ APP_URL }}list" class="btn btn-primary px-5"><i class="fas fa-store me-2"></i>Mua sắm ngay</a>
    </div>
</div>
@endif
@endsection
