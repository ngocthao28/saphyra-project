<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký - SAPHARY</title>
    
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
            <a href="lienhe.php">Liên Hệ</a>
            <a href="login.php">Đăng Nhập</a>
            <a href="register.php" class="active">Đăng Ký</a>
        </nav>
    </header>

    <main class="container">
        <section id="register" class="page active-page">
            <div class="auth-container">
                <h2>Tạo Tài Khoản Mới</h2>
                <form class="auth-form" id="register-form">
                    <input type="text" name="name" placeholder="Họ và tên" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="tel" name="phone" placeholder="Số điện thoại (VD: 0912345678)" required>
                    
                    <h3 style="margin: 15px 0 10px 0; font-size: 16px; color: #6f488b; text-align: left;">📍 Địa chỉ giao hàng</h3>
                    <input type="text" name="street" placeholder="Số nhà, tên đường" required>
                    <input type="text" name="ward" placeholder="Phường/Xã" required>
                    <input type="text" name="district" placeholder="Quận/Huyện" required>
                    <input type="text" name="city" placeholder="Tỉnh/Thành phố" required>
                    
                    <div style="display: flex; align-items: center; gap: 10px; margin: 10px 0;">
                        <input type="checkbox" id="saveAddress" name="saveAddress" checked style="width: auto; margin: 0;">
                        <label for="saveAddress" style="margin: 0; font-size: 14px; color: #666;">Lưu địa chỉ này làm mặc định</label>
                    </div>
                    
                    <h3 style="margin: 15px 0 10px 0; font-size: 16px; color: #6f488b; text-align: left;">🔐 Bảo mật</h3>
                    <input type="password" name="password" placeholder="Mật khẩu" required>
                    <input type="password" name="confirm" placeholder="Nhập lại mật khẩu" required>
                    <input type="password" name="pin" placeholder="Mã PIN thanh toán (6 số)" maxlength="6" pattern="[0-9]{6}" required>
                    <input type="password" name="confirmPin" placeholder="Nhập lại mã PIN" maxlength="6" pattern="[0-9]{6}" required>
                    <p style="font-size: 12px; color: #999; margin: -10px 0 10px 0;">Mã PIN dùng để xác nhận thanh toán</p>
                    
                    <button type="submit" class="btn-auth">Đăng Ký</button>
                </form>
                <p>Đã có tài khoản?
                    <a href="login.php">Đăng nhập</a>
                </p>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded');
            
            // Nếu đã đăng nhập, chuyển về trang chủ
            if (localStorage.getItem('currentUser')) {
                window.location.href = 'index.php';
                return;
            }

            // Xử lý submit form đăng ký
            const registerForm = document.getElementById('register-form');
            console.log('Form found:', registerForm);
            
            if (!registerForm) {
                console.error('Form not found!');
                return;
            }

            registerForm.addEventListener('submit', function(e) {
                e.preventDefault();
                console.log('Form submitted');
                
                try {
                    const name = this.querySelector('input[name="name"]').value.trim();
                    const email = this.querySelector('input[name="email"]').value.trim();
                    const phone = this.querySelector('input[name="phone"]').value.trim();
                    const street = this.querySelector('input[name="street"]').value.trim();
                    const ward = this.querySelector('input[name="ward"]').value.trim();
                    const district = this.querySelector('input[name="district"]').value.trim();
                    const city = this.querySelector('input[name="city"]').value.trim();
                    const password = this.querySelector('input[name="password"]').value;
                    const confirmPassword = this.querySelector('input[name="confirm"]').value;
                    const pin = this.querySelector('input[name="pin"]').value;
                    const confirmPin = this.querySelector('input[name="confirmPin"]').value;
                    const saveAddress = this.querySelector('input[name="saveAddress"]').checked;

                    console.log('Form data:', { name, email, phone });

                    // Validate
                    if (!name || !email || !phone || !street || !ward || !district || !city || !password || !pin) {
                        alert('Vui lòng nhập đầy đủ thông tin!');
                        return;
                    }

                    // Validate số điện thoại
                    const phoneRegex = /^[0-9]{10,11}$/;
                    if (!phoneRegex.test(phone)) {
                        alert('Số điện thoại không hợp lệ! Vui lòng nhập 10-11 chữ số.');
                        return;
                    }

                    if (password !== confirmPassword) {
                        alert('Mật khẩu nhập lại không khớp!');
                        return;
                    }

                    if (password.length < 6) {
                        alert('Mật khẩu phải có ít nhất 6 ký tự!');
                        return;
                    }

                    // Validate PIN
                    const pinRegex = /^[0-9]{6}$/;
                    if (!pinRegex.test(pin)) {
                        alert('Mã PIN phải là 6 chữ số!');
                        return;
                    }

                    if (pin !== confirmPin) {
                        alert('Mã PIN nhập lại không khớp!');
                        return;
                    }

                    const users = JSON.parse(localStorage.getItem('users') || '[]');

                    // Kiểm tra email đã tồn tại
                    const existingUser = users.find(u => u.email === email);
                    if (existingUser) {
                        const userConfirm = window.confirm('❌ Email này đã được sử dụng!\n\nBạn đã có tài khoản? Hãy đăng nhập.');
                        if (userConfirm) {
                            window.location.href = 'login.php';
                        }
                        return;
                    }

                    // Ghép địa chỉ đầy đủ
                    const fullAddress = `${street}, ${ward}, ${district}, ${city}`;

                    const newUser = {
                        name: name,
                        email: email,
                        phone: phone,
                        address: fullAddress,
                        addressDetails: {
                            street: street,
                            ward: ward,
                            district: district,
                            city: city
                        },
                        saveAddress: saveAddress,
                        password: password,
                        pin: pin
                    };

                    users.push(newUser);
                    localStorage.setItem('users', JSON.stringify(users));

                    console.log('User registered:', newUser);

                    alert('🎉 Đăng ký thành công! Vui lòng đăng nhập.');
                    window.location.href = 'login.php';
                    
                } catch (error) {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra: ' + error.message);
                }
            });
        });
    </script>
</body>
</html>