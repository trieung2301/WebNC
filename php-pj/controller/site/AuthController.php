<?php
require_once __DIR__ . "/../../model/User.php";

class AuthController {
    private User $userModel;

    public function __construct(User $userModel) {
        $this->userModel = $userModel;
    }

    public function login(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if (empty($username) || empty($password)){
                $_SESSION['error'] = "Vui lòng nhập đầy đủ thông tin!";
                header("Location: /php-pj/index.php?action=login");
                exit;
            }
    
            $userFromDB = $this->userModel->findByUsername($username);
    
            if ($userFromDB && password_verify($password, $userFromDB['password'])) {
                
                // Kiểm tra trạng thái
                if (($userFromDB['status'] ?? 1) == 0) {
                    $_SESSION['login-error'] = "Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên!";
                    header("Location: /php-pj/index.php?action=login");
                    exit;
                }

                // Cập nhật session để lưu các thông tin cần thiết
                $_SESSION['user'] = [
                    'id' => $userFromDB['id'], 
                    'username' => $userFromDB['username'],
                    'role' => $userFromDB['role']
                ]; 
                
                $_SESSION['login-success'] = "Đăng nhập thành công!"; 
    
                // Kiểm tra quyền và chuyển hướng
                if ($userFromDB['role'] === 'admin') {
                    header("Location: /php-pj/index.php?action=admin/dashboard");
                } else {
                    header("Location: /php-pj/index.php?action=home");
                }
                exit;
            } else {
                $_SESSION['login-error'] = "Sai tên đăng nhập hoặc mật khẩu!";
            }
        }
        include __DIR__ . "/../../view/site/login.php";
    }

    // Phương thức dashboard 
    public function dashboard(): void {
        // Kiểm tra xem người dùng đã đăng nhập và có phải admin không
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: /php-pj/index.php?action=login");
            exit;
        }
        
        // Nếu là admin, hiển thị trang dashboard
        include __DIR__ . "/../../view/admin/dashboard.php";
    }

    // Phương thức logout 
    public function logout(): void {
        session_unset();
        session_destroy();
        header("Location: /php-pj/index.php?action=login");
        exit;
    }

    // Phương thức register
    public function register(): void {
        if($_SERVER['REQUEST_METHOD']=='POST') {
            $fullname=$_POST['fullname']??'';
            $username=$_POST['username']??'';
            $phone=$_POST['phone']??'';
            $email=$_POST['email']??'';
            $password=$_POST['password']??'';
            $confirmPassword=$_POST['confirm_password']??'';

            if($password != $confirmPassword) {
                $_SESSION['regis-error']="Mật khẩu không khớp!";
                header("Location: /php-pj/index.php?action=register");
                exit;
            }
            if ($this->userModel->findByUsername($username)) {
                $_SESSION['regis-error'] = "Username đã tồn tại!";
                header("Location: /php-pj/index.php?action=register");
                exit;
            }

            $result =$this->userModel->register([
                'fullname'=> $fullname, 'username'=> $username, 'phone'=> $phone, 'email'=> $email, 'password'=> $password, 'role'=>'user'
            ]);

            if($result) {
                header('location: /php-pj/index.php?action=login');
            } else {
                $_SESSION['regis-error']='Thất bại';
                header('location: /php-pj/index.php?action=register');
            }
        }
        include __DIR__ . "/../../view/site/register.php";  
    }
}