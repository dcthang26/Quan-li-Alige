@extends('client.layout.app')
@section('title', 'Trang chủ')
@section('content')



    <div id="homeCarousel" class="carousel slide mb-5" data-bs-ride="carousel" data-bs-interval="2000">
        <div class="carousel-inner rounded-4 overflow-hidden">


            <div class="carousel-item active position-relative">
                <img src="{{ APP_URL }}images/slide1.jpg" class="d-block w-100" style="height:400px; object-fit:cover;">
                <div class="carousel-caption d-flex flex-column justify-content-center h-100">
                    <h1 class="fw-bold" style="color: #fff;text-shadow: 0 2px 6px rgba(0,0,0,0.6);">
                        Chào mừng đến với
                        <span style="color: #fff;text-shadow: 0 2px 6px rgba(0,0,0,0.6)">Shop</span>
                    </h1>
                    <p style="color:#fff; text-shadow: 0 2px 6px rgba(0,0,0,0.7);">
                        Khám phá hàng ngàn sản phẩm chất lượng
                    </p>
                    <a href="<?= APP_URL ?>list" class="btn btn-light mt-2" style="color:#000; font-weight:bold;
                                      text-shadow: 0 1px 0 #fff, 0 2px 5px rgba(0,0,0,0.6);">
                        Mua sắm ngay
                    </a>
                </div>
            </div>


            <div class="carousel-item position-relative">
                <img src="{{ APP_URL }}images/slide2.jpg" class="d-block w-100" style="height:400px; object-fit:cover;">

                <div class="carousel-caption d-flex flex-column justify-content-center h-100">
                    <h1 class="fw-bold" style="color:#fff; text-shadow: 0 3px 8px rgba(0,0,0,0.8);">
                        Giảm giá cực sốc
                    </h1>

                    <p style="color:#fff; text-shadow: 0 2px 6px rgba(0,0,0,0.7);">
                        Ưu đãi lên đến 50%
                    </p>

                    <a href="{{ APP_URL }}list" class="btn btn-warning mt-2 fw-semibold"
                        style="color:#000; text-shadow: 0 1px 3px rgba(0,0,0,0.4);">
                        Xem ngay
                    </a>
                </div>
            </div>


            <div class="carousel-item position-relative">
                <img src="{{ APP_URL }}images/slide3.jpg" class="d-block w-100" style="height:400px; object-fit:cover;">

                <div class="carousel-caption d-flex flex-column justify-content-center h-100">
                    <h1 class="fw-bold" style="color:#fff; text-shadow: 0 3px 8px rgba(0,0,0,0.8);">
                        Sản phẩm chất lượng
                    </h1>

                    <p style="color:#fff; text-shadow: 0 2px 6px rgba(0,0,0,0.7);">
                        Bảo hành chính hãng
                    </p>

                    @if(!isset($_SESSION['user']))
                        <a href="{{ APP_URL }}/register" class="btn btn-outline-light mt-2 fw-semibold"
                            style="color:#fff; text-shadow: 0 1px 3px rgba(0,0,0,0.6);">
                            Đăng ký
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="text-center p-4 rounded-4 h-100 stat-box">
                    <i class="fas fa-shipping-fast fa-2x mb-3" style="color:#1565C0"></i>
                    <h5 class="fw-bold">Giao hàng nhanh</h5>
                    <p class="text-muted mb-0">Giao hàng toàn quốc trong 2–3 ngày làm việc</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center p-4 rounded-4 h-100 stat-box">
                    <i class="fas fa-shield-alt fa-2x mb-3" style="color:#1565C0"></i>
                    <h5 class="fw-bold">Bảo hành chính hãng</h5>
                    <p class="text-muted mb-0">Tất cả sản phẩm đều có bảo hành từ nhà sản xuất</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center p-4 rounded-4 h-100 stat-box">
                    <i class="fas fa-undo fa-2x mb-3" style="color:#1565C0"></i>
                    <h5 class="fw-bold">Đổi trả dễ dàng</h5>
                    <p class="text-muted mb-0">Hoàn tiền 100% nếu sản phẩm không đúng mô tả</p>
                </div>
            </div>
        </div>

        <h4 class="fw-bold mb-4"><i class="fas fa-fire text-danger me-2"></i>Sản phẩm nổi bật</h4>
        <div class="row g-3">
            @foreach(array_slice($data, 0, 4) as $item)
                <div class="col-6 col-md-3">
                    <div class="card product-card shadow-sm">
                        @if($item->image)
                            <img src="{{ APP_URL }}{{ $item->image }}" class="product-image" alt="{{ $item->name }}">
                        @else
                            <div class="product-image bg-light d-flex align-items-center justify-content-center">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h6 class="card-title text-truncate">{{ $item->name }}</h6>
                            <div class="product-price mb-2">{{ number_format($item->price) }}đ</div>
                            <a href="{{ APP_URL }}/user/product/{{ $item->id }}" class="btn btn-primary btn-sm w-100">
                                <i class="fas fa-eye me-1"></i>Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-4">
            <a href="{{ APP_URL }}list" class="btn btn-outline-primary px-5">
                <i class="fas fa-th me-2"></i>Xem tất cả sản phẩm
            </a>
        </div>

@endsection