<?php
session_start();

// Validate and sanitize inputs
$name = htmlspecialchars($_POST["name"]);
$surname = htmlspecialchars($_POST["surname"]);
$email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
$password = $_POST["password"];
$password_confirmation = $_POST["password_confirmation"];

// Basic input validation
$errors = [];

if (empty($name)) {
    $errors[] = "Name is required";
}

if (empty($surname)) {
    $errors[] = "Surname is required";
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Valid email is required";
}

if (strlen($password) < 8) {
    $errors[] = "Password must be at least 8 characters";
}

if (!preg_match("/[a-zA-Z]/", $password)) {
    $errors[] = "Password must contain at least one letter";
}

if (!preg_match("/[0-9]/", $password)) {
    $errors[] = "Password must contain at least one number";
}

if ($password !== $password_confirmation) {
    $errors[] = "Passwords do not match";
}

// If there are errors, display them and exit
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
    exit;
}

// Hash the password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Database connection (replace with your own connection details)
$mysqli = new mysqli("localhost", "username", "password", "database");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Prepare SQL statement
$sql = "INSERT INTO user (name, surename, email, password_hash)
        VALUES (?, ?, ?, ?)";
$stmt = $mysqli->prepare($sql);

// Bind parameters and execute statement
$stmt->bind_param("ssss", $name, $surname, $email, $password_hash);

if ($stmt->execute()) {
    // Signup success
    $_SESSION['signup_success'] = true;
    header("Location: /index.php");
    exit;
} else {
    if ($mysqli->errno === 1062) {
        // Duplicate entry error (email already taken)
        echo "Email already taken";
    } else {
        // Other SQL error
        echo "SQL error: " . $mysqli->error;
    }
}

// Close statement and connection
$stmt->close();
$mysqli->close();
?>
