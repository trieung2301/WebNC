<?php
require_once __DIR__ . "/xl_data.php";

class DanhMuc {
    private int $id = 0;
    private string $name = "";
    private string $slug = "";

    public function setId(int $id): void {
        $this->id = $id;
    }
    public function getId(): int {
        return $this->id;
    }

    public function setName(string $name): void {
        $this->name = $name;
        $this->slug = $this->createSlug($name); // tự động tạo slug
    }
    public function getName(): string {
        return $this->name;
    }

    public function getSlug(): string {
        return $this->slug;
    }
    private function createSlug(string $name): string {
        $slug = strtolower($name); // chuyển về chữ thường
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $slug); // bỏ dấu
        $slug = preg_replace('/[^a-z0-9]+/i', '-', $slug); // ký tự đặc biệt -> -
        return trim($slug, '-'); //bỏ dấu - thừa ở đầu và cuối
    }

    public function getAll(): array {
        $xl = new xl_data();
        $sql = "SELECT * FROM `danhmuc` ORDER BY `created_at` DESC";
        return $xl->readItem($sql);
    }

    public function getBySlug(string $slug): ?array { //trả về mảng hoặc null
        $xl = new xl_data();
        $sql = "SELECT * FROM `danhmuc` WHERE `slug` = '$slug' ";
        $results = $xl->readItem($sql);
        return $results[0] ?? null; // nếu có phần từ thì trả về không thì null
    }

    public function add(DanhMuc $dm): void {
        $xl = new xl_data();
        $sql = "INSERT INTO `danhmuc` (`id`, `name`, `slug`, `created_at`, `updated_at`)
                VALUES (NULL, '" . $dm->getName() . "', '" . $dm->getSlug() . "', NOW(), NOW())"; //". tức là dấu phẩy đóng cái string trc đó, dấu . là nối chuỗi
        $xl->executeItem($sql);
    }

    public function update(DanhMuc $dm): void {
        $xl = new xl_data();
        $sql = "UPDATE `danhmuc` 
                SET `name` = '" . $dm->getName() . "', slug = '" . $dm->getSlug() . "', updated_at = NOW()
                WHERE `id` = " . $dm->getId();
        $xl->executeItem($sql);
    }

    public function delete(DanhMuc $dm): void {
        $xl = new xl_data();
        $sql = "DELETE FROM `danhmuc` WHERE `id` = " . $dm->getId();
        $xl->executeItem($sql);
    }
}
?>
