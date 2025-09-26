<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { min-height: 100vh; display: flex; flex-direction: column; }
        .wrapper { display: flex; flex: 1; }
        .sidebar { width: 250px; background-color: #343a40; min-height: 100vh; position: sticky; top: 0; }
        .main-content { flex: 1; padding: 20px; }
        .sidebar .nav-link { color: rgba(255, 255, 255, 0.75); }
        .sidebar .nav-link.active { color: #fff; background-color: rgba(255, 255, 255, 0.1); }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/php-pj/index.php?action=admin/dashboard">Trang chủ Admin</a>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link">
                        <i class="fa-solid fa-user-circle"></i>
                        <?php echo htmlspecialchars($_SESSION['user']['username']); ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/php-pj/index.php?action=logout">Đăng xuất</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="wrapper">
    <div class="sidebar text-white p-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="/php-pj/index.php?action=admin/dashboard">
                    <i class="fa-solid fa-tachometer-alt"></i> Trang chủ
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/php-pj/index.php?action=admin/users">
                    <i class="fa-solid fa-users"></i> Quản lý người dùng
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/php-pj/index.php?action=admin/products">
                    <i class="fa-solid fa-box-open"></i> Quản lý sản phẩm
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/php-pj/index.php?action=admin/orders">
                    <i class="fa-solid fa-shopping-cart"></i> Quản lý đơn hàng
                </a>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <h1 class="mb-4">Tổng quan</h1>
        <p>Chào mừng bạn đã trở lại, **<?php echo htmlspecialchars($_SESSION['user']['username']); ?>**!</p>

        <div class="row g-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Tổng người dùng</h5>
                                <h3><?php echo htmlspecialchars($totalUsers); ?></h3>
                            </div>
                            <i class="fa-solid fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Tổng sản phẩm</h5>
                                <h3>50</h3>
                            </div>
                            <i class="fa-solid fa-box fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-dark">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Tổng đơn hàng</h5>
                                <h3>120</h3>
                            </div>
                            <i class="fa-solid fa-shopping-cart fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <h2 class="mt-5 mb-3">Đơn hàng gần đây</h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Khách hàng</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Nguyễn Văn A</td>
                        <td>500,000đ</td>
                        <td><span class="badge bg-success">Đã giao</span></td>
                    </tr>
                    </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>