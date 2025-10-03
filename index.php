<?php
session_start();
//model
require_once __DIR__ . "/model/Database.php";
require_once __DIR__ . "/model/User.php";
require_once __DIR__ . "/model/Product.php";
require_once __DIR__ . "/model/Category.php";
require_once __DIR__ . "/model/Rating.php";
require_once __DIR__ . "/model/Order.php";
require_once __DIR__ . "/model/OrderItems.php";
require_once __DIR__ . "/model/Coupon.php";
require_once __DIR__ . "/model/CouponUsage.php";
require_once __DIR__ . "/model/Comments.php";
require_once __DIR__ . "/model/Cart.php";

//controller Site
require_once __DIR__ . "/controller/site/ProductController.php";
require_once __DIR__ . "/controller/site/AuthController.php";
require_once __DIR__ . "/controller/site/HomeController.php";
require_once __DIR__ . "/controller/site/CategoryController.php";
require_once __DIR__ . "/controller/site/CartController.php";
require_once __DIR__ . "/controller/site/OrderController.php";
require_once __DIR__ . "/controller/site/CheckoutController.php";

//controller Admin (Added from the first file)
require_once __DIR__ . "/controller/admin/HomeAdminController.php";
require_once __DIR__ . "/controller/admin/ProductAdminController.php";
require_once __DIR__ . "/controller/admin/UserAdminController.php";
require_once __DIR__ . "/controller/admin/StaffAdminController.php";
require_once __DIR__ . "/controller/admin/OrderAdminController.php";
require_once __DIR__ . "/controller/admin/DiscountAdminController.php";

$pdo = Database::getConnection();

//model
$userModel = new User($pdo);
$productsModel =new Product($pdo);
$categoryModel = new Category($pdo);
$ratingModel= new Rating($pdo);
$orderModel= new Order($pdo);
$orderItemsModel= new OrderItems($pdo);
$couponModel= new Coupon($pdo);
$couponUsageModel= new CouponUsage($pdo);
$commentsModel= new Comments($pdo);
$cartModel= new Cart($pdo);

//controller Site
$authController = new AuthController($userModel);
$homeController = new HomeController($productsModel,$categoryModel);
$productController = new ProductController($productsModel,$ratingModel,$commentsModel);
$categoryController = new CategoryController($categoryModel);
$cartController= new CartController($cartModel,$productsModel);
$orderController= new OrderController($orderModel,$productsModel,$orderItemsModel);
$checkoutController= new CheckoutController($cartModel,$orderModel,$productsModel,$orderItemsModel,$couponModel,$couponUsageModel);

//controller Admin (Added from the first file)
$homeAdminController = new HomeAdminController($userModel, $productsModel, $orderModel);
$productAdminController = new ProductAdminController($productsModel, $categoryModel);
$userAdminController = new UserAdminController($userModel);
$staffAdminController = new StaffAdminController($userModel);
$orderAdminController = new OrderAdminController($orderModel, $userModel);
$discountAdminController = new DiscountAdminController($couponModel);

$action = $_GET['action'] ?? 'home';
switch ($action) {
    //========================================== SITE ROUTES ==========================================//
    case 'login':
        $authController->login();
        break;
    case 'home':
        $homeController->home();
        $cartController->add();
        break;
    case 'logout':
        $authController->logout();
        break;
    case 'register':
        $authController->register();
        break;
    case 'getProducts':
        $products = $productController->getAll();  // Lấy danh sách sản phẩm
        $categories = $categoryController->getAll();  // Lấy danh sách danh mục
        $cate_id=$_GET['category'] ?? 'all';// lấy ra id của cate từ frontend
        if($cate_id==='all')
        {
            $products = $productController->getAll();
        }
        else{
            $products = $productController->getProductCategory($cate_id);
        }
        include __DIR__ . '/view/site/products.php';
        $cartController->add();
        break;
    case 'productDetails':
        $productController->productDetails();
        $cartController->add();
        break;
    case 'cart':
        $cartController->index();
        break;
    case 'order':
        $orderController->index();
        break;
    case 'checkout':
        $checkoutController->index();
        break;
    case 'error':
        include __DIR__ . '/view/site/404.php';
        break;
    case 'success':
        include __DIR__ . '/view/site/success.php';
        break;

    //========================================== ADMIN ROUTES (Added from the first file) ==========================================//
    case 'homeAdmin':
        $homeAdminController->homeAdmin();
        break;

    // QUẢN LÝ KHÁCH HÀNG
    case 'admin/users':
        $userAdminController->getUsers();
        break;
    case 'admin/users/edit':
        $userAdminController->editUser();
        break;
    case 'admin/users/update':
        $userAdminController->updateUser();
        break;
    case 'admin/users/add':
        $userAdminController->createUser();
        break;
    case 'admin/users/addUser':
        $userAdminController->addUser();
        break;
    case 'admin/users/toggleStatus':
        $userAdminController->toggleStatus();
        break;
    case 'admin/users/changePassword':
        $userAdminController->changePassword();
        break;
    case 'admin/users/delete':
        $userAdminController->deleteUser();
        break;

    // QUẢN LÝ NHÂN VIÊN & ADMIN
    case 'admin/staff':
        $staffAdminController->getStaff();
        break;
    case 'admin/staff/add':
        $staffAdminController->createStaff();
        break;
    case 'admin/staff/addStaff':
        $staffAdminController->addStaff();
        break;
    case 'admin/staff/edit':
        $staffAdminController->editStaff();
        break;
    case 'admin/staff/update':
        $staffAdminController->updateStaff();
        break;
    case 'admin/staff/toggleStatus':
        $staffAdminController->toggleStaffStatus();
        break;
    case 'admin/staff/changePassword':
        $staffAdminController->changeStaffPassword();
        break;
    case 'admin/staff/delete':
        $staffAdminController->deleteStaff();
        break;

    // QUẢN LÝ SẢN PHẨM
    case 'admin/products':
        $productAdminController->manageProducts();
        break;
    case 'admin/addProduct':
        $productAdminController->addProductForm();
        break;
    case 'admin/addProduct/submit':
        $productAdminController->addProduct();
        break;
    case 'admin/deleteProduct':
        $productAdminController->deleteProduct();
        break;
    case 'admin/editProduct':
        $productAdminController->editProduct();
        break;
    case 'admin/updateProduct':
        $productAdminController->updateProduct();
        break;

    // QUẢN LÝ ĐƠN HÀNG (ORDER)
    case 'admin/orders':
        $orderAdminController->getOrders();
        break;

    case 'admin/orders/detail':
        $orderAdminController->viewOrderDetail();
        break;

    case 'admin/orders/updateStatus':
        $orderAdminController->updateOrderStatus();
        break;

    // Quản lý GIẢM GIÁ (Coupons)
    case 'admin/discounts':
        $discountAdminController->getCoupon();
        break;
    case 'admin/discounts/add':
        $discountAdminController->add();
        break;
    case 'admin/discounts/update':
        $discountAdminController->update();
        break;
    case 'admin/discounts/toggleStatus':
        $discountAdminController->toggleStatus();
        break;

    default:
        header("Location: index.php?action=home");
        exit;
}