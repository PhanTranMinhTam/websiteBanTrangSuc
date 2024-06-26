<?php

$host = "localhost";
$db = "mydatabase";
$username = "PhanTam";
$password = "E.7MVCpvJ88AMsX1";

$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

try {
    $pdo = new PDO($dsn, $username, $password);

    if ($pdo) {
        echo "Connect successful. <br />";
    }
} catch (PDOException $ex) {
    echo $ex->getMessage();
    exit;
}

$sql = "SELECT * FROM product WHERE id=:id";
$stmt = $pdo->prepare($sql);

$id = 2;
$stmt->bindParam(":id", $id, PDO::PARAM_INT);

if ($stmt->execute()) {
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    var_dump($products);
} else {
    $error = $stmt->errorInfo();
    var_dump($error);
}