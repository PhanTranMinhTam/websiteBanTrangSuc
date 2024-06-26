<?php
class Order {
    public $id_order, $id_user, $ThanhTien;

    public static function insertOrderItem($pdo, $user_id) {
        try {
            // Truy vấn SQL để lấy tổng số tiền từ giỏ hàng của người dùng
            $sql_cart = "SELECT SUM(price_cart*quality) AS total_price FROM cart WHERE user_id = :user_id";
            $stmt_cart = $pdo->prepare($sql_cart);
            $stmt_cart->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt_cart->execute();
            
            // Lấy tổng số tiền trong giỏ hàng
            $total_price = $stmt_cart->fetch(PDO::FETCH_ASSOC)['total_price'];

            // Kiểm tra xem có tồn tại giỏ hàng cho người dùng không
            if ($total_price === null) {
                echo "Không có giỏ hàng cho người dùng này.";
                return false; // Trả về false nếu không có giỏ hàng
            }
            
            // Chèn thông tin đơn hàng vào bảng đặt hàng
            $sql_insert = "INSERT INTO dathang (id_user, ThanhTien) VALUES (:id_user, :ThanhTien)";
            $stmt_insert = $pdo->prepare($sql_insert);
            $stmt_insert->bindParam(":id_user", $user_id, PDO::PARAM_INT);
            $stmt_insert->bindParam(":ThanhTien", $total_price);
            
            // Thực thi truy vấn chèn
            if ($stmt_insert->execute()) {
                // Lấy id_order vừa được sinh ra
                $id_order = $pdo->lastInsertId();
                
                // Thông báo thành công
                echo "Thêm đơn hàng thành công!";
                
                // Trả về id_order để sử dụng khi thêm thông tin chi tiết đơn hàng vào bảng ct_dathang
                return $id_order;
            } else {
                echo "Lỗi khi thêm đơn hàng: " . $stmt_insert->errorInfo()[2];
                return false; // Trả về false nếu có lỗi khi chèn
            }
        } catch (PDOException $pdoe) {
            // Xử lý lỗi PDO
            echo "Lỗi PDO: " . $pdoe->getMessage();
            return false;
        } catch (Exception $e) {
            // Xử lý lỗi khác
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }
}