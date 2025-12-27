<?php
// File lưu trữ dữ liệu sản phẩm
// Trong thực tế nên dùng database, đây là giải pháp tạm thời

function getProducts($includeHidden = false) {
    $file = 'products.json';
    
    // Nếu file chưa tồn tại, tạo dữ liệu mặc định
    if (!file_exists($file)) {
        $defaultProducts = [
            [
                "id" => 1,
                "name" => "Bông Tai Nữ Tính",
                "price" => 100000,
                "quantity" => 50,
                "imgs" => ["img/bong tai 2.jpg", "img/bong tai 3.webp"],
                "desc" => "Thiết kế bông tai hình trái tim, tôn lên vẻ nữ tính và thanh lịch.",
                "hidden" => false
            ],
            [
                "id" => 2,
                "name" => "Dây Chuyền Tuyết",
                "price" => 300000,
                "quantity" => 30,
                "imgs" => ["img/day chuyen 4.jpg", "img/day chuyen 2.jpg"],
                "desc" => "Dây chuyền pha lê cao cấp phản chiếu ánh sáng lung linh.",
                "hidden" => false
            ],
            [
                "id" => 3,
                "name" => "Vòng Tay",
                "price" => 250000,
                "quantity" => 40,
                "imgs" => ["img/vong tay 5.jpg", "img/vong tay 3.jpg"],
                "desc" => "Vòng tay ngọc trai sang trọng, phù hợp với mọi phong cách.",
                "hidden" => false
            ]
        ];
        file_put_contents($file, json_encode($defaultProducts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
    
    $json = file_get_contents($file);
    $products = json_decode($json, true);
    
    // Lọc sản phẩm ẩn nếu không yêu cầu hiển thị
    if (!$includeHidden) {
        $products = array_filter($products, function($p) {
            return empty($p['hidden']);
        });
    }
    
    return array_values($products);
}

function saveProducts($products) {
    $file = 'products.json';
    return file_put_contents($file, json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function getProductById($id) {
    $products = getProducts();
    foreach ($products as $product) {
        if ($product['id'] == $id) {
            return $product;
        }
    }
    return null;
}

function updateProduct($id, $data) {
    $products = getProducts(true); // Lấy cả sản phẩm ẩn
    $updated = false;
    
    foreach ($products as $key => $product) {
        if ($product['id'] == $id) {
            if (isset($data['price'])) {
                $products[$key]['price'] = floatval($data['price']);
            }
            if (isset($data['quantity'])) {
                $products[$key]['quantity'] = intval($data['quantity']);
            }
            if (isset($data['name'])) {
                $products[$key]['name'] = $data['name'];
            }
            if (isset($data['desc'])) {
                $products[$key]['desc'] = $data['desc'];
            }
            if (isset($data['imgs'])) {
                $products[$key]['imgs'] = $data['imgs'];
            }
            if (isset($data['hidden'])) {
                $products[$key]['hidden'] = $data['hidden'];
            }
            $updated = true;
            break;
        }
    }
    
    if ($updated) {
        saveProducts($products);
    }
    
    return $updated;
}

function hideProduct($id) {
    return updateProduct($id, ['hidden' => true]);
}

function unhideProduct($id) {
    return updateProduct($id, ['hidden' => false]);
}

function getHiddenProducts() {
    $products = getProducts(true);
    return array_filter($products, function($p) {
        return !empty($p['hidden']);
    });
}

function addProduct($data) {
    $products = getProducts(true);
    
    // Tìm ID lớn nhất
    $maxId = 0;
    foreach ($products as $p) {
        if ($p['id'] > $maxId) {
            $maxId = $p['id'];
        }
    }
    
    $newProduct = [
        'id' => $maxId + 1,
        'name' => $data['name'],
        'price' => floatval($data['price']),
        'quantity' => intval($data['quantity']),
        'imgs' => $data['imgs'] ?? [],
        'desc' => $data['desc'],
        'hidden' => false
    ];
    
    // Thêm các trường mới nếu có
    if (isset($data['category'])) $newProduct['category'] = $data['category'];
    if (isset($data['material'])) $newProduct['material'] = $data['material'];
    if (isset($data['stone'])) $newProduct['stone'] = $data['stone'];
    if (isset($data['size'])) $newProduct['size'] = $data['size'];
    if (isset($data['weight'])) $newProduct['weight'] = $data['weight'];
    
    $products[] = $newProduct;
    saveProducts($products);
    
    return $newProduct;
}

function deleteProduct($id) {
    $products = getProducts(true); // Lấy cả sản phẩm ẩn
    $deleted = false;
    $deletedProduct = null;
    
    foreach ($products as $key => $product) {
        if ($product['id'] == $id) {
            $deletedProduct = $product;
            unset($products[$key]);
            $deleted = true;
            break;
        }
    }
    
    if ($deleted) {
        // Xóa ảnh sản phẩm nếu có
        if ($deletedProduct && isset($deletedProduct['imgs'])) {
            foreach ($deletedProduct['imgs'] as $img) {
                if (file_exists($img)) {
                    @unlink($img);
                }
            }
        }
        
        // Lưu lại danh sách sản phẩm
        saveProducts(array_values($products));
    }
    
    return $deleted;
}
