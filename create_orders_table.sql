-- SQL file to create basic orders table for the admin orders listing feature.
-- Run this against your database (e.g. via phpMyAdmin or mysql CLI).

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `total` decimal(12,2) NOT NULL DEFAULT 0,
  `status` enum('pending','processing','completed','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Example data (optional):
INSERT INTO `orders` (`user_id`, `total`, `status`) VALUES
(2, 123000, 'completed'),
(3, 56000, 'processing'),
(4, 12345.67, 'pending');
