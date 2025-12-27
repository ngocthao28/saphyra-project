<?php
session_start();

// Kiểm tra đăng nhập
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
}

require_once 'products_data.php';

$products = getProducts();
$hiddenProducts = getHiddenProducts();

// Lấy thông báo từ session
$message = '';
if (isset($_SESSION['success_message'])) {
    $message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}
if (isset($_SESSION['error_message'])) {
    $message = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}

// Xử lý đăng xuất
if (isset($_GET['logout'])) {
    session_destroy();
    // Xóa adminSession trong localStorage và chuyển về trang chủ
    echo '<script>
        localStorage.removeItem("adminSession");
        window.location.href = "index.php";
    </script>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm - Admin SAPHARY</title>
    
    <!-- Favicon - Logo SAPHARY -->
    <link rel="icon" type="image/jpeg" href="img/logo.jpg">
    <link rel="shortcut icon" type="image/jpeg" href="img/logo.jpg">
    <link rel="apple-touch-icon" href="img/logo.jpg">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header h1 {
            font-size: 24px;
        }
        .header-right {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        .btn {
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            cursor: pointer;
            border: none;
            font-size: 14px;
        }
        .btn-primary {
            background: white;
            color: #667eea;
        }
        .btn-primary:hover {
            background: #f0f0f0;
        }
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        .btn-danger:hover {
            background: #c82333;
            transform: scale(1.05);
        }
        .btn-danger:active {
            transform: scale(0.95);
        }
        
        /* Nút xóa vĩnh viễn - màu đỏ đậm hơn */
        button[value="delete"],
        form[onsubmit*="XÓA VĨNH VIỄN"] .btn-danger {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
        }
        button[value="delete"]:hover,
        form[onsubmit*="XÓA VĨNH VIỄN"] .btn-danger:hover {
            background: linear-gradient(135deg, #c82333 0%, #a71d2a 100%);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.5);
        }
        .btn-success {
            background: #28a745;
            color: white;
        }
        .btn-success:hover {
            background: #218838;
        }
        .admin-layout {
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 30px;
            max-width: 1600px;
            margin: 30px auto;
            padding: 0 20px;
        }
        .admin-sidebar {
            background: white;
            border-radius: 10px;
            padding: 20px;
            height: fit-content;
            position: sticky;
            top: 20px;
        }
        .sidebar-item {
            padding: 15px 20px;
            margin-bottom: 10px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #333;
        }
        .sidebar-item:hover {
            background: #f8f4fc;
            color: #451c5f;
        }
        .sidebar-item.active {
            background: #451c5f;
            color: white;
        }
        .admin-content {
            background: white;
            border-radius: 10px;
            padding: 30px;
        }
        .admin-section {
            display: none;
        }
        .admin-section.active {
            display: block;
        }
        .admin-section h2 {
            color: #451c5f;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
        .products-table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead {
            background: #451c5f;
            color: white;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
        }
        tbody tr {
            border-bottom: 1px solid #e0e0e0;
            transition: background 0.2s;
        }
        tbody tr:hover {
            background: #f8f9fa;
        }
        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }
        .product-name {
            font-weight: 600;
            color: #333;
        }
        .price {
            color: #451c5f;
            font-weight: 600;
        }
        .quantity {
            display: inline-block;
            padding: 4px 12px;
            background: #e3f2fd;
            color: #1976d2;
            border-radius: 20px;
            font-weight: 600;
        }
        .quantity.low {
            background: #ffebee;
            color: #c62828;
        }
        
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            animation: fadeIn 0.3s;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .modal-content {
            background: white;
            margin: 30px auto;
            padding: 0;
            border-radius: 15px;
            width: 90%;
            max-width: 700px;
            max-height: 90vh;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            animation: slideDown 0.3s;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        
        .modal-body {
            padding: 30px;
            overflow-y: auto;
            max-height: calc(90vh - 100px);
        }
        
        /* Custom scrollbar */
        .modal-body::-webkit-scrollbar {
            width: 8px;
        }
        
        .modal-body::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .modal-body::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
        }
        
        .modal-body::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }
        @keyframes slideDown {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 30px;
            border-bottom: 2px solid #e0e0e0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px 15px 0 0;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .modal-header h2 {
            color: white;
            margin: 0;
        }
        .close {
            font-size: 32px;
            font-weight: bold;
            color: white;
            cursor: pointer;
            transition: all 0.3s;
            line-height: 1;
            opacity: 0.8;
        }
        .close:hover {
            opacity: 1;
            transform: rotate(90deg);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: border-color 0.3s;
        }
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }
        .form-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 2px solid #e0e0e0;
            position: sticky;
            bottom: 0;
            background: white;
            margin-left: -30px;
            margin-right: -30px;
            margin-bottom: -30px;
            padding-left: 30px;
            padding-right: 30px;
            padding-bottom: 20px;
        }
        
        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
        }
        .stat-icon {
            font-size: 40px;
            margin-bottom: 10px;
        }
        .stat-value {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .stat-label {
            font-size: 14px;
            opacity: 0.9;
        }
        
        /* Orders Table */
        .order-card {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
        }
        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .order-status {
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-processing { background: #cfe2ff; color: #084298; }
        .status-shipping { background: #d1e7dd; color: #0f5132; }
        .status-completed { background: #d1e7dd; color: #0f5132; }
        .status-cancelled { background: #f8d7da; color: #842029; }
        
        /* Customer Table */
        .customer-card {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        /* Contact Form */
        .contact-form {
            max-width: 800px;
        }
        .contact-form select,
        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🛍️ SAPHARY Admin Dashboard</h1>
        <div class="header-right">
            <span>Xin chào, <strong><?php echo htmlspecialchars($_SESSION['admin_username']); ?></strong></span>
            <a href="index.php" class="btn btn-primary">Xem trang chủ</a>
            <a href="?logout=1" class="btn btn-danger">Đăng xuất</a>
        </div>
    </div>

    <div class="admin-layout">
        <!-- Sidebar Navigation -->
        <div class="admin-sidebar">
            <div class="sidebar-item active" onclick="showSection('products')">
                <span>📦</span> Quản lý sản phẩm
            </div>
            <div class="sidebar-item" onclick="showSection('hidden-products')">
                <span>👁️</span> Sản phẩm đã ẩn
            </div>
            <div class="sidebar-item" onclick="showSection('orders')">
                <span>🛒</span> Quản lý đơn hàng
            </div>
            <div class="sidebar-item" onclick="showSection('customers')">
                <span>👥</span> Quản lý khách hàng
            </div>
            <div class="sidebar-item" onclick="showSection('contacts')">
                <span>📧</span> Liên hệ khách hàng
            </div>
            <div class="sidebar-item" onclick="showSection('statistics')">
                <span>📊</span> Thống kê
            </div>
        </div>

        <!-- Main Content -->
        <div class="admin-content">
            <?php if ($message): ?>
                <div class="success-message">✓ <?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <!-- Quản lý sản phẩm -->
            <div id="products" class="admin-section active">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                    <h2 style="margin: 0;">Quản lý sản phẩm</h2>
                    <button class="btn btn-success" onclick="openAddModal()" style="font-size: 16px;">
                        ➕ Thêm sản phẩm mới
                    </button>
                </div>
                <div class="products-table">
                    <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td>
                            <img src="<?php echo htmlspecialchars($product['imgs'][0]); ?>" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                 class="product-img">
                        </td>
                        <td class="product-name"><?php echo htmlspecialchars($product['name']); ?></td>
                        <td class="price"><?php echo number_format($product['price']); ?> VND</td>
                        <td>
                            <span class="quantity <?php echo ($product['quantity'] < 20) ? 'low' : ''; ?>">
                                <?php echo $product['quantity']; ?> sản phẩm
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-success" onclick="openEditModal(<?php echo htmlspecialchars(json_encode($product)); ?>)">
                                ✏️ Sửa
                            </button>
                            <form method="POST" action="admin_product_handler.php" style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn ẩn sản phẩm này?')">
                                <input type="hidden" name="action" value="hide">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <button type="submit" class="btn btn-danger">👁️ Ẩn</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Sản phẩm đã ẩn -->
    <div id="hidden-products" class="admin-section">
        <h2>Sản phẩm đã ẩn (<?php echo count($hiddenProducts); ?>)</h2>
        <?php if (empty($hiddenProducts)): ?>
            <p style="text-align:center;color:#999;padding:40px;">Không có sản phẩm nào bị ẩn</p>
        <?php else: ?>
            <div class="products-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($hiddenProducts as $product): ?>
                        <tr style="opacity: 0.6;">
                            <td><?php echo $product['id']; ?></td>
                            <td>
                                <img src="<?php echo htmlspecialchars($product['imgs'][0]); ?>" 
                                     alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                     class="product-img">
                            </td>
                            <td class="product-name"><?php echo htmlspecialchars($product['name']); ?></td>
                            <td class="price"><?php echo number_format($product['price']); ?> VND</td>
                            <td>
                                <span class="quantity"><?php echo $product['quantity']; ?> sản phẩm</span>
                            </td>
                            <td>
                                <form method="POST" action="admin_product_handler.php" style="display:inline;">
                                    <input type="hidden" name="action" value="unhide">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <button type="submit" class="btn btn-success">👁️ Hiển thị lại</button>
                                </form>
                                <form method="POST" action="admin_product_handler.php" style="display:inline; margin-left: 5px;" 
                                      onsubmit="return confirm('⚠️ CẢNH BÁO: Bạn có chắc muốn XÓA VĨNH VIỄN sản phẩm này?\n\nHành động này KHÔNG THỂ HOÀN TÁC!\n\n✓ Sản phẩm sẽ bị xóa khỏi hệ thống\n✓ Tất cả ảnh sản phẩm sẽ bị xóa\n✓ Dữ liệu không thể khôi phục')">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <button type="submit" class="btn btn-danger" style="background: #dc3545;">🗑️ Xóa vĩnh viễn</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- Quản lý đơn hàng -->
    <div id="orders" class="admin-section">
        <h2>Quản lý đơn hàng</h2>
        <div id="ordersList"></div>
    </div>

    <!-- Quản lý khách hàng -->
    <div id="customers" class="admin-section">
        <h2>Quản lý khách hàng</h2>
        <div id="customersList"></div>
    </div>

    <!-- Liên hệ khách hàng -->
    <div id="contacts" class="admin-section">
        <h2>Liên hệ khách hàng</h2>
        <div class="contact-form">
            <h3>Gửi email cho khách hàng</h3>
            <form id="contactForm">
                <div class="form-group">
                    <label>Chọn khách hàng</label>
                    <select id="customerSelect" required></select>
                </div>
                <div class="form-group">
                    <label>Tiêu đề</label>
                    <input type="text" id="emailSubject" required>
                </div>
                <div class="form-group">
                    <label>Nội dung</label>
                    <textarea id="emailContent" rows="6" required></textarea>
                </div>
                <button type="submit" class="btn btn-success">📧 Gửi email</button>
            </form>
        </div>
    </div>

    <!-- Thống kê -->
    <div id="statistics" class="admin-section">
        <h2>Thống kê tổng quan</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">📦</div>
                <div class="stat-value" id="totalProducts">0</div>
                <div class="stat-label">Tổng sản phẩm</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🛒</div>
                <div class="stat-value" id="totalOrders">0</div>
                <div class="stat-label">Tổng đơn hàng</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">👥</div>
                <div class="stat-value" id="totalCustomers">0</div>
                <div class="stat-label">Tổng khách hàng</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">💰</div>
                <div class="stat-value" id="totalRevenue">0 VND</div>
                <div class="stat-label">Tổng doanh thu</div>
            </div>
        </div>
    </div>
</div>

    <!-- Modal thêm sản phẩm mới -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>➕ Thêm sản phẩm mới</h2>
                <span class="close" onclick="closeAddModal()">&times;</span>
            </div>
            <div class="modal-body">
            <form method="POST" action="admin_product_handler.php" id="addForm" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add">
                
                <div class="form-group">
                    <label for="add_name">Tên sản phẩm *</label>
                    <input type="text" id="add_name" name="name" required placeholder="VD: Nhẫn Kim Cương Cao Cấp">
                </div>
                
                <div class="form-group">
                    <label for="add_category">Danh mục *</label>
                    <select id="add_category" name="category" required style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px;">
                        <option value="">-- Chọn danh mục --</option>
                        <option value="Nhẫn">💍 Nhẫn</option>
                        <option value="Dây chuyền">📿 Dây chuyền</option>
                        <option value="Bông tai">💎 Bông tai</option>
                        <option value="Vòng tay">⭕ Vòng tay</option>
                    </select>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="form-group">
                        <label for="add_price">Giá (VND) *</label>
                        <input type="number" id="add_price" name="price" min="0" step="1000" required placeholder="VD: 500000">
                    </div>
                    
                    <div class="form-group">
                        <label for="add_quantity">Số lượng *</label>
                        <input type="number" id="add_quantity" name="quantity" min="1" required placeholder="VD: 50">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="add_material">Chất liệu</label>
                    <input type="text" id="add_material" name="material" placeholder="VD: Bạc 925, mạ vàng trắng 18K">
                </div>
                
                <div class="form-group">
                    <label for="add_stone">Loại đá</label>
                    <input type="text" id="add_stone" name="stone" placeholder="VD: Kim cương thiên nhiên, Cubic Zirconia">
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="form-group">
                        <label for="add_size">Kích thước</label>
                        <input type="text" id="add_size" name="size" placeholder="VD: 1.2cm x 0.8cm">
                    </div>
                    
                    <div class="form-group">
                        <label for="add_weight">Trọng lượng</label>
                        <input type="text" id="add_weight" name="weight" placeholder="VD: 2.5g">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="add_desc">Mô tả sản phẩm *</label>
                    <textarea id="add_desc" name="desc" required 
                              placeholder="Nhập mô tả chi tiết về sản phẩm: chất liệu, đặc điểm, ưu điểm, công dụng..."
                              style="min-height: 120px;"></textarea>
                    <small style="color:#666;display:block;margin-top:5px;">
                        💡 Mô tả chi tiết giúp khách hàng hiểu rõ hơn về sản phẩm
                    </small>
                </div>
                
                <div class="form-group">
                    <label for="add_images">Hình ảnh sản phẩm * (Chọn 2-5 ảnh)</label>
                    <input type="file" id="add_images" name="images[]" multiple accept="image/*" required
                           style="padding:10px;border:2px dashed rgb(71, 31, 97);border-radius:8px;width:100%;cursor:pointer;">
                    <small style="color:#666;display:block;margin-top:5px;">
                        📸 Chọn nhiều ảnh (giữ Ctrl/Cmd). Ảnh đầu tiên sẽ là ảnh đại diện.
                    </small>
                    <div id="add_preview_images" style="display:flex;gap:10px;margin-top:10px;flex-wrap:wrap;"></div>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn btn-danger" onclick="closeAddModal()">Hủy</button>
                    <button type="submit" class="btn btn-success">➕ Thêm sản phẩm</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <!-- Modal chỉnh sửa -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>✏️ Chỉnh sửa sản phẩm</h2>
                <span class="close" onclick="closeEditModal()">&times;</span>
            </div>
            <div class="modal-body">
            <form method="POST" action="admin_product_handler.php" id="editForm" enctype="multipart/form-data">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="product_id" id="edit_product_id">
                
                <div class="form-group">
                    <label for="edit_name">Tên sản phẩm</label>
                    <input type="text" id="edit_name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_price">Giá (VND)</label>
                    <input type="number" id="edit_price" name="price" min="0" step="1000" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_quantity">Số lượng</label>
                    <input type="number" id="edit_quantity" name="quantity" min="0" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_desc">Mô tả sản phẩm</label>
                    <textarea id="edit_desc" name="desc" required 
                              placeholder="Nhập mô tả chi tiết về sản phẩm: chất liệu, đặc điểm, ưu điểm..."
                              style="min-height: 120px;"></textarea>
                    <small style="color:#666;display:block;margin-top:5px;">
                        💡 Mô tả chi tiết giúp khách hàng hiểu rõ hơn về sản phẩm
                    </small>
                </div>
                
                <div class="form-group">
                    <label for="edit_images">Hình ảnh sản phẩm</label>
                    <div id="current_images" style="display:flex;gap:10px;margin-bottom:10px;flex-wrap:wrap;"></div>
                    <input type="file" id="edit_images" name="images[]" multiple accept="image/*" 
                           style="padding:10px;border:2px dashed rgb(71, 31, 97);border-radius:8px;width:100%;cursor:pointer;">
                    <small style="color:#666;display:block;margin-top:5px;">
                        📸 Chọn nhiều ảnh (giữ Ctrl/Cmd). Ảnh mới sẽ thay thế ảnh cũ.
                    </small>
                    <div id="preview_images" style="display:flex;gap:10px;margin-top:10px;flex-wrap:wrap;"></div>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn btn-danger" onclick="closeEditModal()">Hủy</button>
                    <button type="submit" class="btn btn-success">💾 Lưu thay đổi</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <script>
        function openEditModal(product) {
            document.getElementById('edit_product_id').value = product.id;
            document.getElementById('edit_name').value = product.name;
            document.getElementById('edit_price').value = product.price;
            document.getElementById('edit_quantity').value = product.quantity;
            document.getElementById('edit_desc').value = product.desc;
            
            // Hiển thị ảnh hiện tại
            const currentImagesDiv = document.getElementById('current_images');
            currentImagesDiv.innerHTML = '';
            if (product.imgs && product.imgs.length > 0) {
                product.imgs.forEach(img => {
                    const imgEl = document.createElement('img');
                    imgEl.src = img;
                    imgEl.style.width = '80px';
                    imgEl.style.height = '80px';
                    imgEl.style.objectFit = 'cover';
                    imgEl.style.borderRadius = '8px';
                    imgEl.style.border = '2px solid #e0e0e0';
                    currentImagesDiv.appendChild(imgEl);
                });
            }
            
            // Reset preview
            document.getElementById('preview_images').innerHTML = '';
            document.getElementById('edit_images').value = '';
            
            document.getElementById('editModal').style.display = 'block';
        }
        
        // Preview ảnh khi chọn file
        document.getElementById('edit_images')?.addEventListener('change', function(e) {
            const previewDiv = document.getElementById('preview_images');
            previewDiv.innerHTML = '';
            
            if (this.files.length > 0) {
                Array.from(this.files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.width = '80px';
                        img.style.height = '80px';
                        img.style.objectFit = 'cover';
                        img.style.borderRadius = '8px';
                        img.style.border = '2px solid rgb(71, 31, 97)';
                        previewDiv.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                });
            }
        });

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }
        
        // ===== MODAL THÊM SẢN PHẨM =====
        function openAddModal() {
            document.getElementById('addForm').reset();
            document.getElementById('add_preview_images').innerHTML = '';
            document.getElementById('addModal').style.display = 'block';
        }
        
        function closeAddModal() {
            document.getElementById('addModal').style.display = 'none';
        }
        
        // Preview ảnh khi thêm sản phẩm mới
        document.getElementById('add_images')?.addEventListener('change', function(e) {
            const previewDiv = document.getElementById('add_preview_images');
            previewDiv.innerHTML = '';
            
            if (this.files.length > 0) {
                if (this.files.length < 2) {
                    alert('⚠️ Vui lòng chọn ít nhất 2 ảnh cho sản phẩm!');
                    this.value = '';
                    return;
                }
                
                if (this.files.length > 5) {
                    alert('⚠️ Chỉ được chọn tối đa 5 ảnh!');
                    this.value = '';
                    return;
                }
                
                Array.from(this.files).forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imgWrapper = document.createElement('div');
                        imgWrapper.style.position = 'relative';
                        
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.width = '100px';
                        img.style.height = '100px';
                        img.style.objectFit = 'cover';
                        img.style.borderRadius = '8px';
                        img.style.border = '2px solid rgb(71, 31, 97)';
                        
                        if (index === 0) {
                            const badge = document.createElement('div');
                            badge.textContent = 'Ảnh chính';
                            badge.style.cssText = 'position:absolute;top:5px;left:5px;background:rgb(71, 31, 97);color:white;padding:2px 8px;border-radius:4px;font-size:11px;font-weight:600;';
                            imgWrapper.appendChild(badge);
                        }
                        
                        imgWrapper.appendChild(img);
                        previewDiv.appendChild(imgWrapper);
                    };
                    reader.readAsDataURL(file);
                });
            }
        });

        // Đóng modal khi click bên ngoài
        window.onclick = function(event) {
            const editModal = document.getElementById('editModal');
            const addModal = document.getElementById('addModal');
            
            if (event.target == editModal) {
                closeEditModal();
            }
            if (event.target == addModal) {
                closeAddModal();
            }
        }

        // ===== NAVIGATION =====
        function showSection(sectionId) {
            document.querySelectorAll('.admin-section').forEach(s => s.classList.remove('active'));
            document.querySelectorAll('.sidebar-item').forEach(s => s.classList.remove('active'));
            
            document.getElementById(sectionId).classList.add('active');
            event.target.closest('.sidebar-item').classList.add('active');
            
            // Load data cho section
            if (sectionId === 'orders') loadOrders();
            if (sectionId === 'customers') loadCustomers();
            if (sectionId === 'contacts') loadContactForm();
            if (sectionId === 'statistics') loadStatistics();
        }

        // ===== QUẢN LÝ ĐƠN HÀNG =====
        function loadOrders() {
            const orders = JSON.parse(localStorage.getItem('allOrders') || '[]');
            const ordersList = document.getElementById('ordersList');
            
            if (orders.length === 0) {
                ordersList.innerHTML = '<p style="text-align:center;color:#999;padding:40px;">Chưa có đơn hàng nào</p>';
                return;
            }
            
            ordersList.innerHTML = orders.map((order, index) => `
                <div class="order-card">
                    <div class="order-header">
                        <div>
                            <strong>Đơn hàng #${index + 1}</strong>
                            <div style="color:#666;font-size:14px;margin-top:5px;">📅 ${order.created_at || 'N/A'}</div>
                        </div>
                        <select onchange="updateOrderStatus(${index}, this.value)" class="order-status status-${order.status}">
                            <option value="pending" ${order.status === 'pending' ? 'selected' : ''}>⏳ Chờ xác nhận</option>
                            <option value="processing" ${order.status === 'processing' ? 'selected' : ''}>✅ Đã xác nhận - Chuẩn bị hàng</option>
                            <option value="shipping" ${order.status === 'shipping' ? 'selected' : ''}>🚚 Đang giao hàng</option>
                            <option value="completed" ${order.status === 'completed' ? 'selected' : ''}>✅ Hoàn thành</option>
                            <option value="cancelled" ${order.status === 'cancelled' ? 'selected' : ''}>❌ Đã hủy</option>
                        </select>
                    </div>
                    <div style="margin-bottom:10px;">
                        <strong>Khách hàng:</strong> ${order.name} - ${order.phone}
                    </div>
                    <div style="margin-bottom:10px;">
                        <strong>Địa chỉ:</strong> ${order.address}
                    </div>
                    <div style="margin-bottom:10px;">
                        <strong>Thanh toán:</strong> ${order.payment_method === 'cod' ? 'COD' : 'Chuyển khoản'}
                    </div>
                    <div style="font-size:18px;font-weight:600;color:#451c5f;">
                        Tổng: ${formatMoney(order.total)} VND
                    </div>
                    <button onclick="cancelOrder(${index})" class="btn btn-danger" style="margin-top:10px;">Hủy đơn</button>
                </div>
            `).join('');
        }

        function updateOrderStatus(index, newStatus) {
            const orders = JSON.parse(localStorage.getItem('allOrders') || '[]');
            const oldStatus = orders[index].status;
            orders[index].status = newStatus;
            
            // Cập nhật thời gian thay đổi trạng thái
            orders[index].status_updated_at = new Date().toISOString();
            
            localStorage.setItem('allOrders', JSON.stringify(orders));
            
            // Cập nhật cho user orders
            updateUserOrders();
            
            // Thông báo chi tiết
            const statusText = {
                'pending': 'Chờ xác nhận',
                'processing': 'Đã xác nhận - Đang chuẩn bị hàng',
                'shipping': 'Đang giao hàng',
                'completed': 'Hoàn thành',
                'cancelled': 'Đã hủy'
            };
            
            alert(`✅ Đã cập nhật trạng thái đơn hàng!\n\nTừ: ${statusText[oldStatus]}\nSang: ${statusText[newStatus]}\n\nKhách hàng sẽ thấy cập nhật ngay lập tức.`);
            loadOrders();
        }

        function cancelOrder(index) {
            if (!confirm('Bạn có chắc muốn hủy đơn hàng này?')) return;
            
            const orders = JSON.parse(localStorage.getItem('allOrders') || '[]');
            orders[index].status = 'cancelled';
            localStorage.setItem('allOrders', JSON.stringify(orders));
            
            updateUserOrders();
            
            alert('✅ Đã hủy đơn hàng!');
            loadOrders();
        }

        function updateUserOrders() {
            // Sync orders từ allOrders về userOrders của từng user
            const orders = JSON.parse(localStorage.getItem('allOrders') || '[]');
            const users = JSON.parse(localStorage.getItem('users') || '[]');
            
            // Tạo map email -> orders
            const ordersByEmail = {};
            orders.forEach(order => {
                const email = order.email || order.user_email;
                if (email) {
                    if (!ordersByEmail[email]) {
                        ordersByEmail[email] = [];
                    }
                    ordersByEmail[email].push(order);
                }
            });
            
            // Cập nhật cho từng user
            users.forEach(user => {
                const userOrders = ordersByEmail[user.email] || [];
                localStorage.setItem('userOrders_' + user.email, JSON.stringify(userOrders));
            });
            
            console.log('✅ Đã đồng bộ đơn hàng cho tất cả khách hàng');
        }

        // ===== QUẢN LÝ KHÁCH HÀNG =====
        function loadCustomers() {
            const users = JSON.parse(localStorage.getItem('users') || '[]');
            const customersList = document.getElementById('customersList');
            
            if (users.length === 0) {
                customersList.innerHTML = '<p style="text-align:center;color:#999;padding:40px;">Chưa có khách hàng nào</p>';
                return;
            }
            
            customersList.innerHTML = users.map((user, index) => `
                <div class="customer-card">
                    <div>
                        <div style="font-weight:600;font-size:16px;margin-bottom:5px;">${user.name}</div>
                        <div style="color:#666;font-size:14px;">📧 ${user.email}</div>
                        <div style="color:#666;font-size:14px;">📱 ${user.phone || 'N/A'}</div>
                        <div style="color:#666;font-size:14px;">📍 ${user.address || 'N/A'}</div>
                    </div>
                    <div>
                        <button onclick="viewCustomerOrders('${user.email}')" class="btn btn-primary">Xem đơn hàng</button>
                        <button onclick="deleteCustomer(${index})" class="btn btn-danger" style="margin-left:10px;">Xóa</button>
                    </div>
                </div>
            `).join('');
        }

        function viewCustomerOrders(email) {
            const orders = JSON.parse(localStorage.getItem('userOrders_' + email) || '[]');
            alert(`Khách hàng có ${orders.length} đơn hàng`);
            // Có thể mở modal hiển thị chi tiết
        }

        function deleteCustomer(index) {
            if (!confirm('⚠️ Bạn có chắc muốn xóa khách hàng này?')) return;
            
            const users = JSON.parse(localStorage.getItem('users') || '[]');
            users.splice(index, 1);
            localStorage.setItem('users', JSON.stringify(users));
            
            alert('✅ Đã xóa khách hàng!');
            loadCustomers();
        }

        // ===== LIÊN HỆ KHÁCH HÀNG =====
        function loadContactForm() {
            const users = JSON.parse(localStorage.getItem('users') || '[]');
            const select = document.getElementById('customerSelect');
            
            select.innerHTML = '<option value="">-- Chọn khách hàng --</option>' +
                users.map(u => `<option value="${u.email}">${u.name} (${u.email})</option>`).join('');
        }

        document.getElementById('contactForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('customerSelect').value;
            const subject = document.getElementById('emailSubject').value;
            const content = document.getElementById('emailContent').value;
            
            // Trong thực tế sẽ gửi email qua API
            alert(`📧 Email đã được gửi đến ${email}\n\nTiêu đề: ${subject}\n\nNội dung: ${content}`);
            
            this.reset();
        });

        // ===== THỐNG KÊ =====
        function loadStatistics() {
            const products = <?php echo json_encode($products); ?>;
            const orders = JSON.parse(localStorage.getItem('allOrders') || '[]');
            const users = JSON.parse(localStorage.getItem('users') || '[]');
            
            const totalRevenue = orders.reduce((sum, order) => {
                if (order.status !== 'cancelled') {
                    return sum + (order.total || 0);
                }
                return sum;
            }, 0);
            
            document.getElementById('totalProducts').textContent = products.length;
            document.getElementById('totalOrders').textContent = orders.length;
            document.getElementById('totalCustomers').textContent = users.length;
            document.getElementById('totalRevenue').textContent = formatMoney(totalRevenue) + ' VND';
        }

        function formatMoney(amount) {
            return new Intl.NumberFormat('vi-VN').format(amount);
        }

        // Load statistics on page load
        loadStatistics();
    </script>
</body>
</html>
