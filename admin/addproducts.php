<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "autoparts"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else{
    echo("Connected Successfully!");
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $image_url = $_POST['image_url'];

    $stmt = $conn->prepare("INSERT INTO products (brand, model, year, name, description, price, stock, image_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssdis", $brand, $model, $year, $name, $description, $price, $stock, $image_url);

    if ($stmt->execute()) {
        header("Location: addproducts.html?status=success");
    } else {
        header("Location: addproducts.html?status=error");
    }

    $stmt->close();
    $conn->close();
}
?>