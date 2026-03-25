@extends('layouts.app')
@section('title', 'Edit sản phẩm')
@section('content')
<h1>Edit sản phẩm</h1>

@if(isset($_SESSION['error']))
<div class="alert alert-danger alert-dismissible fade show">
    {{ $_SESSION['error'] }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@php unset($_SESSION['error']); @endphp
@endif

<form method="POST" action="{{ APP_URL }}admin/products/update/{{ $productCurrent->id }}" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" class="form-control" name="name" required value="{{ $productCurrent->name }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Price</label>
        <input type="number" class="form-control" name="price" required value="{{ $productCurrent->price }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Image hiện tại</label><br>
        @if(!empty($productCurrent->image))
            <img src="{{ APP_URL }}{{ $productCurrent->image }}" width="100" class="mb-2 rounded">
        @endif
        <input type="file" class="form-control" name="image" accept="image/*">
    </div>
    <div class="mb-3">
        <label class="form-label">Quantity</label>
        <input type="number" class="form-control" name="quantity" required value="{{ $productCurrent->quantity }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" name="description" rows="3">{{ $productCurrent->description }}</textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Size <small class="text-muted">(phân cách bằng dấu phẩy, VD: 38,39,40,41,42)</small></label>
        <input type="text" class="form-control" name="sizes" value="{{ $productCurrent->sizes ?? '' }}" placeholder="38,39,40,41,42">
    </div>
    <div class="mb-3">
        <label class="form-label">Màu sắc <small class="text-muted">(phân cách bằng dấu phẩy)</small></label>
        <input type="text" class="form-control" name="colors" value="{{ $productCurrent->colors ?? '' }}" placeholder="Đỏ,Xanh,Đen,Trắng">
    </div>
    <div class="mb-3">
        <label class="form-label">Đế giày <small class="text-muted">(phân cách bằng dấu phẩy, VD: mềm,cứng,dẻo)</small></label>
        <input type="text" class="form-control" name="sole" value="{{ $productCurrent->sole ?? '' }}" placeholder="mềm,cứng,dẻo">
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Cập nhật</button>
</form>
@endsection