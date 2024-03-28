<?php
session_start();

$conn = require __DIR__ . "/db/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

// Fetch user data from the database
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM user WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Error: User data not found";
    exit();
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        p {
            margin-bottom: 10px;
        }
        form {
            margin-top: 20px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg fill="#888" width="12" height="12" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg"><path d="M5.999 11L0.292893 5.29289C-0.0976311 4.90237 -0.0976311 4.26948 0.292893 3.87896L0.292893 3.87896C0.683417 3.48844 1.31631 3.48844 1.70684 3.87896L5.999 8.17115L10.2929 3.87896C10.6834 3.48844 11.3163 3.48844 11.7068 3.87896L11.7068 3.87896C12.0974 4.26948 12.0974 4.90237 11.7068 5.29289L6.999 11L5.999 11Z"></path></svg>');
            background-size: 12px;
            background-repeat: no-repeat;
            background-position: right 10px center;
            padding-right: 30px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>User Profile</h1>
    <p>Name: <?php echo htmlspecialchars($user['name']); ?></p>
    <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>

    <form method="post" action="submit_review.php">
        <label for="user_name">Your Name:</label><br>
        <input type="text" id="user_name" name="user_name"><br>
        <label for="review_text">Your Review:</label><br>
        <textarea id="review_text" name="review_text" rows="4" cols="50"></textarea><br>
        <label for="rating">Your Rating:</label><br>
        <select id="rating" name="rating">
            <option value="1">1 star</option>
            <option value="2">2 stars</option>
            <option value="3">3 stars</option>
            <option value="4">4 stars</option>
            <option value="5">5 stars</option>
        </select><br>
        <input type="submit" value="Submit Review">
    </form>
    <a href="index.php">Back</a>

    <a href="auth/logout.php">Logout</a>
</div>
</body>
</html>
