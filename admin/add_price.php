<?php
include "../db/db.php";
session_start();

// Pārbaudām, vai lietotājs ir autentificējies
if (!isset($_SESSION['user_id'])) {
    header("Location: /auth/login.php"); // Ja lietotājs nav autentificējies, novirzīt uz autentifikācijas lapu
    exit;
}

// Pārbaudām, vai lietotājs ir administrators
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    // Ja lietotājs nav administrators, novirzīt uz kļūdas lapu vai citu atbilstošu vietni
    header("Location: /error.php");
    exit;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if variables are defined and obtained from the form
    if (isset($_POST["price"]) && isset($_POST["description"]) && isset($_FILES["image"]["name"])) {
        // Get data from form
        $price = $_POST["price"];
        $description = $_POST["description"];

        // Upload image file
        $target_dir = "../images/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

        // Insert data into database
        $sql_insert = "INSERT INTO RoomPrices (price, description, image) VALUES ('$price', '$description', '$target_file')";
        if ($conn->query($sql_insert) === TRUE) {
            $success_message = "New room price added successfully";
        } else {
            $error_message = "Error adding room price: " . $conn->error;
        }
    } else {
        $error_message = "Please fill in all required fields";
    }
}
?>
