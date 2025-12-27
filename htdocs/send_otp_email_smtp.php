<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

header('Content-Type: application/json');

// Nhận dữ liệu từ POST
$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'] ?? '';
$otp = $data['otp'] ?? '';
$name = $data['name'] ?? 'Khách hàng';

if (!$email || !$otp) {
    echo json_encode(['success' => false, 'message' => 'Thiếu thông tin!']);
    exit;
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Email không hợp lệ!']);
    exit;
}

$mail = new PHPMailer(true);

try {
    // ===== CẤU HÌNH SMTP - THAY ĐỔI THÔNG TIN CỦA BẠN =====
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'htnthao9@gmail.com';        // ⚠️ THAY BẰNG EMAIL CỦA BẠN
    $mail->Password   = 'oggj dfqq qwie syac';  // ⚠️ THAY BẰNG APP PASSWORD
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;
    $mail->CharSet    = 'UTF-8';

    // Người gửi
    $mail->setFrom('htnthao9@gmail.com', 'SAPHARY');  // ⚠️ THAY BẰNG EMAIL CỦA BẠN
    
    // Người nhận
    $mail->addAddress($email, $name);

    // Nội dung email
    $mail->isHTML(true);
    $mail->Subject = 'Mã xác thực đặt lại mật khẩu - SAPHARY';
    $mail->Body    = "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <style>
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                color: #333;
            }
            .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                background: #f9f9f9;
            }
            .header {
                background: linear-gradient(135deg, #331a43 0%, #1a0d21 100%);
                color: white;
                padding: 30px;
                text-align: center;
                border-radius: 10px 10px 0 0;
            }
            .content {
                background: white;
                padding: 30px;
                border-radius: 0 0 10px 10px;
            }
            .otp-code {
                background: #f0f0f0;
                border: 2px dashed #331a43;
                padding: 20px;
                text-align: center;
                font-size: 32px;
                font-weight: bold;
                color: #331a43;
                letter-spacing: 8px;
                margin: 20px 0;
                border-radius: 8px;
            }
            .warning {
                background: #fff3cd;
                border-left: 4px solid #ffc107;
                padding: 15px;
                margin: 20px 0;
                border-radius: 4px;
            }
            .footer {
                text-align: center;
                color: #666;
                font-size: 12px;
                margin-top: 20px;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>🔐 SAPHARY</h1>
                <p>Đặt lại mật khẩu</p>
            </div>
            <div class='content'>
                <p>Xin chào <strong>$name</strong>,</p>
                
                <p>Bạn đã yêu cầu đặt lại mật khẩu cho tài khoản SAPHARY của mình.</p>
                
                <p>Mã xác thực của bạn là:</p>
                
                <div class='otp-code'>$otp</div>
                
                <div class='warning'>
                    <strong>⚠️ Lưu ý:</strong>
                    <ul style='margin: 10px 0; padding-left: 20px;'>
                        <li>Mã này có hiệu lực trong <strong>10 phút</strong></li>
                        <li>Không chia sẻ mã này với bất kỳ ai</li>
                        <li>Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này</li>
                    </ul>
                </div>
                
                <p>Trân trọng,<br><strong>Đội ngũ SAPHARY</strong></p>
            </div>
            <div class='footer'>
                <p>© 2025 SAPHARY - Trang sức cao cấp</p>
                <p>Email này được gửi tự động, vui lòng không trả lời.</p>
            </div>
        </div>
    </body>
    </html>
    ";

    $mail->send();
    echo json_encode([
        'success' => true, 
        'message' => 'Email đã được gửi thành công đến ' . $email
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => 'Không thể gửi email: ' . $mail->ErrorInfo
    ]);
}
?>
