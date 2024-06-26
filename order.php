<?php
$title = 'Cart page';
require_once "class/Database.php";
require "class/Product.php";
require "class/Cart.php";
require "class/Order.php";
require "class/CartItem.php";
require 'inc/init.php';

// Khởi tạo biến tổng tiền
$totalPrice = 0;
$i = 0;

// Tạo kết nối với cơ sở dữ liệu
$conn = new Database();
$pdo = $conn->getConnect();

// Lấy thông tin giỏ hàng của người dùng
//$data_order = Order::getAllOrders($pdo, $_SESSION['id_user']);

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
}

// Tính tổng tiền
foreach ($data_cart as $cart):
    $totalPrice += $cart->price * $cart->quality;
endforeach;
?>

<?php require 'inc/header.php'; ?>

<div class="container">
    <form method="post"> <!-- Di chuyển form ra khỏi vòng lặp -->
        <table class="table my-3">
            <a href="cart.php?action=empty" class="btn btn-danger mt-2">Empty Cart</a>
            <thead>
                <tr class="text-center">
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
                        <td><?= $cart->name ?></td>
                        <td><?= number_format($cart->price, 0, ',', '.') ?> VNĐ</td>
                        <td>
                            <input type="number" value="<?= $cart->quality ?>" name="qty" min="1" style="width: 100px" />
                            <input type="hidden" name="proid" value="<?= $cart->product_id ?>" /> <!-- Input ẩn cho product_id -->
                        </td>
                        <td>
                            <button type="submit" class="btn btn-danger" name="action" value="remove">Remove</button> <!-- Đặt giá trị "remove" cho input ẩn -->
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" class="text-right"><b>Tổng tiền:</b></td>
                    <td><b><?= number_format($totalPrice, 0, ',', '.') ?> VNĐ</b></td>
                </tr>
            </tbody>
        </table>
    </form>
</div>

<?php require 'inc/footer.php'; ?>
