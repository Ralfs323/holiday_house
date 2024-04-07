<?php
session_start();

// Iekļauj datubāzes konfigurāciju
require_once __DIR__ . "/db/db.php";

// Pārbauda, vai lietotājs ir autorizējies
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

// Pārbauda, vai ir saņemts rezervācijas ID
if (!isset($_POST['reservation_id'])) {
    echo "Error: Reservation ID not provided";
    exit();
}

// Izgūst rezervācijas ID no formas
$reservation_id = $_POST['reservation_id'];

// Izveido SQL vaicājumu, lai dzēstu rezervāciju
$sql = "DELETE FROM reservations WHERE id = ?";

// Sagatavo vaicājumu
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $reservation_id);

// Izpilda vaicājumu
if ($stmt->execute()) {
    echo "Reservation successfully canceled.";
} else {
    echo "Error canceling reservation: " . $conn->error;
}

// Aizver sagatavoto paziņojumu un datubāzes savienojumu
$stmt->close();
$conn->close();
?>
