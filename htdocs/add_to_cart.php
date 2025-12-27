<?php
session_start();

// Nếu chưa có giỏ hàng thì tạo mảng rỗng
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

// Kiểm tra phương thức gửi dữ liệu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Nhận dữ liệu từ form
  $id = $_POST['id'] ?? '';
  $name = $_POST['name'] ?? '';
  $price = isset($_POST['price']) ? floatval($_POST['price']) : 0;
  $img = $_POST['img'] ?? '';
  $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

  if ($id && $name && $price > 0) {
    // Chuyển ID về cùng kiểu dữ liệu để so sánh
    $id = strval($id);
    
    // Làm sạch giỏ hàng - gộp các sản phẩm trùng ID
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
    
    // Kiểm tra xem sản phẩm đã có trong giỏ chưa
    $found = false;
    foreach ($_SESSION['cart'] as $key => &$item) {
      if (strval($item['id']) === $id) {
        $item['quantity'] += $quantity;
        $found = true;
        break;
      }
    }
    unset($item); // Giải phóng reference

    // Nếu chưa có thì thêm mới
    if (!$found) {
      $_SESSION['cart'][] = [
        'id' => $id,
        'name' => $name,
        'price' => $price,
        'img' => $img,
        'quantity' => $quantity
      ];
    }

    // Đếm tổng số lượng sản phẩm trong giỏ
    $totalItems = 0;
    foreach ($_SESSION['cart'] as $item) {
      $totalItems += $item['quantity'];
    }

    // Nếu gọi từ AJAX thì trả về JSON
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
      header('Content-Type: application/json');
      echo json_encode([
        'success' => true,
        'message' => 'Đã thêm sản phẩm vào giỏ hàng!',
        'totalItems' => $totalItems
      ]);
      exit;
    }

    // Nếu submit form thường thì không redirect, hiển thị thông báo
    $_SESSION['cart_message'] = 'Đã thêm sản phẩm vào giỏ hàng!';
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
  } else {
    echo "Thiếu dữ liệu sản phẩm!";
  }
} else {
  echo "Không có sản phẩm nào được gửi!";
}
?>
