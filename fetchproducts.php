<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "autoparts";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection Failed: ' . $conn->connect_error]));
}

$id = isset($_GET['id']) ? $_GET['id'] : '';
$brand = isset($_GET['brand']) ? $_GET['brand'] : '';

// Check if an ID is provided to fetch a single product
if ($id) {
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // Assuming ID is an integer
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        echo json_encode($product); // Return the single product as JSON
    } else {
        echo json_encode(['error' => 'Product not found.']);
    }
} else {
    // Existing functionality to fetch products by brand
    $sql = $brand ? "SELECT * FROM products WHERE brand = ? ORDER BY price ASC" : "SELECT * FROM products ORDER BY price ASC";
    $stmt = $conn->prepare($sql);
    if ($brand) {
        $stmt->bind_param("s", $brand);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    echo json_encode($products); // Return the array of products as JSON
}

$stmt->close();
$conn->close();
?>