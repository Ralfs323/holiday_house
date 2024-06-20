<?php
$is_invalid = false;
$signup_error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate name
    if(empty($_POST["name"])) {
        $signup_error = "Name field is empty";
        $is_invalid = true;
    }

    // Validate surname
    if(empty($_POST["surname"])) {
        $signup_error = "Surname field is empty";
        $is_invalid = true;
    }

    // Validate email
    if(empty($_POST["email"])) {
        $signup_error = "Email field is empty";
        $is_invalid = true;
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $signup_error = "Invalid email format";
        $is_invalid = true;
    }

    // Validate password
    if(empty($_POST["password"])) {
        $signup_error = "Password field is empty";
        $is_invalid = true;
    } elseif (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,20}$/", $_POST["password"])) {
        $signup_error = "Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji";
        $is_invalid = true;
    }

    // Validate password confirmation
    if(empty($_POST["password_confirmation"])) {
        $signup_error = "Password confirmation field is empty";
        $is_invalid = true;
    } elseif ($_POST["password"] !== $_POST["password_confirmation"]) {
        $signup_error = "Password and password confirmation do not match";
        $is_invalid = true;
    }

    // Proceed only if no validation errors
    if(!$is_invalid) {
        header("Location: /auth/process-signup.php?" . http_build_query($_POST));
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
</head>
<body>

<form action="/auth/process-signup.php" method="post" id="signup" novalidate>
    <h1>Signup</h1>

    <?php if ($is_invalid): ?>
        <p><em><?php echo $signup_error; ?></em></p>
    <?php endif; ?>

    <div>
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="<?php echo isset($_POST["name"]) ? htmlspecialchars($_POST["name"]) : ''; ?>">
    </div>

    <div>
        <label for="surname">Surname</label>
        <input type="text" id="surname" name="surname" value="<?php echo isset($_POST["surname"]) ? htmlspecialchars($_POST["surname"]) : ''; ?>">
    </div>

    <div>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : ''; ?>">
    </div>

    <div>
        <label for="password">Password</label>
        <input type="password" id="password" name="password">
        <small id="passwordHelpBlock" class="form-text text-muted">
            Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.
        </small>
    </div>

    <div>
        <label for="password_confirmation">Repeat password</label>
        <input type="password" id="password_confirmation" name="password_confirmation">
    </div>

    <button type="submit" class="btn">Sign Up</button>
</form>

</body>
</html>
