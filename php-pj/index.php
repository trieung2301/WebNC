<?php
session_start();

require_once __DIR__ . "/model/Database.php";
require_once __DIR__ . "/model/User.php";
require_once __DIR__ . "/model/Product.php";
require_once __DIR__ . "/controller/site/AuthController.php";
require_once __DIR__ . "/controller/site/HomeController.php";
require_once __DIR__ . "/controller/admin/AdminController.php";
require_once __DIR__ . "/controller/admin/UserActionController.php"; // <--- THÊM DÒNG NÀY

$pdo = Database::getConnection(); 
$userModel = new User($pdo); 
$authController = new AuthController($userModel); 
$action = $_GET['action'] ?? 'home';
$productsModel = new Product($pdo);
$homeController = new HomeController($productsModel);

// Khởi tạo Admin Controllers
$adminController = new AdminController($userModel, $productsModel);
$userActionController = new UserActionController($userModel); // <--- KHỞI TẠO CONTROLLER MỚI

switch ($action) {
    case 'login':
        $authController->login();
        break;
    case 'home':
        $homeController->home();
        break;
    case 'logout':
        $authController->logout();
        break;
    case 'register':
        $authController->register();
        break;
    // case mới của admin
    case 'admin/users/change_password':
        $adminController->changePassword();
        break;
    case 'admin/dashboard': 
        $adminController->dashboard();
        break;
    case 'admin/products':
        $adminController->manageProducts();
        break;
    case 'admin/users':
        $adminController->manageUsers();
        break;
    case 'admin/users/add':
        $userActionController->addUser();
        break;
    case 'admin/users/delete':
        $userActionController->deleteUser();
        break;
    case 'admin/users/change_role':
        $userActionController->changeUserRole();
        break;
    case 'admin/users/toggle_status':
        $userActionController->toggleUserStatus();
        break;
    default:
        header("Location: /php-pj/index.php?action=home");
        exit;
}