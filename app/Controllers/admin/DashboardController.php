<?php
namespace App\Controllers\admin;

use PDO;

class DashboardController {

    private $conn;

    public function __construct() {
        $this->conn = new \PDO(
            "mysql:host=" . HOST . ";dbname=" . DBNAME . ";charset=utf8;port=" . PORT,
            USERNAME, PASSWORD
        );
        $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function index() {
        require_admin();

        // ── Tổng quan ──────────────────────────────────────────────
        $totalRevenue    = $this->scalar("SELECT COALESCE(SUM(total),0) FROM orders WHERE status='completed'");
        $totalOrders     = $this->scalar("SELECT COUNT(*) FROM orders");
        $totalProducts   = $this->scalar("SELECT COUNT(*) FROM products");
        $totalUsers      = $this->scalar("SELECT COUNT(*) FROM users WHERE role='user'");
        $pendingOrders   = $this->scalar("SELECT COUNT(*) FROM orders WHERE status='pending'");
        $lowStock        = $this->scalar("SELECT COUNT(*) FROM products WHERE quantity <= 5");

        // ── Doanh thu 6 tháng gần nhất ────────────────────────────
        $revenueChart = $this->query(
            "SELECT DATE_FORMAT(created_at,'%m/%Y') AS month,
                    DATE_FORMAT(created_at,'%Y-%m') AS month_sort,
                    COALESCE(SUM(total),0) AS revenue
             FROM orders
             WHERE status='completed'
               AND created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
             GROUP BY DATE_FORMAT(created_at,'%Y-%m'), DATE_FORMAT(created_at,'%m/%Y')
             ORDER BY month_sort ASC"
        );

        // ── Đơn hàng theo trạng thái ──────────────────────────────
        $orderStatus = $this->query(
            "SELECT status, COUNT(*) AS total FROM orders GROUP BY status"
        );

        // ── Top 5 sản phẩm bán chạy ───────────────────────────────
        $topProducts = $this->query(
            "SELECT id, name, quantity, price FROM products ORDER BY quantity ASC LIMIT 5"
        );

        // ── 5 đơn hàng mới nhất ───────────────────────────────────
        $recentOrders = $this->query(
            "SELECT o.id, o.total, o.status, o.created_at, u.name AS user_name
             FROM orders o
             LEFT JOIN users u ON u.id = o.user_id
             ORDER BY o.created_at DESC
             LIMIT 5"
        );

        // ── Sản phẩm sắp hết hàng ─────────────────────────────────
        $lowStockProducts = $this->query(
            "SELECT id, name, quantity FROM products WHERE quantity <= 5 ORDER BY quantity ASC LIMIT 5"
        );

        view('admin.dashboard', compact(
            'totalRevenue', 'totalOrders', 'totalProducts', 'totalUsers',
            'pendingOrders', 'lowStock',
            'revenueChart', 'orderStatus', 'topProducts', 'recentOrders', 'lowStockProducts'
        ));
    }

    private function scalar($sql) {
        return $this->conn->query($sql)->fetchColumn() ?? 0;
    }

    private function query($sql) {
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_OBJ);
    }
}
