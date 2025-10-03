<?php include __DIR__ . '/components/header.php'; ?>
<!-- Banner -->
<header class="bg-primary text-white text-center py-5">
  <div id="carouselExampleAutoplaying" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="2000">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="/php-pj/view/image/dong-ho-nam.jpg" class="d-block w-100" alt="Banner 1">
      </div>
      <div class="carousel-item">
        <img src="/php-pj/view/image/dong-ho-nu.jpg" class="d-block w-100" alt="Banner 2">
      </div>
      <div class="carousel-item">
        <img src="/php-pj/view/image/dong-ho-thong-minh.webp" class="d-block w-100" alt="Banner 3">
      </div>
    </div>
  </div>
  <div class="container mt-4">
    <p class="lead">Chào mừng bạn đến với cửa hàng trực tuyến của chúng tôi</p>
  </div>
</header>
<!-- Bộ lọc danh mục (riêng, dưới navbar) -->
<div class="bg-light py-3 border-bottom">
  <div class="container">
    <form class="d-flex" method="get" action="index.php">
      <input type="hidden" name="action" value="home">
      <select class="form-select w-auto me-2" name="category" onchange="this.form.submit()"> <!--this.form.submit là tự gọi action -->
        <option value="all">Tất cả danh mục</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?php echo $cat['id']; ?>">
                    <?php echo htmlspecialchars($cat['name']); ?>
                </option>
        <?php endforeach; ?>
      </select>
    </form>
  </div>
</div>

<!-- Danh sách sản phẩm -->
<section class="py-5">
  <div class="container">
    <h2 class="text-center mb-4">Danh sách sản phẩm</h2>
    <div class="row g-4">
      <?php if (!empty($products)): ?>
        <?php foreach ($products as $pd): ?>
          <div class="col-md-4">
            <div class="card shadow-sm">
              
              <a href="index.php?action=productDetails&id=<?=$pd['id'] ?>"> 
                <img src="view/image/<?= htmlspecialchars($pd['image']) ?>"
                     class="card-img-top"
                     alt="<?= htmlspecialchars($pd['name']) ?>">
              </a>

                <div class="card-body text-center">
                  <h5 class="card-title"><?= htmlspecialchars($pd['name']) ?></h5>
                  <p class="card-text text-danger fw-bold">
                      <?= number_format($pd['price'], 0, ',', '.') ?> VND
                  </p>

                  <!-- Nút thêm vào giỏ hàng -->
                  <form method="POST" action="index.php?action=home">
                      <input type="hidden" name="product_id" value="<?= $pd['id'] ?>">
                      <input type="hidden" name="quantity" value="1">
                      <button type="submit" class="btn btn-primary">Thêm vào giỏ hàng</button>
                  </form>
                </div>

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
</section>
<!-- Google Map hiển thị vị trí cửa hàng -->
<section class="py-5">
  <div class="container">
    <h2 class="text-center mb-4">Vị trí cửa hàng của chúng tôi</h2>
    <div class="ratio ratio-16x9">
      <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.777580236414!2d106.69927097570303!3d10.751617859649468!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f736589a387%3A0x9147855bfef1be53!2zNzAxIMSQLiBUcuG6p24gWHXDom4gU2_huqFuLCBQLCBRdeG6rW4gNywgSOG7kyBDaMOtIE1pbmggNzAwMDAwLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1759237711117!5m2!1svi!2s" 
        width="600" 
        height="450" 
        style="border:0;" 
        allowfullscreen 
        loading="lazy" 
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </div>
  </div>
</section>
<footer class="bg-dark text-white text-center py-3">
  &copy; 2025 WatchShop. All rights reserved.<br>
  If you have any problems. Please call <a href="tel:+84937861799" class="text-white">+84 937 861 799</a>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>