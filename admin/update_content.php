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


// Check if form is submitted and if 'new_content' is set in $_POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["new_content"])) {
    // Get new content from form
    $new_content = $_POST["new_content"];

    // Update content in database
    $sql_update = "UPDATE about_us SET content = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("s", $new_content);
    if ($stmt->execute()) {
        $success_message = "Content updated successfully";
    } else {
        $error_message = "Error updating content: " . $conn->error;
    }
}

header("Location: admin_dashboard.php")
?>
