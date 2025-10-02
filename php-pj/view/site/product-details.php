<?php include __DIR__ . '/components/header.php'; ?>

<div class="container py-5">

  <div class="row">
    <!-- Ảnh sản phẩm -->
    <div class="col-md-6">
      <img src="view/image/<?= htmlspecialchars($product['image']) ?>"
           class="img-fluid rounded shadow-sm"
           alt="<?= htmlspecialchars($product['name']) ?>">
    </div>

    <!-- Thông tin sản phẩm -->
    <div class="col-md-6">
      <h1 class="mb-3"><?= htmlspecialchars($product['name']) ?></h1>
      <p class="text-danger fs-4 fw-bold">
        <?= number_format($product['price'], 0, ',', '.') ?> VND
      </p>

      <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
      <p class="fw-bold">Số lượng còn: <?= $product['stock'] ?></p>
      <form method="POST" action="index.php?action=productDetails&id=<?= $product['id'] ?>">
          <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
          <input type="hidden" name="quantity" value="1">
          <button type="submit" class="btn btn-primary">Thêm vào giỏ hàng</button>
      </form>
    </div>
  </div>

  <!-- Khu vực Đánh giá -->
<div class="mt-5">
  <h3>Đánh giá sản phẩm</h3>

  <?php if (!$isRating): ?>
    <!-- Form vote -->
    <form method="post" action="index.php?action=productDetails&id=<?= $product['id'] ?>" class="mb-4">
      <div class="mb-3">
        <label class="form-label">Chọn số sao:</label>
        <div class="d-flex gap-2">
          <?php for ($i = 5; $i >= 1; $i--): ?>
            <input type="radio" class="btn-check" name="rating" id="star<?= $i ?>" value="<?= $i ?>" required>
            <label for="star<?= $i ?>" class="btn btn-outline-warning">
              <?= str_repeat('★', $i) ?>
            </label>
          <?php endfor; ?>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
    </form>
  <?php else: ?>
    <p class="text-success fw-bold">Bạn đã đánh giá sản phẩm này rồi.</p>
  <?php endif; ?>

  <!-- Hiển thị điểm trung bình -->
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
    <h3>Bình luận</h3>

    <!-- Form comment -->
    <form method="post" action="index.php?action=productDetails&id=<?= $product['id'] ?>" class="mb-4">
      <div class="mb-3">
        <textarea name="comment_text" rows="3" class="form-control" placeholder="Nhập bình luận..." required></textarea>
      </div>
      <button type="submit" class="btn btn-secondary">Gửi bình luận</button>
    </form>

    <!-- Hiển thị danh sách bình luận -->
    <?php if (!empty($comments)): ?>
      <?php foreach ($comments as $cmt): ?>
        <div class="border rounded p-3 mb-3 bg-light">
          <strong><?= htmlspecialchars($cmt['username']) ?></strong>
          <small class="text-muted float-end"><?= htmlspecialchars($cmt['created_at']) ?></small>

          <p class="mb-0"><?= nl2br(htmlspecialchars($cmt['comment_text'])) ?></p>
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
