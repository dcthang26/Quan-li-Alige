@extends('layouts.app')
@section('title', 'Danh sách sản phẩm')
@section('css')
<style>
:root {
    --blue-50:  #eff6ff;
    --blue-100: #dbeafe;
    --blue-200: #bfdbfe;
    --blue-500: #3b82f6;
    --blue-600: #2563eb;
    --blue-700: #1d4ed8;
    --blue-800: #1e40af;
    --bg:    #f0f6ff;
    --card:  #ffffff;
    --text:  #1e293b;
    --muted: #94a3b8;
    --border:#e2e8f0;
    --shadow: 0 4px 24px rgba(37,99,235,0.08);
}
body { background: var(--bg); }

/* ── Header ── */
.page-header {
    background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 55%, #3b82f6 100%);
    border-radius: 20px;
    padding: 26px 32px;
    margin-bottom: 26px;
    color: white;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 8px 32px rgba(29,78,216,0.28);
    animation: slideDown 0.5s ease;
}
.page-header h4 { margin:0; font-size:1.55rem; font-weight:800; letter-spacing:-0.5px; }
.page-header p  { margin:4px 0 0; opacity:.8; font-size:.88rem; }
.btn-add {
    background: white;
    color: var(--blue-700);
    border: none;
    padding: 10px 22px;
    border-radius: 12px;
    font-weight: 700;
    font-size: .88rem;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all .2s;
    box-shadow: 0 2px 10px rgba(0,0,0,.15);
    white-space: nowrap;
}
.btn-add:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(0,0,0,.2); color:var(--blue-800); }

/* ── Stats ── */
.stats-row {
    display: grid;
    grid-template-columns: repeat(4,1fr);
    gap: 16px;
    margin-bottom: 22px;
    animation: fadeUp .5s ease .08s both;
}
.stat-card {
    background: var(--card);
    border-radius: 16px;
    padding: 18px 22px;
    display: flex;
    align-items: center;
    gap: 14px;
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    transition: transform .2s, box-shadow .2s;
}
.stat-card:hover { transform:translateY(-3px); box-shadow:0 8px 28px rgba(37,99,235,.13); }
.stat-icon {
    width:50px; height:50px;
    border-radius:14px;
    display:flex; align-items:center; justify-content:center;
    font-size:1.3rem; flex-shrink:0;
}
.si-blue   { background:var(--blue-100); color:var(--blue-700); }
.si-green  { background:#d1fae5; color:#065f46; }
.si-orange { background:#ffedd5; color:#9a3412; }
.si-purple { background:#ede9fe; color:#6d28d9; }
.stat-label { font-size:.75rem; color:var(--muted); font-weight:500; }
.stat-value { font-size:1.55rem; font-weight:900; color:var(--text); line-height:1; }

/* ── Filter ── */
.filter-card {
    background: var(--card);
    border-radius: 16px;
    padding: 18px 24px;
    margin-bottom: 20px;
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    animation: fadeUp .5s ease .15s both;
}
.search-wrap { position:relative; }
.search-wrap .si {
    position:absolute; left:14px; top:50%; transform:translateY(-50%);
    color:var(--muted); font-size:.88rem; pointer-events:none;
}
.search-wrap input {
    padding-left:40px;
    border-radius:12px;
    border:1.5px solid var(--border);
    height:44px; font-size:.88rem; width:100%;
    transition:border-color .2s, box-shadow .2s;
    background:#f8fafc;
}
.search-wrap input:focus {
    border-color:var(--blue-500);
    box-shadow:0 0 0 3px rgba(59,130,246,.12);
    outline:none; background:white;
}
.filter-select {
    border-radius:12px;
    border:1.5px solid var(--border);
    height:44px; font-size:.88rem;
    padding:0 14px; width:100%;
    background:white; transition:border-color .2s;
}
.filter-select:focus { border-color:var(--blue-500); outline:none; box-shadow:0 0 0 3px rgba(59,130,246,.12); }
.btn-search {
    background:var(--blue-600); color:white; border:none;
    border-radius:12px; height:44px; padding:0 20px;
    font-weight:700; transition:all .2s; white-space:nowrap;
}
.btn-search:hover { background:var(--blue-700); transform:translateY(-1px); }
.btn-clear {
    background:#f1f5f9; color:var(--muted);
    border:1.5px solid var(--border); border-radius:12px;
    height:44px; padding:0 16px; transition:all .2s;
    text-decoration:none; display:flex; align-items:center; gap:6px;
    font-size:.85rem; font-weight:600;
}
.btn-clear:hover { background:#e2e8f0; color:var(--text); }

/* ── View toggle ── */
.view-toggle { display:flex; gap:6px; }
.vt-btn {
    width:36px; height:36px; border-radius:10px;
    border:1.5px solid var(--border); background:white;
    display:flex; align-items:center; justify-content:center;
    cursor:pointer; color:var(--muted); transition:all .2s;
    font-size:.9rem;
}
.vt-btn.active, .vt-btn:hover { background:var(--blue-600); color:white; border-color:var(--blue-600); }

/* ── Table view ── */
.table-card {
    background: var(--card);
    border-radius: 20px;
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    overflow: hidden;
    animation: fadeUp .5s ease .22s both;
}
.table-card table { margin:0; }
.table-card thead th {
    background: var(--blue-50);
    color: var(--blue-700);
    font-size:.72rem; font-weight:800;
    text-transform:uppercase; letter-spacing:.9px;
    padding:14px 18px;
    border-bottom:2px solid var(--blue-100);
    border-top:none;
}
.table-card tbody tr { transition:background .15s; animation:rowIn .4s ease both; }
.table-card tbody tr:hover { background:var(--blue-50); }
.table-card tbody td {
    padding:13px 18px;
    border-bottom:1px solid #f1f5f9;
    vertical-align:middle; font-size:.87rem;
}
.table-card tbody tr:last-child td { border-bottom:none; }

.prod-img {
    width:56px; height:56px; border-radius:12px;
    object-fit:cover; border:2px solid var(--blue-100);
    transition:transform .2s;
}
.prod-img:hover { transform:scale(1.08); }
.prod-name { font-weight:700; color:var(--text); font-size:.9rem; }
.prod-id   { font-size:.72rem; color:var(--muted); }

.price-tag {
    font-weight:800; color:var(--blue-700); font-size:.92rem;
    background:var(--blue-50); padding:4px 10px;
    border-radius:8px; white-space:nowrap;
}

.qty-badge {
    display:inline-flex; align-items:center; gap:5px;
    padding:4px 10px; border-radius:8px;
    font-size:.78rem; font-weight:700;
}
.qty-ok   { background:#d1fae5; color:#065f46; }
.qty-low  { background:#fef3c7; color:#92400e; }
.qty-zero { background:#fee2e2; color:#991b1b; }

.tag {
    display:inline-block;
    padding:3px 9px; border-radius:6px;
    font-size:.72rem; font-weight:700;
    margin:2px;
}
.tag-size  { background:var(--blue-100); color:var(--blue-800); }
.tag-color { background:#e0e7ff; color:#3730a3; }
.tag-sole  { background:#fef3c7; color:#92400e; }

.desc-cell {
    max-width:180px;
    white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
    color:var(--muted); font-size:.8rem;
}

.action-btn {
    width:32px; height:32px; border-radius:9px; border:none;
    display:inline-flex; align-items:center; justify-content:center;
    font-size:.82rem; transition:all .2s;
    text-decoration:none; cursor:pointer;
}
.ab-view   { background:var(--blue-100); color:var(--blue-700); }
.ab-view:hover   { background:var(--blue-700); color:white; transform:scale(1.1); }
.ab-edit   { background:#d1fae5; color:#065f46; }
.ab-edit:hover   { background:#059669; color:white; transform:scale(1.1); }
.ab-delete { background:#fee2e2; color:#dc2626; }
.ab-delete:hover { background:#dc2626; color:white; transform:scale(1.1); }

/* ── Grid view ── */
.grid-view {
    display:grid;
    grid-template-columns:repeat(auto-fill, minmax(230px,1fr));
    gap:18px;
    animation: fadeUp .5s ease .22s both;
}
.prod-card {
    background:var(--card);
    border-radius:18px;
    border:1px solid var(--border);
    box-shadow:var(--shadow);
    overflow:hidden;
    transition:transform .2s, box-shadow .2s;
    animation:cardIn .4s ease both;
}
.prod-card:hover { transform:translateY(-5px); box-shadow:0 12px 36px rgba(37,99,235,.15); }
.prod-card-img {
    width:100%; height:180px; object-fit:cover;
    border-bottom:1px solid var(--border);
    transition:transform .3s;
}
.prod-card:hover .prod-card-img { transform:scale(1.04); }
.prod-card-img-wrap { overflow:hidden; position:relative; }
.prod-card-badge {
    position:absolute; top:10px; right:10px;
    background:var(--blue-600); color:white;
    font-size:.7rem; font-weight:700;
    padding:3px 9px; border-radius:20px;
}
.prod-card-body { padding:14px 16px; }
.prod-card-name { font-weight:700; font-size:.92rem; color:var(--text); margin-bottom:6px;
    white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.prod-card-price { font-weight:900; color:var(--blue-700); font-size:1rem; margin-bottom:8px; }
.prod-card-meta { display:flex; justify-content:space-between; align-items:center; margin-bottom:10px; }
.prod-card-actions { display:flex; gap:8px; }
.prod-card-actions .action-btn { flex:1; border-radius:10px; height:34px; }

/* ── Empty ── */
.empty-state { text-align:center; padding:60px 20px; color:var(--muted); }
.empty-state i { font-size:3rem; margin-bottom:12px; opacity:.35; display:block; color:var(--blue-400); }

/* ── Footer ── */
.table-footer {
    padding:14px 24px;
    border-top:1px solid var(--border);
    background:var(--blue-50);
    font-size:.82rem; color:var(--muted);
    display:flex; align-items:center; justify-content:space-between;
}

@keyframes slideDown { from{opacity:0;transform:translateY(-20px)} to{opacity:1;transform:translateY(0)} }
@keyframes fadeUp    { from{opacity:0;transform:translateY(16px)}  to{opacity:1;transform:translateY(0)} }
@keyframes rowIn     { from{opacity:0;transform:translateX(-10px)} to{opacity:1;transform:translateX(0)} }
@keyframes cardIn    { from{opacity:0;transform:scale(.95)}        to{opacity:1;transform:scale(1)} }
</style>
@endsection
@section('content')

@php
    $totalProducts = count($products);
    $totalQty      = array_sum(array_column($products, 'quantity'));
    $maxPrice      = $products ? max(array_column($products, 'price')) : 0;
    $lowStock      = count(array_filter($products, fn($p) => ($p->quantity ?? 0) <= 5));
@endphp

{{-- Header --}}
<div class="page-header">
    <div>
        <h4><i class="fas fa-box-open me-2"></i>Danh sách sản phẩm</h4>
        <p>Quản lý toàn bộ sản phẩm trong cửa hàng</p>
    </div>
    <a href="{{ APP_URL }}/admin/products/add" class="btn-add">
        <i class="fas fa-plus"></i> Thêm sản phẩm
    </a>
</div>

{{-- Stats --}}
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon si-blue"><i class="fas fa-boxes"></i></div>
        <div>
            <div class="stat-label">Tổng sản phẩm</div>
            <div class="stat-value">{{ $totalProducts }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon si-green"><i class="fas fa-cubes"></i></div>
        <div>
            <div class="stat-label">Tổng tồn kho</div>
            <div class="stat-value">{{ number_format($totalQty) }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon si-orange"><i class="fas fa-exclamation-triangle"></i></div>
        <div>
            <div class="stat-label">Sắp hết hàng</div>
            <div class="stat-value">{{ $lowStock }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon si-purple"><i class="fas fa-tag"></i></div>
        <div>
            <div class="stat-label">Giá cao nhất</div>
            <div class="stat-value" style="font-size:1.1rem">{{ number_format($maxPrice) }}đ</div>
        </div>
    </div>
</div>

{{-- Filter --}}
<div class="filter-card">
    <form method="GET" action="{{ APP_URL }}/admin/products">
        <div class="d-flex gap-3 align-items-center flex-wrap">
            <div class="search-wrap flex-grow-1" style="min-width:200px">
                <i class="fas fa-search si"></i>
                <input type="text" name="q" placeholder="Tìm theo tên sản phẩm..." value="{{ $keyword ?? '' }}">
            </div>
            <select name="size" class="filter-select" style="width:160px" onchange="this.form.submit()">
                <option value="">Tất cả Size</option>
                @foreach($allSizes as $s)
                <option value="{{ $s }}" {{ ($filterSize ?? '') === $s ? 'selected' : '' }}>Size {{ $s }}</option>
                @endforeach
            </select>
            <select name="sole" class="filter-select" style="width:160px" onchange="this.form.submit()">
                <option value="">Tất cả Đế</option>
                @foreach($allSoles as $s)
                <option value="{{ $s }}" {{ ($filterSole ?? '') === $s ? 'selected' : '' }}>Đế {{ $s }}</option>
                @endforeach
            </select>
            <button class="btn-search" type="submit"><i class="fas fa-search me-1"></i>Tìm</button>
            @if(!empty($keyword) || !empty($filterSize) || !empty($filterSole))
            <a href="{{ APP_URL }}/admin/products" class="btn-clear"><i class="fas fa-times"></i>Xóa lọc</a>
            @endif
            <div class="view-toggle ms-auto">
                <button type="button" class="vt-btn active" id="btnTable" onclick="switchView('table')" title="Dạng bảng"><i class="fas fa-list"></i></button>
                <button type="button" class="vt-btn" id="btnGrid" onclick="switchView('grid')" title="Dạng lưới"><i class="fas fa-th"></i></button>
            </div>
        </div>
    </form>
    @if(!empty($keyword) || !empty($filterSize) || !empty($filterSole))
    <div class="mt-2" style="font-size:.82rem;color:var(--muted)">
        Tìm thấy <strong style="color:var(--text)">{{ count($products) }}</strong> sản phẩm
        @if(!empty($keyword)) &mdash; tên: <strong>"{{ $keyword }}"</strong>@endif
        @if(!empty($filterSize)) &mdash; size: <strong>{{ $filterSize }}</strong>@endif
        @if(!empty($filterSole)) &mdash; đế: <strong>{{ $filterSole }}</strong>@endif
    </div>
    @endif
</div>

{{-- TABLE VIEW --}}
<div id="viewTable">
    <div class="table-card">
        <table class="table">
            <thead>
                <tr>
                    <th style="width:50px">#</th>
                    <th style="width:70px">Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th style="width:130px">Giá</th>
                    <th style="width:100px">Tồn kho</th>
                    <th>Size</th>
                    <th>Màu sắc</th>
                    <th>Đế</th>
                    <th style="width:180px">Mô tả</th>
                    <th style="width:110px;text-align:center">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @if(count($products) > 0)
                    @foreach($products as $i => $item)
                    @php
                        $qty = $item->quantity ?? 0;
                        $qtyClass = $qty == 0 ? 'qty-zero' : ($qty <= 5 ? 'qty-low' : 'qty-ok');
                        $qtyIcon  = $qty == 0 ? 'fa-times-circle' : ($qty <= 5 ? 'fa-exclamation-circle' : 'fa-check-circle');
                    @endphp
                    <tr style="animation-delay:{{ $i * 0.04 }}s">
                        <td><span style="font-weight:700;color:var(--muted);font-size:.8rem">{{ $i + 1 }}</span></td>
                        <td>
                            @if(!empty($item->image))
                            <img src="{{ APP_URL }}{{ $item->image }}" class="prod-img" alt="{{ $item->name }}">
                            @else
                            <div style="width:56px;height:56px;border-radius:12px;background:var(--blue-100);display:flex;align-items:center;justify-content:center;color:var(--blue-400)">
                                <i class="fas fa-image"></i>
                            </div>
                            @endif
                        </td>
                        <td>
                            <div class="prod-name">{{ $item->name }}</div>
                            <div class="prod-id">ID: #{{ $item->id }}</div>
                        </td>
                        <td><span class="price-tag">{{ number_format($item->price) }}đ</span></td>
                        <td>
                            <span class="qty-badge {{ $qtyClass }}">
                                <i class="fas {{ $qtyIcon }}"></i>{{ $qty }}
                            </span>
                        </td>
                        <td>
                            @if(!empty($item->sizes))
                                @foreach(array_slice(explode(',', $item->sizes), 0, 4) as $s)
                                <span class="tag tag-size">{{ trim($s) }}</span>
                                @endforeach
                                @if(count(explode(',', $item->sizes)) > 4)
                                <span class="tag tag-size">+{{ count(explode(',', $item->sizes)) - 4 }}</span>
                                @endif
                            @else<span style="color:var(--muted);font-size:.8rem">—</span>@endif
                        </td>
                        <td>
                            @if(!empty($item->colors))
                                @foreach(array_slice(explode(',', $item->colors), 0, 3) as $c)
                                <span class="tag tag-color">{{ trim($c) }}</span>
                                @endforeach
                                @if(count(explode(',', $item->colors)) > 3)
                                <span class="tag tag-color">+{{ count(explode(',', $item->colors)) - 3 }}</span>
                                @endif
                            @else<span style="color:var(--muted);font-size:.8rem">—</span>@endif
                        </td>
                        <td>
                            @if(!empty($item->sole))
                                @foreach(explode(',', $item->sole) as $s)
                                <span class="tag tag-sole">{{ trim($s) }}</span>
                                @endforeach
                            @else<span style="color:var(--muted);font-size:.8rem">—</span>@endif
                        </td>
                        <td><div class="desc-cell" title="{{ $item->description }}">{{ $item->description }}</div></td>
                        <td>
                            <div class="d-flex gap-1 justify-content-center">
                                <a href="{{ APP_URL }}/admin/products/show/{{ $item->id }}" class="action-btn ab-view" title="Xem"><i class="fas fa-eye"></i></a>
                                <a href="{{ APP_URL }}/admin/products/edit/{{ $item->id }}" class="action-btn ab-edit" title="Sửa"><i class="fas fa-pen"></i></a>
                                <form action="{{ APP_URL }}/admin/products/delete/{{ $item->id }}" method="POST" style="display:inline">
                                    <button type="submit" class="action-btn ab-delete" title="Xóa"
                                        onclick="return confirm('Xóa sản phẩm {{ $item->name }}?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @else
                <tr><td colspan="10">
                    <div class="empty-state">
                        <i class="fas fa-box-open"></i>
                        <div style="font-size:1rem;font-weight:700;color:var(--text)">Không tìm thấy sản phẩm nào</div>
                        <div style="font-size:.85rem;margin-top:4px">Thử thay đổi bộ lọc hoặc thêm sản phẩm mới</div>
                    </div>
                </td></tr>
                @endif
            </tbody>
        </table>
        <div class="table-footer">
            <span>Hiển thị <strong>{{ count($products) }}</strong> sản phẩm</span>
            <span>Tổng tồn kho: <strong>{{ number_format($totalQty) }}</strong> sản phẩm</span>
        </div>
    </div>
</div>

{{-- GRID VIEW --}}
<div id="viewGrid" style="display:none">
    @if(count($products) > 0)
    <div class="grid-view">
        @foreach($products as $i => $item)
        @php
            $qty = $item->quantity ?? 0;
            $qtyClass = $qty == 0 ? 'qty-zero' : ($qty <= 5 ? 'qty-low' : 'qty-ok');
        @endphp
        <div class="prod-card" style="animation-delay:{{ $i * 0.05 }}s">
            <div class="prod-card-img-wrap">
                @if(!empty($item->image))
                <img src="{{ APP_URL }}{{ $item->image }}" class="prod-card-img" alt="{{ $item->name }}">
                @else
                <div style="width:100%;height:180px;background:var(--blue-50);display:flex;align-items:center;justify-content:center;color:var(--blue-300)">
                    <i class="fas fa-image fa-3x"></i>
                </div>
                @endif
                <span class="prod-card-badge">#{{ $i + 1 }}</span>
            </div>
            <div class="prod-card-body">
                <div class="prod-card-name" title="{{ $item->name }}">{{ $item->name }}</div>
                <div class="prod-card-price">{{ number_format($item->price) }}đ</div>
                <div class="prod-card-meta">
                    <span class="qty-badge {{ $qtyClass }}" style="font-size:.72rem">
                        <i class="fas fa-cubes"></i>{{ $qty }} cái
                    </span>
                    @if(!empty($item->sizes))
                    <span style="font-size:.72rem;color:var(--muted)">
                        {{ count(explode(',', $item->sizes)) }} size
                    </span>
                    @endif
                </div>
                <div class="prod-card-actions">
                    <a href="{{ APP_URL }}/admin/products/show/{{ $item->id }}" class="action-btn ab-view" title="Xem"><i class="fas fa-eye"></i></a>
                    <a href="{{ APP_URL }}/admin/products/edit/{{ $item->id }}" class="action-btn ab-edit" title="Sửa"><i class="fas fa-pen"></i></a>
                    <form action="{{ APP_URL }}/admin/products/delete/{{ $item->id }}" method="POST" style="display:contents">
                        <button type="submit" class="action-btn ab-delete" title="Xóa"
                            onclick="return confirm('Xóa sản phẩm {{ $item->name }}?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="table-card">
        <div class="empty-state">
            <i class="fas fa-box-open"></i>
            <div style="font-size:1rem;font-weight:700;color:var(--text)">Không tìm thấy sản phẩm nào</div>
        </div>
    </div>
    @endif
</div>

@endsection
@section('js')
<script>
function switchView(v) {
    const isTable = v === 'table';
    document.getElementById('viewTable').style.display = isTable ? '' : 'none';
    document.getElementById('viewGrid').style.display  = isTable ? 'none' : '';
    document.getElementById('btnTable').classList.toggle('active', isTable);
    document.getElementById('btnGrid').classList.toggle('active', !isTable);
    localStorage.setItem('prodView', v);
}
// Khôi phục view đã chọn
const saved = localStorage.getItem('prodView');
if (saved === 'grid') switchView('grid');
</script>
@endsection
