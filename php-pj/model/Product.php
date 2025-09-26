<?php
class Product {
    private $pdo;

    public function __construct($pdo) { //tạo đối tượng dpo để querry trực tiếp và mở kết nối db
        $this->pdo = $pdo;
    }

    public function getAllProducts(): array {
        $stmt = $this->pdo->query("SELECT * FROM products ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }

    public function getProductById(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        return $product ?: null;
    }

    public function createProduct(array $data): bool {
        $sql = "INSERT INTO products (name, slug, description, image, price, stock, category_id, created_at, updated_at)
                VALUES (:name, :slug, :description, :image, :price, :stock, :category_id, NOW(), NOW())";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'name'        => $data['name'],
            'slug'        => $data['slug'],
            'description' => $data['description'],
            'image'       => $data['image'],
            'price'       => $data['price'],
            'stock'       => $data['stock'],
            'category_id' => $data['category_id'],
        ]);
    }

    public function updateProduct(int $id, array $data): bool {
        $sql = "UPDATE products 
                SET name = :name, slug = :slug, description = :description, image = :image, 
                    price = :price, stock = :stock, category_id = :category_id, updated_at = NOW() 
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'id'          => $id,
            'name'        => $data['name'],
            'slug'        => $data['slug'],
            'description' => $data['description'],
            'image'       => $data['image'],
            'price'       => $data['price'],
            'stock'       => $data['stock'],
            'category_id' => $data['category_id'],
        ]);
    }

    public function deleteProduct(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
