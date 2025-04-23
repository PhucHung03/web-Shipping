<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="./public/css/bootstrap.min.css">
    <link rel="stylesheet" href="./public/css/font-awesome.min.css">
    <link rel="stylesheet" href="./public/css/style.css">

    <!-- link -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>

<body>
    <!-- Navigation -->
    <div class="danhMuc">
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    <img src="./public/img/logo flybee.png" alt="Logo" height="40">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?url=trangchu">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?url=tracking">Theo dõi vận đơn</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?url=create-shipment">Giao Hàng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?url=manager-shipment">Quản lí đơn hàng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?url=contact">Liên Hệ</a>
                        </li>
                    </ul>
                    <div class="d-flex">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="index.php?url=profile" class="btn btn-outline-primary me-2">
                                <i class="fas fa-user"></i> <?php echo $_SESSION['username']; ?>
                            </a>
                            <a href="index.php?url=logout" class="btn btn-outline-danger">Đăng xuất</a>
                        <?php else: ?>
                            <a href="index.php?url=login" class="btn btn-outline-primary me-2">Đăng nhập</a>
                            <a href="index.php?url=register" class="btn btn-primary">Đăng kí</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </div>