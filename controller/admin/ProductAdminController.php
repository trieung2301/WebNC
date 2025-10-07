<?php

class ProductAdminController {
    private $productModel;
    private $categoryModel;
    private $userModel;

    public function __construct($productModel, $categoryModel, $userModel = null) {
        $this->productModel = $productModel;
        $this->categoryModel = $categoryModel;
        $this->userModel = $userModel;
    }

    private function adminCheck(): void {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? 'user') !== 'admin') { 
            header("Location: /php-pj/login");
            exit;
        }
    }

    private function handleImageUpload($fileInputName): string {
        if (empty($_FILES[$fileInputName]['name'])) {
            return '';
        }

        $targetDir = __DIR__ . "/../../view/images";
        $fileName = basename($_FILES[$fileInputName]["name"]);
        $imageFileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $newFileName = time() . '_' . uniqid() . '.' . $imageFileType;
        $targetFilePath = $targetDir . $newFileName;

        if ($_FILES[$fileInputName]["error"] !== UPLOAD_ERR_OK) {
            $_SESSION['error_message'] .= " | Lỗi upload file: Mã lỗi " . $_FILES[$fileInputName]["error"];
            return 'error';
        }

        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            $_SESSION['error_message'] .= " | Chỉ chấp nhận JPG, JPEG, PNG & GIF.";
            return 'error';
        }
        
        if (move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $targetFilePath)) {
            return $newFileName;
        } else {
            $_SESSION['error_message'] .= " | Lỗi khi di chuyển file.";
            return 'error';
        }
    }

    public function manageProducts(): void {
        $this->adminCheck();

        $searchTerm = $_GET['search'] ?? '';

        if (!empty($searchTerm)) {
            $products = $this->productModel->SearchProduct($searchTerm); 
        } else {
            $products = $this->productModel->getAllProducts();
        }

        $categories = $this->categoryModel->getAllCategories(); 
        $categoryMap = [];
        foreach ($categories as $cate) {
            $categoryMap[$cate['id']] = $cate['name'];
        }
        
        include __DIR__ . "/../../view/admin/productAdmin.php";
    }

    public function addProductForm(): void {
        $this->adminCheck();
        
        $categories = $this->categoryModel->getAllCategories(); 
        $product = null;
        $actionUrl = 'admin/addProduct/submit';
        
        include __DIR__ . "/../../view/admin/productForm.php";
    }

    public function addProduct(): void {
        $this->adminCheck();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $price = (float)($_POST['price'] ?? 0);
            $stock = (int)($_POST['stock'] ?? 0);
            $categoryId = (int)($_POST['category_id'] ?? 0);
            
            $uploadedFileName = $this->handleImageUpload('image_file'); 
            
            if ($uploadedFileName === 'error') {
                header("Location: /php-pj/admin/addProduct");
                exit;
            }

            $image = $uploadedFileName ?: 'default.jpg'; 

            $data = [
                'name' => $name, 'description' => $description, 
                'price' => $price, 'stock' => $stock, 'category_id' => $categoryId, 'image' => $image
            ];
            
            if (empty($name) || $price <= 0 || $categoryId <= 0) {
                $_SESSION['error_message'] = "Vui lòng nhập đầy đủ Tên sản phẩm, Giá và chọn Danh mục.";
                header("Location: /php-pj/admin/addProduct");
                exit;
            }

            if ($this->productModel->createProduct($data)) {
                $_SESSION['success_message'] = "Thêm sản phẩm '{$name}' thành công! ✅";
                header("Location: /php-pj/admin/products");
                exit;
            } else {
                $_SESSION['error_message'] = "Lỗi khi thêm sản phẩm vào cơ sở dữ liệu. Vui lòng thử lại.";
            }
        }
        
        header("Location: /php-pj/admin/addProduct"); 
        exit;
    }

    public function editProduct(): void {
        $this->adminCheck();

        $id = (int)($_GET['id'] ?? 0);
        $product = $this->productModel->getProductById($id); 

        if (!$product) {
            $_SESSION['error_message'] = "Không tìm thấy sản phẩm cần chỉnh sửa.";
            header("Location: /php-pj/admin/products");
            exit;
        }

        $categories = $this->categoryModel->getAllCategories(); 
        $actionUrl = 'admin/updateProduct';

        include __DIR__ . "/../../view/admin/productForm.php";
    }

    public function updateProduct(): void {
        $this->adminCheck();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['id'] ?? 0); 
            
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $price = (float)($_POST['price'] ?? 0);
            $stock = (int)($_POST['stock'] ?? 0);
            $categoryId = (int)($_POST['category_id'] ?? 0);
            $oldImage = trim($_POST['old_image'] ?? 'default.jpg'); 

            $uploadedFileName = $this->handleImageUpload('image_file'); 

            if ($uploadedFileName === 'error') {
                header("Location: /php-pj/admin/editProduct&id={$id}");
                exit;
            }

            $image = !empty($uploadedFileName) ? $uploadedFileName : $oldImage; 

            $data = [
                'name' => $name, 'description' => $description, 
                'price' => $price, 'stock' => $stock, 'category_id' => $categoryId, 'image' => $image
            ];

            if ($id <= 0 || empty($name) || $price <= 0 || $categoryId <= 0) {
                $_SESSION['error_message'] = "Dữ liệu cập nhật không hợp lệ. Vui lòng kiểm tra lại.";
                header("Location: /php-pj/admin/editProduct&id={$id}");
                exit;
            }

            if ($this->productModel->updateProduct($id, $data)) {
                $_SESSION['success_message'] = "Cập nhật sản phẩm ID: {$id} thành công! ✅";
            } else {
                $_SESSION['error_message'] = "Lỗi khi cập nhật sản phẩm. Có thể không có thay đổi nào được thực hiện.";
            }
        }
        
        header("Location: /php-pj/admin/products");
        exit;
    }

    public function deleteProduct(): void {
        $this->adminCheck();
        
        $id = (int)($_GET['id'] ?? 0); 

        if ($id <= 0) {
            $_SESSION['error_message'] = "ID sản phẩm không hợp lệ.";
            header("Location: /php-pj/admin/products");
            exit;
        }

        if ($this->productModel->deleteProduct($id)) {
            $_SESSION['success_message'] = "Xóa sản phẩm ID: {$id} thành công! 🗑️";
        } else {
            $_SESSION['error_message'] = "Lỗi khi xóa sản phẩm ID: {$id}. Có thể do sản phẩm này đang liên quan đến các đơn hàng hoặc bình luận.";
        }
        
        header("Location: /php-pj/admin/products");
        exit;
    }
}