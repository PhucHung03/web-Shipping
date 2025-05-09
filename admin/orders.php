<?php
// assign.php
require 'header.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require 'db.php';

$message = '';
$messageType = '';

// Xử lý phân công khi submit form
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    !empty($_POST['orders']) &&
    !empty($_POST['staff_id'])
) {
    $staffId = (int)$_POST['staff_id'];
    $orders  = $_POST['orders'];

    $mysqli->begin_transaction();
    try {
        $stmtUpdate = $mysqli->prepare(
            "UPDATE DonHang 
             SET id_nhanVien = ?, trangThaiDonHang = 'Đã phân công' 
             WHERE maVanDon = ?"
        );
        $stmtNotify = $mysqli->prepare(
            "INSERT INTO ThongBao (Id_NhanVien, noiDung) VALUES (?, ?)"
        );

        foreach ($orders as $md) {
            $stmtUpdate->bind_param('is', $staffId, $md);
            $stmtUpdate->execute();

            $msgNotify = "Bạn được phân công đơn hàng $md";
            $stmtNotify->bind_param('is', $staffId, $msgNotify);
            $stmtNotify->execute();
        }
        $mysqli->commit();
        $message = 'Phân công thành công!';
        $messageType = 'success';
    } catch (Exception $e) {
        $mysqli->rollback();
        $message = 'Lỗi: Không thể cập nhật. Vui lòng thử lại!';
        $messageType = 'error';
    }
}

// Lấy đơn chờ phân công
$sql = "
    SELECT D.maVanDon,
           N.diaChi    AS diaChiNhan,
           S.tenSanPham AS loaiHang,
           D.ngayTaoDon
    FROM DonHang D
    JOIN NguoiNhan N ON D.id_nguoiNhan = N.Id_NguoiNhan
    JOIN SanPham S   ON D.id_sanPham  = S.Id_SanPham
    WHERE D.trangThaiDonHang = 'Chờ phân công'
    ORDER BY D.ngayTaoDon DESC
";
$result = $mysqli->query($sql);

// Lấy danh sách nhân viên giao hàng và thống kê
$staffs = $mysqli->query(
    "SELECT Id_nhanVien, tenNhanVien, viTri FROM NhanVien WHERE viTri = 'Giao hàng'"
);
$staffList = [];
$staffStats = [];
while ($s = $staffs->fetch_assoc()) {
    $sid = $s['Id_nhanVien'];
    // Đếm pending
    $st1 = $mysqli->prepare("SELECT COUNT(*) FROM DonHang WHERE id_nhanVien = ? AND trangThaiDonHang != 'Đã giao'");
    $st1->bind_param('i', $sid);
    $st1->execute(); $st1->bind_result($pending); $st1->fetch(); $st1->close();
    // Đếm done
    $st2 = $mysqli->prepare("SELECT COUNT(*) FROM DonHang WHERE id_nhanVien = ? AND trangThaiDonHang = 'Đã giao'");
    $st2->bind_param('i', $sid);
    $st2->execute(); $st2->bind_result($done); $st2->fetch(); $st2->close();
    $perf = ($done + $pending) > 0 ? round($done/($done+$pending)*100,1) : 0;
    
    $staffList[] = $s;
    $staffStats[$sid] = [
        'name'        => $s['tenNhanVien'],
        'position'    => $s['viTri'],
        'pending'     => $pending,
        'done'        => $done,
        'performance' => $perf
    ];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Phân công đơn hàng</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    .content-container { max-width: 1000px; margin: 2rem auto; padding: 1.5rem; background: #fff; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); min-height: 85vh; }
    .content-container h2 { margin-bottom: 1rem; color: #2c3e50; font-size: 1.75rem; }
    .no-orders { text-align: center; margin: 2rem 0; font-size: 1.25rem; color: #555; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 1.5rem; }
    th, td { padding: 0.75rem 1rem; border-bottom: 1px solid #e0e0e0; text-align: left; }
    th { background: #0dcaf0; color: #ecf0f1; font-weight: 500; }
    tr:nth-child(even) { background: #f9f9f9; }
    select, button { padding: 0.6rem 1rem; border: 1px solid #ccc; border-radius: 6px; font-size: 1rem; outline: none; }
    select { min-width: 230px; transition: border-color 0.3s; }
    select:focus { border-color: #2c3e50; box-shadow: 0 0 5px rgba(44,62,80,0.2); }
    button { background: #0dcaf0; color: #fff; border: 1px solid #1abc9c; cursor: pointer; transition: background 0.3s; margin-top: 0.5rem; }
    button:hover { background: #0dcaf0; }
    #detailLink { margin-left: 1rem; font-size: 0.95rem; color: #2c3e50; text-decoration: none; transition: color 0.3s; }
    #detailLink:hover { color: #1abc9c; }
    /* Popup Modals */
    .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.4); overflow: auto; }
    .modal-content { background: #fff; margin: 10% auto; padding: 1.5rem; border-radius: 8px; max-width: 400px; position: relative; }
    .modal-header { margin-bottom: 1rem; font-size: 1.25rem; color: #2c3e50; }
    .modal-body ul { list-style: none; padding: 0; }
    .modal-body li { margin: 0.5rem 0; }
    .close { position: absolute; right: 1rem; top: 0.5rem; font-size: 1.5rem; cursor: pointer; color: #aaa; }
    .close:hover { color: #000; }
    .modal-content.success { border-top: 5px solid #2ecc71; }
    .modal-content.error   { border-top: 5px solid #e74c3c; }
  </style>
</head>
<body>
<div class="content-container">
  <h2>Đơn hàng chờ phân công</h2>
  <form id="assignForm" method="post">
    <?php if ($result->num_rows === 0): ?>
      <p class="no-orders">Không có đơn hàng nào.</p>
    <?php else: ?>
    <table>
      <thead>
        <tr><th>Chọn</th><th>Mã đơn</th><th>Địa chỉ</th><th>Loại hàng</th><th>Ngày tạo</th></tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><input type="checkbox" name="orders[]" value="<?= htmlspecialchars($row['maVanDon']) ?>"></td>
          <td><?= htmlspecialchars($row['maVanDon']) ?></td>
          <td><?= htmlspecialchars($row['diaChiNhan']) ?></td>
          <td><?= htmlspecialchars($row['loaiHang']) ?></td>
          <td><?= date('d/m/Y', strtotime($row['ngayTaoDon'])) ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
    <?php endif; ?>
    <div>
      <label for="staffSelect">Phân công cho:</label>
      <select name="staff_id" id="staffSelect" required>
        <option value="">-- Chọn nhân viên giao hàng --</option>
        <?php foreach ($staffList as $s): ?>
          <option value="<?= $s['Id_nhanVien'] ?>"><?= htmlspecialchars($s['tenNhanVien']) ?></option>
        <?php endforeach; ?>
      </select>
      <a id="detailLink" href="#" style="display:none;">Xem chi tiết nhân viên</a>
    </div>
    <button type="submit">Phân công</button>
  </form>
</div>

<!-- Assignment Result Modal -->
<?php if ($message): ?>
<div id="assignModal" class="modal">
  <div class="modal-content <?= $messageType ?>">
    <span class="close" id="closeAssign">&times;</span>
    <p><?= htmlspecialchars($message) ?></p>
  </div>
</div>
<?php endif; ?>

<!-- Staff Detail Modal -->
<div id="staffModal" class="modal">
  <div class="modal-content">
    <span class="close" id="closeStaff">&times;</span>
    <div class="modal-header">Chi tiết nhân viên</div>
    <div class="modal-body" id="staffModalBody"></div>
  </div>
</div>

<script>
// Pass PHP stats to JS
const staffStats = <?= json_encode($staffStats) ?>;

// Elements\const staffSelect = document.getElementById('staffSelect');
const detailLink  = document.getElementById('detailLink');
const staffModal  = document.getElementById('staffModal');
const staffBody   = document.getElementById('staffModalBody');
const closeStaff  = document.getElementById('closeStaff');

// Show detail link on select change
staffSelect.addEventListener('change', function() {
  if (this.value) {
    detailLink.style.display = 'inline';
  } else {
    detailLink.style.display = 'none';
  }
});

// Open staff detail modal
detailLink.addEventListener('click', function(e) {
  e.preventDefault();
  const sid = staffSelect.value;
  const st  = staffStats[sid];
  if (st) {
    staffBody.innerHTML = `
      <ul>
        <li><strong>Tên:</strong> ${st.name}</li>
        <li><strong>Vị trí:</strong> ${st.position}</li>
        <li><strong>Đang xử lý:</strong> ${st.pending}</li>
        <li><strong>Đã giao:</strong> ${st.done}</li>
        <li><strong>Hiệu suất:</strong> ${st.performance}%</li>
      </ul>
    `;
    staffModal.style.display = 'block';
  }
});

// Close staff modal
closeStaff.onclick = () => staffModal.style.display = 'none';
window.addEventListener('click', e => { if (e.target === staffModal) staffModal.style.display = 'none'; });

// Assignment result modal
const assignModal = document.getElementById('assignModal');
const closeAssign = document.getElementById('closeAssign');
if (assignModal) {
  assignModal.style.display = 'block';
  closeAssign.onclick = () => assignModal.style.display = 'none';
  window.onclick = e => { if (e.target === assignModal) assignModal.style.display = 'none'; };
}

// Form validation
document.getElementById('assignForm').addEventListener('submit', function(e) {
  if (!document.querySelector('input[name="orders[]"]:checked')) {
    e.preventDefault();
    alert('Vui lòng chọn ít nhất một đơn hàng để phân công!');
  }
});
</script>

<?php require 'footer.php'; ?>
