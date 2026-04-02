<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


    @yield('css') <!-- Thêm CSS riêng nếu cần -->
</head>

<body class="d-flex flex-column" style="min-height:100vh">

    <!-- Header -->
    @include('blocks.header')

    <div class="container-fluid flex-grow-1 d-flex p-0">
        <div class="row g-0 w-100">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block bg-dark sidebar">
                @include('blocks.sidebar')
            </div>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-3">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Footer -->
    @include('blocks.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @if(isset($_SESSION['success']) || isset($_SESSION['errors']) || isset($_SESSION['error']))
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index:9999">
        @if(isset($_SESSION['success']))
        <div class="toast align-items-center text-bg-success border-0 show mb-2" role="alert">
            <div class="d-flex">
                <div class="toast-body"><i class="fas fa-check-circle me-2"></i>{{ $_SESSION['success'] }}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        @php unset($_SESSION['success']); @endphp
        @endif
        @if(isset($_SESSION['error']))
        <div class="toast align-items-center text-bg-danger border-0 show mb-2" role="alert">
            <div class="d-flex">
                <div class="toast-body"><i class="fas fa-exclamation-circle me-2"></i>{{ $_SESSION['error'] }}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        @php unset($_SESSION['error']); @endphp
        @endif
        @if(isset($_SESSION['errors']))
        <div class="toast align-items-center text-bg-danger border-0 show mb-2" role="alert">
            <div class="d-flex">
                <div class="toast-body"><i class="fas fa-exclamation-circle me-2"></i>
                    @foreach($_SESSION['errors'] as $err){{ $err }}<br>@endforeach
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        @php unset($_SESSION['errors']); @endphp
        @endif
    </div>
    @endif

    @yield('js') <!-- Thêm JavaScript riêng nếu cần -->
</body>

</html>
