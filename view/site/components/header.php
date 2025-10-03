<?php
require_once __DIR__ . "/../../../model/Cart.php";
$pdo = Database::getConnection();
$cart = new Cart($pdo);
$userId=$_SESSION['user']['id'];
$totalItems= $cart->getTotalItems($userId);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang chủ WatchShop</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        /* Giới hạn chiều rộng trang */
        .custom-container {
            max-width: 70%;
            margin: 0 auto;
        }

        /* Ảnh carousel */
        .carousel-inner img {
            height: 400px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<!-- Navbar với ô tìm kiếm -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">

    <!-- Logo -->
    <a class="navbar-brand fw-bold" href="index.php?action=home">WatchShop</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">

      <!-- Menu trái -->
      <ul class="navbar-nav me-auto">
          <li class="nav-item">
              <a class="nav-link" href="index.php?action=order">Đơn hàng</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="index.php?action=getProducts">Sản phẩm</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="index.php?action=cart">
                  Giỏ hàng <i class="fa fa-shopping-cart"></i>
                  <span class="badge bg-danger">
                      <?= $totalItems ?>
                  </span>
              </a>
          </li>
      </ul>

      <!-- Ô tìm kiếm trên navbar -->
      <form class="d-flex me-3" method="get" action="index.php">
        <input type="hidden" name="action" value="home">
        <input class="form-control me-2" type="text" name="keyword" placeholder="Tìm kiếm..."
               value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
        <button class="btn btn-outline-light" type="submit">Tìm</button>
      </form>

      <!-- User -->
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="index.php?action=logout">Đăng xuất</a></li>
        <li class="nav-item">
          <span class="nav-link text-light">
            Chào, <?= htmlspecialchars($_SESSION['user']['username'] ?? 'Khách') ?>
          </span>
        </li>
        <ul class="navbar-nav">
        <?php 
        // Kiểm tra và chỉ hiển thị nút nếu vai trò là 'admin'
        if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): 
        ?>
          <li class="nav-item ms-2">
            <a href="index.php?action=homeAdmin" class="btn btn-warning btn-sm">
                <i class="fas fa-user-shield"></i> Admin
            </a>
          </li>
        <?php endif; ?>

      </ul>

    </div>
  </div>
</nav>