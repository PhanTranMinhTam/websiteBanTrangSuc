<?php
$title = 'Home page';

require_once "class/Database.php";
require_once "class/Product.php";
require_once "class/Category.php";
require_once "class/Cart.php";
require_once "class/Auth.php";
require_once "inc/init.php";


$conn = new Database();
$pdo = $conn->getConnect();
$data_category = Category::getAll($pdo);
//$sapxep = Product::SapXepProductByPrice($pdo,$name);
// Pagination
$page = isset($_GET["page"]) ? (int)$_GET['page'] : 1;
$ppp = 4;
$offset = ($page - 1) * $ppp;

// Total number of products
$sqlTotal = "SELECT COUNT(*) AS TOTAL FROM PRODUCT";
$stmtTotal = $pdo->query($sqlTotal);
$totalProducts = $stmtTotal->fetchColumn();

// Calculate total pages
$totalPages = ceil($totalProducts / $ppp);

// Fetch products for the current page
$sql = "SELECT * FROM PRODUCT ORDER BY ID DESC LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":limit", $ppp, PDO::PARAM_INT);
$stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
$stmt->execute();
// $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
$data = Product::getProduct_Category($pdo, $_GET['id']);

//$cart = new Cart();
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

<?php require_once "inc/header.php"?>
<br>
<div class="block_title">
    <h3>Danh sách sản phẩm</h3>
</div>
<br>
<div class="row row-cols-1 row-cols-md-4 g-4">
  <?php foreach($data as $product): ?>
    <div class="col-3">
      <div class="card">
        <img src="img/<?=$product->Image?>" class="card-img-top" alt="<?=$product->name?>">
        <div class="card-body">
            <h5 class="card-title"><a href="product.php?id=<?= $product->id ?>"><?php echo $product->name ?></a></h5>
            <p class="card-text"><?=$product->description?></p>
            <div class="d-flex justify-content-between align-items-center">
                <div class="rating">
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                </div>
                <p class="card-text"><?=number_format($product->price, 0, ',', '.')?> VNĐ</p>
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
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<br>
<br>
<?php require_once "inc/footer.php"?>
