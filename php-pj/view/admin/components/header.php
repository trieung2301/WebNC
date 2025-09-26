<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <!-- Logo -->
    <a class="navbar-brand fw-bold" href="index.php?controller=dashboard&action=index">
      🛠 Admin Panel
    </a>

    <!-- Nút thu gọn khi mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu -->
    <div class="collapse navbar-collapse" id="adminNavbar">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="index.php?controller=category&action=index">📂 Danh mục</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?controller=product&action=index">📦 Sản phẩm</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?controller=user&action=index">👤 Người dùng</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?controller=order&action=index">🧾 Đơn hàng</a>
        </li>
      </ul>

      <!-- User info -->
      <div class="d-flex">
        <span class="navbar-text text-white me-3">
          Xin chào, Admin
        </span>
        <a href="logout.php" class="btn btn-outline-light btn-sm">Đăng xuất</a>
      </div>
    </div>
  </div>
</nav>
