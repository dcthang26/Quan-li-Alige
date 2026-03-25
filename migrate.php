<?php
require_once __DIR__ . '/env.php';

try {
    $pdo = new PDO(
        "mysql:host=" . HOST . ";dbname=" . DBNAME . ";port=" . PORT . ";charset=utf8mb4",
        USERNAME, PASSWORD
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("ALTER TABLE `orders` MODIFY COLUMN `status` ENUM('pending','processing','shipping','completed','cancelled') NOT NULL DEFAULT 'pending'");

    echo "✅ Đã thêm trạng thái 'shipping' vào bảng orders.";
} catch (PDOException $e) {
    echo "❌ Lỗi: " . $e->getMessage();
}
