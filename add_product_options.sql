ALTER TABLE `products`
  ADD COLUMN `sizes`  VARCHAR(255) NULL COMMENT 'Danh sách size, phân cách bằng dấu phẩy. VD: 38,39,40,41,42' AFTER `quantity`,
  ADD COLUMN `colors` VARCHAR(255) NULL COMMENT 'Danh sách màu, phân cách bằng dấu phẩy. VD: Đỏ,Xanh,Đen' AFTER `sizes`,
  ADD COLUMN `sole`   ENUM('mềm','cứng','dẻo') NULL COMMENT 'Loại đế giày' AFTER `colors`;
