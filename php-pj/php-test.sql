-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2025 at 12:16 PM
-- Server version: 11.6.2-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php-test`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() -- Đã sửa lỗi tại dòng này
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Đồng hồ nam', 'dong-ho-nam', 'Đồng hồ nam', 1, '2025-09-18 13:23:18', '2025-09-19 12:18:08'),
(2, 'Đồng hồ nữ', 'dong-ho-nu', 'Đồng hồ nữ', 1, '2025-09-18 13:23:18', '2025-09-19 12:18:18');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `used_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `discount_value`, `expires_at`, `usage_limit`, `used_count`) VALUES
(1, 'GIAM10', 10.00, '2025-09-18 23:59:59', 100, 0),
(3, 'VIP30', 30.00, '2025-09-25 14:19:48', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `coupon_usages`
--

CREATE TABLE `coupon_usages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `used_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `district` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `postcode` varchar(20) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `total` decimal(12,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT 0.00,
  `stock` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `description`, `image`, `price`, `stock`, `category_id`, `created_at`, `updated_at`) VALUES
(30, 'ABC-classic', 'abc-classic', 'đồng hồ này đẹp', 'dong-ho-nu.jpg', 4120000.00, 8, 2, '2025-09-18 08:32:19', '2025-09-22 12:47:31'),
(31, 'Standard Watch', 'standard-watch', 'dfdfdfd', 'dong-ho-nam.jpg', 6300000.00, 9, 1, '2025-09-18 08:32:52', '2025-09-22 12:47:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(32) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `password`, `email`, `phone`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Trần Chí Nghị', 'Cisnij', '$2y$10$e0NR8w3Jf9R/1yP5/3Dq2u8l2b8T3d9k6Z5wO2VtXQ0F1yPjG0E2K', 'admin@gmail.com', '0937861899', 'admin', '2025-09-18 13:00:24', '2025-09-19 12:20:01'),
(2, 'admin', 'admin', '$2y$10$A1wHFPSwGDXH08uoHEDFSe7aqYuJTpSbA39yI3wrx2Ynv8wi5bgYq', 'adfadf', '0937861899', 'admin', '2025-09-20 16:03:36', '2025-09-20 16:03:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_id`),
  ADD KEY `fk_product` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `fk_coupon` (`coupon_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `fk_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  ADD CONSTRAINT `coupon_usages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `coupon_usages_ibfk_2` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`),
  ADD CONSTRAINT `coupon_usages_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `password`, `email`, `phone`, `role`, `created_at`, `updated_at`) VALUES
(3, 'Nguyễn Văn A', 'nguyenvana', '$2y$10$A1wHFPSwGDXH08uoHEDFSe7aqYuJTpSbA39yI3wrx2Ynv8wi5bgYq', 'nguyenvana@gmail.com', '0912345678', 'user', '2025-09-24 12:00:00', '2025-09-24 12:00:00'),
(4, 'Lê Thị B', 'lethib', '$2y$10$A1wHFPSwGDXH08uoHEDFSe7aqYuJTpSbA39yI3wrx2Ynv8wi5bgYq', 'lethib@gmail.com', '0912345679', 'user', '2025-09-24 12:01:00', '2025-09-24 12:01:00'),
(5, 'Phạm Văn C', 'phamvanc', '$2y$10$A1wHFPSwGDXH08uoHEDFSe7aqYuJTpSbA39yI3wrx2Ynv8wi5bgYq', 'phamvanc@gmail.com', '0912345680', 'user', '2025-09-24 12:02:00', '2025-09-24 12:02:00'),
(6, 'Trần Văn D', 'tranvand', '$2y$10$A1wHFPSwGDXH08uoHEDFSe7aqYuJTpSbA39yI3wrx2Ynv8wi5bgYq', 'tranvand@gmail.com', '0912345681', 'user', '2025-09-24 12:03:00', '2025-09-24 12:03:00'),
(7, 'Hoàng Thị E', 'hoangthie', '$2y$10$A1wHFPSwGDXH08uoHEDFSe7aqYuJTpSbA39yI3wrx2Ynv8wi5bgYq', 'hoangthie@gmail.com', '0912345682', 'user', '2025-09-24 12:04:00', '2025-09-24 12:04:00'),
(8, 'Vũ Đình F', 'vudinhf', '$2y$10$A1wHFPSwGDXH08uoHEDFSe7aqYuJTpSbA39yI3wrx2Ynv8wi5bgYq', 'vudinhf@gmail.com', '0912345683', 'user', '2025-09-24 12:05:00', '2025-09-24 12:05:00'),
(9, 'Bùi Minh G', 'buiminhg', '$2y$10$A1wHFPSwGDXH08uoHEDFSe7aqYuJTpSbA39yI3wrx2Ynv8wi5bgYq', 'buiminhg@gmail.com', '0912345684', 'user', '2025-09-24 12:06:00', '2025-09-24 12:06:00'),
(10, 'Đặng Thị H', 'dangthih', '$2y$10$A1wHFPSwGDXH08uoHEDFSe7aqYuJTpSbA39yI3wrx2Ynv8wi5bgYq', 'dangthih@gmail.com', '0912345685', 'user', '2025-09-24 12:07:00', '2025-09-24 12:07:00'),
(11, 'Cao Văn I', 'caovani', '$2y$10$A1wHFPSwGDXH08uoHEDFSe7aqYuJTpSbA39yI3wrx2Ynv8wi5bgYq', 'caovani@gmail.com', '0912345686', 'user', '2025-09-24 12:08:00', '2025-09-24 12:08:00'),
(12, 'Hồ Thị J', 'hothij', '$2y$10$A1wHFPSwGDXH08uoHEDFSe7aqYuJTpSbA39yI3wrx2Ynv8wi5bgYq', 'hothij@gmail.com', '0912345687', 'user', '2025-09-24 12:09:00', '2025-09-24 12:09:00'),
(13, 'Lê Văn K', 'levank', '$2y$10$A1wHFPSwGDXH08uoHEDFSe7aqYuJTpSbA39yI3wrx2Ynv8wi5bgYq', 'levank@gmail.com', '0912345688', 'user', '2025-09-24 12:10:00', '2025-09-24 12:10:00'),
(14, 'Nguyễn Thị L', 'nguyenthil', '$2y$10$A1wHFPSwGDXH08uoHEDFSe7aqYuJTpSbA39yI3wrx2Ynv8wi5bgYq', 'nguyenthil@gmail.com', '0912345689', 'user', '2025-09-24 12:11:00', '2025-09-24 12:11:00'),
(15, 'Phạm Văn M', 'phamvanm', '$2y$10$A1wHFPSwGDXH08uoHEDFSe7aqYuJTpSbA39yI3wrx2Ynv8wi5bgYq', 'phamvanm@gmail.com', '0912345690', 'user', '2025-09-24 12:12:00', '2025-09-24 12:12:00'),
(16, 'Đỗ Văn N', 'dovann', '$2y$10$A1wHFPSwGDXH08uoHEDFSe7aqYuJTpSbA39yI3wrx2Ynv8wi5bgYq', 'dovann@gmail.com', '0912345691', 'user', '2025-09-24 12:13:00', '2025-09-24 12:13:00'),
(17, 'Lý Thị O', 'lythio', '$2y$10$A1wHFPSwGDXH08uoHEDFSe7aqYuJTpSbA39yI3wrx2Ynv8wi5bgYq', 'lythio@gmail.com', '0912345692', 'user', '2025-09-24 12:14:00', '2025-09-24 12:14:00'),
(18, 'Trịnh Văn P', 'trinhvanp', '$2y$10$A1wHFPSwGDXH08uoHEDFSe7aqYuJTpSbA39yI3wrx2Ynv8wi5bgYq', 'trinhvanp@gmail.com', '0912345693', 'user', '2025-09-24 12:15:00', '2025-09-24 12:15:00'),
(19, 'Bùi Thị Q', 'buithiq', '$2y$10$A1wHFPSwGDXH08uoHEDFSe7aqYuJTpSbA39yI3wrx2Ynv8wi5bgYq', 'buithiq@gmail.com', '0912345694', 'user', '2025-09-24 12:16:00', '2025-09-24 12:16:00'),
(20, 'Đinh Văn R', 'dinhvanr', '$2y$10$A1wHFPSwGDXH08uoHEDFSe7aqYuJTpSbA39yI3wrx2Ynv8wi5bgYq', 'dinhvanr@gmail.com', '0912345695', 'user', '2025-09-24 12:17:00', '2025-09-24 12:17:00'),
(21, 'Lê Văn S', 'levans', '$2y$10$A1wHFPSwGDXH08uoHEDFSe7aqYuJTpSbA39yI3wrx2Ynv8wi5bgYq', 'levans@gmail.com', '0912345696', 'user', '2025-09-24 12:18:00', '2025-09-24 12:18:00'),
(22, 'Phan Thị T', 'phanthit', '$2y$10$A1wHFPSwGDXH08uoHEDFSe7aqYuJTpSbA39yI3wrx2Ynv8wi5bgYq', 'phanthit@gmail.com', '0912345697', 'user', '2025-09-24 12:19:00', '2025-09-24 12:19:00');

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `status`, `created_at`, `updated_at`) VALUES
(3, 'Đồng hồ điện tử', 'dong-ho-dien-tu', 'Đồng hồ điện tử', 1, '2025-09-24 12:20:00', '2025-09-24 12:20:00'),
(4, 'Đồng hồ cơ', 'dong-ho-co', 'Đồng hồ cơ', 1, '2025-09-24 12:21:00', '2025-09-24 12:21:00'),
(5, 'Đồng hồ thông minh', 'dong-ho-thong-minh', 'Đồng hồ thông minh', 1, '2025-09-24 12:22:00', '2025-09-24 12:22:00'),
(6, 'Đồng hồ thể thao', 'dong-ho-the-thao', 'Đồng hồ thể thao', 1, '2025-09-24 12:23:00', '2025-09-24 12:23:00'),
(7, 'Đồng hồ đeo tay', 'dong-ho-deo-tay', 'Đồng hồ đeo tay', 1, '2025-09-24 12:24:00', '2025-09-24 12:24:00'),
(8, 'Đồng hồ treo tường', 'dong-ho-treo-tuong', 'Đồng hồ treo tường', 1, '2025-09-24 12:25:00', '2025-09-24 12:25:00'),
(9, 'Đồng hồ cao cấp', 'dong-ho-cao-cap', 'Đồng hồ cao cấp', 1, '2025-09-24 12:26:00', '2025-09-24 12:26:00'),
(10, 'Đồng hồ giá rẻ', 'dong-ho-gia-re', 'Đồng hồ giá rẻ', 1, '2025-09-24 12:27:00', '2025-09-24 12:27:00'),
(11, 'Đồng hồ trẻ em', 'dong-ho-tre-em', 'Đồng hồ trẻ em', 1, '2025-09-24 12:28:00', '2025-09-24 12:28:00'),
(12, 'Đồng hồ cho người lớn', 'dong-ho-nguoi-lon', 'Đồng hồ cho người lớn', 1, '2025-09-24 12:29:00', '2025-09-24 12:29:00'),
(13, 'Đồng hồ nhập khẩu', 'dong-ho-nhap-khau', 'Đồng hồ nhập khẩu', 1, '2025-09-24 12:30:00', '2025-09-24 12:30:00'),
(14, 'Đồng hồ sản xuất trong nước', 'dong-ho-trong-nuoc', 'Đồng hồ sản xuất trong nước', 1, '2025-09-24 12:31:00', '2025-09-24 12:31:00'),
(15, 'Đồng hồ đeo tay', 'dong-ho-deo-tay-2', 'Đồng hồ đeo tay 2', 1, '2025-09-24 12:32:00', '2025-09-24 12:32:00'),
(16, 'Đồng hồ cao cấp', 'dong-ho-cao-cap-2', 'Đồng hồ cao cấp 2', 1, '2025-09-24 12:33:00', '2025-09-24 12:33:00'),
(17, 'Đồng hồ giá rẻ', 'dong-ho-gia-re-2', 'Đồng hồ giá rẻ 2', 1, '2025-09-24 12:34:00', '2025-09-24 12:34:00'),
(18, 'Đồng hồ trẻ em', 'dong-ho-tre-em-2', 'Đồng hồ trẻ em 2', 1, '2025-09-24 12:35:00', '2025-09-24 12:35:00'),
(19, 'Đồng hồ cho người lớn', 'dong-ho-nguoi-lon-2', 'Đồng hồ cho người lớn 2', 1, '2025-09-24 12:36:00', '2025-09-24 12:36:00'),
(20, 'Đồng hồ nhập khẩu', 'dong-ho-nhap-khau-2', 'Đồng hồ nhập khẩu 2', 1, '2025-09-24 12:37:00', '2025-09-24 12:37:00'),
(21, 'Đồng hồ sản xuất trong nước', 'dong-ho-trong-nuoc-2', 'Đồng hồ sản xuất trong nước 2', 1, '2025-09-24 12:38:00', '2025-09-24 12:38:00');

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `description`, `image`, `price`, `stock`, `category_id`, `created_at`, `updated_at`) VALUES
(32, 'Luxury Watch A', 'luxury-watch-a', 'Đồng hồ cao cấp dành cho nam', 'product_1.jpg', 15000000.00, 15, 1, '2025-09-24 12:30:00', '2025-09-24 12:30:00'),
(33, 'Sport Watch B', 'sport-watch-b', 'Đồng hồ thể thao năng động', 'product_2.jpg', 3500000.00, 30, 6, '2025-09-24 12:31:00', '2025-09-24 12:31:00'),
(34, 'Classic Watch C', 'classic-watch-c', 'Đồng hồ cơ cổ điển', 'product_3.jpg', 8200000.00, 25, 4, '2025-09-24 12:32:00', '2025-09-24 12:32:00'),
(35, 'Smart Watch D', 'smart-watch-d', 'Đồng hồ thông minh đa năng', 'product_4.jpg', 6800000.00, 40, 5, '2025-09-24 12:33:00', '2025-09-24 12:33:00'),
(36, 'Digital Watch E', 'digital-watch-e', 'Đồng hồ điện tử tiện lợi', 'product_5.jpg', 1200000.00, 50, 3, '2025-09-24 12:34:00', '2025-09-24 12:34:00'),
(37, 'Women Watch F', 'women-watch-f', 'Đồng hồ nữ sang trọng', 'product_6.jpg', 7500000.00, 20, 2, '2025-09-24 12:35:00', '2025-09-24 12:35:00'),
(38, 'Men Watch G', 'men-watch-g', 'Đồng hồ nam thanh lịch', 'product_7.jpg', 9800000.00, 18, 1, '2025-09-24 12:36:00', '2025-09-24 12:36:00'),
(39, 'Kid Watch H', 'kid-watch-h', 'Đồng hồ trẻ em màu sắc', 'product_8.jpg', 500000.00, 100, 11, '2025-09-24 12:37:00', '2025-09-24 12:37:00'),
(40, 'Wall Clock I', 'wall-clock-i', 'Đồng hồ treo tường trang trí', 'product_9.jpg', 1800000.00, 12, 8, '2025-09-24 12:38:00', '2025-09-24 12:38:00'),
(41, 'Luxury Watch J', 'luxury-watch-j', 'Đồng hồ cao cấp nhập khẩu', 'product_10.jpg', 25000000.00, 7, 9, '2025-09-24 12:39:00', '2025-09-24 12:39:00'),
(42, 'Vintage Watch K', 'vintage-watch-k', 'Đồng hồ cổ điển', 'product_11.jpg', 9000000.00, 10, 4, '2025-09-24 12:40:00', '2025-09-24 12:40:00'),
(43, 'Fashion Watch L', 'fashion-watch-l', 'Đồng hồ thời trang', 'product_12.jpg', 2300000.00, 22, 2, '2025-09-24 12:41:00', '2025-09-24 12:41:00'),
(44, 'Minimalist Watch M', 'minimalist-watch-m', 'Đồng hồ thiết kế tối giản', 'product_13.jpg', 3800000.00, 28, 7, '2025-09-24 12:42:00', '2025-09-24 12:42:00'),
(45, 'Chronograph Watch N', 'chronograph-watch-n', 'Đồng hồ bấm giờ', 'product_14.jpg', 12500000.00, 14, 1, '2025-09-24 12:43:00', '2025-09-24 12:43:00'),
(46, 'Pilot Watch O', 'pilot-watch-o', 'Đồng hồ phi công', 'product_15.jpg', 18000000.00, 9, 1, '2025-09-24 12:44:00', '2025-09-24 12:44:00'),
(47, 'Diver Watch P', 'diver-watch-p', 'Đồng hồ lặn chuyên nghiệp', 'product_16.jpg', 22000000.00, 11, 1, '2025-09-24 12:45:00', '2025-09-24 12:45:00'),
(48, 'Quartz Watch Q', 'quartz-watch-q', 'Đồng hồ thạch anh', 'product_17.jpg', 4200000.00, 35, 3, '2025-09-24 12:46:00', '2025-09-24 12:46:00'),
(49, 'Solar Watch R', 'solar-watch-r', 'Đồng hồ năng lượng mặt trời', 'product_18.jpg', 6700000.00, 24, 5, '2025-09-24 12:47:00', '2025-09-24 12:47:00'),
(50, 'Hand-made Watch S', 'hand-made-watch-s', 'Đồng hồ thủ công', 'product_19.jpg', 30000000.00, 5, 9, '2025-09-24 12:48:00', '2025-09-24 12:48:00'),
(51, 'Tourbillon Watch T', 'tourbillon-watch-t', 'Đồng hồ Tourbillon', 'product_20.jpg', 90000000.00, 2, 9, '2025-09-24 12:49:00', '2025-09-24 12:49:00');

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `discount_value`, `expires_at`, `usage_limit`, `used_count`) VALUES
(4, 'GIAM20', 20.00, '2025-10-31 23:59:59', 50, 5),
(5, 'SALE50', 50.00, '2025-11-15 23:59:59', 10, 1),
(6, 'FREESHIP', 0.00, '2025-12-31 23:59:59', 200, 20);

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `fullname`, `phone`, `email`, `address`, `district`, `city`, `note`, `payment_method`, `total`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 'Nguyễn Văn A', '0912345678', 'nguyenvana@gmail.com', '123 Đường ABC', 'Quận 1', 'Hồ Chí Minh', 'Giao hàng nhanh', 'cod', 15000000.00, 'completed', '2025-09-24 13:00:00', '2025-09-24 13:01:00'),
(2, 4, 'Lê Thị B', '0912345679', 'lethib@gmail.com', '456 Đường XYZ', 'Quận 2', 'Hồ Chí Minh', NULL, 'online', 8200000.00, 'processing', '2025-09-24 13:02:00', '2025-09-24 13:02:00'),
(3, 5, 'Phạm Văn C', '0912345680', 'phamvanc@gmail.com', '789 Đường CDE', 'Quận 3', 'Hà Nội', NULL, 'cod', 1200000.00, 'pending', '2025-09-24 13:03:00', '2025-09-24 13:03:00'),
(4, 6, 'Trần Văn D', '0912345681', 'tranvand@gmail.com', '101 Đường FGH', 'Quận 4', 'Hà Nội', 'Gọi trước khi giao', 'online', 6800000.00, 'shipped', '2025-09-24 13:04:00', '2025-09-24 13:04:00'),
(5, 7, 'Hoàng Thị E', '0912345682', 'hoangthie@gmail.com', '102 Đường IJK', 'Quận 5', 'Đà Nẵng', NULL, 'cod', 7500000.00, 'completed', '2025-09-24 13:05:00', '2025-09-24 13:06:00'),
(6, 8, 'Vũ Đình F', '0912345683', 'vudinhf@gmail.com', '103 Đường LMN', 'Quận 6', 'Đà Nẵng', NULL, 'online', 9800000.00, 'processing', '2025-09-24 13:07:00', '2025-09-24 13:07:00'),
(7, 9, 'Bùi Minh G', '0912345684', 'buiminhg@gmail.com', '104 Đường OPQ', 'Quận 7', 'Hải Phòng', NULL, 'cod', 500000.00, 'pending', '2025-09-24 13:08:00', '2025-09-24 13:08:00'),
(8, 10, 'Đặng Thị H', '0912345685', 'dangthih@gmail.com', '105 Đường RST', 'Quận 8', 'Hải Phòng', 'Không gọi điện', 'online', 1800000.00, 'shipped', '2025-09-24 13:09:00', '2025-09-24 13:09:00'),
(9, 11, 'Cao Văn I', '0912345686', 'caovani@gmail.com', '106 Đường UVW', 'Quận 9', 'Cần Thơ', NULL, 'cod', 25000000.00, 'completed', '2025-09-24 13:10:00', '2025-09-24 13:11:00'),
(10, 12, 'Hồ Thị J', '0912345687', 'hothij@gmail.com', '107 Đường XYZ', 'Quận 10', 'Cần Thơ', NULL, 'online', 9000000.00, 'processing', '2025-09-24 13:12:00', '2025-09-24 13:12:00'),
(11, 13, 'Lê Văn K', '0912345688', 'levank@gmail.com', '108 Đường ABC', 'Quận 11', 'Hồ Chí Minh', NULL, 'cod', 2300000.00, 'pending', '2025-09-24 13:13:00', '2025-09-24 13:13:00'),
(12, 14, 'Nguyễn Thị L', '0912345689', 'nguyenthil@gmail.com', '109 Đường DFG', 'Quận 12', 'Hồ Chí Minh', 'Giao hàng buổi sáng', 'online', 3800000.00, 'shipped', '2025-09-24 13:14:00', '2025-09-24 13:14:00'),
(13, 15, 'Phạm Văn M', '0912345690', 'phamvanm@gmail.com', '110 Đường HKL', 'Thủ Đức', 'Hồ Chí Minh', NULL, 'cod', 12500000.00, 'completed', '2025-09-24 13:15:00', '2025-09-24 13:16:00'),
(14, 16, 'Đỗ Văn N', '0912345691', 'dovann@gmail.com', '111 Đường MNO', 'Thủ Đức', 'Hồ Chí Minh', NULL, 'online', 18000000.00, 'processing', '2025-09-24 13:17:00', '2025-09-24 13:17:00'),
(15, 17, 'Lý Thị O', '0912345692', 'lythio@gmail.com', '112 Đường PQR', 'Thủ Đức', 'Hồ Chí Minh', NULL, 'cod', 22000000.00, 'pending', '2025-09-24 13:18:00', '2025-09-24 13:18:00'),
(16, 18, 'Trịnh Văn P', '0912345693', 'trinhvanp@gmail.com', '113 Đường STU', 'Thủ Đức', 'Hồ Chí Minh', NULL, 'online', 4200000.00, 'shipped', '2025-09-24 13:19:00', '2025-09-24 13:19:00'),
(17, 19, 'Bùi Thị Q', '0912345694', 'buithiq@gmail.com', '114 Đường VWX', 'Hà Đông', 'Hà Nội', NULL, 'cod', 6700000.00, 'completed', '2025-09-24 13:20:00', '2025-09-24 13:21:00'),
(18, 20, 'Đinh Văn R', '0912345695', 'dinhvanr@gmail.com', '115 Đường YZA', 'Hà Đông', 'Hà Nội', NULL, 'online', 30000000.00, 'processing', '2025-09-24 13:22:00', '2025-09-24 13:22:00'),
(19, 21, 'Lê Văn S', '0912345696', 'levans@gmail.com', '116 Đường BCD', 'Hà Đông', 'Hà Nội', NULL, 'cod', 90000000.00, 'pending', '2025-09-24 13:23:00', '2025-09-24 13:23:00'),
(20, 22, 'Phan Thị T', '0912345697', 'phanthit@gmail.com', '117 Đường EFG', 'Hà Đông', 'Hà Nội', NULL, 'online', 15000000.00, 'shipped', '2025-09-24 13:24:00', '2025-09-24 13:24:00');

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 32, 1, 15000000.00, '2025-09-24 13:30:00', '2025-09-24 13:30:00'),
(2, 2, 34, 1, 8200000.00, '2025-09-24 13:31:00', '2025-09-24 13:31:00'),
(3, 3, 36, 1, 1200000.00, '2025-09-24 13:32:00', '2025-09-24 13:32:00'),
(4, 4, 35, 1, 6800000.00, '2025-09-24 13:33:00', '2025-09-24 13:33:00'),
(5, 5, 37, 1, 7500000.00, '2025-09-24 13:34:00', '2025-09-24 13:34:00'),
(6, 6, 38, 1, 9800000.00, '2025-09-24 13:35:00', '2025-09-24 13:35:00'),
(7, 7, 39, 1, 500000.00, '2025-09-24 13:36:00', '2025-09-24 13:36:00'),
(8, 8, 40, 1, 1800000.00, '2025-09-24 13:37:00', '2025-09-24 13:37:00'),
(9, 9, 41, 1, 25000000.00, '2025-09-24 13:38:00', '2025-09-24 13:38:00'),
(10, 10, 42, 1, 9000000.00, '2025-09-24 13:39:00', '2025-09-24 13:39:00'),
(11, 11, 43, 1, 2300000.00, '2025-09-24 13:40:00', '2025-09-24 13:40:00'),
(12, 12, 44, 1, 3800000.00, '2025-09-24 13:41:00', '2025-09-24 13:41:00'),
(13, 13, 45, 1, 12500000.00, '2025-09-24 13:42:00', '2025-09-24 13:42:00'),
(14, 14, 46, 1, 18000000.00, '2025-09-24 13:43:00', '2025-09-24 13:43:00'),
(15, 15, 47, 1, 22000000.00, '2025-09-24 13:44:00', '2025-09-24 13:44:00'),
(16, 16, 48, 1, 4200000.00, '2025-09-24 13:45:00', '2025-09-24 13:45:00'),
(17, 17, 49, 1, 6700000.00, '2025-09-24 13:46:00', '2025-09-24 13:46:00'),
(18, 18, 50, 1, 30000000.00, '2025-09-24 13:47:00', '2025-09-24 13:47:00'),
(19, 19, 51, 1, 90000000.00, '2025-09-24 13:48:00', '2025-09-24 13:48:00'),
(20, 20, 32, 1, 15000000.00, '2025-09-24 13:49:00', '2025-09-24 13:49:00'),
(21, 1, 33, 1, 3500000.00, '2025-09-24 13:50:00', '2025-09-24 13:50:00'),
(22, 12, 30, 2, 4120000.00, '2025-09-24 13:51:00', '2025-09-24 13:51:00'),
(23, 1, 31, 1, 6300000.00, '2025-09-24 13:52:00', '2025-09-24 13:52:00'),
(24, 2, 35, 1, 6800000.00, '2025-09-24 13:53:00', '2025-09-24 13:53:00');

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `user_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 3, 33, 1, '2025-09-24 14:00:00', '2025-09-24 14:00:00'),
(2, 4, 35, 2, '2025-09-24 14:01:00', '2025-09-24 14:01:00'),
(3, 5, 37, 1, '2025-09-24 14:02:00', '2025-09-24 14:02:00'),
(4, 6, 39, 3, '2025-09-24 14:03:00', '2025-09-24 14:03:00'),
(5, 7, 41, 1, '2025-09-24 14:04:00', '2025-09-24 14:04:00'),
(6, 8, 43, 2, '2025-09-24 14:05:00', '2025-09-24 14:05:00'),
(7, 9, 45, 1, '2025-09-24 14:06:00', '2025-09-24 14:06:00'),
(8, 10, 47, 1, '2025-09-24 14:07:00', '2025-09-24 14:07:00'),
(9, 11, 49, 1, '2025-09-24 14:08:00', '2025-09-24 14:08:00'),
(10, 12, 51, 1, '2025-09-24 14:09:00', '2025-09-24 14:09:00'),
(11, 13, 30, 2, '2025-09-24 14:10:00', '2025-09-24 14:10:00'),
(12, 14, 31, 1, '2025-09-24 14:11:00', '2025-09-24 14:11:00'),
(13, 15, 32, 1, '2025-09-24 14:12:00', '2025-09-24 14:12:00'),
(14, 16, 34, 1, '2025-09-24 14:13:00', '2025-09-24 14:13:00'),
(15, 17, 36, 1, '2025-09-24 14:14:00', '2025-09-24 14:14:00'),
(16, 18, 38, 1, '2025-09-24 14:15:00', '2025-09-24 14:15:00'),
(17, 19, 40, 1, '2025-09-24 14:16:00', '2025-09-24 14:16:00'),
(18, 20, 42, 1, '2025-09-24 14:17:00', '2025-09-24 14:17:00'),
(19, 21, 44, 1, '2025-09-24 14:18:00', '2025-09-24 14:18:00'),
(20, 22, 46, 1, '2025-09-24 14:19:00', '2025-09-24 14:19:00');

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `discount_value`, `expires_at`, `usage_limit`, `used_count`) VALUES
(7, 'SUMMER25', 25.00, '2025-10-31 23:59:59', 100, 10),
(8, 'FALL15', 15.00, '2025-11-30 23:59:59', 75, 5),
(9, 'WELCOME', 5.00, '2026-01-01 00:00:00', 500, 50);

--
-- Dumping data for table `coupon_usages`
--

INSERT INTO `coupon_usages` (`id`, `user_id`, `coupon_id`, `order_id`, `used_at`) VALUES
(1, 1, 4, 1, '2025-09-24 14:30:00'),
(2, 2, 5, 2, '2025-09-24 14:31:00'),
(3, 3, 6, 3, '2025-09-24 14:32:00'),
(4, 4, 7, 4, '2025-09-24 14:33:00'),
(5, 5, 8, 5, '2025-09-24 14:34:00'),
(6, 6, 9, 6, '2025-09-24 14:35:00'),
(7, 7, 4, 7, '2025-09-24 14:36:00'),
(8, 8, 5, 8, '2025-09-24 14:37:00'),
(9, 9, 6, 9, '2025-09-24 14:38:00'),
(10, 10, 7, 10, '2025-09-24 14:39:00'),
(11, 11, 8, 11, '2025-09-24 14:40:00'),
(12, 12, 9, 12, '2025-09-24 14:41:00'),
(13, 13, 4, 13, '2025-09-24 14:42:00'),
(14, 14, 5, 14, '2025-09-24 14:43:00'),
(15, 15, 6, 15, '2025-09-24 14:44:00'),
(16, 16, 7, 16, '2025-09-24 14:45:00'),
(17, 17, 8, 17, '2025-09-24 14:46:00'),
(18, 18, 9, 18, '2025-09-24 14:47:00'),
(19, 19, 4, 19, '2025-09-24 14:48:00'),
(20, 20, 5, 20, '2025-09-24 14:49:00');

-- Thêm cột 'status' (0: Bị khóa, 1: Hoạt động) mặc đihj là 1
ALTER TABLE `users` ADD `status` TINYINT(1) NOT NULL DEFAULT '1' AFTER `role`;