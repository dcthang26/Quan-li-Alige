THI THỬ
(Thời gian 60’)

1.	Chuẩn bị:
a)	Thiết kế CSDL sau:
i.	Bảng categories - Danh mục sản phẩm
Tên trường	Kiểu dữ liệu	Ghi chú
id	Integer, AutoIncrement	Định danh
name	Varchar(50)	Tên danh mục

ii.	Bảng products - Sản phẩm
Tên trường	Kiểu dữ liệu	Ghi chú
id	Integer, AutoIncrement	Định danh
category_id	Integer	ID category
name	Varchar(255)	Tên sản phẩm
img_thumbnail	Varchar(255), Null	Ảnh
description	Varchar(255), Null	Mô tả tổng quan
created_at	Datetime, Null	Ngày tạo sản phẩm
updated_at	Datetime, Null	Ngày sửa sản phẩm

b)	Thêm tối thiếu 2 danh mục và 2 sản phẩm.
c)	Base dự án do giảng viên cung cấp, bao gồm:
i.	Dự án đã hỗ trợ autoload
ii.	Thư mục chia rõ ràng theo MVC
iii.	Có sẵn file kết nối DB

2.	Yêu cầu: 
a)	Thiết kế đường dẫn theo yêu cầu sau
METHOD	URI	Mô tả
GET	/products	Danh sách
GET	/products/create	Hiển thị trang thêm
POST	/products/store	Lưu thêm
GET	/products/:id/edit	Hiển thị trang sửa
POST	/products/:id/update	Lưu sửa
GET	/products/:id/delete	Xóa

b)	Sinh viên thực hiện CRUD Product.
i.	Hiển thị danh sách sản phẩm bao gồm các cột sau: (2đ)
ID	Category Name	Name	Image Thumbnail	Created at	Updated at	Action

●	Chú ý quan trọng:
■	Dữ liệu lấy ra sắp xếp theo ID giảm dần
■	Cột category Name: Hiển thị tên danh mục sản phẩm
■	Image Thumbnail: Hiển thị hình ảnh sản phẩm thông qua thẻ img
■	Created at và Updated at: Hiển thị định dạng dd/mm/yyyy H:i:s
■	Action: Hiển thị 2 nút Sửa và Xóa
ii.	Thêm mới sản phẩm thành công. (1đ)
iii.	Sửa sản phẩm thành công. (1đ)
iv.	Xóa sản phẩm có confirm thành công. (1đ)
v.	Upload được ảnh khi tạo mới và sửa. (1đ)
vi.	Xóa được ảnh khi sửa và xóa. (1đ)
vii.	Validate khi thêm mới - Quy tắc theo Kiểu dữ liệu của các trường trong bảng products. (1đ)
viii.	Validate khi sửa - Quy tắc theo Kiểu dữ liệu của các trường trong bảng products. (1đ)

Sau khi chấm xong GV xoá project tại máy SV
COPY – HỎI BÀI DƯỚI MỌI HÌNH THỨC 0 ĐIỂM
