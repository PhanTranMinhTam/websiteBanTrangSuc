<?php
    require "class/Database.php";
    require "class/Product.php";
    require "class/Auth.php";
    require "inc/init.php";

    $nameErrors = "";
    $desErrors = "";
    $priceErrors = "";

    $name = "";
    $des = "";
    $price = "";

    //$auth = new Auth();
    //$auth->restrictAccess();

    // Kiểm tra xem đã truyền id của sản phẩm cần chỉnh sửa chưa
    if(!isset($_GET["id"])) {
        die("Cần cung cấp thông tin sản phẩm");
    }

    $id = $_GET["id"];

    // Lấy thông tin sản phẩm từ cơ sở dữ liệu
    $db = new Database();
    $pdo = $db->getConnect();
    $product = Product::getOneProductByID($pdo, $id);

    if(!$product) {
        die ("ID sản phẩm không hợp lệ !!!");
    }

    // Kiểm tra nếu form được gửi đi
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $name = $_POST['name'];
        $des = $_POST['des'];
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

        // Nếu không có lỗi, cập nhật thông tin sản phẩm
        if(!$nameErrors && !$desErrors && !$priceErrors) {
            $success = Product::updateProduct($pdo, $id, $name, $des, $price);
            if($success) {
                header("location: product.php?id=".$id);
            } else {
                die("Có lỗi xảy ra khi cập nhật sản phẩm");
            }
        }
    } else {
        // Nếu không phải là request POST, điền thông tin sản phẩm vào form
        $name = $product->name;
        $des = $product->description;
        $price = $product->price;
    }
?>

<?php require_once "inc/header.php" ?>

<h2 class="text-center">Chỉnh sửa sản phẩm</h2>
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
    <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
</form>

<?php require_once "inc/footer.php" ?>
