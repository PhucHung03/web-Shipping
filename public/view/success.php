<?php 
    if (isset($_GET['maVanDon'])) {
        $maVanDon = $_GET['maVanDon'];
    } else {
        $maVanDon = 'Không có mã vận đơn!';
    }

?>
<div class="success-container">
    <div class="card success-card shadow">
        <div class="card-body">
            <h1 class="card-title text-success mb-4">Tạo đơn giao hàng thành công!</h1>
            <p class="card-text">Cảm ơn bạn đã tạo đơn giao hàng. Đơn giao hàng của bạn đã được ghi nhận.</p>
            <p class="card-text" >Mã vận đơn của bạn là: <b><?= $maVanDon ?></b></p>
            <p class="order-code" id="orderCode"></p>
            <p class="card-text">Vui lòng lưu lại mã này để tra cứu trạng thái đơn hàng.</p>
            <a href="index.php?url=trangchu" class="btn mt-3">Quay lại trang chủ</a>
            <a href="index.php?url=manager-shipment" class="btn btn-primary mt-3">Đơn giao của tôi</a>
        </div>
    </div>
</div>