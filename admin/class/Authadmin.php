<?php
class Authadmin {

    public static function doneLogin()
    {
        if (!isset($_SESSION['logged_admin']))
        {
            die('Bạn cần đăng nhập nhá');
        }
    }

    // Hàm mã hóa password
    public static function hashPassword($passwd) 
    {
        return password_hash($passwd, PASSWORD_DEFAULT);
    }

    public static function testLogin($pdo, $username, $password, $nameError, $passError) 
    { 

        try {
            $stmt = $pdo->prepare("SELECT password FROM qtadmin WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
    
            $passwd_h = $stmt->fetch(PDO::FETCH_ASSOC);
            $pass_h= $passwd_h['password'];         

            if ($username && password_verify($password, $pass_h)) 
            {
                $_SESSION['logged_admin'] = $username;
                return true;
            } 
            else 
            {
                //Chỉ trả về mảng chứa thông báo lỗi khi có lỗi
                $errorMessages = [];
                if (empty($username)) {
                    $errorMessages['nameError'] = "Phải nhập tên";
                }
                // elseif (empty($password))
                // { 
                //     $errorMessages['passError'] = "Phải nhập pass";
                // }
                else
                {
                    $errorMessages['Error'] = "Password hoặc Username không đúng";
                }
                return $errorMessages;
            }
        } catch (PDOException $e) {
            // Xử lý lỗi khi không thể thực hiện truy vấn
            return "Có lỗi xảy ra khi truy vấn cơ sở dữ liệu: " . $e->getMessage();
        }
    }

    public static function register($pdo, $name, $email, $password, $repassword, $gender) 
    {       
        $nameError = '';
        $emailError = '';
        $genderError = '';
        $passError = '';
        $repassError = '';

        if (empty($name))
            $nameError = "Phải nhập họ tên nha";
        elseif (!preg_match("/^[A-Za-z]*$/", $name))
            $nameError = "Tên không chứa số nha";

        if (empty($email)) {
            $emailError = "Phải nhập email á";
        } elseif (!preg_match('/^\\S+@\\S+\\.\\S+$/', $email)) {
            $emailError = "Email không hợp lệ nha";
        }

        if (empty($_POST['gender'])) {
            $genderError = "Giới tính không được bỏ trống nhá!";
        }

        if (empty($password)) {
            $passError = "Phải nhập password";
        } elseif (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $password)) {
            $passError = "Password phải đủ 8 kí tự, chứa chữ in hoa, chữ thường và chứa kí tự đặc biệt nha";
        }

        if (empty($repassword)) {
            $repassError = "Phải nhập lại mật khẩu bạn à";
        } elseif ($password != $repassword) {
            $repassError = "Nhập lại password không đúng rồi";
        }

        // Đăng ký thành công

        $sql = "INSERT INTO qtadmin (username, password, email, gender) VALUES (:username, :password, :email, :gender)";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':username', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':gender', $gender);

        // if ($stmt->execute()) 
        // {    
        //     echo "Đăng kí thành công";
        // } else {
        //     echo "Có lỗi xảy ra khi đăng kí.";
        // }

        if (!$nameError && !$emailError && !$passError && $stmt->execute()) {
            
            return true;
        } else {
            // Đăng ký thất bại, trả về các thông báo lỗi
            return [
                'nameError' => $nameError,
                'emailError' => $emailError,
                'genderError' => $genderError,
                'passError' => $passError,
                'repassError' => $repassError
            ];
        }
    }   

    
    public function restrictAccess() {
        if(!isset( $_SESSION['logged_admin'])){
            die('Ban can phai dang nhap');
            exit; // dừng việc thực hiện mã PHP tiếp theo
        }
    }
}
?>
