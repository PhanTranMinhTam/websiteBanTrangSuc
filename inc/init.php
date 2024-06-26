<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
// // Kiểm tra và khởi tạo $_SESSION['data'] nếu cần
// if (!isset($_SESSION['data'])) {
//     $conn = new Database();
//     $pdo =$conn->getConnect();
//     $_SESSION['data'] = Product::getAll($pdo);
// }

// // Kiểm tra và khởi tạo $_SESSION['cart'] nếu cần
// if (!isset($_SESSION['cart'])) {
//     $_SESSION['cart'] = [];
// }
?>
