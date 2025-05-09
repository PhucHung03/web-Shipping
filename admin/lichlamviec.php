<?php
// lichlamviec.php
if (session_status() === PHP_SESSION_NONE) session_start();
require 'db.php';
require 'header.php';

$actionMessage = '';
// Thêm mới
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $stmt = $mysqli->prepare("INSERT INTO LichLamViec (Id_NhanVien, ngayLamViec, thoiGianBatDau, thoiGianKetThuc, ghiChu) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $_POST['Id_NhanVien'], $_POST['ngayLamViec'], $_POST['thoiGianBatDau'], $_POST['thoiGianKetThuc'], $_POST['ghiChu']);
    $stmt->execute();
    $actionMessage = "Thêm lịch làm việc thành công!";
}

// Xóa
if (isset($_GET['delete'])) {
    $stmt = $mysqli->prepare("DELETE FROM LichLamViec WHERE Id_LichLamViec = ?");
    $stmt->bind_param("i", $_GET['delete']);
    $stmt->execute();
    $actionMessage = "Đã xóa lịch làm việc!";
}

// Cập nhật
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    // 1. Cập nhật lịch làm việc
    $stmt = $mysqli->prepare("UPDATE LichLamViec SET ngayLamViec=?, thoiGianBatDau=?, thoiGianKetThuc=?, ghiChu=? WHERE Id_LichLamViec=?");
    $stmt->bind_param("ssssi", $_POST['ngayLamViec'], $_POST['thoiGianBatDau'], $_POST['thoiGianKetThuc'], $_POST['ghiChu'], $_POST['Id_LichLamViec']);
    $stmt->execute();

    // 2. Lấy Id_NhanVien từ lịch làm việc vừa sửa
    $stmt = $mysqli->prepare("SELECT Id_NhanVien FROM LichLamViec WHERE Id_LichLamViec = ?");
    $stmt->bind_param("i", $_POST['Id_LichLamViec']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $idNhanVien = $row['Id_NhanVien'];

    // 3. Tạo thông báo kèm thời gian chi tiết
    $ngayTao = date("Y-m-d H:i:s");
    $ngayLam = $_POST['ngayLamViec'];
    $batDau = $_POST['thoiGianBatDau'];
    $ketThuc = $_POST['thoiGianKetThuc'];

    $noiDung = "🗓 Lịch làm việc ngày $ngayLam từ $batDau đến $ketThuc của bạn đã được cập nhật.";
    $trangThai = "Chưa đọc";

    $stmt = $mysqli->prepare("INSERT INTO ThongBao (Id_NhanVien, noiDung, trangThai) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $idNhanVien, $noiDung, $trangThai);
    $stmt->execute();

    $actionMessage = "Cập nhật thành công!";
}


// Danh sách nhân viên
$nhanvien = $mysqli->query("SELECT Id_nhanVien, tenNhanVien FROM NhanVien ORDER BY tenNhanVien");

// Nếu chọn nhân viên
$lichlamviec = [];
$selectedStaff = null;
if (isset($_GET['staff_id'])) {
    $sid = (int)$_GET['staff_id'];
    $selectedStaff = $mysqli->query("SELECT * FROM NhanVien WHERE Id_nhanVien=$sid")->fetch_assoc();
    $lichlamviec = $mysqli->query("SELECT * FROM LichLamViec WHERE Id_NhanVien=$sid ORDER BY ngayLamViec DESC");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý lịch làm việc</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 960px; min-height: 80vh;margin: 2rem auto; padding: 1.5rem; background: #fff; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.1); }
        h2 { margin-bottom: 1rem; color: #2c3e50; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 2rem; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background: #3498db; color: white; }
        a.btn, button { padding: 0.5rem 1rem; margin-right: 0.5rem; border: none; border-radius: 5px; background: #ff5722; color: white; text-decoration: none; cursor: pointer; }
        .btn-danger { background: #e74c3c; }
        .btn-edit { background: #f39c12; }
        form { margin-bottom: 1.5rem; }
        input, select, textarea { padding: 0.4rem; margin: 0.2rem 0; width: 100%; }
        .alert { padding: 1rem; background: #dff0d8; color: #3c763d; margin-bottom: 1rem; border-radius: 5px; }
        details summary {
            display: inline-block;
            cursor: pointer;
            margin-top: 5px;
        }

        details form {
            background: #f9f9f9;
            padding: 0.5rem;
            margin-top: 0.5rem;
            border-radius: 5px;
            box-shadow: 0 0 3px rgba(0,0,0,0.1);
        }

        td > details {
            display: block;
            margin-top: 5px;
        }

    </style>
</head>
<body>
<div class="container">
    <h2>Quản lý lịch làm việc nhân viên</h2>

    <?php if ($actionMessage): ?>
        <div class="alert"><?= $actionMessage ?></div>
    <?php endif; ?>

    <h3>Chọn nhân viên</h3>
    <ul style="margin-top: 30px;">
        <?php while ($nv = $nhanvien->fetch_assoc()): ?>
            <li style="height: 50px; list-style: none;">
                <a class="btn" href="?staff_id=<?= $nv['Id_nhanVien'] ?>">
                    <?= htmlspecialchars($nv['tenNhanVien']) ?>
                </a>
            </li>
        <?php endwhile; ?>
    </ul>

    <?php if ($selectedStaff): ?>
        <hr>
        <h3 style="margin-bottom: 20px;">Lịch làm việc của: <?= htmlspecialchars($selectedStaff['tenNhanVien']) ?></h3>

        <form method="post" style="margin-top: 0px;">
            <input type="hidden" name="Id_NhanVien" value="<?= $selectedStaff['Id_nhanVien'] ?>">
            <label>Ngày làm việc: <input type="date" name="ngayLamViec" required></label>
            <label>Bắt đầu: <input type="time" name="thoiGianBatDau" required></label>
            <label>Kết thúc: <input type="time" name="thoiGianKetThuc" required></label>
            <label style="position: relative; top: 30px;">Ghi chú: <textarea name="ghiChu"></textarea></label>
            <button type="submit" name="add">Thêm lịch</button>
        </form>

        <?php if ($lichlamviec && $lichlamviec->num_rows > 0): ?>
            <table>
                <thead>
                    <tr><th>Ngày</th><th>Thời gian</th><th>Ghi chú</th><th>Hành động</th></tr>
                </thead>
                <tbody>
                <?php while ($row = $lichlamviec->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['ngayLamViec'] ?></td>
                        <td><?= $row['thoiGianBatDau'] ?> - <?= $row['thoiGianKetThuc'] ?></td>
                        <td><?= htmlspecialchars($row['ghiChu']) ?></td>
                        <td>
                            <!-- Nút xóa -->
                            <a style="display: block; width: 60px; background-color: #e74c3c;" class="btn" href="?staff_id=<?= $selectedStaff['Id_nhanVien'] ?>&delete=<?= $row['Id_LichLamViec'] ?>" onclick="return confirm('Xóa lịch này?')">Xóa</a>
                            <!-- Sửa inline -->
                            <details style="margin-top: 5px;">
                            <summary class="btn btn-edit" style="width: 50px; height: 30px; border-radius: 5px; color: white; display: flex; align-items: center; justify-content: center; margin-top: 5px;">
                                Sửa
                            </summary>

                                <form method="post">
                                    <input type="hidden" name="Id_LichLamViec" value="<?= $row['Id_LichLamViec'] ?>">
                                    <label>Ngày: <input type="date" name="ngayLamViec" value="<?= $row['ngayLamViec'] ?>" required></label>
                                    <label>Bắt đầu: <input type="time" name="thoiGianBatDau" value="<?= $row['thoiGianBatDau'] ?>" required></label>
                                    <label>Kết thúc: <input type="time" name="thoiGianKetThuc" value="<?= $row['thoiGianKetThuc'] ?>" required></label>
                                    <label>Ghi chú: <input name="ghiChu" value="<?= htmlspecialchars($row['ghiChu']) ?>"></label>
                                    <button type="submit" name="edit">Cập nhật</button>
                                </form>
                            </details>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Không có lịch làm việc nào.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php require 'footer.php'; ?>
</body>
</html>
