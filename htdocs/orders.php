<?php
// Đọc file orders.json
$file = 'orders.json';

if (!file_exists($file)) {
  file_put_contents($file, '[]'); // Tạo file rỗng nếu chưa có
}

$jsonData = file_get_contents($file);
$orders = json_decode($jsonData, true);

// Sắp xếp đơn mới nhất lên đầu
usort($orders, function($a, $b) {
  return strtotime($b['date']) - strtotime($a['date']);
});
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Danh sách đơn hàng | SAPHARY</title>
  <style>
    body {
      font-family: "Segoe UI", sans-serif;
      background: #f4f6f8;
      margin: 0;
      padding: 0;
    }
    .container {
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
      text-align: left;
      border-bottom: 1px solid #eee;
    }
    th {
      background: #f9fafb;
      color: #555;
    }
    tr:hover {
      background: #fafafa;
    }
    .total {
      color: #c59d5f;
      font-weight: bold;
    }
    .btn {
      display: inline-block;
      padding: 8px 15px;
      background: #c59d5f;
      color: white;
      text-decoration: none;
      border-radius: 6px;
    }
    .btn:hover {
      background: #a47d3d;
    }
    .empty {
      text-align: center;
      color: #888;
      padding: 20px;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>📦 Danh sách đơn hàng</h2>

  <?php if (empty($orders)): ?>
    <p class="empty">Hiện chưa có đơn hàng nào.</p>
  <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Khách hàng</th>
          <th>Số điện thoại</th>
          <th>Địa chỉ</th>
          <th>Tổng tiền</th>
          <th>Thời gian</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($orders as $index => $order): ?>
          <tr>
            <td><?php echo $index + 1; ?></td>
            <td><?php echo htmlspecialchars($order['name']); ?></td>
            <td><?php echo htmlspecialchars($order['phone']); ?></td>
            <td><?php echo htmlspecialchars($order['address']); ?></td>
            <td class="total"><?php echo number_format($order['total'], 0, ',', '.'); ?> VND</td>
            <td><?php echo date("d/m/Y H:i", strtotime($order['date'])); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <div style="text-align:center; margin-top:25px;">
    <a href="sanpham.php" class="btn">← Quay lại trang sản phẩm</a>
  </div>
</div>

</body>
</html>
