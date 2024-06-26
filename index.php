<?php
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
$sql = "SELECT * FROM PRODUCT ORDER BY price DESC LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":limit", $ppp, PDO::PARAM_INT);
$stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$product_id = "";
$price = "";

// Kiểm tra xem nút "Sắp xếp" đã được nhấn chưa
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'sapxep') {
    // Thực hiện hành động sắp xếp
    $sql = "SELECT * FROM PRODUCT ORDER BY price ASC LIMIT :limit OFFSET :offset";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":limit", $ppp, PDO::PARAM_INT);
    $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

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
                                            <a href="#">PNJ</a>
                                            <a href="#">DOJI</a>
                                            <a href="#">Minh Tam</a>
                                            <a href="#">Phong Thủy</a>
                                            <a href="#">Tierra Diamond</a>
                                            <a href="#">Skymond Luxury</a>
                                            <a href="#"> Huy Thanh</a>
                                            <a href="#">Phú Quý</a>
                                            <a href="#">Cartino</a>
                                            <a href="#">Thế giới Kim Cương</a>
                                            <a href="#">SJC</a>
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
    <div class="d-flex justify-content-between align-items-center">
    <div>
    <form method="post" style="display: inline;">
    <input type="hidden" name="action" value="sapxep">
    <button class="btn1 mb-2" type="submit">
    <span class="btn1-text-one">Giá giảm dần</span>
    <span class="btn1-text-two">Giá tăng dần</span>
</button>
</form>
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
                    for ($i = $startPage; $i <= min($totalPages, $startPage + 2); $i++) : ?>
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
</div>

<div class="row row-cols-1 row-cols-md-4 g-4">
                                <?php foreach($data as $product): ?>
                                    <div class="col-4 mb-3">
                                    <div class="card" style="filter: drop-shadow(1px 1px 20px #ADD8E6);">
                                        <img src="img/<?=$product['Image']?>" class="card-img-top" alt="<?=$product['name']?>">
                                        <div class="card-body">
                                        <h5 class="card-title"><a href="product.php?id=<?= $product['id'] ?>"><?php echo $product['name'] ?></a></h5>
                                        <p class="card-text"><?=$product['description']?></p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="rating">
                                            <span class="star">&#9733;</span>
                                            <span class="star">&#9733;</span>
                                            <span class="star">&#9733;</span>
                                            <span class="star">&#9733;</span>
                                            <span class="star">&#9733;</span>
                                            </div>
                                            <p class="card-text"><?=number_format($product['price'], 0, ',', '.')?> VNĐ</p>
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
                                <?php endforeach; ?>
                                </div>
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
                                                            <a href="#">Cartino</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <h3><a href="blog-details.php">Thương hiệu Cartino</a></h3>
                                                <p>Cartino được biết tới là thương hiệu trang sức cưới nổi tiếng nhất tại thành phố Hồ Chí Minh hiện nay. Ra đời từ năm 2006, bằng sự nỗ lực không ngừng trong việc sáng tạo và sản xuất ra những dòng trang sức độc đáo, sang trọng dành cho những khách hàng trẻ muốn thể hiện đẳng cấp của mình, Cartino đã có được những dấu ấn trên thị trường.</p>
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
                                                            <a href="#">SJC</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <h3><a href="blog-details.php">Thương hiệu SJC</a></h3>
                                                <p>SJC là Công ty Vàng Bạc Đá Quý Sài Gòn, được thành lập vào năm 1988 - doanh nghiệp nhà nước trực thuộc UBND TP. Hồ Chí Minh. Từ ngày 16/9/2010, doanh nghiệp này được đổi tên thành Công ty TNHH Một thành viên Vàng Bạc Đá Quý Sài Gòn.
Vàng miếng SJC vốn được biết tới là thương hiệu có bề dày lịch sử, uy tín, được cả thị trường trong nước và quốc tế...</p>
                                                <div class="post_footer">
                                                    <div class="post_meta">
                                                        <ul>
                                                            <li>Oc 23, 2023</li>
                                                            <li>23 Comments</li>
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
                                                <h3><a href="blog-details.php">Thương hiệu Bảo Tín Minh Châu</a></h3>
                                                <p>Bảo Tín Minh Châu là cái tên không còn xa lạ đối với những tín đồ trang sức tại Việt Nam. Với gần 30 năm xây dựng và phát triển, thương hiệu này không ngừng tiến ra thị trường với dòng sản phẩm thế mạnh là trang sức vàng 24K và vàng miếng. Sắc vàng ánh kim rất đậm của vàng nguyên chất hiện diện trên logo chính là sự thể hiện rõ nhất cho dòng sản phẩm đặc trưng này..</p>
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
