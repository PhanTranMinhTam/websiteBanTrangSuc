
<?php
require_once 'class/Database.php';
require_once 'class/Product.php';
require_once "inc/init.php";
require_once 'class/Auth.php';

$nameError= '';
$passError= '';
$name='';
$pass= '';



//&& isset($_POST['login'])
if ($_SERVER['REQUEST_METHOD'] == "POST"  ) {
    $name = $_POST['name'];
    $pass = $_POST['pass'];


    $conn= new Database();
    $pdo = $conn->getConnect();

    $result= Auth::testLogin($pdo, $name, $pass, $nameError, $passError);

    if ( $result === true)
    //if ( $result === true) //phải 3 dấu bằng mới đúng (===: so sánh cả giá trị và kiểu dữ liệu của hai biến.)
    {
        $_SESSION['logged_user'] = $name; //lấy tên lưu vào session, 1 là để ktra tồn tại (đã đn chưa), 2 là để hiển thị hello tam
        header("location: index.php");

    } else 
    {
        //echo "<script>alert('Đăng nhập thất bại');</script>";
        // Đăng nhập thất bại, xử lý thông báo lỗi nếu có
        if (isset($result['nameError'])) {
            $nameError = $result['nameError'];
        }
        // if (isset($result['passError'])) {
        //     $passError = $result['passError'];
        // }
        if (isset($result['Error'])) {
            //$Error = $result['Error'];
            echo $result['Error'];
        }
    }
    
        
}

?>

<?php require_once "inc/header.php"  ?>
		<div class="d-flex justify-content-center h-100">
			<div class="user_card">
				<div class="d-flex justify-content-center">
					<div class="brand_logo1_container">
						<img src="assets\img\logo\login.png" class="brand_logo1" alt="Logo" style="padding-top: -20px;">
					</div>
				</div>
				<div class="d-flex justify-content-center form_container">
					<form method= "post" class= " w-50 m-auto"> 
						<div class="input-group mb-3">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-user"></i><?= $nameError ?></span>
							</div>
							<input type="text" id= "name" name= "name" class="form-control input_user"  placeholder="username" value= "<?= $name ?>">
						</div>
						<div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-key"></i><?= $passError ?></span>
							</div>
							<input type="password" id= "pass" name= "pass" class="form-control input_pass" value="" placeholder="password">
						</div>
						<div class="d-flex justify-content-center mt-3 login_container">
				 	<button type="submit" name="button" class="btn login_btn">Login</button>
				   </div>
					</form>
				</div>
		
				<div class="mt-4">
					<div class="d-flex justify-content-center links">
						Don't have an account? <a href="#" class="ml-2">Sign Up</a>
					</div>
					<div class="d-flex justify-content-center links">
						<a href="#">Forgot your password?</a>
					</div>
				</div>
			</div>
		</div>
<?php require_once "inc/footer.php" ?>