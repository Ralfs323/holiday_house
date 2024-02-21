<?php
include "../../db/db.php";
include "auth.php";


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

<h2>Add New Room Price:</h2>
<form method="post" enctype="multipart/form-data">
    <label for="price">Price:</label><br>
    <input type="text" id="price" name="price"><br>
    <label for="description">Description:</label><br>
    <input type="text" id="description" name="description"><br>
    <label for="image">Image:</label><br>
    <input type="file" id="image" name="image"><br>
    <input type="submit" value="Add Room Price">
</form>
