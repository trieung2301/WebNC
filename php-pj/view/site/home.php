<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang chủ E-commerce</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome (icon) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">E-Shop</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="#">Trang chủ</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Sản phẩm</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Giỏ hàng <i class="fa fa-shopping-cart"></i></a></li>
        <li class="nav-item"><a class="nav-link" href="/php-pj/index.php?action=logout">Đăng xuất</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Banner -->
<header class="bg-primary text-white text-center py-5">
  <div class="container">
    <h1>Xin chào, <?= htmlspecialchars($_SESSION['user']['username']) ?></h1>
    <p class="lead">Chào mừng bạn đến với cửa hàng trực tuyến của chúng tôi</p>
    <a href="#" class="btn btn-light btn-lg">Mua ngay</a>
  </div>
</header>

<!-- Danh mục sản phẩm -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">Sản phẩm nổi bật</h2>
        <div class="row g-4">
            <?php if (!empty($products) && is_array($products)): ?>
                <?php foreach ($products as $pd): ?>
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <img src="/php-pj/view/image/<?= htmlspecialchars($pd['image']); ?>" class="card-img-top" alt="Sản phẩm 1">
                            <div class="card-body text-center">
                                <h5 class="card-title"><?= htmlspecialchars($pd['name']) ?></h5>
                                <p class="card-text text-danger fw-bold"><?= htmlspecialchars($pd['price']) ?></p>
                                <a href="#" class="btn btn-primary">Mua ngay</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="mt-5">Hiện không có sản phẩm nào để hiển thị.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3">
  <p class="mb-0">&copy; 2025 E-Shop. All rights reserved.</p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
