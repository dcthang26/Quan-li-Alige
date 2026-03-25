@extends('layouts.app')
@section('title', 'Quản lý Đơn hàng')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Danh sách Đơn hàng</h2>
</div>

@if(isset($_SESSION['success']))
    <div class="alert alert-success">
        <i class="fa fa-check-circle"></i> {{ $_SESSION['success'] }}
    </div>
    @php unset($_SESSION['success']); @endphp
@endif

@if(isset($_SESSION['errors']))
    <div class="alert alert-danger">
        @foreach($_SESSION['errors'] as $error)
            <div>
                <i class="fa fa-exclamation-circle"></i> {{ $error }}
            </div>
        @endforeach
    </div>
    @php unset($_SESSION['errors']); @endphp
@endif

<div style="overflow-x: auto;">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 80px;">ID</th>
                <th>Khách hàng</th>
                <th style="width: 140px;">Tổng tiền</th>
                <th style="width: 140px;">Trạng thái</th>
                <th style="width: 180px;">Ngày đặt</th>
                <th style="width: 120px;">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @if (count($orders) > 0)
                @foreach ($orders as $order)
                    <tr>
                        <td class="text-center"><strong>#{{ $order->id }}</strong></td>
                        <td>
                            <strong>{{ $order->user_name ?? 'Khách vãng lai' }}</strong><br>
                            <small class="text-muted">{{ $order->user_email ?? '-' }}</small>
                        </td>
                        <td>{{ number_format($order->total ?? 0) }} đ</td>
                        <td>
                            @php
                                $status = $order->status ?? 'pending';
                                $statusMap = [
                                    'pending'    => ['label' => 'Chờ xác nhận', 'badge' => 'bg-warning text-dark'],
                                    'processing' => ['label' => 'Chuẩn bị hàng',  'badge' => 'bg-primary'],
                                    'shipping'   => ['label' => 'Đang giao',       'badge' => 'bg-info text-dark'],
                                    'completed'  => ['label' => 'Hoàn thành',      'badge' => 'bg-success'],
                                    'cancelled'  => ['label' => 'Đã hủy',          'badge' => 'bg-danger'],
                                ];
                                $cur = $statusMap[$status] ?? ['label' => $status, 'badge' => 'bg-secondary'];
                            @endphp
                            <form method="POST" action="{{ APP_URL }}/admin/orders/{{ $order->id }}/status" class="d-flex gap-1 align-items-center">
                                <input type="hidden" name="redirect" value="/admin/orders">
                                @if($status === 'cancelled')
                                    <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i>Đã hủy</span>
                                @else
                                <select name="status" class="form-select form-select-sm" style="min-width:140px" onchange="this.form.submit()">
                                    @foreach($statusMap as $val => $info)
                                    <option value="{{ $val }}" {{ $status === $val ? 'selected' : '' }}>{{ $info['label'] }}</option>
                                    @endforeach
                                </select>
                                @endif
                            </form>
                        </td>
                        <td><small class="text-muted">{{ date('d/m/Y H:i', strtotime($order->created_at ?? 'now')) }}</small></td>
                        <td>
                            <a href="{{ APP_URL }}/admin/orders/{{ $order->id }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-eye"></i> Xem
                            </a>
                            <form method="POST" action="{{ APP_URL }}/admin/orders/{{ $order->id }}/delete" style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn xóa đơn hàng #{{ $order->id }}?')">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i> Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="text-center" style="padding: 30px;">
                        <p style="color: #999; margin: 0;">
                            <i class="fa fa-inbox" style="font-size: 24px; margin-bottom: 10px; display: block;"></i>
                            Chưa có đơn hàng nào
                        </p>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

@endsection
