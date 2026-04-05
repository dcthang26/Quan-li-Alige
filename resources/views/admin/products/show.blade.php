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
    {{-- Ảnh --}}
    <div class="col-lg-5">
        <div class="rounded-3 overflow-hidden border" style="background:#f8f9fa;">
            @if(!empty($product->image))
                <img src="{{ APP_URL }}{{ $product->image }}" class="w-100" style="height:420px;object-fit:cover;" alt="{{ $product->name }}">
            @else
                <div class="d-flex align-items-center justify-content-center" style="height:420px;">
                    <i class="fas fa-image fa-5x text-muted"></i>
                </div>
            @endif
        </div>
    </div>

    {{-- Thông tin --}}
    <div class="col-lg-7">
        <h3 class="fw-bold mb-1">{{ $product->name }}</h3>
        <p class="text-muted mb-3">ID: #{{ $product->id }}</p>

        <div class="fs-2 fw-bold text-danger mb-3">{{ number_format($product->price) }}đ</div>

        <div class="mb-3">
            @if($product->quantity > 0)
                <span class="badge bg-success-subtle text-success border border-success px-3 py-2">
                    <i class="fas fa-check-circle me-1"></i>Còn hàng ({{ $product->quantity }} sản phẩm)
                </span>
            @else
                <span class="badge bg-danger-subtle text-danger border border-danger px-3 py-2">
                    <i class="fas fa-times-circle me-1"></i>Hết hàng
                </span>
            @endif
        </div>

        <hr>

        {{-- Size --}}
        @if(!empty($product->sizes))
        <div class="mb-3">
            <div class="fw-semibold mb-2">Size</div>
            <div class="d-flex flex-wrap gap-2">
                @foreach(explode(',', $product->sizes) as $s)
                    <span class="border rounded px-3 py-1 fw-semibold" style="font-size:.9rem">{{ trim($s) }}</span>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Màu --}}
        @if(!empty($product->colors))
        <div class="mb-3">
            <div class="fw-semibold mb-2">Màu sắc</div>
            <div class="d-flex flex-wrap gap-2">
                @foreach(explode(',', $product->colors) as $c)
                    <span class="badge bg-info text-dark px-3 py-2">{{ trim($c) }}</span>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Đế --}}
        @if(!empty($product->sole))
        <div class="mb-3">
            <div class="fw-semibold mb-2">Đế giày</div>
            <div class="d-flex flex-wrap gap-2">
                @foreach(explode(',', $product->sole) as $s)
                    <span class="badge bg-warning text-dark px-3 py-2">{{ trim($s) }}</span>
                @endforeach
            </div>
        </div>
        @endif

        <hr>

        {{-- Mô tả --}}
        <div>
            <div class="fw-semibold mb-2">Mô tả sản phẩm</div>
            <p class="text-muted mb-0">{{ $product->description ?: '—' }}</p>
        </div>
    </div>
</div>

@endsection
