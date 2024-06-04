<?php
session_start();

// Iekļauj datubāzes konfigurāciju
require_once __DIR__ . "/db/db.php";

// Pārbauda, vai lietotājs ir autorizējies
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

// Izgūst lietotāja datus no datubāzes
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM user WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Ja lietotājs nav atrasts, izvada kļūdas ziņojumu un beidz skriptu
if ($result->num_rows === 0) {
    echo "Error: User data not found";
    exit();
}

$user = $result->fetch_assoc();
$stmt->close();

// Izgūst rezervāciju datus no datubāzes, kas saistīti ar šo lietotāju
$stmt = $conn->prepare("SELECT * FROM reservations WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$reservation_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            color: #007bff;
            margin-bottom: 20px;
            text-align: center;
        }
        h2 {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 20px;
        }
        form {
            margin-top: 10px;
        }
        input[type="submit"], .button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 16px;
        }
        input[type="submit"]:hover, .button:hover {
            background-color: #0056b3;
        }
        a {
            text-decoration: none;
            color: #007bff;
            margin-right: 10px;
            transition: color 0.3s;
            font-size: 16px;
        }
        a:hover {
            color: #0056b3;
        }
        textarea, select, input[type="number"] {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            margin-bottom: 10px;
            font-size: 16px;
            resize: none;
        }
        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background: url('data:image/svg+xml;utf8,<svg fill="#000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/><path d="M0 0h24v24H0z" fill="none"/></svg>') no-repeat;
            background-position: right 10px top 50%;
            background-size: 20px;
        }
        select::-ms-expand {
            display: none;
        }
        .button.secondary {
            background-color: #6c757d;
        }
        .button.secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>User Profile</h1>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>

    <!-- Reservation list -->
    <h2>Reservations</h2>
    <ul>
        <?php while ($reservation = $reservation_result->fetch_assoc()): ?>
            <li>
                Check-in: <?php echo $reservation['check_in']; ?><br>
                Check-out: <?php echo $reservation['check_out']; ?><br>
                Adults: <?php echo $reservation['adults']; ?><br>
                Children: <?php echo $reservation['children']; ?><br>
                <!-- Add cancellation link or button with appropriate ID -->
                <form method="post" action="cancel_reservation.php" onsubmit="return confirmCancellation()">
                    <input type="hidden" name="reservation_id" value="<?php echo $reservation['id']; ?>">
                    <input type="submit" value="Cancel Reservation" class="button">
                </form>

                <script>
                    function confirmCancellation() {
                        return confirm("Are you sure you want to cancel this reservation?");
                    }
                </script>

                <!-- Add edit link with appropriate reservation ID -->
                <a href="#edit_form_<?php echo $reservation['id']; ?>" onclick="showEditForm(<?php echo $reservation['id']; ?>)" class="button">Edit</a>
                <!-- Edit form (initially hidden) -->
                <div id="edit_form_<?php echo $reservation['id']; ?>" style="display: none;">
                    <form method="post" action="update_reservation.php">
                        <input type="hidden" name="reservation_id" value="<?php echo $reservation['id']; ?>">
                        <!-- Editable fields -->
                        <label for="adults_<?php echo $reservation['id']; ?>">Adults:</label>
                        <input type="number" name="adults" id="adults_<?php echo $reservation['id']; ?>" value="<?php echo $reservation['adults']; ?>">
                        <br>
                        <label for="children_<?php echo $reservation['id']; ?>">Children:</label>
                        <input type="number" name="children" id="children_<?php echo $reservation['id']; ?>" value="<?php echo $reservation['children']; ?>">
                        <br>
                        <input type="submit" value="Save" class="button">
                    </form>
                </div>

            </li>
        <?php endwhile; ?>
    </ul>

    <!-- Form to submit a review -->
    <form method="post" action="submit_review.php">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <label for="review_text">Your Review:</label><br>
        <textarea id="review_text" name="review_text" rows="4" cols="50" required></textarea><br>
        <label for="rating">Your Rating:</label><br>
        <select id="rating" name="rating" required>
            <option value="1">1 star</option>
            <option value="2">2 stars</option>
            <option value="3">3 stars</option>
            <option value="4">4 stars</option>
            <option value="5">5 stars</option>
        </select><br>
        <input type="submit" value="Submit Review" class="button">
    </form>

    <!-- Button to go back to the home page -->
    <a href="index.php" class="button secondary">Back</a>

    <!-- Button to log out -->
    <a href="auth/logout.php" class="button secondary">Logout</a>
</div>

<script>
    // JavaScript function to show/hide edit form
    function showEditForm(reservationId) {
        var editForm = document.getElementById('edit_form_' + reservationId);
        if (editForm.style.display === 'none') {
            editForm.style.display = 'block';
        } else {
            editForm.style.display = 'none';
        }
    }
</script>

</body>
</html>
