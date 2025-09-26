<?php
require_once "/../../model/Category.php";

class CategoryController {
    private DanhMuc $danhMuc; //khai báo kiểu dữ liệu object

    public function __construct() {
        $this->danhMuc = new DanhMuc(); //khởi tạo đối tượng
    }

    // Hiển thị danh sách
    public function index(): void {
        $categories = $this->danhMuc->getAll(); //lấy ra danh sách từ model đã viết
        include "./view/category/index.php"; // view hiển thị danh sách
    }

    // Hiển thị form thêm mới
    public function create(): void {
        include "./view/category/create.php";
    }

    // Xử lý thêm mới
    public function store(): void {
        if (isset($_POST['name'])) { //isset kiểm biến có tồn tại hay không, nếu không thì return null
            $dm = new DanhMuc();
            $dm->setName($_POST['name']);
            $this->danhMuc->add($dm);
        }
        header("Location: index.php?controller=category&action=index"); //redirect
    }

    // Hiển thị form sửa
    public function edit(): void {
        $id = $_GET['id'] ?? 0;
        $category = null;
        if ($id) {
            $category = $this->danhMuc->getBySlug($_GET['slug'] ?? ""); //lấy slug từ url
        }
        include "./view/category/edit.php";
    }

    // Xử lý cập nhật
    public function update(): void {
        if (isset($_POST['id']) && isset($_POST['name'])) {
            $dm = new DanhMuc();
            $dm->setId((int)$_POST['id']);//ép kiểu int
            $dm->setName($_POST['name']);
            $this->danhMuc->update($dm);
        }
        header("Location: index.php?controller=category&action=index");
    }

    // Xóa
    public function delete(): void {
        if (isset($_GET['id'])) {
            $dm = new DanhMuc();
            $dm->setId((int)$_GET['id']);
            $this->danhMuc->delete($dm);
        }
        header("Location: index.php?controller=category&action=index");
    }
}
