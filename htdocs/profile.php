<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Cá Nhân - SAPHARY</title>
    
    <!-- Favicon - Logo SAPHARY -->
    <link rel="icon" type="image/jpeg" href="img/logo.jpg">
    <link rel="shortcut icon" type="image/jpeg" href="img/logo.jpg">
    <link rel="apple-touch-icon" href="img/logo.jpg">
    
    <link rel="stylesheet" href="style.css/trangchu_style.css">
    <style>
        body {
            background: #f5f5f5;
        }
        .profile-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        .profile-header {
            background: linear-gradient(135deg, #331a43 0%, #1a0d21 100%);
            color: white;
            padding: 40px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(51, 26, 67, 0.3);
        }
        .profile-header h1 {
            margin: 0 0 10px 0;
            font-size: 32px;
        }
        .profile-header p {
            margin: 0;
            opacity: 0.9;
        }
        .profile-content {
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 30px;
        }
        .sidebar {
            background: white;
            border-radius: 15px;
            padding: 20px;
            height: fit-content;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .sidebar-item {
            padding: 15px 20px;
            margin-bottom: 10px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #333;
            text-decoration: none;
        }
        .sidebar-item:hover {
            background: #f8f4fc;
            color: #331a43;
        }
        .sidebar-item.active {
            background: linear-gradient(135deg, #331a43 0%, #1a0d21 100%);
            color: white;
        }
        .main-content {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .section {
            display: none;
        }
        .section.active {
            display: block;
        }
        .section h2 {
            color: #331a43;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        .info-item {
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 4px solid #331a43;
        }
        .info-item label {
            display: block;
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-item .value {
            font-size: 16px;
            color: #333;
            font-weight: 500;
        }
        .wallet-card {
            background: linear-gradient(135deg, #331a43 0%, #1a0d21 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
        }
        .wallet-balance {
            font-size: 36px;
            font-weight: bold;
            margin: 10px 0;
        }
        .order-item {
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            margin-bottom: 15px;
            transition: all 0.3s;
        }
        .order-item:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .order-id {
            font-weight: 600;
            color: #331a43;
        }
        .order-status {
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        .status-processing {
            background: #cfe2ff;
            color: #084298;
        }
        .status-shipping {
            background: #d1e7dd;
            color: #0f5132;
        }
        .status-completed {
            background: #d1e7dd;
            color: #0f5132;
        }
        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.3s;
        }
        .btn-primary {
            background: linear-gradient(135deg, #331a43 0%, #1a0d21 100%);
            color: white;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(51, 26, 67, 0.4);
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }
        .empty-state img {
            width: 150px;
            opacity: 0.5;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="profile-container">
        <div class="profile-header">
            <h1 id="userName">Xin chào!</h1>
            <p id="userEmail"></p>
        </div>

        <div class="profile-content">
            <div class="sidebar">
                <div class="sidebar-item active" onclick="showSection('overview')">
                    <span>📊</span> Tổng quan
                </div>
                <div class="sidebar-item" onclick="showSection('orders')">
                    <span>📦</span> Đơn hàng
                </div>
                <div class="sidebar-item" onclick="showSection('wallet')">
                    <span>💰</span> Ví của tôi
                </div>
                <div class="sidebar-item" onclick="showSection('settings')">
                    <span>⚙️</span> Cài đặt
                </div>
                <div class="sidebar-item" onclick="logout()" style="color: #dc3545;">
                    <span>🚪</span> Đăng xuất
                </div>
            </div>

            <div class="main-content">
                <!-- Tổng quan -->
                <div id="overview" class="section active">
                    <h2>Tổng quan tài khoản</h2>
                    <div class="info-grid">
                        <div class="info-item">
                            <label>Họ và tên</label>
                            <div class="value" id="overviewName">-</div>
                        </div>
                        <div class="info-item">
                            <label>Email</label>
                            <div class="value" id="overviewEmail">-</div>
                        </div>
                        <div class="info-item">
                            <label>Số điện thoại</label>
                            <div class="value" id="overviewPhone">-</div>
                        </div>
                        <div class="info-item">
                            <label>Địa chỉ</label>
                            <div class="value" id="overviewAddress">-</div>
                        </div>
                    </div>

                    <h3 style="margin-top: 30px; color: #331a43;">Thống kê</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <label>Tổng đơn hàng</label>
                            <div class="value" id="totalOrders">0</div>
                        </div>
                        <div class="info-item">
                            <label>Đang giao</label>
                            <div class="value" id="shippingOrders">0</div>
                        </div>
                        <div class="info-item">
                            <label>Hoàn thành</label>
                            <div class="value" id="completedOrders">0</div>
                        </div>
                        <div class="info-item">
                            <label>Số dư ví</label>
                            <div class="value" id="walletBalance">0 VND</div>
                        </div>
                    </div>
                </div>

                <!-- Đơn hàng -->
                <div id="orders" class="section">
                    <h2>Lịch sử đơn hàng</h2>
                    <div id="ordersList"></div>
                </div>

                <!-- Ví -->
                <div id="wallet" class="section">
                    <h2>Ví của tôi</h2>
                    <div class="wallet-card">
                        <div style="opacity: 0.9;">Số dư khả dụng</div>
                        <div class="wallet-balance" id="walletBalanceMain">0 VND</div>
                        <div style="opacity: 0.8; font-size: 14px;">Tài khoản: <span id="walletEmail"></span></div>
                    </div>
                    <button class="btn btn-primary">💳 Nạp tiền</button>
                    <button class="btn btn-secondary" style="margin-left: 10px;">📤 Rút tiền</button>
                </div>

                <!-- Cài đặt -->
                <div id="settings" class="section">
                    <h2>Cài đặt tài khoản</h2>
                    <div class="info-grid">
                        <div class="info-item">
                            <label>Đổi mật khẩu</label>
                            <button class="btn btn-primary" onclick="changePassword()">Đổi mật khẩu</button>
                        </div>
                        <div class="info-item">
                            <label>Đổi mã PIN</label>
                            <button class="btn btn-primary" onclick="changePin()">Đổi mã PIN</button>
                        </div>
                        <div class="info-item">
                            <label>Cập nhật thông tin</label>
                            <button class="btn btn-primary" onclick="updateInfo()">Chỉnh sửa</button>
                        </div>
                        <div class="info-item">
                            <label>Xóa tài khoản</label>
                            <button class="btn btn-secondary" onclick="deleteAccount()">Xóa tài khoản</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        // Kiểm tra đăng nhập
        const currentUser = localStorage.getItem('currentUser');
        if (!currentUser) {
            alert('Vui lòng đăng nhập để xem trang cá nhân!');
            window.location.href = 'login.php';
        }

        const user = JSON.parse(currentUser);

        // Hiển thị thông tin user
        document.getElementById('userName').textContent = `Xin chào, ${user.name}!`;
        document.getElementById('userEmail').textContent = user.email;
        document.getElementById('overviewName').textContent = user.name;
        document.getElementById('overviewEmail').textContent = user.email;
        document.getElementById('overviewPhone').textContent = user.phone || '-';
        document.getElementById('overviewAddress').textContent = user.address || '-';
        document.getElementById('walletEmail').textContent = user.email;

        // Load đơn hàng
        loadOrders();

        function showSection(sectionId) {
            // Ẩn tất cả sections
            document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
            document.querySelectorAll('.sidebar-item').forEach(s => s.classList.remove('active'));
            
            // Hiện section được chọn
            document.getElementById(sectionId).classList.add('active');
            event.target.closest('.sidebar-item').classList.add('active');
        }

        function loadOrders() {
            // Đồng bộ từ allOrders về userOrders
            syncOrdersFromAdmin();
            
            const orders = JSON.parse(localStorage.getItem('userOrders_' + user.email) || '[]');
            const ordersList = document.getElementById('ordersList');
            
            if (orders.length === 0) {
                ordersList.innerHTML = `
                    <div class="empty-state">
                        <div style="font-size: 60px;">📦</div>
                        <h3>Chưa có đơn hàng nào</h3>
                        <p>Hãy mua sắm ngay để trải nghiệm dịch vụ của chúng tôi!</p>
                        <a href="sanpham.php" class="btn btn-primary" style="display: inline-block; margin-top: 20px;">Mua sắm ngay</a>
                    </div>
                `;
            } else {
                ordersList.innerHTML = orders.map((order, index) => `
                    <div class="order-item">
                        <div class="order-header">
                            <div class="order-id">Đơn hàng #${index + 1}</div>
                            <div class="order-status status-${order.status}">${getStatusText(order.status)}</div>
                        </div>
                        <div style="color: #666; font-size: 14px; margin-bottom: 10px;">
                            📅 ${order.created_at || 'N/A'}
                        </div>
                        <div style="font-weight: 600; color: #331a43; font-size: 18px;">
                            ${formatMoney(order.total)} VND
                        </div>
                        <div style="margin-top: 10px; color: #666;">
                            📍 ${order.address}
                        </div>
                    </div>
                `).join('');
            }

            // Cập nhật thống kê
            document.getElementById('totalOrders').textContent = orders.length;
            document.getElementById('shippingOrders').textContent = orders.filter(o => o.status === 'shipping').length;
            document.getElementById('completedOrders').textContent = orders.filter(o => o.status === 'completed').length;
        }

        function getStatusText(status) {
            const statusMap = {
                'pending': '⏳ Chờ xác nhận',
                'processing': '✅ Đã xác nhận - Đang chuẩn bị hàng',
                'shipping': '🚚 Đang giao hàng',
                'completed': '✅ Hoàn thành',
                'cancelled': '❌ Đã hủy'
            };
            return statusMap[status] || status;
        }
        
        function syncOrdersFromAdmin() {
            // Lấy tất cả đơn hàng từ admin
            const allOrders = JSON.parse(localStorage.getItem('allOrders') || '[]');
            
            // Lọc đơn hàng của user hiện tại (theo email)
            const userOrders = allOrders.filter(order => {
                // So sánh theo email trong đơn hàng
                const orderEmail = order.email || order.user_email;
                return orderEmail === user.email;
            });
            
            // Cập nhật lại userOrders
            localStorage.setItem('userOrders_' + user.email, JSON.stringify(userOrders));
        }

        function formatMoney(amount) {
            return new Intl.NumberFormat('vi-VN').format(amount);
        }

        function logout() {
            if (confirm('Bạn có chắc muốn đăng xuất?')) {
                // Xóa giỏ hàng của user hiện tại
                const userEmail = getCurrentUser();
                const cartKey = `cart_${userEmail}`;
                localStorage.removeItem(cartKey);
                
                localStorage.removeItem('currentUser');
                window.location.href = 'index.php';
            }
        }
        
        function getCurrentUser() {
            const user = localStorage.getItem('currentUser');
            if (user) {
                const userData = JSON.parse(user);
                return userData.email || 'guest';
            }
            return 'guest';
        }

        function changePassword() {
            alert('Tính năng đổi mật khẩu đang được phát triển!');
        }

        function changePin() {
            alert('Tính năng đổi mã PIN đang được phát triển!');
        }

        function updateInfo() {
            alert('Tính năng cập nhật thông tin đang được phát triển!');
        }

        function deleteAccount() {
            if (confirm('⚠️ Bạn có chắc muốn xóa tài khoản? Hành động này không thể hoàn tác!')) {
                alert('Tính năng xóa tài khoản đang được phát triển!');
            }
        }
    </script>
</body>
</html>
