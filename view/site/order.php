<?php
include __DIR__ . '/components/header.php';
?>


<style>
body {
    background: #f5f7fa;     
}

/* Nav Pills */
.nav-pills .nav-link {
    background: #004f9fff; 
    color: #555;
    font-weight: 500;
    border-radius: 20px;
    margin: 0 6px;
    padding: 8px 18px;
    transition: all 0.3s ease;
    border: 1px solid #d0d0d0;
}

.nav-pills .nav-link:hover {
    background: #d6e4f0;       
    color: #007bff;
}

.nav-pills .nav-link.active {
    background: linear-gradient(90deg,#4facfe,#00c6ff); 
    color: #fff;
    font-weight: 600;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}


.table thead {
    font-weight: 600;
}
.table {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}
</style>

<div class="container py-5">
    <h1 class="text-center mb-5">Đơn hàng của tôi</h1>

    <!-- Nav Pills -->
    <ul class="nav nav-pills justify-content-center mb-4" id="orderTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-pending-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-pending" type="button" role="tab">
                <i class="fa-solid fa-clock me-1"></i> Đơn đặt hàng
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-completed-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-completed" type="button" role="tab">
                <i class="fa-solid fa-check me-1"></i> Lịch sử đơn hàng
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-cancelled-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-cancelled" type="button" role="tab">
                <i class="fa-solid fa-ban me-1"></i> Đơn đã hủy
            </button>
        </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content" id="orderTabsContent">

        <!-- Pending -->
        <div class="tab-pane fade show active" id="pills-pending" role="tabpanel">
            <?php if (!empty($pendingOrders)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>Ngày mua</th>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($pendingOrders as $index => $order): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($order['order_date']) ?></td>
                                <td><?= htmlspecialchars($order['product_name']) ?></td>
                                <td><?= $order['quantity'] ?></td>
                                <td><?= number_format($order['total_price'], 0, ',', '.') ?> VNĐ</td>
                                <td><span class="badge bg-warning text-dark"><?= htmlspecialchars($order['status']) ?></span></td>
                                <td>
                                    <?php if ($order['status'] === 'Chờ xác nhận'): ?>
                                        <form action="/php-pj/order" method="POST" style="display:inline;">
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

        <!-- Completed -->
        <div class="tab-pane fade" id="pills-completed" role="tabpanel">
            <?php if (!empty($completedOrders)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle text-center">
                        <thead class="table-success">
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
                        <?php foreach ($completedOrders as $index => $order): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($order['order_date']) ?></td>
                                <td><?= htmlspecialchars($order['product_name']) ?></td>
                                <td><?= $order['quantity'] ?></td>
                                <td><?= number_format($order['total_price'], 0, ',', '.') ?> VNĐ</td>
                                <td><span class="badge bg-success"><?= htmlspecialchars($order['status']) ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-center fs-5">Bạn chưa có đơn hàng đã hoàn tất nào.</p>
            <?php endif; ?>
        </div>

        <!-- Cancelled -->
        <div class="tab-pane fade" id="pills-cancelled" role="tabpanel">
            <?php if (!empty($cancelledOrders)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle text-center">
                        <thead class="table-danger">
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
                        <?php foreach ($cancelledOrders as $index => $order): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($order['order_date']) ?></td>
                                <td><?= htmlspecialchars($order['product_name']) ?></td>
                                <td><?= $order['quantity'] ?></td>
                                <td><?= number_format($order['total_price'], 0, ',', '.') ?> VNĐ</td>
                                <td><span class="badge bg-danger"><?= htmlspecialchars($order['status']) ?></span></td>
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
