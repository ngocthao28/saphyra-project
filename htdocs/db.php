<?php
$host = "sql207.byethost7.com";
$dbname = "saphyra";
$user = "b7_40550716";
$pass = '3@B_87zTD$g73fA';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $pass
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Lỗi kết nối DB: " . $e->getMessage());
}
