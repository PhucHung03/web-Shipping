<!-- Hero Section -->
<div class="trangChu">
    <section class="section__banner container-fluid p-0">
        <!-- banner  -->
        <div class="row m-0">
            <div class="col-lg p-0">
                <!-- Carousel -->
                <div id="banner__carousel" class="carousel slide" data-bs-ride="carousel">
                    <!-- The slideshow/carousel -->
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="./public/img/banner/banner-1.jpg" alt="" class="d-block w-100" style="object-fit: cover; object-position: center;">
                        </div>
                        <div class="carousel-item">
                            <img src="./public/img/banner/banner-2.jpg" alt="" class="d-block w-100" style="object-fit: cover; object-position: center;">
                        </div>
                        <div class="carousel-item">
                            <img src="./public/img/banner/banner-3.jpg" alt="" class="d-block w-100" style="object-fit: cover; object-position: center;">
                        </div>
                    </div>

                    <!-- Left and right controls/icons -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#banner__carousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#banner__carousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Tracking Form -->
    <section class="py-5">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Đơn hàng của bạn</h3>
                    <form action="index.php" method="GET">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <input type="hidden" name="url" value="tracking">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-lg" name="tracking_number" placeholder="Nhập mã vận đơn"
                                        value="<?php echo isset($_GET['tracking_number']) ? htmlspecialchars($_GET['tracking_number']) : ''; ?>">

                                    <button class="btn btn-primary btn-lg" type="submit">Tìm kiếm</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- infomation -->
    <div class="about_flybee container bg-light" style="margin: 100px 0 100px 0;">
        <div class="row" style="margin-left: 90px ;">
            <!-- Phần giới thiệu -->
            <div class="col-md-6 content p-4 ">
                <h3 class="text-center mb-4">Về FlyBee</h3>
                <p style="font-size: 16px;">FlybeeMove là dịch vụ giao hàng nhanh chóng và đáng tin cậy, phát triển dựa trên nền tảng công nghệ hiện đại. Chúng tôi sở hữu mạng lưới rộng khắp nhằm hỗ trợ các hoạt động giao nhận hàng hóa nhanh chóng không chỉ ở nội thành mà còn ở ngoại thành và vùng sâu vùng xa trên toàn quốc.</p>
            </div>

            <!-- Phần dịch vụ -->
            <div class="col-md-6 bg-white ">
                <div class="row g-4">
                    <div class="col-6 d-flex align-items-start">
                        <img src="./public/img/63tinh-thanh.png" alt="map" width="100" class="me-3">
                        <div>
                            <h4 class="fw-bold">63 TỈNH THÀNH</h4>
                            <p class="mb-0">Dịch vụ phủ sóng khắp 63 tỉnh thành</p>
                        </div>
                    </div>

                    <div class="col-6 d-flex align-items-start">
                        <img src="./public/img/1000xe.png" alt="truck" width="90" class="me-3">
                        <div>
                            <h4 class="fw-bold">ĐA DẠNG PHƯƠNG TIỆN</h4>
                            <p class="mb-0">Đa dạng phương tiện vận chuyển hàng hóa</p>
                        </div>
                    </div>

                    <div class="col-6 d-flex align-items-start">
                        <img src="./public/img/25000nhan-vien.png" alt="staff" width="90" class="me-3">
                        <div>
                            <h4 class="fw-bold">NHÂN SỰ CHUYÊN NGHIỆP</h4>
                            <p class="mb-0">Nhân sự được đào tạo bài bản & chuyên nghiệp</p>
                        </div>
                    </div>

                    <div class="col-6 d-flex align-items-start">
                        <img src="./public/img/1900bu-cuc.png" alt="warehouse" width="90" class="me-3">
                        <div>
                            <h4 class="fw-bold">BƯU CỤC RỘNG KHẮP</h4>
                            <p class="mb-0">Mạng lưới bưu cục rộng khắp hoạt động trên toàn quốc</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4">Dịch vụ của chúng tôi</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-truck fa-3x mb-3" style="color:#ff5722 ;"></i>
                            <h4>Giao hàng nhanh</h4>
                            <p>Dịch vụ giao hàng nhanh chóng và đáng tin cậy trên toàn quốc</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-map-marker-alt fa-3x mb-3" style="color:#ff5722 ;"></i>
                            <h4>Theo dõi thời gian giao hàng</h4>
                            <p>Theo dõi các gói hàng của bạn theo thời gian thực với các cập nhật chi tiết</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-shield-alt fa-3x mb-3" style="color:#ff5722 ;"></i>
                            <h4>Vận chuyển an toàn</h4>
                            <p>Các gói hàng của bạn được bảo hiểm và xử lý cẩn thận</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- section tin tức  -->
    <div class="section__tintuc container mt-5">
        <h2 class="text-center mb-4">
            Tin tức mới
        </h2>

        <div class="row">
            <!-- Card 1 -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="./public/img/tintuc/trungngay.png" class="card-img-top" alt="Tin tức 1">
                    <div class="card-body">
                        <span class="badge badge-primary mb-2">Tin báo chí</span>
                        <p class="text-muted">05/11/2024</p>
                        <h5 class="card-title">Siêu Quay Trúng Ngay: đổi điểm JP trên App - cơ hội trúng iPhone 15</h5>
                        <p class="card-text">Từ ngày 12/5/2025 đến 30/6/2025, khách hàng sử dụng App Flybee Express VN Pro tích lũy điểm JP sẽ được tham gia vòng quay may mắn "Siêu Quay Trúng Ngay".</p>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="./public/img/tintuc/even.png" class="card-img-top" alt="Tin tức 2">
                    <div class="card-body">
                        <span class="badge badge-primary mb-2">Tin báo chí</span>
                        <p class="text-muted">22/10/2024</p>
                        <h5 class="card-title">Flybee Express đạt chứng nhận quốc tế về hệ thống quản lý an toàn thông tin ISO/IEC 27001</h5>
                        <p class="card-text">Flybee Express Việt Nam vừa được trao chứng nhận "ISO/IES 27001:2022"- tiêu chuẩn quốc tế về hệ thống quản lý an toàn thông tin, thể hiện cam kết...</p>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="./public/img/tintuc/diaphuong.jpg" class="card-img-top" alt="Tin tức 3">
                    <div class="card-body">
                        <span class="badge badge-primary mb-2">Tin báo chí</span>
                        <p class="text-muted">21/10/2024</p>
                        <h5 class="card-title">Địa phương hóa - Chiến lược mũi nhọn của Flybee Express</h5>
                        <p class="card-text">Flybee Express mang yếu tố quốc tế hòa nhập vào từng địa phương, tạo nên bản sắc riêng ở mỗi nơi mà hành trình giao nhận đi qua. Và điểm đến lần này là Huế....</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="#" class="btn btn-primary">XEM TẤT CẢ</a>
        </div>
    </div>
    <!-- end section tin tức -->
</div>