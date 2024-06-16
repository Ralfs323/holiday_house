
<?php
session_start();

// Include database configuration
require_once __DIR__ . "/db/db.php";

// Check if user is authorized
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

// Fetch user data from database
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM user WHERE id = ?");
if ($stmt === false) {
    die("Error: " . $conn->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// If user is not found, display error message and exit script
if ($result->num_rows === 0) {
    die("Error: User data not found");
}

$user = $result->fetch_assoc();
$stmt->close();

// Fetch reservations data related to this user
$stmt = $conn->prepare("SELECT * FROM reservations WHERE user_id = ?");
if ($stmt === false) {
    die("Error: " . $conn->error);
}
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
            font-family: 'Roboto', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            color: #333;
            line-height: 1.6;
        }
        /* Container styles */
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        /* Header styles */
        h1, h2 {
            color: #007bff;
            text-align: center;
        }
        h2 {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-top: 20px;
        }
        /* List styles */
        ul {
            padding: 0;
            list-style-type: none;
            margin-top: 0;
        }
        li {
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        li:not(:last-child) {
            margin-bottom: 30px;
        }
        .reservation-details {
            margin-bottom: 10px;
        }
        /* Form and button styles */
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
        /* Form input styles */
        textarea, select, input[type="number"] {
            width: calc(100% - 22px); /* Adjusted for padding and border */
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
        /* Button styles */
        .button.secondary {
            background-color: #6c757d;
        }
        .button.secondary:hover {
            background-color: #5a6268;
        }
        /* Edit form styles */
        .edit-form {
            background-color: #f0f0f0;
            padding: 10px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-top: 10px;
            display: none; /* Initially hidden */
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
    <ul id="reservation-list">
        <?php while ($reservation = $reservation_result->fetch_assoc()): ?>
            <li id="reservation_<?php echo htmlspecialchars($reservation['id']); ?>">
                <div class="reservation-details">
                    <strong>Check-in:</strong> <?php echo htmlspecialchars($reservation['check_in']); ?><br>
                    <strong>Check-out:</strong> <?php echo htmlspecialchars($reservation['check_out']); ?><br>
                    <strong>Adults:</strong> <?php echo htmlspecialchars($reservation['adults']); ?><br>
                    <strong>Children:</strong> <?php echo htmlspecialchars($reservation['children']); ?><br>
                </div>

                <!-- Cancel button -->
                <form onsubmit="cancelReservation(event, <?php echo htmlspecialchars($reservation['id']); ?>)">
                    <input type="submit" value="Cancel" class="button">
                </form>

                <!-- Edit button -->
                <a href="#" onclick="showEditForm(<?php echo htmlspecialchars($reservation['id']); ?>)" class="button">Edit</a>

                <!-- Edit form (initially hidden) -->
                <div id="edit_form_<?php echo htmlspecialchars($reservation['id']); ?>" class="edit-form">
                    <form method="post" action="update_reservation.php">
                        <input type="hidden" name="reservation_id" value="<?php echo htmlspecialchars($reservation['id']); ?>">
                        <label for="adults_<?php echo htmlspecialchars($reservation['id']); ?>">Adults:</label>
                        <input type="number" name="adults" id="adults_<?php echo htmlspecialchars($reservation['id']); ?>" value="<?php echo htmlspecialchars($reservation['adults']); ?>">
                        <br>
                        <label for="children_<?php echo htmlspecialchars($reservation['id']); ?>">Children:</label>
                        <input type="number" name="children" id="children_<?php echo htmlspecialchars($reservation['id']); ?>" value="<?php echo htmlspecialchars($reservation['children']); ?>">
                        <br>
                        <input type="submit" value="Save" class="button">
                    </form>
                </div>
            </li>
        <?php endwhile; ?>
    </ul>

    <!-- Review submission form -->
    <form method="post" action="">
        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
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

    <!-- Navigation buttons -->
    <div style="text-align: center; margin-top: 20px;">
        <a href="index.php" class="button secondary">Back</a>
        <a href="auth/logout.php" class="button secondary">Logout</a>
    </div>
</div>

<script>
    function cancelReservation(event, reservationId) {
        event.preventDefault();
        if (!confirm("Are you sure you want to cancel this reservation?")) {
            return;
        }

        const formData = new FormData();
        formData.append('reservation_id', reservationId);

        fetch('cancel_reservation.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById('reservation_' + reservationId).remove();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while cancelling the reservation.');
            });
    }

    function showEditForm(reservationId) {
        const editForm = document.getElementById('edit_form_' + reservationId);
        editForm.style.display = (editForm.style.display === 'none') ? 'block' : 'none';
    }
</script>

</body>
</html>

<?php
// Close database connection
$conn->close();
?>

