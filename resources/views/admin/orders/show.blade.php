@extends('layouts.app')
@section('title', 'Chi tiết Đơn hàng')
@section('css')
<style>
:root {
    --primary: #6366f1;
    --bg: #f1f5f9;
    --card: #ffffff;
    --text: #1e293b;
    --muted: #94a3b8;
    --border: #e2e8f0;
    --shadow: 0 4px 24px rgba(99,102,241,0.08);
}
body { background: var(--bg); }

.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 9px 18px;
    border-radius: 12px;
    border: 1.5px solid var(--border);
    background: white;
    color: var(--muted);
    font-size: 0.85rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
    margin-bottom: 24px;
    animation: fadeUp 0.4s ease;
}
.back-btn:hover { background: #f1f5f9; color: var(--text); border-color: #cbd5e1; }

.order-hero {
    background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 60%, #3b82f6 100%);
    border-radius: 20px;
    padding: 28px 32px;
    color: white;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 20px;
    box-shadow: 0 8px 32px rgba(29,78,216,0.25);
    animation: slideDown 0.5s ease;
}
.order-hero-id {
    font-size: 2.2rem;
    font-weight: 900;
    letter-spacing: -1px;
    line-height: 1;
}
.order-hero-sub { opacity: 0.65; font-size: 0.85rem; margin-top: 4px; }
.order-hero-price {
    text-align: right;
}
.order-hero-price .amount {
    font-size: 2rem;
    font-weight: 900;
    color: #34d399;
    line-height: 1;
}
.order-hero-price .label { opacity: 0.65; font-size: 0.82rem; margin-top: 4px; }

.timeline {
    display: flex;
    align-items: center;
    gap: 0;
    margin-bottom: 28px;
    background: var(--card);
    border-radius: 16px;
    padding: 20px 24px;
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    overflow-x: auto;
    animation: fadeUp 0.5s ease 0.1s both;
}
.timeline-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    flex: 1;
    min-width: 80px;
    position: relative;
}
.timeline-step:not(:last-child)::after {
    content: '';
    position: absolute;
    top: 20px;
    left: 50%;
    width: 100%;
    height: 2px;
    background: var(--border);
    z-index: 0;
}
.timeline-step.done:not(:last-child)::after { background: #10b981; }
.timeline-step.active:not(:last-child)::after { background: linear-gradient(90deg, #10b981, var(--border)); }

.step-circle {
    width: 40px; height: 40px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.9rem;
    border: 2px solid var(--border);
    background: white;
    color: var(--muted);
    position: relative;
    z-index: 1;
    transition: all 0.3s;
}
.timeline-step.done .step-circle   { background: #10b981; border-color: #10b981; color: white; }
.timeline-step.active .step-circle { background: var(--primary); border-color: var(--primary); color: white; box-shadow: 0 0 0 4px rgba(99,102,241,0.2); }
.timeline-step.cancelled .step-circle { background: #ef4444; border-color: #ef4444; color: white; }
.step-label { font-size: 0.7rem; font-weight: 600; color: var(--muted); margin-top: 8px; text-align: center; }
.timeline-step.done .step-label   { color: #059669; }
.timeline-step.active .step-label { color: var(--primary); font-weight: 700; }
.timeline-step.cancelled .step-label { color: #dc2626; }

.grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
    animation: fadeUp 0.5s ease 0.2s both;
}
@media(max-width:768px) { .grid-2 { grid-template-columns: 1fr; } }

.info-card {
    background: var(--card);
    border-radius: 16px;
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    overflow: hidden;
}
.info-card-header {
    padding: 14px 20px;
    border-bottom: 1px solid var(--border);
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: var(--muted);
    background: #f8fafc;
    display: flex;
    align-items: center;
    gap: 8px;
}
.info-card-body { padding: 20px; }
.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #f8fafc;
    font-size: 0.88rem;
}
.info-row:last-child { border-bottom: none; padding-bottom: 0; }
.info-row .key { color: var(--muted); font-weight: 500; }
.info-row .val { font-weight: 600; color: var(--text); text-align: right; }

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.78rem;
    font-weight: 700;
}
.status-pending    { background: #fef3c7; color: #92400e; }
.status-processing { background: #dbeafe; color: #1e40af; }
.status-shipping   { background: #cffafe; color: #155e75; }
.status-completed  { background: #d1fae5; color: #065f46; }
.status-cancelled  { background: #fee2e2; color: #991b1b; }

.update-card {
    background: var(--card);
    border-radius: 16px;
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    overflow: hidden;
    animation: fadeUp 0.5s ease 0.3s both;
}
.update-card-header {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    padding: 16px 24px;
    color: white;
    font-weight: 700;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 8px;
}
.update-card-body { padding: 24px; }

.status-options {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    margin-bottom: 20px;
}
.status-opt { display: none; }
.status-opt-label {
    border: 2px solid var(--border);
    border-radius: 12px;
    padding: 12px 14px;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f8fafc;
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--muted);
}
.status-opt-label:hover { border-color: #cbd5e1; background: white; color: var(--text); }
.status-opt:checked + .status-opt-label {
    border-color: var(--primary);
    background: #ede9fe;
    color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
}
.status-dot {
    width: 10px; height: 10px;
    border-radius: 50%;
    flex-shrink: 0;
}

.btn-save {
    width: 100%;
    padding: 13px;
    border-radius: 12px;
    border: none;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: white;
    font-weight: 700;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.2s;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    box-shadow: 0 4px 14px rgba(99,102,241,0.35);
}
.btn-save:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(99,102,241,0.45); }

.cancelled-notice {
    background: #fef2f2;
    border: 1.5px solid #fecaca;
    border-radius: 12px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    color: #dc2626;
    font-weight: 600;
    font-size: 0.88rem;
}
.cancelled-notice i { font-size: 1.3rem; flex-shrink: 0; }

@keyframes slideDown { from { opacity:0; transform:translateY(-20px); } to { opacity:1; transform:translateY(0); } }
@keyframes fadeUp    { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
</style>
@endsection
@section('content')

@php
$statusMap = [
    'pending'    => ['label'=>'Chờ xác nhận', 'class'=>'status-pending',    'icon'=>'fa-clock',        'dot'=>'#f59e0b', 'order'=>0],
    'processing' => ['label'=>'Chuẩn bị hàng','class'=>'status-processing', 'icon'=>'fa-box',          'dot'=>'#3b82f6', 'order'=>1],
    'shipping'   => ['label'=>'Đang giao',     'class'=>'status-shipping',   'icon'=>'fa-truck',        'dot'=>'#06b6d4', 'order'=>2],
    'completed'  => ['label'=>'Hoàn thành',    'class'=>'status-completed',  'icon'=>'fa-check-circle', 'dot'=>'#10b981', 'order'=>3],
    'cancelled'  => ['label'=>'Đã hủy',        'class'=>'status-cancelled',  'icon'=>'fa-times-circle', 'dot'=>'#ef4444', 'order'=>-1],
];
$cur = $statusMap[$order->status] ?? $statusMap['pending'];
$curOrder = $cur['order'];
@endphp

<a href="{{ APP_URL }}/admin/orders" class="back-btn">
    <i class="fas fa-arrow-left"></i> Quay lại danh sách
</a>

{{-- Hero --}}
<div class="order-hero">
    <div>
        <div class="order-hero-id">Đơn #{{ $order->id }}</div>
        <div class="order-hero-sub">
            <i class="fas fa-calendar me-1"></i>{{ date('d/m/Y H:i', strtotime($order->created_at ?? 'now')) }}
        </div>
        <div style="margin-top:10px">
            <span class="status-badge {{ $cur['class'] }}">
                <i class="fas {{ $cur['icon'] }}"></i>{{ $cur['label'] }}
            </span>
        </div>
    </div>
    <div class="order-hero-price">
        <div class="amount">{{ number_format($order->total ?? 0) }}đ</div>
        <div class="label">Tổng giá trị đơn hàng</div>
    </div>
</div>

{{-- Timeline --}}
@if($order->status !== 'cancelled')
<div class="timeline">
    @foreach(['pending','processing','shipping','completed'] as $step)
    @php
        $stepInfo = $statusMap[$step];
        $stepOrder = $stepInfo['order'];
        $cls = $stepOrder < $curOrder ? 'done' : ($stepOrder == $curOrder ? 'active' : '');
    @endphp
    <div class="timeline-step {{ $cls }}">
        <div class="step-circle"><i class="fas {{ $stepInfo['icon'] }}"></i></div>
        <div class="step-label">{{ $stepInfo['label'] }}</div>
    </div>
    @endforeach
</div>
@else
<div style="animation: fadeUp 0.5s ease 0.1s both; margin-bottom:24px">
    <div class="cancelled-notice">
        <i class="fas fa-ban"></i>
        <div>
            <div>Đơn hàng này đã bị hủy</div>
            <div style="font-size:0.78rem;font-weight:400;margin-top:2px;opacity:0.8">Không thể thay đổi trạng thái của đơn hàng đã hủy</div>
        </div>
    </div>
</div>
@endif

{{-- Info Grid --}}
<div class="grid-2">
    <div class="info-card">
        <div class="info-card-header"><i class="fas fa-user"></i> Thông tin khách hàng</div>
        <div class="info-card-body">
            <div class="info-row">
                <span class="key">Tên khách hàng</span>
                <span class="val">{{ $order->user_name ?? 'Khách vãng lai' }}</span>
            </div>
            <div class="info-row">
                <span class="key">Email</span>
                <span class="val" style="font-size:0.82rem">{{ $order->user_email ?? '—' }}</span>
            </div>
        </div>
    </div>

    <div class="info-card">
        <div class="info-card-header"><i class="fas fa-receipt"></i> Thông tin đơn hàng</div>
        <div class="info-card-body">
            <div class="info-row">
                <span class="key">Mã đơn hàng</span>
                <span class="val">#{{ $order->id }}</span>
            </div>
            <div class="info-row">
                <span class="key">Ngày đặt</span>
                <span class="val">{{ date('d/m/Y H:i', strtotime($order->created_at ?? 'now')) }}</span>
            </div>
            <div class="info-row">
                <span class="key">Tổng tiền</span>
                <span class="val" style="color:#059669;font-size:1rem">{{ number_format($order->total ?? 0) }}đ</span>
            </div>
            <div class="info-row">
                <span class="key">Trạng thái</span>
                <span class="val">
                    <span class="status-badge {{ $cur['class'] }}">
                        <i class="fas {{ $cur['icon'] }}"></i>{{ $cur['label'] }}
                    </span>
                </span>
            </div>
        </div>
    </div>
</div>

{{-- Update Status --}}
@if($order->status !== 'cancelled')
<div class="update-card">
    <div class="update-card-header">
        <i class="fas fa-edit"></i> Cập nhật trạng thái đơn hàng
    </div>
    <div class="update-card-body">
        <form method="POST" action="{{ APP_URL }}/admin/orders/{{ $order->id }}/status">
            <input type="hidden" name="redirect" value="/admin/orders/{{ $order->id }}">
            <div class="status-options">
                @foreach($statusMap as $val => $info)
                <div>
                    <input type="radio" name="status" id="s_{{ $val }}" value="{{ $val }}" class="status-opt"
                        {{ $order->status === $val ? 'checked' : '' }}>
                    <label for="s_{{ $val }}" class="status-opt-label">
                        <div class="status-dot" style="background:{{ $info['dot'] }}"></div>
                        <i class="fas {{ $info['icon'] }}"></i>
                        {{ $info['label'] }}
                    </label>
                </div>
                @endforeach
            </div>
            <button type="submit" class="btn-save">
                <i class="fas fa-save"></i> Lưu trạng thái
            </button>
        </form>
    </div>
</div>
@endif

@endsection
