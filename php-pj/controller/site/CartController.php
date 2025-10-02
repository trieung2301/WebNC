<?php
require_once __DIR__ . "/../../model/Cart.php";
require_once __DIR__ . "/../../model/Product.php";
class CartController {
    private Cart $cartModel;
    private Product $productsModel;
    public function __construct(Cart $cartModel,Product $productsModel) {
        $this->cartModel = $cartModel;
        $this->productsModel= $productsModel;
    }
    public function index() {
        if (!isset($_SESSION['user'])) {
            $_SESSION['ERROR'] = 'Bạn cần đăng nhập để xem giỏ hàng!';
            header('Location: index.php?action=login');
            exit;
        }
        $user_id = $_SESSION['user']['id'];
        $cartItems = $this->cartModel->getCartItems($user_id);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
            $product_id = $_POST['product_id'];
            $this->cartModel->deleteFromCart($user_id,$product_id);
            header('Location: index.php?action=cart');
        }
        include __DIR__ . '/../../view/site/cart.php';
    }

    public function add() {
        if (!isset($_SESSION['user'])) {
            $_SESSION['ERROR'] = 'Bạn cần đăng nhập để thêm sản phẩm!';
            header('Location: index.php?action=login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
            $user_id    = $_SESSION['user']['id'];
            $product_id = (int)$_POST['product_id'];
            $quantity   = (int)($_POST['quantity']);

            $stockProduct= $this->productsModel->checkQuantityProducts($product_id);//check số lg trong sp
            $stockCart= $this->productsModel->checkQuantityCart($user_id, $product_id);//check số lg trong giỏ hàng
            $newStock= $stockCart + $quantity; // số lg mới bằng số đã có trong giỏ hàng + với số vừa thêm vào
            if($newStock > $stockProduct){ // nếu thêm vào vượt quá thì redirect thoát luôn
                header('Location: index.php?action=cart');
                exit;
            }
            $this->cartModel->addToCart($user_id, $product_id, $quantity);
            exit;
        }
    }
}
?>
