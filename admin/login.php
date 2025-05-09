<?php
session_start();
require 'db.php';

// Xử lý đăng nhập
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $mysqli->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    
    $stmt = $mysqli->prepare(
        "SELECT Id_nhanVien, Password, phanQuyen 
         FROM NhanVien WHERE Email = ?"
    );
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->bind_result($id, $hash, $role);
    if ($stmt->fetch() && $password === $hash) {
        $_SESSION['user_id'] = $id;
        $_SESSION['role']    = $role;
        if($role === 1)
            header('Location: index.php');
        else
        header('Location: my_orders.php');
        exit;
    }
    $error = 'Email hoặc mật khẩu không đúng';
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng nhập</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <style>
    /* Reset & Global Styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Roboto', sans-serif;
    }
    body {
      background: linear-gradient(135deg, #71b7e6, #9b59b6);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    /* Container */
    .login-container {
      background: #fff;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
      width: 350px;
      text-align: center;
    }
    .login-container h2 {
      margin-bottom: 1.5rem;
      color: #333;
    }
    /* Form Elements */
    .input-group {
      margin-bottom: 1rem;
      text-align: left;
    }
    .input-group label {
      display: block;
      margin-bottom: 0.5rem;
      color: #555;
    }
    .input-group input {
      width: 100%;
      padding: 0.75rem;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 1rem;
    }
    .input-group input:focus {
      outline: none;
      border-color: #9b59b6;
      box-shadow: 0 0 5px rgba(155,89,182,0.2);
    }
    /* Button */
    button {
      width: 100%;
      padding: 0.75rem;
      border: none;
      border-radius: 8px;
      background: #ff5722;
      color: #fff;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.3s ease;
    }
    button:hover {
      background: #8e44ad;
    }
    /* Error message */
    .error {
      color: #e74c3c;
      margin-bottom: 1rem;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>
  <div class="login-container">
  <h2> CÔNG TY FLYBEEMOVE </h2>
  <img src="../admin/img/admin1.png" alt="Logo" style="display:block; margin: 0 auto -19px; max-width: 300px;">
  <h3> ADMIN - NHÂN VIÊN </h3>
    <h2> Đăng nhập</h2>
    <?php if (!empty($error)): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post">
      <div class="input-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="input-group">
        <label for="password">Mật khẩu</label>
        <input type="password" id="password" name="password" required>
      </div>
      <button type="submit">Đăng nhập</button>
    </form>
  </div>
</body>
</html>
