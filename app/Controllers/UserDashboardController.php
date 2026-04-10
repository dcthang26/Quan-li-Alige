<?php
namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\OrderModel;
use App\Models\UserModel;

class UserDashboardController
{
    private function normalizeCart($cart): array 
    {
        if (!is_array($cart)) return [];
        $normalized = [];
        foreach ($cart as $key => $item) {
            if (is_object($item) && get_class($item) === 'stdClass') {
                $item = get_object_vars($item);
            }
            $normalized[$key] = $item;
        }
        return $normalized;
    }

    // ==================== PROFILE ====================

    public function profile()
    {
        require_auth();
        $orderModel = new OrderModel();
        $userId = $_SESSION['user']->id;
        $orders = $orderModel->allWithUser();
        $orderCount = count(array_filter($orders, fn($o) => $o->user_id == $userId));
        $cart = $this->normalizeCart($_SESSION['cart'] ?? []);
        $cartCount = array_sum(array_column($cart, 'quantity'));
        view('users.profile.index', compact('orderCount', 'cartCount'));
    }

    public function uploadAvatar()
    {
        require_auth();
        if (!is_upload('avatar')) {
            session_flash('error', 'Vui lòng chọn ảnh');
            return redirect('/user/profile');
        }

        $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($_FILES['avatar']['type'], $allowed)) {
            session_flash('error', 'Chỉ chấp nhận ảnh JPG, PNG, GIF, WEBP');
            return redirect('/user/profile');
        }
        if ($_FILES['avatar']['size'] > 2 * 1024 * 1024) {
            session_flash('error', 'Ảnh không được vượt quá 2MB');
            return redirect('/user/profile');
        }

        $path = upload_file($_FILES['avatar'], 'images');
        UserModel::update($_SESSION['user']->id, ['avatar' => $path]);
        $userModel = new UserModel();
        $_SESSION['user'] = $userModel->findByEmail($_SESSION['user']->email);
        $_SESSION['success'] = 'Ảnh đại diện đã thay đổi thành công';
        redirect('/');
    }

    public function updateProfile()
    {
        require_auth();
        $name  = strip_tags(trim($_POST['name'] ?? ''));
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);

        if (empty($name) || empty($email)) {
            $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin';
            return redirect('/user/profile');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Email không hợp lệ';
            return redirect('/user/profile');
        }

        $userModel = new UserModel();
        UserModel::update($_SESSION['user']->id, ['name' => $name, 'email' => $email]);
        $updated = $userModel->findByEmail($email);
        $_SESSION['user'] = $updated;
        $_SESSION['success'] = 'Thông tin cá nhân đã thay đổi thành công';
        redirect('/');
    }

    public function changePassword()
    {
        require_auth();
        $current = $_POST['current_password'] ?? '';
        $new     = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        if (empty($current) || empty($new) || empty($confirm)) {
            session_flash('error', 'Vui lòng nhập đầy đủ thông tin');
            return redirect('/user/profile');
        }
        if ($new !== $confirm) {
            session_flash('error', 'Mật khẩu mới không khớp');
            return redirect('/user/profile');
        }
        if (!password_verify($current, $_SESSION['user']->password)) {
            session_flash('error', 'Mật khẩu hiện tại không đúng');
            return redirect('/user/profile');
        }

        $userModel = new UserModel();
        $userModel->updatePassword($_SESSION['user']->id, $new);
        session_flash('success', 'Đổi mật khẩu thành công');
        redirect('/user/profile');
    }

    // ==================== PRODUCT ====================

    public function productDetail($id)
    {
        $id = (int)$id;
        $product = ProductModel::find($id);
        if (!$product) return redirect404();

        $all     = ProductModel::all();
        $related = array_filter($all, fn($p) => $p->id != $id);
        $related = array_slice(array_values($related), 0, 4);
        view('users.product.detail', compact('product', 'related'));
    }

    // ==================== CART ====================

    public function cart()
    {
        require_auth();
        $cart = $this->getCart();
        view('users.cart.index', ['cart' => $cart]);
    }

    public function addToCart()
    {
        require_auth();
        $productId = (int)($_POST['product_id'] ?? 0);
        $quantity  = max(1, (int)($_POST['quantity'] ?? 1));
        $buyNow    = isset($_POST['buy_now']);

        $product = ProductModel::find($productId);
        if (!$product) return redirect('/list');

        $cart = $this->normalizeCart($_SESSION['cart'] ?? []);
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'id'       => $product->id,
                'name'     => $product->name,
                'price'    => $product->price,
                'image'    => $product->image,
                'quantity' => $quantity,
            ];
        }
        $_SESSION['cart'] = $cart;
        session_flash('success', 'Đã thêm vào giỏ hàng');

        if ($buyNow) return redirect('/user/cart');
        redirect('/user/product/' . $productId);
    }

    public function updateCart()
    {
        require_auth();
        $productId = (int)($_POST['product_id'] ?? 0);
        $quantity  = max(1, (int)($_POST['quantity'] ?? 1));
        $cart = $this->normalizeCart($_SESSION['cart'] ?? []);
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
            $_SESSION['cart'] = $cart;
        }
        redirect('/user/cart');
    }

    public function removeFromCart()
    {
        require_auth();
        $productId = (int)($_POST['product_id'] ?? 0);
        $cart = $this->normalizeCart($_SESSION['cart'] ?? []);
        unset($cart[$productId]);
        $_SESSION['cart'] = $cart;
        redirect('/user/cart');
    }

    public function clearCart()
    {
        require_auth();
        $_SESSION['cart'] = [];
        redirect('/user/cart');
    }

    public function checkout()
    {
        require_auth();
        $cart = $this->getCart();
        if (empty($cart)) return redirect('/user/cart');
        view('users.order.checkout', compact('cart'));
    }

    public function confirmCheckout()
    {
        require_auth();
        $cart = $this->normalizeCart($_SESSION['cart'] ?? []);
        if (empty($cart)) return redirect('/user/cart');

        $info = [
            'receiver_name'  => strip_tags(trim($_POST['receiver_name'] ?? '')),
            'phone'          => strip_tags(trim($_POST['phone'] ?? '')),
            'address'        => strip_tags(trim($_POST['address'] ?? '')),
            'district'       => strip_tags(trim($_POST['district'] ?? '')),
            'city'           => strip_tags(trim($_POST['city'] ?? '')),
            'note'           => strip_tags(trim($_POST['note'] ?? '')),
            'payment_method' => in_array($_POST['payment_method'] ?? '', ['cod', 'bank']) ? $_POST['payment_method'] : 'cod',
        ];

        if (empty($info['receiver_name']) || empty($info['phone']) || empty($info['address'])) {
            session_flash('error', 'Vui lòng nhập đầy đủ thông tin giao hàng');
            return redirect('/user/checkout');
        }

        $total = array_sum(array_map(fn($i) => ($i['price'] ?? 0) * ($i['quantity'] ?? 0), $cart));
        $orderId = OrderModel::create([
            'user_id'    => $_SESSION['user']->id,
            'total'      => $total,
            'status'     => 'pending',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $_SESSION['cart'] = [];
        view('users.order.success', compact('orderId', 'info', 'total'));
    }

    // ==================== ORDERS ====================

    public function orders()
    {
        require_auth();
        $allowed = ['all', 'pending', 'processing', 'completed', 'cancelled'];
        $status  = in_array($_GET['status'] ?? 'all', $allowed) ? ($_GET['status'] ?? 'all') : 'all';
        $orderModel = new OrderModel();
        $all        = $orderModel->allWithUser();
        $userId     = $_SESSION['user']->id;
        $orders     = array_filter($all, fn($o) => $o->user_id == $userId);
        if ($status !== 'all') {
            $orders = array_filter($orders, fn($o) => $o->status === $status);
        }
        $orders = array_values($orders);
        view('users.order.index', compact('orders', 'status'));
    }

    public function orderDetail($id)
    {
        require_auth();
        $id = (int)$id;
        $orderModel = new OrderModel();
        $order = $orderModel->findWithUser($id);
        if (!$order || $order->user_id != $_SESSION['user']->id) {
            return redirect('/user/orders');
        }
        view('users.order.show', compact('order'));
    }

    public function cancelOrder($id)
    {
        require_auth();
        $id = (int)$id;
        $orderModel = new OrderModel();
        $order = $orderModel->findWithUser($id);
        if ($order && $order->user_id == $_SESSION['user']->id && $order->status === 'pending') {
            OrderModel::update($id, ['status' => 'cancelled']);
            session_flash('success', 'Đã hủy đơn hàng');
        }
        redirect('/user/orders');
    }

    // ==================== HELPER ====================

    private function getCart(): array
    {
        return array_values($this->normalizeCart($_SESSION['cart'] ?? []));
    }
}
