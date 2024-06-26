<?php
    require "class/Database.php";
    require "class/Product.php";
    require "class/Auth.php";
    require "inc/init.php";
    //$data = $_SESSION['data'];

    $nameErrors = "";
    $desErrors = "";
    $priceErrors = "";

    $name = "";
    $des = "";
    $price = "";

    $auth = new Auth();
    $auth->restrictAccess();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $name = $_POST['name'];
        $des= $_POST['des'];
        $price =  $_POST["price"];
        if(empty($name)) {
            $nameErrors ="Phải nhập tên";
        }

        if(empty($des)) {
            $desErrors ="Phải nhập mô tả";
        }

        if(empty($price)) {
            $priceErrors ="Phải nhập giá";
        }
        elseif($price%1000!=0){
            $priceErrors ="Giá phải chia hết cho 1000";
        }

        
        if(!$nameErrors && !$desErrors && !$priceErrors) {
            // $id = Product::getLastID($data) + 1;
            $conn =  new Database();
            $pdo = $conn->getConnect();
            $newProduct = Product::addOneProduct($pdo, $name, $des, $price);
            
            // Thêm sản phẩm mới vào danh sách sản phẩm đã có
            // $data[] = $newProduct;
            // var_dump($data);
            
            // Lưu danh sách sản phẩm mới vào session
            //$_SESSION['data'] = $data;
            header("location: Bai1.php");
        }

    }

?>

<?php require_once "inc/header.php" ?>

<!-- xử lý form trong cùng 1 file nên kh cần action -->
<h2 class="text-center">Thêm sản phẩm mới</h2>
<form class="w-50 m-auto" method="post">
    <div class="mb-3">
        <label for="name" class="form-label">Tên SP</label>
        <input class="form-control" id="name" name="name" value="<?=$name?>">
        <span class="text-danger fw-bold"><?=$nameErrors?></span>
    </div>
    <div class="mb-3">
        <label for="textarea" class="form-label">Description</label>
        <input class="form-control" id="des" name="des"  value="<?=$des?>">
        <span class="text-danger fw-bold"><?=$desErrors?></span>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Giá</label>
        <input class="form-control" id="price" name="price"  value="<?=$price?>">
        <span class="text-danger fw-bold"><?=$priceErrors?></span>
    </div>
    <button type="submit" class="btn btn-primary">Thêm SP</button>
    
</form>
<?php require_once "inc/footer.php" ?>
