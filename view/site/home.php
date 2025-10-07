<?php include __DIR__ . '/components/header.php'; ?>

<!-- ==================== HERO BANNER ==================== -->
<header class="hero-banner position-relative">
  <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="1500">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="/php-pj/view/image/dong-ho-nam.jpg" class="d-block w-100 banner-img" alt="Banner 1">
      </div>
      <div class="carousel-item">
        <img src="/php-pj/view/image/dong-ho-nu.jpg" class="d-block w-100 banner-img" alt="Banner 2">
      </div>
      <div class="carousel-item">
        <img src="/php-pj/view/image/dong-ho-thong-minh.webp" class="d-block w-100 banner-img" alt="Banner 3">
      </div>
    </div>
  </div>
  <div class="hero-content text-center text-white position-absolute top-50 start-50 translate-middle">
    <h1 class="display-3 fw-bold animate__animated animate__fadeInDown">WATCHSHOP</h1>
    <p class="lead animate__animated animate__fadeInUp">Khám phá thời trang đỉnh cao của thế giới đồng hồ</p>
    <a href="#product-section" class="btn btn-gradient btn-lg shadow">Khám phá ngay</a>
  </div>
</header>

<!-- ==================== DANH MỤC ==================== -->
<div class="category-filter py-3 border-bottom bg-gradient-light">
  <div class="container">
    <form class="d-flex justify-content-center" method="get" action="/php-pj/home">
      <input type="hidden" name="action" value="home">
      <select class="form-select form-select-lg w-auto shadow-sm glass-select" name="category" onchange="this.form.submit()">
        <option value="all">Tất cả danh mục</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?= $cat['id'] ?>">
            <?= htmlspecialchars($cat['name']); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </form>
  </div>
</div>

<!-- ==================== DANH SÁCH SẢN PHẨM ==================== -->
<section id="product-section" class="py-5 bg-light">
  <div class="container">
    <h2 class="text-center fw-bold mb-5 display-5">Sản phẩm nổi bật</h2>
    <div class="row g-4">
      <?php if (!empty($products)): ?>
        <?php foreach ($products as $pd): ?>
          <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="product-card glass-card shadow-hover h-100 d-flex flex-column">
              
              <a href="/php-pj/productDetails&id=<?= $pd['id'] ?>"> 
                <img src="/php-pj/view/image/<?= htmlspecialchars($pd['image']) ?>" 
                     class="product-img" 
                     alt="<?= htmlspecialchars($pd['name']) ?>">
              </a>

              <div class="p-3 text-center flex-grow-1 d-flex flex-column justify-content-between">
                <div>
                  <h5 class="fw-semibold"><?= htmlspecialchars($pd['name']) ?></h5>
                  <p class="text-danger fs-5 fw-bold">
                    <?= number_format($pd['price'], 0, ',', '.') ?> VND
                  </p>
                </div>

                <form method="POST" action="/php-pj/home/">
                  <input type="hidden" name="product_id" value="<?= $pd['id'] ?>">
                  <input type="hidden" name="quantity" value="1">
                  <button type="submit" class="btn btn-gradient w-100 mt-2">Thêm vào giỏ hàng</button>
                </form>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-12 text-center">
          <p class="text-muted">Không tìm thấy sản phẩm.</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- ==================== GOOGLE MAP ==================== -->
<section class="py-5 bg-white">
  <div class="container">
    <h2 class="text-center mb-4 fw-bold">Vị trí cửa hàng</h2>
    <div class="ratio ratio-16x9 rounded-4 overflow-hidden shadow-lg">
      <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.777580236414!2d106.69927097570303!3d10.751617859649468!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f736589a387%3A0x9147855bfef1be53!2zNzAxIMSQLiBUcuG6p24gWHXDom4gU2_huqFuLCBQLCBRdeG6rW4gNywgSOG7kyBDaMOtIE1pbmggNzAwMDAwLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1759237711117!5m2!1svi!2s" 
        style="border:0;" 
        allowfullscreen 
        loading="lazy" 
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </div>
  </div>
</section>

<!-- ==================== FOOTER ==================== -->
<footer class="footer-modern text-white text-center py-4">
  &copy; 2025 <strong>WatchShop</strong>. All Rights Reserved.
  <br>
  Hỗ trợ: <a href="tel:+84937861799" class="text-info text-decoration-none">+84 937 861 799</a>
</footer>

<!-- ==================== CSS TÙY CHỈNH ==================== -->
<style>
/* ===== HERO ===== */
.hero-banner {
  height: 80vh;
  overflow: hidden;
  position: relative;
}
.banner-img {
  height: 80vh;
  object-fit: cover;
  filter: brightness(70%);
}
.hero-content h1 {
  text-shadow: 0 4px 20px rgba(0,0,0,0.6);
}
.btn-gradient {
  background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%);
  border: none;
  color: #fff;
  font-weight: 600;
  transition: all 0.3s ease-in-out;
}
.btn-gradient:hover {
  background: linear-gradient(90deg, #00f2fe 0%, #4facfe 100%);
  transform: scale(1.05);
}

/* ===== CATEGORY FILTER ===== */
.glass-select {
  background: rgba(255,255,255,0.2);
  backdrop-filter: blur(10px);
  border-radius: 12px;
  padding: .6rem 1rem;
  border: 1px solid rgba(255,255,255,0.3);
}

/* ===== PRODUCT CARD ===== */
.product-card {
  background: rgba(255,255,255,0.15);
  backdrop-filter: blur(15px);
  border-radius: 20px;
  overflow: hidden;
  transition: transform .3s ease, box-shadow .3s ease;
}
.product-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 20px 35px rgba(0,0,0,0.15);
}
.product-img {
  width: 100%;
  height: 220px;
  object-fit: cover;
  transition: transform .4s ease;
}
.product-card:hover .product-img {
  transform: scale(1.08);
}

/* ===== FOOTER ===== */
.footer-modern {
  background: #111;
  border-top: 1px solid rgba(255,255,255,0.1);
}

/* Gradient Light */
.bg-gradient-light {
  background: linear-gradient(to right, #f8f9fa, #e9ecef);
}
</style>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
