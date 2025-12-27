<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập - SAPHARY</title>
    
    <!-- Favicon - Logo SAPHARY -->
    <link rel="icon" type="image/jpeg" href="img/logo.jpg">
    <link rel="shortcut icon" type="image/jpeg" href="img/logo.jpg">
    <link rel="apple-touch-icon" href="img/logo.jpg">
    
    <link rel="stylesheet" href="style.css/trangchu_style.css">
</head>
<body>
    
    <header>
        <div class="logo" onclick="window.location.href='index.php'">
            <img src="img/logo.jpg" alt="Logo SAPHYRA">
            <span>SAPHYRA</span>
        </div>
        <nav id="main-nav">
            <a href="index.php">Trang Chủ</a>
            <a href="sanpham.php">Sản Phẩm</a>
            <a href="gioithieu.php">Giới Thiệu</a>
            <a href="contact.php">Liên Hệ</a>
            <a href="login.php" class="active">Đăng Nhập</a>
            <a href="register.php">Đăng Ký</a>
        </nav>
    </header>

    <main class="container">
        <section id="login" class="page active-page">
            <div class="auth-container">
                <h2>Đăng Nhập</h2>
                <form class="auth-form" id="login-form">
                    <input type="email" placeholder="Email" required>
                    <input type="password" placeholder="Mật khẩu" required>
                    <button type="submit" class="btn-auth">Đăng Nhập</button>
                </form>
                <p>Chưa có tài khoản?
                    <a href="register.php">Đăng ký ngay</a>
                </p>
                <p style="margin-top: 10px;">
                    <a href="forgot_password.php" style="color: #dc3545;">Quên mật khẩu?</a>
                </p>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Nếu đã đăng nhập, chuyển về trang chủ
            if (localStorage.getItem('currentUser')) {
                window.location.href = 'index.php';
            }
        });

        // Xử lý submit form đăng nhập
        document.getElementById('login-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = this.querySelector('input[type="email"]').value.trim();
            const password = this.querySelector('input[type="password"]').value;

            // Kiểm tra tài khoản admin (ẩn)
            if (email === 'admin@saphyra.com' && password === 'admin123') {
                // Lưu session admin vào localStorage
                localStorage.setItem('adminSession', JSON.stringify({
                    username: 'admin',
                    email: email,
                    loginTime: new Date().toISOString()
                }));
                
                // Chuyển hướng đến trang admin (sử dụng PHP session)
                fetch('admin_login.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `username=admin&password=admin123`
                })
                .then(response => response.text())
                .then(() => {
                    window.location.href = 'admin_dashboard.php';
                })
                .catch(() => {
                    window.location.href = 'admin_dashboard.php';
                });
                return;
            }

            // Kiểm tra tài khoản user thông thường
            const users = JSON.parse(localStorage.getItem('users') || '[]');
            const user = users.find(u => u.email === email && u.password === password);

            if (user) {
                alert(`Xin chào ${user.name}! Bạn đã đăng nhập thành công.`);
                localStorage.setItem('currentUser', JSON.stringify(user));
                window.location.href = 'index.php'; // Chuyển về trang chủ
            } else {
                alert('Email hoặc mật khẩu không đúng!');
            }
        });
    </script>
</body>
</html>