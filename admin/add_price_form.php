<?php include "add_price.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Room Price</title>
</head>
<body>
<h2>Add New Room Price:</h2>
<?php
if (isset($error_message)) {
    echo "<p>Error: $error_message</p>";
}
if (isset($success_message)) {
    echo "<p>Success: $success_message</p>";
}
?>
<form method="post" enctype="multipart/form-data">
    <label for="price">Price:</label><br>
    <input type="text" id="price" name="price"><br>
    <label for="description">Description:</label><br>
    <input type="text" id="description" name="description"><br>
    <label for="image">Image:</label><br>
    <input type="file" id="image" name="image"><br>
    <input type="submit" value="Add Room Price">
</form>
</body>
</html>
