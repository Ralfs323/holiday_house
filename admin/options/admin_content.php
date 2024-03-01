<?php
include "../../db/db.php";
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

// Fetch existing content from database
$sql_select = "SELECT * FROM about_us";
$result = $conn->query($sql_select);

// Check if there are rows returned from the query
if ($result && $result->num_rows > 0) {
    // Fetch the first row
    $row = $result->fetch_assoc();
    // Get the content from the fetched row
    $existing_content = $row["content"];
} else {
    // If no rows are returned, set existing_content to null
    $existing_content = null;
}

// Check if form is submitted and if 'new_content' is set in $_POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["new_content"])) {
    // Get new content from form
    $new_content = $_POST["new_content"];

    // Update content in database
    $sql_update = "UPDATE about_us SET content = '$new_content'";
    if ($conn->query($sql_update) === TRUE) {
        $success_message = "Content updated successfully";
    } else {
        $error_message = "Error updating content: " . $conn->error;
    }
}
?>

<h2>Current Content:</h2>
<p><?php echo $existing_content; ?></p>

<h2>Update Content:</h2>
<form method="post">
    <label for="new_content">New Content:</label><br>
    <textarea id="new_content" name="new_content" rows="4" cols="50"></textarea><br>
    <input type="submit" value="Update Content">
</form>
