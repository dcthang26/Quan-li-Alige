<?php
namespace App\Controllers\admin;

class UserController {
    
    /**
     * Hiển thị danh sách tất cả users
     */
    public function index() {
        require_admin();
        $userModel = new \App\Models\UserModel();
        $users = $userModel->all();
        view('admin.users.listing', ['users' => $users]);
    }

    /**
     * Hiển thị form thêm user mới
     */
    public function add() {
        require_admin();
        view('admin.users.add');
    }

    /**
     * Lưu user mới vào database
     */
    public function store() {
        require_admin();
        
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $role = $_POST['role'] ?? 'user';

        // Validate dữ liệu
        $errors = $this->validateUserData($name, $email, $password, $confirmPassword, null);
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_data'] = $_POST;
            redirect('/admin/users/add');
            return;
        }

        $userModel = new \App\Models\UserModel();
        
        // Kiểm tra email đã tồn tại chưa
        if ($userModel->emailExists($email)) {
            $_SESSION['errors'] = ['Email này đã được sử dụng!'];
            $_SESSION['old_data'] = $_POST;
            redirect('/admin/users/add');
            return;
        }

        // Chuẩn bị dữ liệu để lưu
        $data = [
            'name' => trim($name),
            'email' => trim($email),
            'password' => $password,
            'role' => $role
        ];

        // Lưu vào database
        try {
            $userModel->registerUser($data);
            $_SESSION['success'] = 'Thêm user thành công!';
            redirect('/admin/users');
        } catch (\Exception $e) {
            $_SESSION['errors'] = ['Lỗi khi thêm user: ' . $e->getMessage()];
            redirect('/admin/users/add');
        }
    }

    /**
     * Hiển thị form chỉnh sửa user
     */
    public function edit($id) {
        require_admin();
        
        $id = intval($id);
        if ($id <= 0) {
            redirect('/admin/users');
            return;
        }

        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            $_SESSION['errors'] = ['User không tồn tại!'];
            redirect('/admin/users');
            return;
        }

        view('admin.users.edit', ['user' => $user]);
    }

    /**
     * Cập nhật thông tin user
     */
    public function update($id) {
        require_admin();
        
        $id = intval($id);
        if ($id <= 0) {
            redirect('/admin/users');
            return;
        }

        $userModel = new \App\Models\UserModel();
        $userCurrent = $userModel->find($id);

        if (!$userCurrent) {
            $_SESSION['errors'] = ['User không tồn tại!'];
            redirect('/admin/users');
            return;
        }

        if (isset($_POST['submit'])) {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            $role = $_POST['role'] ?? 'user';

            // Validate dữ liệu (với id để kiểm tra email không trùng chính mình)
            $errors = $this->validateUserData($name, $email, $password, $confirmPassword, $id);
            
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old_data'] = $_POST;
                redirect('/admin/users/edit/' . $id);
                return;
            }

            // Kiểm tra email đã tồn tại chưa (ngoại trừ email hiện tại)
            if ($email !== $userCurrent->email && $userModel->emailExists($email)) {
                $_SESSION['errors'] = ['Email này đã được sử dụng!'];
                $_SESSION['old_data'] = $_POST;
                redirect('/admin/users/edit/' . $id);
                return;
            }

            // Chuẩn bị dữ liệu để cập nhật
            $data = [
                'name' => trim($name),
                'email' => trim($email),
                'role' => $role
            ];

            // Nếu có mật khẩu mới, thêm vào dữ liệu cập nhật
            if (!empty($password)) {
                $data['password'] = password_hash($password, PASSWORD_BCRYPT);
            }

            // Cập nhật vào database
            try {
                $userModel->update($id, $data);
                $_SESSION['success'] = 'Cập nhật user thành công!';
                redirect('/admin/users');
            } catch (\Exception $e) {
                $_SESSION['errors'] = ['Lỗi khi cập nhật user: ' . $e->getMessage()];
                redirect('/admin/users/edit/' . $id);
            }
        }
    }

    /**
     * Xóa user
     */
    public function delete($id) {
        require_admin();
        
        $id = intval($id);
        if ($id <= 0) {
            redirect('/admin/users');
            return;
        }

        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            $_SESSION['errors'] = ['User không tồn tại!'];
            redirect('/admin/users');
            return;
        }

        // Không cho phép xóa admin account (id = 1)
        if ($id == 1) {
            $_SESSION['errors'] = ['Không thể xóa tài khoản admin chính!'];
            redirect('/admin/users');
            return;
        }

        try {
            $userModel->delete($id);
            $_SESSION['success'] = 'Xóa user thành công!';
        } catch (\Exception $e) {
            $_SESSION['errors'] = ['Lỗi khi xóa user: ' . $e->getMessage()];
        }
        
        redirect('/admin/users');
    }

    /**
     * Kiểm tra hợp lệ dữ liệu user
     * 
     * @param string $name - Tên user
     * @param string $email - Email user
     * @param string $password - Mật khẩu user
     * @param string $confirmPassword - Xác nhận mật khẩu
     * @param int|null $userId - ID user (khi cập nhật)
     * @return array - Mảng lỗi
     */
    private function validateUserData($name, $email, $password, $confirmPassword, $userId = null) {
        $errors = [];

        // Kiểm tra tên user
        if (empty(trim($name))) {
            $errors[] = 'Tên user không được để trống!';
        } elseif (strlen($name) < 2) {
            $errors[] = 'Tên user phải có ít nhất 2 ký tự!';
        } elseif (strlen($name) > 255) {
            $errors[] = 'Tên user không được vượt quá 255 ký tự!';
        }

        // Kiểm tra email
        if (empty(trim($email))) {
            $errors[] = 'Email không được để trống!';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email không hợp lệ!';
        }

        // Kiểm tra mật khẩu (khi thêm hoặc khi chỉnh sửa và nhập mật khẩu mới)
        if ($userId === null) {
            // Thêm user mới - mật khẩu bắt buộc
            if (empty($password)) {
                $errors[] = 'Mật khẩu không được để trống!';
            } elseif (strlen($password) < 6) {
                $errors[] = 'Mật khẩu phải có ít nhất 6 ký tự!';
            }

            if (empty($confirmPassword)) {
                $errors[] = 'Vui lòng xác nhận mật khẩu!';
            }
        } else {
            // Chỉnh sửa user - mật khẩu là tùy chọn
            if (!empty($password)) {
                if (strlen($password) < 6) {
                    $errors[] = 'Mật khẩu phải có ít nhất 6 ký tự!';
                }
                if (empty($confirmPassword)) {
                    $errors[] = 'Vui lòng xác nhận mật khẩu!';
                }
            }
        }

        // Kiểm tra mật khẩu xác nhận
        if (!empty($password) && !empty($confirmPassword) && $password !== $confirmPassword) {
            $errors[] = 'Mật khẩu xác nhận không khớp!';
        }

        return $errors;
    }
}
?>
