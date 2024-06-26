<?php
require "../class/Database.php";
require "../class/Product.php";
require "../class/Category.php";
require "../class/User.php";
require "../class/product_category.php";
require "../class/Authadmin.php";
require "../inc/init.php";

$conn = new Database();
$pdo = $conn->getConnect();
$data = User::getAll($pdo);

$usernameErrors = "";
$passwordErrors = "";
$emailErrors = "";
$genderErrors = "";

$username = "";
$password = "";
$email = "";
$gender = "";

$id_user = User::getLastID($pdo);

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
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Add user to the database with hashed password
        $idpro = User::addOneUser($pdo, $username, $hashedPassword, $email, $gender);

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
            <li class="breadcrumb-item"><a href="#">Thêm người dùng</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Tạo mới người dùng</h3>
                <div class="tile-body">
                    <div class="row element-button">
                        <!-- Your buttons here -->
                    </div>
                    <h2 class="text-center">Thêm người dùng mới</h2>
                    <form class="w-50 m-auto" method="post" enctype="multipart/form-data">
                        
                        <div class="mb-3">
                            <label for="username" class="form-label">Tên người dùng</label>
                            <input class="form-control" id="username" name="username" value="<?= htmlspecialchars($username) ?>">
                            <span class="text-danger fw-bold"><?= $usernameErrors ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" value="<?= htmlspecialchars($password) ?>">
                            <span class="text-danger fw-bold"><?= $passwordErrors ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input class="form-control" id="email" name="email" value="<?= htmlspecialchars($email) ?>">
                            <span class="text-danger fw-bold"><?= $emailErrors ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Giới tính</label>
                            <input class="form-control" id="gender" name="gender" value="<?= htmlspecialchars($gender) ?>">
                            <span class="text-danger fw-bold"><?= $genderErrors ?></span>
                        </div>
                        <button class="btn btn-save" type="submit">Thêm người dùng</button>
                        <a class="btn btn-cancel" href="user.php">Hủy bỏ</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Your modals and scripts here -->

<?php require_once "../inc/footer.php" ?>
