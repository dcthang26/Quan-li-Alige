@extends('client.layout.app')
@section('title', 'Trang chủ')
@section('content')

<div class="text-center py-5 mb-5 rounded-4 page-banner">
    <h1 class="fw-bold mb-3" style="font-size:2.8rem">Chào mừng đến với <span style="color:#90CAF9">Shop</span></h1>
    <p class="mb-4 opacity-75 fs-5">Khám phá hàng ngàn sản phẩm chất lượng với giá tốt nhất</p>
    <a href="{{ APP_URL }}list" class="btn btn-light btn-lg px-5 fw-semibold me-3">
        <i class="fas fa-store me-2"></i>Mua sắm ngay
    </a>
    @if(!isset($_SESSION['user']))
    <a href="{{ APP_URL }}/register" class="btn btn-outline-light btn-lg px-5 fw-semibold">
        <i class="fas fa-user-plus me-2"></i>Đăng ký
    </a>
    @endif
</div>

<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="text-center p-4 rounded-4 h-100 stat-box">
            <i class="fas fa-shipping-fast fa-2x mb-3" style="color:#1565C0"></i>
            <h5 class="fw-bold">Giao hàng nhanh</h5>
            <p class="text-muted mb-0">Giao hàng toàn quốc trong 2–3 ngày làm việc</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="text-center p-4 rounded-4 h-100 stat-box">
            <i class="fas fa-shield-alt fa-2x mb-3" style="color:#1565C0"></i>
            <h5 class="fw-bold">Bảo hành chính hãng</h5>
            <p class="text-muted mb-0">Tất cả sản phẩm đều có bảo hành từ nhà sản xuất</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="text-center p-4 rounded-4 h-100 stat-box">
            <i class="fas fa-undo fa-2x mb-3" style="color:#1565C0"></i>
            <h5 class="fw-bold">Đổi trả dễ dàng</h5>
            <p class="text-muted mb-0">Hoàn tiền 100% nếu sản phẩm không đúng mô tả</p>
        </div>
    </div>
</div>

<h4 class="fw-bold mb-4"><i class="fas fa-fire text-danger me-2"></i>Sản phẩm nổi bật</h4>
<div class="row g-3">
    @foreach(array_slice($data, 0, 4) as $item)
    <div class="col-6 col-md-3">
        <div class="card product-card shadow-sm">
            @if($item->image)
                <img src="{{ APP_URL }}{{ $item->image }}" class="product-image" alt="{{ $item->name }}">
            @else
                <div class="product-image bg-light d-flex align-items-center justify-content-center">
                    <i class="fas fa-image fa-3x text-muted"></i>
                </div>
            @endif
            <div class="card-body">
                <h6 class="card-title text-truncate">{{ $item->name }}</h6>
                <div class="product-price mb-2">{{ number_format($item->price) }}đ</div>
                <a href="{{ APP_URL }}/user/product/{{ $item->id }}" class="btn btn-primary btn-sm w-100">
                    <i class="fas fa-eye me-1"></i>Xem chi tiết
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="text-center mt-4">
    <a href="{{ APP_URL }}list" class="btn btn-outline-primary px-5">
        <i class="fas fa-th me-2"></i>Xem tất cả sản phẩm
    </a>
</div>

@endsection
