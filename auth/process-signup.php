<?php
session_start();

// Validate input
if (
    empty($_POST["name"]) || empty($_POST["surname"]) ||
    empty($_POST["email"]) || empty($_POST["password"]) ||
    empty($_POST["password_confirmation"])
) {
    die("All fields are required");
}

$name = htmlspecialchars($_POST["name"]);
$surname = htmlspecialchars($_POST["surname"]);
$email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
$password = $_POST["password"];
$password_confirmation = $_POST["password_confirmation"];

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format");
}

// Validate password criteria
if (strlen($password) < 8 || !preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,20}$/", $password)) {
    die("Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji");
}

// Check if passwords match
if ($password !== $password_confirmation) {
    die("Passwords do not match");
}

// Hash the password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Database connection (replace with your actual database credentials)
$mysqli = new mysqli("localhost", "root", "root", "login_db");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Check if email already exists
$sql_check_email = "SELECT * FROM user WHERE email = ?";
$stmt_check_email = $mysqli->prepare($sql_check_email);
if (!$stmt_check_email) {
    die("Prepare failed: " . $mysqli->error);
}
$stmt_check_email->bind_param("s", $email);
$stmt_check_email->execute();
$result_check_email = $stmt_check_email->get_result();

if ($result_check_email->num_rows > 0) {
    die("Email already taken");
}

// Insert the new user
$sql_insert_user = "INSERT INTO user (name, surname, email, password_hash, is_admin) VALUES (?, ?, ?, ?, 0)";
$stmt_insert_user = $mysqli->prepare($sql_insert_user);
if (!$stmt_insert_user) {
    die("Prepare failed: " . $mysqli->error);
}
$stmt_insert_user->bind_param("ssss", $name, $surname, $email, $password_hash);

if ($stmt_insert_user->execute()) {
    $_SESSION['signup_success'] = true;
    $_SESSION['message'] = "Registration successful!";
    header("Location: /index.php");
    exit;
} else {
    die("Execute failed: " . $stmt_insert_user->error);
}

$stmt_check_email->close();
$stmt_insert_user->close();
$mysqli->close();
?>
