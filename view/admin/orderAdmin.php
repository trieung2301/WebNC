<?php 
include __DIR__ . "/components/header.php";
include __DIR__ . "/components/navbar.php";
include __DIR__ . "/components/sidebar.php";

$orders = $orders ?? []; 
$statusMap = OrderAdminController::STATUS_MAP; //lấy giá trị của STATUS_MAP trong OrderAdminController
$statusKeys = array_keys($statusMap); 

?>

<div class="main-content">
    <h1 class="mb-4 text-dark"><i class="fa-solid fa-shopping-cart"></i> Quản lý đơn hàng</h1> 

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Khách hàng</th>
                <th>Tổng tiền</th>
                <th>Địa chỉ nhận</th>
                <th>Ngày tạo</th>
                <th>Phương thức</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($orders)): ?>
                <tr>
                    <td colspan="8">Chưa có đơn hàng nào.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($orders as $order): 
                    $statusText = trim($order['status'] ?? 'Không rõ'); 
                    $badgeColor = $statusColors[$statusText] ?? 'secondary';
                ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td><?= $order['user_name'] ?? 'Khách vãng lai' ?></td>
                    <td><?= number_format($order['total'], 0, ',', '.') ?> VNĐ</td>
                    <td><?= $order['address'] . ', ' . $order['district'] . ', ' . $order['city'] ?></td>
                    <td><?= $order['created_at'] ?></td>
                    <td><?= $order['payment_method'] ?? 'Không rõ' ?></td>
                    
                    <td>
                        <span class="badge bg-<?= $badgeColor ?>">
                            <?= $statusText ?>
                        </span>
                    </td>
                    <td class="d-flex flex-column flex-lg-row align-items-lg-center">
                        
                        <a href="index.php?action=admin/orders/detail&id=<?= $order['id'] ?>" 
                            class="btn btn-sm btn-primary mb-2 mb-lg-0 me-lg-2" 
                            title="Xem chi tiết đơn hàng #<?= $order['id'] ?>">
                                <i class="fa-solid fa-eye me-1"></i> 
                            </a>
                        
                        <form action="index.php?action=admin/orders/updateStatus" method="POST" class="d-flex align-items-center">
                            <input type="hidden" name="id" value="<?= $order['id'] ?>">
                            
                            <select name="status" class="form-select-sm">
                                <?php foreach ($statusKeys  as $name): ?>
                                    <option value="<?= $name ?>" 
                                        <?= ($statusText === $name) ? 'selected' : '' ?>>
                                        <?= $name ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            
                            <button type="submit" class="btn btn-sm btn-info ms-2">Cập nhật</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>