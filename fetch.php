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
    echo json_encode(['error' => 'No product ID provided.']);
}

$stmt->close();
$conn->close();
?>