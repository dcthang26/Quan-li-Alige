@extends('layouts.app')
@section('title', 'Edit sản phẩm')
@section('content')
<h1>Edit sản phẩm</h1>

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
    <button type="submit" name="submit" class="btn btn-primary">Cập nhật ảnh</button>
</form>

<div id="saveStatus" class="mt-3" style="display:none"></div>

<script>
(function () {
    const AUTOSAVE_URL = '{{ APP_URL }}admin/products/autosave/{{ $productCurrent->id }}';
    const status = document.getElementById('saveStatus');
    let timer = null;

    function showStatus(msg, type) {
        status.innerHTML = '<div class="alert alert-' + type + ' py-2 px-3 mb-0 d-inline-flex align-items-center gap-2"><i class="fas ' + (type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle') + '"></i>' + msg + '</div>';
        status.style.display = 'block';
        if (type === 'success') setTimeout(() => status.style.display = 'none', 2500);
    }

    function autoSave() {
        const fields = ['name','price','quantity','description','sizes','colors','sole'];
        const data = {};
        fields.forEach(f => {
            const el = document.querySelector('[name=' + f + ']');
            if (el) data[f] = el.value;
        });

        showStatus('<span class="spinner-border spinner-border-sm"></span> Đang lưu...', 'info');

        fetch(AUTOSAVE_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(r => r.json())
        .then(res => showStatus(res.success ? '✓ Đã lưu tự động' : '✗ ' + res.message, res.success ? 'success' : 'danger'))
        .catch(() => showStatus('✗ Lỗi kết nối', 'danger'));
    }

    const inputs = document.querySelectorAll('input:not([type=file]), textarea');
    inputs.forEach(el => {
        el.addEventListener('input', () => {
            clearTimeout(timer);
            showStatus('...', 'secondary');
            timer = setTimeout(autoSave, 1000);
        });
    });
})();
</script>
@endsection