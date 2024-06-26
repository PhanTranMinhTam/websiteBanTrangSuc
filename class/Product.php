<?php
class Product {
    public $id, $name, $description, $price;

    public static function getAll($pdo) {
        $sql = "SELECT * FROM product";
        $stmt = $pdo->prepare($sql);
    
        if($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product");
            return $stmt->fetchAll();
        }
    }
    public static function getProduct_Category($pdo, $category_id) {
        $sql = "SELECT * FROM product_category, product 
        WHERE product_id = id and category_id=:category_id";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(":category_id", $category_id, PDO::PARAM_STR);
    
        if($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product");
            return $stmt->fetchAll();
        }
    }
    
    public static function getProductDetailsById($pdo, $product_id) {
        // Chuẩn bị truy vấn SQL để lấy thông tin chi tiết sản phẩm dựa trên ID
        $sql = "SELECT * FROM product WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $product_id, PDO::PARAM_INT);
        $stmt->execute();

        // Trả về kết quả dưới dạng mảng liên hợp chứa thông tin chi tiết của sản phẩm
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function getOneProductByID($pdo, $id) {
        $sql = "SELECT * FROM product WHERE id=:id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product");
            return $stmt->fetch();
        }
    }

    public static function getLastID($data) {
        $lastid = end($data);
        return  $lastid->id;
    }
    public static function findProductByName($pdo, $name) {
        $sql = "SELECT * FROM product WHERE name = :name";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    
    
    public static function addOneProduct($pdo, $name, $description, $price) {
        $sql = "INSERT INTO product(name, description, price) VALUES (:name, :description,:price)";
        $stmt = $pdo->prepare($sql);
    
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":description", $description, PDO::PARAM_STR);
        $stmt->bindParam(":price", $price, PDO::PARAM_STR); // Change PDO::PARAM_INT to PDO::PARAM_STR
    
        return $stmt->execute();   
    }

    public static function updateProduct($pdo, $id, $name, $description, $price) {
        try {
            $sql = "UPDATE product SET name = :name, description = :description, price = :price WHERE id = :id";
            $stmt = $pdo->prepare($sql);
    
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->bindParam(":description", $description, PDO::PARAM_STR);
            $stmt->bindParam(":price", $price, PDO::PARAM_STR);
    
            return $stmt->execute();
        } catch (PDOException $e) {
            // Xử lý lỗi nếu có
            // Ví dụ: log lỗi, hiển thị thông báo lỗi, vv.
            return false; // Trả về false nếu có lỗi xảy ra
        }
    }
}
