<?php
require_once "class/Database.php";
require_once "class/Auth.php";
require_once "inc/init.php";

$nameErrors = "";
$emailErrors = "";
$passErrors = "";
$passconfirmErrors = "";
$result = "";

$name = "";
$email = "";
$pass = "";
$pass_confirm = "";
$gender = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $pass = $_POST['password'];
    $pass_confirm = $_POST['passconfirm'];

    // Hash the password
    $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

    // Validate the data
    $valid = true;

    // Validate name
    if (empty($name)) {
        $nameErrors = "Tên người dùng không được để trống.";
        $valid = false;
    }

    // Validate email
    if (empty($email)) {
        $emailErrors = "Địa chỉ email không được để trống.";
        $valid = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErrors = "Địa chỉ email không hợp lệ.";
        $valid = false;
    }

    // Validate password
    if (empty($pass)) {
        $passErrors = "Mật khẩu không được để trống.";
        $valid = false;
    }

    // Validate password confirmation
    if ($pass !== $pass_confirm) {
        $passconfirmErrors = "Mật khẩu và mật khẩu xác nhận không khớp.";
        $valid = false;
    }

    // If all data is valid, proceed with registration
    if ($valid) {
        $conn = new Database();
        $pdo = $conn->getConnect();

        $result = Auth::register($pdo, $name, $email, $hashedPassword, $pass_confirm, $gender);
        if ($result === true) {
            $result = "Đăng ký thành công! Hãy click vào <a href='login.php'>Login</a> để đăng nhập.";
        } else {
            $result = "Đăng ký thất bại. Vui lòng thử lại sau.";
        }
    }
}
?>

<?php require_once "inc/header.php" ?>

<div class="container">
            <div class="row main">
                <div class="main-login main-center">
                    <form class="form-horizontal" method="post" action="#">
                    <div class="panel-title text-center" >
                            <h1 class="title">Create Account</h1>
                        </div>
                        <div class="form-group">
                            <label for="name" class="cols-sm-2 control-label">Name:</label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon iconbk"><i class="fa fa-user fa" aria-hidden="true"></i><?= htmlspecialchars($nameErrors) ?></span>
                                    <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($name) ?>" placeholder="Nhập tên của bạn"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="cols-sm-2 control-label">Email:</label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon iconbk"><i class="fa fa-envelope fa" aria-hidden="true"></i><?= htmlspecialchars($emailErrors) ?></span>
                                    <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($email) ?>" placeholder="Nhập địa chỉ email của bạn"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="cols-sm-2 control-label">Password:</label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon iconbk"><i class="fa fa-lock fa-lg " aria-hidden="true"></i><?= htmlspecialchars($passErrors) ?></span>
                                    <input type="password" class="form-control" name="password" value="<?= htmlspecialchars($pass) ?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="confirm" class="cols-sm-2 control-label">Re-enter Password:</label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon iconbk"><i class="fa fa-lock fa-lg" aria-hidden="true"></i><?= htmlspecialchars($passconfirmErrors) ?></span>
                                    <input type="password" class="form-control" name="passconfirm" value="<?= htmlspecialchars($pass_confirm) ?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username" class="cols-sm-2 control-label">Gender:</label>
                            <div class="cols-sm-10">
                            <div class="input-group">
                                <select class="w-100 p-2" name="gender">
                                    <option value="Nam" <?= ($gender === 'Nam') ? 'selected' : '' ?>>Nam</option>
                                    <option value="Nữ" <?= ($gender === 'Nữ') ? 'selected' : '' ?>>Nữ</option>
                                </select>
                            </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <h4 class="text-success"><?= $result ?></h4>
                            <input type="submit" class="btn btn-primary btn-lg btn-block login-button"></input>
                        </div>
                        <div class="login-register">
                            <a href=" ">Already have an account?</a>
                         </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<?php require_once "inc/footer.php" ?>
