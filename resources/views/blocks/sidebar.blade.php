<div class="d-flex flex-column p-3 text-white bg-dark" style="min-height: 100vh; overflow-y: auto;">
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('admin/products') }}" class="nav-link text-white">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin/products') }}" class="nav-link text-white">
                <i class="fas fa-box"></i> Quản lý sản phẩm
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin/orders') }}" class="nav-link text-white">
                <i class="fas fa-receipt"></i> Quản lý đơn hàng
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin/users') }}" class="nav-link text-white">
                <i class="fas fa-users"></i> Quản lý Users
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('list') }}" class="nav-link text-white">
                <i class="fas fa-store"></i> Danh sách sản phẩm
            </a>
        </li>
    </ul>
</div>
