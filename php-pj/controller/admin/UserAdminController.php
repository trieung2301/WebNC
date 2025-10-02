<?php
require_once __DIR__ . "/../../model/User.php";

class UserAdminController {
    private User $userModel;

    public function __construct(User $userModel) {
        $this->userModel = $userModel;
    }

    private function adminCheck(): void {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? 'user') !== 'admin') { 
            header("Location: /php-pj/index.php?action=login");
            exit;
        }
    }
    
    public function getUsers(): void { 
        $this->adminCheck();
        $searchTerm = trim($_GET['search'] ?? '');
        $allUsers = $this->userModel->getAll(); 
        $users = [];
        
        foreach ($allUsers as $user) {
            if ($user['role'] === 'user') { 
                $totalSpent = $this->userModel->calculateTotalSpent($user['id']);
                 $newLevel = $this->userModel->determineLevel($totalSpent);
                
                if ($totalSpent !== (float)($user['total_spent'] ?? 0) || $newLevel !== ($user['level'] ?? 'common')) {
                    $this->userModel->updateLevel($user['id'], $totalSpent, $newLevel);
                    $user['total_spent'] = $totalSpent;
                    $user['level'] = $newLevel;
                }

                $isMatch = empty($searchTerm) || 
                           stripos($user['fullname'] ?? '', $searchTerm) !== false || 
                           stripos($user['username'] ?? '', $searchTerm) !== false;
                           
                if ($isMatch) {
                    $users[] = $user;
                }
            }
        }
        
        include __DIR__ . "/../../view/admin/userAdmin.php";
    }

    public function createUser(): void { 
        $this->adminCheck();
        $oldInput = $_SESSION['old_input'] ?? [];
        $error_message = $_SESSION['error_message'] ?? '';
        unset($_SESSION['old_input'], $_SESSION['error_message']);
        $actionUrl = 'admin/users/addUser';
        include __DIR__ . '/../../view/admin/addUser.php';
    }

    public function addUser(): void { 
        $this->adminCheck(); 
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
             header("Location: index.php?action=admin/users");
             exit;
        }

        $userData = [
            'fullname' => trim($_POST['fullname'] ?? ''), 'username' => trim($_POST['username'] ?? ''),
            'email' => trim($_POST['email'] ?? ''), 'password' => $_POST['password'] ?? '',
            'phone' => trim($_POST['phone'] ?? ''), 'role' => 'user', 
        ];
        
        $_SESSION['old_input'] = $userData;
        $errorMessage = '';
        
        if (empty($userData['username']) || empty($userData['password'])) {
            $errorMessage = "Tên đăng nhập và Mật khẩu không được để trống.";
        } elseif ($this->userModel->findByUsername($userData['username'])) {
            $errorMessage = "Tên đăng nhập **{$userData['username']}** đã tồn tại, vui lòng chọn tên khác.";
        } elseif (strlen($userData['password']) < 6) {
            $errorMessage = "Mật khẩu phải có tối thiểu 6 ký tự.";
        } elseif ($userData['password'] !== ($_POST['confirm_password'] ?? '')) {
            $errorMessage = "Lỗi xác nhận: Mật khẩu xác nhận không khớp.";
        }
        
        if (!empty($errorMessage)) {
            $_SESSION['error_message'] = $errorMessage;
            header("Location: index.php?action=admin/users/add"); 
            exit;
        }
        
        if (!$this->userModel->register($userData)) {
            $_SESSION['error_message'] = "Lỗi khi thêm khách hàng vào cơ sở dữ liệu. Vui lòng thử lại.";
            header("Location: index.php?action=admin/users/add"); 
            exit;
        }
        
        $_SESSION['success_message'] = "Thêm khách hàng **{$userData['username']}** thành công! ✅";
        unset($_SESSION['old_input']);
        header("Location: index.php?action=admin/users");
        exit;
    }

    public function editUser(): void {
        $this->adminCheck();
        $id = (int)($_GET['id'] ?? 0);
        $user = $this->userModel->getById($id); 
        
        if (!$user) {
            $_SESSION['error_message'] = "Không tìm thấy người dùng cần chỉnh sửa.";
        } else {
            include __DIR__ . "/../../view/admin/userEdit.php"; 
            return;
        }
        
        header("Location: index.php?action=admin/users"); 
        exit;
    }

    public function updateUser(): void {
        $this->adminCheck();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
             header("Location: index.php?action=admin/users");
             exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        $userOld = $this->userModel->getById($id);
            
        if (!$userOld) {
            $_SESSION['error_message'] = "Không thể cập nhật. Người dùng không tồn tại.";
        } else {
            $userData = [
                'id' => $id, 
                'fullname' => trim($_POST['fullname'] ?? $userOld['fullname']),
                'username' => trim($_POST['username'] ?? $userOld['username']), 
                'email' => trim($_POST['email'] ?? $userOld['email']),
                'phone' => trim($_POST['phone'] ?? $userOld['phone']), 
                'role' => trim($_POST['role'] ?? $userOld['role']), 
            ];
            
            if ($this->userModel->updateInfo($userData)) { 
                $_SESSION['success_message'] = "Cập nhật người dùng ID: {$id} thành công! ✅";
            } else {
                $_SESSION['error_message'] = "Lỗi khi cập nhật người dùng.";
            }
        }
        
        header("Location: index.php?action=admin/users"); 
        exit;
    }

    public function changePassword(): void {
        $this->adminCheck();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
             header("Location: index.php?action=admin/users");
             exit;
        }
        
        $id = (int)($_POST['id'] ?? 0);
        $newPassword = $_POST['new_password'] ?? '';
        $userOld = $this->userModel->getById($id);
            
        if ($id <= 0 || strlen($newPassword) < 6) { 
            $_SESSION['error_message'] = "ID không hợp lệ hoặc mật khẩu quá ngắn.";
        } elseif (!$userOld) {
             $_SESSION['error_message'] = "Không thể đổi mật khẩu. Người dùng không tồn tại.";
        } elseif ($this->userModel->updatePassword($id, $newPassword)) { 
             $_SESSION['success_message'] = "Đổi mật khẩu cho người dùng ID: {$id} thành công! ✅";
        } else {
             $_SESSION['error_message'] = "Lỗi khi cập nhật mật khẩu.";
        }
        
        header("Location: index.php?action=admin/users");
        exit;
    }

    public function toggleStatus(): void {
        $this->adminCheck();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
             header("Location: index.php?action=admin/users");
             exit;
        }
        
        $id = (int)($_POST['id'] ?? 0);
        $currentStatus = (int)($_POST['status'] ?? 0);
            
        if ($id <= 0) {
            $_SESSION['error_message'] = "ID người dùng không hợp lệ.";
        } else {
            $userExists = $this->userModel->getById($id); 
            
            if (!$userExists) {
                $_SESSION['error_message'] = "ID người dùng không tồn tại.";
                header("Location: index.php?action=admin/users");
                exit;
            }

            $newStatus = $currentStatus === 1 ? 0 : 1;
            $actionName = $newStatus === 1 ? 'Khóa' : 'Mở khóa';

            if ($this->userModel->updateStatus($id, $newStatus)) {
                $_SESSION['success_message'] = "{$actionName} tài khoản người dùng ID: {$id} thành công! ✅";
            } else {
                $_SESSION['error_message'] = "Lỗi khi {$actionName} tài khoản người dùng ID: {$id}.";
            }
        }
        
        header("Location: index.php?action=admin/users");
        exit;
    }

    public function deleteUser(): void {
        $this->adminCheck(); 
        $id = (int)($_GET['id'] ?? 0); 

        if ($id <= 0) {
            $_SESSION['error_message'] = "ID người dùng không hợp lệ.";
        } elseif ($this->userModel->delete($id)) { 
            $_SESSION['success_message'] = "Xóa người dùng ID: {$id} thành công! 🗑️";
        } else {
            $_SESSION['error_message'] = "Lỗi khi xóa người dùng ID: {$id}.";
        }
        
        header("Location: index.php?action=admin/users");
        exit;
    }
}