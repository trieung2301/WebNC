<?php
include __DIR__ . '/components/header.php';
?>

<div class="container py-5">
    <h1 class="mb-4 text-center">Đơn hàng của tôi</h1>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs mb-4" id="orderTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">Đơn đặt hàng</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button" role="tab">Lịch sử đơn hàng</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="cancelled-tab" data-bs-toggle="tab" data-bs-target="#cancelled" type="button" role="tab">Đơn đã hủy</button>
        </li> 
    </ul>

    <!-- Tab content -->
    <div class="tab-content">
        <!-- Pending Orders -->
        <div class="tab-pane fade show active" id="pending" role="tabpanel">
            <?php if (!empty($pendingOrders)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Ngày mua</th>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($pendingOrders as $index => $order): ?> <!--key value-->
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($order['order_date']) ?></td>
                                <td><?= htmlspecialchars($order['product_name']) ?></td>
                                <td><?= $order['quantity'] ?></td>
                                <td><?= number_format($order['total_price'], 0, ',', '.') ?> VNĐ</td>
                                <td><span class="badge bg-warning text-dark"><?= htmlspecialchars($order['status']) ?></span></td>
                                <td>
                                    <?php if ($order['status'] === 'Chờ xác nhận'): ?>
                                        <form action="/php-pj/index.php?action=order" method="POST" style="display:inline;">
                                            <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này không?')">
                                                Hủy
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <button class="btn btn-secondary btn-sm" disabled>Không thể hủy</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>
            <?php else: ?>
                <p class="text-center fs-5">Bạn chưa có đơn đặt hàng nào.</p>
            <?php endif; ?>
        </div>

        <!-- Completed Orders -->
        <div class="tab-pane fade" id="completed" role="tabpanel">
            <?php if (!empty($completedOrders)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Ngày mua</th>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($completedOrders as $index => $c): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= htmlspecialchars($c['order_date']) ?></td>
                                    <td><?= htmlspecialchars($c['product_name']) ?></td>
                                    <td><?= $c['quantity'] ?></td>
                                    <td><?= number_format($c['total_price'], 0, ',', '.') ?> VNĐ</td>
                                    <td><span class="badge bg-success"><?= htmlspecialchars($c['status']) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-center fs-5">Bạn chưa có đơn hàng đã hoàn tất nào.</p>
            <?php endif; ?>
        </div>
    <!-- Cancelled Orders -->
        <div class="tab-pane fade" id="cancelled" role="tabpanel">
            <?php if (!empty($cancelledOrders)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Ngày mua</th>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cancelledOrders as $index => $o): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= htmlspecialchars($o['order_date']) ?></td>
                                    <td><?= htmlspecialchars($o['product_name']) ?></td>
                                    <td><?= $o['quantity'] ?></td>
                                    <td><?= number_format($o['total_price'], 0, ',', '.') ?> VNĐ</td>
                                    <td><span class="badge bg-danger"><?= htmlspecialchars($o['status']) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-center fs-5">Bạn chưa có đơn hàng bị hủy nào.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
