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

    <link rel="stylesheet" href="style.css/trangchu_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* Header hiện đại */
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
        
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Poppins', sans-serif;
            font-size: 24px;
            font-weight: bold;
            color: #fff;
            cursor: pointer;
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
            gap: 40px;
        }
        
        nav a {
            color: #fff;
            text-decoration: none;
            padding: 8px 12px;
            transition: all 0.3s;
            white-space: nowrap;
            position: relative;
        }

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

        nav a:hover {
            color: #e0aaff;
            text-shadow: 0 0 15px rgba(224, 170, 255, 0.8);
            transform: translateY(-2px) scale(1.05);
        }

        nav a.active {
            color: #e0aaff;
            font-weight: 600;
            text-shadow: 0 0 10px rgba(224, 170, 255, 0.6);
        }

        nav a.active::before {
            width: 100%;
        }
        
        /* Header Actions - Tìm kiếm + Giỏ hàng + Menu */
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
            padding: 8px 16px;
            border-radius: 20px;
            border: 2px solid rgb(71, 31, 97);
            outline: none;
            font-size: 14px;
            width: 180px;
            background-color: rgba(255, 255, 255, 0.95);
            color: #333;
            transition: all 0.3s ease;
        }
        
        .header-search input::placeholder {
            color: #999;
        }
        
        .header-search input:focus {
            border-color: rgb(71, 31, 97);
            box-shadow: 0 0 10px rgba(71, 31, 97, 0.5);
            width: 220px;
            background-color: #fff;
        }
        
        .header-search i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            pointer-events: none;
            font-size: 14px;
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
            transition: all 0.3s ease;
        }
        
        .cart-badge.hidden {
            display: none;
        }
        
        /* Animation bounce cho badge */
        @keyframes bounce {
            0%, 100% { transform: scale(1); }
            25% { transform: scale(1.3); }
            50% { transform: scale(0.9); }
            75% { transform: scale(1.2); }
        }
        
        /* Menu hamburger - Luôn ở góc phải */
        .account-menu {
            position: absolute;
            right: 40px;
            top: 50%;
            transform: translateY(-50%);
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
            
            nav {
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

<header>
    <div class="logo" onclick="window.location.href='index.php'">
        <img src="img/logo.jpg" alt="Logo SAPHYRA">
        <span>SAPHYRA</span>
    </div>

    <nav id="main-nav">
        <a href="index.php">Trang chủ</a>
        <a href="sanpham.php">Sản phẩm</a>
        <a href="gioithieu.php">Giới thiệu</a>
        <a href="contact.php">Liên hệ</a>
    </nav>
    
    <!-- Header Actions: Tìm kiếm + Giỏ hàng + Menu -->
    <div class="header-actions">
        <?php 
        $current_page = basename($_SERVER['PHP_SELF']);
        // Chỉ hiển thị thanh tìm kiếm và giỏ hàng ở trang chủ và sản phẩm
        if ($current_page != 'contact.php' && $current_page != 'gioithieu.php' && $current_page != 'profile.php'): 
        ?>
        <!-- Thanh tìm kiếm -->
        <div class="header-search">
            <input type="text" id="searchInput" placeholder="Tìm kiếm...">
            <i class="fas fa-search"></i>
        </div>
        
        <!-- Nút giỏ hàng -->
        <button class="cart-btn" onclick="window.location.href='cart.php'" title="Giỏ hàng">
            🛒
            <span class="cart-badge" id="cartBadge">0</span>
        </button>
        <?php endif; ?>
        
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

<script>
// Menu hamburger
function toggleAccountMenu() {
    const dropdown = document.getElementById('accountDropdown');
    dropdown.classList.toggle('show');
}

window.addEventListener('click', function(event) {
    if (!event.target.closest('.account-menu')) {
        const dropdown = document.getElementById('accountDropdown');
        if (dropdown && dropdown.classList.contains('show')) {
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
                    badge.classList.remove('hidden');
                } else {
                    badge.style.display = 'none';
                    badge.classList.add('hidden');
                }
            }
        })
        .catch(error => {
            console.error('Lỗi khi cập nhật badge:', error);
        });
}

// Kiểm tra đăng nhập
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

<main>