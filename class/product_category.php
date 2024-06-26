<?php
class product_category {
    public $category_id;
    public $product_id;

    public static function getAll($pdo) {
        $sql = "SELECT * FROM product_category";
        $stmt = $pdo->prepare($sql);
    
        if($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, "product_category");
            return $stmt->fetchAll();
        }
    }

    public static function getByIDProduct($pdo, $product_id) {
        $sql = "SELECT * FROM product_category WHERE id=:id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":product_id", $product_id, PDO::PARAM_INT);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "product_category");
            return $stmt->fetchAll();
        }
    }

    // public static function getLastID($data) {
    //     $lastid = end($data);
    //     return  $lastid->id;
    // }

    public static function addOneProductCategory($pdo,$product_id,$category_id) {
        $sql = "INSERT INTO product_category(product_id,category_id) VALUES (:product_id, :category_id)";
        $stmt = $pdo->prepare($sql);
    
        $stmt->bindParam(":product_id", $product_id, PDO::PARAM_INT);
        $stmt->bindParam(":category_id", $category_id, PDO::PARAM_INT);
    
        if( $stmt->execute())
        {

        }else{
            echo"Có lỗi xảy ra khi thêm loại sản phẩm";
        }   
    }

    // public static function updateProduct($pdo, $id, $name, $description, $price) {
    //     try {
    //         $sql = "UPDATE product SET name = :name, description = :description, price = :price WHERE id = :id";
    //         $stmt = $pdo->prepare($sql);
    
    //         $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    //         $stmt->bindParam(":name", $name, PDO::PARAM_STR);
    //         $stmt->bindParam(":description", $description, PDO::PARAM_STR);
    //         $stmt->bindParam(":price", $price, PDO::PARAM_STR);
    
    //         return $stmt->execute();
    //     } catch (PDOException $e) {
    //         // Xử lý lỗi nếu có
    //         // Ví dụ: log lỗi, hiển thị thông báo lỗi, vv.
    //         return false; // Trả về false nếu có lỗi xảy ra
    //     }
    // }

    // public static function deleteProduct($pdo, $id) {
    //     try {
    //         $sql = "DELETE FROM product WHERE id = :id";
    //         $stmt = $pdo->prepare($sql);
    
    //         $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    
    //         return $stmt->execute();
    //     } catch (PDOException $e) {
    //         // Handle database errors
    //         // For example, you can log the error or echo a message
    //         // echo "Database error: " . $e->getMessage();
    //         return false; // Return false if an error occurs
    //     }
    // }
}
