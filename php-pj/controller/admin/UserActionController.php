<?php
require_once __DIR__ . "/../../model/User.php";

class UserActionController {
    private User $userModel;

    public function __construct(User $userModel) {
        $this->userModel = $userModel;
    }

    // Kiểm tra quyền admin và chuyển hướng nếu không phải admin
    private function adminCheck(): void {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? 'user') !== 'admin') {
            header("Location: /php-pj/index.php?action=login");
            exit;
        }
    }

    // Phương thức thêm người dùng
    public function addUser(): void {
        $this->adminCheck();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userData = $_POST;
            if (!empty($userData['username']) && !empty($userData['password'])) {
                $this->userModel->register($userData);
            }
            header("Location: /php-pj/index.php?action=admin/users");
            exit;
        }
        header("Location: /php-pj/index.php?action=admin/users");
        exit;
    }

    // Phương thức đổi role
    public function changeUserRole(): void {
        $this->adminCheck();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['user_id'] ?? 0);
            $newRole = $_POST['new_role'] ?? '';

            if ($id > 0 && in_array($newRole, ['user', 'admin'])) {
                 // Không cho phép hạ quyền tài khoản của chính mình
                 if ($id != $_SESSION['user']['id'] || $newRole == 'admin') {
                     $this->userModel->updateRole($id, $newRole);
                 }
            }
        }
        header("Location: /php-pj/index.php?action=admin/users");
        exit;
    }

    // Phương thức khoá user
    public function toggleUserStatus(): void {
        $this->adminCheck();
        $id = (int)($_GET['id'] ?? 0);
        $status = (int)($_GET['status'] ?? 0); // Status mới (0: khóa, 1: mở khóa)

        // Không khóa tài khoản admin khi đang đăng nhập
        if ($id > 0 && isset($_SESSION['user']) && $id != $_SESSION['user']['id']) {
            $this->userModel->updateStatus($id, $status);
        }

        header("Location: /php-pj/index.php?action=admin/users");
        exit;
    }
}