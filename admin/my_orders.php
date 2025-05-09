<?php
require 'header1.php';
// session_start();

// Kiểm tra đăng nhập và vai trò nhân viên giao hàng
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 2) {
    header('Location: login.php');
    exit;
}

$staffId = $_SESSION['user_id'];

// Xử lý cập nhật trạng thái khi nhấn "Bắt đầu giao hàng"
if (isset($_POST['start_delivery']) && isset($_GET['maVanDon'])) {
    $ma = $_GET['maVanDon'];
    $updateStmt = $mysqli->prepare(
        "UPDATE DonHang SET trangThaiDonHang = 'Đang giao' WHERE maVanDon = ? AND id_nhanVien = ?"
    );
    $updateStmt->bind_param("si", $ma, $staffId);
    if ($updateStmt->execute()) {
        // Hiển thị thông báo và reload trang
        echo "<script>alert('Đã cập nhật trạng thái đơn hàng thành Đang giao.'); window.location.href = window.location.pathname;</script>";
        exit;
    } else {
        echo "<script>alert('Không thể cập nhật trạng thái. Vui lòng thử lại.');</script>";
    }
}

// Lấy danh sách đơn hàng (bao gồm tên sản phẩm)
$stmtList = $mysqli->prepare(
    "SELECT D.maVanDon, D.ngayTaoDon, N.diaChi, D.trangThaiDonHang, S.tenSanPham
     FROM DonHang D
     JOIN NguoiNhan N ON D.id_nguoiNhan = N.Id_NguoiNhan
     JOIN SanPham S ON D.id_sanPham = S.Id_SanPham
     WHERE D.id_nhanVien = ?
       AND D.trangThaiDonHang IN ('Đã phân công', 'Đang giao', 'Đã giao', 'Giao không thành công')
     ORDER BY D.ngayTaoDon DESC"
);
$stmtList->bind_param("i", $staffId);
$stmtList->execute();
$resultList = $stmtList->get_result();
?>

<style>
.content-container {
    min-height: 85vh;
    padding: 20px;
}
.table-orders {
  width: 100%;
  border-collapse: collapse;
  margin: 20px 0;
}
.table-orders th, .table-orders td {
  padding: 12px;
  border: 1px solid #ddd;
  text-align: left;
}
.table-orders th {
  background-color: #f4f4f4;
}
.btn {
  display: inline-block;
  padding: 8px 12px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  text-decoration: none;
  margin: 2px;
}
.btn-primary {
  background-color: #007bff;
  color: #fff;
}
.btn-success {
  background-color: #28a745;
  color: #fff;
}
.btn-close {
  background: none;
  font-size: 20px;
  float: right;
  cursor: pointer;
}
.modal {
  display: none;
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0,0,0,0.5);
}
.modal-content {
  background-color: #fff;
  margin: 10% auto;
  padding: 20px;
  border-radius: 8px;
  max-width: 500px;
  position: relative;
}
.modal-header {
  margin-bottom: 10px;
}
.modal-body {
  margin-bottom: 20px;
}
</style>

<div class="content-container">
  <h2>Đơn hàng của tôi</h2>

  <table class="table-orders">
    <tr>
      <th>Mã đơn</th>
      <th>Loại hàng</th>
      <th>Địa chỉ</th>
      <th>Ngày tạo</th>
      <th>Trạng thái</th>
      <th>Thao tác</th>
    </tr>
    <?php while ($row = $resultList->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($row['maVanDon']) ?></td>
        <td><?= htmlspecialchars($row['tenSanPham']) ?></td>
        <td><?= htmlspecialchars($row['diaChi']) ?></td>
        <td><?= $row['ngayTaoDon'] ?></td>
        <td><?= htmlspecialchars($row['trangThaiDonHang']) ?></td>
        <td>
          <button
            class="btn btn-primary view-detail"
            data-ma="<?= htmlspecialchars($row['maVanDon']) ?>"
            data-product="<?= htmlspecialchars($row['tenSanPham']) ?>"
            data-address="<?= htmlspecialchars($row['diaChi']) ?>"
            data-date="<?= $row['ngayTaoDon'] ?>"
            data-status="<?= htmlspecialchars($row['trangThaiDonHang']) ?>"
          >Xem chi tiết</button>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>
</div>

<!-- Popup Modal -->
<div id="detailModal" class="modal">
  <div class="modal-content">
    <span class="btn-close" id="modalClose">&times;</span>
    <div class="modal-header"><h3>Chi tiết đơn hàng</h3></div>
    <div class="modal-body" id="modalBody"></div>
  </div>
</div>

<script>
// Khởi tạo kết nối WebSocket đến server Node.js
const socket = new WebSocket('ws://localhost:8081');

socket.addEventListener('open', () => {
  console.log('WebSocket connected');
});

socket.addEventListener('error', (err) => {
  console.error('WebSocket error:', err);
});

// Gửi vị trí liên tục khi có thay đổi
if (navigator.geolocation) {
  navigator.geolocation.watchPosition(
    pos => {
      const { latitude: lat, longitude: lng } = pos.coords;
      const payload = {
        staffId: <?= $staffId ?>,
        timestamp: new Date().toISOString(),
        lat,
        lng
      };
      if (socket.readyState === WebSocket.OPEN) {
        socket.send(JSON.stringify(payload));
      }
    },
    err => {
      console.error('Error getting location:', err.code, err.message);
    },
    {
      enableHighAccuracy: true,
      timeout: 10000,
      maximumAge: 0
    }
  );
} else {
  console.error('Geolocation không được hỗ trợ');
}
socket.addEventListener('close', () => {
  console.log('Socket closed, retry in 3s');
  setTimeout(initWebSocket, 3000);
});


// xử lý modal giao hàng
const modal = document.getElementById('detailModal');
const bodyDiv = document.getElementById('modalBody');
const closeBtn = document.getElementById('modalClose');

// Đóng modal
closeBtn.addEventListener('click', () => modal.style.display = 'none');
window.addEventListener('click', e => { if (e.target === modal) modal.style.display = 'none'; });

// Xem chi tiết
document.querySelectorAll('.view-detail').forEach(btn => {
  btn.addEventListener('click', () => {
    const ma = btn.dataset.ma;
    const product = btn.dataset.product;
    const address = btn.dataset.address;
    const date = btn.dataset.date;
    const status = btn.dataset.status;
    let html = `
      <ul>
        <li><strong>Mã đơn:</strong> ${ma}</li>
        <li><strong>Loại hàng:</strong> ${product}</li>
        <li><strong>Địa chỉ:</strong> ${address}</li>
        <li><strong>Ngày tạo:</strong> ${date}</li>
        <li><strong>Trạng thái:</strong> ${status}</li>
      </ul>
    `;
    if (status === 'Đã phân công') {
      html += `
        <form method="post" action="?maVanDon=${encodeURIComponent(ma)}">
          <button class="btn btn-success" type="submit" name="start_delivery">Bắt đầu giao hàng</button>
        </form>
      `;
    }
    bodyDiv.innerHTML = html;
    modal.style.display = 'block';
  });
});
</script>
<?php require 'footer.php'; ?>