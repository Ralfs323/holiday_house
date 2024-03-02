<?php
include "../db/db.php";

// Fetch existing content from database
$sql_select = "SELECT * FROM about_us";
$result = $conn->query($sql_select);

// Pārbaudām, vai ir rindas atgrieztas no vaicājuma
if ($result && $result->num_rows > 0) {
    // Izgūstam pirmo rindu
    $row = $result->fetch_assoc();
    // Izgūstam saturu no iegūtās rindas
    $existing_content = $row["content"];
} else {
    // Ja nav atgrieztu rindu, definējam `existing_content` ar kaut kādu noklusējuma vērtību
    $existing_content = "No content available";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
</head>
<body>
<h2>Current Content:</h2>
<p><?php echo $existing_content; ?></p>

<h2>Update Content:</h2>
<form method="post" action="update_content.php">
    <label for="new_content">New Content:</label><br>
    <textarea id="new_content" name="new_content" rows="4" cols="50"></textarea><br>
    <input type="submit" value="Update Content">
</form>
</body>
</html>
