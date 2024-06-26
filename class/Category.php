<?php
class Category {
    public $id, $name;

    public static function getAll($pdo) {
        $sql = "SELECT * FROM category";
        $stmt = $pdo->prepare($sql);
    
        if($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Category");
            return $stmt->fetchAll();
        }
    }

    public static function getOneCategoryByID($pdo, $id) {
        $sql = "SELECT * FROM category WHERE id=:id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Category");
            return $stmt->fetch();
        }
    }

    public static function getLastID($data) {
        $lastid = end($data);
        return  $lastid->id;
    }

    public static function addOneCategory($pdo, $name) {
        $sql = "INSERT INTO category(name) VALUES (:name)";
        $stmt = $pdo->prepare($sql);
    
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
    
        return $stmt->execute();   
    }

    public static function updateCategory($pdo, $id, $name) {
        try {
            $sql = "UPDATE category SET name = :name";
            $stmt = $pdo->prepare($sql);
    
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            // Xử lý lỗi nếu có
            // Ví dụ: log lỗi, hiển thị thông báo lỗi, vv.
            return false; // Trả về false nếu có lỗi xảy ra
        }
    }

    public static function deleteCategory($pdo, $id) {
        try {
            $sql = "DELETE FROM category WHERE id = :id";
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
