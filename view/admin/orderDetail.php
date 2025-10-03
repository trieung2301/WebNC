<?php
include __DIR__ . "/components/header.php";
include __DIR__ . "/components/navbar.php";
include __DIR__ . "/components/sidebar.php";

function formatCurrency($amount) {
    return number_format($amount, 0, ',', '.') . ' VNĐ';
}

function formatDate($datetimeString) {
    if (empty($datetimeString) || $datetimeString === 'N/A') {
        return 'N/A';
    }
    try {
        $date = new DateTime($datetimeString);
        return $date->format('d-m-Y H:i:s'); 
    } catch (Exception $e) {
        return htmlspecialchars($datetimeString);
    }
}

function formatShippingAddress($orderDetail) {
    $addressParts = [];
    if (!empty($orderDetail['address'])) $addressParts[] = $orderDetail['address'];
    if (!empty($orderDetail['district'])) $addressParts[] = $orderDetail['district'];
    if (!empty($orderDetail['city'])) $addressParts[] = $orderDetail['city'];

    return htmlspecialchars(implode(', ', $addressParts) ?: 'N/A');
}

?>

<div class="main-content">
    <div class="container-fluid">
        <h1 class="mb-4 text-dark"><i class="fa-solid fa-receipt"></i> Chi tiết Đơn hàng #<?= htmlspecialchars($orderId) ?></h1>

        <div class="d-flex justify-content-between mb-4">
            <a href="index.php?action=admin/orders" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i> Quay lại Danh sách Đơn hàng
            </a>
            
            <span class="fs-4">
                Trạng thái: <span class="badge bg-<?= htmlspecialchars($badgeColor) ?>"><?= htmlspecialchars($statusText) ?></span>
            </span>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                Thông tin Giao nhận & Thanh toán
            </div>
            <div class="card-body row">
                <div class="col-md-6">
                    <h5 class="fw-bold">Thông tin Khách hàng</h5>
                    <p><strong>Khách hàng:</strong> <?= htmlspecialchars($orderDetail['fullname'] ?? 'N/A') ?></p> 
                    <p><strong>Ngày đặt:</strong> <?= formatDate($orderDetail['created_at'] ?? 'N/A') ?></p>
                    <p><strong>Phương thức TT:</strong> <?= htmlspecialchars($orderDetail['payment_method'] ?? 'N/A') ?></p>
                </div>
                <div class="col-md-6">
                    <h5 class="fw-bold">Địa chỉ Giao hàng</h5>
                    <p><strong>Người nhận:</strong> <?= htmlspecialchars($orderDetail['fullname'] ?? 'N/A') ?></p> 
                    <p><strong>SĐT:</strong> <?= htmlspecialchars($orderDetail['phone'] ?? 'N/A') ?></p>
                    <p><strong>Địa chỉ:</strong> <?= formatShippingAddress($orderDetail) ?></p>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header bg-dark text-white">
                Sản phẩm đã đặt
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Giá (Đơn vị)</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $subtotal = 0; ?>
                        <?php foreach ($orderItems as $item): 
                            $itemTotal = ($item['quantity'] ?? 0) * ($item['price'] ?? 0); 
                            $subtotal += $itemTotal;
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($item['name'] ?? 'Sản phẩm không rõ') ?></td>
                                <td><?= formatCurrency($item['price'] ?? 0) ?></td>
                                <td><?= htmlspecialchars($item['quantity'] ?? 0) ?></td>
                                <td><?= formatCurrency($itemTotal) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Tổng tiền hàng:</th>
                            <th><?= formatCurrency($subtotal) ?></th>
                        </tr>
                        <?php 
                        $discountAmount = $orderDetail['discount_amount'] ?? 0;
                        if ($discountAmount > 0): 
                        ?>
                        <tr>
                            <th colspan="3" class="text-end">Giảm giá (<?= htmlspecialchars($orderDetail['discount_code'] ?? '') ?>):</th>
                            <th class="text-danger">- <?= formatCurrency($discountAmount) ?></th>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <th colspan="3" class="text-end text-success fs-5">TỔNG THANH TOÁN:</th>
                            <th class="text-success fs-5"><?= formatCurrency($orderDetail['total'] ?? $subtotal) ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>
</div>