<?php
    namespace App\Controllers;
    class HomeController {
        public function index() {
            // Dữ liệu mẫu để truyền vào view
            $productModel = new \App\Models\ProductModel();
            $data = $productModel->all(); // Giả sử phương thức all() lấy
            view('client.home', ['data' => $data]);
        }
        public function add(){
            echo "This is Add Page";
        }
        public function detail($id) {
        echo "Đây là trang chi tiết. ID sản phẩm là: " . $id;
        }
        public function testPost() {
            echo "Đây là Test Post";
        }
        public function edit($id) {
            echo "Đây là trang sửa (Edit). ID: " . $id;
        }
        public function update($id) {
            echo "Đang xử lý cập nhật (Update) cho ID: " . $id;
        }
        public function delete($id) {
            echo "Đang xử lý xóa (Delete) ID: " . $id;
        }
    }
?>