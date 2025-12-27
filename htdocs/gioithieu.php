<?php
require_once 'config.php';
include 'header.php'; // Tải header (menu, CSS...)
?>

<style>
    /* Làm cho phần "Giá Trị Cốt Lõi" giống các info-box */
    .value-box {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 10px;
        transition: all 0.3s ease-in-out;
        height: 100%;
        border: 0;
    }

    .value-box:hover {
        transform: translateY(-10px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.1) !important;
    }

    .value-box .icon-wrapper {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        margin-bottom: 20px;
        font-size: 24px;
        transition: all 0.3s ease;
    }

    /* Đặt màu nền riêng cho từng icon */
    .value-box.quality .icon-wrapper {
        background-color: rgba(var(--bs-primary-rgb), 0.1);
        color: var(--bs-primary);
    }
    .value-box.customer .icon-wrapper {
        background-color: rgba(var(--bs-success-rgb), 0.1);
        color: var(--bs-success);
    }
    .value-box.innovation .icon-wrapper {
        background-color: rgba(var(--bs-warning-rgb), 0.1);
        color: var(--bs-warning);
    }

    .cta-section {
        background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=600') no-repeat center center;
        background-size: cover;
        background-attachment: fixed;
    }

</style>


<div class="bg-light">
    <div class="container text-center py-5">
        <h1 class="display-4 fw-bold" data-aos="fade-down">
            Về Chúng Tôi
        </h1>
        <p class="fs-5 text-muted col-lg-8 mx-auto" data-aos="fade-up" data-aos-delay="100">
            Tìm hiểu thêm về câu chuyện, sứ mệnh và đội ngũ đằng sau thành công của Saphyra
        </p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5 align-items-center">
        
        <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
            <img src="img/nen 3.jpg" 
                 alt="Đội ngũ làm việc" 
                 class="img-fluid rounded-3 shadow-lg">
        </div>

        <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
            <h2 class="fw-bold mb-3">Câu Chuyện Của Chúng Tôi</h2>
            <p class="text-muted lh-lg">
                Bắt đầu từ một ý tưởng nhỏ vào năm 2005, Saphyra đã phát triển thành một thương hiệu được tin cậy, cung cấp [Sản phẩm/Dịch vụ của bạn] chất lượng cao cho hàng ngàn khách hàng trên cả nước.
            </p>
            <h4 class="fw-bold mt-4 mb-2">Sứ Mệnh</h4>
            <p class="text-muted lh-lg">
                Sứ mệnh của chúng tôi là [Viết sứ mệnh của bạn vào đây, ví dụ: "mang đến trải nghiệm mua sắm..."] và không ngừng đổi mới để phục vụ khách hàng tốt nhất.
            </p>
        </div>

    </div>
</div>

<div class="bg-light py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-5" data-aos="fade-up">Giá Trị Cốt Lõi</h2>
        <div class="row g-4">

            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="value-box quality text-center shadow-sm">
                    <div class="icon-wrapper">
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <h5 class="fw-bold">Chất Lượng</h5>
                    <p class="text-muted mb-0">Chúng tôi cam kết chất lượng cao nhất trong từng sản phẩm và dịch vụ.</p>
                </div>
            </div>

            <div class="col-md-4" data-aos="fade-up" data-aos-delay="250">
                <div class="value-box customer text-center shadow-sm">
                    <div class="icon-wrapper">
                        <i class="fa-solid fa-handshake"></i>
                    </div>
                    <h5 class="fw-bold">Khách Hàng</h5>
                    <p class="text-muted mb-0">Khách hàng là trọng tâm trong mọi quyết định và hành động của chúng tôi.</p>
                </div>
            </div>

            <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                <div class="value-box innovation text-center shadow-sm">
                    <div class="icon-wrapper">
                        <i class="fa-solid fa-lightbulb"></i>
                    </div>
                    <h5 class="fw-bold">Đổi Mới</h5>
                    <p class="text-muted mb-0">Luôn tìm tòi, sáng tạo và áp dụng công nghệ mới để cải tiến.</p>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="cta-section py-5 text-white">
    <div class="container text-center py-5" data-aos="zoom-in">
        <h2 class="display-5 fw-bold mb-4">Sẵn Sàng Trải Nghiệm?</h2>
        <p class="fs-5 mb-4 col-lg-8 mx-auto">
            Hãy để chúng tôi giúp bạn tìm thấy giải pháp hoàn hảo. Liên hệ ngay hoặc khám phá các sản phẩm tuyệt vời của chúng tôi.
        </p>
        <a href="contact.php" class="btn btn-primary btn-lg me-2 px-4 py-3 fw-bold">
            <i class="fa-solid fa-paper-plane me-2"></i> Liên Hệ Ngay
        </a>
        <a href="sanpham.php" class="btn btn-light btn-lg px-4 py-3 fw-bold">
            <i class="fa-solid fa-store me-2"></i> Xem Sản Phẩm
        </a>
    </div>
</div>


<?php include 'footer.php'; // Tải footer (thông tin, JS...) ?>