<?php
session_start();

// Đếm tổng số lượng sản phẩm trong giỏ hàng
$totalItems = 0;

if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $totalItems += isset($item['quantity']) ? intval($item['quantity']) : 1;
    }
}

// Trả về JSON
header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'totalItems' => $totalItems
]);
?>
