<?php
if(!isset($_GET["id"])) {
    die("Cần cung cấp thông tin sản phẩm");
}

$id = $_GET["id"];
require "../class/Database.php";
require "../class/Product.php";
require "../class/Authadmin.php";
require "../inc/init.php";

$db = new Database();
$pdo = $db->getConnect();
$data = Product::getOneProductByID($pdo,$id);
if(!$data) {
    die ("ID sản phẩm không hợp lệ !!!");
}

// Kiểm tra xem yêu cầu có phải là POST không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Xóa sản phẩm
    $success = Product::deleteProduct($pdo, $id);

    if ($success) {
        // Nếu xóa thành công, chuyển hướng đến trang Bai1.php
        header("Location: product.php");
        exit; // Đảm bảo kết thúc script sau khi chuyển hướng
    } else {
        echo "Có lỗi xảy ra khi xóa sản phẩm.";
    }
}
?>

<?php require_once "../inc/header.php" ?>

<main class="app-content">
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item">Danh sách sản phẩm</li>
            <li class="breadcrumb-item"><a href="#">Xóa sản phẩm</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Xóa sản phẩm</h3>
                <div class="tile-body">
                    <div class="row element-button">
                        <!-- Your buttons here -->
                    </div>
                    <form class="w-50 m-auto" method="post" enctype="multipart/form-data">
                    <div class="product-details">
                    <div class="product-images">
                        <div class="main-image">
                        <img src="../images/<?=$data->Image?>" alt="Product Image">
                        </div>
                        <div class="thumbnail-images">
                        <div class="thumbnail">
                            <img src="../images/BONG5.jpg" alt="Thumbnail 1">
                        </div>
                        <div class="thumbnail">
                            <img src="../images/BONG8.jpg" alt="Thumbnail 2">
                        </div>
                        <div class="thumbnail">
                            <img src="../images/NHAN1.JPG" alt="Thumbnail 3">
                        </div>
                        <div class="thumbnail">
                            <img src="../images/NHAN3.jpg" alt="Thumbnail 4">
                        </div>
                        </div>
                    </div>
                    <div class="product-info">
                        <h2><?= $data->name ?></h2>
                        <div class="rating">
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                        <a href="#">Write a review</a>
                        </div>
                        <p><?= $data->description ?></p>
                        <div class="price">
                        <span class="discounted-price"><?= number_format($data->price, 0, ",", ".") ?> VNĐ</span>
                        </div>
                        <div class="quantity">
                        <label for="quantity">quantity</label>
                        <input type="number" id="quantity" value="1" min="1">
                        </div>
                        <button class="add-to-cart">ADD TO CART</button>
                        <div class="product-options p-2">
                            <div class="size p-2">
                            <label for="size">SIZE</label>
                            <div class="select-container">
                                <select id="size">
                                    <option value="s">S</option>
                                    <option value="m">M</option>
                                    <option value="l">L</option>
                                </select>
                            </div>
                        </div>
                        <div class="color-options">
                            <span>CHOOSE COLOR</span>
                            <div class="colors">
                            <div class="color" style="background-color: blue;"></div>
                            <div class="color" style="background-color: yellow;"></div>
                            <div class="color" style="background-color: pink;"></div>
                            <div class="color" style="background-color: green;"></div>
                            </div>
                        </div>
                        </div>
                        <div class="stock-info">
                        <span>299 items</span>
                        <span>In stock</span>
                        </div>
                        <div class="share-options">
                        <span>Share On:</span>
                        <a href="#"><i class="fa fa-rss"></i></a>
                        <a href="#"><i class="fa fa-vk"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                        </div>
                            <!-- Form để xác nhận xóa sản phẩm -->
                        <form method="post">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')">Xóa sản phẩm</button>
                        </form>
                    </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Your modals and scripts here -->

<?php require_once "../inc/footer.php" ?>
