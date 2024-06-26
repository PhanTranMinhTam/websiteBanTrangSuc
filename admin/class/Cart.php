<?php
class Cart {
    private $items;

    // public function __construct($items)
    // {
    //     $this->items = $items;
    // }

    public function __construct()
    {
        $this->items = [];
    }

    public function addItem($proid) {
        if(!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if(array_key_exists($proid, $_SESSION['cart'])) {
            // $this->items[$proid]->qty += 1;
            // Trong PHP, khi gán một đối tượng vào biến session, PHP sẽ tự động thực hiện quá trình serialize
            // (chuyển đổi một đối tượng hoặc một biến thành một chuỗi dữ liệu có thể lưu trữ hoặc truyền tải)
            // để lưu trữ đối tượng đó trong session. Khi truy cập biến session và lấy ra đối tượng,
            //  PHP sẽ tự động unserialize để chuyển đổi dữ liệu session trở lại thành đối tượng gốc.
            $_SESSION['cart'][$proid]->qty += 1;
            // var_dump($_SESSION['cart']);
        }
        else {
            // $this->items[$proid] = new CartItem($proid, 1);
            $_SESSION['cart'][$proid] = new CartItem($proid, 1);
        }
    }

    public function removeItem($proid) {
        if (isset($_GET['proid'])) {
            $proid = $_GET['proid'];
            unset($_SESSION['cart'][$proid]);
        }
    }

    public function emptyCart() {
        $_SESSION['cart'] = [];
    }

    public function updateItem($proid) {
        $_SESSION['cart'][$proid]->qty = $_POST['qty'];
    }

    public function getItems() {
        return $this->items;
    }
}