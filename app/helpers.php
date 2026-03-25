<?php

use eftec\bladeone\BladeOne;

/**
 * hàm view dùng để render giao diện
 * $view: template blade view
 * $data: dữ liệu
 **/
function view($view, $data = [])
{
    $views = APP_DIR . '/resources/views';
    $cache = APP_DIR . '/storage/cache';
    $blade = new BladeOne($views, $cache, BladeOne::MODE_DEBUG); // MODE_DEBUG allows to pinpoint troubles.
    echo $blade->run($view, $data); // it calls /views/$view.blade.php
}

/**
 * Hàm dd dùng để hiển thị dữ liệu cần bug
 * @param $data: dữ liệu hiển thị
 */
function dd(...$data)
{
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    die;
}

//hàm route trả về đường dẫn cho route
function route($route)
{
    return APP_URL . $route;
}

//Hàm redirect điều hướng website
function redirect($path)
{
    header("location: " . route($path));
    die;
}

//Điều hường về lỗi không tìm thấy trang
function redirect404()
{
    redirect('404');
}

function upload_file(array $file, $folder = null)
{
    // Thông tin về file
    $fileTmpPath = $file['tmp_name']; // file tạm trên server
    $fileName = time() . '-' . $file['name']; // Tên file chống trùng bằng thời gian hiện tại

    $uploadDir = 'storage/' . $folder . '/';

    // Tạo thư mục nếu chưa tồn tại
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Đường dẫn đầy đủ để lưu file
    $destPath = $uploadDir . $fileName;

    // Di chuyển file từ thư mục tạm thời đến thư mục đích
    if (move_uploaded_file($fileTmpPath, $destPath)) {
        return $destPath;
    }

    throw new Exception('Lỗi upload file!');
}

//Lấy đường dẫn của file
function file_url($file)
{
    return APP_URL . $file;
}

//Kiểm tra file upload có tồn tại không
function is_upload($key)
{
    return isset($_FILES[$key]) && $_FILES[$key]['size'] > 0;
}

//Hàm session_flash. lấy session dùng 1 lần
function session_flash($key, $value = null)
{
    //Nếu có value, thì sẽ tiến hành set dữ liệu cho session
    if ($value !== null) {
        $_SESSION['_flash'][$key] = $value;
    } else {
        //Nếu chỉ có key, thì lấy value ra
        if (isset($_SESSION['_flash_old'][$key])) {
            $value = $_SESSION['_flash_old'][$key];
            unset($_SESSION['_flash_old'][$key]);
            return $value;
        }
    }
    return null;
}

//Gọi ở đầu mỗi request, thông thường sẽ ở index
function flash_next_request()
{
    $_SESSION['_flash_old'] = $_SESSION['_flash'] ?? [];
    unset($_SESSION['_flash']);
}
/**
 * Kiểm tra user đã đăng nhập chưa
 */
function is_auth()
{
    return isset($_SESSION['user']);
}

/**
 * Kiểm tra user có phải admin không
 */
function is_admin()
{
    return isset($_SESSION['user']) && $_SESSION['user']->role === 'admin';
}

/**
 * Lấy thông tin user hiện tại
 */
function auth_user()
{
    return $_SESSION['user'] ?? null;
}

/**
 * Chuyển hướng nếu chưa đăng nhập
 */
function require_auth()
{
    if (!is_auth()) {
        $_SESSION['error'] = 'Vui lòng đăng nhập để tiếp tục';
        redirect('/login');
    }
}

/**
 * Chuyển hướng nếu không phải admin
 */
function require_admin()
{
    if (!is_admin()) {
        $_SESSION['error'] = 'Bạn không có quyền truy cập';
        redirect('/');
    }
}