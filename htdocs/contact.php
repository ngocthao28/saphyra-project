<?php
require_once 'config.php';
include 'header.php'; // Dòng này sẽ tải tất cả code header ở trên

$success = "";
$error = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if($name == "" || $email == "" || $message == ""){
        $error = "Vui lòng nhập đầy đủ thông tin!";
    } else {
        // Câu lệnh INSERT của bạn đã đúng với các cột đã tạo
        $stmt = $pdo->prepare("INSERT INTO contacts(name, email, message, created_at) VALUES (?, ?, ?, NOW())");
        if($stmt->execute([$name, $email, $message])){
            $success = "Gửi thành công! Chúng tôi sẽ phản hồi sớm nhất.";
            // Xóa dữ liệu POST để tránh hiển thị lại trên form
            $_POST = array();
        } else {
            $error = "Lỗi hệ thống! Vui lòng thử lại.";
        }
    }
}
?>

<style>
    body {
    background-image: url('img/lien he.png');
    background-position: center center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
    background-color: #f8f9fa;
}

    /* 2. Style lại các hộp thông tin (Địa chỉ, Hotline, Giờ) */
    .info-box {
        background-color: #cec1d4ff;
        padding: 25px;
        border-radius: 10px;
        transition: all 0.3s ease-in-out;
        height: 100%; /* Giúp các hộp cao bằng nhau */
    }

    /* 3. Thêm hiệu ứng "nâng" lên khi hover, tạo cảm giác tương tác */
    .info-box:hover {
        transform: translateY(-10px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.1) !important;
    }

    /* 4. Style lại icon trong info-box cho đẹp hơn */
    .info-box .icon-wrapper {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        margin-bottom: 15px;
        font-size: 24px;
        transition: all 0.3s ease;
    }

    /* 5. Đặt màu nền riêng cho từng icon */
    .info-box.phone .icon-wrapper {
        background-color: rgba(var(--bs-primary-rgb), 0.1);
        color: var(--bs-primary);
    }
    .info-box.location .icon-wrapper {
        background-color: rgba(var(--bs-danger-rgb), 0.1);
        color: var(--bs-danger);
    }
    .info-box.clock .icon-wrapper {
        background-color: rgba(var(--bs-warning-rgb), 0.1);
        color: var(--bs-warning);
    }

    /* 6. Thêm hiệu ứng cho nút Gửi */
    .contact-form .btn-primary {
        transition: all 0.3s ease;
    }

    .contact-form .btn-primary:hover {
        transform: scale(1.02);
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15);
    }

    /* 7. Đảm bảo bản đồ chiếm 100% chiều cao của cột */
    .map-wrapper {
        height: 100%;
        min-height: 500px; /* Đảm bảo chiều cao tối thiểu trên di động */
    }

    @media (max-width: 991.98px) {
        /* Trên di động, giảm chiều cao bản đồ */
        .map-wrapper {
            min-height: 350px;
            margin-top: 2rem;
        }
    }
    h2.display-5 {
  color: #000000ff;
}
.contact-wrapper h2.display-5,
.contact-wrapper p {
  color: #ffffffff !important;
}


</style>


<div class="contact-wrapper container py-5">

    <div class="row mb-5">
        <div class="col-lg-8 offset-lg-2 text-center">
            <h2 class="display-5 fw-bold" data-aos="fade-down">
                Kết Nối Với Chúng Tôi
            </h2>
            <p class="fs-5 text-muted" data-aos="fade-up" data-aos-delay="100">
                Chúng tôi luôn sẵn sàng lắng nghe! Gửi thắc mắc của bạn qua biểu mẫu bên dưới hoặc liên hệ trực tiếp qua các thông tin được cung cấp.
            </p>
        </div>
    </div>

    <?php if($error): ?>
      <div class="alert alert-danger" data-aos="fade-up" data-aos-delay="200"><?=$error?></div>
    <?php endif; ?>

    <div class="row g-4 g-lg-5">

        <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
            <form method="POST" action="contact.php" class="contact-form p-4 p-md-5 shadow-lg rounded-3 bg-white">
                <h4 class="fw-bold mb-4">Gửi tin nhắn 📩</h4>
                <div class="form-floating mb-3">
                    <input type_="text" name="name" class="form-control" placeholder="Tên của bạn" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                    <label><i class="fa-solid fa-user me-2"></i> Họ & Tên</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control" placeholder="email của bạn" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    <label><i class="fa-solid fa-envelope me-2"></i> Email</label>
                </div>

                <div class="form-floating mb-3">
                    <textarea name="message" class="form-control" style="height: 150px;" placeholder="Nội dung" required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                    <label><i class="fa-solid fa-message me-2"></i> Nội dung</label>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-lg py-3 fw-bold">
                    <i class="fa-solid fa-paper-plane me-2"></i> Gửi liên hệ
                </button>

            </form>
        </div>

        <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
            <div class="shadow-lg rounded-3 overflow-hidden map-wrapper">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.669618118228!2d106.68006981533088!3d10.759976992332906!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f019438c615%3A0x610c3b0f7e4e3a3c!2zMTA1YSBI4buTIFRo4buLIEvhu7csIFBoxrDhu51uZyAxLCBRdeG6rW4gMTAsIFRow6BuaCBwaOG7kSBI4buTIENow60gTWluaCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1668580000000!5m2!1svi!2s"
                    style="border:0; width:100%; height:100%;"
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>

    </div>

    <div class="row g-4 mt-5">
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
            <div class="info-box phone text-center shadow-sm">
                <div class="icon-wrapper">
                    <i class="fa-solid fa-phone"></i>
                </div>
                <h5 class="fw-bold">Hotline</h5>
                <p class="mb-0"><a href="tel:0365376880" class="text-decoration-none">0365376880</a></p>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="250">
            <div class="info-box location text-center shadow-sm">
                <div class="icon-wrapper">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <h5 class="fw-bold">Địa chỉ</h5>
                <p class="mb-0">105A/38 Hồ Thị Kỷ, P.1, Q.10, TP. HCM</p>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
            <div class="info-box clock text-center shadow-sm">
                <div class="icon-wrapper">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <h5 class="fw-bold">Giờ mở cửa</h5>
                <p class="mb-0">8:00 - 22:00 (Mỗi ngày)</p>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="thankYouModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center py-4">
      <div class="modal-body">
        <i class="fa-solid fa-circle-check text-success fa-4x mb-3" data-aos="zoom-in"></i>
        <h4 class="modal-title fw-bold" id="modalLabel">Cảm ơn bạn!</h4>
        <p>Chúng tôi đã nhận được tin nhắn và sẽ phản hồi trong thời gian sớm nhất.</p>
        <button type="button" class="btn btn-success mt-3" data-bs-dismiss="modal">Tuyệt vời!</button>
      </div>
    </div>
  </div>
</div>


<?php 
// **LOGIC KÍCH HOẠT MODAL**
// Nếu biến $success có giá trị (tức là gửi form thành công)
// thì mới in đoạn script này ra để kích hoạt modal
if($success): 
?>
<script>
    // Chờ cho toàn bộ trang tải xong
    document.addEventListener("DOMContentLoaded", function() {
        // Tạo một đối tượng Modal của Bootstrap từ ID
        var myModal = new bootstrap.Modal(document.getElementById('thankYouModal'), {
            keyboard: false // Không cho đóng bằng phím Esc
        });
        // Hiển thị modal
        myModal.show();
    });
</script>
<?php 
endif; 
// Kết thúc phần script kích hoạt
?>


<?php include 'footer.php'; ?>