<?php
session_start();

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "autoparts"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['check_email'])) {
    $email = $_GET['check_email'];
    $checkEmailSql = "SELECT email FROM userinformation WHERE email = ?";
    $stmtCheck = $conn->prepare($checkEmailSql);
    $stmtCheck->bind_param("s", $email);
    $stmtCheck->execute();
    $stmtCheck->store_result();

    if ($stmtCheck->num_rows > 0) {
        echo json_encode(['exists' => true]);
    } else {
        echo json_encode(['exists' => false]);
    }
    $stmtCheck->close();
    $conn->close();
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $enteredPassword = $_POST['userPassword']; 

    $sql = "SELECT * FROM userinformation WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($enteredPassword, $user['userPassword'])) {
            $_SESSION['username'] = $user['fname']; 
            if ($user['role'] === 'admin') {
                header("Location: admin/admin.html"); 
            } else {
                header("Location: index.html"); 
            }
            exit(); 
        } else {
            header("Location: signin.html?error=invalid_login");
            exit();
        }
    } else {
        header("Location: signin.html?error=no_user");
        exit();
    }
    $stmt->close();
}

$conn->close();
?>