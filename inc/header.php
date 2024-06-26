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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Xử lý xóa sản phẩm khỏi giỏ hàng
        if (isset($_POST['action']) && $_POST['action'] == 'remove') {
            $product_id = filter_input(INPUT_POST, 'proid', FILTER_VALIDATE_INT);
            if ($product_id !== false) {
                $user_id = $_SESSION['id_user']; // Lấy user_id từ session
                // Gọi phương thức để xóa mục khỏi giỏ hàng
                if (Cart::deleteCartItem($pdo, $user_id, $product_id)) {
                    // Chuyển hướng sau khi xóa thành công
                    header("Location: cart.php");
                    exit();
                } else {
                    echo "Lỗi khi xóa sản phẩm khỏi giỏ hàng.";
                }
            } else {
                // Xử lý lỗi nếu product_id không hợp lệ
                echo "Product ID không hợp lệ.";
            }
        }
    }
    if(!empty($_SESSION['id_user'])){
        $data_cart = Cart::getAll($pdo, $_SESSION['id_user']);
        $count = Cart::countItem($pdo, $_SESSION['id_user']);
    
        // Thực hiện các thao tác khác (ví dụ: tìm kiếm sản phẩm)
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])) {
            // Lấy tên sản phẩm từ biểu mẫu
            $searchTerm = $_POST["search"];
    
            // Gọi hàm tìm kiếm sản phẩm
            $timkiem = Product::findProductByName($pdo, $searchTerm);
    
            // Hiển thị kết quả tìm kiếm (chỉ hiển thị một sản phẩm)
            if ($timkiem) {
                // Chuyển hướng đến trang chi tiết sản phẩm và chuyển dữ liệu sản phẩm qua session hoặc tham số URL
                $product_id = $timkiem["id"]; // Giả sử cột id là cột chứa ID sản phẩm trong cơ sở dữ liệu
                header("Location: index_trangchu.php?product_id=$product_id");
                exit(); // Kết thúc kịch bản sau khi chuyển hướng
            } else {
                // Hiển thị thông báo nếu không tìm thấy sản phẩm
                echo "Không tìm thấy sản phẩm với từ khóa '$searchTerm'";
            }
        }
        // Hiển thị giỏ hàng và tính tổng giá
        foreach ($data_cart as $cart):
            $totalPrice += $cart->price * $cart->quality;
        endforeach;
    } 
?>

<!doctype html>
<html class="no-js" lang="zxx">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Minh Tam - Jewelry 💍</title>
        <title>My Awesome Login Page</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets\img\favicon1.png">
		
		<!-- all css here -->
        <link rel="stylesheet" href="assets\css\bootstrap.min.css">
        <link rel="stylesheet" href="assets\css\plugin.css">
        <link rel="stylesheet" href="assets\css\bundle.css">
        <link rel="stylesheet" href="assets\css\style1.css">
        <link rel="stylesheet" href="assets\css\responsive.css">
        <link rel="stylesheet" href="assets\css\style_logo.css">
        <link rel="stylesheet" href="assets\css\style_product.css">
        <link rel="stylesheet" href="assets\css\style.css">
        <link rel="stylesheet" href="assets\css\style_register.css">
        <script src="assets\js\vendor\modernizr-2.8.3.min.js"></script>
    </head>
    <body>
            <!-- Add your site or application content here -->
            
            <!--pos page start-->
            <div class="pos_page">
                <div class="container">
                   <!--pos page inner-->
                    <div class="pos_page_inner">  
                       <!--header area -->
                        <div class="header_area">
                               <!--header top--> 
                                <div class="header_top">
                                   <div class="row align-items-center">
                                        <div class="col-lg-6 col-md-6">
                                           <div class="switcher">
                                                <ul>
                                                    <li class="languages"><a href="#"><img src="assets\img\logo\fontlogo.jpg" alt=""> English <i class="fa fa-angle-down"></i></a>
                                                        <ul class="dropdown_languages">
                                                            <li><a href="#"><img src="assets\img\logo\fontlogo.jpg" alt=""> English</a></li>
                                                            <li><a href="#"><img src="assets\img\logo\fontlogo2.jpg" alt=""> French </a></li>
                                                        </ul>   
                                                    </li> 

                                                    <li class="currency"><a href="#"> Currency : $ <i class="fa fa-angle-down"></i></a>
                                                        <ul class="dropdown_currency">
                                                            <li><a href="#"> Dollar (USD)</a></li>
                                                            <li><a href="#"> Euro (EUR)  </a></li>
                                                        </ul> 
                                                    </li> 
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="header_links">
                                                <ul>
                                                    <li><a href="contact.php" title="Contact">Contact</a></li>
                                                    <li><a href="../DoAn_TrangSuc_Sua/admin/index.php" title="admin">Admin</a></li>
                                                    <li class="nav-item">
                                                    <a class="nav-link active" aria-current="page" href="register.php">Register</a>
                                                </li>
                                                <!-- Người dùng có đăng nhập hay không  -->
                                                <?php if (isset($_SESSION['logged_user'])) : ?>
                                                <!-- liên kết logout sẽ hiển thị -->
                                                    <a class="nav-link" href="logout.php">Logout</a>
                                                    <li class="nav-item">
                                                    <a class="nav-link active" aria-current="page" href="#"><span style="color:red">Hello <?=$_SESSION['logged_user']?></span></a>
                                                    </li>
                                                    
                                                <?php else:?>
                                                    <li class="nav-item">
                                                        <a class="nav-link active" aria-current="page" href="login.php">Login</a>
                                                    </li>
                                                <?php endif;?>
                                                <li><a href="cart.php" title="My cart">My cart</a></li>
                                                </ul>
                                            </div>   
                                        </div>
                                   </div> 
                                </div> 
                            </div>
                        </div> 
                </div> 
        </div>
                            
                                <!--header top end-->

                                <!--header middel--> 
                                <div class="header_middel">
                                    <div class="row align-items-center">
                                       <!--logo start-->
                                       <div class="col">
                                            <div class="logo">
                                                <a href="index.php"><img src="assets\img\logo\logoMTam.png" alt="" style="width: 150px;height: auto;
	filter: drop-shadow(1px 1px 20px #426EB4);"></a>
                                            </div>
                                        </div>
                                        <!--logo end-->
                                        <div class="col-lg-9 col-md-9">
                                            <div class="header_right_info">
                                            <div class="search_bar">
                                                <form action="#" method="POST">
                                                    <input name="search" placeholder="Search..." type="text">
                                                    <button type="submit"><i class="fa fa-search"></i></button>
                                                </form>
                                            </div>
                                                <div class="shopping_cart">
                                                <a href="#"> Giỏ hàng 🛒<span><?= empty($_SESSION['id_user'])?0:$count ?></span><i class="fa fa-angle-down"></i></a>
                                                    <!--mini cart-->
                                                    <div class="mini_cart">
                                                    <?php foreach ($data_cart as $cart): ?>
                                                        <div class="cart_item">
                                                           <div class="cart_img">
                                                           <img src="img/<?=$cart->Image?>" class="card-img-top" alt="<?= $cart->name ?>" width="50px" height="50px">
                                                           </div>
                                                            <div class="cart_info">
                                                                <a href="#"><?= $cart->name ?></a>
                                                                <span class="cart_price"><?= number_format($cart->price, 0, ',', '.') ?> VNĐ</span>
                                                                <span class="quantity"><?= $cart->quality ?></span>
                                                            </div>
                                                            <div class="cart_remove">
                                                                <!-- Sử dụng một form để gửi yêu cầu xóa sản phẩm -->
                                                                <form method="post" action="cart.php">
                                                                    <!-- Input hidden chứa product_id của sản phẩm -->
                                                                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                                                    <!-- Trường ẩn để xác định hành động -->
                                                                    <input type="hidden" name="action" value="remove_product">
                                                                    <!-- Nút xóa sản phẩm -->
                                                                    <button type="submit" title="Remove this item"><i class="fa fa-times-circle"></i></button>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    <?php endforeach; ?>
                                                    <tr>
                                                        <td colspan="3" class="text-center"><b>Tổng tiền:</b></td>
                                                        <td><b><?= number_format($totalPrice, 0, ',', '.') ?> VNĐ</b></td>
                                                    </tr>
                                                    </div>
                                                    <!--mini cart end-->
                                                </div>

                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>     
                                <!--header middel end-->      
                            <div class="header_bottom ">
                                <div class="row">
                                        <div class="col-12 ">
                                            <div class="main_menu_inner">
                                                <div class="main_menu d-none d-lg-block">
                                                    <nav >
                                                        <ul>
                                                            <li class="active"><a href="index.php">Trang chủ</a>
                                                                <div class="mega_menu jewelry">
                                                                    <div class="mega_items jewelry">
                                                                        <ul>
                                                                            <li><a href="index.php">Home 2 </a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div> 
                                                            </li>
                                                            <li><a href="index.php">DANH MỤC SẢN PHẨM</a>
                                                                <div class="mega_menu">
                                                                    <div class="mega_top fix">
                                                                        <div class="mega_items">
                                                                            <ul>
                                                                            <?php foreach($data_category as $category): ?>
                                                                                <li><a href="HienThiSanPham.php?id=<?= $category->id ?>"><?= $category->name ?></a></li>
                                                                            <?php endforeach; ?>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="mega_items">
                                                                            <a href="#"><img src="assets\img\banner\banner-tn.jpg" style="max-width: 100%; height: 400px;" alt=""></a>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </li>
                                                            <li><a href="about.php">GIỚI THIỆU</a>
                                                            </li>
                                                            <li><a href="blog.php">TIN TỨC</a>
                                                                <div class="mega_menu jewelry">
                                                                    <div class="mega_items jewelry">
                                                                        <ul>
                                                                            <li><a href="blog-details.php">blog details</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>  
                                                            </li>
                                                            
                                                            <li><a href="contact.php">Liên hệ</a></li>

                                                        </ul>
                                                    </nav>
                                                </div>
                                                <div class="mobile-menu d-lg-none">
                                                    <nav>
                                                        <ul>
                                                            <li><a href="index_trangchu1.php">Trang chủ</a>
                                                                <div>
                                                                    <div>
                                                                        <ul>
                                                                            <li><a href="index.php">Home 2</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div> 
                                                            </li>
                                                            <li><a href="shop.html">shop</a>
                                                                <div>
                                                                    <div>
                                                                        <ul>
                                                                            <li><a href="shop-list.html">shop list</a></li>
                                                                            <li><a href="shop-fullwidth.html">shop Full Width Grid</a></li>
                                                                            <li><a href="shop-fullwidth-list.html">shop Full Width list</a></li>
                                                                            <li><a href="shop-sidebar.html">shop Right Sidebar</a></li>
                                                                            <li><a href="shop-sidebar-list.html">shop list Right Sidebar</a></li>
                                                                            <li><a href="single-product.html">Product Details</a></li>
                                                                            <li><a href="single-product-sidebar.html">Product sidebar</a></li>
                                                                            <li><a href="single-product-video.html">Product Details video</a></li>
                                                                            <li><a href="single-product-gallery.html">Product Details Gallery</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>  
                                                            </li>
                                                            <li><a href="#">women</a>
                                                                <div>
                                                                    <div>
                                                                        <div>
                                                                            <h3><a href="#">Accessories</a></h3>
                                                                            <ul>
                                                                                <li><a href="#">Cocktai</a></li>
                                                                                <li><a href="#">day</a></li>
                                                                                <li><a href="#">Evening</a></li>
                                                                                <li><a href="#">Sundresses</a></li>
                                                                                <li><a href="#">Belts</a></li>
                                                                                <li><a href="#">Sweets</a></li>
                                                                            </ul>
                                                                        </div>
                                                                        <div>
                                                                            <h3><a href="#">HandBags</a></h3>
                                                                            <ul>
                                                                                <li><a href="#">Accessories</a></li>
                                                                                <li><a href="#">Hats and Gloves</a></li>
                                                                                <li><a href="#">Lifestyle</a></li>
                                                                                <li><a href="#">Bras</a></li>
                                                                                <li><a href="#">Scarves</a></li>
                                                                                <li><a href="#">Small Leathers</a></li>
                                                                            </ul>
                                                                        </div>
                                                                        <div>
                                                                            <h3><a href="#">Tops</a></h3>
                                                                            <ul>
                                                                                <li><a href="#">Evening</a></li>
                                                                                <li><a href="#">Long Sleeved</a></li>
                                                                                <li><a href="#">Shrot Sleeved</a></li>
                                                                                <li><a href="#">Tanks and Camis</a></li>
                                                                                <li><a href="#">Sleeveless</a></li>
                                                                                <li><a href="#">Sleeveless</a></li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                        <div>
                                                                            <a href="#"><img src="assets\img\banner\banner1.jpg" alt=""></a>
                                                                        </div>
                                                                        <div>
                                                                            <a href="#"><img src="assets\img\banner\banner2.jpg" alt=""></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li><a href="#">Nhẫn cưới</a>
                                                                <div>
                                                                    <div>
                                                                        <div>
                                                                            <h3><a href="#">Nhẫn cưới</a></h3>
                                                                            <ul>
                                                                                <li><a href="#">Platinum Rings</a></li>
                                                                                <li><a href="#">Gold Ring</a></li>
                                                                                <li><a href="#">Silver Ring</a></li>
                                                                                <li><a href="#">Tungsten Ring</a></li>
                                                                                <li><a href="#">Sweets</a></li>
                                                                            </ul>
                                                                        </div>
                                                                        <div>
                                                                            <h3><a href="#">Nhẫn cưới kim cương</a></h3>
                                                                            <ul>
                                                                                <li><a href="#">Platinum Bands</a></li>
                                                                                <li><a href="#">Gold Bands</a></li>
                                                                                <li><a href="#">Silver Bands</a></li>
                                                                                <li><a href="#">Silver Bands</a></li>
                                                                                <li><a href="#">Sweets</a></li>
                                                                            </ul>
                                                                        </div>
                                                                        <div>
                                                                            <a href="#"><img src="assets\img\banner\banner7.png" alt=""></a>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </li>
                                                            <li><a href="#">pages</a>
                                                                <div>
                                                                    <div>
                                                                        <div>
                                                                            <h3><a href="#">Column1</a></h3>
                                                                            <ul>
                                                                                <li><a href="portfolio.html">Portfolio</a></li>
                                                                                <li><a href="portfolio-details.html">single portfolio </a></li>
                                                                                <li><a href="about.html">About Us </a></li>
                                                                                <li><a href="about-2.html">About Us 2</a></li>
                                                                                <li><a href="services.html">Service </a></li>
                                                                                <li><a href="my-account.html">my account </a></li>
                                                                            </ul>
                                                                        </div>
                                                                        <div>
                                                                            <h3><a href="#">Column2</a></h3>
                                                                            <ul>
                                                                                <li><a href="blog.html">Blog </a></li>
                                                                                <li><a href="blog-details.html">Blog  Details </a></li>
                                                                                <li><a href="blog-fullwidth.html">Blog FullWidth</a></li>
                                                                                <li><a href="blog-sidebar.html">Blog  Sidebar</a></li>
                                                                                <li><a href="faq.html">Frequently Questions</a></li>
                                                                                <li><a href="404.html">404</a></li>
                                                                            </ul>
                                                                        </div>
                                                                        <div>
                                                                            <h3><a href="#">Column3</a></h3>
                                                                            <ul>
                                                                                <li><a href="contact.html">Contact</a></li>
                                                                                <li><a href="cart.html">cart</a></li>
                                                                                <li><a href="checkout.html">Checkout  </a></li>
                                                                                <li><a href="wishlist.html">Wishlist</a></li>
                                                                                <li><a href="login.html">Login</a></li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            
                                                            <li><a href="blog.html">blog</a>
                                                                <div>
                                                                    <div>
                                                                        <ul>
                                                                            <li><a href="blog-details.html">blog details</a></li>
                                                                            <li><a href="blog-fullwidth.html">blog fullwidth</a></li>
                                                                            <li><a href="blog-sidebar.html">blog sidebar</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>  
                                                            </li>
                                                            <li><a href="contact.html">contact us</a></li>

                                                        </ul>
                                                    </nav>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                </div>
            </div>
                        <!--header end -->
                       