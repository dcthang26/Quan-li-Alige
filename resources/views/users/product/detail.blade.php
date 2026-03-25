@extends('client.layout.app')
@section('title', $product->name ?? 'Chi tiết sản phẩm')
@section('content')

{{-- Breadcrumb --}}
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ APP_URL }}list"><i class="fas fa-home"></i> Trang chủ</a></li>
        <li class="breadcrumb-item active">{{ $product->name }}</li>
    </ol>
</nav>

<div class="row g-5 mb-5">
    {{-- Ảnh sản phẩm --}}
    <div class="col-lg-5">
        <div class="product-img-wrap">
            @if(!empty($product->image))
                <img src="{{ APP_URL }}{{ $product->image }}" alt="{{ $product->name }}">
            @else
                <div class="product-img-placeholder"><i class="fas fa-image"></i></div>
            @endif
        </div>
    </div>

    {{-- Thông tin sản phẩm --}}
    <div class="col-lg-7">
        <h1 class="product-title mb-2">{{ $product->name }}</h1>
        <div class="mb-3">
            @if($product->quantity > 0)
                <span class="badge-stock"><i class="fas fa-check-circle me-1"></i>Còn {{ $product->quantity }} sản phẩm</span>
            @else
                <span class="badge-stock out"><i class="fas fa-times-circle me-1"></i>Hết hàng</span>
            @endif
        </div>

        <div class="mb-4">
            <span class="product-price">{{ number_format($product->price) }}đ</span>
        </div>

        <p class="text-muted mb-4" style="line-height:1.8">{{ $product->description }}</p>

        @if($product->quantity > 0)
        <form action="{{ APP_URL }}/user/cart/add" method="POST">
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            @if(!empty($product->sizes))
            <div class="mb-3">
                <label class="fw-semibold mb-2 d-block">Size</label>
                <div class="d-flex flex-wrap gap-2">
                    @foreach(explode(',', $product->sizes) as $size)
                    @php $size = trim($size); @endphp
                    <input type="radio" class="btn-check" name="size" id="size_{{ $size }}" value="{{ $size }}" required>
                    <label class="btn btn-outline-secondary btn-sm" for="size_{{ $size }}">{{ $size }}</label>
                    @endforeach
                </div>
            </div>
            @endif

            @if(!empty($product->colors))
            <div class="mb-3">
                <label class="fw-semibold mb-2 d-block">Màu sắc</label>
                <div class="d-flex flex-wrap gap-2">
                    @foreach(explode(',', $product->colors) as $color)
                    @php $color = trim($color); @endphp
                    <input type="radio" class="btn-check" name="color" id="color_{{ $color }}" value="{{ $color }}" required>
                    <label class="btn btn-outline-secondary btn-sm" for="color_{{ $color }}">{{ $color }}</label>
                    @endforeach
                </div>
            </div>
            @endif

            @if(!empty($product->sole))
            <div class="mb-3">
                <label class="fw-semibold mb-2 d-block">Đế giày</label>
                <span class="badge bg-secondary fs-6">Đế {{ $product->sole }}</span>
            </div>
            @endif

            <div class="mb-4">
                <label class="fw-semibold mb-2 d-block">Số lượng</label>
                <div class="qty-wrap">
                    <button type="button" id="qtyMinus">−</button>
                    <input type="number" name="quantity" id="qtyInput" value="1" min="1" max="{{ $product->quantity }}">
                    <button type="button" id="qtyPlus">+</button>
                </div>
            </div>
            <div class="d-flex gap-3 flex-wrap">
                <button type="submit" class="btn-add-cart"><i class="fas fa-shopping-cart me-2"></i>Thêm vào giỏ</button>
                <button type="submit" name="buy_now" value="1" class="btn-buy-now"><i class="fas fa-bolt me-2"></i>Mua ngay</button>
            </div>
        </form>
        @else
        <button class="btn-add-cart opacity-50" disabled><i class="fas fa-shopping-cart me-2"></i>Hết hàng</button>
        @endif
    </div>
</div>

{{-- Mô tả chi tiết --}}
<div class="card desc-card mb-5">
    <div class="card-header"><i class="fas fa-align-left me-2"></i>Mô tả sản phẩm</div>
    <div class="card-body p-4" style="line-height:1.9; color:#333">
        {{ $product->description ?? 'Chưa có mô tả chi tiết.' }}
    </div>
</div>

{{-- Sản phẩm liên quan --}}
@if(!empty($related) && count($related) > 0)
<h5 class="fw-bold mb-3"><i class="fas fa-th-large me-2 text-primary"></i>Sản phẩm liên quan</h5>
<div class="row g-3">
    @foreach($related as $item)
    <div class="col-6 col-md-4 col-lg-3">
        <div class="card related-card h-100">
            @if(!empty($item->image))
                <img src="{{ APP_URL }}{{ $item->image }}" class="related-img" alt="{{ $item->name }}">
            @else
                <div class="related-img bg-light d-flex align-items-center justify-content-center"><i class="fas fa-image fa-2x text-muted"></i></div>
            @endif
            <div class="card-body p-3">
                <div class="fw-semibold text-truncate mb-1">{{ $item->name }}</div>
                <div class="related-price mb-2">{{ number_format($item->price) }}đ</div>
                <a href="{{ APP_URL }}/user/product/{{ $item->id }}" class="btn btn-sm btn-outline-primary w-100">Xem chi tiết</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection

@section('js')
<script>
    const qtyInput = document.getElementById('qtyInput');
    const max = parseInt(qtyInput?.max || 1);
    document.getElementById('qtyMinus')?.addEventListener('click', () => {
        qtyInput.value = Math.max(1, +qtyInput.value - 1);
    });
    document.getElementById('qtyPlus')?.addEventListener('click', () => {
        qtyInput.value = Math.min(max, +qtyInput.value + 1);
    });
</script>
@endsection
