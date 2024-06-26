<?php
$title = 'Home page';

require '../class/Database.php';
require '../class/Category.php'; 
require '../class/Cart.php'; 
require '../class/Order.php';
require '../class/CT_Order.php';
require "../inc/init.php"; 

$conn = new Database();
$pdo = $conn->getConnect();

// Pagination
$page = isset($_GET["page"]) ? (int)$_GET['page'] : 1;
$ppp = 10;
$offset = ($page - 1) * $ppp;

// Total number of products
$sqlTotal = "SELECT COUNT(*) AS TOTAL FROM CT_DATHANG";
$stmtTotal = $pdo->query($sqlTotal);
$totalProducts = $stmtTotal->fetchColumn();

// Calculate total pages
$totalPages = ceil($totalProducts / $ppp);

// Fetch products for the current page
$sql = "
    SELECT o.*, cto.*, u.username, p.name
    FROM `dathang` o
    JOIN `ct_dathang` cto ON o.ID_ORDER = cto.ID_ORDER 
    JOIN `user` u ON o.id_user = u.id
    JOIN `product` p ON cto.product_id = p.id
    ORDER BY o.ID_ORDER DESC 
    LIMIT :limit OFFSET :offset
";

// Chuẩn bị đối tượng PDOStatement
$stmt = $pdo->prepare($sql);

// Bind các tham số limit và offset
$stmt->bindParam(":limit", $ppp, PDO::PARAM_INT);
$stmt->bindParam(":offset", $offset, PDO::PARAM_INT);

// Thực thi câu lệnh SQL
$stmt->execute();

// Lấy tất cả các kết quả vào mảng kết hợp
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);



// THÊM VÀO GIỎ HÀNG
// if (isset($_GET['action']) && isset($_GET['proid'])) 
// {
//     $action = $_GET['action'];
//     $proid = $_GET['proid']; //$product->id
//     if ($action == 'addcart') 
//     {
//         $cart->addProToCart($proid); 
//     }
// }
// 
?>


<?php require_once "../inc/header.php"?>
<main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item active"><a href="#"><b>Dach sách đơn hàng</b></a></li>
            </ul>
            <div id="clock"></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
<h1>Danh sách hóa đơn</h1>
<table class="table table-bordered table-striped">
    <thead class="table-primary">
        <tr>
            <th>Mã hóa đơn</th>
            <th>Khách hàng</th>
            <th>Sản phẩm</th>
            <th>Số lượng</th>
            <th>Giá</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($data as $order): ?>
            <tr>
                <td><?= $order['id_order'] ?></td> 
                <td><?= $order['username'] ?></td>  
                <td><?= $order['name'] ?></td>  
                <td><?= $order['quantity'] ?></td>  
                <td><?= $order['price'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<main>
    <div class="container-fluid">
        <!-- Pagination -->
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="index_trangchu2.php?page=<?= max($page - 1, 1) ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php 
                $startPage = max(1, min($page - 1, $totalPages - 2));
                // Display pagination links
                for($i = $startPage; $i <= min($totalPages, $startPage + 2); $i++) : ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="table-data-oder.php?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item">
                    <a class="page-link" href="table-data-oder.php?page=<?= min($page + 1, $totalPages) ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</main>
<?php require_once "../inc/footer.php"?>
