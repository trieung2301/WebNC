<?php include __DIR__ . '/components/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Danh sách sản phẩm</h1>
    
    <!-- Thanh chọn Categories -->
    <form method="get" action="index.php">
        <input type="hidden" name="action" value="getProducts">
        <select name="category" class="form-select">
            <option value="all">Tất cả</option>
            <?php foreach ($categories as $catego): ?>
                <option value="<?php echo $catego['id']; ?>">
                    <?php echo htmlspecialchars($catego['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-primary mt-3">Lọc</button>
    </form>


    <div class="row row-cols-1 row-cols-md-3 g-4" id="productContainer">
    <?php if (!empty($products)): ?>
    <?php foreach ($products as $product): ?>
        <div class="col-md-4 product-card category-<?= $product['category_id'] ?>">
            
            <div class="card shadow-lg rounded-3 h-100">

                <!-- Link tới chi tiết sản phẩm -->
                <a href="index.php?action=productDetails&id=<?= $product['id'] ?>" class="text-decoration-none text-dark">
                    <img src="/php-pj/view/image/<?= htmlspecialchars($product['image']) ?>" 
                         class="card-img-top" 
                         alt="<?= htmlspecialchars($product['name']) ?>" 
                         style="max-height: 250px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                        <p class="card-text text-center"><?= htmlspecialchars($product['description']) ?></p>
                        <p class="text-danger fw-bold"><?= number_format($product['price'], 0, ',', '.') ?> VNĐ</p>
                    </div>
                </a>

                <!-- Nút thêm vào giỏ hàng -->
                <form method="POST" action="index.php?action=getProducts" class="m-3">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn btn-success w-100 d-flex align-items-center justify-content-center gap-2 rounded-pill shadow-sm">
                        <i class="bi bi-cart-plus-fill"></i> Thêm vào giỏ
                    </button>
                </form>

            </div>
        </div>
    <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12 text-center">
            <p>Không tìm thấy sản phẩm.</p>
        </div>
    <?php endif; ?>

</div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
