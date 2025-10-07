<?php
require_once __DIR__ . "/../../../model/Cart.php";
$pdo = Database::getConnection();
$cart = new Cart($pdo);
$userId = $_SESSION['user']['id'] ?? null;
$totalItems = $userId ? $cart->getTotalItems($userId) : 0;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>WatchShop</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        /* Navbar hiện đại */
        .navbar {
            background: linear-gradient(90deg, #4facfe, #00c6ff);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.6rem;
            color: #fff !important;
        }

        .nav-link {
            color: #fff !important;
            font-weight: 500;
            margin-right: 1rem;
            transition: all 0.3s ease;
        }
        .nav-link:hover {
            color: #ffe57f !important;
        }

        /* Nút tìm kiếm */
        .form-control {
            border-radius: 25px;
            padding: 0.4rem 1rem;
        }
        .btn-outline-light {
            border-radius: 25px;
            border-color: #fff;
            color: #fff;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-outline-light:hover {
            background: #fff;
            color: #00c6ff;
        }

        /* Giỏ hàng */
        .fa-shopping-cart {
            margin-right: 5px;
        }
        .badge {
            font-size: 0.75rem;
            padding: 0.4rem 0.6rem;
            border-radius: 50%;
        }

        /* Admin Button */
        .btn-warning {
            font-weight: 600;
            border-radius: 25px;
            padding: 0.3rem 0.8rem;
        }
        .btn-warning:hover {
            background-color: #f8c146;
        }

        /* Responsive logo spacing */
        @media (max-width: 768px) {
            .nav-link {
                margin-right: 0;
                margin-bottom: 0.5rem;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand" href="/php-pj/home">
            <i class="fa-solid fa-clock"></i> WatchShop
        </a>

        <!-- Toggle cho mobile -->
        <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="navbarNav">

            <!-- Menu trái -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/php-pj/order">
                        <i class="fa-solid fa-box"></i> Đơn hàng
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/php-pj/getProducts">
                        <i class="fa-solid fa-list"></i> Sản phẩm
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link position-relative" href="/php-pj/cart">
                        <i class="fa fa-shopping-cart"></i> Giỏ hàng
                        <?php if ($totalItems > 0): ?>
                            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                                <?= $totalItems ?>
                            </span>
                        <?php endif; ?>
                    </a>
                </li>
            </ul>

            <!-- Form tìm kiếm -->
            <form class="d-flex me-3" method="get" action="/php-pj/home">
                <input type="hidden" name="action" value="home">
                <input class="form-control me-2" type="text" name="keyword" placeholder="Tìm kiếm..."
                       value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
                <button class="btn btn-outline-light" type="submit">
                    <i class="fa fa-search"></i>
                </button>
            </form>

            <!-- User menu -->
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['user'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/php-pj/logout/">
                            <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="/php-pj/editProfile">
                            <i class="fa-solid fa-user"></i> Chào, <?= htmlspecialchars($_SESSION['user']['username']) ?>
                        </a>
                    </li>

                    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                        <li class="nav-item ms-2">
                            <a href="/php-pj/homeAdmin" class="btn btn-warning btn-sm">
                                <i class="fas fa-user-shield"></i> Admin
                            </a>
                        </li>
                    <?php endif; ?>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/php-pj/login">
                            <i class="fa-solid fa-right-to-bracket"></i> Đăng nhập
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>



