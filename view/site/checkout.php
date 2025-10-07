<?php include __DIR__ . '/components/header.php'; ?>
<div class="container my-5">
  <h1 class="mb-4 text-center">Trang Đặt Hàng</h1>
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger text-center">
          <?= htmlspecialchars($error) ?>
      </div>
  <?php endif; ?>
  <form method="POST" action="">
    <!-- Họ và tên -->
    <div class="mb-3">
      <label for="fullname" class="form-label">Họ và Tên</label>
      <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Nhập họ và tên" required>
    </div>

    <!-- Số điện thoại -->
    <div class="mb-3">
      <label for="phone" class="form-label">Số điện thoại</label>
      <input type="text" class="form-control" id="phone" name="phone" placeholder="Nhập số điện thoại" required>
    </div>

    <!-- Email -->
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email" required>
    </div>

    <!-- Địa chỉ -->
    <div class="mb-3">
      <label for="address" class="form-label">Địa chỉ</label>
      <input type="text" class="form-control" id="address" name="address" placeholder="Số nhà, đường..." required>
    </div>

    <div class="row">
      <div class="col-md-4 mb-3">
        <label for="district" class="form-label">Quận / Huyện</label>
        <input type="text" class="form-control" id="district" name="district" placeholder="VD: Quận 1" required>
      </div>
      <div class="col-md-4 mb-3">
        <label for="city" class="form-label">Thành phố</label>
        <input type="text" class="form-control" id="city" name="city" placeholder="VD: Hồ Chí Minh" required>
      </div>
      <div class="col-md-4 mb-3">
        <label for="postcode" class="form-label">Mã bưu điện</label>
        <input type="text" class="form-control" id="postcode" name="postcode" placeholder="VD: 700000">
      </div>
    </div>

    <!-- Ghi chú -->
    <div class="mb-3">
      <label for="note" class="form-label">Ghi chú</label>
      <textarea class="form-control" id="note" name="note" rows="3" placeholder="Ghi chú thêm (tuỳ chọn)"></textarea>
    </div>

    <!-- Phương thức thanh toán -->
    <div class="mb-3">
      <label class="form-label">Phương thức thanh toán</label>
      <select class="form-select" id="payment_method" name="payment_method">
        <option value="Tiền mặt">Thanh toán khi nhận hàng (COD)</option>
        <option value="Chuyển khoản">Ví MoMo</option>
      </select>
    </div>

    <!-- Mã giảm giá -->
    <div class="mb-3">
      <label for="coupon" class="form-label">Mã giảm giá</label>
      <input type="text" class="form-control" id="coupon" name="coupon" placeholder="Nhập mã coupon" value="<?= isset($_POST['coupon']) ? htmlspecialchars($_POST['coupon']) : '' ?>">
    </div>

    <!-- Tổng tiền -->
    <div class="mb-3">
      <label for="total_display" class="form-label">Tổng tiền</label>
      <input type="text" class="form-control" id="total_display" value="<?= number_format($total,0,',','.') ?> VND" readonly>
      <input type="hidden" name="total" value="<?= $total ?>">
    </div>

    <!-- Nút đặt hàng -->
    <button type="submit" class="btn btn-primary w-100">Đặt hàng</button>
      </form>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</script>
</body>
</html>