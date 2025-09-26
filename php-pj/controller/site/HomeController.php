<?php
require_once __DIR__ . "/../../model/Product.php";

class HomeController
{
    private Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function home(): void
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /php-pj/index.php?action=login");
            exit;
        }
        $products = $this->product->getAllProducts();
        include __DIR__ . '/../../view/site/home.php';
    }
}
