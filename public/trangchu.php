<!-- Hero Section -->
    <div class="trangChu">
        <section class="hero-section bg-light py-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h1 class="display-4 fw-bold">Dịch vụ giao hàng nhanh và đáng tin cậy</h1>
                        <p class="lead">Tạo đơn hàng và quản lý đơn vận chuyển dễ dàng</p>
                        <div class="mt-4">
                            <a href="index.php?url=create-shipment" class="btn btn-primary btn-lg me-3">Tạo đơn hàng</a>
                            <a href="index.php?url=manager-shipment" class="btn btn-outline-primary btn-lg">Đơn hàng của bạn</a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <img src="./public/img/banner_flybee.png" alt="Shipping illustration" class="img-fluid">
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
    
        <!-- Features Section -->
        <section class="py-5 bg-light">
            <div class="container">
                <h2 class="text-center mb-5">Dịch vụ của chúng tôi</h2>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-truck fa-3x text-primary mb-3"></i>
                                <h4>Giao hàng nhanh</h4>
                                <p>Dịch vụ giao hàng nhanh chóng và đáng tin cậy trên toàn quốc</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-map-marker-alt fa-3x text-primary mb-3"></i>
                                <h4>Theo dõi thời gian giao hàng</h4>
                                <p>Theo dõi các gói hàng của bạn theo thời gian thực với các cập nhật chi tiết</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-shield-alt fa-3x text-primary mb-3"></i>
                                <h4>Vận chuyển an toàn</h4>
                                <p>Các gói hàng của bạn được bảo hiểm và xử lý cẩn thận</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>