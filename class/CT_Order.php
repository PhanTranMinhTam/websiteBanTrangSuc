<?php
class CtOrder {
    public $id_order, $product_id, $quantity, $price;

    public static function addOrderItem($pdo, $id_order, $user_id) {
        try {
            // Kiểm tra giá trị hợp lệ của id_order
            if ($id_order === null) {
                throw new Exception("Invalid order ID.");
            }

            // Lấy thông tin đơn hàng từ bảng dathang
            $sql_order = "SELECT id_user FROM dathang WHERE id_order = :id_order";
            $stmt_order = $pdo->prepare($sql_order);
            $stmt_order->bindParam(":id_order", $id_order, PDO::PARAM_INT);
            $stmt_order->execute();
            $order_info = $stmt_order->fetch(PDO::FETCH_ASSOC);

            // Kiểm tra xem đơn hàng có tồn tại không
            if (!$order_info) {
                throw new Exception("Order not found.");
            }

            // Lấy thông tin sản phẩm từ giỏ hàng của người dùng
            $sql_cart = "SELECT product_id, quality, price_cart FROM cart WHERE user_id = :user_id";
            $stmt_cart = $pdo->prepare($sql_cart);
            $stmt_cart->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt_cart->execute();
            
            // Lặp qua từng sản phẩm trong giỏ hàng và thêm vào bảng chi tiết đặt hàng
            while ($row = $stmt_cart->fetch(PDO::FETCH_ASSOC)) {
                $product_id = $row['product_id'];
                $quantity = $row['quality'];
                $price = $row['price_cart'] * $quantity; // Tính giá cho mỗi sản phẩm
                
                // Chuẩn bị truy vấn SQL để chèn sản phẩm vào bảng chi tiết đặt hàng
                $sql_insert = "INSERT INTO ct_dathang (id_order, product_id, quantity, price) VALUES (:id_order, :product_id, :quantity, :price)";
                $stmt_insert = $pdo->prepare($sql_insert);
                if (!$stmt_insert) {
                    throw new Exception("Error preparing SQL statement");
                }
                $stmt_insert->bindParam(':id_order', $id_order, PDO::PARAM_INT);
                $stmt_insert->bindParam(':product_id', $product_id, PDO::PARAM_INT);
                $stmt_insert->bindParam(':quantity', $quantity, PDO::PARAM_INT);
                $stmt_insert->bindParam(':price', $price);
                $result = $stmt_insert->execute();
                if (!$result) {
                    throw new Exception("Error executing SQL statement");
                }
            }
    
            // Trả về true nếu thêm thành công
            return true;
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