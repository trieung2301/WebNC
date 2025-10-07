<?php include __DIR__ . '/components/header.php'; ?>

<style>
  body {
    background: #f8fafc;
  }

  .product-img {
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
  }
  .product-img:hover {
    transform: scale(1.03);
  }

  h1 {
    font-weight: 700;
    color: #222;
  }

  .price-tag {
    font-size: 1.8rem;
    font-weight: 700;
    background: linear-gradient(to right, #4facfe, #00c6ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }

  .btn-primary {
    background: linear-gradient(to right, #4facfe, #00c6ff);
    border: none;
    font-weight: 600;
    padding: 0.6rem 1.2rem;
    border-radius: 10px;
    transition: all 0.3s ease;
  }
  .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,198,255,0.4);
  }

  .rating-stars label {
    font-size: 1.2rem;
    cursor: pointer;
    transition: transform 0.2s ease;
  }
  .rating-stars label:hover {
    transform: scale(1.2);
  }

  .comment-box {
    background: rgba(255,255,255,0.9);
    border-radius: 12px;
    padding: 1rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
  }
</style>

<div class="container py-5">

  <div class="row align-items-start g-4">
    <!-- Ảnh sản phẩm -->
    <div class="col-md-6">
      <img src="/php-pj/view/image/<?= htmlspecialchars($product['image']) ?>"
           class="img-fluid product-img"
           alt="<?= htmlspecialchars($product['name']) ?>">
    </div>

    <!-- Thông tin sản phẩm -->
    <div class="col-md-6">
      <h1 class="mb-3"><?= htmlspecialchars($product['name']) ?></h1>
      <p class="price-tag mb-3">
        <?= number_format($product['price'], 0, ',', '.') ?> VND
      </p>

      <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
      <p class="fw-bold text-secondary">Số lượng còn: <?= $product['stock'] ?></p>

      <form method="POST" action="/php-pj/productDetails&id=<?= $product['id'] ?>">
          <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
          <input type="hidden" name="quantity" value="1">
          <button type="submit" class="btn btn-primary">🛒 Thêm vào giỏ hàng</button>
      </form>
    </div>
  </div>

  <!-- Khu vực Đánh giá -->
  <div class="mt-5">
    <h3 class="mb-4">⭐ Đánh giá sản phẩm</h3>

    <?php if (!$isRating): ?>
      <form method="post" action="/php-pj/productDetails&id=<?= $product['id'] ?>" class="mb-4">
        <div class="mb-3 rating-stars">
          <label class="form-label d-block mb-2">Chọn số sao:</label>
          <div class="d-flex gap-2">
            <?php for ($i = 5; $i >= 1; $i--): ?>
              <input type="radio" class="btn-check" name="rating" id="star<?= $i ?>" value="<?= $i ?>" required>
              <label for="star<?= $i ?>" class="btn btn-outline-warning px-3">
                <?= str_repeat('★', $i) ?>
              </label>
            <?php endfor; ?>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
      </form>
    <?php else: ?>
      <p class="text-success fw-bold">✅ Bạn đã đánh giá sản phẩm này rồi.</p>
    <?php endif; ?>

    <?php if (isset($averageRating)): ?>
      <div class="mb-4">
        <strong>Đánh giá trung bình: </strong>
        <span class="text-warning">
          <?= str_repeat('★', floor($averageRating)) ?>
          <?= str_repeat('☆', 5 - floor($averageRating)) ?>
        </span>
        (<?= number_format($averageRating, 1) ?>/5)
      </div>
    <?php endif; ?>
  </div>

  <!-- Khu vực Bình luận -->
  <div class="mt-5">
    <h3 class="mb-4">💬 Bình luận</h3>

    <form method="post" action="/php-pj/productDetails&id=<?= $product['id'] ?>" class="mb-4">
      <div class="mb-3">
        <textarea name="comment_text" rows="3" class="form-control" placeholder="Nhập bình luận..." required></textarea>
      </div>
      <button type="submit" class="btn btn-secondary">Gửi bình luận</button>
    </form>

    <?php if (!empty($comments)): ?>
      <?php foreach ($comments as $cmt): ?>
        <div class="comment-box mb-3">
          <div class="d-flex justify-content-between">
            <strong><?= htmlspecialchars($cmt['username']) ?></strong>
            <small class="text-muted"><?= htmlspecialchars($cmt['created_at']) ?></small>
          </div>
          <p class="mb-0 mt-2"><?= nl2br(htmlspecialchars($cmt['comment_text'])) ?></p>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Chưa có bình luận nào cho sản phẩm này.</p>
    <?php endif; ?>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
