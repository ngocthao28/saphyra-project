<?php
session_start();
require_once 'products_data.php';

// Lấy ID sản phẩm từ URL
$id = $_GET['id'] ?? 1;
$product = getProductById($id);

if (!$product) {
  die("Sản phẩm không tồn tại!");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title><?php echo $product['name']; ?> | SAPHARY</title>
  
  <!-- Favicon - Logo SAPHARY -->
  <link rel="icon" type="image/jpeg" href="img/logo.jpg">
  <link rel="shortcut icon" type="image/jpeg" href="img/logo.jpg">
  <link rel="apple-touch-icon" href="img/logo.jpg">
  
  <style>
    body { font-family: 'Segoe UI'; background: #f8f8f8; margin: 0; padding: 0; }
    header {
      background: #000; padding: 15px 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      display: flex; align-items: center; justify-content: space-between; border-radius: 10px;
    }
    header nav a {
      position: relative;
      overflow: hidden;
    }

    /* Hiệu ứng underline animation */
    header nav a::before {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      width: 0;
      height: 3px;
      background: linear-gradient(90deg, transparent, #c77dff, #e0aaff, #c77dff, transparent);
      transform: translateX(-50%);
      transition: width 0.4s ease;
      box-shadow: 0 0 10px #c77dff;
    }

    header nav a:hover::before {
      width: 100%;
    }

    /* Hiệu ứng glow khi hover */
    header nav a:hover {
      color: #e0aaff !important;
      text-shadow: 0 0 15px rgba(224, 170, 255, 0.8), 0 0 25px rgba(199, 125, 255, 0.6);
      transform: translateY(-2px) scale(1.05);
    }

    /* Hiệu ứng cho menu active */
    header nav a.active {
      color: #e0aaff;
      font-weight: 600;
      text-shadow: 0 0 10px rgba(224, 170, 255, 0.6);
    }

    header nav a.active::before {
      width: 100%;
    }

    .product-detail {
      display: flex; justify-content: center; align-items: flex-start;
      gap: 40px; margin: 60px auto; max-width: 1000px;
      background: white; padding: 30px; border-radius: 12px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    /* === SLIDER === */
    .slider {
      position: relative; width: 400px; height: 400px; overflow: hidden; border-radius: 12px;
    }
    .slides {
      display: flex; transition: transform 0.5s ease-in-out; width: 100%;
    }
    .slides img {
      width: 400px; height: 400px; object-fit: cover; border-radius: 12px;
    }
    .nav-btn {
      position: absolute; top: 50%; transform: translateY(-50%);
      background: rgba(0,0,0,0.4); color: white; border: none;
      width: 40px; height: 40px; border-radius: 50%;
      font-size: 24px; cursor: pointer;
    }
    #prev { left: 10px; }
    #next { right: 10px; }
    .nav-btn:hover { background: rgba(0,0,0,0.7); }

    /* === INFO === */
    .info-section { max-width: 450px; }
    .info-section h1 { margin: 0 0 10px 0; }
    .price { color: #c59d5f; font-size: 22px; font-weight: bold; margin-bottom: 15px; }
    .desc { color: #555; line-height: 1.6; }
    .add-to-cart, .buy-now {
      display: inline-block; padding: 12px 30px; margin: 10px 5px 0 0;
      border: none; border-radius: 8px; cursor: pointer; font-size: 16px;
      font-weight: 600; transition: all 0.3s ease;
      position: relative; overflow: hidden;
    }
    .add-to-cart { 
      background: linear-gradient(135deg, #c59d5f 0%, #a37f43 100%); 
      color: white; 
      box-shadow: 0 4px 15px rgba(197, 157, 95, 0.3);
    }
    .buy-now { 
      background: linear-gradient(135deg, rgb(71, 31, 97) 0%, rgba(71, 31, 97, 0.8) 100%); 
      color: white;
      box-shadow: 0 4px 15px rgba(71, 31, 97, 0.3);
    }
    .add-to-cart:hover { 
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(197, 157, 95, 0.4);
    }
    .buy-now:hover { 
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(181, 143, 207, 0.4);
    }
    .add-to-cart:active, .buy-now:active {
      transform: translateY(0);
    }
    
    /* Tabs */
    .product-tabs {
      margin-top: 50px;
      border-top: 2px solid #eee;
      padding-top: 30px;
    }
    .tab-buttons {
      display: flex;
      gap: 20px;
      border-bottom: 2px solid #eee;
      margin-bottom: 30px;
    }
    .tab-btn {
      padding: 15px 30px;
      background: none;
      border: none;
      cursor: pointer;
      font-size: 16px;
      font-weight: 600;
      color: #666;
      border-bottom: 3px solid transparent;
      transition: all 0.3s;
    }
    .tab-btn.active {
      color: rgb(71, 31, 97);
      border-bottom-color: rgb(71, 31, 97);
    }
    .tab-btn:hover {
      color: rgb(71, 31, 97);
    }
    .tab-content {
      display: none;
      animation: fadeIn 0.5s;
    }
    .tab-content.active {
      display: block;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-50px) scale(0.9);
      }
      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }
    
    /* Reviews */
    .review-summary {
      display: flex;
      gap: 40px;
      align-items: center;
      margin-bottom: 30px;
      padding: 20px;
      background: #f8f9fa;
      border-radius: 12px;
    }
    .rating-score {
      text-align: center;
    }
    .rating-number {
      font-size: 48px;
      font-weight: bold;
      color: rgb(71, 31, 97);
    }
    .stars {
      color: #ffc107;
      font-size: 24px;
    }
    .review-item {
      border-bottom: 1px solid #eee;
      padding: 20px 0;
    }
    .review-header {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
    }
    .reviewer-name {
      font-weight: 600;
      color: #333;
    }
    .review-date {
      color: #999;
      font-size: 14px;
    }
    .review-stars {
      color: #ffc107;
      margin-bottom: 10px;
    }
    .review-text {
      color: #666;
      line-height: 1.6;
    }
    #quantity {
      font-size: 16px; text-align: center; width: 70px;
      padding:5px; margin-bottom:10px; border-radius:6px; border:1px solid #ccc;
    }
    label[for="quantity"] { display: block; margin-bottom: 5px; color: #444; }
    
    .cart-badge {
      position: absolute;
      top: -8px;
      right: -8px;
      background: #ff0000;
      color: white;
      border-radius: 50%;
      width: 22px;
      height: 22px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 12px;
      font-weight: bold;
      border: 2px solid white;
      box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    .cart-badge.hidden {
      display: none;
    }
    
    @keyframes slideIn {
      from {
        transform: translateX(400px);
        opacity: 0;
      }
      to {
        transform: translateX(0);
        opacity: 1;
      }
    }
    
    @keyframes slideOut {
      from {
        transform: translateX(0);
        opacity: 1;
      }
      to {
        transform: translateX(400px);
        opacity: 0;
      }
    }
  </style>
</head>
<body>
  <header style="justify-content: space-between; cursor: default;">
    <div onclick="window.location.href='index.php'" style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 24px; font-weight: bold; color: #fff;">
      <img src="img/logo.jpg" alt="Logo SAPHYRA" style="height: 50px; width: auto; border-radius: 50%; background-color: #fff; padding: 2px; box-shadow: 0 0 8px rgba(0,0,0,0.15);">
      <span>SAPHYRA</span>
    </div>
    <nav style="display: flex; align-items: center; gap: 50px;">
      <a href="index.php" style="color: #fff; text-decoration: none; padding: 8px 12px;">Trang Chủ</a>
      <a href="sanpham.php" style="color: #fff; text-decoration: none; padding: 8px 12px;">Sản Phẩm</a>
      <a href="gioithieu.php" style="color: #fff; text-decoration: none; padding: 8px 12px;">Giới Thiệu</a>
      <a href="contact.php" style="color: #fff; text-decoration: none; padding: 8px 12px;">Liên Hệ</a>
    </nav>
    <a href="cart.php" style="background: linear-gradient(135deg, #c77dff, #e0aaff); color: white; padding: 8px 16px; border-radius: 25px; text-decoration: none; position: relative; box-shadow: 0 4px 15px rgba(199, 125, 255, 0.4); transition: all 0.3s ease;">
      🛒 Giỏ hàng
      <span id="cartBadge" class="cart-badge">0</span>
    </a>
  </header>
  
  <!-- Toast notification -->
  <div id="toast" style="position: fixed; top: 20px; right: 20px; background: #28a745; color: white; padding: 15px 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); display: none; z-index: 9999;">
    <span id="toastMessage">✓ Đã thêm sản phẩm vào giỏ hàng!</span>
  </div>

  <!-- Modal yêu cầu đăng nhập -->
  <div id="loginRequiredModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 10000; justify-content: center; align-items: center;">
    <div style="background: white; padding: 40px; border-radius: 15px; max-width: 450px; width: 90%; text-align: center; box-shadow: 0 10px 40px rgba(0,0,0,0.3); animation: slideDown 0.3s;">
      <div style="font-size: 60px; margin-bottom: 20px;">🔐</div>
      <h2 style="color: rgb(71, 31, 97); margin-bottom: 15px;">Vui lòng đăng nhập</h2>
      <p style="color: #666; margin-bottom: 25px; line-height: 1.6;">
        Bạn cần có tài khoản để thêm sản phẩm vào giỏ hàng và mua sắm.
      </p>
      <div style="display: flex; gap: 10px; justify-content: center;">
        <button onclick="closeLoginModal()" style="flex: 1; padding: 12px; background: #6c757d; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 16px;">Đóng</button>
        <button onclick="window.location.href='login.php'" style="flex: 1; padding: 12px; background: rgb(71, 31, 97); color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; font-weight: 600;">Đăng nhập</button>
        <button onclick="window.location.href='register.php'" style="flex: 1; padding: 12px; background: #28a745; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; font-weight: 600;">Đăng ký</button>
      </div>
    </div>
  </div>

  <div class="product-detail">
    <div class="slider">
      <div class="slides" id="slides">
        <?php foreach ($product['imgs'] as $img): ?>
          <img src="<?php echo $img; ?>" alt="Ảnh sản phẩm">
        <?php endforeach; ?>
      </div>
      <button class="nav-btn" id="prev">❮</button>
      <button class="nav-btn" id="next">❯</button>
    </div>

    <div class="info-section">
      <h1><?php echo $product['name']; ?></h1>
      <div class="stars" style="margin: 10px 0;">
        ⭐⭐⭐⭐⭐ <span style="color: #666; font-size: 14px;">(128 đánh giá)</span>
      </div>
      <p class="price"><?php echo number_format($product['price']); ?> VND</p>
      <p class="desc"><?php echo $product['desc']; ?></p>

      <form method="POST" action="add_to_cart.php" id="addToCartForm">
        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
        <input type="hidden" name="name" value="<?php echo $product['name']; ?>">
        <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
        <input type="hidden" name="img" value="<?php echo $product['imgs'][0]; ?>">
        <label for="quantity">Số lượng:</label>
        <input type="number" name="quantity" id="quantity" value="1" min="1">
        <br>
        <button class="add-to-cart" type="submit">🛒 Thêm vào giỏ</button>
        <button class="buy-now" type="button" onclick="buyNow()">💳 Mua ngay</button>
      </form>
      
      <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px;">
        <p style="margin: 5px 0; color: #666;"><strong>✓</strong> Miễn phí vận chuyển cho đơn hàng trên 500.000đ</p>
        <p style="margin: 5px 0; color: #666;"><strong>✓</strong> Bảo hành 12 tháng</p>
        <p style="margin: 5px 0; color: #666;"><strong>✓</strong> Đổi trả trong 7 ngày</p>
      </div>
    </div>
  </div>

  <!-- Product Tabs -->
  <div class="product-tabs" style="max-width: 1000px; margin: 50px auto; padding: 0 20px;">
    <div class="tab-buttons">
      <button class="tab-btn active" onclick="showTab('description')">📝 Mô tả chi tiết</button>
      <button class="tab-btn" onclick="showTab('specs')">📋 Thông số</button>
      <button class="tab-btn" onclick="showTab('reviews')">⭐ Đánh giá (128)</button>
    </div>

    <!-- Tab Mô tả -->
    <div id="description" class="tab-content active">
      <h3 style="color: #333; margin-bottom: 20px;">Mô tả sản phẩm</h3>
      <p style="line-height: 1.8; color: #666;">
        <?php echo $product['desc']; ?>
      </p>
      <p style="line-height: 1.8; color: #666; margin-top: 15px;">
        Sản phẩm được chế tác từ chất liệu cao cấp, đảm bảo độ bền và vẻ đẹp lâu dài. 
        Thiết kế tinh xảo, phù hợp với mọi phong cách từ thanh lịch đến hiện đại.
      </p>
      <ul style="margin-top: 20px; line-height: 2; color: #666;">
        <?php if (isset($product['material'])): ?>
        <li>✨ Chất liệu: <?php echo htmlspecialchars($product['material']); ?></li>
        <?php endif; ?>
        
        <?php if (isset($product['stone'])): ?>
        <li>💎 Đá chính: <?php echo htmlspecialchars($product['stone']); ?></li>
        <?php endif; ?>
        
        <?php if (isset($product['category'])): ?>
        <li>🏷️ Loại: <?php echo htmlspecialchars($product['category']); ?></li>
        <?php endif; ?>
        
        <li>📦 Đóng gói: Hộp quà sang trọng kèm túi nhung</li>
        <li>🛡️ Bảo hành: 12 tháng</li>
        <li>🚚 Miễn phí vận chuyển cho đơn hàng trên 500.000đ</li>
      </ul>
    </div>

    <!-- Tab Thông số -->
    <div id="specs" class="tab-content">
      <h3 style="color: #333; margin-bottom: 20px;">Thông số kỹ thuật</h3>
      <table style="width: 100%; border-collapse: collapse;">
        <?php if (isset($product['material'])): ?>
        <tr style="border-bottom: 1px solid #eee;">
          <td style="padding: 15px; font-weight: 600; color: #333; width: 200px;">💎 Chất liệu</td>
          <td style="padding: 15px; color: #666;"><?php echo htmlspecialchars($product['material']); ?></td>
        </tr>
        <?php endif; ?>
        
        <?php if (isset($product['stone'])): ?>
        <tr style="border-bottom: 1px solid #eee;">
          <td style="padding: 15px; font-weight: 600; color: #333;">✨ Đá chính</td>
          <td style="padding: 15px; color: #666;"><?php echo htmlspecialchars($product['stone']); ?></td>
        </tr>
        <?php endif; ?>
        
        <?php if (isset($product['size'])): ?>
        <tr style="border-bottom: 1px solid #eee;">
          <td style="padding: 15px; font-weight: 600; color: #333;">📏 Kích thước</td>
          <td style="padding: 15px; color: #666;"><?php echo htmlspecialchars($product['size']); ?></td>
        </tr>
        <?php endif; ?>
        
        <?php if (isset($product['weight'])): ?>
        <tr style="border-bottom: 1px solid #eee;">
          <td style="padding: 15px; font-weight: 600; color: #333;">⚖️ Trọng lượng</td>
          <td style="padding: 15px; color: #666;"><?php echo htmlspecialchars($product['weight']); ?></td>
        </tr>
        <?php endif; ?>
        
        <?php if (isset($product['category'])): ?>
        <tr style="border-bottom: 1px solid #eee;">
          <td style="padding: 15px; font-weight: 600; color: #333;">🏷️ Danh mục</td>
          <td style="padding: 15px; color: #666;"><?php echo htmlspecialchars($product['category']); ?></td>
        </tr>
        <?php endif; ?>
        
        <tr style="border-bottom: 1px solid #eee;">
          <td style="padding: 15px; font-weight: 600; color: #333;">📦 Số lượng còn</td>
          <td style="padding: 15px; color: #666;"><?php echo $product['quantity']; ?> sản phẩm</td>
        </tr>
        
        <tr style="border-bottom: 1px solid #eee;">
          <td style="padding: 15px; font-weight: 600; color: #333;">🌍 Xuất xứ</td>
          <td style="padding: 15px; color: #666;">Việt Nam</td>
        </tr>
        
        <tr>
          <td style="padding: 15px; font-weight: 600; color: #333;">🛡️ Bảo hành</td>
          <td style="padding: 15px; color: #666;">12 tháng</td>
        </tr>
      </table>
    </div>

    <!-- Tab Đánh giá -->
    <div id="reviews" class="tab-content">
      <h3 style="color: #333; margin-bottom: 20px;">Đánh giá từ khách hàng</h3>
      
      <!-- Form viết đánh giá mới -->
      <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); margin-bottom: 30px;">
        <h4 style="color: rgb(71, 31, 97); margin-bottom: 20px;">✍️ Viết đánh giá của bạn</h4>
        <form id="newReviewForm">
          <!-- Chọn số sao -->
          <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 10px; font-weight: 600; color: #333;">Đánh giá của bạn:</label>
            <div class="stars-input" style="display: flex; gap: 5px; font-size: 40px; cursor: pointer;">
              <span class="star" data-rating="1" style="color: #ddd; transition: all 0.2s;">☆</span>
              <span class="star" data-rating="2" style="color: #ddd; transition: all 0.2s;">☆</span>
              <span class="star" data-rating="3" style="color: #ddd; transition: all 0.2s;">☆</span>
              <span class="star" data-rating="4" style="color: #ddd; transition: all 0.2s;">☆</span>
              <span class="star" data-rating="5" style="color: #ddd; transition: all 0.2s;">☆</span>
            </div>
            <input type="hidden" id="newRatingValue" value="0" required>
          </div>

          <!-- Nhập nhận xét -->
          <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Nhận xét của bạn:</label>
            <textarea id="newReviewText" rows="4" placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm..." required style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 15px; font-family: Arial, sans-serif; resize: vertical;"></textarea>
          </div>

          <!-- Tải hình ảnh -->
          <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Thêm hình ảnh (tùy chọn):</label>
            <input type="file" id="newReviewImages" accept="image/*" multiple style="width: 100%; padding: 10px; border: 2px dashed #e0e0e0; border-radius: 8px; cursor: pointer;">
            <div id="newImagePreview" style="display: flex; gap: 10px; margin-top: 10px; flex-wrap: wrap;"></div>
          </div>

          <button type="submit" style="width: 100%; padding: 14px; background: linear-gradient(135deg, rgb(71, 31, 97) 0%, rgba(71, 31, 97, 0.8) 100%); color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s;">
            Gửi đánh giá
          </button>
        </form>
      </div>
      
      <div class="review-summary">
        <div class="rating-score">
          <div class="rating-number">4.8</div>
          <div class="stars">⭐⭐⭐⭐⭐</div>
          <div style="color: #666; margin-top: 5px;">128 đánh giá</div>
        </div>
        <div style="flex: 1;">
          <div style="display: flex; align-items: center; margin-bottom: 8px;">
            <span style="width: 60px;">5 ⭐</span>
            <div style="flex: 1; height: 8px; background: #eee; border-radius: 4px; margin: 0 10px;">
              <div style="width: 85%; height: 100%; background: #ffc107; border-radius: 4px;"></div>
            </div>
            <span style="color: #666;">108</span>
          </div>
          <div style="display: flex; align-items: center; margin-bottom: 8px;">
            <span style="width: 60px;">4 ⭐</span>
            <div style="flex: 1; height: 8px; background: #eee; border-radius: 4px; margin: 0 10px;">
              <div style="width: 10%; height: 100%; background: #ffc107; border-radius: 4px;"></div>
            </div>
            <span style="color: #666;">15</span>
          </div>
          <div style="display: flex; align-items: center; margin-bottom: 8px;">
            <span style="width: 60px;">3 ⭐</span>
            <div style="flex: 1; height: 8px; background: #eee; border-radius: 4px; margin: 0 10px;">
              <div style="width: 3%; height: 100%; background: #ffc107; border-radius: 4px;"></div>
            </div>
            <span style="color: #666;">4</span>
          </div>
          <div style="display: flex; align-items: center; margin-bottom: 8px;">
            <span style="width: 60px;">2 ⭐</span>
            <div style="flex: 1; height: 8px; background: #eee; border-radius: 4px; margin: 0 10px;">
              <div style="width: 1%; height: 100%; background: #ffc107; border-radius: 4px;"></div>
            </div>
            <span style="color: #666;">1</span>
          </div>
          <div style="display: flex; align-items: center;">
            <span style="width: 60px;">1 ⭐</span>
            <div style="flex: 1; height: 8px; background: #eee; border-radius: 4px; margin: 0 10px;">
              <div style="width: 0%; height: 100%; background: #ffc107; border-radius: 4px;"></div>
            </div>
            <span style="color: #666;">0</span>
          </div>
        </div>
      </div>

      <!-- Review Items - Load từ localStorage -->
      <div id="reviewsList">
        <!-- Đánh giá mẫu -->
        <div class="review-item">
          <div class="review-header">
            <span class="reviewer-name">👤 Nguyễn Thị Mai</span>
            <span class="review-date">15/11/2024</span>
          </div>
          <div class="review-stars">⭐⭐⭐⭐⭐</div>
          <p class="review-text">
            Sản phẩm rất đẹp, chất lượng tốt. Đóng gói cẩn thận, giao hàng nhanh. 
            Mình rất hài lòng với sản phẩm này. Sẽ ủng hộ shop lâu dài!
          </p>
        </div>

        <div class="review-item">
          <div class="review-header">
            <span class="reviewer-name">👤 Trần Văn Hùng</span>
            <span class="review-date">10/11/2024</span>
          </div>
          <div class="review-stars">⭐⭐⭐⭐⭐</div>
          <p class="review-text">
            Mua tặng bạn gái, bạn ấy rất thích. Thiết kế sang trọng, tinh tế. 
            Giá cả hợp lý so với chất lượng. Recommend!
          </p>
        </div>

        <div class="review-item">
          <div class="review-header">
            <span class="reviewer-name">👤 Lê Thị Hương</span>
            <span class="review-date">05/11/2024</span>
          </div>
          <div class="review-stars">⭐⭐⭐⭐</div>
          <p class="review-text">
            Sản phẩm đẹp, đúng như mô tả. Chỉ có điều giao hàng hơi lâu một chút. 
            Nhưng nhìn chung vẫn ok, sẽ mua thêm.
          </p>
        </div>
      </div>
    </div>
  </div>

  <script>
    // ===== XỬ LÝ ĐÁNH GIÁ MỚI =====
    let selectedNewRating = 0;
    const newStars = document.querySelectorAll('.stars-input .star');

    // Xử lý chọn số sao
    newStars.forEach(star => {
      star.addEventListener('click', function() {
        selectedNewRating = parseInt(this.getAttribute('data-rating'));
        document.getElementById('newRatingValue').value = selectedNewRating;
        
        // Cập nhật hiển thị sao
        newStars.forEach((s, index) => {
          if (index < selectedNewRating) {
            s.style.color = '#ffd700';
            s.textContent = '★';
          } else {
            s.style.color = '#ddd';
            s.textContent = '☆';
          }
        });
      });

      // Hover effect
      star.addEventListener('mouseenter', function() {
        const rating = parseInt(this.getAttribute('data-rating'));
        newStars.forEach((s, index) => {
          if (index < rating) {
            s.textContent = '★';
            s.style.color = '#ffd700';
          } else {
            s.textContent = '☆';
            s.style.color = '#ddd';
          }
        });
      });
    });

    // Reset khi rời chuột
    document.querySelector('.stars-input').addEventListener('mouseleave', function() {
      newStars.forEach((s, index) => {
        if (index < selectedNewRating) {
          s.textContent = '★';
          s.style.color = '#ffd700';
        } else {
          s.textContent = '☆';
          s.style.color = '#ddd';
        }
      });
    });

    // Preview hình ảnh
    document.getElementById('newReviewImages').addEventListener('change', function(e) {
      const preview = document.getElementById('newImagePreview');
      preview.innerHTML = '';
      
      const files = Array.from(e.target.files);
      files.forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e) {
          const img = document.createElement('img');
          img.src = e.target.result;
          img.style.cssText = 'width: 100px; height: 100px; object-fit: cover; border-radius: 8px; border: 2px solid #e0e0e0;';
          preview.appendChild(img);
        };
        reader.readAsDataURL(file);
      });
    });

    // Xử lý submit form đánh giá
    document.getElementById('newReviewForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const rating = document.getElementById('newRatingValue').value;
      const reviewText = document.getElementById('newReviewText').value;
      const images = document.getElementById('newReviewImages').files;
      
      if (rating == 0) {
        alert('Vui lòng chọn số sao đánh giá!');
        return;
      }
      
      // Lấy thông tin user
      const currentUser = JSON.parse(localStorage.getItem('currentUser'));
      if (!currentUser) {
        alert('Vui lòng đăng nhập để đánh giá!');
        window.location.href = 'login.php';
        return;
      }
      
      // Xử lý hình ảnh
      const imagePromises = [];
      for (let i = 0; i < images.length; i++) {
        const reader = new FileReader();
        const promise = new Promise((resolve) => {
          reader.onload = function(e) {
            resolve(e.target.result);
          };
          reader.readAsDataURL(images[i]);
        });
        imagePromises.push(promise);
      }
      
      Promise.all(imagePromises).then(imageDataUrls => {
        // Tạo đánh giá mới
        const review = {
          productId: <?php echo $product['id']; ?>,
          userName: currentUser.name,
          userEmail: currentUser.email,
          rating: parseInt(rating),
          text: reviewText,
          images: imageDataUrls,
          date: new Date().toISOString()
        };
        
        // Lưu vào localStorage
        const reviews = JSON.parse(localStorage.getItem('productReviews') || '[]');
        reviews.unshift(review);
        localStorage.setItem('productReviews', JSON.stringify(reviews));
        
        alert('✅ Cảm ơn bạn đã đánh giá!');
        
        // Reset form
        this.reset();
        selectedNewRating = 0;
        newStars.forEach(s => {
          s.style.color = '#ddd';
          s.textContent = '☆';
        });
        document.getElementById('newImagePreview').innerHTML = '';
        
        // Reload trang để hiển thị đánh giá mới
        location.reload();
      });
    });
    
    // ===== SLIDER =====
    const slides = document.getElementById('slides');
    const total = slides.children.length;
    let index = 0;

    document.getElementById('next').onclick = () => {
      index = (index + 1) % total;
      slides.style.transform = `translateX(-${index * 400}px)`;
    };
    document.getElementById('prev').onclick = () => {
      index = (index - 1 + total) % total;
      slides.style.transform = `translateX(-${index * 400}px)`;
    };

    // Auto slide mỗi 3 giây
    setInterval(() => {
      index = (index + 1) % total;
      slides.style.transform = `translateX(-${index * 400}px)`;
    }, 3000);
    
    // Kiểm tra đăng nhập
    function checkLogin() {
      const currentUser = localStorage.getItem('currentUser');
      if (!currentUser) {
        showLoginModal();
        return false;
      }
      return true;
    }
    
    function showLoginModal() {
      document.getElementById('loginRequiredModal').style.display = 'flex';
    }
    
    function closeLoginModal() {
      document.getElementById('loginRequiredModal').style.display = 'none';
    }
    
    // Hàm Mua ngay - Thêm vào giỏ và chuyển đến trang thanh toán
    function buyNow() {
      // Kiểm tra đăng nhập trước
      if (!checkLogin()) {
        return;
      }
      
      const form = document.getElementById('addToCartForm');
      const formData = new FormData(form);
      
      // Gửi request thêm vào giỏ hàng
      fetch('add_to_cart.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.text())
      .then(() => {
        // Chuyển đến trang thanh toán ngay lập tức
        window.location.href = 'checkout.php';
      })
      .catch(error => {
        console.error('Error:', error);
        // Nếu có lỗi vẫn chuyển đến checkout
        window.location.href = 'checkout.php';
      });
    }
    
    // Chặn submit form nếu chưa đăng nhập
    document.getElementById('addToCartForm').addEventListener('submit', function(e) {
      if (!checkLogin()) {
        e.preventDefault();
        return false;
      }
    });
    
    // Hàm chuyển tab
    function showTab(tabName) {
      // Ẩn tất cả tabs
      document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
      });
      document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
      });
      
      // Hiện tab được chọn
      document.getElementById(tabName).classList.add('active');
      event.target.classList.add('active');
    }
    
    // Load đánh giá từ localStorage khi trang load
    document.addEventListener('DOMContentLoaded', function() {
      const reviews = JSON.parse(localStorage.getItem('productReviews') || '[]');
      const productReviews = reviews.filter(r => r.productId == <?php echo $product['id']; ?>);
      
      if (productReviews.length > 0) {
        const reviewsList = document.getElementById('reviewsList');
        
        // Thêm đánh giá mới vào đầu danh sách
        productReviews.forEach(review => {
          const stars = '⭐'.repeat(review.rating);
          const date = new Date(review.date).toLocaleDateString('vi-VN');
          
          let imagesHtml = '';
          if (review.images && review.images.length > 0) {
            imagesHtml = '<div style="display: flex; gap: 10px; margin-top: 10px; flex-wrap: wrap;">';
            review.images.forEach(img => {
              imagesHtml += `<img src="${img}" alt="Review image" style="width: 120px; height: 120px; object-fit: cover; border-radius: 8px; cursor: pointer; transition: transform 0.3s;" onclick="this.style.transform = this.style.transform ? '' : 'scale(2)'">`;
            });
            imagesHtml += '</div>';
          }
          
          const reviewHtml = `
            <div class="review-item" style="background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 15px;">
              <div class="review-header">
                <span class="reviewer-name">👤 ${review.userName}</span>
                <span class="review-date">${date}</span>
              </div>
              <div class="review-stars">${stars}</div>
              <p class="review-text">${review.text}</p>
              ${imagesHtml}
            </div>
          `;
          
          reviewsList.insertAdjacentHTML('afterbegin', reviewHtml);
        });
      }
    });
  </script>
  
  <script src="cart_handler.js"></script>
</body>
</html>
