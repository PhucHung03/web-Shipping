<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require 'db.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
// Lấy số thông báo chưa đọc
$userId = $_SESSION['user_id'];
$sqlCount = "SELECT COUNT(*) AS cnt FROM thongbao 
             WHERE Id_NhanVien = $userId AND trangThai = 'Chưa đọc'";
$resCount = $mysqli->query($sqlCount);
$rowCount = $resCount->fetch_assoc();
$unreadCount = (int)$rowCount['cnt'];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Quản lý giao hàng</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- 1. Load Bootstrap CSS NGAY ĐẦU -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet">

  <!-- 2. Load Bootstrap Icons nếu dùng -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css"
    rel="stylesheet">
  <!-- Font & CSS cơ bản -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

  <style>
    * { box-sizing: border-box; margin:0; padding:0; }
    body {
      font-family: 'Roboto', sans-serif;
      display: flex;
      min-height: 100vh;
      background: #f4f6f8;
    }
    /* Thanh ngang (topbar) */
    .topbar {
      position: fixed; top: 0; left: 0; right: 0;
      height: 60px;
      background: #0dcaf0;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 1.5rem;
      color: #ecf0f1;
      z-index: 100;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .topbar .logo {
      font-size: 1.25rem; font-weight: 700;
    }
    .topbar .logout {
      text-decoration: none;
      color: #ecf0f1;
      font-weight: 500;
      transition: color .2s;
    }
    .topbar .logout:hover { color: #e74c3c; }

    /* Sidebar trái */
    .sidebar {
      width: 220px;
      padding-top: 60px; /* để tránh đè topbar */
      background: #111212;
      position: fixed;
      top: 0; bottom: 0; left: 0;
      display: flex;
      flex-direction: column;
    }
    .sidebar a {
      color: #ecf0f1;
      padding: .75rem 1rem;
      text-decoration: none;
      transition: background .2s;
    }
    .sidebar a:hover {
      background: #0dcaf0;
    }
    .notification {
      position: relative;
      padding: .75rem 1rem;
      cursor: pointer;
    }
    .notification .bell-icon { font-size: 1.2rem; }
    .notification .count {
      position: absolute; top: 8px; right: 16px;
      background: #e74c3c; color: #fff;
      border-radius: 50%; padding: 2px 6px;
      font-size: .75rem;
    }
    .notification .dropdown-content {
      display: none;
      position: absolute;
      left: -200px;
      top: 50px;
      background: #fff;
      width: 280px;
      max-height: 350px;
      overflow-y: auto;
      box-shadow: 0 8px 16px rgba(0,0,0,0.2);
      z-index: 200;
    }
    .notification .dropdown-content .item {
      padding: .75rem;
      border-bottom: 1px solid #eee;
      color: black;
    }
    .notification .dropdown-content .item:last-child {
      border-bottom: none;
    }

    /* Nội dung chính */
    .main-content {
      margin: 60px 0 0 220px;
      padding: 1.5rem;
      width: calc(100% - 220px);
    }
    hr { border: none; border-top: 1px solid #ccc; margin: 0 0 1rem; }
    .topbar {
  position: fixed; top: 0; left: 0; right: 0;
  height: 60px;
  background: #ff5722;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 1.5rem;
  color: #ecf0f1;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  z-index: 100;
}

/* nhóm notification + logout */
.topbar .actions {
  display: flex;
  align-items: center;
  gap: 1rem;            /* khoảng cách giữa chuông và logout */
}

/* tuỳ chỉnh chuông */
.topbar .notification {
  position: relative;
  cursor: pointer;
}
.topbar .bell-icon {
  font-size: 1.4rem;
}
.topbar .count {
  position: absolute;
  background: #e74c3c;
  color: #fff;
  border-radius: 50%;
  padding: 2px 6px;
  font-size: 0.75rem;
}

/* nút logout */
.topbar .logout {
  text-decoration: none;
  color: #ecf0f1;
  font-weight: 500;
  transition: color .2s;
}
.topbar .logout:hover {
  color: #e74c3c;
}

  </style>
</head>
<body>

  <!-- Topbar -->
  <header class="topbar">
    <div  class="logo">🚚 ADMIN</div>
    <div class="actions">
    <?php if ($_SESSION['role'] === 2): ?>
      <div class="notification" id="notif">
        <span class="bell-icon">🔔</span>
        <?php if($unreadCount > 0): ?>
          <span class="count"><?php echo $unreadCount; ?></span>
        <?php endif; ?>
        <div id="notif-dropdown" class="dropdown-content"></div>
      </div>
    <?php endif; ?>
    <a href="logout.php" class="logout">Đăng xuất</a>
  </div>
  </header>

  <!-- Sidebar -->
  <aside class="sidebar">
    <?php if ($_SESSION['role'] === 1): ?>
      <a href="orders.php">Phân công nhân viên</a>
      <a href="tracking.php">Theo dõi giao hàng</a>
      <a href="lichlamviec.php">Lịch làm việc</a>
      <a href="index.php">Thống kê</a>
    <?php else: ?>
      <a href="my_orders.php">Đơn hàng của tôi</a>
      <a href="donhang_danggiao.php">Đơn hàng đang giao</a>
      
    <?php endif; ?>
  </aside>

  <!-- Nội dung chính -->
  <main class="main-content">
    

  <script>
  document.getElementById('notif').addEventListener('click', function(e) {
    e.stopPropagation();
    const dd = document.getElementById('notif-dropdown');
    if (dd.style.display === 'block') {
      dd.style.display = 'none';
      return;
    }
    fetch('notifications.php')
      .then(res => res.json())
      .then(data => {
        dd.innerHTML = '';
        if (data.length === 0) {
          dd.innerHTML = '<div class="item">Không có thông báo mới</div>';
        } else {
          data.forEach(n => {
            dd.innerHTML += `<div class="item">
                               <p>${n.noiDung}</p>
                               <small>${n.ngayTao}</small>
                             </div>`;
          });
        }
        dd.style.display = 'block';
        const cnt = document.querySelector('.notification .count');
        if (cnt) cnt.remove();
      })
      .catch(console.error);
  });
  window.addEventListener('click', function(e) {
    const dd = document.getElementById('notif-dropdown');
    if (dd.style.display === 'block' && !dd.contains(e.target)) {
      dd.style.display = 'none';
    }
  });
</script>
