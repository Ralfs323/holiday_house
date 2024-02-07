<?php

$is_invalid = false;
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/../db/db.php";

    $sql = "SELECT * FROM user WHERE email = ?";

    $stmt = $mysqli->prepare($sql);

    $stmt->bind_param("s", $_POST["email"]);
    $stmt->execute();

    $result = $stmt->get_result();

    $user = $result->fetch_assoc();

    if ($user && password_verify($_POST["password"], $user["password_hash"])) {
        session_regenerate_id();

        $_SESSION["user_id"] = $user["id"];

        header("Location: login.php");
        exit;
    } else {
        $is_invalid = true;
        $error_message = 'Invalid email or password.';
    }
}
?>
