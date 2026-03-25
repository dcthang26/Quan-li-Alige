<?php
namespace App\Controllers\admin;

class ProductController {
    public function index() {
        $productsModel = new \App\Models\ProductModel();
        $products = $productsModel->all();
        //dd($products);
        //truyền dữ liệu sản phẩm vào view 
        view('admin.products.listing', ['products' => $products]);
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

       
    public function delete($id) { 
        if($id > 0){
            $productsModel = new \App\Models\ProductModel();
            $productsModel->delete($id);
            //chuyển hướng về trang danh sách sản phẩm
            redirect('/admin/products');
        }
    }
}
?>
