<?php
include "../db/db.php";

// Pārbaudām, vai lietotājs ir autentificējies un ir administrators
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: /auth/login.php"); // Ja lietotājs nav autentificējies vai nav administrators, novirzīt uz autentifikācijas lapu
    exit;
}

// Add New Image to Gallery
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["gallery_image"]["name"])) {
    // Upload image file
    $target_dir = "../images/";
    $target_file = $target_dir . basename($_FILES["gallery_image"]["name"]);
    move_uploaded_file($_FILES["gallery_image"]["tmp_name"], $target_file);

    // Insert data into database
    $sql_insert_gallery = "INSERT INTO Gallery (image) VALUES ('$target_file')";
    if ($conn->query($sql_insert_gallery) === TRUE) {
        $success_message_gallery = "New image added to gallery successfully";
    } else {
        $error_message_gallery = "Error adding image to gallery: " . $conn->error;
    }
}
?>

<h2>Add New Image to Gallery:</h2>
<form method="post" enctype="multipart/form-data">
    <label for="gallery_image">Image:</label><br>
    <input type="file" id="gallery_image" name="gallery_image"><br>
    <input type="submit" value="Add Image">
</form>

