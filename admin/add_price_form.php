<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Room Price</title>
</head>
<body>
<h2>Add New Room Price:</h2>
<form method="post" enctype="multipart/form-data">
    <label for="price">Price:</label><br>
    <input type="number" id="price" name="price"><br>
    <label for="description">Description:</label><br>
    <input type="text" id="description" name="description"><br>
    <label for="image">Image:</label><br>
    <input type="file" id="image" name="image" required><br>
    <input type="submit" value="Add Room Price">
</form>
</body>
</html>
