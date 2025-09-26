<?php
include "../../model/User.php";

class UserController {

    private User $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    /** ------------------- LOGIN ------------------- */
    public function login(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $this->userModel->setUsername($username);
            $this->userModel->setPassword($password);

            $user = $this->userModel->login();

            if ($user) {
                session_start();
                $_SESSION['user'] = $user;
                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Sai username hoặc password!";
                header("Location: login.php?error=" . urlencode($error));
                exit;
            }
        } else {
            include "../views/login.php";
        }
    }

    /** ------------------- REGISTER ------------------- */
    public function register(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->userModel->setFullname($_POST['fullname'] ?? '');
            $this->userModel->setUsername($_POST['username'] ?? '');
            $this->userModel->setEmail($_POST['email'] ?? '');
            $this->userModel->setPassword($_POST['password'] ?? '');
            $this->userModel->setPhone($_POST['phone'] ?? '');
            $this->userModel->setRole($_POST['role'] ?? 'user');

            $this->userModel->register();
            header("Location: login.php?success=" . urlencode("Đăng ký thành công!"));
            exit;
        } else {
            include "../views/register.php";
        }
    }

    /** ------------------- CREATE USER (ADMIN) ------------------- */
    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newUser = new User();
            $newUser->setFullname($_POST['fullname'] ?? '');
            $newUser->setUsername($_POST['username'] ?? '');
            $newUser->setEmail($_POST['email'] ?? '');
            $newUser->setPassword($_POST['password'] ?? '');
            $newUser->setPhone($_POST['phone'] ?? '');
            $newUser->setRole($_POST['role'] ?? 'user');

            $this->userModel->create($newUser);
            header("Location: users.php?success=" . urlencode("Tạo user thành công!"));
            exit;
        } else {
            include "../views/create_user.php";
        }
    }

    /** ------------------- UPDATE USER ------------------- */
    public function update(): void {
        $id = (int)($_GET['id'] ?? 0);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $updateUser = new User();
            $updateUser->setId($id);
            $updateUser->setFullname($_POST['fullname'] ?? '');
            $updateUser->setUsername($_POST['username'] ?? '');
            $updateUser->setEmail($_POST['email'] ?? '');
            $updateUser->setPhone($_POST['phone'] ?? '');
            $updateUser->setRole($_POST['role'] ?? 'user');

            if (!empty($_POST['password'])) {
                $updateUser->setPassword($_POST['password']);
                $this->userModel->update($updateUser);
            } else {
                $this->userModel->updateWithoutPassword($updateUser);
            }

            header("Location: users.php?success=" . urlencode("Cập nhật user thành công!"));
            exit;
        } else {
            $user = $this->userModel->getById($id);
            include "../views/edit_user.php";
        }
    }

    /** ------------------- DELETE USER ------------------- */
    public function delete(): void {
        $id = (int)($_GET['id'] ?? 0);
        $delUser = new User();
        $delUser->setId($id);
        $this->userModel->delete($delUser);

        header("Location: users.php?success=" . urlencode("Xóa user thành công!"));
        exit;
    }

    /** ------------------- LIST USERS ------------------- */
    public function index(): void {
        $users = $this->userModel->getAll();
        include "../views/users.php"; // file hiển thị danh sách
    }

    /** ------------------- GET USER BY ID ------------------- */
    public function getById(): void {
        $id = (int)($_GET['id'] ?? 0);
        $user = $this->userModel->getById($id);
        var_dump($user);
    }

    /** ------------------- COUNT USERS ------------------- */
    public function count(): void {
        $total = $this->userModel->countAll();
        echo "Tổng số user: $total";
    }
}

// Khởi tạo controller và xử lý request
$controller = new UserController();

// Nhận action từ query string, ví dụ ?action=login
$action = $_GET['action'] ?? 'index';

if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    echo "Action không tồn tại!";
}
?>
