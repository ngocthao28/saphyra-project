<?php
session_start();

// Cấu hình ByetHost
$db_host = 'sql207.byethost7.com';
$db_name = 'saphyra';
$db_user = 'b7_40550716';
$db_pass = '3@B_87zTD$g73fA';

$dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
} catch (PDOException $e) {
    die("DB connect failed: " . $e->getMessage());
}

// Kết nối mysqli (nếu cần dùng song song)
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
