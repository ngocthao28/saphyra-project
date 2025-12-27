<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAPHARY - Trang Sức Sang Trọng</title>
    
    <!-- Favicon - Logo SAPHARY -->
    <link rel="icon" type="image/jpeg" href="img/logo.jpg">
    <link rel="shortcut icon" type="image/jpeg" href="img/logo.jpg">
    <link rel="apple-touch-icon" href="img/logo.jpg">
    
    <link rel="stylesheet" href="trangchu_style.css">

    
    <link rel="stylesheet" href="../style.css/trangchu.css">
    <link rel="stylesheet" href="style.css/product_detail.css">
    
    <!-- AOS Animation Library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">

    <script src="../js/trangchu.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    
    <style>
        /* Thêm CSS này để link sản phẩm không bị gạch chân và có màu xanh */
        .product-card-link {
            text-decoration: none;
            color: inherit;
        }
/* ===========================
🌸 STYLE.CSS - WEBSITE TRANG SỨC
=========================== */

/* RESET & CƠ BẢN */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
    color: #333;
    line-height: 1.6;
}

/* ===========================
    HEADER & NAVIGATION
    =========================== */
header {
    background-color: #000;
    color: #fff;
    padding: 15px 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    position: sticky;
    top: 0;
    z-index: 1000;
    border-radius: 10px;
    position: relative;
}

.logo {
    display: flex;
    align-items: center;
    gap: 10px;
    font-family: 'Poppins', sans-serif;
    font-size: 24px;
    font-weight: bold;
    color: #fff !important;
    cursor: pointer;
    position: absolute;
    left: 40px;
}

.logo img {
    height: 50px;
    width: auto;
    border-radius: 50%;
    background-color: #fff;
    padding: 2px;
    box-shadow: 0 0 8px rgba(0,0,0,0.15);
    transition: transform 0.3s ease;
}

.logo img:hover {
    transform: scale(1.1);
}

nav {
    display: flex;
    align-items: center;
    gap: 50px;
}

nav a {
    color: #fff;
    text-decoration: none;
    padding: 8px 12px;
    transition: color 0.3s, border-bottom 0.3s;
    white-space: nowrap;
}

nav a {
    position: relative;
    overflow: hidden;
}

/* Hiệu ứng underline animation */
nav a::before {
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

nav a:hover::before {
    width: 100%;
}

/* Hiệu ứng glow khi hover */
nav a:hover {
    color: #e0aaff;
    text-shadow: 0 0 15px rgba(224, 170, 255, 0.8), 0 0 25px rgba(199, 125, 255, 0.6);
    transform: translateY(-2px) scale(1.05);
}

/* Hiệu ứng cho menu active */
nav a.active {
    color: #e0aaff;
    font-weight: 600;
    text-shadow: 0 0 10px rgba(224, 170, 255, 0.6);
}

nav a.active::before {
    width: 100%;
}

.actions button {
    background: none;
    border: none;
    color: #fff;
    cursor: pointer;
    margin-left: 10px;
    font-size: 16px;
    transition: color 0.3s;
}

.actions button:hover {
    color: rgb(71, 31, 97);
}

/* ===========================
    CONTAINER & PAGE
    =========================== */
.container {
    padding: 20px;
    max-width: 1200px;
    margin: auto;
}

.page {
    display: none;
    animation: fadeIn 0.8s;
}

.active-page {
    display: block;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* ===========================
    HERO SECTION
    =========================== */
.hero-section {
    position: relative;
    color: #fff;
    text-align: center;
    padding: 100px 20px;
    min-height: 450px;
    border-radius: 20px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin-bottom: 40px;
    background: url("img/nền 2.jpg") center/cover no-repeat;
}

.hero-section h1 {
    font-size: 56px;
    margin-bottom: 20px;
    font-weight: 800;
    color: #ffffff;
    text-shadow: 
        2px 2px 8px rgba(0,0,0,0.8),
        0 0 20px rgba(255, 255, 255, 0.6),
        0 0 40px rgba(255, 255, 255, 0.4);
    animation: titleEntrance 1.5s ease, titleGlow 3s ease-in-out infinite;
    position: relative;
    letter-spacing: 2px;
}

.hero-section p {
    font-size: 20px;
    letter-spacing: 5px;
    font-weight: 600;
    margin-bottom: 25px;
    text-shadow: 
        1px 1px 4px rgba(0,0,0,0.8),
        0 0 15px rgba(255, 255, 255, 0.5);
    animation: subtitleSlide 1.8s ease, subtitlePulse 2s ease-in-out infinite;
    position: relative;
    display: inline-block;
}

.hero-section p::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 100%;
    height: 2px;
    background: #fff;
    opacity: 0.8;
}

@keyframes titleEntrance {
    0% {
        opacity: 0;
        transform: translateY(-50px) scale(0.8);
        filter: blur(10px);
    }
    100% {
        opacity: 1;
        transform: translateY(0) scale(1);
        filter: blur(0);
    }
}

@keyframes titleGlow {
    0%, 100% {
        text-shadow: 
            2px 2px 8px rgba(0,0,0,0.8),
            0 0 20px rgba(255, 255, 255, 0.6),
            0 0 40px rgba(255, 255, 255, 0.4);
        background-position: 0% 50%;
    }
    50% {
        text-shadow: 
            2px 2px 8px rgba(0,0,0,0.8),
            0 0 30px rgba(255, 255, 255, 0.8),
            0 0 60px rgba(255, 255, 255, 0.6);
        background-position: 100% 50%;
    }
}

@keyframes subtitleSlide {
    0% {
        opacity: 0;
        transform: translateX(-100px);
        letter-spacing: 10px;
    }
    100% {
        opacity: 1;
        transform: translateX(0);
        letter-spacing: 5px;
    }
}

@keyframes subtitlePulse {
    0%, 100% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.05);
        opacity: 0.9;
    }
}



@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ===========================
    TIÊU ĐỀ SẢN PHẨM NỔI BẬT
    =========================== */
.featured-title {
    font-size: 36px;
    font-weight: 700;
    text-align: center;
    margin: 40px 0 30px 0;
    position: relative;
    display: inline-block;
    width: 100%;
    background: linear-gradient(90deg, 
        #667eea 0%, 
        #764ba2 25%, 
        #f093fb 50%, 
        #764ba2 75%, 
        #667eea 100%);
    background-size: 200% auto;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    cursor: pointer;
    transition: all 0.3s ease;
}

.featured-title:hover {
    animation: gradientShine 3s linear infinite;
    transform: scale(1.05);
    letter-spacing: 2px;
}

@keyframes gradientShine {
    0% {
        background-position: 0% center;
    }
    100% {
        background-position: 200% center;
    }
}

.featured-title::before {
    content: '';
    position: absolute;
    left: 50%;
    bottom: -10px;
    transform: translateX(-50%);
    width: 0;
    height: 3px;
    background: linear-gradient(90deg, #667eea, #764ba2, #f093fb);
    transition: width 0.5s ease;
}

.featured-title:hover::before {
    width: 200px;
}

.featured-title::after {
    content: '✨';
    position: absolute;
    right: -40px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 24px;
    opacity: 0;
    transition: all 0.3s ease;
}

.featured-title:hover::after {
    opacity: 1;
    right: -50px;
    animation: sparkle 1s ease infinite;
}

@keyframes sparkle {
    0%, 100% {
        transform: translateY(-50%) scale(1);
        opacity: 1;
    }
    50% {
        transform: translateY(-50%) scale(1.2);
        opacity: 0.7;
    }
}

.btn {
    background: linear-gradient(135deg, rgb(71, 31, 97) 0%, rgba(71, 31, 97, 0.8) 100%);
    color: #fff;
    padding: 15px 40px;
    text-decoration: none;
    border-radius: 50px;
    margin-top: 20px;
    display: inline-block;
    font-weight: 600;
    font-size: 16px;
    letter-spacing: 1px;
    text-transform: uppercase;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(71, 31, 97, 0.4);
    transition: all 0.4s ease;
    border: 2px solid transparent;
}

.btn::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.btn:hover {
    background: linear-gradient(135deg, rgba(71, 31, 97, 0.8) 0%, rgb(71, 31, 97) 100%);
    box-shadow: 0 8px 25px rgba(71, 31, 97, 0.6);
    transform: translateY(-3px);
    border-color: rgba(255, 255, 255, 0.3);
}

.btn:hover::before {
    width: 300px;
    height: 300px;
}

.btn:active {
    transform: translateY(-1px) scale(0.98);
    box-shadow: 0 4px 15px rgba(71, 31, 97, 0.4);
}

/* Hiệu ứng blur khi click */
.btn.clicked {
    animation: blurPulse 0.6s ease;
}

@keyframes blurPulse {
    0% {
        filter: blur(0px);
        transform: translateY(-3px) scale(1);
    }
    50% {
        filter: blur(3px);
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 12px 35px rgba(71, 31, 97, 0.8);
    }
    100% {
        filter: blur(0px);
        transform: translateY(-3px) scale(1);
    }
}

/* Hiệu ứng glow animation */
@keyframes glow {
    0%, 100% {
        box-shadow: 0 4px 15px rgba(71, 31, 97, 0.4);
    }
    50% {
        box-shadow: 0 8px 30px rgba(71, 31, 97, 0.8), 
                    0 0 40px rgba(71, 31, 97, 0.6);
    }
}

.btn:hover {
    animation: glow 2s ease-in-out infinite;
}

/* Hiệu ứng shine */
.btn::after {
    content: '';
    position: absolute;
    top: -50%;
    left: -100%;
    width: 50%;
    height: 200%;
    background: linear-gradient(90deg, 
        transparent, 
        rgba(255, 255, 255, 0.3), 
        transparent);
    transform: skewX(-25deg);
    transition: left 0.7s;
}

.btn:hover::after {
    left: 150%;
}

/* ===========================
    PRODUCT GRID
    =========================== */
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 30px;
}

.product-card {
    background-color: #fff;
    border: 1px solid #ddd;
    padding: 15px;
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s;
    cursor: pointer;
    border-radius: 10px;
}

.product-card img {
    width: 100%;
    height: 280px;            /* đồng bộ chiều cao khung ảnh */
    object-fit: cover;        /* cắt ảnh vừa khung mà không méo */
    object-position: center;    /* căn giữa ảnh */
    border-radius: 12px 12px 0 0;
    transition: transform 0.4s ease;
    background-color: #fff;     /* nền trắng tránh viền đen */
}
.product-card {
    background-color: #fff;
    border: 1px solid #eee;
    border-radius: 16px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    transition: all 0.3s ease;
}

.product-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.product-card:hover img {
    transform: scale(1.05);
}

.product-card h3 {
    font-size: 18px;
    margin: 5px 0;
}

.product-card p {
    color: #5c0681ff;
    font-weight: bold;
}

/* ===========================
    CART & FORM
    =========================== */
.form-container, .cart-content {
    background-color: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    margin: 50px auto;
}

.form-container input,
.form-container button {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.form-container button {
    background-color: #000;
    color: rgb(71, 31, 97);
    cursor: pointer;
    font-weight: bold;
    transition: background-color 0.3s;
}

.form-container button:hover {
    background-color: #333;
}

.cart-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #eee;
    padding: 10px 0;
}

.cart-item:last-child {
    border-bottom: none;
}

/* ===========================
    RESPONSIVE
    =========================== */
@media (max-width: 600px) {
    .form-container, .cart-content {
        width: 90%;
        margin: 30px auto;
    }

    .hero-section h1 {
        font-size: 32px;
    }
}

/* ===========================
    ĐĂNG NHẬP & ĐĂNG KÝ
    =========================== */
.auth-container {
    background: #fff;
    max-width: 400px;
    margin: 60px auto;
    padding: 40px 30px;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    text-align: center;
    animation: fadeInUp 0.6s ease;
}

.auth-container h2 {
    color: #6f488b;
    margin-bottom: 25px;
    font-size: 24px;
    letter-spacing: 1px;
}

.auth-form input {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 15px;
    transition: border-color 0.3s ease;
}

.auth-form input:focus {
    border-color: rgb(71, 31, 97);
    outline: none;
}

.btn-auth {
    width: 100%;
    background-color: rgb(71, 31, 97);
    color: white;
    padding: 12px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-auth:hover {
    background-color: rgba(71, 31, 97, 0.8);
}

.auth-container p {
    margin-top: 15px;
    font-size: 14px;
}

.auth-container a {
    color: rgb(71, 31, 97);
    text-decoration: none;
    font-weight: bold;
}

.auth-container a:hover {
    text-decoration: underline;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}


/* ===========================
   MENU HAMBURGER TÀI KHOẢN
   =========================== */
.account-menu {
    position: absolute;
    right: 40px;
    top: 50%;
    transform: translateY(-50%);
}

/* Thanh tìm kiếm đã xóa - Chỉ có ở trang sản phẩm */

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
    background-color: rgb(71, 31, 97);
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
    border-bottom-color: transparent;
}

/* ===========================
   FEATURED PRODUCTS SECTION
   =========================== */
.featured-section {
    text-align: center;
    margin: 60px 0 40px;
}

.section-title {
    font-size: 42px;
    color: rgb(71, 31, 97);
    margin-bottom: 10px;
    font-weight: 700;
}

.section-subtitle {
    font-size: 18px;
    color: #666;
    margin-bottom: 30px;
}

/* Product Grid Enhancements */
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
    margin-bottom: 60px;
}

.product-card {
    position: relative;
    overflow: hidden;
}

.product-card::before {
    content: 'NEW';
    position: absolute;
    top: 15px;
    right: 15px;
    background: linear-gradient(135deg, #ff6b6b, #ff5252);
    color: white;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
    z-index: 10;
    box-shadow: 0 2px 8px rgba(255, 107, 107, 0.4);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

/* ===========================
   NEWSLETTER SECTION
   =========================== */
.newsletter-section {
    background: linear-gradient(135deg, rgb(71, 31, 97), rgba(71, 31, 97, 0.9));
    padding: 60px 40px;
    border-radius: 20px;
    margin: 60px 0;
    box-shadow: 0 10px 40px rgba(71, 31, 97, 0.3);
    position: relative;
    overflow: hidden;
}

.newsletter-section::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: rotate 20s linear infinite;
}

@keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.newsletter-content {
    position: relative;
    z-index: 1;
    text-align: center;
    max-width: 600px;
    margin: 0 auto;
}

.newsletter-content h2 {
    font-size: 36px;
    color: #fff;
    margin-bottom: 10px;
}

.newsletter-content p {
    font-size: 16px;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 30px;
}

.newsletter-form {
    display: flex;
    gap: 10px;
    max-width: 500px;
    margin: 0 auto 15px;
}

.newsletter-form input {
    flex: 1;
    padding: 15px 20px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 30px;
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
    font-size: 15px;
    outline: none;
    transition: all 0.3s ease;
}

.newsletter-form input::placeholder {
    color: rgba(255, 255, 255, 0.6);
}

.newsletter-form input:focus {
    border-color: rgba(255, 255, 255, 0.6);
    background: rgba(255, 255, 255, 0.15);
    box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
}

.newsletter-form button {
    padding: 15px 35px;
    background: #fff;
    color: rgb(71, 31, 97);
    border: none;
    border-radius: 30px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
}

.newsletter-form button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 255, 255, 0.4);
}

.newsletter-note {
    font-size: 13px;
    color: rgba(255, 255, 255, 0.7);
    margin-top: 10px;
}

/* Responsive */
@media (max-width: 768px) {
    .newsletter-form {
        flex-direction: column;
    }
    
    .section-title {
        font-size: 32px;
    }
}

    </style>
</head>
<body>
    <header>
        <div class="logo" onclick="window.location.href='index.php'">
            <img src="img/logo.jpg" alt="Logo SAPHYRA">
            <span style="color: #fff !important;">SAPHYRA</span>
        </div>

        <nav id="main-nav">
            <a href="index.php" class="active">Trang Chủ</a>
            <a href="sanpham.php">Sản Phẩm</a>
            <a href="gioithieu.php">Giới Thiệu</a>
            <a href="contact.php">Liên Hệ</a>
        </nav>
        

        
        <!-- Menu Hamburger cho Tài khoản -->
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
    </header>
    
    <main class="container">
        <section id="home" class="page active-page">
            <div class="hero-section">
                <h1>Blackcurrant Modern Set</h1>
                <p>NEW BRAND COLLECTION</p>
                <a href="sanpham.php" class="btn"> Khám phá ngay</a>
            </div>

            <!-- Featured Products Section -->
            <div class="featured-section" data-aos="fade-up">
                <h2 class="section-title"> Sản Phẩm Nổi Bật</h2>
                <p class="section-subtitle">Khám phá những món trang sức tinh tế được yêu thích nhất</p>
            </div>
            
            <div class="product-grid" data-aos="fade-up" data-aos-delay="200">
                
                <a href="chitiet.php?id=1" class="product-card-link">
                    <div class="product-card" data-id="4">
                        <img src="img/bong tai1.jpg" alt="Bông Tai">
                        <h3>Bông Tai Kim Cương</h3>
                        <p>8,990,000 VND</p>
                        <small>Xem chi tiết</small>
                    </div>
                </a>

                <a href="chitiet.php?id=2" class="product-card-link">
                    <div class="product-card" data-id="2">
                        <img src="img/vong tay 1.jpg" alt="Vòng Tay">
                        <h3>Vòng Tay Kim Cương</h3>
                        <p>12,500,000 VND</p>
                        <small>Xem chi tiết</small>
                    </div>
                </a>

                <a href="chitiet.php?id=3" class="product-card-link">
                    <div class="product-card" data-id="3">
                        <img src="img/nhan 1.jpg" alt="Nhẫn">
                        <h3>Nhẫn Kim Cương</h3>
                        <p>5,490,000 VND</p>
                        <small>Xem chi tiết</small>
                    </div>
                </a>
                
            </div>
        </section>

        <section id="about" class="page">
            <h2>Về SAPHARY</h2>
            <p>SAPHARY tự hào là thương hiệu trang sức cao cấp...</p>
        </section>

        <section id="contact" class="page">
            <h2>Liên Hệ Với Chúng Tôi</h2>
            <p>Địa chỉ: 283 N. Glenwood Street, Levittown, NY</p>
            <form class="form-container" style="max-width: 600px; margin: 20px 0;">
                </form>
        </section>

        <section id="cart" class="page">
            <h2>🛍️ Giỏ Hàng Của Bạn</h2>
            <div id="empty-cart-msg" style="text-align:center; color:gray;">Giỏ hàng của bạn đang trống.</div>
            <div id="cart-items"></div>
            </section>
            
            <!-- Newsletter Section -->
            <div class="newsletter-section" data-aos="zoom-in">
                <div class="newsletter-content">
                    <h2>💌 Đăng Ký Nhận Tin</h2>
                    <p>Nhận thông tin về bộ sưu tập mới và ưu đãi đặc biệt</p>
                    <form class="newsletter-form" onsubmit="subscribeNewsletter(event)">
                        <input type="email" placeholder="Nhập email của bạn..." required>
                        <button type="submit">Đăng ký</button>
                    </form>
                    <p class="newsletter-note">🔒 Chúng tôi tôn trọng quyền riêng tư của bạn</p>
                </div>
            </div>

        </main>
    
    <script>
        // ===============================
        // 🛍️ SAPHARY - Trang Sức Cao Cấp
        // ===============================
        let cart = [];

        // Hàm showPage vẫn được giữ lại để chuyển tab Giới Thiệu, Liên Hệ, Giỏ Hàng
        function showPage(pageId) {
            const pages = document.querySelectorAll('.page');
            pages.forEach(page => page.classList.remove('active-page'));

            const targetPage = document.getElementById(pageId);
            if (targetPage) {
                targetPage.classList.add('active-page');
            }
            
            if (pageId === 'cart') {
                renderCart();
            }
        }

        function formatCurrency(amount) {
            return amount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
        }

        function updateCartCount() {
            // ... (Giữ nguyên code) ...
        }

        // Hàm addToCart vẫn còn đây để dùng ở trang chi tiết sản phẩm (nếu bạn import script này)
        window.addToCart = (id, name, price) => {
            const existing = cart.find(item => item.id === id);
            if (existing) {
                existing.quantity += 1;
            } else {
                cart.push({ id, name, price, quantity: 1 });
            }
            updateCartCount();
            alert(`${name} đã được thêm vào giỏ hàng!`);
        };

        window.removeFromCart = (id) => {
            // ... (Giữ nguyên code) ...
            renderCart();
            updateCartCount();
        };

        function renderCart() {
            // ... (Giữ nguyên code) ...
        }

        window.checkout = () => {
            // ... (Giữ nguyên code) ...
        };

        // ===============================
        // KHỞI TẠO SỰ KIỆN VÀ XỬ LÝ NAV
        // ===============================
        document.addEventListener('DOMContentLoaded', () => {
            showPage('home'); // Mặc định hiển thị trang chủ
            updateCartCount();

            // Gắn sự kiện cho các link About, Contact, Cart
            const navLinks = document.querySelectorAll('nav a');
            navLinks.forEach(link => {
                link.addEventListener('click', e => {
                    const href = link.getAttribute('href');
                    if (href && href.startsWith('#')) {
                        e.preventDefault();
                        showPage(href.substring(1));
                    }
                });
            });

            // *** LOGIC MỚI: KIỂM TRA ĐĂNG NHẬP ĐỂ THAY ĐỔI MENU ***
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
        });

        // ===============================
        // HIỆU ỨNG NÚT READ MORE
        // ===============================
        const readMoreBtn = document.querySelector('.hero-section .btn');
        if (readMoreBtn) {
            readMoreBtn.addEventListener('click', function(e) {
                this.classList.add('clicked');
                setTimeout(() => {
                    this.classList.remove('clicked');
                }, 600);
            });
        }

        // ===============================
        // HÀM ĐĂNG NHẬP / ĐĂNG KÝ
        // ===============================
        
        // HÀM SUBMIT ĐÃ BỊ XÓA (chuyển sang login.php và register.php)

        // HÀM LOGOUT ĐÃ CẬP NHẬT
        function logout() {
            if (confirm('Bạn có chắc muốn đăng xuất?')) {
                // Xóa giỏ hàng của user hiện tại
                if (typeof clearUserCart === 'function') {
                    clearUserCart();
                }
                localStorage.removeItem('currentUser');
                window.location.reload();
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
        // ===============================
// 🔍 TÌM KIẾM SẢN PHẨM
// ===============================
function searchProducts() {
    const input = document.getElementById('searchInput').value.toLowerCase().trim();
    const productLinks = document.querySelectorAll('.product-card-link');
    let foundCount = 0;

    productLinks.forEach(link => {
        const card = link.querySelector('.product-card');
        const title = card.querySelector('h3').textContent.toLowerCase();
        
        // Tìm kiếm theo từng ký tự - chỉ cần có chữ cái đó trong tên
        if (input === '' || title.includes(input)) {
            link.style.display = 'block';
            foundCount++;
        } else {
            link.style.display = 'none';
        }
    });

    // Hiển thị thông báo nếu không tìm thấy
    let noResultMsg = document.getElementById('noResultMessage');
    if (foundCount === 0 && input !== '') {
        if (!noResultMsg) {
            noResultMsg = document.createElement('p');
            noResultMsg.id = 'noResultMessage';
            noResultMsg.style.textAlign = 'center';
            noResultMsg.style.color = '#999';
            noResultMsg.style.fontSize = '18px';
            noResultMsg.style.marginTop = '30px';
            noResultMsg.textContent = '❌ Không tìm thấy sản phẩm nào phù hợp';
            document.querySelector('.product-grid').appendChild(noResultMsg);
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

// ===============================
// 🎨 AOS ANIMATION INIT
// ===============================
AOS.init({
    duration: 1000,
    once: true,
    offset: 100,
    easing: 'ease-out-cubic'
});

// ===============================
// 💌 NEWSLETTER SUBSCRIPTION
// ===============================
function subscribeNewsletter(event) {
    event.preventDefault();
    const email = event.target.querySelector('input[type="email"]').value;
    
    // Hiển thị thông báo thành công
    alert('✅ Cảm ơn bạn đã đăng ký!\n\nEmail: ' + email + '\n\nChúng tôi sẽ gửi thông tin ưu đãi đến bạn sớm nhất!');
    
    // Reset form
    event.target.reset();
    
    // Có thể thêm code gửi email đến server ở đây
    // fetch('/api/newsletter', { method: 'POST', body: JSON.stringify({email}) })
}

    </script>
</body>
</html>