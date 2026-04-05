<div class="d-flex flex-column p-3 text-white bg-dark" style="min-height: 100vh; overflow-y: auto;">
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('admin/dashboard') }}" class="nav-link text-white {{ strpos($_SERVER['REQUEST_URI'], '/admin/dashboard') !== false || $_SERVER['REQUEST_URI'] === '/ASM2/admin/' ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin/products') }}" class="nav-link text-white {{ strpos($_SERVER['REQUEST_URI'], '/admin/products') !== false ? 'active' : '' }}">
                <i class="fas fa-box me-2"></i>Quản lý sản phẩm
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin/orders') }}" class="nav-link text-white {{ strpos($_SERVER['REQUEST_URI'], '/admin/orders') !== false ? 'active' : '' }}">
                <i class="fas fa-receipt me-2"></i>Quản lý đơn hàng
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin/users') }}" class="nav-link text-white {{ strpos($_SERVER['REQUEST_URI'], '/admin/users') !== false ? 'active' : '' }}">
                <i class="fas fa-users me-2"></i>Quản lý Users
            </a>
        </li>
        <li class="nav-item mt-3">
            <a href="{{ route('list') }}" class="nav-link text-white">
                <i class="fas fa-store me-2"></i>Xem cửa hàng
            </a>
        </li>
    </ul>
</div>
