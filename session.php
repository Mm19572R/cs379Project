<?php
session_start();

if (isset($_GET['logout'])) {
    $_SESSION = array();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', 0,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    session_destroy();
    header("Location: index.html");
}

echo json_encode(['username' => isset($_SESSION['username']) ? $_SESSION['username'] : null,
'email' => isset($_SESSION['email']) ? $_SESSION['email'] : null,
'phone' => isset($_SESSION['phone']) ? $_SESSION['phone'] : null
]);
?>