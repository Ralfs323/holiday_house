<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$is_invalid = false;
$login_error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if(isset($_POST["email"]) && isset($_POST["password"])) { // Check if both email and password are set
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
            session_regenerate_id();
            $_SESSION["user_id"] = $user["id"];

            // Set is_admin session variable if the user is an admin
            if ($user["is_admin"] == 1) {
                $_SESSION["is_admin"] = true;
                header("Location: index.php"); // Redirect to admin dashboard
            } else {
                $_SESSION["is_admin"] = false;
                header("Location: index.php"); // Redirect to regular user page
            }
            exit;
        } else {
            $login_error = "Invalid email or password";
            $is_invalid = true;
        }
    } else {
        $login_error = "Email or password field is empty";
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
    <input type="email" name="email" id="email" autocomplete="email" required>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>

    <button type="submit" class="btn">Log in</button>
</form>

</body>
</html>