<?php
$servername = "localhost";
$hostname = "root";
$password = "";
$dbname = "autoparts";

$conn = new mysqli($servername, $hostname, $password, $dbname);

if($conn->connect_error){
    die("Connection failed!") . $conn->connect_error;
}
else{
    echo("Connected successfully.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO contact_messages (fullname, email, phone, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fullname, $email, $phone, $message);

    if ($stmt->execute()) {
        header("Location: ../contact.html?status=success");
    } else {
        header("Location: ../contact.html?status=error");
    }


    $stmt->close();
    $conn->close();
}
?>