<?php
session_start();

// Kiểm tra đăng nhập admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
}

require_once 'products_data.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    
    // ===== THÊM SẢN PHẨM MỚI =====
    if ($_POST['action'] === 'add') {
        $uploadedImages = [];
        
        // Xử lý upload ảnh
        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            $uploadDir = 'img/';
            
            // Tạo thư mục nếu chưa tồn tại
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['images']['error'][$key] === 0) {
                    $originalName = $_FILES['images']['name'][$key];
                    $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
                    
                    // Kiểm tra định dạng file
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                    if (!in_array($extension, $allowedExtensions)) {
                        $_SESSION['error_message'] = 'Chỉ chấp nhận file ảnh: JPG, PNG, GIF, WEBP';
                        header('Location: admin_dashboard.php');
                        exit;
                    }
                    
                    // Tạo tên file unique
                    $filename = 'product_' . time() . '_' . uniqid() . '.' . $extension;
                    $filepath = $uploadDir . $filename;
                    
                    // Di chuyển file
                    if (move_uploaded_file($tmp_name, $filepath)) {
                        $uploadedImages[] = $filepath;
                    }
                }
            }
        }
        
        // Kiểm tra có ít nhất 1 ảnh
        if (empty($uploadedImages)) {
            $_SESSION['error_message'] = 'Vui lòng upload ít nhất 1 ảnh sản phẩm!';
            header('Location: admin_dashboard.php');
            exit;
        }
        
        // Chuẩn bị dữ liệu sản phẩm
        $productData = [
            'name' => trim($_POST['name']),
            'price' => floatval($_POST['price']),
            'quantity' => intval($_POST['quantity']),
            'desc' => trim($_POST['desc']),
            'imgs' => $uploadedImages,
            'category' => trim($_POST['category'] ?? ''),
            'material' => trim($_POST['material'] ?? ''),
            'stone' => trim($_POST['stone'] ?? ''),
            'size' => trim($_POST['size'] ?? ''),
            'weight' => trim($_POST['weight'] ?? '')
        ];
        
        // Thêm sản phẩm vào database
        $newProduct = addProduct($productData);
        
        if ($newProduct) {
            $_SESSION['success_message'] = '✅ Đã thêm sản phẩm mới thành công! ID: ' . $newProduct['id'];
        } else {
            $_SESSION['error_message'] = '❌ Có lỗi xảy ra khi thêm sản phẩm!';
        }
        
        header('Location: admin_dashboard.php');
        exit;
    }
    
    // ===== CẬP NHẬT SẢN PHẨM =====
    elseif ($_POST['action'] === 'update') {
        $id = intval($_POST['product_id']);
        $data = [
            'name' => trim($_POST['name']),
            'price' => floatval($_POST['price']),
            'quantity' => intval($_POST['quantity']),
            'desc' => trim($_POST['desc'])
        ];
        
        // Xử lý upload ảnh mới (nếu có)
        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            $uploadedImages = [];
            $uploadDir = 'img/';
            
            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['images']['error'][$key] === 0) {
                    $extension = strtolower(pathinfo($_FILES['images']['name'][$key], PATHINFO_EXTENSION));
                    $filename = 'product_' . time() . '_' . uniqid() . '.' . $extension;
                    $filepath = $uploadDir . $filename;
                    
                    if (move_uploaded_file($tmp_name, $filepath)) {
                        $uploadedImages[] = $filepath;
                    }
                }
            }
            
            if (!empty($uploadedImages)) {
                $data['imgs'] = $uploadedImages;
            }
        }
        
        if (updateProduct($id, $data)) {
            $_SESSION['success_message'] = '✅ Cập nhật sản phẩm thành công!';
        } else {
            $_SESSION['error_message'] = '❌ Có lỗi xảy ra khi cập nhật!';
        }
        
        header('Location: admin_dashboard.php');
        exit;
    }
    
    // ===== ẨN SẢN PHẨM =====
    elseif ($_POST['action'] === 'hide') {
        $id = intval($_POST['product_id']);
        if (hideProduct($id)) {
            $_SESSION['success_message'] = '✅ Đã ẩn sản phẩm!';
        } else {
            $_SESSION['error_message'] = '❌ Có lỗi xảy ra!';
        }
        
        header('Location: admin_dashboard.php');
        exit;
    }
    
    // ===== HIỂN THỊ LẠI SẢN PHẨM =====
    elseif ($_POST['action'] === 'unhide') {
        $id = intval($_POST['product_id']);
        if (unhideProduct($id)) {
            $_SESSION['success_message'] = '✅ Đã hiển thị lại sản phẩm!';
        } else {
            $_SESSION['error_message'] = '❌ Có lỗi xảy ra!';
        }
        
        header('Location: admin_dashboard.php');
        exit;
    }
    
    // ===== XÓA SẢN PHẨM VĨNH VIỄN =====
    elseif ($_POST['action'] === 'delete') {
        $id = intval($_POST['product_id']);
        
        // Lấy thông tin sản phẩm trước khi xóa
        $product = getProductById($id);
        
        if (deleteProduct($id)) {
            $_SESSION['success_message'] = '✅ Đã xóa sản phẩm vĩnh viễn: ' . ($product ? $product['name'] : 'ID ' . $id);
        } else {
            $_SESSION['error_message'] = '❌ Có lỗi xảy ra khi xóa sản phẩm!';
        }
        
        header('Location: admin_dashboard.php');
        exit;
    }
}

// Nếu không có action hợp lệ, quay về dashboard
header('Location: admin_dashboard.php');
exit;
