<?php 
include __DIR__ . "/components/header.php";
include __DIR__ . "/components/navbar.php";
include __DIR__ . "/components/sidebar.php";

$orders = $orders ?? []; 
$statusMap = OrderAdminController::STATUS_MAP; //lấy giá trị của STATUS_MAP trong OrderAdminController
$statusKeys = array_keys($statusMap); 

// THÊM: Thiết lập mảng màu sắc trạng thái (để dùng trong bảng)
$statusColors = [];
foreach ($statusMap as $key => $value) {
    $statusColors[$key] = $value['class'];
}
// THÊM: Lấy các biến từ Controller
$currentStatusKey = $currentStatusKey ?? 'Tất cả'; 
$allStatusesKeys = $allStatusesKeys ?? ['Tất cả', 'Chờ xác nhận', 'Đang giao', 'Giao thành công', 'Đã hủy']; // Giá trị mặc định

?>

<div class="main-content">
    <h1 class="mb-4 text-dark"><i class="fa-solid fa-shopping-cart"></i> Quản lý đơn hàng</h1> 

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
    <?php endif; ?>

    <ul class="nav nav-tabs mb-4">
        <?php foreach ($allStatusesKeys as $statusName): ?>
            <?php 
            // Tạo URL để lọc trạng thái
            $url = ($statusName === 'Tất cả') ? '/php-pj/admin/orders' : '/php-pj/admin/orders&status=' . urlencode($statusName);
            $isActive = ($currentStatusKey === $statusName) ? 'active' : '';
            ?>
            <li class="nav-item">
                <a class="nav-link <?= $isActive ?>" href="<?= $url ?>">
                    <?= htmlspecialchars($statusName) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
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
                    <td colspan="8" class="text-center">
                        <?php if ($currentStatusKey === 'Tất cả'): ?>
                            Chưa có đơn hàng nào.
                        <?php else: ?>
                            Không có đơn hàng nào ở trạng thái **<?= htmlspecialchars($currentStatusKey) ?>**.
                        <?php endif; ?>
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($orders as $order): 
                    $statusText = trim($order['status'] ?? 'Không rõ'); 
                    // Lấy màu sắc từ mảng $statusColors (đã định nghĩa ở trên)
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
                        
                        <a href="/php-pj/admin/orders/detail&id=<?= $order['id'] ?>" 
                            class="btn btn-sm btn-primary mb-2 mb-lg-0 me-lg-2" 
                            title="Xem chi tiết đơn hàng #<?= $order['id'] ?>">
                                <i class="fa-solid fa-eye me-1"></i> 
                            </a>
                        
                        <form action="/php-pj/admin/orders/updateStatus" method="POST" class="d-flex align-items-center">
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