@extends('layouts.app')
@section('title', 'danh sách sản phẩm')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Danh sách sản phẩm</h4>
    <a href="{{ APP_URL }}/admin/products/add" class="btn btn-success"><i class="fa fa-plus"></i> ADD</a>
</div>

<form method="GET" action="{{ APP_URL }}/admin/products" class="row g-2 mb-3">
    <div class="col-md-5">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Tìm theo tên sản phẩm..." value="{{ $keyword ?? '' }}">
            <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
            @if(!empty($keyword) || !empty($filterSize) || !empty($filterSole))
            <a href="{{ APP_URL }}/admin/products" class="btn btn-outline-secondary"><i class="fa fa-times"></i></a>
            @endif
        </div>
    </div>
    <div class="col-md-3">
        <select name="size" class="form-select" onchange="this.form.submit()">
            <option value="">-- Lọc theo Size --</option>
            @foreach($allSizes as $s)
            <option value="{{ $s }}" {{ ($filterSize ?? '') === $s ? 'selected' : '' }}>Size {{ $s }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <select name="sole" class="form-select" onchange="this.form.submit()">
            <option value="">-- Lọc theo Đế --</option>
            @foreach($allSoles as $s)
            <option value="{{ $s }}" {{ ($filterSole ?? '') === $s ? 'selected' : '' }}>Đế {{ $s }}</option>
            @endforeach
        </select>
    </div>
</form>

@if(!empty($keyword) || !empty($filterSize) || !empty($filterSole))
<p class="text-muted mb-2">
    Tìm thấy <strong>{{ count($products) }}</strong> sản phẩm
    @if(!empty($keyword)) &mdash; tên: <strong>"{{ $keyword }}"</strong> @endif
    @if(!empty($filterSize)) &mdash; size: <strong>{{ $filterSize }}</strong> @endif
    @if(!empty($filterSole)) &mdash; đế: <strong>{{ $filterSole }}</strong> @endif
</p>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Image</th>
            <th>Quantity</th>
            <th>Size</th>
            <th>Màu</th>
            <th>Đế</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->price }}</td>
            <td><img src="{{ APP_URL }}{{ $item->image }}" alt="" width="100"></td>
            <td>{{ $item->quantity }}</td>
            <td>
                @if(!empty($item->sizes))
                    @foreach(explode(',', $item->sizes) as $s)
                        <span class="badge bg-secondary">{{ trim($s) }}</span>
                    @endforeach
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>
            <td>
                @if(!empty($item->colors))
                    @foreach(explode(',', $item->colors) as $c)
                        <span class="badge bg-info text-dark">{{ trim($c) }}</span>
                    @endforeach
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>
            <td>
                @if(!empty($item->sole))
                    @foreach(explode(',', $item->sole) as $s)
                        <span class="badge bg-warning text-dark">{{ trim($s) }}</span>
                    @endforeach
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>
            <td>{{ $item->description }}</td>
            <td>
                <a href="{{ APP_URL }}/admin/products/show/{{ $item->id }}" class="btn btn-info btn-sm" title="Xem"><i class="fa fa-eye"></i></a>
                <a href="{{ APP_URL }}/admin/products/edit/{{ $item->id }}" class="btn btn-primary btn-sm" title="Sửa"><i class="fa fa-edit"></i></a>
                <form action="{{ APP_URL }}/admin/products/delete/{{ $item->id }}" method="POST" style="display:inline;">
                    <button type="submit" class="btn btn-danger btn-sm" title="Xóa" onclick="return confirm('Bạn chắc chắn muốn xóa?')"><i class="fa fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
