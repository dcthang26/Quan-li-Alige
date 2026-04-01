<?php
namespace App\Controllers\admin;

class ProductController {
    public function index() {
        $productsModel = new \App\Models\ProductModel();
        $all = $productsModel->all();

        $keyword = trim($_GET['q'] ?? '');
        $filterSize = trim($_GET['size'] ?? '');
        $filterSole = trim($_GET['sole'] ?? '');

        $products = array_filter($all, function($item) use ($keyword, $filterSize, $filterSole) {
            if ($keyword && stripos($item->name, $keyword) === false) return false;
            if ($filterSize) {
                $sizes = array_map('trim', explode(',', $item->sizes ?? ''));
                if (!in_array($filterSize, $sizes)) return false;
            }
            if ($filterSole) {
                $soles = array_map('trim', explode(',', $item->sole ?? ''));
                if (!in_array($filterSole, $soles)) return false;
            }
            return true;
        });
        $products = array_values($products);

        // Lấy tất cả size và sole unique để hiện filter
        $allSizes = [];
        $allSoles = [];
        foreach ($all as $item) {
            foreach (array_map('trim', explode(',', $item->sizes ?? '')) as $s) if ($s) $allSizes[] = $s;
            foreach (array_map('trim', explode(',', $item->sole ?? '')) as $s) if ($s) $allSoles[] = $s;
        }
        $allSizes = array_unique($allSizes);
        $allSoles = array_unique($allSoles);

        view('admin.products.listing', compact('products', 'keyword', 'filterSize', 'filterSole', 'allSizes', 'allSoles'));
    }
    public function show($id) {
        require_admin();
        $productsModel = new \App\Models\ProductModel();
        $product = $productsModel->find($id);
        if (!$product) {
            $_SESSION['error'] = 'Sản phẩm không tồn tại';
            return redirect('/admin/products');
        }
        view('admin.products.show', compact('product'));
    }

    public function add() {
        view('admin.products.add');
    }

    public function store() {
        require_admin();
        $name        = trim($_POST['name'] ?? '');
        $price       = $_POST['price'] ?? '';
        $quantity    = $_POST['quantity'] ?? '';
        $description = trim($_POST['description'] ?? '');
        $sizes       = trim($_POST['sizes'] ?? '');
        $colors      = trim($_POST['colors'] ?? '');
        $sole        = $_POST['sole'] ?? '';
        $file        = $_FILES['image'] ?? null;

        if (empty($name)) {
            $_SESSION['error'] = 'Tên sản phẩm không được để trống';
            return redirect('/admin/products/add');
        }
        if ($price === '' || !is_numeric($price) || (float)$price <= 0) {
            $_SESSION['error'] = 'Giá sản phẩm phải lớn hơn 0';
            return redirect('/admin/products/add');
        }
        if ($quantity === '' || !is_numeric($quantity) || (int)$quantity < 0) {
            $_SESSION['error'] = 'Số lượng không hợp lệ';
            return redirect('/admin/products/add');
        }
        if (empty($description)) {
            $_SESSION['error'] = 'Mô tả không được để trống';
            return redirect('/admin/products/add');
        }

        if (!empty($file['name'])) {
            $image = upload_file($file, 'images');
        }

        $data = [
            'name'        => $name,
            'price'       => (float)$price,
            'quantity'    => (int)$quantity,
            'description' => $description,
            'image'       => $image ?? '',
            'sizes'       => $sizes,
            'colors'      => $colors,
            'sole'        => $sole ?: null,
        ];

        $productsModel = new \App\Models\ProductModel();
        $productsModel->create($data);
        $_SESSION['success'] = 'Thêm sản phẩm thành công';
        redirect('/admin/products');
    }
    

    public function edit($id) {
        require_admin();
        $id = $id ?? 0;
        $productsModel = new \App\Models\ProductModel();
        $productCurrent = $productsModel->find($id);
        // dd($productCurrent);
        view ('admin.products.edit', ['productCurrent' => $productCurrent]);
    }

    public function update($id) {
        require_admin();
        $productsModel = new \App\Models\ProductModel();
        $productsCurrent = $productsModel->find($id);
        // dd($_POST);
        //kiểm tra xem người dùng click nút submit chưa
        if(isset($_POST['submit'])){
            $name        = trim($_POST['name'] ?? '');
            $price       = $_POST['price'] ?? 0;
            $quantity    = $_POST['quantity'] ?? 0;
            $description = trim($_POST['description'] ?? '');
            $sizes       = trim($_POST['sizes'] ?? '');
            $colors      = trim($_POST['colors'] ?? '');
            $sole        = $_POST['sole'] ?? '';
            $file        = $_FILES['image'] ?? null;

            if($file['name'] != ''){
                $image = upload_file($file, 'images');
            }
            $data = [
                'name'        => $name,
                'price'       => $price,
                'quantity'    => $quantity,
                'description' => $description,
                'image'       => $image ?? $productsCurrent->image,
                'sizes'       => $sizes,
                'colors'      => $colors,
                'sole'        => $sole ?: null,
            ];
            $productsModel = new \App\Models\ProductModel();
            $productsModel->update($id, $data);
            $_SESSION['success'] = 'Cập nhật sản phẩm thành công';
            redirect('/admin/products');
        }
    }

       
    public function autoSave($id) {
        require_admin();
        header('Content-Type: application/json');
        $id = intval($id);
        $allowed = ['name', 'price', 'quantity', 'description', 'sizes', 'colors', 'sole'];
        $input = json_decode(file_get_contents('php://input'), true) ?? [];
        $data = array_filter($input, fn($k) => in_array($k, $allowed), ARRAY_FILTER_USE_KEY);

        if (empty($data) || $id <= 0) {
            echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
            exit;
        }

        try {
            $productsModel = new \App\Models\ProductModel();
            $productsModel->update($id, $data);
            echo json_encode(['success' => true, 'message' => 'Đã lưu']);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Lỗi lưu']);
        }
        exit;
    }

    public function delete($id) { 
        if($id > 0){
            $productsModel = new \App\Models\ProductModel();
            $product = $productsModel->find($id);
            $productsModel->delete($id);
            $_SESSION['success'] = 'Xóa sản phẩm "' . ($product->name ?? '') . '" thành công';
            redirect('/admin/products');
        }
    }
}
?>
