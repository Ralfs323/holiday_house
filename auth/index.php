<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: /auth/login.php");
    exit();
}

$mysqli = require __DIR__ . "/../db/db.php";

if (!($mysqli instanceof mysqli)) {
    echo "<p>Error: Database connection failed</p>";
    exit();
}

$sql = "SELECT * FROM user WHERE id = ?";
$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    echo "<p>Error preparing SQL statement: " . $mysqli->error . "</p>";
    exit();
}

$stmt->bind_param("i", $_SESSION["user_id"]);

if (!$stmt->execute()) {
    echo "<p>Error executing SQL statement: " . $stmt->error . "</p>";
    $stmt->close();
    exit();
}

$result = $stmt->get_result();
$stmt->close();

if (!$result) {
    echo "<p>Error: User not found</p>";
    exit();
}

$user = $result->fetch_assoc();

if (!$user) {
    echo "<p>Error: User not found</p>";
    exit();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <meta charset="UTF-8">
</head>
<body>

<h1>Home</h1>

<p>Hello <?= htmlspecialchars($user["name"]) ?></p>
<p><a href="/auth/logout.php">Log out</a></p>

</body>
</html>
