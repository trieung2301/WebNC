<?php
require_once __DIR__ . "/../../model/Cart.php";
require_once __DIR__ . "/../../model/Order.php";
require_once __DIR__ . "/../../model/Product.php";
require_once __DIR__ . "/../../model/OrderItems.php";
require_once __DIR__ . "/../../model/Coupon.php";
require_once __DIR__ . "/../../model/CouponUsage.php";

// Đã sửa lỗi đường dẫn tuyệt đối → tương đối
require_once __DIR__ . '/../../PHPMailer/src/Exception.php';
require_once __DIR__ . '/../../PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class CheckoutController {
    private Cart $cartModel;
    private Order $orderModel;
    private Product $productModel;
    private OrderItems $orderItems;
    private Coupon $couponModel;
    private CouponUsage $couponUsageModel;

    public function __construct(
        Cart $cartModel,
        Order $orderModel,
        Product $productModel,
        OrderItems $orderItems,
        Coupon $couponModel,
        CouponUsage $couponUsageModel
    ) {
        $this->cartModel = $cartModel;
        $this->orderModel = $orderModel;
        $this->productModel = $productModel;
        $this->orderItems = $orderItems;
        $this->couponModel = $couponModel;
        $this->couponUsageModel = $couponUsageModel;
    }

    public function index() {
        if (!isset($_SESSION['user'])) {
            header('Location: php-pj/login');
            exit;
        }

        $user_id   = $_SESSION['user']['id'];
        $cartItems = $this->cartModel->getCartItems($user_id);
        $totalItems = $this->cartModel->getTotalItems($user_id);

        if ($totalItems == 0) {
            header('Location: /php-pj/home');
            exit;
        }

        // Tính tổng tiền trước khi áp dụng voucher
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $discount = 0;
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname        = $_POST['fullname'];
            $email           = $_POST['email'];
            $phone           = $_POST['phone'];
            $note            = $_POST['note'];
            $address         = $_POST['address'];
            $district        = $_POST['district'];
            $city            = $_POST['city'];
            $postcode        = $_POST['postcode'];
            $payment_method  = $_POST['payment_method'];
            $couponCode      = trim($_POST['coupon'] ?? '');
            $coupon = null;

            if ($couponCode !== '') {
                $coupon = $this->couponModel->checkCoupon($couponCode);
                if ($coupon) {
                    $couponId = $coupon['id'];
                    $used = $this->couponUsageModel->checkUsed($user_id, $couponId);
                    if (!$used) {
                        $discount = $coupon['discount_value'];
                        $total -= $discount;

                        $this->couponUsageModel->addUsage($user_id, $couponId);
                        $this->couponModel->updateUsageCount($couponCode);
                    } else {
                        $error = 'Bạn đã sử dụng voucher này trước đó.';
                    }
                } else {
                    $error = 'Voucher không tồn tại hoặc đã hết hạn.';
                }
            }

            if ($error === '') {
                $orderId = $this->orderModel->createOrder(
                    $user_id, $fullname, $phone, $email, $address,
                    $district, $city, $postcode, $note, $payment_method, $total
                );

                if ($orderId) {
                    foreach ($cartItems as $item) {
                        $this->orderItems->addOrderItem($orderId, $item['product_id'], $item['quantity'], $item['price']);
                        $this->productModel->decreaseStock($item['product_id'], $item['quantity']);
                    }
                    $this->cartModel->clearCart($user_id);

                    $mail = new PHPMailer(true);
                    try {
                        $mail->isSMTP();
                        $mail->Host       = 'smtp.gmail.com';
                        $mail->SMTPAuth   = true;
                        $mail->Username   = 'trannghi1672004@gmail.com';
                        $mail->Password   = 'hmmm hqpc lsny zfdj'; // App password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                        $mail->Port       = 465;

                        $mail->setFrom('trannghi1672004@gmail.com', 'WatchShop');
                        $mail->addAddress($email, $fullname);

                        $mail->isHTML(true);
                        $mail->Subject = 'Cảm ơn bạn đã đặt hàng tại WatchShop';

                        $body  = "<h3>Chào $fullname,</h3>";
                        $body .= "<p>Cám ơn bạn đã mua sản phẩm tại <strong>WatchShop</strong>.</p>";
                        $body .= "<h4>Thông tin đơn hàng:</h4>
                                <ul>
                                    <li>Email: $email</li>
                                    <li>Số điện thoại: $phone</li>
                                    <li>Địa chỉ: $address, $district, $city, $postcode</li>
                                    <li>Phương thức thanh toán: $payment_method</li>
                                    <li>Mã giảm giá: " . ($coupon ? $coupon['code'] : 'Không có') . "</li>
                                    <li>Ghi chú: " . (!empty($note) ? $note : 'Không có') . "</li>
                                </ul>";

                        $body .= "<h4>Chi tiết sản phẩm:</h4>
                                <table border='1' cellpadding='5' cellspacing='0'>
                                    <tr>
                                        <th>STT</th>
                                        <th>Sản phẩm</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                    </tr>";

                        foreach ($cartItems as $index => $item) {
                            $subtotal = $item['price'] * $item['quantity'];
                            $body .= "<tr>
                                        <td>".($index+1)."</td>
                                        <td>".$item['name']."</td>
                                        <td>".number_format($item['price'],0,',','.')." VND</td>
                                        <td>".$item['quantity']."</td>
                                        <td>".number_format($subtotal,0,',','.')." VND</td>
                                    </tr>";
                        }

                        $body .= "<tr>
                                    <td colspan='4' style='text-align:right'><strong>Tổng tiền:</strong></td>
                                    <td><strong>".number_format($total,0,',','.')." VND</strong></td>
                                  </tr>
                                </table>";

                        if ($payment_method === "Chuyển khoản") {
                            $body .= "<p style='color:red; font-weight:bold;'>
                                        Lưu ý: Đối với khách hàng thanh toán bằng ngân hàng, vui lòng thanh toán trước khi chúng tôi giao hàng.<br>
                                        Ngân hàng: MBBANK – Số tài khoản: 0937861799<br>
                                        Số điện thoại hỗ trợ: 093786199
                                     </p>";
                        }

                        $body .= "<p>Chúng tôi sẽ liên hệ với bạn sớm nhất để xác nhận đơn hàng.</p>";

                        $mail->Body    = $body;
                        $mail->AltBody = "Cảm ơn bạn đã mua sản phẩm tại WatchShop. Tổng tiền: ".number_format($total,0,',','.')." VND";

                        $mail->send();

                    } catch (Exception $e) {
                        error_log("Mailer Error: {$mail->ErrorInfo}");
                    }

                    header('Location: /php-pj/success');
                    exit;
                } else {
                    $error = 'Có lỗi xảy ra khi tạo đơn hàng. Vui lòng thử lại.';
                }
            }
        }
        include __DIR__ . "/../../view/site/checkout.php";
    }
}
?>
