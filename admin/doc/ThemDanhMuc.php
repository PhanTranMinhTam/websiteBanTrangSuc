<?php
require "../class/Database.php";
require "../class/Product.php";
require "../class/Category.php";
require "../class/Authadmin.php";
require "../inc/init.php";

$conn = new Database();
$pdo = $conn->getConnect();
$data = Category::getAll($pdo);

$nameErrors = "";
$name = "";

$id_product = Category::getLastID($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];

    // Check if 'id' index is set in $_POST
    $id_product = isset($_POST['id']) ? $_POST['id'] : '';

    if (empty($name)) {
        $nameErrors = "Phải nhập tên";
    }
    if (!$nameErrors ) {
        // Add product to database
        $added = Category::addOneCategory($pdo, $name);

        if ($added) {
            // Redirect to product.php if product added successfully
            header("location: category.php");
            exit; // Stop further execution
        } else {
            // Handle error if product couldn't be added
            // For example, display an error message
            $errorMessage = "Đã xảy ra lỗi khi thêm danh mục.";
        }
    }
}
?>

<?php require_once "../inc/header.php" ?>
<main class="app-content">
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item">Danh sách danh mục</li>
            <li class="breadcrumb-item"><a href="#">Thêm danh mục</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Tạo mới danh mục</h3>
                <div class="tile-body">
                    <div class="row element-button">
                        <!-- Your buttons here -->
                    </div>
                    <h2 class="text-center">Thêm danh mục mới</h2>
                    <form class="w-50 m-auto" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên danh mục</label>
                            <input class="form-control" id="name" name="name" value="<?= $name ?>">
                            <span class="text-danger fw-bold"><?= $nameErrors ?></span>
                        </div>
                        <button class="btn btn-save" type="submit">Thêm danh mục</button>
                        <a class="btn btn-cancel" href="category.php">Hủy bỏ</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Your modals and scripts here -->

<?php require_once "../inc/footer.php" ?>
