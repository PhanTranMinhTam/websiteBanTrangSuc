<?php

class Product {
    public static function getAllProducts() {
        $lines = explode("\n", file_get_contents('data.csv'));
        $headers = str_getcsv(array_shift($lines)); // Lấy headers từ dòng đầu tiên
        $data = array(); // Khởi tạo mảng data
        foreach($lines as $line) { // Lặp qua từng dòng
            $row = array();
            foreach(str_getcsv($line) as $key => $value) { // Lặp qua từng cột trong dòng
                $row[$headers[$key]] = $value; // Gán giá trị từng cột vào mảng row với key là header tương ứng
            }
            $data[] = $row; // Thêm mảng row vào mảng data
        }
        return $data; // Trả về mảng data
    }

    public static function getProductById($id) {
        $products = self::getAllProducts();
        foreach ($products as $product) {
            if ($product['id'] == $id) {
                return $product;
            }
        }
        return null; // Trả về null nếu không tìm thấy sản phẩm
    }
    function getOneProductByID($data, $proid) {
        // Thực hiện logic để lấy sản phẩm từ dữ liệu với ID tương ứng
        // Ví dụ:
        foreach ($data as $product) {
            if ($product['id'] == $proid) {
                return $product;
            }
        }
        return null; // Trả về null nếu không tìm thấy sản phẩm
    }
}

?>
