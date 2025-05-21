<?php
require_once './config/conn.php';
session_start();


if (!isset($_SESSION['id_khach'])) {
    echo "<script>alert('Bạn cần đăng nhập để thực hiện thao tác này.'); window.location.href='index.php?url=login';</script>";
    exit();
}


if (!isset($_GET['maVanDon'])) {
    echo "<script>alert('Không tìm thấy mã vận đơn.'); window.location.href='index.php?url=manager-shipment';</script>";
    exit();
}

$maVanDon = $_GET['maVanDon'];


$conn->begin_transaction();

try {
    //
    $checkOrder = $conn->prepare("SELECT id_trangThai FROM donhang WHERE maVanDon = ? AND id_khachHang = ?");
    $checkOrder->bind_param("si", $maVanDon, $_SESSION['id_khach']);
    $checkOrder->execute();
    $result = $checkOrder->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception("Không tìm thấy đơn hàng hoặc bạn không có quyền hủy đơn hàng này.");
    }
    
    $order = $result->fetch_assoc();
    
    // kiểm tra trạng thái "Đã tạo"
    if ($order['id_trangThai'] !== 1) { 
        throw new Exception("Chỉ có thể hủy đơn hàng ở trạng thái 'Đã tạo'.");
    }
    
    // Lấy mã trạng thái "Đã hủy"
    $getCancelStatus = $conn->query("SELECT id_trangThai FROM trangthai WHERE tenTrangThai = 'Đã hủy'");
    $cancelStatus = $getCancelStatus->fetch_assoc();
    
    if (!$cancelStatus) {
        throw new Exception("Không tìm thấy trạng thái 'Đã hủy' trong hệ thống.");
    }
    
    // Cập nhật trạng thái đơn hàng "Đã hủy"
    $updateOrder = $conn->prepare("UPDATE donhang SET id_trangThai = ? WHERE maVanDon = ?");
    $updateOrder->bind_param("is", $cancelStatus['id_trangThai'], $maVanDon);
    $updateOrder->execute();
    
    // Thêm lịch sử trạng thái
    $currentTime = date('Y-m-d H:i:s');
    $addHistory = $conn->prepare("INSERT INTO lichsu_trangthai (maVanDon, id_trangThai, mocThoiGian, diaDiem, HIMnotes) VALUES (?, ?, ?, ?, ?)");
    $location = "Hệ thống";
    $note = "Đơn hàng đã được hủy bởi người gửi";
    $addHistory->bind_param("sisss", $maVanDon, $cancelStatus['id_trangThai'], $currentTime, $location, $note);
    $addHistory->execute();
    
    //
    $conn->commit();
    
    echo "<script>alert('Hủy đơn hàng thành công.'); window.location.href='index.php?url=manager-shipment';</script>";
    
} catch (Exception $e) {
    // Xử lý lỗi
    $conn->rollback();
    echo "<script>alert('Lỗi: " . $e->getMessage() . "'); window.location.href='index.php?url=manager-shipment';</script>";
}

$conn->close();
?> 