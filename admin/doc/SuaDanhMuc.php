<?php
require "../class/Database.php";
require "../class/Category.php";
//require "../class/Auth.php";
require "../inc/init.php";

// Khởi tạo kết nối đến CSDL
if (!isset($_GET["id"])) {
    die("Cần cung cấp thông tin danh mục");
}

// Lấy id từ URL và chuyển đổi thành số nguyên
$id = intval($_GET["id"]);

$db = new Database();
$pdo = $db->getConnect();
$category = Category::getOneCategoryByID($pdo, $id);
if(!$category) {
    die ("ID danh mục không hợp lệ !!!");
}

// Khởi tạo các biến lưu trữ thông tin và lỗi
$nameErrors = "";
$name = "";

// Xử lý khi nhấn nút submit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']) && $_POST['submit'] === 'submit') {
    // Lấy dữ liệu từ form
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    
    // Kiểm tra và xử lý lỗi
    if (empty($name)) {
        $nameErrors = "Phải nhập tên danh mục";
    }

    if (!$nameErrors) {
        $updated = Category::updateCategory($pdo, $id, $name);

        if ($updated) {
            // Chuyển hướng đến trang category.php sau khi cập nhật thành công
            header("Location:Category.php");
            exit;
        } else {
            $errorMessage = "Đã xảy ra lỗi khi cập nhật danh mục.";
        }
    }
}
?>

<?php require_once "../inc/header.php" ?>
<main class="app-content">
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item">Danh sách danh mục</li>
            <li class="breadcrumb-item"><a href="#">Sửa danh mục</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Chỉnh sửa danh mục</h3>
                <div class="tile-body">
                    <h2 class="text-center">Chỉnh sửa danh mục</h2>
                    <form class="w-50 m-auto" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $category->id ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên Danh Mục</label>
                            <input class="form-control" id="name" name="name" value="<?= $category->name ?>">
                            <span class="text-danger fw-bold"><?= $nameErrors ?></span>
                        </div>
                        <button class="btn btn-save" type="submit" name="submit" value="submit">Cập nhật danh mục</button>
                        <a class="btn btn-cancel" href="category.php">Hủy bỏ</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require_once "../inc/footer.php" ?>
