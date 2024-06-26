<?php
require "../class/Database.php";
require "../class/Product.php";
require "../class/Category.php";
require "../class/Authadmin.php";
require "../inc/init.php";

// Khởi tạo kết nối đến CSDL
if (!isset($_GET["id"])) {
    die("Cần cung cấp thông tin sản phẩm");
}

// Lấy id từ URL và chuyển đổi thành số nguyên
$id = intval($_GET["id"]);

$db = new Database();
$pdo = $db->getConnect();
$product = Product::getOneProductByID($pdo, $id);
if(!$product) {
    die ("ID sản phẩm không hợp lệ !!!");
}

// Khởi tạo các biến lưu trữ thông tin và lỗi
$nameErrors = $desErrors = $priceErrors = $imgErrors = $categoryErrors = "";
$name = $description = $price = $Image = "";

// Xử lý khi nhấn nút submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';
    $Image = isset($_FILES['Image']['name']) ? $_FILES['Image']['name'] : '';

    // Kiểm tra và xử lý lỗi (có thể thêm kiểm tra định dạng ảnh, giá, vv.)
    if (empty($name)) {
        $nameErrors = "Phải nhập tên sản phẩm";
    }

    if (empty($description)) {
        $desErrors = "Phải nhập mô tả sản phẩm";
    }

    if (empty($price)) {
        $priceErrors = "Phải nhập giá sản phẩm";
    }

    if (empty($Image)) {
        $imgErrors = "Phải chọn hình ảnh sản phẩm";
    }

    // Nếu không có lỗi, thực hiện cập nhật sản phẩm
    if (!$nameErrors && !$desErrors && !$priceErrors && !$imgErrors && !$categoryErrors) {
        $updated = Product::updateProduct($pdo, $id, $name, $description, $price, $Image);

        if ($updated) {
            // Chuyển hướng đến trang product.php sau khi cập nhật thành công
            header("Location: product.php");
            exit; // Dừng kịch bản tiếp theo sau khi chuyển hướng
        } else {
            $errorMessage = "Đã xảy ra lỗi khi cập nhật sản phẩm.";
        }
    }
}
?>

<?php require_once "../inc/header.php" ?>
<main class="app-content">
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item">Danh sách sản phẩm</li>
            <li class="breadcrumb-item"><a href="#">Sửa sản phẩm</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Chỉnh sửa sản phẩm</h3>
                <div class="tile-body">
                    <h2 class="text-center">Chỉnh sửa sản phẩm</h2>
                    <form class="w-50 m-auto" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên SP</label>
                            <input class="form-control" id="name" name="name" value="<?= $product->name ?>">
                            <span class="text-danger fw-bold"><?= $nameErrors ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input class="form-control" id="description" name="description" value="<?= $product->description ?>">
                            <span class="text-danger fw-bold"><?= $desErrors ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Giá</label>
                            <input class="form-control" id="price" name="price" value="<?= $product->price ?>">
                            <span class="text-danger fw-bold"><?= $priceErrors ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="img" class="form-label">Hình ảnh</label>
                            <input class="form-control" type="file" id="Image" name="Image" value="<?= $product->Image ?>">
                            <span class="text-danger fw-bold"><?= $imgErrors ?></span>
                        </div>
                        <button class="btn btn-save" type="submit">Cập nhật sản phẩm</button>
                        <a class="btn btn-cancel" href="product.php">Hủy bỏ</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require_once "../inc/footer.php" ?>
