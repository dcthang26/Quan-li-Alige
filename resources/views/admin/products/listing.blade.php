@extends('layouts.app')
@section('title', 'danh sách sản phẩm')
@section('content')

@if(isset($_SESSION['success']))
<div class="alert alert-success alert-dismissible fade show">
    {{ $_SESSION['success'] }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@php unset($_SESSION['success']); @endphp
@endif

<a href="{{ APP_URL }}/admin/products/add" class="btn btn-success mb-3"><i class="fa fa-plus"></i>ADD</a>
<table class="table table-bordered">
    <thread>
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
                @else <span class="text-muted">-</span>
                @endif
            </td>
            <td>
                @if(!empty($item->colors))
                    @foreach(explode(',', $item->colors) as $c)
                        <span class="badge bg-info text-dark">{{ trim($c) }}</span>
                    @endforeach
                @else <span class="text-muted">-</span>
                @endif
            </td>
            <td>
                @if(!empty($item->sole))
                    <span class="badge bg-warning text-dark">{{ $item->sole }}</span>
                @else <span class="text-muted">-</span>
                @endif
            </td>
            <td>{{ $item->description }}</td>
            <td>
                <a href="{{ APP_URL }}/admin/products/edit/{{ $item->id }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i>Edit</a>
                <form action="{{ APP_URL }}/admin/products/delete/{{ $item->id }}" method="POST" style="display:inline;">
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn chắc chắn muốn xóa?')"><i class="fa fa-trash"></i>Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection