<?php
$title = 'Cart page';
require_once "class/Database.php";
require "class/Product.php";
require "class/Cart.php";
require "class/CartItem.php";
require "inc/init.php";
require "class/Order.php";
require "class/CT_Order.php";

// Khởi tạo biến tổng tiền
$totalPrice = 0;
$i = 0;

// Tạo kết nối với cơ sở dữ liệu
$conn = new Database();
$pdo = $conn->getConnect();

// Lấy thông tin giỏ hàng của người dùng
$data_cart = Cart::getAll($pdo, $_SESSION['id_user']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Xử lý xóa sản phẩm khỏi giỏ hàng
    if (isset($_POST['action']) && $_POST['action'] == 'remove') {
        $product_id = filter_input(INPUT_POST, 'proid', FILTER_VALIDATE_INT);
        if ($product_id !== false) {
            $user_id = $_SESSION['id_user']; // Lấy user_id từ session
            // Gọi phương thức để xóa mục khỏi giỏ hàng
            if (Cart::deleteCartItem($pdo, $user_id, $product_id)) {
                // Chuyển hướng sau khi xóa thành công
                header("Location: cart.php");
                exit();
            } else {
                echo "Lỗi khi xóa sản phẩm khỏi giỏ hàng.";
            }
        } else {
            // Xử lý lỗi nếu product_id không hợp lệ
            echo "Product ID không hợp lệ.";
        }
    }

    // Xử lý đặt hàng
    if (isset($_POST['place_order'])) {
        // Tạo một đơn hàng mới
        $order_id = Order::insertOrderItem($pdo, $_SESSION['id_user']);
        
        if ($order_id) {
            // Thêm thông tin chi tiết đơn hàng
            $result = CtOrder::addOrderItem($pdo, $order_id, $_SESSION['id_user']);
            if ($result) {
                // Nếu thêm đơn hàng thành công, chuyển hướng người dùng đến trang chủ
                header("Location: index.php");
                exit();
            } else {
                echo "Đã xảy ra lỗi khi thêm thông tin chi tiết đơn hàng.";
            }
        } else {
            echo "Đã xảy ra lỗi khi tạo đơn hàng.";
        }
    }
}



// Tính tổng tiền
foreach ($data_cart as $cart):
    $totalPrice += $cart->price * $cart->quality;
endforeach;
?>

<?php require 'inc/header.php'; ?>

<div class="container">
    <form method="post">
        <table class="table table-bordered my-3">
            <thead class="text-center">
                <tr>
                    <th>No</th>
                    <th>Pro Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data_cart as $cart): ?>
                    <tr class="text-center">
                        <td><?= ++$i ?></td>
                        <td><?= htmlspecialchars($cart->name) ?></td>
                        <td><?= number_format($cart->price, 0, ',', '.') ?> VNĐ</td>
                        <td>
                            <input type="number" value="<?= htmlspecialchars($cart->quality) ?>" name="qty" min="1" style="width: 100px" />
                            <input type="hidden" name="proid" value="<?= htmlspecialchars($cart->product_id) ?>" />
                        </td>
                        <td>
                            <button type="submit" class="btn-remove" name="action" value="remove">Remove</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" class="text-right"><b>Tổng tiền:</b></td>
                    <td colspan="2"><b><?= number_format($totalPrice, 0, ',', '.') ?> VNĐ</b></td>
                </tr>
            </tbody>
        </table>
        <button type="submit" class="btn btn-success mb-3" name="place_order">Đặt hàng</button>
    </form>
</div>

<?php require 'inc/footer.php'; ?>
