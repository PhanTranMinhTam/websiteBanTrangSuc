<?php
$title = 'Home page';

require '../class/Database.php';
require '../class/Category.php'; 
require '../class/Cart.php'; 
require "../inc/init.php"; 

$conn = new Database();
$pdo = $conn->getConnect();

// Pagination
$page = isset($_GET["page"]) ? (int)$_GET['page'] : 1;
$ppp = 5;
$offset = ($page - 1) * $ppp;

// Total number of products
$sqlTotal = "SELECT COUNT(*) AS TOTAL FROM CATEGORY";
$stmtTotal = $pdo->query($sqlTotal);
$totalProducts = $stmtTotal->fetchColumn();

// Calculate total pages
$totalPages = ceil($totalProducts / $ppp);

// Fetch products for the current page
$sql = "SELECT * FROM CATEGORY ORDER BY ID DESC LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":limit", $ppp, PDO::PARAM_INT);
$stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Kiểm tra xem yêu cầu có phải là POST không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy ID từ biến POST
    $id = $_POST['id'];

    // Xóa người dùng
    $success = Category::deleteCategory($pdo, $id);

    if ($success) {
        // Nếu xóa thành công, chuyển hướng đến trang user.php
        header("Location: category.php");
        exit; // Đảm bảo kết thúc script sau khi chuyển hướng
    } else {
        echo "Có lỗi xảy ra khi xóa người dùng.";
    }
}
?>


<?php require_once "../inc/header.php"?>
<main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item active"><a href="#"><b>Danh mục sản phẩm</b></a></li>
            </ul>
            <div id="clock"></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="row element-button">
                            <div class="col-sm-2">
              
                              <a class="btn btn-add btn-sm" href="ThemDanhMuc.php" title="Thêm"><i class="fas fa-plus"></i>
                                Tạo mới danh mục</a>
                            </div>
                            <div class="col-sm-2">
                              <a class="btn btn-delete btn-sm nhap-tu-file" type="button" title="Nhập" onclick="myFunction(this)"><i
                                  class="fas fa-file-upload"></i> Tải từ file</a>
                            </div>
              
                            <div class="col-sm-2">
                              <a class="btn btn-delete btn-sm print-file" type="button" title="In" onclick="myApp.printTable()"><i
                                  class="fas fa-print"></i> In dữ liệu</a>
                            </div>
                            <div class="col-sm-2">
                              <a class="btn btn-delete btn-sm print-file js-textareacopybtn" type="button" title="Sao chép"><i
                                  class="fas fa-copy"></i> Sao chép</a>
                            </div>
              
                            <div class="col-sm-2">
                              <a class="btn btn-excel btn-sm" href="" title="In"><i class="fas fa-file-excel"></i> Xuất Excel</a>
                            </div>
                            <div class="col-sm-2">
                              <a class="btn btn-delete btn-sm pdf-file" type="button" title="In" onclick="myFunction(this)"><i
                                  class="fas fa-file-pdf"></i> Xuất PDF</a>
                            </div>
                            <div class="col-sm-2">
                              <a class="btn btn-delete btn-sm" type="button" title="Xóa" onclick="myFunction(this)"><i
                                  class="fas fa-trash-alt"></i> Xóa tất cả </a>
                            </div>
                          </div>
<h1>Danh mục sản phẩm</h1>
<table class="table table-bordered table-hover">
    <thead class="table-primary">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($data as $category): ?>
            <tr>
                <td><?= $category['id'] ?></td>       
                <td><a href="detail_product.php?id=<?= $category['id'] ?>"><?php echo $category['name'] ?></a></td>
                <td>
                    <div class="btn-group" role="group">
                        <a href="../doc/SuaDanhMuc.php?id=<?= $category['id'] ?>" class="btn btn-primary" title="Edit"><i class="fa fa-edit"></i></a>
                        <form method="post" class="delete-form" onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng này không?')">
                            <input type="hidden" name="id" value="<?= $category['id'] ?>">
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </div>
                </td>
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
                        <a class="page-link" href="category.php?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item">
                    <a class="page-link" href="product.php?page=<?= min($page + 1, $totalPages) ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</main>
<?php require_once "../inc/footer.php"?>
