<?php
include "../db/db.php";
// --> About Us <--
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

// --> Prices <--
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

// --> Gallery <--
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

// --> Reviews <--
// Check if POST form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if review ID and status are obtained
    if (isset($_POST["review_id"]) && isset($_POST["status"])) {
        $review_id = $_POST["review_id"];
        $status = $_POST["status"];

        // Update review status in the database
        $sql_update = "UPDATE Reviews SET status = '$status' WHERE id = $review_id";

        if ($conn->query($sql_update) === TRUE) {
            $success_message = "Review status updated successfully";
        } else {
            $error_message = "Error updating review status: " . $conn->error;
        }
    }
}

// Get all reviews from the database
$sql_select_reviews = "SELECT * FROM Reviews";
$result_reviews = $conn->query($sql_select_reviews);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin-style.css">

</head>
<body>
<div class="container">
    <a href="/auth/logout.php">Logout</a>

    <h1>Admin Dashboard</h1>

    <!--
<?php if(isset($success_message)): ?>
        <script>
            alert("<?php echo $success_message; ?>");
        </script>
<?php endif; ?>

<?php if(isset($error_message)): ?>
        <div class="error"><?php echo $error_message; ?></div>
<?php endif; ?>
-->


    <?php if(isset($existing_content)): ?>
        <h2>Current Content:</h2>
        <p><?php echo $existing_content; ?></p>
    <?php endif; ?>

    <h2>Update Content:</h2>
    <form method="post">
        <label for="new_content">New Content:</label><br>
        <textarea id="new_content" name="new_content" rows="4" cols="50"></textarea><br>
        <input type="submit" value="Update Content">
    </form>

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

    <h2>Add New Image to Gallery:</h2>
    <form method="post" enctype="multipart/form-data">
        <label for="gallery_image">Image:</label><br>
        <input type="file" id="gallery_image" name="gallery_image"><br>
        <input type="submit" value="Add Image">
    </form>

<!--    --><?php //if(isset($success_message_gallery)): ?>
<!--        <div class="success-alert">--><?php //echo $success_message_gallery; ?><!--</div>-->
<!--    --><?php //endif; ?>
<!--    --><?php //if(isset($error_message_gallery)): ?>
<!--        <div class="error">--><?php //echo $error_message_gallery; ?><!--</div>-->
<!--    --><?php //endif; ?>

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

    <?php if($result_reviews->num_rows > 0): ?>
        <h2>All Reviews:</h2>
        <ul>
            <?php while($row_review = $result_reviews->fetch_assoc()): ?>
                <li>
                    <form method="post">
                        <input type="hidden" name="review_id" value="<?php echo $row_review["id"]; ?>">
                        <p><?php echo $row_review["review_text"]; ?></p>
                        <p>Rating: <?php echo $row_review["rating"]; ?></p>
                        <p>Author: <?php echo $row_review["user_name"]; ?></p>
                        <select name="status">
                            <option value="pending" <?php if($row_review["status"] == "pending") echo "selected"; ?>>Pending</option>
                            <option value="approved" <?php if($row_review["status"] == "approved") echo "selected"; ?>>Approved</option>
                            <option value="rejected" <?php if($row_review["status"] == "rejected") echo "selected"; ?>>Rejected</option>
                        </select>
                        <button type="submit">Update Status</button>
                    </form>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No reviews found.</p>
    <?php endif; ?>


</div>
</body>
</html>

