<?php
require_once './config/conn.php';

session_start();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';

    if (!empty($name) && !empty($email) && !empty($password) && !empty($confirm_password) && !empty($address)) {
        if ($password === $confirm_password) {
            try {
                $stmt = $conn->prepare("SELECT id_khachhang FROM khach WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();

                if ($user) {
                    $error = 'Email đã tồn tại. Vui lòng dùng email khác.';
                } else {
                    // Mã hóa mật khẩu
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Thêm người dùng mới vào bảng khach
                    $stmt = $conn->prepare("INSERT INTO khach (hoTen, soDienThoai, diaChi, email, password) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$name, $phone, $address, $email, $hashed_password]);

                    $success = 'Đăng ký thành công! Đang chuyển đến trang đăng nhập...';
                    header("refresh:2;url=index.php?url=login");
                }
            } catch (PDOException $e) {
                $error = "Lỗi kết nối: " . $e->getMessage();
            }
        } else {
            $error = 'Mật khẩu không khớp';
        }
    } else {
        $error = 'Vui lòng điền đầy đủ các trường bắt buộc';
    }
}
?>

<div class="register container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <a href="index.php">
                            <img src="public/img/logo flybee.png" alt="Logo" height="40" class="mb-4">
                        </a>
                        <h2 class="fw-bold">Đăng ký tài khoản</h2>
                        <p class="text-muted">Tham gia dịch vụ giao hàng của Flybee ngay</p>
                    </div>

                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php elseif ($success): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>

                    <form method="POST" action="index.php?url=register">
                        <div class="mb-3">
                            <label for="name" class="form-label">Họ và Tên</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="tel" class="form-control" id="phone" name="phone">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-4">
                            <label for="confirm_password" class="form-label">Nhập lại mật khẩu</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Tạo tài khoản</button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <p class="mb-0">Bạn đã có tài khoản<a href="index.php?url=login" class="text-primary">Đăng nhập</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>