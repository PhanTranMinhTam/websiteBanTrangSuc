<?php
class Product {
    public $id, $name, $description, $price, $Image;

    public static function getAll($pdo) {
        $sql = "SELECT * FROM product";
        $stmt = $pdo->prepare($sql);
    
        if($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product");
            return $stmt->fetchAll();
        }
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

    public static function getLastID($pdo) {
        $sql ="SELECT ID FROM PRODUCT ORDER BY ID DESC LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $lastID = $pdo->lastInsertId();
        return $lastID;
    }
    
    public static function addOneProduct($pdo, $name, $description, $price, $Image) {
        
            $sql = "INSERT INTO product(name, description, price, Image) VALUES (:name, :description, :price, :Image)";
            $stmt = $pdo->prepare($sql);
        
            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->bindParam(":description", $description, PDO::PARAM_STR);
            $stmt->bindParam(":price", $price, PDO::PARAM_STR); // Đảm bảo kiểu dữ liệu phù hợp với cột 'price' trong cơ sở dữ liệu
            $stmt->bindParam(":Image", $Image, PDO::PARAM_STR);
        
            if($stmt->execute()){
                $stmt->setFetchMode(PDO::FETCH_CLASS, "Product");
                $lastID = $pdo->lastInsertId();
                return $lastID;
            }
    }
    public static function updateProduct($pdo, $id, $name, $description, $price, $Image) {
        try {
            $sql = "UPDATE product SET name = :name, description = :description, price = :price, Image = :Image WHERE id = :id";
            $stmt = $pdo->prepare($sql);
    
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->bindParam(":description", $description, PDO::PARAM_STR);
            $stmt->bindParam(":price", $price, PDO::PARAM_STR);
            $stmt->bindParam(":Image", $Image, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            // Xử lý lỗi nếu có
            // Ví dụ: log lỗi, hiển thị thông báo lỗi, vv.
            return false; // Trả về false nếu có lỗi xảy ra
        }
    }
    public static function deleteProduct($pdo, $id) {
        try {
            $sql = "DELETE FROM product WHERE id = :id";
            $stmt = $pdo->prepare($sql);
    
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    
            return $stmt->execute();
        } catch (PDOException $e) {
            // Handle database errors
            // For example, you can log the error or echo a message
            // echo "Database error: " . $e->getMessage();
            return false; // Return false if an error occurs
        }
    }
}
?>
