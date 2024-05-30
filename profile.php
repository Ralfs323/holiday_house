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
        /* Iekļaujiet CSS stila definīcijas šeit */
    </style>
</head>
<body>
<div class="container">
    <h1>User Profile</h1>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>

    <!-- Rezervāciju saraksts -->
    <h2>Reservations</h2>
    <ul>
        <?php while ($reservation = $reservation_result->fetch_assoc()): ?>
            <li>
                Check-in: <?php echo $reservation['check_in']; ?><br>
                Check-out: <?php echo $reservation['check_out']; ?><br>
                Adults: <?php echo $reservation['adults']; ?><br>
                Children: <?php echo $reservation['children']; ?><br>
                <!-- Pievienojiet atcelšanas saiti vai pogu ar atbilstošu ID -->
                <form method="post" action="cancel_reservation.php" onsubmit="return confirmCancellation()">
                    <input type="hidden" name="reservation_id" value="<?php echo $reservation['id']; ?>">
                    <input type="submit" value="Cancel Reservation">
                </form>

                <script>
                    function confirmCancellation() {
                        return confirm("Are you sure you want to cancel this reservation?");
                    }
                </script>

                <!-- Pievieno rediģēšanas saiti ar atbilstošu rezervācijas ID -->
                <a href="#edit_form_<?php echo $reservation['id']; ?>" onclick="showEditForm(<?php echo $reservation['id']; ?>)">Edit</a>
                <!-- Rediģēšanas forma (sākotnēji paslēpta) -->
                <div id="edit_form_<?php echo $reservation['id']; ?>" style="display: none;">
                    <form method="post" action="update_reservation.php"> <!-- Action norāda uz failu, kurš apstrādās rediģēšanas datus -->
                        <input type="hidden" name="reservation_id" value="<?php echo $reservation['id']; ?>">
                        <!-- Rediģējamie lauki -->
                        <label for="adults_<?php echo $reservation['id']; ?>">Adults:</label>
                        <input type="number" name="adults" id="adults_<?php echo $reservation['id']; ?>" value="<?php echo $reservation['adults']; ?>">
                        <br>
                        <label for="children_<?php echo $reservation['id']; ?>">Children:</label>
                        <input type="number" name="children" id="children_<?php echo $reservation['id']; ?>" value="<?php echo $reservation['children']; ?>">
                        <br>
                        <input type="submit" value="Save">
                    </form>
                </div>
            </li>
        <?php endwhile; ?>
    </ul>

    <!-- Forma, lai iesniegtu atsauksmi -->
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
        <input type="submit" value="Submit Review">
    </form>

    <!-- Poga, lai atgrieztos uz sākuma lapu -->
    <a href="index.php">Back</a>

    <!-- Poga, lai izietu no konta -->
    <a href="auth/logout.php">Logout</a>
</div>
</body>
</html>

<script>
    // JavaScript funkcija, lai rādītu/ēnu rediģēšanas formu
    function showEditForm(reservationId) {
        var editForm = document.getElementById('edit_form_' + reservationId);
        if (editForm.style.display === 'none') {
            editForm.style.display = 'block';
        } else {
            editForm.style.display = 'none';
        }
    }
</script>
