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
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? 0;
            $quantity = $_POST['quantity'] ?? '';
            $description = $_POST['description'] ?? '';
            $quantity = $_POST['quantity'] ?? 0;
            $file = $_FILES['image'] ?? null;
            // dd($_POST);
            // xử lí validate dữ liệu
            if($file['name'] != ''){
              $image =  upload_file($file, 'images');
            }
            $data = [
                'name' => $name,
                'price' => $price,
                'quantity' => $quantity,
                'description' => $description,
                'image' => $image ?? '',
            ];
            // lưu dữ liệu vào db
            $productsModel = new \App\Models\ProductModel();
            $productsModel->create($data);
            //chuyển hướng về trang danh sách sản phẩm
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
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? 0;
            $quantity = $_POST['quantity'] ?? '';
            $description = $_POST['description'] ?? '';
            $quantity = $_POST['quantity'] ?? 0;
            $file = $_FILES['image'] ?? null;
            // dd($_POST);
            // xử lí validate dữ liệu
            if($file['name'] != ''){
              $image =  upload_file($file, 'images');
            }
            $data = [
                'name' => $name,
                'price' => $price,
                'quantity' => $quantity,
                'description' => $description,
                'image' => $image ?? $productsCurrent->image,
            ];
            // lưu dữ liệu vào db
            $productsModel = new \App\Models\ProductModel();
            $productsModel->update($id, $data);
            //chuyển hướng về trang danh sách sản phẩm
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
