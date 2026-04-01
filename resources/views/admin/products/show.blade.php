@extends('layouts.app')
@section('title', 'Chi tiết sản phẩm')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="fa fa-box me-2"></i>Chi tiết sản phẩm</h4>
    <div class="d-flex gap-2">
        <a href="{{ APP_URL }}/admin/products/edit/{{ $product->id }}" class="btn btn-primary btn-sm"><i class="fa fa-edit me-1"></i>Chỉnh sửa</a>
        <a href="{{ APP_URL }}/admin/products" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left me-1"></i>Quay lại</a>
    </div>
</div>

<div class="row g-4">
    {{-- Ảnh sản phẩm --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            @if(!empty($product->image))
                <img src="{{ APP_URL }}{{ $product->image }}" class="card-img-top rounded" style="height:320px;object-fit:cover;" alt="{{ $product->name }}">
            @else
                <div class="d-flex align-items-center justify-content-center bg-light rounded" style="height:320px;">
                    <i class="fas fa-image fa-4x text-muted"></i>
                </div>
            @endif
        </div>
    </div>

    {{-- Thông tin --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h4 class="fw-bold mb-1">{{ $product->name }}</h4>
                <p class="text-muted mb-3">ID: #{{ $product->id }}</p>

                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <div class="p-3 rounded bg-light">
                            <div class="text-muted small mb-1">Giá bán</div>
                            <div class="fw-bold fs-5 text-danger">{{ number_format($product->price) }}đ</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 rounded bg-light">
                            <div class="text-muted small mb-1">Số lượng tồn kho</div>
                            <div class="fw-bold fs-5 {{ $product->quantity > 0 ? 'text-success' : 'text-danger' }}">
                                {{ $product->quantity }}
                                <small class="fs-6">{{ $product->quantity > 0 ? 'còn hàng' : 'hết hàng' }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="text-muted small mb-1">Mô tả</div>
                    <p class="mb-0">{{ $product->description ?: '—' }}</p>
                </div>

                <hr>

                <div class="row g-3">
                    <div class="col-sm-4">
                        <div class="text-muted small mb-2">Size</div>
                        @if(!empty($product->sizes))
                            @foreach(explode(',', $product->sizes) as $s)
                                <span class="badge bg-secondary me-1 mb-1">{{ trim($s) }}</span>
                            @endforeach
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </div>
                    <div class="col-sm-4">
                        <div class="text-muted small mb-2">Màu sắc</div>
                        @if(!empty($product->colors))
                            @foreach(explode(',', $product->colors) as $c)
                                <span class="badge bg-info text-dark me-1 mb-1">{{ trim($c) }}</span>
                            @endforeach
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </div>
                    <div class="col-sm-4">
                        <div class="text-muted small mb-2">Đế giày</div>
                        @if(!empty($product->sole))
                            @foreach(explode(',', $product->sole) as $s)
                                <span class="badge bg-warning text-dark me-1 mb-1">{{ trim($s) }}</span>
                            @endforeach
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
