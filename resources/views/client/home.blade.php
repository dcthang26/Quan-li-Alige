@extends('client.layout.app')
@section('title', 'Danh sách sản phẩm')
@section('content')

<h4 class="fw-bold mb-4"><i class="fas fa-list me-2"></i>Danh sách sản phẩm</h4>

<form method="GET" action="{{ APP_URL }}list" class="mb-4">
    <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Tìm kiếm sản phẩm..." value="{{ $keyword ?? '' }}">
        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
        @if(!empty($keyword))
        <a href="{{ APP_URL }}list" class="btn btn-outline-secondary"><i class="fas fa-times"></i></a>
        @endif
    </div>
</form>

@if(!empty($keyword))
<p class="text-muted mb-3">Kết quả tìm kiếm cho: <strong>"{{ $keyword }}"</strong> &mdash; {{ count($data) }} sản phẩm</p>
@endif

@if(count($data) > 0)
<div class="row">
    @foreach($data as $item)
    <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
        <div class="card product-card">
            @if($item->image)
                <img src="{{ APP_URL }}{{ $item->image }}" alt="{{ $item->name }}" class="product-image">
            @else
                <div class="product-image bg-light d-flex align-items-center justify-content-center">
                    <i class="fas fa-image fa-3x text-muted"></i>
                </div>
            @endif
            <div class="card-body">
                <h5 class="card-title text-truncate">{{ $item->name }}</h5>
                <p class="card-text text-muted small">{{ substr($item->description, 0, 60) }}...</p>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="product-price">{{ number_format($item->price) }}đ</span>
                    <small class="text-success">
                        <i class="fas fa-check-circle"></i> {{ $item->quantity }} sản phẩm
                    </small>
                </div>
                <div class="d-grid gap-2">
                    <a href="{{ APP_URL }}/user/product/{{ $item->id }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-eye"></i> Chi tiết
                    </a>
                    <form action="{{ APP_URL }}/user/cart/add" method="POST">
                        <input type="hidden" name="product_id" value="{{ $item->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn btn-success btn-sm w-100">
                            <i class="fas fa-shopping-cart"></i> Thêm giỏ hàng
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="alert alert-info text-center">
    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
    @if(!empty($keyword))
        <p>Không tìm thấy sản phẩm nào cho <strong>"{{ $keyword }}"</strong></p>
        <a href="{{ APP_URL }}list" class="btn btn-outline-primary btn-sm">Xem tất cả sản phẩm</a>
    @else
        <p>Hiện không có sản phẩm nào</p>
    @endif
</div>
@endif

@endsection
