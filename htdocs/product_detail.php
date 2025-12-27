<?php
// Giả lập dữ liệu sản phẩm (bạn có thể lấy từ DB sau này)
$product = [
  "id" => 1,
  "name" => "Bông Tai Tuyết",
  "price" => 899000,
  "desc" => "Đôi bông tai lấy cảm hứng từ hoa tuyết, thiết kế tinh tế với chất liệu bạc cao cấp, mang lại vẻ đẹp thanh lịch và sang trọng.",
  "img" => "img/bong tai 2.jpg"
];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $product['name']; ?> - SAPHARY</title>
  
  <!-- Favicon - Logo SAPHARY -->
  <link rel="icon" type="image/jpeg" href="img/logo.jpg">
  <link rel="shortcut icon" type="image/jpeg" href="img/logo.jpg">
  <link rel="apple-touch-icon" href="img/logo.jpg">
  
  <link rel="stylesheet" href="style.css/product_detail.css">
</head>
<body>
  <header>
    <div class="logo" onclick="window.location.href='index.php'">
      <img src="img/bong_tai.jpg" alt="Logo" />
      <span>SAPHARY</span>
    </div>
    <nav>
      <a href="index.php">Trang Chủ</a>
      <a href="sanpham.php">Sản Phẩm</a>
      <a href="#">Giới Thiệu</a>
      <a href="#">Liên Hệ</a>
    </nav>
  </header>

  <main class="product-detail">
    <div class="image-section">
      <img src="<?php echo $product['img']; ?>" alt="<?php echo $product['name']; ?>">
    </div>
    <div class="info-section">
      <h1><?php echo $product['name']; ?></h1>
      <p class="price"><?php echo number_format($product['price'], 0, ',', '.'); ?> VND</p>
      <p class="desc"><?php echo $product['desc']; ?></p>

      <div class="quantity">
        <label for="qty">Số lượng:</label>
        <input type="number" id="qty" value="1" min="1">
      </div>

      <div class="actions">
        <button class="add-to-cart">🛒 Thêm vào giỏ hàng</button>
        <button class="buy-now">💎 Mua ngay</button>
      </div>
    </div>
  </main>

  <!-- Phần đánh giá sản phẩm -->
  <section class="reviews-section">
    <div class="reviews-container">
      <h2>📝 Đánh giá sản phẩm</h2>
      
      <!-- Form viết đánh giá -->
      <div class="review-form-container">
        <h3>Viết đánh giá của bạn</h3>
        <form id="reviewForm" enctype="multipart/form-data">
          <!-- Chọn số sao -->
          <div class="rating-input">
            <label>Đánh giá của bạn:</label>
            <div class="stars-input">
              <span class="star" data-rating="1">☆</span>
              <span class="star" data-rating="2">☆</span>
              <span class="star" data-rating="3">☆</span>
              <span class="star" data-rating="4">☆</span>
              <span class="star" data-rating="5">☆</span>
            </div>
            <input type="hidden" id="ratingValue" name="rating" value="0" required>
          </div>

          <!-- Nhập nhận xét -->
          <div class="form-group">
            <label>Nhận xét của bạn:</label>
            <textarea id="reviewText" name="review" rows="4" placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm..." required></textarea>
          </div>

          <!-- Tải hình ảnh -->
          <div class="form-group">
            <label>Thêm hình ảnh (tùy chọn):</label>
            <input type="file" id="reviewImages" name="images[]" accept="image/*" multiple>
            <div id="imagePreview" class="image-preview"></div>
          </div>

          <button type="submit" class="btn-submit-review">Gửi đánh giá</button>
        </form>
      </div>

      <!-- Danh sách đánh giá -->
      <div class="reviews-list">
        <h3>Đánh giá từ khách hàng</h3>
        <div id="reviewsList"></div>
      </div>
    </div>
  </section>

  <footer>
    <p>© 2025 SAPHARY - Tinh Hoa Trang Sức Việt</p>
  </footer>

 <style>
/* CSS cho phần đánh giá */
.reviews-section {
  max-width: 1200px;
  margin: 40px auto;
  padding: 20px;
}

.reviews-container h2 {
  color: #331a43;
  text-align: center;
  margin-bottom: 30px;
  font-size: 28px;
}

.review-form-container {
  background: white;
  padding: 30px;
  border-radius: 15px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.1);
  margin-bottom: 40px;
}

.review-form-container h3 {
  color: #331a43;
  margin-bottom: 20px;
}

.rating-input {
  margin-bottom: 20px;
}

.rating-input label {
  display: block;
  margin-bottom: 10px;
  font-weight: 600;
  color: #333;
}

.stars-input {
  display: flex;
  gap: 5px;
  font-size: 40px;
  cursor: pointer;
}

.stars-input .star {
  color: #ddd;
  transition: all 0.2s;
}

.stars-input .star:hover,
.stars-input .star.active {
  color: #ffd700;
  transform: scale(1.1);
}

.form-group {
  margin-bottom: 20px;
}

.form-group label {
  display: block;
  margin-bottom: 8px;
  font-weight: 600;
  color: #333;
}

.form-group textarea {
  width: 100%;
  padding: 12px;
  border: 2px solid #e0e0e0;
  border-radius: 8px;
  font-size: 15px;
  font-family: Arial, sans-serif;
  resize: vertical;
  transition: border-color 0.3s;
}

.form-group textarea:focus {
  outline: none;
  border-color: #331a43;
}

.form-group input[type="file"] {
  width: 100%;
  padding: 10px;
  border: 2px dashed #e0e0e0;
  border-radius: 8px;
  cursor: pointer;
}

.image-preview {
  display: flex;
  gap: 10px;
  margin-top: 10px;
  flex-wrap: wrap;
}

.image-preview img {
  width: 100px;
  height: 100px;
  object-fit: cover;
  border-radius: 8px;
  border: 2px solid #e0e0e0;
}

.btn-submit-review {
  width: 100%;
  padding: 14px;
  background: linear-gradient(135deg, #331a43 0%, #1a0d21 100%);
  color: white;
  border: none;
  border-radius: 8px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s;
}

.btn-submit-review:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(51, 26, 67, 0.4);
}

.reviews-list {
  margin-top: 40px;
}

.reviews-list h3 {
  color: #331a43;
  margin-bottom: 20px;
  font-size: 22px;
}

.review-item {
  background: white;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.08);
  margin-bottom: 20px;
}

.review-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}

.review-user {
  font-weight: 600;
  color: #331a43;
}

.review-stars {
  color: #ffd700;
  font-size: 18px;
}

.review-date {
  color: #999;
  font-size: 13px;
}

.review-text {
  color: #555;
  line-height: 1.6;
  margin: 10px 0;
}

.review-images {
  display: flex;
  gap: 10px;
  margin-top: 10px;
  flex-wrap: wrap;
}

.review-images img {
  width: 120px;
  height: 120px;
  object-fit: cover;
  border-radius: 8px;
  cursor: pointer;
  transition: transform 0.3s;
}

.review-images img:hover {
  transform: scale(1.05);
}

.no-reviews {
  text-align: center;
  color: #999;
  padding: 40px;
  background: #f9f9f9;
  border-radius: 12px;
}
</style>

 <script>
// Xử lý chọn số sao
let selectedRating = 0;
const stars = document.querySelectorAll('.star');

stars.forEach(star => {
  star.addEventListener('click', function() {
    selectedRating = parseInt(this.getAttribute('data-rating'));
    document.getElementById('ratingValue').value = selectedRating;
    
    // Cập nhật hiển thị sao
    stars.forEach((s, index) => {
      if (index < selectedRating) {
        s.classList.add('active');
        s.textContent = '★';
      } else {
        s.classList.remove('active');
        s.textContent = '☆';
      }
    });
  });

  // Hover effect
  star.addEventListener('mouseenter', function() {
    const rating = parseInt(this.getAttribute('data-rating'));
    stars.forEach((s, index) => {
      if (index < rating) {
        s.textContent = '★';
      } else {
        s.textContent = '☆';
      }
    });
  });
});

// Reset khi rời chuột
document.querySelector('.stars-input').addEventListener('mouseleave', function() {
  stars.forEach((s, index) => {
    if (index < selectedRating) {
      s.textContent = '★';
    } else {
      s.textContent = '☆';
    }
  });
});

// Preview hình ảnh
document.getElementById('reviewImages').addEventListener('change', function(e) {
  const preview = document.getElementById('imagePreview');
  preview.innerHTML = '';
  
  const files = Array.from(e.target.files);
  files.forEach(file => {
    const reader = new FileReader();
    reader.onload = function(e) {
      const img = document.createElement('img');
      img.src = e.target.result;
      preview.appendChild(img);
    };
    reader.readAsDataURL(file);
  });
});

// Xử lý submit form đánh giá
document.getElementById('reviewForm').addEventListener('submit', function(e) {
  e.preventDefault();
  
  const rating = document.getElementById('ratingValue').value;
  const reviewText = document.getElementById('reviewText').value;
  const images = document.getElementById('reviewImages').files;
  
  if (rating == 0) {
    alert('Vui lòng chọn số sao đánh giá!');
    return;
  }
  
  // Lấy thông tin user
  const currentUser = JSON.parse(localStorage.getItem('currentUser'));
  if (!currentUser) {
    alert('Vui lòng đăng nhập để đánh giá!');
    window.location.href = 'login.php';
    return;
  }
  
  // Xử lý hình ảnh
  const imagePromises = [];
  for (let i = 0; i < images.length; i++) {
    const reader = new FileReader();
    const promise = new Promise((resolve) => {
      reader.onload = function(e) {
        resolve(e.target.result);
      };
      reader.readAsDataURL(images[i]);
    });
    imagePromises.push(promise);
  }
  
  Promise.all(imagePromises).then(imageDataUrls => {
    // Tạo đánh giá mới
    const review = {
      productId: <?php echo $product['id']; ?>,
      userName: currentUser.name,
      userEmail: currentUser.email,
      rating: parseInt(rating),
      text: reviewText,
      images: imageDataUrls,
      date: new Date().toISOString()
    };
    
    // Lưu vào localStorage
    const reviews = JSON.parse(localStorage.getItem('productReviews') || '[]');
    reviews.unshift(review);
    localStorage.setItem('productReviews', JSON.stringify(reviews));
    
    alert('✅ Cảm ơn bạn đã đánh giá!');
    
    // Reset form
    this.reset();
    selectedRating = 0;
    stars.forEach(s => {
      s.classList.remove('active');
      s.textContent = '☆';
    });
    document.getElementById('imagePreview').innerHTML = '';
    
    // Reload danh sách đánh giá
    loadReviews();
  });
});

// Load và hiển thị đánh giá
function loadReviews() {
  const reviews = JSON.parse(localStorage.getItem('productReviews') || '[]');
  const productReviews = reviews.filter(r => r.productId == <?php echo $product['id']; ?>);
  
  const reviewsList = document.getElementById('reviewsList');
  
  if (productReviews.length === 0) {
    reviewsList.innerHTML = '<div class="no-reviews">Chưa có đánh giá nào. Hãy là người đầu tiên đánh giá sản phẩm này!</div>';
    return;
  }
  
  reviewsList.innerHTML = productReviews.map(review => {
    const stars = '★'.repeat(review.rating) + '☆'.repeat(5 - review.rating);
    const date = new Date(review.date).toLocaleDateString('vi-VN');
    
    const imagesHtml = review.images.length > 0 
      ? `<div class="review-images">
          ${review.images.map(img => `<img src="${img}" alt="Review image">`).join('')}
         </div>`
      : '';
    
    return `
      <div class="review-item">
        <div class="review-header">
          <div>
            <div class="review-user">👤 ${review.userName}</div>
            <div class="review-stars">${stars}</div>
          </div>
          <div class="review-date">${date}</div>
        </div>
        <div class="review-text">${review.text}</div>
        ${imagesHtml}
      </div>
    `;
  }).join('');
}

// Load đánh giá khi trang load
document.addEventListener('DOMContentLoaded', loadReviews);

// Xử lý giỏ hàng
document.querySelector(".add-to-cart").addEventListener("click", () => {
  const qty = document.getElementById("qty").value;
  const product = {
    id: <?php echo $product['id']; ?>,
    name: "<?php echo $product['name']; ?>",
    price: <?php echo $product['price']; ?>,
    img: "<?php echo $product['img']; ?>"
  };

  fetch("add_to_cart.php", {
    method: "POST",
    headers: {"Content-Type": "application/x-www-form-urlencoded"},
    body: `id=${product.id}&name=${encodeURIComponent(product.name)}&price=${product.price}&quantity=${qty}&img=${encodeURIComponent(product.img)}`
  })
  .then(res => res.text())
  .then(data => {
    if (data === "success") {
      alert("Đã thêm sản phẩm vào giỏ hàng!");
    }
  });
});

document.querySelector(".buy-now").addEventListener("click", () => {
  const qty = document.getElementById("qty").value;
  const product = {
    id: <?php echo $product['id']; ?>,
    name: "<?php echo $product['name']; ?>",
    price: <?php echo $product['price']; ?>,
    img: "<?php echo $product['img']; ?>"
  };

  fetch("add_to_cart.php", {
    method: "POST",
    headers: {"Content-Type": "application/x-www-form-urlencoded"},
    body: `id=${product.id}&name=${encodeURIComponent(product.name)}&price=${product.price}&quantity=${qty}&img=${encodeURIComponent(product.img)}`
  })
  .then(res => res.text())
  .then(() => {
    window.location.href = "checkout.php";
  });
});
</script>
</body>
</html>
