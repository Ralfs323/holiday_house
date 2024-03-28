<?php
include "../db/db.php";
include "manage_reviews.php";

// Pārbaudām, vai lietotājs ir autentificējies un ir administrators
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: /auth/login.php"); // Ja lietotājs nav autentificējies vai nav administrators, novirzīt uz autentifikācijas lapu
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["review_id"]) && isset($_POST["action"])) {
    $review_id = $_POST["review_id"];
    $action = $_POST["action"];

    // Update review status in the database
    $sql_update_review = "UPDATE Reviews SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql_update_review);
    $stmt->bind_param("si", $action, $review_id);

    if ($stmt->execute()) {
        $success_message = "Review status updated successfully";
    } else {
        $error_message = "Error updating review status: " . $stmt->error;
    }
}

// Retrieve reviews from the database
$sql_select_reviews = "SELECT * FROM Reviews";
$result_reviews = $conn->query($sql_select_reviews);

// Check for database errors
if (!$result_reviews) {
    $error_message = "Error retrieving reviews: " . $conn->error;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Reviews</title>
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>
<div class="container">
    <h1>Admin Reviews</h1>

    <?php if(isset($success_message)): ?>
        <div class="success-alert"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <?php if(isset($error_message)): ?>
        <div class="error"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <table>
        <tr>
            <th>Review ID</th>
            <th>Review Text</th>
            <th>Rating</th>
            <th>User Name</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php if ($result_reviews->num_rows > 0): ?>
            <?php while($row_review = $result_reviews->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row_review["id"]; ?></td>
                    <td><?php echo $row_review["review_text"]; ?></td>
                    <td><?php echo $row_review["rating"]; ?></td>
                    <td><?php echo $row_review["user_name"]; ?></td>
                    <td><?php echo $row_review["status"]; ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="review_id" value="<?php echo $row_review["id"]; ?>">
                            <select name="action">
                                <option value="pending" <?php if ($row_review["status"] === "pending") echo "selected"; ?>>Pending</option>
                                <option value="approved" <?php if ($row_review["status"] === "approved") echo "selected"; ?>>Approved</option>
                                <option value="rejected" <?php if ($row_review["status"] === "rejected") echo "selected"; ?>>Rejected</option>
                            </select>
                            <button type="submit">Update Status</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6">No reviews found</td></tr>
        <?php endif; ?>
    </table>
</div>
</body>
</html>
