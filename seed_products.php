<?php
require_once 'env.php';

$pdo = new PDO("mysql:host=".HOST.";dbname=".DBNAME.";port=".PORT, USERNAME, PASSWORD);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$products = [
    ['Nike Air Max 270', 2850000, 50, 'Giày thể thao Nike Air Max 270 đế khí êm ái, thiết kế hiện đại', '38,39,40,41,42,43', 'Đen,Trắng,Xanh', 'khí'],
    ['Nike React Infinity', 3200000, 30, 'Giày chạy bộ Nike React Infinity với đế React siêu nhẹ', '39,40,41,42,43', 'Trắng,Đỏ', 'react'],
    ['Nike Air Force 1', 2500000, 45, 'Giày Nike Air Force 1 cổ điển, phong cách đường phố', '38,39,40,41,42', 'Trắng,Đen', 'khí'],
    ['Nike Zoom Pegasus', 2950000, 25, 'Giày chạy bộ Nike Zoom Pegasus nhẹ và bền', '39,40,41,42,43,44', 'Xanh,Cam,Đen', 'zoom'],
    ['Nike Blazer Mid', 2200000, 60, 'Giày Nike Blazer Mid cổ cao phong cách retro', '38,39,40,41,42', 'Trắng,Nâu', 'cứng'],
    ['Nike Dunk Low', 2700000, 35, 'Giày Nike Dunk Low thiết kế năng động trẻ trung', '38,39,40,41,42,43', 'Xanh lá,Trắng,Đen', 'cứng'],
    ['Nike Free Run', 1950000, 40, 'Giày chạy bộ Nike Free Run linh hoạt tự nhiên', '39,40,41,42', 'Xám,Đen,Xanh', 'dẻo'],
    ['Nike Metcon 8', 3100000, 20, 'Giày tập gym Nike Metcon 8 ổn định và chắc chắn', '40,41,42,43,44', 'Đen,Đỏ', 'cứng'],
];

$stmt = $pdo->prepare("INSERT INTO products (name, price, quantity, description, sizes, colors, sole, image) VALUES (?, ?, ?, ?, ?, ?, ?, '')");

$count = 0;
foreach ($products as $p) {
    $stmt->execute($p);
    $count++;
}

echo "Đã thêm $count sản phẩm thành công!";
