<?php
class Cart {
    public $product_id, $user_id, $price, $quality;

    public static function getAll($pdo,$user_id) {
        $sql = "SELECT * FROM cart, product WHERE user_id = :user_id and product_id = id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        if($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Cart");
            return $stmt->fetchAll();
        }
    }
    public static function getProductPrice($pdo, $product_id) {
        try {
            // Chuẩn bị truy vấn SQL để lấy giá của sản phẩm từ cơ sở dữ liệu
            $sql = "SELECT price FROM product WHERE id = :product_id";
    
            // Chuẩn bị và thực thi truy vấn SQL
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(':product_id' => $product_id));
    
            // Lấy giá của sản phẩm từ kết quả truy vấn
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Kiểm tra nếu tồn tại giá và trả về giá nếu có
            if ($result && isset($result['price'])) {
                return $result['price'];
            } else {
                // Trả về null nếu không tìm thấy giá của sản phẩm
                return null;
            }
        } catch (PDOException $e) {
            // Xử lý lỗi: bạn có thể log lỗi hoặc hiển thị thông báo lỗi
            // echo "Lỗi cơ sở dữ liệu: " . $e->getMessage();
            return null; // Trả về null nếu có lỗi xảy ra
        }
    }
    
    public static function countItem($pdo, $user_id) {
        $sql = "SELECT COUNT(*) FROM cart WHERE user_id=:user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count;
    }

    public static function insertCartItem($pdo, $user_id, $product_id, $price_cart, $quality) {
        // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng của người dùng hay chưa
        if (self::isExistItem($pdo, $user_id, $product_id)) {
            // Nếu sản phẩm đã tồn tại, cập nhật hoặc tăng số lượng sản phẩm
            $sql_update = "UPDATE cart SET quality = quality + :quality WHERE user_id = :user_id AND product_id = :product_id";
            $stmt_update = $pdo->prepare($sql_update);
            $stmt_update->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt_update->bindParam(":product_id", $product_id, PDO::PARAM_INT);
            $stmt_update->bindParam(":quality", $quality, PDO::PARAM_INT);
            $stmt_update->execute();
        } else {
            // Nếu sản phẩm chưa tồn tại, chèn một bản ghi mới vào giỏ hàng
            $sql_insert = "INSERT INTO cart (product_id, user_id, price_cart, quality) VALUES (:product_id, :user_id, :price_cart, :quality)";
            $stmt_insert = $pdo->prepare($sql_insert);
            $stmt_insert->bindParam(":product_id", $product_id, PDO::PARAM_INT);
            $stmt_insert->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt_insert->bindParam(":price_cart", $price_cart);
            $stmt_insert->bindParam(":quality", $quality, PDO::PARAM_INT);
            $stmt_insert->execute();
        }
    
        // Trả về thông tin của mục vừa thêm vào giỏ hàng
        $sql_select_item = "SELECT * FROM cart WHERE user_id = :user_id AND product_id = :product_id";
        $stmt_select_item = $pdo->prepare($sql_select_item);
        $stmt_select_item->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt_select_item->bindParam(":product_id", $product_id, PDO::PARAM_INT);
        $stmt_select_item->execute();
        return $stmt_select_item->fetch(PDO::FETCH_ASSOC);
    }
    
    // Định nghĩa hàm kiểm tra sự tồn tại của sản phẩm trong giỏ hàng
    public static function isExistItem($pdo,$user_id, $product_id) {
        $sql_check = "SELECT COUNT(*) FROM cart WHERE user_id = :user_id AND product_id = :product_id";
        $stmt_check = $pdo->prepare($sql_check);
        $stmt_check->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt_check->bindParam(":product_id", $product_id, PDO::PARAM_INT);
        $stmt_check->execute();
        return $stmt_check->fetchColumn() > 0;
    }
    public static function deleteCartItem($pdo, $user_id, $product_id) {
        try {
            // Kiểm tra xem product_id có hợp lệ không
            if (!is_numeric($product_id) || $product_id <= 0) {
                return false; // Trả về false nếu product_id không hợp lệ
            }
    
            // Chuẩn bị truy vấn SQL để xóa sản phẩm khỏi giỏ hàng của user cụ thể
            $sql = "DELETE FROM cart WHERE user_id = :user_id AND product_id = :product_id LIMIT 1";
    
            // Chuẩn bị và thực thi truy vấn SQL
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->execute();
    
            // Trả về true nếu xóa thành công
            return true;
        } catch (PDOException $e) {
            // Xử lý lỗi: bạn có thể log lỗi hoặc hiển thị thông báo lỗi
            // echo "Lỗi cơ sở dữ liệu: " . $e->getMessage();
            return false; // Trả về false nếu có lỗi xảy ra
        }
    }
    
    
}