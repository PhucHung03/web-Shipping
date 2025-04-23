<?php
require_once './config/conn.php';

session_start();


$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error_message = 'Vui lòng điền đầy đủ thông tin.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Vui lòng nhập địa chỉ email hợp lệ.';
    } else {
        try {
            // Sử dụng mysqli thay vì PDO
            $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message, created_at) VALUES (?, ?, ?, ?, NOW())");
            $stmt->bind_param("ssss", $name, $email, $subject, $message);
            $result = $stmt->execute();
            
            if ($result) {
                $success_message = 'Cảm ơn bạn đã gửi tin nhắn. Chúng tôi sẽ liên hệ lại với bạn sớm!';
                
                // Gửi email thông báo cho quản trị viên
                $to = "admin@shipping.com";
                $headers = "From: " . $email . "\r\n";
                $headers .= "Reply-To: " . $email . "\r\n";
                $headers .= "X-Mailer: PHP/" . phpversion();
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                
                mail($to, "Tin nhắn liên hệ mới: " . $subject, $message, $headers);
            } else {
                $error_message = 'Xin lỗi, đã xảy ra lỗi khi gửi tin nhắn. Vui lòng thử lại sau.';
            }
            
        } catch (Exception $e) {
            $error_message = 'Xin lỗi, đã xảy ra lỗi khi gửi tin nhắn. Vui lòng thử lại sau.';
        }
    }
}
?>

    <div class="container py-5">
        <div class="row">
            <!-- Form Liên hệ -->
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body p-5">
                        <h2 class="card-title mb-4">Liên hệ với chúng tôi</h2>
                        
                        <?php if ($success_message): ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo htmlspecialchars($success_message); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($error_message): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo htmlspecialchars($error_message); ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="contact.php">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Họ và tên</label>
                                        <input type="text" class="form-control form-control-lg" id="name" name="name" 
                                               required value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Địa chỉ email</label>
                                        <input type="email" class="form-control form-control-lg" id="email" name="email" 
                                               required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="subject" class="form-label">Tiêu đề</label>
                                <input type="text" class="form-control form-control-lg" id="subject" name="subject" 
                                       required value="<?php echo htmlspecialchars($_POST['subject'] ?? ''); ?>">
                            </div>

                            <div class="mb-4">
                                <label for="message" class="form-label">Nội dung</label>
                                <textarea class="form-control form-control-lg" id="message" name="message" rows="5" 
                                          required><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Gửi tin nhắn</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Thông tin liên hệ -->
            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Thông tin liên hệ</h4>
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                12 Lê Thánh Tôn<br>
                                phường Bến Nghé, Quận 1, TP.HCM
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-phone text-primary me-2"></i>
                                +84 123123123
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-envelope text-primary me-2"></i>
                                info@flybeeshipping.com
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-clock text-primary me-2"></i>
                                Thứ 2 - Thứ 6: 8:00 - 17:30
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Bản đồ -->
                <div class="card shadow-sm">
                    <div class="card-body p-0">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.5177580045246!2d106.69891731533417!3d10.771597192324364!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f3c586421ef%3A0xb606461945d70bc9!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBLaG9hIGjhu41jIFThu7Egbmhpw6puIFRQLiBIQ00!5e0!3m2!1svi!2s!4v1682225583059!5m2!1svi!2s" 
                                width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>