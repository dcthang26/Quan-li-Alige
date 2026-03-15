-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th3 11, 2026 lúc 03:54 AM
-- Phiên bản máy phục vụ: 8.4.3
-- Phiên bản PHP: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `php2_asm`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `quantity` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `description`, `quantity`) VALUES
(13, 'ihpone10', 12444444, 'storage/images/1770237894-shesh.jpg', 'sheshhh', 44444),
(14, 'ihpone edit', 65476, 'storage/images/1770283617-output-onlinegiftools.gif', 'edit\r\n', 6636646),
(16, 'ádasd', 123123, 'storage/images/1770239991-Gemini_Generated_Image_i3j77li3j77li3j7.png', 'fasdfasdf', 1241),
(17, 'ihpone SSD', 10000, 'storage/images/1770283576-chicken 1.png', 'fdasgshdjfkggfdfSD', 123),
(18, 'ngonnnnn', 144422, 'storage/images/1770283826-adu anh seng.png', 'aduanhseng\r\n\r\n', 14),
(19, 'kayo ult', 10032006, 'storage/images/1770283894-kayo.gif', 'kayooooo\r\n', 103),
(20, 'reyna ult', 1999, 'storage/images/1770284123-reyna.gif', 'deadlock', 19),
(21, 'deadlock', 133, 'storage/images/1770284141-deadlock.gif', 'deadlock ult\r\n', 200),
(22, 'adma', 111, 'storage/images/1770287119-de0ec63186e01cd8dd5e970ed6cfadde.jpg', 'acacac', 111);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expires` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `reset_token`, `reset_token_expires`, `created_at`) VALUES
(1, 'Admin', 'admin@admin.com', '$2y$10$JPevZpW5LuiBsd8X3fcIE.qRP.XZFdpfFHkSXR6DvWe73gSL.xmzG', 'admin', NULL, NULL, '2026-02-04 21:08:19'),
(2, 'User Client', 'user@user.com', '$2y$10$rcY68bnvpG1rxmzS3eoNPOA0bSbUlInU2pZZYAUnPxKXgkbRDLZbG', 'user', NULL, NULL, '2026-02-04 21:08:19'),
(3, 'linhSET', 'linh@gmail.com', '$2y$10$vIcc0MapFYkvy8APCbl8ueNQ6FkanrERtBQRcVcGiPbzNzhoCmg6G', 'user', NULL, NULL, '2026-02-04 21:16:46'),
(4, 'nhat linh', 'sans@sans.com', '$2y$10$fRxI.5Ee5h3Cz//h10Nhdufzs0KKMW42VDAw/1t1m1VQZo0JIMlxi', 'user', NULL, NULL, '2026-02-05 10:13:37');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

-- --------------------------------------------------------
--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `total` decimal(12,2) NOT NULL DEFAULT 0,
  `status` enum('pending','processing','completed','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `status`, `created_at`) VALUES
(1, 2, 123000.00, 'completed', '2026-03-01 10:00:00'),
(2, 3, 56000.00, 'processing', '2026-03-10 12:20:00'),
(3, 4, 12345.67, 'pending', '2026-03-14 09:15:00');

-- --------------------------------------------------------
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
