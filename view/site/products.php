<?php include __DIR__ . '/components/header.php'; ?>

<style>
  body {
      background: #f8fafc;
  }

  h1 {
      font-weight: 700;
      color: #222;
  }

  /* Bộ lọc danh mục */
  .filter-form {
      background: #ffffff;
      padding: 1.5rem;
      border-radius: 16px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.05);
      margin-bottom: 2rem;
  }

  /* Card sản phẩm */
  .product-card .card {
      border: none;
      border-radius: 18px;
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      background: #ffffff;
  }
  .product-card .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 25px rgba(0,0,0,0.1);
  }

  .product-card img {
      border-bottom: 1px solid #f0f0f0;
      height: 250px;
      object-fit: cover;
      transition: transform 0.3s ease;
  }
  .product-card img:hover {
      transform: scale(1.05);
  }

  .product-card .card-body h5 {
      font-weight: 600;
      color: #222;
  }

  .product-card .card-body p {
      font-size: 0.9rem;
      color: #555;
      min-height: 48px;
  }

  .product-card .price {
      font-size: 1.2rem;
      font-weight: 700;
      background: linear-gradient(to right, #4facfe, #00c6ff);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
  }

  /* Nút thêm vào giỏ */
  .btn-add-cart {
      background: linear-gradient(to right, #4facfe, #00c6ff);
      color: #fff;
      font-weight: 600;
      border: none;
      padding: 0.6rem;
      border-radius: 50px;
      transition: all 0.3s ease;
  }
  .btn-add-cart:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(0,198,255,0.4);
  }
</style>

<div class="container mt-5">
    <h1 class="text-center mb-4">Danh sách sản phẩm</h1>
    
    <!-- Bộ lọc danh mục -->
    <form method="get" action="/php-pj/getProducts/" class="filter-form">
        <input type="hidden" name="action" value="getProducts">
        <div class="row g-3 align-items-center">
            <div class="col-md-4">
                <select name="category" class="form-select">
                    <option value="all">Tất cả danh mục</option>
                    <?php foreach ($categories as $catego): ?>
                        <option value="<?= $catego['id'] ?>">
                            <?= htmlspecialchars($catego['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Lọc</button>
            </div>
        </div>
    </form>

    <!-- Danh sách sản phẩm -->
    <div class="row row-cols-1 row-cols-md-3 g-4" id="productContainer">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="col product-card category-<?= $product['category_id'] ?>">
                    <div class="card h-100 shadow-sm">
                        <a href= "/php-pj/productDetails&id=<?= $product['id'] ?>" class="text-decoration-none">
                            <img src="/php-pj/view/image/<?= htmlspecialchars($product['image']) ?>" 
                                 alt="<?= htmlspecialchars($product['name']) ?>">
                            <div class="card-body text-center">
                                <h5><?= htmlspecialchars($product['name']) ?></h5>
                                <p><?= htmlspecialchars($product['description']) ?></p>
                                <p class="price"><?= number_format($product['price'], 0, ',', '.') ?> VNĐ</p>
                            </div>
                        </a>

                        <form method="POST" action="/php-pj/getProducts/" class="p-3">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-add-cart w-100 d-flex align-items-center justify-content-center gap-2">
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
