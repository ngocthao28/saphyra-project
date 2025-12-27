<?php
session_start();
require_once 'db.php'; // File kết nối database của bạn

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = 'Vui lòng nhập đầy đủ email và mật khẩu.';
        $_SESSION['old_email'] = $email;
        header('Location: login.php');
        exit;
    }

    try {
        // Đặc biệt: xử lý tài khoản admin cứng (nếu bạn vẫn muốn giữ)
        if ($email === 'admin@saphyra.com') {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify('admin123', $user['password'])) { // khuyến khích đổi pass admin và hash
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['full_name'] ?? 'Admin';
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['is_admin'] = true; // đánh dấu admin nếu cần
                header('Location: admin_dashboard.php');
                exit;
            }
        }

        // Đăng nhập user thường
        $stmt = $pdo->prepare("SELECT id, full_name, email, password, is_verified FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Có thể kiểm tra email đã verified chưa
            // if ($user['is_verified'] == 0) {
            //     $_SESSION['error'] = 'Tài khoản chưa được xác thực. Vui lòng kiểm tra email.';
            //     header('Location: login.php');
            //     exit;
            // }

            // Đăng nhập thành công
            $_SESSION['user_id']    = $user['id'];
            $_SESSION['user_name']  = $user['full_name'] ?? 'User';
            $_SESSION['user_email'] = $user['email'];

            $_SESSION['success'] = 'Đăng nhập thành công! Xin chào ' . htmlspecialchars($user['full_name']);
            header('Location: index.php');
            exit;
        } else {
            $_SESSION['error'] = 'Email hoặc mật khẩu không đúng!';
            $_SESSION['old_email'] = $email;
            header('Location: login.php');
            exit;
        }
    } catch (PDOException $e) {
        // Nên log lỗi thật, chỉ hiển thị thông báo chung cho user
        error_log($e->getMessage());
        $_SESSION['error'] = 'Lỗi hệ thống, vui lòng thử lại sau.';
        header('Location: login.php');
        exit;
    }
} else {
    // Nếu truy cập trực tiếp không qua POST
    header('Location: login.php');
    exit;
}
?>