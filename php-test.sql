-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 04, 2025 lúc 04:23 PM
-- Phiên bản máy phục vụ: 11.6.2-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `php-test`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_items`
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
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Đồng hồ nam', 'Đồng hồ nam', '2025-09-18 13:23:18', '2025-09-19 12:18:08'),
(2, 'Đồng hồ nữ', 'Đồng hồ nữ', '2025-09-18 13:23:18', '2025-09-19 12:18:18');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`id`, `product_id`, `user_id`, `comment_text`, `created_at`) VALUES
(21, 31, 2, 'hay', '2025-09-29 11:59:20'),
(22, 31, 2, 'hay', '2025-09-29 12:16:10'),
(23, 30, 2, 'k', '2025-09-29 12:16:24'),
(24, 30, 2, 'ngon', '2025-10-01 04:45:47'),
(25, 31, 2, 'đã quá', '2025-10-01 04:45:56'),
(26, 31, 2, 'ok', '2025-10-03 11:05:29');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `used_count` int(11) DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `discount_value`, `expires_at`, `usage_limit`, `used_count`, `status`) VALUES
(1, 'GIAM10', 100000.00, '2029-09-28 23:59:59', 100, 1, 1),
(3, 'VIP30', 300000.00, '2028-09-23 14:19:48', 10, 4, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coupon_usages`
--

CREATE TABLE `coupon_usages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `used_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `coupon_usages`
--

INSERT INTO `coupon_usages` (`id`, `user_id`, `coupon_id`, `order_id`, `used_at`) VALUES
(12, 2, 3, NULL, '2025-10-03 12:25:43');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
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
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('Chờ xác nhận','Đang giao','Giao thành công','Đã hủy') NOT NULL DEFAULT 'Chờ xác nhận'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `fullname`, `phone`, `email`, `address`, `district`, `city`, `postcode`, `note`, `payment_method`, `total`, `created_at`, `updated_at`, `status`) VALUES
(40, 2, 'Trần Chí Nghị', '0937861799', 'trannghi1672004@gmail.com', '21D/9', '7', 'Tphcm', '00000', 'hi vọng', 'Tiền mặt', 29320000.00, '2025-10-01 13:40:24', '2025-10-03 18:39:38', 'Đã hủy'),
(41, 2, 'Chinghi', '0937861799', 'trannghi1672004@gmail.com', '21D/9', '7', 'Tphcm', '00000', '', 'Tiền mặt', 6300000.00, '2025-10-01 13:42:14', '2025-10-03 18:39:37', 'Đã hủy'),
(42, 2, 'Trần Chí Nghị', '0937861799', 'trannghi1672004@gmail.com', '21D/9', '7', 'Tphcm', '00000', 'a', 'Tiền mặt', 4120000.00, '2025-10-01 13:42:55', '2025-10-03 19:19:38', 'Đã hủy'),
(43, 2, 'Trần Chí Nghị', '0937861799', 'trannghi1672004@gmail.com', '21D/9', '7', 'Tphcm', '00000', 'a', 'Tiền mặt', 6300000.00, '2025-10-01 13:43:48', '2025-10-03 18:39:25', 'Đã hủy'),
(44, 2, 'Trần Chí Nghị', '0937861799', 'trannghi1672004@gmail.com', '21D/9', '7', 'Tphcm', '00000', 'a', 'Tiền mặt', 18900000.00, '2025-10-03 18:06:22', '2025-10-03 18:39:23', 'Đã hủy'),
(45, 2, 'Trần Chí Nghị', '0937861799', 'trannghi1672004@gmail.com', '21D/9', '7', 'Tphcm', 'a', 'a', 'Tiền mặt', 6300000.00, '2025-10-03 18:08:45', '2025-10-03 18:39:22', 'Đã hủy'),
(46, 2, 'Trần Chí Nghị', '0937861799', 'trannghi1672004@gmail.com', 'a', 'a', 'a', 'a', 'a', 'Tiền mặt', 6300000.00, '2025-10-03 18:10:32', '2025-10-03 18:39:21', 'Đã hủy'),
(47, 2, 'Trần Chí Nghị', '0937861799', 'trannghi1672004@gmail.com', '21D/9', '7', 'a', 'a', 'a', 'Tiền mặt', 4120000.00, '2025-10-03 18:32:01', '2025-10-03 18:39:17', 'Đã hủy'),
(48, 2, 'Trần Chí Nghị', '0937861799', 'admin@gmail.com', '21D/9', '7', 'Tphcm', '00000', 'a', 'Tiền mặt', 4120000.00, '2025-10-03 18:32:52', '2025-10-03 18:39:13', 'Đã hủy'),
(49, 2, 'a', 'a', 'trannghi1672004@gmail.com', '21D/9', '7', 'Tphcm', 'a', 'a', 'Tiền mặt', 6300000.00, '2025-10-03 18:38:59', '2025-10-03 18:39:11', 'Đã hủy'),
(50, 2, 'Trần Chí Nghị', '0937861799', 'trannghi1672004@gmail.com', '21D/9', '7', 'Tphcm', '00000', 'a', 'Tiền mặt', 126000000.00, '2025-10-03 18:40:52', '2025-10-03 18:43:34', 'Đã hủy'),
(51, 2, 'Trần Chí Nghị', '0937861799', 'trannghi1672004@gmail.com', '21D/9', '7', 'Tphcm', '00000', 'a', 'Tiền mặt', 4120000.00, '2025-10-03 18:42:36', '2025-10-03 18:43:35', 'Đã hủy'),
(52, 2, 'Trần Chí Nghị', '0937861799', 'trannghi1672004@gmail.com', '21D/9', '7', 'Tphcm', '00000', 'a', 'Tiền mặt', 12300000.00, '2025-10-03 18:46:51', '2025-10-03 18:48:38', 'Giao thành công'),
(53, 2, 'Trần Chí Nghị', '0937861799', 'trannghi1672004@gmail.com', '21D/9', '7', 'Tphcm', '', '', 'Tiền mặt', 4020000.00, '2025-10-03 19:05:54', '2025-10-03 19:06:32', 'Giao thành công'),
(54, 2, 'Trần Chí Nghị', '0937861799', 'trannghi1672004@gmail.com', '21D/9', '7', 'Tphcm', '00000', 'a', 'Tiền mặt', 10420000.00, '2025-10-03 19:20:52', '2025-10-03 19:20:52', 'Chờ xác nhận'),
(55, 2, 'Trần Chí Nghị', '0937861799', 'trannghi1672004@gmail.com', '21D/9', 'a', 'a', 'a', 'a', 'Tiền mặt', 6000000.00, '2025-10-03 19:25:43', '2025-10-03 19:25:43', 'Chờ xác nhận');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
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

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(68, 40, 31, 4, 6300000.00, '2025-10-01 13:40:24', '2025-10-01 13:40:24'),
(69, 40, 30, 1, 4120000.00, '2025-10-01 13:40:24', '2025-10-01 13:40:24'),
(70, 41, 31, 1, 6300000.00, '2025-10-01 13:42:14', '2025-10-01 13:42:14'),
(71, 42, 30, 1, 4120000.00, '2025-10-01 13:42:55', '2025-10-01 13:42:55'),
(72, 43, 31, 1, 6300000.00, '2025-10-01 13:43:48', '2025-10-01 13:43:48'),
(73, 44, 31, 3, 6300000.00, '2025-10-03 18:06:22', '2025-10-03 18:06:22'),
(74, 45, 31, 1, 6300000.00, '2025-10-03 18:08:45', '2025-10-03 18:08:45'),
(75, 46, 31, 1, 6300000.00, '2025-10-03 18:10:32', '2025-10-03 18:10:32'),
(76, 47, 30, 1, 4120000.00, '2025-10-03 18:32:01', '2025-10-03 18:32:01'),
(77, 48, 30, 1, 4120000.00, '2025-10-03 18:32:52', '2025-10-03 18:32:52'),
(78, 49, 31, 1, 6300000.00, '2025-10-03 18:38:59', '2025-10-03 18:38:59'),
(79, 50, 31, 20, 6300000.00, '2025-10-03 18:40:52', '2025-10-03 18:40:52'),
(80, 51, 30, 1, 4120000.00, '2025-10-03 18:42:36', '2025-10-03 18:42:36'),
(81, 52, 31, 2, 6300000.00, '2025-10-03 18:46:51', '2025-10-03 18:46:51'),
(82, 53, 30, 1, 4120000.00, '2025-10-03 19:05:54', '2025-10-03 19:05:54'),
(83, 54, 30, 1, 4120000.00, '2025-10-03 19:20:52', '2025-10-03 19:20:52'),
(84, 54, 31, 1, 6300000.00, '2025-10-03 19:20:52', '2025-10-03 19:20:52'),
(85, 55, 31, 1, 6300000.00, '2025-10-03 19:25:43', '2025-10-03 19:25:43');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT 0.00,
  `stock` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `image`, `price`, `stock`, `category_id`, `created_at`, `updated_at`) VALUES
(30, 'ABC-classic', 'đồng hồ này đẹp', 'dong-ho-nu.jpg', 4120000.00, 17, 2, '2025-09-18 08:32:19', '2025-10-03 12:20:52'),
(31, 'Standard Watch', 'dfdfdfd', 'dong-ho-nam.jpg', 6300000.00, 16, 1, '2025-09-18 08:32:52', '2025-10-03 12:25:43');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` tinyint(3) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `rating`
--

INSERT INTO `rating` (`id`, `product_id`, `user_id`, `rating`, `created_at`) VALUES
(8, 31, 2, 5, '2025-09-29 12:16:13'),
(9, 30, 2, 3, '2025-09-29 12:16:20');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(32) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `total_spent` decimal(15,2) NOT NULL DEFAULT 0.00,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `level` enum('Diamond','Gold','Silver','Common') NOT NULL DEFAULT 'Common',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `password`, `email`, `phone`, `total_spent`, `role`, `status`, `level`, `created_at`, `updated_at`) VALUES
(2, 'admin', 'admin', '$2y$10$Ec07CKpg1hNTBDP0Co51UO3QvouWMiIZ0hxIfGspf/YdteLNW.DGK', 'admin@gmail.com', '0937861899', 16320000.00, 'admin', 0, 'Silver', '2025-09-20 16:03:36', '2025-10-04 14:22:57'),
(29, 'Trần Chí Nghị', 'Cisnij', '$2y$10$n0xqv9q/2kC8hElhG7kZlu8Kb/53yHWTcR6xq/kRWLvb1OQMlskO6', 'trannghi1672004@gmail.com', '0937861799', 0.00, 'user', 0, 'Common', '2025-09-23 13:15:07', '2025-10-03 11:11:39'),
(31, 'abc', 'abc', '$2y$10$BRAOnSiGweY2RgeRsAzZMuVdQ2ATVYvhAUm0YJRKP/M5.3fhHelG2', 'abc@gmail.com', '0333', 0.00, 'user', 0, 'Common', '2025-09-29 12:44:04', '2025-10-03 11:12:31'),
(32, 'Trần Chí Nghị', 'Cisnij1', '$2y$10$8JxzB1xXgFgur/alW7LFc.hbm90tjaeWciTMmeKpQBn/7HKRXnTGm', 'trannghi1672004@gmail.com', '0937861799', 0.00, 'admin', 0, 'Common', '2025-10-03 12:30:03', '2025-10-03 12:30:03');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_id`),
  ADD KEY `fk_product` (`product_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Chỉ mục cho bảng `coupon_usages`
--
ALTER TABLE `coupon_usages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `fk_coupon` (`coupon_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_product` (`user_id`,`product_id`),
  ADD UNIQUE KEY `product_id` (`product_id`,`user_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `coupon_usages`
--
ALTER TABLE `coupon_usages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT cho bảng `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `fk_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `coupon_usages`
--
ALTER TABLE `coupon_usages`
  ADD CONSTRAINT `coupon_usages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `coupon_usages_ibfk_2` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`),
  ADD CONSTRAINT `coupon_usages_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Các ràng buộc cho bảng `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
