<?php
namespace App\Controllers;

use App\Models\UserModel;
use Exception;

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    /**
     * Hiển thị form đăng nhập
     */
    public function showLogin() {
        view('auth.login');
    }

    /**
     * Xử lý đăng nhập
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            // Validate
            if (empty($email) || empty($password)) {
                $_SESSION['error'] = 'Vui lòng nhập email và mật khẩu';
                return redirect('/login');
            }

            try {
                // Tìm user
                $user = $this->userModel->findByEmail($email);
                
                if (!$user) {
                    $_SESSION['error'] = 'Email không tồn tại';
                    return redirect('/login');
                }

                // Kiểm tra password
                if (!password_verify($password, $user->password)) {
                    $_SESSION['error'] = 'Mật khẩu không đúng';
                    return redirect('/login');
                }

                // Lưu session
                $_SESSION['user'] = $user;
                $_SESSION['success'] = 'Đăng nhập thành công';
                
                // Redirect theo role
                if ($user->role === 'admin') {
                    return redirect('/admin/products');
                }
                return redirect('/');
                
            } catch (Exception $e) {
                $_SESSION['error'] = 'Lỗi đăng nhập: ' . $e->getMessage();
                return redirect('/login');
            }
        }
    }

    /**
     * Hiển thị form đăng ký
     */
    public function showRegister() {
        view('auth.register');
    }

    /**
     * Xử lý đăng ký
     */
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Validate
            if (empty($name) || empty($email) || empty($password)) {
                $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin';
                return redirect('/register');
            }

            if ($password !== $confirmPassword) {
                $_SESSION['error'] = 'Mật khẩu không khớp';
                return redirect('/register');
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = 'Email không hợp lệ';
                return redirect('/register');
            }

            if (strlen($password) < 8) {
                $_SESSION['error'] = 'Mật khẩu phải có ít nhất 8 ký tự';
                return redirect('/register');
            }

            if (!preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
                $_SESSION['error'] = 'Mật khẩu phải chứa ít nhất 1 chữ hoa và 1 số';
                return redirect('/register');
            }

            // Kiểm tra email đã tồn tại
            if ($this->userModel->emailExists($email)) {
                $_SESSION['error'] = 'Email đã được đăng ký';
                return redirect('/register');
            }

            // Tạo user
            try {
                $this->userModel->registerUser([
                    'name' => $name,
                    'email' => $email,
                    'password' => $password,
                    'role' => 'user'
                ]);

                $_SESSION['success'] = 'Đăng ký thành công. Vui lòng đăng nhập';
                return redirect('/login');
            } catch (\Exception $e) {
                $_SESSION['error'] = 'Lỗi đăng ký. Vui lòng thử lại';
                return redirect('/register');
            }
        }
    }

    /**
     * Hiển thị form quên mật khẩu
     */
    public function showForgotPassword() {
        view('auth.forgot-password');
    }

    /**
     * Xử lý quên mật khẩu
     */
    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');

            if (empty($username)) {
                $_SESSION['error'] = 'Vui lòng nhập tên tài khoản';
                return redirect('/forgot-password');
            }

            try {
                // Tìm user theo username
                $user = $this->userModel->findByUsername($username);
                
                if (!$user) {
                    $_SESSION['error'] = 'Tên tài khoản không tồn tại';
                    return redirect('/forgot-password');
                }

                // Lưu thông tin user vào session để cho phép tạo mật khẩu mới
                $_SESSION['reset_user_id'] = $user->id;
                $_SESSION['success'] = 'Tên tài khoản hợp lệ! Bạn có thể tạo mật khẩu mới.';
                return redirect('/reset-password');
                
            } catch (Exception $e) {
                $_SESSION['error'] = 'Lỗi xử lý: ' . $e->getMessage();
                return redirect('/forgot-password');
            }
        }
    }

    /**
     * Hiển thị form reset password
     */
    public function showResetPassword($token = null) {
        if (!$token) {
            $_SESSION['error'] = 'Link không hợp lệ';
            return redirect('/forgot-password');
        }

        view('auth.reset-password', ['token' => $token]);
    }

    /**
     * Xử lý reset password
     */
    public function resetPassword($token = null) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if (empty($password) || empty($confirmPassword)) {
                $_SESSION['error'] = 'Vui lòng nhập mật khẩu';
                return redirect("/reset-password/$token");
            }

            if ($password !== $confirmPassword) {
                $_SESSION['error'] = 'Mật khẩu không khớp';
                return redirect("/reset-password/$token");
            }

            if (strlen($password) < 6) {
                $_SESSION['error'] = 'Mật khẩu phải có ít nhất 6 ký tự';
                return redirect("/reset-password/$token");
            }

            // Tìm user với token
            $user = $this->userModel->findByResetToken($token);

            if (!$user) {
                $_SESSION['error'] = 'Link reset password không hợp lệ hoặc đã hết hạn';
                return redirect('/forgot-password');
            }

            try {
                // Cập nhật password
                $this->userModel->updatePassword($user->id, $password);

                // Xóa token
                $this->userModel->clearResetToken($user->id);
            } catch (Exception $e) {
                $_SESSION['error'] = 'Lỗi cập nhật mật khẩu';
                return redirect("/reset-password/$token");
            }

            $_SESSION['success'] = 'Mật khẩu đã được cập nhật. Vui lòng đăng nhập';
            return redirect('/login');
        }
    }

    /**
     * Đăng xuất
     */
    public function logout() {
        unset($_SESSION['user']);
        $_SESSION['success'] = 'Đăng xuất thành công';
        redirect('/');
    }
}
?>
