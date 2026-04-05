<?php
namespace App\Models;

use PDO;

class UserModel extends BaseModel {
    protected $table = 'users';
    
    /**
     * Tìm user theo email
     */
    public function findByEmail($email) {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE email = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$email]);
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            return $result;
        } catch (\Exception $e) {
            throw new \Exception("Lỗi tìm user: " . $e->getMessage());
        }
    }

    /**
     * Tìm user theo username
     */
    public function findByUsername($username) {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE name = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$username]);
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            return $result;
        } catch (\Exception $e) {
            throw new \Exception("Lỗi tìm user: " . $e->getMessage());
        }
    }

    /**
     * Kiểm tra email đã tồn tại
     */
    public function emailExists($email) {
        $user = $this->findByEmail($email);
        return $user !== null && $user !== false;
    }

    /**
     * Kiểm tra password
     */
    public function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }

    /**
     * Cập nhật password
     */
    public function updatePassword($id, $newPassword) {
        $sql = "UPDATE {$this->table} SET password = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            password_hash($newPassword, PASSWORD_BCRYPT),
            $id
        ]);
    }

    /**
     * Tạo user mới với password hash
     */
    public function registerUser($data) {
        $sql = "INSERT INTO {$this->table} (name, email, password, role, created_at) 
                VALUES (?, ?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $data['email'],
            password_hash($data['password'], PASSWORD_BCRYPT),
            $data['role'] ?? 'user'
        ]);
    }

    /**
     * Tìm user theo reset token
     */
    public function findByResetToken($token) {
        $sql = "SELECT * FROM {$this->table} WHERE reset_token = ? AND reset_token_expires > NOW()";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Xóa reset token
     */
    public function clearResetToken($userId) {
        $sql = "UPDATE {$this->table} SET reset_token = NULL, reset_token_expires = NULL WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$userId]);
    }
}
?>

