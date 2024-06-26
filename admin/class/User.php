<?php
class User {
    public $id, $username,$password,$email,$gender;

    public static function getAll($pdo) {
        $sql = "SELECT * FROM user";
        $stmt = $pdo->prepare($sql);
    
        if($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, "User");
            return $stmt->fetchAll();
        }
    }

    public static function getOneUserByID($pdo, $id) {
        $sql = "SELECT * FROM user WHERE id=:id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "User");
            return $stmt->fetch();
        }
    }

    public static function getLastID($pdo) {
        $stmt = $pdo->query("SELECT id FROM user ORDER BY id DESC LIMIT 1");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['id'] : null;
    }
    public static function addOneUser($pdo, $username, $password, $email, $gender) {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
            // Prepare SQL statement
            $sql = "INSERT INTO user (username, password, email, gender) VALUES (:username, :password, :email, :gender)";
            $stmt = $pdo->prepare($sql);
    
            // Bind parameters
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $hashedPassword, PDO::PARAM_STR); // Use hashed password
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":gender", $gender, PDO::PARAM_STR);
    
            // Execute the statement
            return $stmt->execute();
        }

        public static function updateUser($pdo, $id, $username, $password, $email, $gender) {
            try {
                // Hash the password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
                $sql = "UPDATE user SET username = :username, password = :password, email = :email, gender = :gender WHERE id = :id";
                $stmt = $pdo->prepare($sql);
        
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->bindParam(":username", $username, PDO::PARAM_STR);
                $stmt->bindParam(":password", $hashedPassword, PDO::PARAM_STR); // Use hashed password
                $stmt->bindParam(":email", $email, PDO::PARAM_STR);
                $stmt->bindParam(":gender", $gender, PDO::PARAM_STR);
        
                return $stmt->execute();
            } catch (PDOException $e) {
                // Handle error if needed
                return false;
            }
        }
        

    public static function deleteUser($pdo, $id) {
        try {
            $sql = "DELETE FROM user WHERE id = :id";
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
