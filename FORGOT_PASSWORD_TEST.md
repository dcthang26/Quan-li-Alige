# Test Chức Năng Quên Mật Khẩu

## Cách thức hoạt động:

1. **Bước 1**: Người dùng truy cập `/forgot-password`
2. **Bước 2**: Nhập tên tài khoản (username) 
3. **Bước 3**: Hệ thống kiểm tra tên tài khoản có tồn tại không
4. **Bước 4**: Nếu tồn tại, chuyển hướng đến `/reset-password`
5. **Bước 5**: Người dùng nhập mật khẩu mới và xác nhận
6. **Bước 6**: Cập nhật mật khẩu và chuyển về trang login

## Các tài khoản test:

- **Admin**: username = "Admin", email = "admin@admin.com", password = "123456"
- **User**: username = "User Client", email = "user@user.com", password = "123456"

## Các trường hợp test:

### Test Case 1: Tên tài khoản không tồn tại
- Input: username = "nonexistent"
- Expected: Hiển thị lỗi "Tên tài khoản không tồn tại"

### Test Case 2: Tên tài khoản tồn tại
- Input: username = "Admin"
- Expected: Chuyển đến trang reset password với thông báo thành công

### Test Case 3: Mật khẩu không khớp
- Input: password = "123456", confirm_password = "654321"
- Expected: Hiển thị lỗi "Mật khẩu không khớp"

### Test Case 4: Mật khẩu quá ngắn
- Input: password = "123", confirm_password = "123"
- Expected: Hiển thị lỗi "Mật khẩu phải có ít nhất 6 ký tự"

### Test Case 5: Reset thành công
- Input: password = "newpass123", confirm_password = "newpass123"
- Expected: Cập nhật thành công, chuyển về login

## URLs:
- Forgot Password: http://localhost/ASM2/forgot-password
- Reset Password: http://localhost/ASM2/reset-password (chỉ truy cập được sau khi verify username)
- Login: http://localhost/ASM2/login