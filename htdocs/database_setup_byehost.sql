-- =====================================================
-- SCRIPT TẠO BẢNG CHO BYEHOST
-- =====================================================
-- Database: saphyra
-- Chỉ cần tạo các bảng
-- =====================================================

USE `saphyra`;

-- =====================================================
-- XÓA CÁC BẢNG CŨ (NẾU CÓ)
-- =====================================================
DROP TABLE IF EXISTS `password_resets`;
DROP TABLE IF EXISTS `contacts`;
DROP TABLE IF EXISTS `cart`;
DROP TABLE IF EXISTS `order_items`;
DROP TABLE IF EXISTS `orders`;
DROP TABLE IF EXISTS `product_images`;
DROP TABLE IF EXISTS `products`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `admins`;
DROP TABLE IF EXISTS `users`;

-- =====================================================
-- BẢNG 1: USERS - Quản lý người dùng
-- =====================================================
CREATE TABLE `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `phone` VARCHAR(15) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `pin` VARCHAR(6) NOT NULL COMMENT 'Mã PIN thanh toán 6 số',
  `street` VARCHAR(255) DEFAULT NULL,
  `ward` VARCHAR(100) DEFAULT NULL,
  `district` VARCHAR(100) DEFAULT NULL,
  `city` VARCHAR(100) DEFAULT NULL,
  `full_address` TEXT DEFAULT NULL,
  `save_address` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_email` (`email`),
  INDEX `idx_phone` (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- BẢNG 2: ADMINS - Quản lý admin
-- =====================================================
CREATE TABLE `admins` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `full_name` VARCHAR(100) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `last_login` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- BẢNG 3: CATEGORIES - Danh mục sản phẩm
-- =====================================================
CREATE TABLE `categories` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(100) NOT NULL UNIQUE,
  `description` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- BẢNG 4: PRODUCTS - Sản phẩm
-- =====================================================
CREATE TABLE `products` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `quantity` INT(11) NOT NULL DEFAULT 0,
  `category` VARCHAR(100) DEFAULT NULL,
  `category_id` INT(11) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `material` VARCHAR(255) DEFAULT NULL COMMENT 'Chất liệu',
  `stone` VARCHAR(255) DEFAULT NULL COMMENT 'Loại đá',
  `size` VARCHAR(100) DEFAULT NULL COMMENT 'Kích thước',
  `weight` VARCHAR(50) DEFAULT NULL COMMENT 'Trọng lượng',
  `hidden` TINYINT(1) DEFAULT 0 COMMENT '0=hiển thị, 1=ẩn',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_category` (`category`),
  INDEX `idx_hidden` (`hidden`),
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- BẢNG 5: PRODUCT_IMAGES - Hình ảnh sản phẩm
-- =====================================================
CREATE TABLE `product_images` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `product_id` INT(11) NOT NULL,
  `image_path` VARCHAR(255) NOT NULL,
  `is_primary` TINYINT(1) DEFAULT 0 COMMENT '1=ảnh chính',
  `sort_order` INT(11) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_product_id` (`product_id`),
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- BẢNG 6: ORDERS - Đơn hàng
-- =====================================================
CREATE TABLE `orders` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) DEFAULT NULL,
  `customer_name` VARCHAR(100) NOT NULL,
  `customer_phone` VARCHAR(15) NOT NULL,
  `customer_email` VARCHAR(100) DEFAULT NULL,
  `customer_address` TEXT DEFAULT NULL,
  `total_amount` DECIMAL(10,2) NOT NULL,
  `payment_method` VARCHAR(20) DEFAULT 'cod' COMMENT 'cod, qr, bank',
  `status` VARCHAR(20) DEFAULT 'pending' COMMENT 'pending, confirmed, shipping, completed, cancelled',
  `notes` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_user_id` (`user_id`),
  INDEX `idx_status` (`status`),
  INDEX `idx_created_at` (`created_at`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- BẢNG 7: ORDER_ITEMS - Chi tiết đơn hàng
-- =====================================================
CREATE TABLE `order_items` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `order_id` INT(11) NOT NULL,
  `product_id` INT(11) NOT NULL,
  `product_name` VARCHAR(255) NOT NULL,
  `product_image` VARCHAR(255) DEFAULT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `quantity` INT(11) NOT NULL,
  `subtotal` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_order_id` (`order_id`),
  INDEX `idx_product_id` (`product_id`),
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- BẢNG 8: CART - Giỏ hàng
-- =====================================================
CREATE TABLE `cart` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) DEFAULT NULL,
  `session_id` VARCHAR(100) DEFAULT NULL COMMENT 'Cho khách chưa đăng nhập',
  `product_id` INT(11) NOT NULL,
  `quantity` INT(11) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_user_id` (`user_id`),
  INDEX `idx_session_id` (`session_id`),
  INDEX `idx_product_id` (`product_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- BẢNG 9: PASSWORD_RESETS - Quên mật khẩu
-- =====================================================
CREATE TABLE `password_resets` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `otp_code` VARCHAR(6) NOT NULL,
  `expires_at` TIMESTAMP NOT NULL,
  `is_used` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_email` (`email`),
  INDEX `idx_otp_code` (`otp_code`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- BẢNG 10: CONTACTS - Liên hệ
-- =====================================================
CREATE TABLE `contacts` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(15) DEFAULT NULL,
  `subject` VARCHAR(255) DEFAULT NULL,
  `message` TEXT NOT NULL,
  `status` VARCHAR(20) DEFAULT 'new' COMMENT 'new, read, replied',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_status` (`status`),
  INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- DỮ LIỆU MẪU
-- =====================================================

-- Thêm admin mặc định
INSERT INTO `admins` (`username`, `email`, `password`, `full_name`) VALUES
('admin', 'admin@saphyra.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator');

-- Thêm danh mục sản phẩm
INSERT INTO `categories` (`name`, `slug`, `description`) VALUES
('Bông tai', 'bong-tai', 'Các loại bông tai thời trang cao cấp'),
('Dây chuyền', 'day-chuyen', 'Dây chuyền bạc, vàng, kim cương'),
('Vòng tay', 'vong-tay', 'Vòng tay ngọc trai, kim cương, charm'),
('Nhẫn', 'nhan', 'Nhẫn cưới, nhẫn kim cương, nhẫn thời trang');

-- Thêm sản phẩm mẫu
INSERT INTO `products` (`id`, `name`, `price`, `quantity`, `category`, `description`, `material`, `stone`, `size`, `weight`, `hidden`) VALUES
(1, 'Bông Tai Nữ Tính', 99000.00, 31, 'Bông tai', 'Thiết kế bông tai hình trái tim, tôn lên vẻ nữ tính và thanh lịch. Chất liệu bạc 925 cao cấp, mạ vàng trắng 18K, đính đá Cubic Zirconia lấp lánh.', 'Bạc 925, mạ vàng trắng 18K', 'Cubic Zirconia', '1.2cm x 0.8cm', '2.5g', 1),
(2, 'Dây Chuyền Tuyết', 300000.00, 30, 'Dây chuyền', 'Dây chuyền pha lê cao cấp phản chiếu ánh sáng lung linh như tuyết rơi.', 'Bạc Ý 925', 'Pha lê Swarovski', 'Dài 45cm', '5.8g', 1),
(3, 'Vòng Tay Ngọc Trai', 250000.00, 40, 'Vòng tay', 'Vòng tay ngọc trai sang trọng, phù hợp với mọi phong cách.', 'Ngọc trai tự nhiên, khóa bạc 925', 'Ngọc trai', 'Chu vi 16-18cm', '8.2g', 0),
(4, 'Bông Tai Kim Cương', 899000.00, 16, 'Bông tai', 'Bông tai kim cương thiên nhiên cao cấp, thiết kế sang trọng và quý phái.', 'Vàng trắng 18K', 'Kim cương thiên nhiên 0.5 carat', '0.6cm x 0.6cm', '1.8g', 0),
(5, 'Vòng Tay Kim Cương', 1250000.00, 10, 'Vòng tay', 'Vòng tay kim cương cao cấp, biểu tượng của sự sang trọng và đẳng cấp.', 'Vàng trắng 18K', 'Kim cương thiên nhiên 1.2 carat', 'Chu vi 17cm', '12.5g', 0),
(6, 'Nhẫn Kim Cương', 549000.00, 20, 'Nhẫn', 'Nhẫn kim cương thiết kế cổ điển, vượt thời gian.', 'Vàng trắng 18K', 'Kim cương thiên nhiên 0.8 carat', 'Size 6-8', '4.2g', 0),
(7, 'Dây Chuyền Bạc Ý', 450000.00, 35, 'Dây chuyền', 'Dây chuyền bạc Ý 925 cao cấp, thiết kế đơn giản nhưng sang trọng.', 'Bạc Ý 925', 'Cubic Zirconia', 'Dài 42cm', '4.5g', 0),
(8, 'Bông Tai Ngọc Trai', 180000.00, 45, 'Bông tai', 'Bông tai ngọc trai thanh lịch, phù hợp cho phụ nữ hiện đại.', 'Bạc 925, ngọc trai tự nhiên', 'Ngọc trai', 'Đường kính 0.8cm', '2.8g', 0),
(9, 'Vòng Tay Charm Bạc', 320000.00, 28, 'Vòng tay', 'Vòng tay charm bạc 925 độc đáo với nhiều mặt charm có thể thay đổi.', 'Bạc 925', 'Không', 'Chu vi 16-19cm', '6.5g', 0),
(10, 'Bông Tai Dài Thời Trang', 150000.00, 50, 'Bông tai', 'Bông tai dài thời trang, thiết kế hiện đại và cá tính.', 'Hợp kim mạ vàng 14K', 'Đá pha lê', 'Dài 5cm', '3.2g', 0);

-- Thêm hình ảnh sản phẩm
INSERT INTO `product_images` (`product_id`, `image_path`, `is_primary`, `sort_order`) VALUES
(1, 'img/bong tai 2.jpg', 1, 1),
(1, 'img/bong tai 3.webp', 0, 2),
(2, 'img/day chuyen 4.jpg', 1, 1),
(2, 'img/day chuyen 2.jpg', 0, 2),
(3, 'img/vong tay 5.jpg', 1, 1),
(3, 'img/vong tay 3.jpg', 0, 2),
(4, 'img/bong tai1.jpg', 1, 1),
(4, 'img/bong tai 4.webp', 0, 2),
(5, 'img/vong tay 1.jpg', 1, 1),
(5, 'img/vong tay 2.jpg', 0, 2),
(6, 'img/product_1764945504_6932ee60cf38e.jpg', 1, 1),
(6, 'img/product_1764945504_6932ee60cfaee.jpg', 0, 2),
(7, 'img/day chuyen 1.jpg', 1, 1),
(7, 'img/day chuyen 3.jpg', 0, 2),
(8, 'img/bong tai 3.webp', 1, 1),
(8, 'img/bong tai 2.jpg', 0, 2),
(9, 'img/vong tay 4.jpg', 1, 1),
(9, 'img/vong tay 5.jpg', 0, 2),
(10, 'img/bong tai 4.webp', 1, 1),
(10, 'img/bong tai 5.webp', 0, 2);

-- =====================================================
-- HOÀN THÀNH!
-- =====================================================
