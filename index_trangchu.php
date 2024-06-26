<?php
require_once "class/Database.php";
require_once "class/Product.php";
require_once "class/Category.php";
require_once "class/Cart.php";
require_once "class/Auth.php";
require_once "inc/init.php";


$conn = new Database();
$pdo = $conn->getConnect();
$data_category = Category::getAll($pdo);
// Pagination
$page = isset($_GET["page"]) ? (int)$_GET['page'] : 1;
$ppp = 6;
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
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);



//$cart = new Cart();
$product_id = "";
$price = "";
// THÊM VÀO GIỎ HÀNG
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    Auth::restrictAccess();

    // Kiểm tra và lọc dữ liệu đầu vào
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
    $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);

    if ($product_id && $price !== false) {
        // Đảm bảo các giá trị hợp lệ trước khi chèn vào giỏ hàng
        Cart::insertCartItem($pdo, $_SESSION['id_user'], $product_id, $price, 1);
        
        // Chuyển hướng sau khi chèn thành công
        header("Location: cart.php");
        exit();
    } else {
        // Xử lý lỗi nếu dữ liệu không hợp lệ
        echo "Dữ liệu không hợp lệ.";
    }
}

?>
<?php require_once "inc/header.php"?>
  <!--pos home section-->
  <div class="pos_home_section">
                            <div class="row">
                               <!--banner slider start-->
                                <div class="col-12">
                                    <div class="banner_slider slider_two">
                                        <div class="slider_active owl-carousel">
                                            <div class="single_slider" style="background-image: url(assets/img/slider/slider1.jpg)">
                                                <div class="slider_content">
                                                    <div class="slider_content_inner">  
                                                        <h1>Minh Tâm Jewelry</h1>
                                                        <p>Đeo trang sức là cách thể hiện bạn mà không cần một lời nói nào. <br> Cuộc đời đó có bao lâu mà hững hờ, hãy cứ đeo trang sức như chưa từng được đeo.</p>
                                                        <a href="#">shop now</a>
                                                    </div>     
                                                </div>
                                            </div>
                                            <div class="single_slider" style="background-image: url(assets/img/slider/Slider2.jpg)">
                                                 <div class="slider_content">
                                                    <div class="slider_content_inner">  
                                                        <h1>Minh Tâm Jewelry</h1>
                                                        <p>Đeo trang sức là cách thể hiện bạn mà không cần một lời nói nào. <br> Cuộc đời đó có bao lâu mà hững hờ, hãy cứ đeo trang sức như chưa từng được đeo.</p>
                                                        <a href="#">shop now</a>
                                                    </div>     
                                                </div> 
                                            </div>
                                            <div class="single_slider" style="background-image: url(assets/img/slider/Slider3.jpg)">
                                                 <div class="slider_content">
                                                    <div class="slider_content_inner">  
                                                    <h1>Minh Tâm Jewelry</h1>
                                                        <p>Đeo trang sức là cách thể hiện bạn mà không cần một lời nói nào. <br> Cuộc đời đó có bao lâu mà hững hờ, hãy cứ đeo trang sức như chưa từng được đeo.</p>
                                                        <a href="#">shop now</a>
                                                    </div>     
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                    <!--banner slider start-->
                                </div>    
                            </div> 
                                  <!--brand logo strat--> 
                            <div class="brand_logo mb-60">
                                        <div class="block_title">
                                            <h3>Brands</h3>
                                        </div>
                                        <div class="row">
                                            <div class="brand_active owl-carousel">
                                                <div class="col-lg-2">
                                                    <div class="single_brand">
                                                        <a href="#"><img src="assets\img\brand\b1.png" alt=""></a>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="single_brand">
                                                        <a href="#"><img src="assets\img\brand\b2.png" alt=""></a>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="single_brand">
                                                        <a href="#"><img src="assets\img\brand\b3.png" alt=""></a>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="single_brand">
                                                        <a href="#"><img src="assets\img\brand\b5.png" alt=""></a>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="single_brand">
                                                        <a href="#"><img src="assets\img\brand\b6.png" alt=""></a>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="single_brand">
                                                        <a href="#"><img src="assets\img\brand\b7.png" alt=""></a>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="single_brand">
                                                        <a href="#"><img src="assets\img\brand\b8.png" alt=""></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>       
                                    <!--brand logo end-->        
                                </div>
                            </div>  
                        </div>
                        <!--pos home section end-->
                    </div>
                    <!--pos page inner end-->
                </div>
            </div>
            <!--pos page end--> 

<div class=" pos_home_section">
                            <div class="row pos_home">
                                <div class="col-lg-3 col-md-8 col-12">
                                   <!--sidebar banner-->
                                    <div class="sidebar_widget banner mb-35">
                                        <div class="banner_img mb-35">
                                            <a href="#"><img src="assets\img\banner\banner5.png" alt=""></a>
                                        </div>
                                        <div class="banner_img">
                                            <a href="#"><img src="assets\img\banner\banner6.png" alt=""></a>
                                        </div>
                                    </div>
                                    <!--sidebar banner end-->

                                    <!--categorie menu start-->
                                    <div class="sidebar_widget catrgorie mb-35">
                                        <h3>Categories</h3>
                                        <ul>
                                            <?php foreach($data_category as $category): ?>
                                                <li><a href="HienThiSanPham.php?id=<?= $category->id ?>"><?= $category->name ?></a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                    <!--categorie menu end-->
                                    <!--popular tags area-->
                                    <div class="sidebar_widget tags mb-35">
                                        <div class="block_title">
                                            <h3>popular tags</h3>
                                        </div>
                                        <div class="block_tags">
                                            <a href="#">ipod</a>
                                            <a href="#">sam sung</a>
                                            <a href="#">apple</a>
                                            <a href="#">iphone 5s</a>
                                            <a href="#">superdrive</a>
                                            <a href="#">shuffle</a>
                                            <a href="#">nano</a>
                                            <a href="#">iphone 4s</a>
                                            <a href="#">canon</a>
                                        </div>
                                    </div>
                                    <!--popular tags end-->

                                    <!--newsletter block start-->
                                    <div class="sidebar_widget newsletter mb-35">
                                        <div class="block_title">
                                            <h3>newsletter</h3>
                                        </div> 
                                        <form action="#">
                                            <p>Sign up for your newsletter</p>
                                            <input placeholder="Your email address" type="text">
                                            <button type="submit">Subscribe</button>
                                        </form>   
                                    </div>
                                    <!--newsletter block end--> 

                                    <!--sidebar banner-->
                                    <div class="sidebar_widget bottom ">
                                        <div class="banner_img">
                                            <a href="#"><img src="assets\img\banner\banner7.png" alt=""></a>
                                        </div>
                                    </div>
                                    <!--sidebar banner end-->
                                </div>
                                
                                <div class="col-lg-9 col-md-12">
                                <div class="block_title">
                                    <h3>Danh sách sản phẩm</h3>
                                </div>
                                <main>
    <div class="container-fluid p-2">
        <!-- Pagination -->
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="index.php?page=<?= max($page - 1, 1) ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php 
                $startPage = max(1, min($page - 1, $totalPages - 2));
                // Display pagination links
                for($i = $startPage; $i <= min($totalPages, $startPage + 2); $i++) : ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="index.php?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                    <a class="page-link" href="index.php?page=<?= min($page + 1, $totalPages) ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</main>
<?php
// Kiểm tra xem product_id có tồn tại trong URL không
if (isset($_GET['product_id'])) {
    // Lấy product_id từ URL
    $product_id = $_GET['product_id'];

    // Gọi hàm để lấy thông tin sản phẩm dựa trên product_id
    $product = Product::getProductDetailsById($pdo, $product_id);

    // Kiểm tra xem sản phẩm có tồn tại không
    if ($product) {
        // Hiển thị thông tin sản phẩm
?>
        <div class="row row-cols-1 row-cols-md-4 g-4">
            <div class="col-4">
                <div class="card">
                    <img src="img/<?= $product['Image'] ?>" class="card-img-top" alt="<?= $product['name'] ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $product['name'] ?></h5>
                        <p class="card-text"><?= $product['description'] ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="rating">
                                <span class="star">&#9733;</span>
                                <span class="star">&#9733;</span>
                                <span class="star">&#9733;</span>
                                <span class="star">&#9733;</span>
                                <span class="star">&#9733;</span>
                            </div>
                            <p class="card-text"><?= number_format($product['price'], 0, ',', '.') ?> VNĐ</p>
                        </div>
                        <div class="actions">
                                        <form method="post" style="display: inline;">
                                            <input type="hidden" name="action" value="add_to_cart">
                                            <input type="hidden" value="<?=$product['id']?>" name="product_id">
                                            <input type="hidden" value="<?=$product['price']?>" name="price">
                                            <button class="CartBtn" type="submit" name="add_to_cart">
  <span class="IconContainer"> 
    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512" fill="rgb(17, 17, 17)" class="cart"><path d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"></path></svg>
  </span>
  <p class="text">Add to Cart</p>
</button>
                                        </form>
                                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
    } else {
        echo "Không tìm thấy sản phẩm.";
    }
}
?>
<div class="block_title">
    <h3>Blog</h3>
</div>
<!--blog area start-->
<div class="blog_area blog_two">
                                <div class="row">   
                                    <div class="col-lg-4 col-md-6">
                                        <div class="single_blog">
                                            <div class="blog_thumb">
                                                <a href="blog-details.php"><img src="assets\img\blog\blog3.jpg" alt=""></a>
                                            </div>
                                            <div class="blog_content">
                                                <div class="blog_post">
                                                    <ul>
                                                        <li>
                                                            <a href="#">Tech</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <h3><a href="blog-details.php">When an unknown took a galley of type.</a></h3>
                                                <p>Distinctively simplify dynamic resources whereas prospective core competencies. Objectively pursue multidisciplinary human capital for interoperable.</p>
                                                <div class="post_footer">
                                                    <div class="post_meta">
                                                        <ul>
                                                            <li>Jun 20, 2018</li>
                                                            <li>3 Comments</li>
                                                        </ul>
                                                    </div>
                                                    <div class="Read_more">
                                                        <a href="blog-details.php">Read more  <i class="fa fa-angle-double-right"></i></a>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="single_blog">
                                            <div class="blog_thumb">
                                                <a href="blog-details.php"><img src="assets\img\blog\blog4.jpg" alt=""></a>
                                            </div>
                                            <div class="blog_content">
                                                <div class="blog_post">
                                                    <ul>
                                                        <li>
                                                            <a href="#">Men</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <h3><a href="blog-details.php">When an unknown took a galley of type.</a></h3>
                                                <p>Distinctively simplify dynamic resources whereas prospective core competencies. Objectively pursue multidisciplinary human capital for interoperable.</p>
                                                <div class="post_footer">
                                                    <div class="post_meta">
                                                        <ul>
                                                            <li>Jun 20, 2018</li>
                                                            <li>3 Comments</li>
                                                        </ul>
                                                    </div>
                                                    <div class="Read_more">
                                                        <a href="blog-details.php">Read more  <i class="fa fa-angle-double-right"></i></a>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="single_blog">
                                            <div class="blog_thumb">
                                                <a href="blog-details.php"><img src="assets\img\blog\blog1.jpg" alt=""></a>
                                            </div>
                                            <div class="blog_content">
                                                <div class="blog_post">
                                                    <ul>
                                                        <li>
                                                            <a href="#">Women</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <h3><a href="blog-details.php">When an unknown took a galley of type.</a></h3>
                                                <p>Distinctively simplify dynamic resources whereas prospective core competencies. Objectively pursue multidisciplinary human capital for interoperable.</p>
                                                <div class="post_footer">
                                                    <div class="post_meta">
                                                        <ul>
                                                            <li>Jun 20, 2018</li>
                                                            <li>3 Comments</li>
                                                        </ul>
                                                    </div>
                                                    <div class="Read_more">
                                                        <a href="blog-details.php">Read more  <i class="fa fa-angle-double-right"></i></a>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
    
                                </div>    
                            </div>
                        
            </div>
</div>
</div>
    <!--blog area end--> 
    <div class="ctn">
  <div class="item">
    <span class="icon"><img src="assets\img\logo\logo1.png"></span>
    <span class="text">KHÁCH HÀNG HÀI LÒNG</span>
    <span class="description">Đặt sự hài lòng của khách hàng là ưu tiên số 1 trong mọi suy nghĩ hành động</span>
  </div>
  <div class="item">
    <span class="icon"><img src="assets\img\logo\logo2.png"></span>
    <span class="text">CHẤT LƯỢNG CAO CẤP</span>
    <span class="description">Mọi sản phẩm đều được thiết kế và chế tác bởi các nghệ nhân hàng đầu</span>
  </div>
  <div class="item">
    <span class="icon"><img src="assets\img\logo\logo3.png"></span>
    <span class="text">ĐỔI TRẢ DỄ DÀNG</span>
    <span class="description">Đổi trả sản phẩm trong vòng 10 ngày. Hoàn tiền nếu không hài lòng</span>
  </div>
  <div class="item">
    <span class="icon"><img src="assets\img\logo\logo4.png"></span>
    <span class="text">HỖ TRỢ NHIỆT TÌNH</span>
    <span class="description">Tất cả các câu hỏi đều được các chuyên viên của LiLi tư vấn, giải đáp kỳ cạng</span>
  </div>
</div>
<?php require_once "inc/footer.php"?>
