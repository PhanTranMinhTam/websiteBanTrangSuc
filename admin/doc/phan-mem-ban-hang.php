<!DOCTYPE html>
<html lang="en">

<head>
  <title>Danh sách nhân viên | Quản trị Admin</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
  <!-- or -->
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  <!-- Font-icon css-->
  <link rel="stylesheet" type="text/css"
    href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

</head>
<?php
$title = 'Home page';

require '../class/Database.php';
require '../class/Product.php'; 
require '../class/Cart.php'; 
require "../inc/init.php"; 

$conn = new Database();
$pdo = $conn->getConnect();

// Pagination
$page = isset($_GET["page"]) ? (int)$_GET['page'] : 1;
$ppp = 5;
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

$cart = new Cart();

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
?>
<body onload="time()" class="app sidebar-mini rtl">
  <!-- Navbar-->
  <header class="app-header">
    <!-- Sidebar toggle button-->
    <!-- Navbar Right Menu-->
    <ul class="app-nav">


      <!-- User Menu-->
      <li><a class="app-nav__item" href="/index.html"><i class='bx bx-log-out bx-rotate-180'></i> </a>

      </li>
    </ul>
  </header>
  <!-- Sidebar menu-->
  <main class="app app-ban-hang">
    <div class="row">
      <div class="col-md-12">
        <div class="app-title">
          <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><a href="#"><b>POS bán hàng</b></a></li>
          </ul>
          <div id="clock"></div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-8">
        <div class="tile">
          <h3 class="tile-title">Phần mềm bán hàng</h3>
          <input type="text" id="myInput" onkeyup="myFunction()"
          placeholder="Nhập mã sản phẩm hoặc tên sản phẩm để tìm kiếm...">
        <div class="du--lieu-san-pham">
        <table class="table table-bordered table-striped">
    <thead class="bg-primary text-white">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Image</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($data as $product): ?>
            <tr>
                <td><?= $product['id'] ?></td>       
                <td><a href="detail_product.php?id=<?= $product['id'] ?>" class="text-decoration-none"><?= $product['name'] ?></a></td>
                <td><?= $product['description'] ?></td>
                <td><?= number_format($product['price'], 0, ',', '.') ?> VNĐ</td>
                <td><img src="../images/<?= $product['Image'] ?>" class="img-thumbnail" alt="<?= $product['name'] ?>" style="max-width: 100px;"></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
        </div>
        <div class="alert">

          <i class="fas fa-exclamation-triangle"></i> Gõ mã hoặc tên sản phẩm vào thanh tìm kiếm để thêm hàng vào đơn hàng
        </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="tile">
          <h3 class="tile-title">Thông tin thanh toán</h3>
          <div class="row">
            <div class="form-group  col-md-10">
              <label class="control-label">Họ tên khách hàng</label>
              <input class="form-control" type="text" placeholder="Tìm kiếm khách hàng">
            </div>
            <div class="form-group  col-md-2">
              <label style="text-align: center;" class="control-label">Tạo mới</label>
              <button class="btn btn-primary btn-them" data-toggle="modal" data-target="#exampleModalCenter"><i class="fas fa-user-plus"></i>
              </button>
            </div>
            <div class="form-group  col-md-12">
              <label class="control-label">Nhân viên bán hàng</label>
              <select class="form-control" id="exampleSelect1">
                <option>--- Chọn nhân viên bán hàng ---</option>
                <option>Võ Trường</option>
                <option>Nhật Kim Anh</option>
                <option>Đào Thanh Tuấn</option>
                <option>Phạm Phong Phú</option>
              </select>
            </div>
            <div class="form-group  col-md-12">
              <label class="control-label">Ghi chú đơn hàng</label>
              <textarea class="form-control" rows="4" placeholder="Ghi chú thêm đơn hàng"></textarea>
            </div>
  
          </div>
          <div class="row">
           
            <div class="form-group  col-md-12">
              <label class="control-label">Hình thức thanh toán</label>
              <select class="form-control" id="exampleSelect2" required>
                <option>Thanh toán chuyển khoản</option>
                <option>Trả tiền mặt tại quầy</option>
              </select>
            </div>
            <div class="form-group  col-md-6">
              <label class="control-label">Tạm tính tiền hàng: </label>
              <p class="control-all-money-tamtinh">= 129.397.213 VNĐ</p>
            </div>
            <div class="form-group  col-md-6">
              <label class="control-label">Giảm giá (F7): </label>
              <input class="form-control" type="number" value="0">
            </div>
            <div class="form-group  col-md-6">
              <label class="control-label">Tổng cộng thanh toán: </label>
              <p class="control-all-money-total">= 129.397.213 VNĐ</p>
            </div>
            <div class="form-group  col-md-6">
              <label class="control-label">Khách hàng đưa tiền (F8): </label>
              <input class="form-control" type="number" value="290000">
            </div>
            <div class="form-group  col-md-12">
              <label class="control-label">Khách hàng còn nợ: </label>
              <p class="control-all-money"> - 129.397.213 VNĐ</p>
            </div>
            <div class="tile-footer col-md-12">
              <button class="btn btn-primary luu-san-pham" type="button"> Lưu đơn hàng (F9)</button>
              <button class="btn btn-primary luu-va-in" type="button">Lưu và in hóa đơn (F10)</button>
  
              <a class="btn btn-secondary luu-va-in" href="index.html">Quay về</a>
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>
  </main>

  <!--
  MODAL
-->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
data-backdrop="static" data-keyboard="false">
<div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">

    <div class="modal-body">
      <div class="row">
        <div class="form-group  col-md-12">
          <span class="thong-tin-thanh-toan">
            <h5>Tạo mới khách hàng</h5>
          </span>
        </div>
        <div class="form-group col-md-12">
          <label class="control-label">Họ và tên</label>
          <input class="form-control" type="text" required>
        </div>
        <div class="form-group col-md-6">
          <label class="control-label">Địa chỉ</label>
          <input class="form-control" type="text" required>
        </div>
        <div class="form-group col-md-6">
          <label class="control-label">Email</label>
          <input class="form-control" type="text" required>
        </div>
        <div class="form-group col-md-6">
          <label class="control-label">Ngày sinh</label>
          <input class="form-control" type="date" required>
        </div>
        <div class="form-group col-md-6">
          <label class="control-label">Số điện thoại</label>
          <input class="form-control" type="number" required>
        </div>
      </div>
      <BR>
      <button class="btn btn-save" type="button">Lưu lại</button>
      <a class="btn btn-cancel" data-dismiss="modal" href="#">Hủy bỏ</a>
      <BR>
    </div>
    <div class="modal-footer">
    </div>
  </div>
</div>
</div>
<!--
MODAL
-->


  <!-- The Modal -->
  <div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
      <div class="modal-header">
        <span class="close">X</span>
      </div>
    
     
    </div>

  </div>
  <!-- Essential javascripts for application to work-->
  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
  <!-- The javascript plugin to display page loading on top-->
  <script src="js/plugins/pace.min.js"></script>
  <!-- Page specific javascripts-->
  <!-- Data table plugin-->
  <script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
  <script type="text/javascript">$('#sampleTable').DataTable();</script>
  <script>
    function deleteRow(r) {
      var i = r.parentNode.parentNode.rowIndex;
      document.getElementById("myTable").deleteRow(i);
    }
    //Thời Gian
    function time() {
      var today = new Date();
      var weekday = new Array(7);
      weekday[0] = "Chủ Nhật";
      weekday[1] = "Thứ Hai";
      weekday[2] = "Thứ Ba";
      weekday[3] = "Thứ Tư";
      weekday[4] = "Thứ Năm";
      weekday[5] = "Thứ Sáu";
      weekday[6] = "Thứ Bảy";
      var day = weekday[today.getDay()];
      var dd = today.getDate();
      var mm = today.getMonth() + 1;
      var yyyy = today.getFullYear();
      var h = today.getHours();
      var m = today.getMinutes();
      var s = today.getSeconds();
      m = checkTime(m);
      s = checkTime(s);
      nowTime = h + " giờ " + m + " phút " + s + " giây";
      if (dd < 10) {
        dd = '0' + dd
      }
      if (mm < 10) {
        mm = '0' + mm
      }
      today = day + ', ' + dd + '/' + mm + '/' + yyyy;
      tmp = '<span class="date"> <i class="bx bxs-calendar" ></i> ' + today + ' | <i class="fa fa-clock-o" aria-hidden="true"></i>  : ' + nowTime +
        '</span>';
      document.getElementById("clock").innerHTML = tmp;
      clocktime = setTimeout("time()", "1000", "Javascript");

      function checkTime(i) {
        if (i < 10) {
          i = "0" + i;
        }
        return i;
      }
    }
  </script>
  <script>
    function deleteRow(r) {
      var i = r.parentNode.parentNode.rowIndex;
      document.getElementById("myTable").deleteRow(i);
    }
    jQuery(function () {
      jQuery(".trash").click(function () {
        swal({
          title: "Cảnh báo",
          text: "Bạn có chắc chắn là muốn xóa?",
          buttons: ["Đóng", "Đồng ý"],
        })
          .then((willDelete) => {
            if (willDelete) {
              swal("Đã xóa thành công.!", {
              });
            }
          });
      });
    });
  </script>
  <script>
    // Modal popup 
    var modal = document.getElementById("myModal");
    var btn = document.getElementById("myBtn");
    var span = document.getElementsByClassName("close")[0];
    btn.onclick = function () {
      modal.style.display = "block";
    }
    span.onclick = function () {
      modal.style.display = "none";
    }
    window.onclick = function (event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
  </script>
</body>

</html>