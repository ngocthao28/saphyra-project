<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // Cấu hình SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'htnthao9@gmail.com';
    $mail->Password   = 'oggj dfqq qwie syac';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    $mail->CharSet    = 'UTF-8';
    
    // Bật debug để xem lỗi
    $mail->SMTPDebug = 2;
    $mail->Debugoutput = 'html';

    // Người gửi
    $mail->setFrom('htnthao9@gmail.com', 'SAPHARY Test');
    
    // Người nhận - THAY BẰNG EMAIL CỦA BẠN ĐỂ TEST
    $mail->addAddress('htnthao9@gmail.com', 'Test User');

    // Nội dung
    $mail->isHTML(true);
    $mail->Subject = 'Test Email - SAPHARY';
    $mail->Body    = '<h1>Test Email</h1><p>Nếu bạn nhận được email này, cấu hình đã thành công!</p>';

    $mail->send();
    echo '<div style="background: #d4edda; color: #155724; padding: 20px; border-radius: 8px; margin: 20px;">';
    echo '<h2>✅ Email đã được gửi thành công!</h2>';
    echo '<p>Kiểm tra hộp thư: htnthao9@gmail.com</p>';
    echo '</div>';
    
} catch (Exception $e) {
    echo '<div style="background: #f8d7da; color: #721c24; padding: 20px; border-radius: 8px; margin: 20px;">';
    echo '<h2>❌ Lỗi khi gửi email:</h2>';
    echo '<p>' . $mail->ErrorInfo . '</p>';
    echo '</div>';
}
?>
