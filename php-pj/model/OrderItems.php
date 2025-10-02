
<?php
//Chi tiết các mặt hàng trong đơn mua
class OrderItems {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Lấy danh sách sản phẩm trong 1 đơn hàng
    public function getOrderItemsByOrderId(int $orderId) {
        $sql = "SELECT order_items.*, products.name,  products.image  FROM order_items JOIN products ON order_items.product_id = products.id WHERE order_items.order_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function addOrderItem($order_id, $product_id, $quantity, $price) {
        $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['order_id' => $order_id,'product_id'=> $product_id,'quantity'=> $quantity,'price' => $price]);
    }
}

?>