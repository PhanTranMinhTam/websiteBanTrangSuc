<?php
if(!isset($_GET["id"])) {
    die("Cần cung cấp thông tin sản phẩm");
}

$id = $_GET["id"];
require "../class/Database.php";
require "../class/Product.php";
require "../class/Auth.php";
require "../inc/init.php";

$db = new Database();
$pdo = $db->getConnect();
$data = Product::getOneProductByID($pdo,$id);
if(!$data) {
    die ("ID sản phẩm không hợp lệ !!!");
}

// Kiểm tra xem yêu cầu có phải là POST không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Xóa sản phẩm
    $success = Product::deleteProduct($pdo, $id);

    if ($success) {
        // Nếu xóa thành công, chuyển hướng đến trang Bai1.php
        header("Location: Bai1.php");
        exit; // Đảm bảo kết thúc script sau khi chuyển hướng
    } else {
        echo "Có lỗi xảy ra khi xóa sản phẩm.";
    }
}
?>

<?php require_once "inc/header.php" ?>

<h1>Thông tin sản phẩm</h1>
<table class="table table-bordered table-success">
    <tr>
        <th class="table-dark">Mã sp</th>
        <td><?=$data->id?></td>
    </tr>
    <tr>
        <th class="table-dark">Tên sp</th>
        <td><?=$data->name?></td>
    </tr>
    <tr>
        <th class="table-dark">Giá</th>
        <td><?= number_format( $data->price, 0, ",", ".")?> VNĐ</td>
    </tr>
    <tr>
        <th class="table-dark">Description</th>
        <td><?=$data->description?></td>
    </tr>
</table>

<!-- Form để xác nhận xóa sản phẩm -->
<form method="post">
    <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')">Xóa sản phẩm</button>
</form>

