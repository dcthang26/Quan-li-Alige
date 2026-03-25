<nav class="navbar navbar-dark bg-dark sticky-top flex-md-nowrap p-2 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="{{ APP_URL }}/admin/products">Admin Panel</a>
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            @if(isset($_SESSION['user']))
                <span class="text-light me-3">{{ $_SESSION['user']->name }}</span>
                <a class="nav-link" href="{{ APP_URL }}/logout" style="display: inline-block;">Đăng xuất</a>
            @else
                <a class="nav-link" href="{{ APP_URL }}/login">Đăng nhập</a>
            @endif
        </li>
    </ul>
</nav>
