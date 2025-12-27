<?php
session_start();

// Nếu giỏ hàng trống → quay lại trang sản phẩm
if (empty($_SESSION['cart'])) {
  header("Location: sanpham.php");
  exit;
}

// Khi người dùng nhấn nút "Xác nhận thanh toán"
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
  $paymentMethod = $_POST['payment_method'] ?? 'qr'; // Mặc định là QR
  $total = 0;

  foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
  }

  // Tạo link QR theo chuẩn VietQR (VD: MBBank)
  $bank = "970422"; // Mã BIN MB Bank
  $account = "229828102005"; // STK nhận tiền
  $template = "compact";
  $description = urlencode("Thanh toan don hang - $name");
  $amount = $total;
  $qr_url = "https://img.vietqr.io/image/$bank-$account-$template.png?amount=$amount&addInfo=$description";

  // --- Lưu thông tin đơn hàng vào file JSON ---
  $orderData = [
    'name' => $name,
    'phone' => $phone,
    'address' => $address,
    'items' => $_SESSION['cart'],
    'total' => $total,
    'payment_method' => $paymentMethod,
    'status' => 'pending',
    'created_at' => date('Y-m-d H:i:s'),
    'email' => '', // Sẽ được cập nhật từ JavaScript
    'user_email' => '' // Sẽ được cập nhật từ JavaScript
  ];

  $file = 'orders.json';
  $existingOrders = [];

  if (file_exists($file)) {
    $json = file_get_contents($file);
    $existingOrders = json_decode($json, true) ?: [];
  }

  $existingOrders[] = $orderData;
  file_put_contents($file, json_encode($existingOrders, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

  // Xóa giỏ hàng sau khi tạo đơn
  $_SESSION['cart'] = [];

  // Lưu đơn hàng vào localStorage (JavaScript)
  $orderDataJson = json_encode($orderData, JSON_UNESCAPED_UNICODE);
  echo "<script>
    // Lưu đơn hàng vào localStorage
    const currentUser = localStorage.getItem('currentUser');
    const orderData = " . $orderDataJson . ";
    
    // Thêm email vào orderData
    if (currentUser) {
      const user = JSON.parse(currentUser);
      orderData.email = user.email;
      orderData.user_email = user.email;
    }
    
    // 1. Lưu vào allOrders (cho admin)
    const allOrders = JSON.parse(localStorage.getItem('allOrders') || '[]');
    allOrders.push(orderData);
    localStorage.setItem('allOrders', JSON.stringify(allOrders));
    
    // 2. Lưu vào userOrders (cho user)
    if (currentUser) {
      const user = JSON.parse(currentUser);
      const userOrders = JSON.parse(localStorage.getItem('userOrders_' + user.email) || '[]');
      userOrders.push(orderData);
      localStorage.setItem('userOrders_' + user.email, JSON.stringify(userOrders));
    }
  </script>";

  // Hiển thị trang cảm ơn theo phương thức thanh toán
  echo "<div style='max-width:500px;margin:50px auto;background:white;padding:30px;border-radius:12px;text-align:center;box-shadow:0 5px 20px rgba(0,0,0,0.1)'>";
  echo "<h2 style='color:#2E8B57;'>✅ Cảm ơn $name đã đặt hàng!</h2>";
  echo "<p>Tổng thanh toán: <b>" . number_format($total) . " VND</b></p>";
  
  if ($paymentMethod === 'cod') {
    // Thanh toán khi nhận hàng
    echo "<div style='background:#fff3cd;padding:20px;border-radius:8px;margin:20px 0;border:2px solid #ffc107;'>";
    echo "<h3 style='color:#856404;margin:0 0 10px 0;'>💵 Thanh toán khi nhận hàng (COD)</h3>";
    echo "<p style='color:#856404;margin:0;'>Bạn sẽ thanh toán bằng tiền mặt khi nhận được hàng.</p>";
    echo "<p style='color:#856404;margin:10px 0 0 0;'><strong>Vui lòng chuẩn bị đủ tiền mặt!</strong></p>";
    echo "</div>";
    echo "<p style='color:#666;'>📦 Đơn hàng của bạn đang được xử lý và sẽ sớm được giao đến địa chỉ:</p>";
    echo "<p style='background:#f8f9fa;padding:10px;border-radius:6px;'><strong>$address</strong></p>";
  } else {
    // Thanh toán QR
    echo "<p>Quét mã VietQR để thanh toán:</p>";
    echo "<img src='$qr_url' alt='VietQR' style='width:250px;margin:15px 0;border-radius:8px;'>";
    echo "<p><small>Ngân hàng MBBank - STK <b>$account</b></small></p>";
    echo "<p><small>Nội dung: <b>Thanh toan don hang - $name</b></small></p>";
  }
  
  echo "<div style='margin-top:20px'>
          <a href='sanpham.php' style='background:#c59d5f;color:white;padding:10px 20px;border-radius:8px;text-decoration:none;'>← Quay lại mua sắm</a>
        </div>";
  echo "</div>";
  exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Thanh toán | SAPHARY</title>
  
  <!-- Favicon - Logo SAPHARY -->
  <link rel="icon" type="image/jpeg" href="img/logo.jpg">
  <link rel="shortcut icon" type="image/jpeg" href="img/logo.jpg">
  <link rel="apple-touch-icon" href="img/logo.jpg">
  
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f8f9fa;
      margin: 0;
      padding: 0;
    }
    .checkout-container {
      max-width: 800px;
      margin: 50px auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      color: #333;
      margin-bottom: 25px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 25px;
    }
    th, td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #eee;
    }
    th {
      background-color: #f1f1f1;
      color: #555;
    }
    tfoot td {
      font-weight: bold;
      color: #c59d5f;
    }
    form {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    input {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
      transition: all 0.3s;
    }
    input[readonly] {
      background-color: #f8f9fa;
      cursor: not-allowed;
    }
    input:not([readonly]):focus {
      outline: none;
      border-color: #c59d5f;
      box-shadow: 0 0 5px rgba(197, 157, 95, 0.3);
    }
    h3 {
      font-size: 16px;
      font-weight: 600;
    }
    button {
      flex: 1;
    }
    button:hover {
      opacity: 0.9;
      transform: translateY(-1px);
    }
    .payment-option:hover {
      border-color: #c59d5f !important;
      background-color: #fffbf5;
    }
    .payment-option input[type="radio"]:checked + div {
      color: #c59d5f;
    }
    .payment-option:has(input[type="radio"]:checked) {
      border-color: #c59d5f !important;
      background-color: #fffbf5;
    }
    button {
      padding: 12px;
      background: #c59d5f;
      border: none;
      color: white;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
    }
    button:hover {
      background: #a47d3d;
    }
  </style>
</head>
<body>

<div class="checkout-container">
  <h2>🧾 Xác nhận đơn hàng</h2>

  <table>
    <thead>
      <tr>
        <th>Sản phẩm</th>
        <th>Giá</th>
        <th>Số lượng</th>
        <th>Thành tiền</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $total = 0;
      foreach ($_SESSION['cart'] as $item):
        $subtotal = $item['price'] * $item['quantity'];
        $total += $subtotal;
      ?>
      <tr>
        <td><?= htmlspecialchars($item['name']) ?></td>
        <td><?= number_format($item['price'], 0, ',', '.') ?> VND</td>
        <td><?= $item['quantity'] ?></td>
        <td><?= number_format($subtotal, 0, ',', '.') ?> VND</td>
      </tr>
      <?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="3" style="text-align:right;">Tổng cộng:</td>
        <td><b><?= number_format($total, 0, ',', '.') ?> VND</b></td>
      </tr>
    </tfoot>
  </table>

  <form method="POST" id="checkoutForm">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
      <h3 style="margin: 0; color: #555;">👤 Thông tin người nhận</h3>
      <button type="button" id="editInfoBtn" style="background: #6c757d; padding: 6px 12px; font-size: 13px;">✏️ Sửa</button>
    </div>
    <input type="text" name="name" id="name" placeholder="Họ tên người nhận" required readonly>
    <input type="text" name="phone" id="phone" placeholder="Số điện thoại" required readonly>
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin: 20px 0 15px 0;">
      <h3 style="margin: 0; color: #555;">📍 Địa chỉ giao hàng</h3>
    </div>
    <input type="text" name="street" id="street" placeholder="Số nhà, tên đường" required readonly>
    <input type="text" name="ward" id="ward" placeholder="Phường/Xã" required readonly>
    <input type="text" name="district" id="district" placeholder="Quận/Huyện" required readonly>
    <input type="text" name="city" id="city" placeholder="Tỉnh/Thành phố" required readonly>
    
    <div style="display: flex; align-items: center; gap: 10px; margin: 15px 0;">
      <input type="checkbox" id="saveNewAddress" name="saveNewAddress" style="width: auto; margin: 0;">
      <label for="saveNewAddress" style="margin: 0; font-size: 14px; color: #666;">Lưu thông tin này cho lần mua sau</label>
    </div>
    
    <h3 style="margin: 20px 0 15px 0; color: #555;">💳 Phương thức thanh toán</h3>
    <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 20px;">
      <label style="display: flex; align-items: center; padding: 15px; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s;" class="payment-option">
        <input type="radio" name="payment_method" value="qr" checked style="width: auto; margin: 0 10px 0 0;">
        <div style="flex: 1;">
          <strong style="color: #333;">💳 Chuyển khoản QR Code</strong>
          <p style="margin: 5px 0 0 0; font-size: 13px; color: #666;">Quét mã QR để thanh toán ngay</p>
        </div>
      </label>
      
      <label style="display: flex; align-items: center; padding: 15px; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s;" class="payment-option">
        <input type="radio" name="payment_method" value="cod" style="width: auto; margin: 0 10px 0 0;">
        <div style="flex: 1;">
          <strong style="color: #333;">💵 Thanh toán khi nhận hàng (COD)</strong>
          <p style="margin: 5px 0 0 0; font-size: 13px; color: #666;">Thanh toán bằng tiền mặt khi nhận hàng</p>
        </div>
      </label>
    </div>
    
    <input type="hidden" name="address" id="address">
    
    <div style="display: flex; gap: 10px;">
      <button type="button" id="cancelEditBtn" style="background: #6c757d; display: none;">❌ Hủy</button>
      <button type="button" id="saveEditBtn" style="background: #28a745; display: none;">💾 Lưu thay đổi</button>
      <button type="button" id="submitBtn" onclick="showPinModal()">💳 Xác nhận thanh toán</button>
    </div>
  </form>
</div>

<!-- Modal nhập PIN -->
<div id="pinModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 10000; justify-content: center; align-items: center;">
  <div style="background: white; padding: 40px; border-radius: 15px; max-width: 400px; width: 90%; text-align: center; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
    <h2 style="color: #c59d5f; margin-bottom: 20px;">🔐 Xác nhận thanh toán</h2>
    <p style="color: #666; margin-bottom: 25px;">Vui lòng nhập mã PIN để xác nhận đơn hàng</p>
    
    <input type="password" id="pinInput" maxlength="6" placeholder="Nhập mã PIN (6 số)" 
           style="width: 100%; padding: 15px; font-size: 24px; text-align: center; letter-spacing: 10px; border: 2px solid #ddd; border-radius: 10px; margin-bottom: 20px; font-weight: bold;"
           pattern="[0-9]*" inputmode="numeric">
    
    <div id="pinError" style="color: #dc3545; margin-bottom: 15px; display: none; font-weight: 500;"></div>
    
    <div style="display: flex; gap: 10px;">
      <button type="button" onclick="closePinModal()" style="flex: 1; padding: 12px; background: #6c757d; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 16px;">Hủy</button>
      <button type="button" onclick="verifyPinAndSubmit()" style="flex: 1; padding: 12px; background: #c59d5f; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; font-weight: 600;">Xác nhận</button>
    </div>
    
    <p style="font-size: 12px; color: #999; margin-top: 15px;">Mã PIN được tạo khi đăng ký tài khoản</p>
  </div>
</div>

<script>
let originalUserData = null;
let isEditing = false;

// Tự động điền thông tin từ tài khoản đã đăng nhập
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý hiệu ứng chọn phương thức thanh toán
    const paymentOptions = document.querySelectorAll('.payment-option');
    paymentOptions.forEach(option => {
        option.addEventListener('click', function() {
            const radio = this.querySelector('input[type="radio"]');
            radio.checked = true;
            
            // Cập nhật text nút submit
            const submitBtn = document.getElementById('submitBtn');
            if (radio.value === 'cod') {
                submitBtn.innerHTML = '📦 Đặt hàng (COD)';
            } else {
                submitBtn.innerHTML = '💳 Xác nhận thanh toán';
            }
        });
    });
    const currentUser = localStorage.getItem('currentUser');
    
    if (currentUser) {
        try {
            const user = JSON.parse(currentUser);
            originalUserData = JSON.parse(JSON.stringify(user)); // Deep copy
            
            // Tự động điền thông tin cơ bản
            if (user.name) document.getElementById('name').value = user.name;
            if (user.phone) document.getElementById('phone').value = user.phone;
            
            // Tự động điền địa chỉ chi tiết nếu có
            if (user.addressDetails) {
                if (user.addressDetails.street) document.getElementById('street').value = user.addressDetails.street;
                if (user.addressDetails.ward) document.getElementById('ward').value = user.addressDetails.ward;
                if (user.addressDetails.district) document.getElementById('district').value = user.addressDetails.district;
                if (user.addressDetails.city) document.getElementById('city').value = user.addressDetails.city;
            } else if (user.address) {
                // Fallback: nếu chỉ có địa chỉ đầy đủ
                document.getElementById('street').value = user.address;
            }
        } catch (e) {
            console.error('Lỗi khi đọc thông tin user:', e);
        }
    } else {
        // Nếu chưa đăng nhập, cho phép nhập tự do
        enableEditing();
        document.getElementById('editInfoBtn').style.display = 'none';
    }
    
    // Xử lý nút "Sửa"
    document.getElementById('editInfoBtn').addEventListener('click', function() {
        enableEditing();
    });
    
    // Xử lý nút "Hủy"
    document.getElementById('cancelEditBtn').addEventListener('click', function() {
        if (originalUserData) {
            // Khôi phục dữ liệu gốc
            document.getElementById('name').value = originalUserData.name || '';
            document.getElementById('phone').value = originalUserData.phone || '';
            
            if (originalUserData.addressDetails) {
                document.getElementById('street').value = originalUserData.addressDetails.street || '';
                document.getElementById('ward').value = originalUserData.addressDetails.ward || '';
                document.getElementById('district').value = originalUserData.addressDetails.district || '';
                document.getElementById('city').value = originalUserData.addressDetails.city || '';
            }
        }
        disableEditing();
    });
    
    // Xử lý nút "Lưu thay đổi"
    document.getElementById('saveEditBtn').addEventListener('click', function() {
        if (validateForm()) {
            disableEditing();
            alert('✅ Thông tin đã được cập nhật tạm thời cho đơn hàng này!');
        }
    });
    
    // Ghép địa chỉ đầy đủ trước khi submit
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        const street = document.getElementById('street').value.trim();
        const ward = document.getElementById('ward').value.trim();
        const district = document.getElementById('district').value.trim();
        const city = document.getElementById('city').value.trim();
        
        const fullAddress = `${street}, ${ward}, ${district}, ${city}`;
        document.getElementById('address').value = fullAddress;
        
        // Nếu checkbox "Lưu thông tin" được chọn
        if (document.getElementById('saveNewAddress').checked) {
            saveUserInfo();
        }
    });
});

function enableEditing() {
    isEditing = true;
    const inputs = ['name', 'phone', 'street', 'ward', 'district', 'city'];
    inputs.forEach(id => {
        const input = document.getElementById(id);
        input.removeAttribute('readonly');
        input.style.backgroundColor = '#fff';
        input.style.borderColor = '#c59d5f';
    });
    
    document.getElementById('editInfoBtn').style.display = 'none';
    document.getElementById('cancelEditBtn').style.display = 'block';
    document.getElementById('saveEditBtn').style.display = 'block';
    document.getElementById('submitBtn').style.display = 'none';
}

function disableEditing() {
    isEditing = false;
    const inputs = ['name', 'phone', 'street', 'ward', 'district', 'city'];
    inputs.forEach(id => {
        const input = document.getElementById(id);
        input.setAttribute('readonly', 'readonly');
        input.style.backgroundColor = '#f8f9fa';
        input.style.borderColor = '#ccc';
    });
    
    document.getElementById('editInfoBtn').style.display = 'block';
    document.getElementById('cancelEditBtn').style.display = 'none';
    document.getElementById('saveEditBtn').style.display = 'none';
    document.getElementById('submitBtn').style.display = 'block';
}

function validateForm() {
    const name = document.getElementById('name').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const street = document.getElementById('street').value.trim();
    const ward = document.getElementById('ward').value.trim();
    const district = document.getElementById('district').value.trim();
    const city = document.getElementById('city').value.trim();
    
    if (!name || !phone || !street || !ward || !district || !city) {
        alert('Vui lòng nhập đầy đủ thông tin!');
        return false;
    }
    
    const phoneRegex = /^[0-9]{10,11}$/;
    if (!phoneRegex.test(phone)) {
        alert('Số điện thoại không hợp lệ! Vui lòng nhập 10-11 chữ số.');
        return false;
    }
    
    return true;
}

function saveUserInfo() {
    const currentUser = localStorage.getItem('currentUser');
    if (!currentUser) return;
    
    try {
        const user = JSON.parse(currentUser);
        const users = JSON.parse(localStorage.getItem('users') || '[]');
        
        // Cập nhật thông tin mới
        user.name = document.getElementById('name').value.trim();
        user.phone = document.getElementById('phone').value.trim();
        user.addressDetails = {
            street: document.getElementById('street').value.trim(),
            ward: document.getElementById('ward').value.trim(),
            district: document.getElementById('district').value.trim(),
            city: document.getElementById('city').value.trim()
        };
        user.address = `${user.addressDetails.street}, ${user.addressDetails.ward}, ${user.addressDetails.district}, ${user.addressDetails.city}`;
        
        // Cập nhật trong danh sách users
        const userIndex = users.findIndex(u => u.email === user.email);
        if (userIndex !== -1) {
            users[userIndex] = user;
            localStorage.setItem('users', JSON.stringify(users));
        }
        
        // Cập nhật currentUser
        localStorage.setItem('currentUser', JSON.stringify(user));
        
        console.log('✅ Đã lưu thông tin mới vào tài khoản');
    } catch (e) {
        console.error('Lỗi khi lưu thông tin:', e);
    }
}

// ===============================
// XỬ LÝ MÃ PIN BẢO MẬT
// ===============================
function showPinModal() {
    const currentUser = localStorage.getItem('currentUser');
    
    if (!currentUser) {
        alert('Vui lòng đăng nhập để thanh toán!');
        window.location.href = 'login.php';
        return;
    }
    
    // Kiểm tra nếu đang ở chế độ edit
    if (isEditing) {
        alert('Vui lòng lưu hoặc hủy thay đổi thông tin trước khi thanh toán!');
        return;
    }
    
    document.getElementById('pinModal').style.display = 'flex';
    document.getElementById('pinInput').value = '';
    document.getElementById('pinError').style.display = 'none';
    document.getElementById('pinInput').focus();
}

function closePinModal() {
    document.getElementById('pinModal').style.display = 'none';
    document.getElementById('pinInput').value = '';
    document.getElementById('pinError').style.display = 'none';
}

function verifyPinAndSubmit() {
    const pinInput = document.getElementById('pinInput').value;
    const pinError = document.getElementById('pinError');
    
    // Validate PIN format
    if (!/^[0-9]{6}$/.test(pinInput)) {
        pinError.textContent = '❌ Mã PIN phải là 6 chữ số!';
        pinError.style.display = 'block';
        return;
    }
    
    // Lấy thông tin user
    const currentUser = localStorage.getItem('currentUser');
    if (!currentUser) {
        alert('Phiên đăng nhập hết hạn. Vui lòng đăng nhập lại!');
        window.location.href = 'login.php';
        return;
    }
    
    try {
        const user = JSON.parse(currentUser);
        
        // Kiểm tra PIN
        if (user.pin !== pinInput) {
            pinError.textContent = '❌ Mã PIN không đúng! Vui lòng thử lại.';
            pinError.style.display = 'block';
            document.getElementById('pinInput').value = '';
            document.getElementById('pinInput').focus();
            return;
        }
        
        // PIN đúng - submit form
        closePinModal();
        document.getElementById('checkoutForm').submit();
        
    } catch (e) {
        console.error('Lỗi:', e);
        alert('Có lỗi xảy ra. Vui lòng thử lại!');
    }
}

// Cho phép nhấn Enter để submit PIN
document.addEventListener('DOMContentLoaded', function() {
    const pinInput = document.getElementById('pinInput');
    if (pinInput) {
        pinInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                verifyPinAndSubmit();
            }
        });
        
        // Chỉ cho phép nhập số
        pinInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    }
});
</script>

</body>
</html>
