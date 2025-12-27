# 🌐 HƯỚNG DẪN CÀI ĐẶT TRÊN BYEHOST

## 📋 Thông tin hosting của bạn

- **Host:** sql207.byethost7.com
- **Database:** saphyra
- **Username:** b7_40550716
- **Password:** ⚠️ CẦN CẬP NHẬT

## 🚀 BƯỚC 1: Cập nhật mật khẩu database

### 1.1. Lấy mật khẩu database từ byehost
1. Đăng nhập vào byehost control panel
2. Vào **MySQL Databases**
3. Copy mật khẩu database

### 1.2. Cập nhật vào file config.php
Mở file `ecommerce/config.php`, tìm dòng:
```php
$db_pass = 'MẬT_KHẨU_DB';  // ⚠️ THAY BẰNG MẬT KHẨU THẬT CỦA BẠN
```

Thay `MẬT_KHẨU_DB` bằng mật khẩu thật của bạn.

## 🗄️ BƯỚC 2: Tạo bảng trong database

### 2.1. Truy cập phpMyAdmin trên byehost
1. Đăng nhập byehost control panel
2. Click **phpMyAdmin**
3. Chọn database: `saphyra`

### 2.2. Chạy SQL script
1. Click tab **SQL**
2. Mở file `database_setup_byehost.sql`
3. Copy **toàn bộ** nội dung
4. Paste vào ô SQL
5. Click **Go** để chạy

### 2.3. Kiểm tra kết quả
Sau khi chạy xong, bạn sẽ thấy 10 bảng:
- ✅ users
- ✅ admins
- ✅ categories
- ✅ products
- ✅ product_images
- ✅ orders
- ✅ order_items
- ✅ cart
- ✅ password_resets
- ✅ contacts

## 📤 BƯỚC 3: Upload files lên hosting

### 3.1. Chuẩn bị files
Các file cần upload từ thư mục `ecommerce/`:
```
ecommerce/
├── config.php (ĐÃ CẬP NHẬT MẬT KHẨU)
├── index.php
├── login.php
├── register.php
├── logout.php
├── header.php
├── footer.php
├── sanpham.php
├── cart.php
├── checkout.php
├── contact.php
├── gioithieu.php
├── admin_login.php
├── admin_dashboard.php
├── img/ (thư mục hình ảnh)
├── style.css/ (thư mục CSS)
└── ... (các file khác)
```

### 3.2. Upload qua FTP
1. Sử dụng FileZilla hoặc FTP client
2. Kết nối đến byehost:
   - Host: `ftpupload.net` hoặc `ftp.byethost7.com`
   - Username: `b7_40550716`
   - Password: (mật khẩu FTP của bạn)
3. Upload tất cả files vào thư mục `htdocs/`

### 3.3. Hoặc upload qua File Manager
1. Đăng nhập byehost control panel
2. Click **File Manager**
3. Vào thư mục `htdocs/`
4. Upload files (có thể zip trước rồi extract)

## ✅ BƯỚC 4: Kiểm tra website

### 4.1. Test kết nối database
Truy cập: `http://saphyra.byethost7.com/test_db_connection.php`

Phải thấy:
- ✅ Kết nối PDO thành công
- ✅ Bảng 'users' đã tồn tại
- ✅ Danh sách 10 bảng

### 4.2. Test đăng ký
1. Truy cập: `http://saphyra.byethost7.com/register.php`
2. Đăng ký tài khoản mới
3. Kiểm tra trong phpMyAdmin xem có user mới không

### 4.3. Test đăng nhập
1. Truy cập: `http://saphyra.byethost7.com/login.php`
2. Đăng nhập bằng tài khoản vừa tạo
3. Phải chuyển về trang chủ

### 4.4. Test admin
1. Truy cập: `http://saphyra.byethost7.com/admin_login.php`
2. Đăng nhập:
   - Username: `admin`
   - Password: `admin123`

## 🔧 Cấu hình tự động

File `config.php` đã được cấu hình tự động phát hiện môi trường:

```php
// Tự động phát hiện localhost hay hosting
if ($is_localhost) {
    // Dùng cấu hình XAMPP
    $db_host = 'localhost';
    $db_name = 'saphyra';
    $db_user = 'root';
    $db_pass = '';
} else {
    // Dùng cấu hình byehost
    $db_host = 'sql207.byethost7.com';
    $db_name = 'saphyra';
    $db_user = 'b7_40550716';
    $db_pass = 'MẬT_KHẨU_CỦA_BẠN';
}
```

## ⚠️ Lưu ý quan trọng

### 1. Giới hạn của byehost miễn phí
- ⏱️ Có thể bị giới hạn số lượng truy vấn/giờ
- 💾 Dung lượng database giới hạn
- 🚫 Có thể bị tạm ngưng nếu traffic cao

### 2. Bảo mật
- 🔐 Đổi mật khẩu admin sau khi cài đặt
- 🔒 Không để lộ thông tin database
- 🛡️ Sử dụng HTTPS nếu có thể

### 3. Đường dẫn file
Trên byehost, đường dẫn tuyệt đối là:
```
/home/vali15_8/byehost7.com/h7_40550716/htdocs/
```

Nhưng trong code chỉ cần dùng đường dẫn tương đối:
```php
require_once 'config.php';
include 'header.php';
```

### 4. Hình ảnh
Đảm bảo thư mục `img/` đã được upload đầy đủ với tất cả hình ảnh sản phẩm.

## 🐛 Xử lý lỗi thường gặp

### Lỗi: "Access denied for user"
- ✅ Kiểm tra mật khẩu database trong config.php
- ✅ Kiểm tra username: `b7_40550716`
- ✅ Kiểm tra host: `sql207.byethost7.com`

### Lỗi: "Unknown database"
- ✅ Kiểm tra tên database: `saphyra`
- ✅ Đảm bảo database đã được tạo trong control panel

### Lỗi: "Table doesn't exist"
- ✅ Chạy lại file `database_setup_byehost.sql`
- ✅ Kiểm tra trong phpMyAdmin xem có 10 bảng chưa

### Lỗi: "Headers already sent"
- ✅ Đảm bảo không có khoảng trắng trước `<?php`
- ✅ Đảm bảo không có `echo` trước `header()`

### Lỗi: "500 Internal Server Error"
- ✅ Kiểm tra file permissions (755 cho thư mục, 644 cho file)
- ✅ Kiểm tra syntax error trong PHP
- ✅ Xem error log trong control panel

## 📞 Hỗ trợ

Nếu gặp vấn đề:
1. Kiểm tra error log trong byehost control panel
2. Test từng bước một
3. Sử dụng file `test_db_connection.php` để debug

## 🎉 Hoàn thành!

Sau khi hoàn thành các bước trên, website của bạn sẽ hoạt động trên byehost với:
- ✅ Đăng ký/Đăng nhập
- ✅ Quản lý sản phẩm
- ✅ Giỏ hàng
- ✅ Đặt hàng
- ✅ Admin dashboard

---
**Website:** http://saphyra.byethost7.com
**Admin:** http://saphyra.byethost7.com/admin_login.php
