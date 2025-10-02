<?php
require_once __DIR__ . "/../../model/Order.php";
require_once __DIR__ . "/../../model/Product.php";
class OrderController {
    private Order $orderModel;
    private Product $productModel;
    private OrderItems $orderItemsModel;
    public function __construct(Order $orderModel, Product $productModel, OrderItems $orderItemsModel ) {
        $this->orderModel = $orderModel; 
        $this->productModel = $productModel;
        $this->orderItemsModel = $orderItemsModel;
    }
    public function index() {
        $user_id= $_SESSION['user']['id'];
        $completedOrders=$this->orderModel->purchaseHistory($user_id);
        $pendingOrders=$this->orderModel->pendingOrder($user_id);
        $cancelledOrders=$this->orderModel->getCancelledOrders($user_id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $order_id = $_POST['order_id'];
            $user_id  = $_SESSION['user']['id'];
            $cancelOrders = $this->orderModel->cancelOrder($order_id,$user_id);
            $item= $this->orderItemsModel->getOrderItemsByOrderId($order_id);
            foreach ($item as $item) {
                $product_id = $item['product_id'];
                $quantity   = $item['quantity'];
                $this->productModel->increaseStock($product_id, $quantity);
            }
            header("Location: /php-pj/index.php?action=order");
        }

        include __DIR__ . "/../../view/site/order.php";
    }

    public function viewOrderDetail(): void {
        $this->adminCheck();

        $orderId = $_GET['id'] ?? null;
        
        if (!$orderId) {
            $_SESSION['error_message'] = "Không tìm thấy ID đơn hàng.";
            header('Location: index.php?action=admin/orders');
            exit;
        }

        // 1. Lấy thông tin đơn hàng (Chỉ từ bảng orders)
        $orderDetail = $this->orderModel->getOrderById($orderId); 
        
        if (!$orderDetail) {
            $_SESSION['error_message'] = "Đơn hàng ID {$orderId} không tồn tại.";
            header('Location: index.php?action=admin/orders');
            exit;
        }
        
        // =========================================================================
        // === FIX LỖI "N/A": TẠO KHÓA TÊN KHÁCH HÀNG (Tài khoản) ===
        // =========================================================================
        
        // Truy vấn bổ sung để lấy tên đầy đủ của tài khoản (từ bảng users)
        $userId = $orderDetail['user_id'] ?? null;
        if ($userId) {
            // Yêu cầu: $this->userModel phải có getUserById() và trả về khóa 'fullname'
            $userInfo = $this->userModel->getUserById($userId); 
            // Gán tên tài khoản vào khóa 'user_name' mà View đang cần
            $orderDetail['user_name'] = $userInfo['fullname'] ?? 'Khách (Tài khoản không rõ)';
        } else {
            $orderDetail['user_name'] = 'Khách (Không đăng nhập)';
        }
        // *Thông tin Người nhận (fullname, phone, address) sẽ được View truy cập trực tiếp.*
        
        // =========================================================================

        // 2. Ánh xạ Trạng thái cho View
        $currentStatusKey = $orderDetail['status'] ?? 'N/A';
        // Đảm bảo $statusText và $badgeColor được khởi tạo
        $statusInfo = self::STATUS_MAP[$currentStatusKey] ?? ['name' => $currentStatusKey, 'class' => 'secondary'];
        $statusText = $statusInfo['name'];
        $badgeColor = $statusInfo['class'];

        // 3. Lấy chi tiết các mặt hàng trong đơn
        global $orderItemsModel; 
        $orderItems = $orderItemsModel->getOrderItemsByOrderId($orderId); 
        
        // 4. Tải View orderDetail.php
        include __DIR__ . '/../../view/admin/orderDetail.php';
    }
}