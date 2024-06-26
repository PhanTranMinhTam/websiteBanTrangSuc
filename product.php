<?php
if(!isset($_GET["id"])) {
    die("Cần cung cấp thông tin sản phẩm");
}

$id = $_GET["id"];
require_once "class/Database.php";
require_once "class/Product.php";
require_once "class/Category.php";
require_once "class/Cart.php";
require_once "class/Auth.php";
require_once "inc/init.php";

$totalPrice = 0;
$product_id = "";
$conn = new Database();
$pdo = $conn->getConnect();
$data_category = Category::getAll($pdo);
$data = Product::getOneProductByID($pdo, $id);

if(!$data) {
    die ("ID không hợp lệ!!!");
}
$product_id = "";
$price = "";
// Kiểm tra nếu form "Thêm vào giỏ hàng" được gửi đi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'add_to_cart') {
    // Xử lý thêm vào giỏ hàng
    if (isset($_POST['add_to_cart'])) {
        $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
    
        if ($product_id && $price !== false) {
            Cart::insertCartItem($pdo, $_SESSION['id_user'], $product_id, $price, 1);
            header("Location: cart.php");
            exit();
        } else {
            echo "Dữ liệu không hợp lệ.";
        }
    }
}
?>

<?php require_once "inc/header.php" ?>
<div class="product-details">
  <div class="product-images">
    <div class="main-image">
      <img src="img/<?=$data->Image?>" alt="Product Image">
    </div>
    <div class="thumbnail-images">
      <div class="thumbnail">
        <img src="img/BONG5.jpg" alt="Thumbnail 1">
      </div>
      <div class="thumbnail">
        <img src="img/BONG8.jpg" alt="Thumbnail 2">
      </div>
      <div class="thumbnail">
        <img src="img/NHAN1.JPG" alt="Thumbnail 3">
      </div>
      <div class="thumbnail">
        <img src="img/NHAN3.jpg" alt="Thumbnail 4">
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
    <div class="actions">
                <form method="post" style="display: inline;">
                    <input type="hidden" name="action" value="add_to_cart">
                    <input type="hidden" value="<?=$product->id?>" name="product_id">
                    <input type="hidden" value="<?=$product->price?>" name="price">
                    <button class="CartBtn" type="submit" name="add_to_cart">
                        <span class="IconContainer"> 
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512" fill="rgb(17, 17, 17)" class="cart">
                                <path d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"></path>
                            </svg>
                        </span>
                        <p class="text">Add to Cart</p>
                    </button>
                </form>
            </div>
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
    <!-- Thêm liên kết chỉnh sửa -->
<!-- <a href="edit_product.php?id=<?= $data->id ?>" class="btn btn-primary">Chỉnh sửa sản phẩm</a> -->

<!-- Thêm liên kết xóa -->
<!-- <a href="remove_product.php?id=<?= $data->id ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')">Xóa sản phẩm</a> -->
  </div>
</div>

<?php require_once "inc/footer.php" ?>
