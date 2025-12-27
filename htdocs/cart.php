<?php
session_start();

// Làm sạch giỏ hàng - gộp các sản phẩm trùng ID
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
  $cleanCart = [];
  foreach ($_SESSION['cart'] as $item) {
    $itemId = strval($item['id']);
    $found = false;
    
    foreach ($cleanCart as &$cleanItem) {
      if (strval($cleanItem['id']) === $itemId) {
        $cleanItem['quantity'] += $item['quantity'];
        $found = true;
        break;
      }
    }
    unset($cleanItem);
    
    if (!$found) {
      $cleanCart[] = $item;
    }
  }
  $_SESSION['cart'] = $cleanCart;
}

// Xóa toàn bộ giỏ hàng
if (isset($_GET['clear_cart'])) {
  $_SESSION['cart'] = [];
  header("Location: cart.php");
  exit;
}

// Xóa sản phẩm khỏi giỏ hàng
if (isset($_GET['remove'])) {
  $id = strval($_GET['remove']);
  foreach ($_SESSION['cart'] as $key => $item) {
    if (strval($item['id']) === $id) {
      unset($_SESSION['cart'][$key]);
    }
  }
  $_SESSION['cart'] = array_values($_SESSION['cart']); // Sắp xếp lại mảng
  header("Location: cart.php");
  exit;
}

// Cập nhật số lượng qua AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_qty_ajax'])) {
  header('Content-Type: application/json');
  $id = $_POST['id'];
  $qty = max(1, intval($_POST['quantity']));
  
  foreach ($_SESSION['cart'] as &$item) {
    if ($item['id'] == $id) {
      $item['quantity'] = $qty;
      break;
    }
  }
  
  // Tính lại tổng
  $total = 0;
  foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
  }
  
  echo json_encode(['success' => true, 'total' => $total]);
  exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Giỏ hàng | SAPHARY</title>
  
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
    header {
      background: #000;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      padding: 15px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-radius: 10px;
    }
    header .logo {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 24px;
      font-weight: bold;
      color: #fff;
      cursor: pointer;
    }
    header nav {
      display: flex;
      align-items: center;
      gap: 50px;
    }
    header nav a {
      text-decoration: none;
      color: #fff;
      font-weight: 500;
      padding: 8px 12px;
      transition: color 0.3s, border-bottom 0.3s;
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
      color: #e0aaff;
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
    .cart-container {
      max-width: 900px;
      margin: 50px auto;
      background: #fff;
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
    }
    th, td {
      padding: 12px;
      text-align: center;
      border-bottom: 1px solid #eee;
    }
    th {
      background: #f1f1f1;
      color: #555;
    }
    td img {
      width: 60px;
      border-radius: 6px;
    }
    .actions {
      text-align: right;
      margin-top: 20px;
    }
    .btn {
      display: inline-block;
      padding: 10px 18px;
      border-radius: 8px;
      text-decoration: none;
      color: white;
      font-weight: bold;
      transition: 0.3s;
    }
    .btn-checkout { 
      background: rgb(71, 31, 97); 
      margin-left: auto;
      display: inline-block;
    }
    .btn-checkout:hover { background: #9d73b8; }
    .btn-remove {
      background: #dc3545;
      color: white;
      border: none;
      padding: 6px 10px;
      border-radius: 6px;
      cursor: pointer;
    }
    .btn-remove:hover { background: #b92a37; }
    .empty {
      text-align: center;
      color: #666;
      font-size: 18px;
    }
  </style>
</head>
<body>

<header>
  <div class="logo" onclick="window.location.href='index.php'">
    <img src="img/logo.jpg" alt="Logo SAPHYRA" style="height: 50px; width: auto; border-radius: 50%; background-color: #fff; padding: 2px; box-shadow: 0 0 8px rgba(0,0,0,0.15);">
    <span>SAPHYRA</span>
  </div>
  <nav>
    <a href="index.php">Trang Chủ</a>
    <a href="sanpham.php">Sản Phẩm</a>
    <a href="gioithieu.php">Giới Thiệu</a>
    <a href="contact.php">Liên Hệ</a>
    <a href="cart.php" style="color:rgb(71, 31, 97);">Giỏ Hàng</a>
  </nav>
</header>

<div class="cart-container">
  <h2>🛒 Giỏ hàng của bạn</h2>

  <?php if (empty($_SESSION['cart'])): ?>
    <p class="empty">Giỏ hàng trống. <a href="sanpham.php">Tiếp tục mua sắm</a></p>
  <?php else: ?>
    <!-- Debug: Nút xóa toàn bộ giỏ hàng -->
    <div style="text-align:right;margin-bottom:10px;">
      <a href="?clear_cart=1" style="color:#dc3545;font-size:14px;text-decoration:none;" 
         onclick="return confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?')">
        🗑️ Xóa toàn bộ giỏ hàng
      </a>
    </div>
    <form method="POST">
      <table>
        <thead>
          <tr>
            <th>Hình ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Thành tiền</th>
            <th>Xóa</th>
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
            <td><img src="<?php echo $item['img']; ?>" alt="<?php echo $item['name']; ?>"></td>
            <td><?php echo $item['name']; ?></td>
            <td class="item-price"><?php echo number_format($item['price'], 0, ',', '.'); ?> VND</td>
            <td>
              <input type="number" 
                     class="qty-input" 
                     data-id="<?php echo $item['id']; ?>" 
                     data-price="<?php echo $item['price']; ?>"
                     value="<?php echo $item['quantity']; ?>" 
                     min="1" 
                     style="width:60px; text-align:center;"
                     onchange="updateQuantity(this)">
            </td>
            <td class="item-subtotal"><?php echo number_format($subtotal, 0, ',', '.'); ?> VND</td>
            <td><a href="cart.php?remove=<?php echo $item['id']; ?>" class="btn-remove" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">X</a></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="4" style="text-align:right;font-weight:bold;">Tổng cộng:</td>
            <td colspan="2" style="font-weight:bold;color:rgb(71, 31, 97);" id="cart-total"><?php echo number_format($total, 0, ',', '.'); ?> VND</td>
          </tr>
        </tfoot>
      </table>

      <div class="actions">
        <a href="checkout.php" class="btn btn-checkout">💳 Thanh toán</a>
      </div>
    </form>
  <?php endif; ?>
</div>

<script>
function updateQuantity(input) {
  const id = input.dataset.id;
  const quantity = parseInt(input.value);
  const price = parseInt(input.dataset.price);
  
  if (quantity < 1) {
    input.value = 1;
    return;
  }
  
  // Cập nhật subtotal của dòng này
  const row = input.closest('tr');
  const subtotalCell = row.querySelector('.item-subtotal');
  const newSubtotal = price * quantity;
  subtotalCell.textContent = new Intl.NumberFormat('vi-VN').format(newSubtotal) + ' VND';
  
  // Cập nhật tổng cộng
  updateTotal();
  
  // Gửi AJAX để cập nhật session
  fetch('cart.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: `update_qty_ajax=1&id=${id}&quantity=${quantity}`
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      console.log('Đã cập nhật giỏ hàng');
    }
  })
  .catch(error => console.error('Lỗi:', error));
}

function updateTotal() {
  let total = 0;
  document.querySelectorAll('.qty-input').forEach(input => {
    const price = parseInt(input.dataset.price);
    const quantity = parseInt(input.value);
    total += price * quantity;
  });
  
  document.getElementById('cart-total').textContent = 
    new Intl.NumberFormat('vi-VN').format(total) + ' VND';
}
</script>

</body>
</html>
