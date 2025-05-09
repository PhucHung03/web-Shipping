<?php
require 'header.php';
// session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 2) {
    header('Location: login.php');
    exit;
}

$maVanDon = $_GET['maVanDon'] ?? '';
$staffId = $_SESSION['user_id'];

// Lấy chi tiết đơn hàng
$stmt = $mysqli->prepare("
    SELECT D.maVanDon, S.tenSanPham, N.diaChi, D.trangThaiDonHang, D.ngayTaoDon
    FROM DonHang D
    JOIN NguoiNhan N ON D.id_nguoiNhan = N.Id_NguoiNhan
    JOIN SanPham S ON D.id_sanPham = S.Id_SanPham
    WHERE D.maVanDon = ? AND D.id_nhanVien = ?
");
$stmt->bind_param("si", $maVanDon, $staffId);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if (!$order) {
    echo "<p>Không tìm thấy đơn hàng hoặc bạn không có quyền xem đơn này.</p>";
    require 'footer.php';
    exit;
}
?>

<h2>Chi tiết đơn hàng: <?= htmlspecialchars($order['maVanDon']) ?></h2>
<ul>
  <li>Địa chỉ: <?= htmlspecialchars($order['diaChi']) ?></li>
  <li>Loại hàng: <?= htmlspecialchars($order['tenSanPham']) ?></li>
  <li>Ngày tạo: <?= $order['ngayTaoDon'] ?></li>
  <li>Trạng thái: <?= htmlspecialchars($order['trangThaiDonHang']) ?></li>
</ul>

<?php if ($order['trangThaiDonHang'] === 'Đã phân công'): ?>
  <form method="post">
    <button type="submit" name="start_delivery">Bắt đầu giao hàng</button>
  </form>
<?php endif; ?>

<?php
// Xử lý cập nhật trạng thái nếu nhấn "Bắt đầu giao hàng"
if (isset($_POST['start_delivery'])) {
    $updateStmt = $mysqli->prepare("UPDATE DonHang SET trangThaiDonHang = 'Đang giao' WHERE maVanDon = ? AND id_nhanVien = ?");
    $updateStmt->bind_param("si", $maVanDon, $staffId);
    if ($updateStmt->execute()) {
        echo "<p style='color: green;'>Đã cập nhật trạng thái đơn hàng thành 'Đang giao'.</p>";
        echo "<script>setTimeout(() => window.location.href = 'my_orders.php', 1500);</script>";
    } else {
        echo "<p style='color: red;'>Không thể cập nhật trạng thái đơn hàng. Vui lòng thử lại.</p>";
    }
}
?>

<?php require 'footer.php'; ?>
