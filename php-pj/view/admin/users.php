<?php 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Người dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { min-height: 100vh; display: flex; flex-direction: column; }
        .wrapper { display: flex; flex: 1; }
        .sidebar { width: 250px; background-color: #343a40; min-height: 100vh; position: sticky; top: 0; }
        .main-content { flex: 1; padding: 20px; }
        .sidebar .nav-link { color: rgba(255, 255, 255, 0.75); }
        .sidebar .nav-link[href*="admin/users"] { color: #fff; background-color: rgba(255, 255, 255, 0.1); }
        .status-toggle-btn { 
            width: 100px;
            font-size: 0.85rem;
            font-weight: bold;
        }
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
                        <?php echo htmlspecialchars($_SESSION['user']['username'] ?? 'Admin'); ?>
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
                <a class="nav-link" href="/php-pj/index.php?action=admin/dashboard">
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
        <h1 class="mb-4">Quản lý Người dùng</h1>
        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Danh sách người dùng</h3>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fa-solid fa-plus"></i> Thêm người dùng mới
            </button>
        </div>

        <form class="mb-4" action="/php-pj/index.php" method="GET">
            <input type="hidden" name="action" value="admin/users">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Tìm kiếm theo Họ tên, Tên đăng nhập hoặc Email..." name="search" value="<?php echo htmlspecialchars($searchTerm ?? ''); ?>">
                <button class="btn btn-outline-secondary" type="submit">Tìm kiếm</button>
                <?php if (!empty($searchTerm)): ?>
                    <a href="/php-pj/index.php?action=admin/users" class="btn btn-outline-danger">Xóa tìm kiếm</a>
                <?php endif; ?>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Họ tên</th>
                        <th>Tên đăng nhập</th>
                        <th>Email</th>
                        <th>Vai trò</th>
                        <th>Mật khẩu</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['id']); ?></td>
                                <td><?php echo htmlspecialchars($user['fullname'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td>
                                    <form action="/php-pj/index.php?action=admin/users/change_role" method="POST" style="display:inline;">
                                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['id']); ?>">
                                        <select name="new_role" onchange="this.form.submit()" class="form-select form-select-sm" 
                                            <?php echo ($user['id'] == ($_SESSION['user']['id'] ?? 0)) ? 'disabled' : ''; ?>>
                                            <option value="user" <?php echo ($user['role'] === 'user' ? 'selected' : ''); ?>>User</option>
                                            <option value="admin" <?php echo ($user['role'] === 'admin' ? 'selected' : ''); ?>>Admin</option>
                                        </select>
                                    </form>
                                </td>
                                
                                <td>
                                    <button class="btn btn-info btn-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#changePasswordModal"
                                            data-bs-id="<?php echo $user['id']; ?>"
                                            data-bs-username="<?php echo htmlspecialchars($user['username']); ?>">
                                        Đổi mật khẩu
                                    </button>
                                </td>
                                
                                <td>
                                    <?php 
                                    $status_is_active = ($user['status'] ?? 1) == 1;
                                    $toggle_text = $status_is_active ? 'Hoạt động' : 'Đang khóa';
                                    $toggle_class = $status_is_active ? 'btn-success' : 'btn-warning';
                                    $next_status = $status_is_active ? 0 : 1;
                                    $confirm_message = $status_is_active ? 'khóa' : 'mở khóa';
                                    $is_self = ($user['id'] == ($_SESSION['user']['id'] ?? 0));
                                    ?>
                                    
                                    <a href="/php-pj/index.php?action=admin/users/toggle_status&id=<?php echo $user['id']; ?>&status=<?php echo $next_status; ?>" 
                                       class="btn btn-sm status-toggle-btn <?php echo $toggle_class; ?>"
                                       onclick="return confirm('Bạn có chắc chắn muốn <?php echo $confirm_message; ?> người dùng <?php echo htmlspecialchars($user['username']); ?>?');"
                                       <?php echo $is_self ? 'disabled' : '';?>>
                                        <?php echo $toggle_text; ?>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">Không tìm thấy người dùng nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Thêm Người Dùng Mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/php-pj/index.php?action=admin/users/add" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Họ và tên</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Tên đăng nhập</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="phone" name="phone">
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Vai trò</label>
                        <select class="form-select" id="role" name="role">
                            <option value="user" selected>User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary">Thêm Người Dùng</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changePasswordModalLabel">Đổi Mật Khẩu cho <span id="modalUsername"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="changePasswordForm" action="/php-pj/index.php?action=admin/users/change_password" method="POST">
        <div class="modal-body">
            <input type="hidden" name="user_id" id="changePasswordUserId">
            <div class="mb-3">
                <label for="new_password" class="form-label">Mật khẩu mới</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_new_password" class="form-label">Xác nhận mật khẩu mới</label>
                <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" required>
            </div>
            <p class="text-danger" id="passwordMatchError" style="display:none;">Mật khẩu xác nhận không khớp!</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
          <button type="submit" class="btn btn-primary" id="submitPasswordChange">Đổi Mật Khẩu</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Xử lý Modal Đổi Mật Khẩu
    document.addEventListener('DOMContentLoaded', function () {
        var changePasswordModal = document.getElementById('changePasswordModal');
        changePasswordModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var userId = button.getAttribute('data-bs-id');
            var username = button.getAttribute('data-bs-username');
            
            var modalUserIdInput = changePasswordModal.querySelector('#changePasswordUserId');
            var modalUsernameSpan = changePasswordModal.querySelector('#modalUsername');

            modalUserIdInput.value = userId;
            modalUsernameSpan.textContent = username;
            
            // Đặt lại các trường mật khẩu và lỗi khi mở modal
            document.getElementById('new_password').value = '';
            document.getElementById('confirm_new_password').value = '';
            document.getElementById('passwordMatchError').style.display = 'none';
        });

        // Kiểm tra mật khẩu khớp trước khi gửi form
        const form = document.getElementById('changePasswordForm');
        form.addEventListener('submit', function (e) {
            const newPass = document.getElementById('new_password').value;
            const confirmPass = document.getElementById('confirm_new_password').value;
            const errorElement = document.getElementById('passwordMatchError');

            if (newPass !== confirmPass) {
                e.preventDefault();
                errorElement.style.display = 'block';
            } else {
                errorElement.style.display = 'none';
            }
        });
    });
</script>
</body>
</html>