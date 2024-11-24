<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "autoparts"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$brand = isset($_GET['brand']) ? $_GET['brand'] : '';
$model = isset($_GET['model']) ? $_GET['model'] : '';
$year = isset($_GET['year']) ? $_GET['year'] : '';


$sql = "SELECT * FROM products WHERE 1=1";

if ($search !== '') {
    $sql .= " AND (name LIKE '%" . $conn->real_escape_string($search) . "%' 
                OR description LIKE '%" . $conn->real_escape_string($search) . "%'
                 OR year LIKE '%" . $conn->real_escape_string($search) . "%')";
}
if ($brand !== '') {
    $sql .= " AND brand = '" . $conn->real_escape_string($brand) . "'";
}
if ($model !== '') {
    $sql .= " AND model = '" . $conn->real_escape_string($model) . "'";
}
if ($year !== '') {
    $sql .= " AND FIND_IN_SET('" . $conn->real_escape_string($year) . "', year)";
}


$sql .= "order by price asc";

$result = $conn->query($sql);

$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($products);

$conn->close();
?>