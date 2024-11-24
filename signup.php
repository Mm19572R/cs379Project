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
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phoneNo'];
    $userPassword = password_hash($_POST['userPassword'], PASSWORD_DEFAULT); 

    $checkEmailSql = "SELECT email FROM userinformation WHERE email = ?";
    $stmtCheck = $conn->prepare($checkEmailSql);
    $stmtCheck->bind_param("s", $email);
    $stmtCheck->execute();
    $stmtCheck->store_result();

    if ($stmtCheck->num_rows > 0) {
        header("Location: signup.html?error=email_taken");
        exit();
    } else {
        $sql = "INSERT INTO userinformation (fname, lname, email, phoneNo, userPassword) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $fname, $lname, $email, $phone, $userPassword);

        if ($stmt->execute()) {
            $_SESSION['username'] = $fname;
            $_SESSION['usrname'] = $lname;
            $_SESSION['email'] = $email;
            $_SESSION['phone'] = $phoneNO;
            header("Location: index.html");
            exit();
        } else {
            header("Location: signup.html?error=registration_failed");
            exit();
        }
        $stmt->close();
    }
    $stmtCheck->close();
}

$conn->close();
?>