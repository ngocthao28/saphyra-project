</main> <footer>
    <div class="container text-center py-3">
        &copy; <?php echo date('Y'); ?> SAPHYRA. All rights reserved.
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>AOS.init({ duration: 900 });</script>

<?php if(isset($success) && $success): // Kiểm tra nếu biến $success tồn tại và là true ?>
<script>
document.getElementById('thankyouModal').style.display = 'flex';
setTimeout(() => {
    closePopup();
}, 3500);
</script>
<?php endif; ?>

<script>
function closePopup(){
  document.getElementById('thankyouModal').style.display = 'none';
}

// ===============================
// 🔍 TÌM KIẾM SẢN PHẨM (cho tất cả trang)
// ===============================
function searchProducts() {
    const input = document.getElementById('searchInput');
    if (!input) return; // Nếu không có ô tìm kiếm thì bỏ qua
    
    const searchTerm = input.value.toLowerCase().trim();
    
    // Tìm kiếm trong product-card (trang chủ)
    const productCards = document.querySelectorAll('.product-card');
    if (productCards.length > 0) {
        let foundCount = 0;
        productCards.forEach(card => {
            const title = card.querySelector('h3').textContent.toLowerCase();
            if (searchTerm === '' || title.includes(searchTerm)) {
                card.parentElement.style.display = 'block';
                foundCount++;
            } else {
                card.parentElement.style.display = 'none';
            }
        });
        
        let noResultMsg = document.getElementById('noResultMessage');
        if (foundCount === 0 && searchTerm !== '') {
            if (!noResultMsg) {
                noResultMsg = document.createElement('p');
                noResultMsg.id = 'noResultMessage';
                noResultMsg.style.textAlign = 'center';
                noResultMsg.style.color = '#999';
                noResultMsg.style.fontSize = '18px';
                noResultMsg.style.marginTop = '30px';
                noResultMsg.textContent = '❌ Không tìm thấy sản phẩm nào phù hợp';
                document.querySelector('.product-grid').appendChild(noResultMsg);
            }
        } else if (noResultMsg) {
            noResultMsg.remove();
        }
    }
    
    // Tìm kiếm trong card (trang sản phẩm)
    const cards = document.querySelectorAll('.card');
    if (cards.length > 0) {
        let foundCount = 0;
        cards.forEach(card => {
            const title = card.querySelector('h3').textContent.toLowerCase();
            if (searchTerm === '' || title.includes(searchTerm)) {
                card.style.display = 'block';
                foundCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        let noResultMsg = document.getElementById('noResultMessage');
        if (foundCount === 0 && searchTerm !== '') {
            if (!noResultMsg) {
                noResultMsg = document.createElement('p');
                noResultMsg.id = 'noResultMessage';
                noResultMsg.style.textAlign = 'center';
                noResultMsg.style.color = '#999';
                noResultMsg.style.fontSize = '18px';
                noResultMsg.style.marginTop = '30px';
                noResultMsg.style.gridColumn = '1 / -1';
                noResultMsg.textContent = '❌ Không tìm thấy sản phẩm nào phù hợp với "' + searchTerm + '"';
                document.querySelector('.grid').appendChild(noResultMsg);
            } else {
                noResultMsg.textContent = '❌ Không tìm thấy sản phẩm nào phù hợp với "' + searchTerm + '"';
            }
        } else if (noResultMsg) {
            noResultMsg.remove();
        }
    }
}
</script>

</body>
</html>