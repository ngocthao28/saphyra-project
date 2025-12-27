<?php
// File test kết nối database
require_once 'config.php';

echo "<h2>🔍 Kiểm tra kết nối Database</h2>";

// Test 1: Kết nối PDO
echo "<h3>1. Kết nối PDO:</h3>";
try {
    echo "✅ Kết nối PDO thành công!<br>";
    echo "Database: <strong>$db_name</strong><br>";
    echo "Host: <strong>$db_host</strong><br>";
} catch (Exception $e) {
    echo "❌ Lỗi: " . $e->getMessage() . "<br>";
}

// Test 2: Kiểm tra bảng users
echo "<h3>2. Kiểm tra bảng 'users':</h3>";
try {
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() > 0) {
        echo "✅ Bảng 'users' đã tồn tại<br>";
        
        // Đếm số user
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM users");
        $result = $stmt->fetch();
        echo "📊 Số lượng users: <strong>" . $result['total'] . "</strong><br>";
        
        // Hiển thị cấu trúc bảng
        echo "<h4>Cấu trúc bảng users:</h4>";
        $stmt = $pdo->query("DESCRIBE users");
        echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th></tr>";
        while ($row = $stmt->fetch()) {
            echo "<tr>";
            echo "<td>" . $row['Field'] . "</td>";
            echo "<td>" . $row['Type'] . "</td>";
            echo "<td>" . $row['Null'] . "</td>";
            echo "<td>" . $row['Key'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "❌ Bảng 'users' CHƯA tồn tại!<br>";
        echo "<p style='color: red;'><strong>⚠️ Cần chạy file database_setup_byehost.sql trên phpMyAdmin của ByetHost!</strong></p>";
        echo "<ol>";
        echo "<li>Đăng nhập vào ByetHost Control Panel</li>";
        echo "<li>Mở phpMyAdmin từ menu</li>";
        echo "<li>Chọn database của bạn</li>";
        echo "<li>Click tab 'SQL'</li>";
        echo "<li>Copy nội dung file <strong>database_setup_byehost.sql</strong> và paste vào</li>";
        echo "<li>Click 'Go' để chạy</li>";
        echo "</ol>";
    }
} catch (Exception $e) {
    echo "❌ Lỗi: " . $e->getMessage() . "<br>";
    if (strpos($e->getMessage(), 'Unknown database') !== false) {
        echo "<p style='color: red;'><strong>⚠️ Database chưa được tạo hoặc cấu hình sai!</strong></p>";
        echo "<p>Hãy chạy file <strong>database_setup_byehost.sql</strong> trên phpMyAdmin của ByetHost.</p>";
    }
}

// Test 3: Kiểm tra các bảng khác
echo "<h3>3. Danh sách tất cả các bảng:</h3>";
try {
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (count($tables) > 0) {
        echo "<ul>";
        foreach ($tables as $table) {
            echo "<li>✅ $table</li>";
        }
        echo "</ul>";
    } else {
        echo "❌ Không có bảng nào trong database!<br>";
    }
} catch (Exception $e) {
    echo "❌ Lỗi: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<p><a href='register.php'>→ Đi đến trang Đăng ký</a></p>";
echo "<p><a href='login.php'>→ Đi đến trang Đăng nhập</a></p>";
?>
