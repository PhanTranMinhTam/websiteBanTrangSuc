<?php
require "../class/Database.php";
require "../class/Product.php";
require "../class/Category.php";
require "../class/User.php";
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
$user = User::getOneUserByID($pdo, $id);
if(!$user) {
    die ("ID sản phẩm không hợp lệ !!!");
}

// Khởi tạo các biến lưu trữ thông tin và lỗi
$usernameErrors = "";
$passwordErrors = "";
$emailErrors = "";
$genderErrors = "";

$username = "";
$password = "";
$email = "";
$gender = "";

// Xử lý khi nhấn nút submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST["email"];
    $gender = $_POST["gender"];
    $idpro = isset($_POST['id']) ? $_POST['id'] : '';

    if (empty($username)) {
        $usernameErrors = "Phải nhập username";
    }

    if (empty($password)) {
        $passwordErrors = "Phải nhập password";
    }

    if (empty($email)) {
        $emailErrors = "Phải nhập email";
    }
    if (empty($gender)) {
        $genderErrors = "Phải nhập giới tính";
    }

    if (!$usernameErrors && !$passwordErrors && !$emailErrors && !$genderErrors) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Add user to the database with hashed password
        $updated = User::updateUser($pdo,$id, $username, $password, $email, $gender);

        if ($idpro) {
            // Redirect to user.php if user added successfully
            header("location: user.php");
            exit; // Stop further execution
        } else {
            // Handle error if user couldn't be added
            $errorMessage = "Đã xảy ra lỗi khi thêm người dùng.";
        }
    }
}
?>

<?php require_once "../inc/header.php" ?>
<main class="app-content">
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item">Danh sách người dùng</li>
            <li class="breadcrumb-item"><a href="#">Sửa người dùng</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Chỉnh sửa người dùng</h3>
                <div class="tile-body">
                    <h2 class="text-center">Chỉnh sửa người dùng</h2>
                    <form class="w-50 m-auto" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <div class="mb-3">
                            <label for="username" class="form-label">Tên người dùng</label>
                            <input class="form-control" id="username" name="username" value="<?= $user->username ?>">
                            <span class="text-danger fw-bold"><?= $usernameErrors ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input class="form-control" id="password" name="password" value="<?= $user->password ?>">
                            <span class="text-danger fw-bold"><?= $passwordErrors ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input class="form-control" id="email" name="email" value="<?= $user->email ?>">
                            <span class="text-danger fw-bold"><?= $emailErrors ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <input class="form-control" id="gender" name="gender" value="<?= $user->gender ?>">
                            <span class="text-danger fw-bold"><?= $genderErrors ?></span>
                        </div>
                        <button class="btn btn-save" type="submit">Cập nhật người dùng</button>
                        <a class="btn btn-cancel" href="user.php">Hủy bỏ</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require_once "../inc/footer.php" ?>
