<?php
include "../../db/db.php";
include "auth.php";


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

// Delete Image from Gallery
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_image"])) {
    $image_to_delete = $_POST["delete_image"];
    // Delete image file from server
    if (file_exists("../images/" . $image_to_delete)) {
        unlink("../images/" . $image_to_delete);
    }
    // Delete image record from database
    $sql_delete_gallery = "DELETE FROM Gallery WHERE image = '$image_to_delete'";
    if ($conn->query($sql_delete_gallery) === TRUE) {
        $success_message_gallery = "Image deleted from gallery successfully";
    } else {
        $error_message_gallery = "Error deleting image from gallery: " . $conn->error;
    }
}
?>

<h2>Add New Image to Gallery:</h2>
<form method="post" enctype="multipart/form-data">
    <label for="gallery_image">Image:</label><br>
    <input type="file" id="gallery_image" name="gallery_image"><br>
    <input type="submit" value="Add Image">
</form>

<h2>Delete Image from Gallery:</h2>
<form method="post">
    <label for="delete_image">Select Image to Delete:</label><br>
    <select id="delete_image" name="delete_image">
        <?php
        // Get all gallery images from the database
        $sql_select_gallery = "SELECT * FROM Gallery";
        $result_gallery = $conn->query($sql_select_gallery);

        // Check if results are obtained
        if ($result_gallery && $result_gallery->num_rows > 0) {
            // Iterate through each row and display image selection option
            while($row_gallery = $result_gallery->fetch_assoc()) {
                echo '<option value="' . $row_gallery["image"] . '">' . $row_gallery["image"] . '</option>';
            }
        } else {
            echo '<option value="">No images found</option>';
        }
        ?>
    </select><br>
    <input type="submit" value="Delete Image">
</form>
