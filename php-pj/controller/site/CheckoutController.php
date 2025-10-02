<?php
require_once __DIR__ . "/../../model/Cart.php";
require_once __DIR__ . "/../../model/Order.php";
require_once __DIR__ . "/../../model/Product.php";
require_once __DIR__ . "/../../model/OrderItems.php";
require_once __DIR__ . "/../../model/Coupon.php";
require_once __DIR__ . "/../../model/CouponUsage.php";
class CheckoutController {
    private Cart $cartModel;
    private Order $orderModel;
    private Product $productModel;
    private OrderItems $orderItems;
    private Coupon $couponModel;
    private CouponUsage $couponUsageModel;
    public function __construct(Cart $cartModel,Order $orderModel,Product $productModel,OrderItems $orderItems,Coupon $couponModel,CouponUsage $couponUsageModel) {
        $this->cartModel = $cartModel;
        $this->orderModel = $orderModel;
        $this->productModel = $productModel; 
        $this->orderItems = $orderItems;
        $this->couponModel = $couponModel;
        $this->couponUsageModel = $couponUsageModel;
    }
    public function index(){
        if(!isset($_SESSION['user']))
        {
            header('Location: /php-pj/index?action=login');
        }
        $user_id= $_SESSION['user']['id'];
        $cartItems= $this->cartModel->getCartItems($user_id);
        $totalItems= $this->cartModel->getTotalItems($user_id);
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        $discount=0;
        if($totalItems==0)
        {
            header('Location: /php-pj/index');
        }
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $fullname= $_POST['fullname'];
            $email= $_POST['email'];
            $phone= $_POST['phone'];
            $note= $_POST['note'];
            $address= $_POST['address'];
            $district = $_POST['district'];
            $payment_method = $_POST['payment_method'];
            $total= $_POST['total'];
            $city = $_POST['city'];
            $postcode = $_POST['postcode'];
            $coupon =$_POST['coupon'];
            //kiểm tra coupon
            $coupon= $this->couponModel->checkCoupon($coupon);
            if($coupon)
            {
                $couponId= $coupon['id'];
                $check= $this->couponUsageModel->checkUsed($user_id,$couponId);
                if(!$check)
                {
                    $discount= $coupon['discount_value'];
                    $total-=$discount;
                    $this->couponUsageModel->addUsage($user_id,$couponId);
                    $this->couponModel->updateUsageCount($couponId);
                }
            }
            
            //tạo đơn
            $order=$this->orderModel->createOrder($user_id,$fullname,$phone,$email,$address,$district,$city,$postcode,$note,$payment_method,$total);
            if($order)
            {
                foreach ($cartItems as $item) {
                    $this->orderItems->addOrderItem($order,$item['product_id'], $item['quantity'], $item['price']); //thêm vào bảng orderitem
                    $this->productModel->decreaseStock($item['product_id'], $item['quantity']);//giảm số lượng
                }
                $this->cartModel->clearCart($user_id);
                header('Location: /php-pj/index.php?action=success');
            }
            else{
                header('Location: /php-pj/index.php?action=error');
            }
            
        }
        include __DIR__ . "/../../view/site/checkout.php";
    }
}
?>