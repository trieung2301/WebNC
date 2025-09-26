<?php
    if(isset($_SESSION['user']))
    {
        header("Location: /php-pj/index.php?action=home");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-4" style="width: 350px;">
        <h3 class="text-center mb-3">Đăng nhập</h3>

        <?php if (isset($_SESSION['login-error'])): ?> <!--Kiểm tra thông báo lỗi đã lưu-->
            <div class="alert alert-danger text-center py-2">
                <?= htmlspecialchars($_SESSION['login-error']) ?><!--Chuyển đổi lỗi thành văn bản html-->
            </div>
            <?php unset($_SESSION['login-error']); ?><!--Xóa thông báo lỗi sau khi hiển thị-->
        <?php endif; ?>

        <form method="post" action="index.php?action=login">
            <div class="mb-3">
                <label for="username" class="form-label">Tài khoản</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Nhập tài khoản" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
        </form>

        <!-- Link chuyển qua đăng ký -->
        <p class="text-center mt-3 mb-0">
            Chưa có tài khoản? <a href="index.php?action=register">Đăng ký</a>
        </p>
    </div>
</div>
</body>
</html>
