<?php
session_start();
require_once 'products_data.php';

$products = getProducts();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Sản phẩm | SAPHARY</title>
  
  <!-- Favicon - Logo SAPHARY -->
  <link rel="icon" type="image/jpeg" href="img/logo.jpg">
  <link rel="shortcut icon" type="image/jpeg" href="img/logo.jpg">
  <link rel="apple-touch-icon" href="img/logo.jpg">
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    body {
      font-family: 'Segoe UI';
      background-image: url('img/nền 7.jpg');
      background-position: center center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
    background-color: #ffffffff;
    
    }
header .logo h2 {
  color: #ffffff;
}


    /* ==== HEADER ==== */
    header {
      background-color: #000;
      color: #fff;
      padding: 15px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }
    
    header .logo {
      display: flex;
      align-items: center;
      gap: 10px;
      font-family: 'Poppins', sans-serif;
      font-size: 24px;
      font-weight: bold;
      color: #fff;
      cursor: pointer;
    }
    
    header .logo img {
      height: 50px;
      width: auto;
      border-radius: 50%;
      background-color: #fff;
      padding: 2px;
      box-shadow: 0 0 8px rgba(0,0,0,0.15);
      transition: transform 0.3s ease;
    }
    
    header .logo img:hover {
      transform: scale(1.1);
    }
    
    header nav {
      display: flex;
      align-items: center;
      gap: 40px;
    }
    
    header nav a {
      color: #fff;
      text-decoration: none;
      padding: 8px 12px;
      transition: all 0.3s;
      white-space: nowrap;
      position: relative;
    }

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

    header nav a:hover {
      color: #e0aaff;
      text-shadow: 0 0 15px rgba(224, 170, 255, 0.8);
      transform: translateY(-2px) scale(1.05);
    }

    header nav a.active {
      color: #e0aaff;
      font-weight: 600;
      text-shadow: 0 0 10px rgba(224, 170, 255, 0.6);
    }

    header nav a.active::before {
      width: 100%;
    }
    
    /* Header Actions */
    .header-actions {
      display: flex;
      align-items: center;
      gap: 20px;
    }
    
    /* Thanh tìm kiếm */
    .header-search {
      position: relative;
    }
    
    .header-search input {
      padding: 10px 40px 10px 16px;
      border-radius: 25px;
      border: 2px solid rgba(255, 255, 255, 0.3);
      outline: none;
      font-size: 14px;
      width: 250px;
      background-color: rgba(255, 255, 255, 0.1);
      color: #fff;
      transition: all 0.3s ease;
    }
    
    .header-search input::placeholder {
      color: rgba(255, 255, 255, 0.6);
    }
    
    .header-search input:focus {
      border-color: #c77dff;
      box-shadow: 0 0 15px rgba(199, 125, 255, 0.5);
      width: 300px;
      background-color: rgba(255, 255, 255, 0.15);
    }
    
    .header-search i {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: rgba(255, 255, 255, 0.6);
      pointer-events: none;
    }
    
    /* Nút giỏ hàng */
    .cart-btn {
      position: relative;
      background: linear-gradient(135deg, #c77dff, #e0aaff);
      border: none;
      color: #fff;
      font-size: 20px;
      cursor: pointer;
      padding: 12px 18px;
      border-radius: 50%;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(199, 125, 255, 0.4);
      width: 50px;
      height: 50px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .cart-btn:hover {
      background: linear-gradient(135deg, #e0aaff, #c77dff);
      transform: scale(1.1);
      box-shadow: 0 6px 20px rgba(199, 125, 255, 0.6);
    }
    
    .cart-badge {
      position: absolute;
      top: 0;
      right: 0;
      background: linear-gradient(135deg, #ff6b6b, #ee5a6f);
      color: white;
      border-radius: 50%;
      width: 20px;
      height: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 11px;
      font-weight: bold;
      box-shadow: 0 2px 8px rgba(255, 107, 107, 0.5);
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

    /* ==== MAIN CONTENT ==== */
    main {
      padding: 40px 20px;
      max-width: 1400px;
      margin: auto;
    }

    /* Hero Section */
    .products-hero {
      text-align: center;
      padding: 80px 20px;
      background: url('img/nen 3.jpg') center/cover no-repeat;
      border-radius: 20px;
      margin-bottom: 40px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
      position: relative;
      overflow: hidden;
    }

    .products-hero::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(135deg, rgba(71, 31, 97, 0.85), rgba(0, 0, 0, 0.6));
      z-index: 0;
    }

    .products-hero h1 {
      font-size: 48px;
      color: #fff;
      margin-bottom: 10px;
      position: relative;
      z-index: 1;
      text-shadow: 0 4px 15px rgba(0,0,0,0.5);
      font-weight: 700;
    }

    .products-hero p {
      font-size: 18px;
      color: rgba(255,255,255,0.95);
      position: relative;
      z-index: 1;
      text-shadow: 0 2px 8px rgba(0,0,0,0.4);
    }

    /* Filter Bar */
    .filter-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 20px;
      margin-bottom: 30px;
      padding: 20px;
      background: white;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.08);
      flex-wrap: wrap;
    }

    .filter-left {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
    }

    .filter-btn {
      padding: 10px 20px;
      border: 2px solid #e0e0e0;
      background: white;
      border-radius: 25px;
      cursor: pointer;
      transition: all 0.3s ease;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .filter-btn:hover {
      border-color: rgb(71, 31, 97);
      color: rgb(71, 31, 97);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(71, 31, 97, 0.2);
    }

    .filter-btn.active {
      background: linear-gradient(135deg, rgb(71, 31, 97), rgba(71, 31, 97, 0.8));
      color: white;
      border-color: rgb(71, 31, 97);
      box-shadow: 0 4px 15px rgba(71, 31, 97, 0.3);
    }

    .filter-right {
      display: flex;
      gap: 15px;
      align-items: center;
    }

    .sort-select {
      padding: 10px 20px;
      border: 2px solid #e0e0e0;
      border-radius: 25px;
      background: white;
      cursor: pointer;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .sort-select:focus {
      outline: none;
      border-color: rgb(71, 31, 97);
      box-shadow: 0 0 10px rgba(71, 31, 97, 0.2);
    }

    .view-toggle {
      display: flex;
      gap: 5px;
      background: #f5f5f5;
      padding: 5px;
      border-radius: 25px;
    }

    .view-btn {
      padding: 8px 15px;
      border: none;
      background: transparent;
      border-radius: 20px;
      cursor: pointer;
      transition: all 0.3s ease;
      font-size: 18px;
    }

    .view-btn:hover {
      background: white;
    }

    .view-btn.active {
      background: rgb(71, 31, 97);
      color: white;
      box-shadow: 0 2px 8px rgba(71, 31, 97, 0.3);
    }

    /* Products Count */
    .products-count {
      text-align: center;
      margin-bottom: 20px;
      font-size: 16px;
      color: #666;
    }

    .products-count span {
      font-weight: bold;
      color: rgb(71, 31, 97);
      font-size: 20px;
    }

    /* ==== PRODUCT GRID ==== */
    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 30px;
      margin-bottom: 40px;
    }

    .grid.list-view {
      grid-template-columns: 1fr;
    }

    .grid.list-view .card {
      display: flex;
      flex-direction: row;
      width: 100%;
      max-width: 100%;
    }

    .grid.list-view .card-img-wrapper {
      width: 250px;
      height: 200px;
      border-radius: 12px 0 0 12px;
    }

    .grid.list-view .card-content {
      flex: 1;
      padding: 20px;
      text-align: left;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .card {
      background: white;
      border-radius: 16px;
      text-align: center;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      overflow: hidden;
      position: relative;
    }

    .card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(135deg, rgba(71, 31, 97, 0.05), transparent);
      opacity: 0;
      transition: opacity 0.4s ease;
      z-index: 0;
    }

    .card:hover::before {
      opacity: 1;
    }

    .card:hover {
      transform: translateY(-10px) scale(1.02);
      box-shadow: 0 20px 40px rgba(71, 31, 97, 0.2);
    }

    .card-content {
      padding: 15px;
      position: relative;
      z-index: 1;
    }

    .card-badge {
      position: absolute;
      top: 15px;
      right: 15px;
      background: linear-gradient(135deg, #ff6b6b, #ff5252);
      color: white;
      padding: 5px 12px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: bold;
      z-index: 10;
      box-shadow: 0 2px 8px rgba(255, 107, 107, 0.4);
    }
    
    .card-img-wrapper {
      position: relative;
      width: 100%;
      height: 230px;
      overflow: hidden;
      border-radius: 12px 12px 0 0;
    }
    
    .card-img-wrapper img {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: all 0.5s ease;
    }
    
    .card-img-wrapper .img-main {
      opacity: 1;
      transform: scale(1);
      z-index: 1;
    }
    
    .card-img-wrapper .img-hover {
      opacity: 0;
      transform: scale(1.1);
      z-index: 2;
    }
    
    .card:hover .card-img-wrapper .img-main {
      opacity: 0;
      transform: scale(0.95);
    }
    
    .card:hover .card-img-wrapper .img-hover {
      opacity: 1;
      transform: scale(1.15);
    }
    .card h3 { 
      margin: 15px 0 10px 0;
      font-size: 18px;
      color: #333;
      font-weight: 600;
    }
    
    .card p { 
      color: rgb(71, 31, 97);
      font-weight: bold;
      font-size: 20px;
      margin: 10px 0;
    }

    .card-category {
      display: inline-block;
      padding: 4px 12px;
      background: #f0f0f0;
      border-radius: 15px;
      font-size: 12px;
      color: #666;
      margin-bottom: 10px;
    }
    
    .card a.btn {
      display: inline-block;
      margin: 10px 0 15px;
      padding: 12px 30px;
      background: linear-gradient(135deg, rgb(71, 31, 97), rgba(71, 31, 97, 0.8));
      color: #fff;
      border-radius: 25px;
      text-decoration: none;
      transition: all 0.3s ease;
      font-weight: 600;
      box-shadow: 0 4px 15px rgba(71, 31, 97, 0.3);
    }
    
    .card a.btn:hover { 
      background: linear-gradient(135deg, rgba(71, 31, 97, 0.8), rgb(71, 31, 97));
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(71, 31, 97, 0.4);
    }

    /* No Results */
    .no-results {
      text-align: center;
      padding: 60px 20px;
      color: #999;
    }

    .no-results h3 {
      font-size: 24px;
      margin-bottom: 10px;
    }

    /* Loading Animation */
    .loading {
      text-align: center;
      padding: 40px;
    }

    .loading::after {
      content: '⏳';
      font-size: 48px;
      animation: spin 2s linear infinite;
    }

    @keyframes spin {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }

    /* ==== FOOTER ==== */
    footer {
      background: rgb(71, 31, 97);
      color: #fff;
      text-align: center;
      padding: 20px 10px;
      margin-top: 50px;
    }
    footer a {
      color: #fff;
      text-decoration: none;
      margin: 0 10px;
    }
    footer a:hover {
      text-decoration: underline;
    }


    /* Menu hamburger */
    .account-menu {
      position: relative;
    }
    
    .hamburger-btn {
      background: none;
      border: none;
      cursor: pointer;
      padding: 10px;
      display: flex;
      flex-direction: column;
      gap: 4px;
      transition: all 0.3s ease;
    }
    
    .hamburger-btn span {
      display: block;
      width: 25px;
      height: 3px;
      background-color: #fff;
      border-radius: 3px;
      transition: all 0.3s ease;
    }
    
    .hamburger-btn:hover span {
      background-color: #c77dff;
    }
    
    .account-dropdown {
      display: none;
      position: absolute;
      right: 0;
      top: 100%;
      background: white;
      min-width: 180px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.2);
      border-radius: 8px;
      overflow: hidden;
      margin-top: 10px;
      z-index: 1000;
      animation: slideDown 0.3s ease;
    }
    
    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    .account-dropdown.show {
      display: block;
    }
    
    .account-dropdown a {
      display: block;
      padding: 12px 20px;
      color: #333;
      text-decoration: none;
      transition: background 0.3s ease;
      border-bottom: 1px solid #f0f0f0;
    }
    
    .account-dropdown a:last-child {
      border-bottom: none;
    }
    
    .account-dropdown a:hover {
      background: #f8f4fc;
      color: #6f488b;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
      header {
        padding: 15px 20px;
      }
      
      header nav {
        gap: 20px;
      }
      
      .header-search input {
        width: 150px;
      }
      
      .header-search input:focus {
        width: 200px;
      }
    }

  </style>
</head>
<body>

  <!-- HEADER -->
  <header>
    <div class="logo" onclick="window.location.href='index.php'">
      <img src="img/logo.jpg" alt="Logo SAPHYRA">
      <span>SAPHYRA</span>
    </div>
    
    <nav>
      <a href="index.php">Trang chủ</a>
      <a href="sanpham.php" class="active">Sản phẩm</a>
      <a href="gioithieu.php">Giới thiệu</a>
      <a href="contact.php">Liên hệ</a>
    </nav>
    
    <!-- Header Actions -->
    <div class="header-actions">
      <!-- Thanh tìm kiếm -->
      <div class="header-search">
        <input type="text" id="searchInput" placeholder="Tìm kiếm..." onkeyup="searchProducts()">
        <i class="fas fa-search"></i>
      </div>
      
      <!-- Nút giỏ hàng -->
      <button class="cart-btn" onclick="window.location.href='cart.php'" title="Giỏ hàng">
        🛒
        <span class="cart-badge" id="cartBadge">0</span>
      </button>
      
      <!-- Menu tài khoản -->
      <div class="account-menu">
        <button class="hamburger-btn" onclick="toggleAccountMenu()">
          <span></span>
          <span></span>
          <span></span>
        </button>
        <div class="account-dropdown" id="accountDropdown">
          <a href="login.php">🔐 Đăng Nhập</a>
          <a href="register.php">📝 Đăng Ký</a>
        </div>
      </div>
    </div>
  </header>

  <!-- Toast notification -->
  <div id="toast" style="position: fixed; top: 20px; right: 20px; background: #28a745; color: white; padding: 15px 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); display: none; z-index: 9999; animation: slideIn 0.3s ease;">
    <span id="toastMessage">✓ Đã thêm sản phẩm vào giỏ hàng!</span>
  </div>

  <!-- MAIN CONTENT -->
  <main>
    <!-- Hero Section -->
    <div class="products-hero">
      <h1> Bộ Sưu Tập Trang Sức</h1>
      <p>Khám phá vẻ đẹp tinh tế và sang trọng</p>
    </div>

    <!-- Filter & Sort Bar -->
    <div class="filter-bar">
      <div class="filter-left">
        <button class="filter-btn active" onclick="filterCategory('all')">
          <span>🔷</span> Tất cả
        </button>
        <button class="filter-btn" onclick="filterCategory('Nhẫn')">
          <span>💍</span> Nhẫn
        </button>
        <button class="filter-btn" onclick="filterCategory('Dây chuyền')">
          <span>📿</span> Dây chuyền
        </button>
        <button class="filter-btn" onclick="filterCategory('Bông tai')">
          <span>💎</span> Bông tai
        </button>
        <button class="filter-btn" onclick="filterCategory('Vòng tay')">
          <span>⭕</span> Vòng tay
        </button>
      </div>
      
      <div class="filter-right">
        <select id="sortSelect" onchange="sortProducts()" class="sort-select">
          <option value="default">Sắp xếp</option>
          <option value="price-asc">Giá: Thấp → Cao</option>
          <option value="price-desc">Giá: Cao → Thấp</option>
          <option value="name-asc">Tên: A → Z</option>
          <option value="name-desc">Tên: Z → A</option>
        </select>
        
        <div class="view-toggle">
          <button class="view-btn active" onclick="setView('grid')" title="Lưới">
            <span>⊞</span>
          </button>
          <button class="view-btn" onclick="setView('list')" title="Danh sách">
            <span>☰</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Products Count -->
    <div class="products-count">
      <span id="productCount"><?php echo count($products); ?></span> sản phẩm
    </div>
    
    <div class="grid">
      <?php foreach($products as $p): 
        // Tự động phát hiện category từ tên sản phẩm
        $category = 'Khác';
        $name_lower = mb_strtolower($p['name'], 'UTF-8');
        if (strpos($name_lower, 'nhẫn') !== false || strpos($name_lower, 'nhan') !== false) {
            $category = 'Nhẫn';
        } elseif (strpos($name_lower, 'dây chuyền') !== false || strpos($name_lower, 'day chuyen') !== false) {
            $category = 'Dây chuyền';
        } elseif (strpos($name_lower, 'bông tai') !== false || strpos($name_lower, 'bong tai') !== false) {
            $category = 'Bông tai';
        } elseif (strpos($name_lower, 'vòng tay') !== false || strpos($name_lower, 'vong tay') !== false) {
            $category = 'Vòng tay';
        }
        
        // Nếu có category trong data thì dùng
        if (isset($p['category']) && !empty($p['category'])) {
            $category = $p['category'];
        }
      ?>
        <div class="card" data-category="<?php echo htmlspecialchars($category); ?>" data-price="<?php echo $p['price']; ?>">
          <div class="card-img-wrapper">
            <img src="<?php echo htmlspecialchars($p['imgs'][0]); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>" class="img-main">
            <?php if(isset($p['imgs'][1])): ?>
              <img src="<?php echo htmlspecialchars($p['imgs'][1]); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>" class="img-hover">
            <?php else: ?>
              <img src="<?php echo htmlspecialchars($p['imgs'][0]); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>" class="img-hover">
            <?php endif; ?>
          </div>
          
          <div class="card-content">
            <span class="card-category"><?php echo htmlspecialchars($category); ?></span>
            <h3><?php echo htmlspecialchars($p['name']); ?></h3>
            <p><?php echo number_format($p['price']); ?> VND</p>
            <a class="btn" href="chitiet.php?id=<?php echo $p['id']; ?>">
               Xem chi tiết
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </main>

  <!-- FOOTER -->
  <footer>
    <p>© 2025 SAPHARY </p>
    <p>
      <a href="https://www.facebook.com/">Facebook</a> |
      <a href="https://www.instagram.com/">Instagram</a> |
      <a href="https://www.tiktok.com/en/">TikTok</a>
    </p>
  </footer>
<script>
// ===============================
// 🎯 FILTER & SORT FUNCTIONS
// ===============================
let currentCategory = 'all';
let currentSort = 'default';

function filterCategory(category) {
    currentCategory = category;
    
    // Update active button
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.closest('.filter-btn').classList.add('active');
    
    applyFilters();
}

function sortProducts() {
    currentSort = document.getElementById('sortSelect').value;
    applyFilters();
}

function setView(viewType) {
    const grid = document.querySelector('.grid');
    const buttons = document.querySelectorAll('.view-btn');
    
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.closest('.view-btn').classList.add('active');
    
    if (viewType === 'list') {
        grid.classList.add('list-view');
    } else {
        grid.classList.remove('list-view');
    }
}

function applyFilters() {
    const cards = Array.from(document.querySelectorAll('.card'));
    let visibleCards = [];
    
    // Filter by category
    cards.forEach(card => {
        const category = card.getAttribute('data-category');
        if (currentCategory === 'all' || category === currentCategory) {
            card.style.display = '';
            visibleCards.push(card);
        } else {
            card.style.display = 'none';
        }
    });
    
    // Sort visible cards
    if (currentSort !== 'default') {
        visibleCards.sort((a, b) => {
            const priceA = parseInt(a.getAttribute('data-price'));
            const priceB = parseInt(b.getAttribute('data-price'));
            const nameA = a.querySelector('h3').textContent;
            const nameB = b.querySelector('h3').textContent;
            
            switch(currentSort) {
                case 'price-asc':
                    return priceA - priceB;
                case 'price-desc':
                    return priceB - priceA;
                case 'name-asc':
                    return nameA.localeCompare(nameB);
                case 'name-desc':
                    return nameB.localeCompare(nameA);
                default:
                    return 0;
            }
        });
        
        // Reorder DOM
        const grid = document.querySelector('.grid');
        visibleCards.forEach(card => grid.appendChild(card));
    }
    
    // Update count
    updateProductCount(visibleCards.length);
}

function updateProductCount(count) {
    document.getElementById('productCount').textContent = count;
}

// ===============================
// 🔍 TÌM KIẾM SẢN PHẨM
// ===============================
function searchProducts() {
    const input = document.getElementById('searchInput').value.toLowerCase().trim();
    const cards = document.querySelectorAll('.card');
    let foundCount = 0;

    cards.forEach(card => {
        const title = card.querySelector('h3').textContent.toLowerCase();
        const category = card.getAttribute('data-category').toLowerCase();
        
        if (input === '' || title.includes(input) || category.includes(input)) {
            if (currentCategory === 'all' || card.getAttribute('data-category') === currentCategory) {
                card.style.display = '';
                foundCount++;
            }
        } else {
            card.style.display = 'none';
        }
    });

    updateProductCount(foundCount);
    
    let noResultMsg = document.getElementById('noResultMessage');
    if (foundCount === 0 && input !== '') {
        if (!noResultMsg) {
            noResultMsg = document.createElement('div');
            noResultMsg.id = 'noResultMessage';
            noResultMsg.className = 'no-results';
            noResultMsg.innerHTML = `
                <h3>😔 Không tìm thấy sản phẩm</h3>
                <p>Không có sản phẩm nào phù hợp với "${input}"</p>
            `;
            document.querySelector('.grid').appendChild(noResultMsg);
        } else {
            noResultMsg.querySelector('p').textContent = `Không có sản phẩm nào phù hợp với "${input}"`;
        }
    } else if (noResultMsg) {
        noResultMsg.remove();
    }
}

// ===============================
// 🍔 MENU HAMBURGER TÀI KHOẢN
// ===============================
function toggleAccountMenu() {
    const dropdown = document.getElementById('accountDropdown');
    dropdown.classList.toggle('show');
}

// Đóng menu khi click bên ngoài
window.addEventListener('click', function(event) {
    if (!event.target.closest('.account-menu')) {
        const dropdown = document.getElementById('accountDropdown');
        if (dropdown.classList.contains('show')) {
            dropdown.classList.remove('show');
        }
    }
});

// Cập nhật số lượng giỏ hàng từ session
function updateCartBadge() {
    fetch('get_cart_count.php')
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('cartBadge');
            if (badge && data.success) {
                badge.textContent = data.totalItems;
                if (data.totalItems > 0) {
                    badge.style.display = 'flex';
                } else {
                    badge.style.display = 'none';
                }
            }
        })
        .catch(error => {
            console.error('Lỗi khi cập nhật badge:', error);
        });
}

// Kiểm tra đăng nhập và thay đổi menu
document.addEventListener('DOMContentLoaded', function() {
    const user = JSON.parse(localStorage.getItem('currentUser'));
    const adminSession = JSON.parse(localStorage.getItem('adminSession'));
    const accountDropdown = document.getElementById('accountDropdown');

    if (accountDropdown) {
        // Nếu là admin
        if (adminSession && adminSession.email === 'admin@saphyra.com') {
            accountDropdown.innerHTML = `
                <a href="admin_dashboard.php">👑 Quản lý Admin</a>
                <a href="#" onclick="logoutAdmin(); return false;">🚪 Đăng xuất</a>
            `;
        }
        // Nếu là user thông thường
        else if (user) {
            accountDropdown.innerHTML = `
                <a href="profile.php">👤 Trang cá nhân</a>
                <a href="#" onclick="logout(); return false;">🚪 Đăng xuất</a>
            `;
        }
    }
    
    // Cập nhật badge giỏ hàng
    updateCartBadge();
});

function logout() {
    if (confirm('Bạn có chắc muốn đăng xuất?')) {
        // Xóa giỏ hàng của user hiện tại
        if (typeof clearUserCart === 'function') {
            clearUserCart();
        }
        localStorage.removeItem('currentUser');
        window.location.href = 'index.php';
    }
}

function logoutAdmin() {
    if (confirm('Bạn có chắc muốn đăng xuất khỏi tài khoản admin?')) {
        // Xóa giỏ hàng của admin hiện tại
        if (typeof clearUserCart === 'function') {
            clearUserCart();
        }
        localStorage.removeItem('adminSession');
        window.location.href = 'index.php';
    }
}
</script>

<script src="cart_handler.js"></script>
</body>
</html>
