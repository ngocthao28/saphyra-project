<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên Mật Khẩu - SAPHARY</title>
    
    <!-- Favicon - Logo SAPHARY -->
    <link rel="icon" type="image/jpeg" href="img/logo.jpg">
    <link rel="shortcut icon" type="image/jpeg" href="img/logo.jpg">
    <link rel="apple-touch-icon" href="img/logo.jpg">
    
    <link rel="stylesheet" href="style.css/trangchu_style.css">
    <style>
        .forgot-container {
            max-width: 450px;
            margin: 80px auto;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .forgot-container h2 {
            color: #331a43;
            text-align: center;
            margin-bottom: 30px;
        }
        .step {
            display: none;
        }
        .step.active {
            display: block;
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
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 15px;
            transition: border-color 0.3s;
        }
        .form-group input:focus {
            outline: none;
            border-color: #331a43;
        }
        .btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #331a43 0%, #1a0d21 100%);
            color: white !important;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(51, 26, 67, 0.4);
        }
        .btn-secondary {
            background: #6c757d;
            margin-top: 10px;
        }
        .error-message {
            background: #fee;
            color: #c33;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            display: none;
        }
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            display: none;
        }
        .code-input {
            text-align: center;
            font-size: 24px;
            letter-spacing: 10px;
            font-weight: bold;
        }
        .info-box {
            background: #e7f3ff;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            color: #004085;
            font-size: 14px;
        }
        .progress-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .progress-step {
            flex: 1;
            text-align: center;
            padding: 10px;
            background: #e0e0e0;
            position: relative;
        }
        .progress-step.active {
            background: #331a43;
            color: white;
        }
        .progress-step.completed {
            background: #28a745;
            color: white;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="forgot-container">
        <h2>🔐 Quên Mật Khẩu</h2>
        
        <!-- Progress Bar -->
        <div class="progress-bar">
            <div class="progress-step active" id="progress1">1. Xác thực</div>
            <div class="progress-step" id="progress2">2. Mã OTP</div>
            <div class="progress-step" id="progress3">3. Đặt lại</div>
        </div>

        <div class="error-message" id="errorMessage"></div>
        <div class="success-message" id="successMessage"></div>

        <!-- Bước 1: Nhập email/SĐT -->
        <div id="step1" class="step active">
            <div class="info-box">
                � Nhập email đã đăng ký để nhận mã xác thực qua email
            </div>
            <form id="verifyForm">
                <div class="form-group">
                    <label>Email đã đăng ký</label>
                    <input type="text" id="identifier" placeholder="email@example.com hoặc 0912345678" required>
                </div>
                <button type="submit" class="btn">Gửi mã xác thực</button>
                <button type="button" class="btn btn-secondary" onclick="window.location.href='login.php'">Quay lại đăng nhập</button>
            </form>
        </div>

        <!-- Bước 2: Nhập mã OTP -->
        <div id="step2" class="step">
            <div class="info-box">
                � MMã xác thực đã được gửi đến email: <strong id="sentTo"></strong>
                <br><small>Vui lòng kiểm tra cả hộp thư spam nếu không thấy email</small>
            </div>
            <form id="otpForm">
                <div class="form-group">
                    <label>Nhập mã xác thực (6 số)</label>
                    <input type="text" id="otpCode" class="code-input" maxlength="6" pattern="[0-9]{6}" placeholder="000000" required>
                </div>
                <p style="text-align: center; color: #666; font-size: 13px;">
                    <em>Kiểm tra email để lấy mã xác thực</em>
                </p>
                <button type="submit" class="btn">Xác nhận mã</button>
                <button type="button" class="btn btn-secondary" onclick="resendCode()">Gửi lại mã</button>
            </form>
        </div>

        <!-- Bước 3: Đặt lại mật khẩu -->
        <div id="step3" class="step">
            <div class="info-box">
                🔑 Tạo mật khẩu mới cho tài khoản của bạn
            </div>
            <form id="resetForm">
                <div class="form-group">
                    <label>Mật khẩu mới</label>
                    <input type="password" id="newPassword" placeholder="Tối thiểu 6 ký tự" required>
                </div>
                <div class="form-group">
                    <label>Xác nhận mật khẩu mới</label>
                    <input type="password" id="confirmPassword" placeholder="Nhập lại mật khẩu" required>
                </div>
                <button type="submit" class="btn">Đặt lại mật khẩu</button>
            </form>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        let currentUser = null;
        let verificationCode = '';

        // Bước 1: Xác thực email/SĐT
        document.getElementById('verifyForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const identifier = document.getElementById('identifier').value.trim();
            const users = JSON.parse(localStorage.getItem('users') || '[]');
            
            // Tìm user theo email hoặc SĐT
            const user = users.find(u => 
                u.email === identifier || u.phone === identifier
            );
            
            if (!user) {
                showError('Không tìm thấy tài khoản với thông tin này!');
                return;
            }
            
            currentUser = user;
            
            // Tạo mã OTP ngẫu nhiên (6 số)
            verificationCode = Math.floor(100000 + Math.random() * 900000).toString();
            
            // Lưu mã OTP (trong thực tế sẽ gửi qua email/SMS)
            localStorage.setItem('otp_temp', JSON.stringify({
                code: verificationCode,
                email: user.email,
                timestamp: Date.now()
            }));
            
            // Hiển thị thông tin
            document.getElementById('sentTo').textContent = user.email;
            document.getElementById('displayCode').textContent = verificationCode;
            
            // Gửi email qua SMTP
            fetch('send_otp_email_smtp.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    email: user.email,
                    otp: verificationCode,
                    name: user.name
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccess('✅ Mã xác thực đã được gửi đến email của bạn!');
                } else {
                    showSuccess('✅ Mã xác thực đã được tạo! (Email server chưa cấu hình)');
                }
            })
            .catch(error => {
                // Nếu lỗi gửi email, vẫn cho phép tiếp tục
                console.log('Email server not configured, using local OTP');
                showSuccess('✅ Mã xác thực đã được tạo!');
            });
            
            setTimeout(() => {
                goToStep(2);
            }, 2000);
        });

        // Bước 2: Xác nhận OTP
        document.getElementById('otpForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const otpCode = document.getElementById('otpCode').value;
            
            if (otpCode !== verificationCode) {
                showError('Mã xác thực không đúng! Vui lòng thử lại.');
                document.getElementById('otpCode').value = '';
                return;
            }
            
            showSuccess('Xác thực thành công!');
            
            setTimeout(() => {
                goToStep(3);
            }, 1000);
        });

        // Bước 3: Đặt lại mật khẩu
        document.getElementById('resetForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            if (newPassword.length < 6) {
                showError('Mật khẩu phải có ít nhất 6 ký tự!');
                return;
            }
            
            if (newPassword !== confirmPassword) {
                showError('Mật khẩu xác nhận không khớp!');
                return;
            }
            
            // Cập nhật mật khẩu
            const users = JSON.parse(localStorage.getItem('users') || '[]');
            const userIndex = users.findIndex(u => u.email === currentUser.email);
            
            if (userIndex !== -1) {
                users[userIndex].password = newPassword;
                localStorage.setItem('users', JSON.stringify(users));
                
                // Tự động đăng nhập
                localStorage.setItem('currentUser', JSON.stringify(users[userIndex]));
                
                showSuccess('✅ Đặt lại mật khẩu thành công! Đang chuyển về trang chủ...');
                
                setTimeout(() => {
                    window.location.href = 'index.php';
                }, 2000);
            } else {
                showError('Có lỗi xảy ra. Vui lòng thử lại!');
            }
        });

        // Gửi lại mã
        function resendCode() {
            verificationCode = Math.floor(100000 + Math.random() * 900000).toString();
            
            // Lưu mã mới
            localStorage.setItem('otp_temp', JSON.stringify({
                code: verificationCode,
                email: currentUser.email,
                timestamp: Date.now()
            }));
            
            document.getElementById('displayCode').textContent = verificationCode;
            
            // Thử gửi email qua SMTP
            fetch('send_otp_email_smtp.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    email: currentUser.email,
                    otp: verificationCode,
                    name: currentUser.name
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccess('✅ Đã gửi lại mã xác thực qua email!');
                } else {
                    showSuccess('✅ Đã tạo mã xác thực mới!');
                }
            })
            .catch(error => {
                showSuccess('✅ Đã tạo mã xác thực mới!');
            });
        }

        // Chuyển bước
        function goToStep(step) {
            document.querySelectorAll('.step').forEach(s => s.classList.remove('active'));
            document.getElementById('step' + step).classList.add('active');
            
            // Cập nhật progress bar
            for (let i = 1; i <= 3; i++) {
                const progressStep = document.getElementById('progress' + i);
                if (i < step) {
                    progressStep.classList.add('completed');
                    progressStep.classList.remove('active');
                } else if (i === step) {
                    progressStep.classList.add('active');
                    progressStep.classList.remove('completed');
                } else {
                    progressStep.classList.remove('active', 'completed');
                }
            }
            
            hideMessages();
        }

        // Hiển thị lỗi
        function showError(message) {
            const errorDiv = document.getElementById('errorMessage');
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';
            document.getElementById('successMessage').style.display = 'none';
        }

        // Hiển thị thành công
        function showSuccess(message) {
            const successDiv = document.getElementById('successMessage');
            successDiv.textContent = message;
            successDiv.style.display = 'block';
            document.getElementById('errorMessage').style.display = 'none';
        }

        // Ẩn thông báo
        function hideMessages() {
            document.getElementById('errorMessage').style.display = 'none';
            document.getElementById('successMessage').style.display = 'none';
        }

        // Chỉ cho phép nhập số cho OTP
        document.getElementById('otpCode').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
</body>
</html>
