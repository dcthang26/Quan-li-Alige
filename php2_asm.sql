-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th4 01, 2026 lúc 03:06 AM
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
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `total` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` enum('pending','processing','shipping','completed','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `status`, `created_at`, `updated_at`) VALUES
(10, 5, 369369.00, 'cancelled', '2026-03-20 21:17:24', '2026-03-23 04:06:42'),
(11, 6, 246246.00, 'cancelled', '2026-03-22 20:20:25', '2026-03-23 03:20:36'),
(12, 1, 1.00, 'cancelled', '2026-03-22 20:51:37', '2026-03-23 03:58:43'),
(13, 1, 85476.00, 'cancelled', '2026-03-22 20:59:50', '2026-03-23 04:06:23'),
(14, 2, 10000.00, 'cancelled', '2026-03-22 21:01:12', '2026-03-23 04:03:03'),
(15, 1, 10000.00, 'completed', '2026-03-22 21:04:12', '2026-03-23 04:04:52');

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
  `quantity` int DEFAULT NULL,
  `sizes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `colors` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sole` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `description`, `quantity`, `sizes`, `colors`, `sole`) VALUES
(14, 'Nike Mind 001', 2649000, 'storage/images/1775010976-NIKE+MIND+001.avif', 'Colour Shown: Light Smoke Grey/Photon Dust/Hyper Crimson/Chrome\r\nStyle: HQ4307-003\r\nCountry/Region of Origin: Vietnam', 10, '38,39,40,41,42', 'Xám, Đen, Đỏ', 'mềm, dẻo, cứng'),
(17, 'Nike Calm', 1183000, 'storage/images/1775011110-W+NIKE+CALM+SLIDE.avif', 'Enjoy a calm, comfortable experience—wherever your day off takes you. Made from soft yet supportive foam, the minimal design makes these slides easy to style with or without socks. And they\'ve got a textured footbed to help keep your feet in place.', 20, '38,39,40,41,42', 'Đen, Đỏ, Hồng, Xám', 'mềm,cứng,dẻo'),
(18, 'Nike Offcourt Adjust', 1063000, 'storage/images/1775011190-W+NIKE+OFFCOURT+ADJUST+SLIDE.avif', 'Post-game, errands and more—adjust your comfort on the go. The adjustable, padded strap lets you perfect your fit, while the lightweight foam midsole brings first-class comfort to your feet.', 35, '38,39,40,41,42', 'Hồng, Đen, Xám, Trắng', 'mềm,cứng,dẻo'),
(19, 'Nike Calm 2.0', 1479000, 'storage/images/1775011291-W+NIKE+CALM+SLIDE+2.0.avif', 'Think less. Feel more. The Calm Slide 2.0 uses an extra-forgiving solar foam for ultimate comfort while updated outsole cut-outs provide more flexibility than the original.', 19, '38,39,40,41,42', 'Trắng, Đen, Hồng', 'mềm,cứng,dẻo'),
(20, 'Jordan Franchise', 711200, 'storage/images/1775011326-JORDAN+FRANCHISE+SLIDE+SH.avif', 'Keep every step supported—even in the shower. Made from a single piece of robust yet flexible foam, these quick-drying shower slides have drainage holes throughout the outsole. A raised elephant print helps add traction to the footbed while giving you heritage Jordan style.', 36, '38,39,40,41,42', 'Xanh rêu, Trắng, Đen', 'mềm, cứng, dẻo'),
(21, 'Nike Victori One', 622299, 'storage/images/1775011439-NIKE+VICTORI+ONE+SLIDE.avif', 'From the beach to the stands, the Victori One is a must-have slide for everyday activities. Subtle yet substantial updates like a wider strap and softer foam make lounging easy. Go ahead—enjoy endless comfort for your feet.', 40, '38,39,40,41,42', 'Đen, Đen trắng, Hồng, Xanh dương', 'mềm,cứng,dẻo'),
(22, 'Nike ReactX Rejuven8', 2069000, 'storage/images/1775011538-NIKE+REACTX+REJUVEN8.avif', 'Give your feet a rest. Made from soft and responsive ReactX foam, the Rejuven8 uses some of our best tech to create a recovery shoe so comfortable you\'ll want to wear it every day.', 100, '38,39,40,41,42', 'Đen, Đỏ thẫm, Trắng, Xanh đậm', 'mềm,cứng,dẻo'),
(24, 'Nike Air Max Cirro', 1479000, 'storage/images/1775011633-NIKE+AIR+MAX+CIRRO+SLIDE.avif', 'Whether you\'re hitting the gym or headed to the shops, we\'ve created a perfect go-between that delivers quick style and incredible comfort. Large, visible Air in the heel is paired with a comfy foam footbed for a striking statement in comfort.', 250, '38,39,40,41,42', 'Đen, Xanh dương, Cam, Đỏ', 'mềm,cứng,dẻo'),
(27, 'Nike Victori One', 815199, 'storage/images/1775011685-W+NIKE+VICTORI+ONE+SLIDE+PRINT.avif', 'From the beach to the bleachers, the Victori One is a must-have for everyday activities. Subtle yet substantial updates like a wider strap and softer foam make lounging easy. Go ahead—enjoy endless comfort for your feet.', 50, '38,39,40,41,42', 'Xanh Cyan, Trắng', 'mềm,cứng,dẻo'),
(28, 'Jordan NOLA', 1063200, 'storage/images/1775011744-WMNS+JORDAN+NOLA+SLIDE.avif', 'Go beyond the flip-flop in the Jordan NOLA Slide, an instant warm-weather favourite. Featuring a moulded foam footbed with a squared-off toe, it\'s light and airy with an easy, slip-in strap.', 49, '38,39,40,41,42', 'Đỏ, Xanh lá, Đỏ thẫm', 'mềm,cứng,dẻo');

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
(1, 'Admin', 'admin@admin.com', '$2y$10$tyIucb4FjE6gfEilzC7SEeALNU7gHlXKMbL0URWFjx10D8GcgJCLC', 'admin', NULL, NULL, '2026-02-04 21:08:19'),
(2, 'nguyễn văn a', 'user@user.com', '$2y$10$rcY68bnvpG1rxmzS3eoNPOA0bSbUlInU2pZZYAUnPxKXgkbRDLZbG', 'user', NULL, NULL, '2026-02-04 21:08:19'),
(4, 'nhat linh', 'sans@sans.com', '$2y$10$fRxI.5Ee5h3Cz//h10Nhdufzs0KKMW42VDAw/1t1m1VQZo0JIMlxi', 'user', NULL, NULL, '2026-02-05 10:13:37'),
(5, 'linh', 'nhatlinh@gmail.com', '$2y$10$uj5cCYcek3yV.XupWbu6fuVkStnClBP4D.u6dptox6KO5wV4wF4cK', 'user', NULL, NULL, '2026-03-21 04:16:36'),
(6, 'hoàng quý', 'hoangquy@gmail.com', '$2y$10$0eEFdfdmojOlGiF7oxzWi.ZVltWz3ryEtqvC.sN13Xszs1cr/Sry.', 'user', NULL, NULL, '2026-03-23 03:19:34');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
