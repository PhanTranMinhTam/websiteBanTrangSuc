<?php
require "../class/Database.php";
require "../class/Product.php";
require "../class/Category.php";
require "../class/product_category.php";
require "../class/Authadmin.php";
require "../inc/init.php";

$conn = new Database();
$pdo = $conn->getConnect();
$data = Category::getAll($pdo);

$nameErrors = "";
$desErrors = "";
$priceErrors = "";
$imgErrors = "";
$categoryErrors = "";

$name = "";
$description = "";
$price = "";
$img = "";

$id_product = Product::getLastID($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST["price"];
    $img = isset($_FILES['img']) ? $_FILES['img']['name'] : ''; // Check if 'img' index is set in $_FILES
    
    // Check if 'id' index is set in $_POST
    $idpro = isset($_POST['id']) ? $_POST['id'] : '';

    if (empty($name)) {
        $nameErrors = "Phải nhập tên";
    }

    if (empty($description)) {
        $desErrors = "Phải nhập mô tả";
    }

    if (empty($price)) {
        $priceErrors = "Phải nhập giá";
    }
    if (empty($img)) {
        $imgErrors = "Phải chọn hình ảnh";
    }

    // Check if at least one category is selected
    if (!isset($_POST['category']) || empty($_POST['category'])) {
        $categoryErrors = "Phải chọn ít nhất một loại sản phẩm";
    }

    if (!$nameErrors && !$desErrors && !$priceErrors && !$imgErrors && !$categoryErrors) {
        // Add product to database
        $idpro = Product::addOneProduct($pdo, $name, $description, $price, $img);
        var_dump($idpro);
        if(isset($_POST['category']))
        {
            foreach($_POST['category'] as $category_id){
                product_category::addOneProductCategory($pdo,$idpro,$category_id);
            }
        }
        if ($idpro) {
            // Redirect to product.php if product added successfully
            header("location: product.php");
            exit; // Stop further execution
        } else {
            // Handle error if product couldn't be added
            // For example, display an error message
            $errorMessage = "Đã xảy ra lỗi khi thêm sản phẩm.";
        }
    }
}
?>

<?php require_once "../inc/header.php" ?>
<main class="app-content">
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item">Danh sách sản phẩm</li>
            <li class="breadcrumb-item"><a href="#">Thêm sản phẩm</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Tạo mới sản phẩm</h3>
                <div class="tile-body">
                    <div class="row element-button">
                        <!-- Your buttons here -->
                    </div>
                    <h2 class="text-center">Thêm sản phẩm mới</h2>
                    <form class="w-50 m-auto" method="post" enctype="multipart/form-data">
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên SP</label>
                            <input class="form-control" id="name" name="name" value="<?= $name ?>">
                            <span class="text-danger fw-bold"><?= $nameErrors ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input class="form-control" id="description" name="description" value="<?= $description ?>">
                            <span class="text-danger fw-bold"><?= $desErrors ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Giá</label>
                            <input class="form-control" id="price" name="price" value="<?= $price ?>">
                            <span class="text-danger fw-bold"><?= $priceErrors ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="img" class="form-label">Hình ảnh</label>
                            <input class="form-control" type="file" id="img" name="img">
                            <span class="text-danger fw-bold"><?= $imgErrors ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Loại sản phẩm</label>
                            <?php foreach ($data as $category) : ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="<?= $category->id ?>" id="category_<?= $category->id ?>" name="category[]">
                                    <label class="formch-check-label" for="category_<?= $category->id ?>">
                                        <?= $category->name ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                            <span class="text-danger fw-bold"><?= $categoryErrors ?></span>
                        </div>
                        <button class="btn btn-save" type="submit">Thêm sản phẩm</button>
                        <a class="btn btn-cancel" href="product.php">Hủy bỏ</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Your modals and scripts here -->

<?php require_once "../inc/footer.php" ?>
