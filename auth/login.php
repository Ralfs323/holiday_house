<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$is_invalid = false;
$login_error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/../db/db.php";

    $email = $mysqli->real_escape_string($_POST["email"]);
    $password = $_POST["password"];

    // Fetch user from database
    $sql = "SELECT id, password_hash, is_admin FROM user WHERE email = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user["password_hash"])) {
        if ($user["is_admin"] == 1) { // Check if the user is an admin
            session_regenerate_id();
            $_SESSION["user_id"] = $user["id"];
            header("Location: ../admin/admin_dashboard.php"); // Redirect to admin dashboard
            exit;
        } else {
            session_regenerate_id();
            $_SESSION["user_id"] = $user["id"];
            header("Location: index.php");
            exit;
        }
    } else {
        $login_error = "Invalid email or password";
        $is_invalid = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

<h1>Login</h1>

<?php if ($is_invalid): ?>
    <p><em><?php echo $login_error; ?></em></p>
<?php endif; ?>

<form method="post">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>

    <button type="submit">Log in</button>
</form>

</body>
</html>
