<?php include __DIR__ . '/components/header.php'; ?>

<div class="container my-5">
    <h2 class="mb-4 text-center">Giỏ hàng của bạn</h2>

    <?php if (!empty($cartItems)): ?>
        <table class="table table-bordered table-striped align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Tổng</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                $total = 0;
                foreach ($cartItems as $item): 
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
            ?>
                <tr>
                    <td><img src="view/image/<?= htmlspecialchars($item['image']) ?>" width="70" alt="Sản phẩm"></td>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= number_format($item['price'], 0, ',', '.') ?>₫</td>
                    <td><?= $item['quantity'] ?></td>
                    <td><?= number_format($subtotal, 0, ',', '.') ?>₫</td>
                    <td>
                        <form action="index.php?action=cart" method="POST" onsubmit="return confirm('Xóa sản phẩm này khỏi giỏ?')">
                            <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <div class="text-end">
            <h4>Tổng cộng: <span class="text-danger"><?= number_format($total, 0, ',', '.') ?>₫</span></h4>
            <a href="index.php?action=checkout" class="btn btn-success btn-lg mt-3">Thanh toán</a>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">
            Giỏ hàng của bạn đang trống!
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
