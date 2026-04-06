<?php
namespace App\Models;

use PDO;

class OrderModel extends BaseModel
{
    protected $table = 'orders';

    public function __construct()
    {
        parent::__construct();
        $this->ensureTableExists();
    }

    /**
     * Đảm bảo bảng orders tồn tại.
     * Nếu không tồn tại sẽ tạo mới.
     */
    private function ensureTableExists()
    {
        $stmt = $this->conn->query("SHOW TABLES LIKE '{$this->table}'");
        $exists = $stmt->fetchColumn();

        if (!$exists) {
            $sql = "CREATE TABLE `{$this->table}` (
                `id` int NOT NULL AUTO_INCREMENT,
                `user_id` int DEFAULT NULL,
                `total` decimal(12,2) NOT NULL DEFAULT 0,
                `status` enum('pending','processing','completed','cancelled') NOT NULL DEFAULT 'pending',
                `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
                KEY `user_id` (`user_id`),
                CONSTRAINT `orders_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
            $this->conn->exec($sql);
        }
    }

    /**
     * Lấy danh sách đơn hàng kèm thông tin user (nếu có)
     *
     * @return array
     */
    public function allWithUser()
    {
        $sql = "SELECT o.*, u.name AS user_name, u.email AS user_email
                FROM {$this->table} AS o
                LEFT JOIN users AS u ON o.user_id = u.id
                ORDER BY o.id ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Lấy chi tiết đơn hàng theo id, kèm user
     */
    public function findWithUser($id)
    {
        $sql = "SELECT o.*, u.name AS user_name, u.email AS user_email
                FROM {$this->table} AS o
                LEFT JOIN users AS u ON o.user_id = u.id
                WHERE o.id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetchObject();
    }
}
