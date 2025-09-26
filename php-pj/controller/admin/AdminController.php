<?php
require_once __DIR__ . "/../../model/User.php";
require_once __DIR__ . "/../../model/Product.php";

class AdminController {
    private $userModel;
    private $productModel;

    public function __construct(User $userModel, Product $productModel) {
        $this->userModel = $userModel;
        $this->productModel = $productModel;
    }

    private function adminCheck(): void {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? 'user') !== 'admin') {
            header("Location: /php-pj/index.php?action=login");
            exit;
        }
    }
    
    public function dashboard() {
        $this->adminCheck();
        
        // Lấy tổng số người dùng
        $totalUsers = $this->userModel->countAll(); 
        
        // Tổng sản phẩm và đơn hàng sửa sau
        $totalProducts = 50; 
        $totalOrders = 120;
        
        $recentOrders = [
            ['id' => 1, 'customer' => 'Nguyễn Văn A', 'total' => '500,000đ', 'status' => 'Đã giao'],
            ['id' => 2, 'customer' => 'Trần Thị B', 'total' => '850,000đ', 'status' => 'Đang xử lý'],
        ];

        include __DIR__ . "/../../view/admin/dashboard.php";
    }

    public function manageProducts() {
        $this->adminCheck();
    }

    public function manageUsers() {
        $this->adminCheck();
        // Lấy từ khóa tìm kiếm từ URL (hoặc rỗng nếu không có)
        $searchTerm = $_GET['search'] ?? '';
        $users = $this->userModel->searchUsers($searchTerm); 
        
        // Biến $searchTerm cũng được truyền qua view để giữ lại từ khóa tìm kiếm trên thanh search
        include __DIR__ . "/../../view/admin/users.php";
    }

    public function changePassword() {
        $this->adminCheck(); // Kiểm tra quyền admin
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id'] ?? 0;
            $newPassword = $_POST['new_password'] ?? '';

            // Xử lý logic đổi mật khẩu:
            if ($userId && !empty($newPassword)) {
                $result = $this->userModel->updatePassword($userId, $newPassword); 
                // Bạn cần định nghĩa phương thức updatePassword trong model/User.php

                if ($result) {
                    $_SESSION['success'] = "Đổi mật khẩu thành công!";
                } else {
                    $_SESSION['error'] = "Lỗi đổi mật khẩu!";
                }
            }
        }
        header("Location: /php-pj/index.php?action=admin/users");
        exit;
    }
}