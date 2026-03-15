<?php
namespace App\Controllers\admin;

class OrderController {

    /**
     * Hiển thị danh sách đơn hàng
     */
    public function index()
    {
        require_admin();

        $orderModel = new \App\Models\OrderModel();
        $orders = $orderModel->allWithUser();

        view('admin.orders.listing', [
            'orders' => $orders,
        ]);
    }

    /**
     * Xem chi tiết đơn hàng
     */
    public function show($id)
    {
        require_admin();

        $id = intval($id);
        if ($id <= 0) {
            redirect('/admin/orders');
            return;
        }

        $orderModel = new \App\Models\OrderModel();
        $order = $orderModel->findWithUser($id);

        if (!$order) {
            $_SESSION['errors'] = ['Đơn hàng không tồn tại!'];
            redirect('/admin/orders');
            return;
        }

        view('admin.orders.show', [
            'order' => $order,
        ]);
    }

    public function delete($id)
    {
        require_admin();

        $id = intval($id);
        if ($id <= 0) {
            redirect('/admin/orders');
            return;
        }

        \App\Models\OrderModel::delete($id);

        $_SESSION['success'] = 'Xóa đơn hàng thành công!';
        redirect('/admin/orders');
    }
}