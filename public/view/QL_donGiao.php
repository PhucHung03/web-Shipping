<?php
require_once './config/conn.php';

session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Bạn cần đăng nhập để truy cập trang này.'); window.location.href='index.php?url=login';</script>";
    header('Location: index.php?url=login');
    exit();
}

// Lấy id của khách hàng đang đăng nhập
$user_id = $_SESSION['user_id'];

// Lấy dữ liệu từ form lọc/tìm kiếm
$search = isset($_GET['search']) ? $_GET['search'] : '';
$status = isset($_GET['status_name']) ? $_GET['status_name'] : 'all';
$date = isset($_GET['date']) ? $_GET['date'] : '';

// Xây dựng câu truy vấn
$sql = "SELECT o.maVanDon, o.ngayTaoDon, s.tenNguoiGui, r.tenNguoiNhan, o.COD, f.tongPhi, f.benTraPhi, os.status_name
            FROM orders o
            JOIN senders s ON o.sender_id = s.sender_id
            JOIN receivers r ON o.receiver_id = r.receiver_id
            JOIN fees f ON o.fee_id = f.fee_id
            JOIN orderstatuses os ON o.current_status_id = os.status_id
            WHERE o.id_khachhang = $user_id"; 

// Điều kiện tìm kiếm
if ($search) {
    $search = $conn->real_escape_string($search);
    $sql .= " AND (o.maVanDon LIKE '%$search%' OR s.tenNguoiGui LIKE '%$search%' OR r.tenNguoiNhan LIKE '%$search%')";
}

// Điều kiện lọc trạng thái
if ($status !== 'all') {
    $status = $conn->real_escape_string($status);
    $sql .= " AND os.status_name = '$status'";
}

// Điều kiện lọc ngày
if ($date) {
    $date = $conn->real_escape_string($date);
    $sql .= " AND DATE(o.ngayTaoDon) = '$date'";
}

$sql .= " ORDER BY o.ngayTaoDon DESC";
$result = $conn->query($sql);
?>

<div class="management-container">
    <h1 class="mb-4" style="text-align:center;padding:20px">Quản lý đơn giao hàng</h1>

    <!-- Bộ lọc và tìm kiếm -->
    <form method="GET" action="">
        <div class="row mb-3">
            <!-- Tìm kiếm -->
            <div class="col-md-4 mb-2">
                <label for="searchInput" class="form-label">Tìm kiếm</label>
                <input type="text" class="form-control search-input" id="searchInput" name="search"
                    placeholder="Tìm theo mã, người gửi, người nhận" value="<?php echo htmlspecialchars($search); ?>" oninput="filterOrders()">
            </div>
            <!-- Lọc trạng thái -->
            <div class="col-md-4 mb-2">
                <label for="statusFilter" class="form-label">Lọc theo trạng thái</label>
                <select class="form-select status-filter" id="statusFilter" name="status" onchange="filterOrders()">
                    <option value="all" <?php echo $status === 'all' ? 'selected' : ''; ?>>Tất cả</option>
                    <option value="Đã tạo" <?php echo $status === 'Đã tạo' ? 'selected' : ''; ?>>Đã tạo</option>
                    <option value="Chờ lấy hàng" <?php echo $status === 'Chờ lấy hàng' ? 'selected' : ''; ?>>Chờ lấy hàng</option>
                    <option value="Đang giao" <?php echo $status === 'Đang giao' ? 'selected' : ''; ?>>Đang giao</option>
                    <option value="Đang hoàn hàng" <?php echo $status === 'Đang hoàn hàng' ? 'selected' : ''; ?>>Đang hoàn hàng</option>
                    <option value="Chờ xác nhận giao lại" <?php echo $status === 'Chờ xác nhận giao lại' ? 'selected' : ''; ?>>Chờ xác nhận giao lại</option>
                    <option value="Hoàn tất" <?php echo $status === 'Hoàn tất' ? 'selected' : ''; ?>>Hoàn tất</option>
                    <option value="Đơn hủy" <?php echo $status === 'Đơn hủy' ? 'selected' : ''; ?>>Đơn hủy</option>
                    <option value="Hàng thất lạc - Hư hỏng" <?php echo $status === 'Hàng thất lạc - Hư hỏng' ? 'selected' : ''; ?>>Hàng thất lạc - Hư hỏng</option>
                </select>
            </div>
            <!-- Lọc theo ngày -->
            <div class="col-md-4 mb-2">
                <label for="dateFilter" class="form-label">Lọc theo ngày</label>
                <input type="date" class="form-control date-filter" id="dateFilter" name="date" value="<?php echo htmlspecialchars($date); ?>" onchange="filterOrders()">
            </div>
        </div>
    </form>

    <!-- Bảng danh sách đơn hàng -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="Manager_table" style="background-color: #ff5722; color: antiquewhite;">
                <tr>
                    <th>STT</th>
                    <th>Mã vận đơn</th>
                    <th>Người gửi</th>
                    <th>Người nhận</th>
                    <th>Thu hộ - COD (VNĐ)</th>
                    <th>Tổng phí (VNĐ)</th>
                    <th>Bên trả phí</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody id="orderTableBody">
                <?php
                if ($result->num_rows > 0) {
                    $stt = 1;
                    while ($row = $result->fetch_assoc()) {
                        // Chuẩn hóa trạng thái để gán lớp CSS
                        $status_class = '';
                        switch ($row['status_name']) {
                            case 'Đã tạo':
                                $status_class = 'status-waitconfirm';
                                break;
                            case 'Chờ lấy hàng':
                                $status_class = 'status-waiting';
                                break;
                            case 'Đang giao':
                                $status_class = 'status-delivering';
                                break;
                            case 'Đang hoàn hàng':
                                $status_class = 'status-returning';
                                break;
                            case 'Chờ xác nhận giao lại':
                                $status_class = 'status-reconfirm';
                                break;
                            case 'Hoàn tất':
                                $status_class = 'status-completed';
                                break;
                            case 'Đơn hủy':
                                $status_class = 'status-canceled';
                                break;
                            case 'Hàng thất lạc - Hư hỏng':
                                $status_class = 'status-lost-damaged';
                                break;
                        }
                ?>
                        <tr data-status="<?php echo htmlspecialchars($row['status_name']); ?>" data-date="<?php echo date('Y-m-d', strtotime($row['ngayTaoDon'])); ?>">
                            <td><?php echo $stt++; ?></td>
                            <td><?php echo htmlspecialchars($row['maVanDon']); ?></td>
                            <td><?php echo htmlspecialchars($row['tenNguoiGui']); ?></td>
                            <td><?php echo htmlspecialchars($row['tenNguoiNhan']); ?></td>
                            <td><?php echo number_format($row['COD'], 0, ',', '.'); ?></td>
                            <td><?php echo number_format($row['tongPhi'], 0, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($row['benTraPhi']); ?></td>
                            <td><span class="status-badge <?php echo $status_class; ?>"><?php echo htmlspecialchars($row['status_name']); ?></span></td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick="showOrderDetails()">Chi tiết</button>
                                <button class="btn btn-sm btn-danger" onclick="showOrderDetails()">Sửa</button>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo '<tr><td colspan="9" class="text-center">Không có đơn hàng nào.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>