<?php
session_start();
header('Content-Type: application/json');

// Iekļauj datubāzes konfigurāciju
require_once __DIR__ . "/db/db.php";

$response = ["status" => "error", "message" => "Invalid request"];

// Pārbauda, vai lietotājs ir autorizējies
if (!isset($_SESSION['user_id'])) {
    $response["message"] = "User not authenticated";
    echo json_encode($response);
    exit();
}

// Pārbauda, vai ir saņemts rezervācijas ID
if (!isset($_POST['reservation_id'])) {
    $response["message"] = "Reservation ID not provided";
    echo json_encode($response);
    exit();
}

// Izgūst rezervācijas ID no formas
$reservation_id = intval($_POST['reservation_id']);
$user_id = $_SESSION['user_id'];

// Izveido SQL vaicājumu, lai dzēstu rezervāciju
$sql = "DELETE FROM reservations WHERE id = ? AND user_id = ?";

// Sagatavo vaicājumu
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    $response["message"] = "Failed to prepare statement: " . $conn->error;
    echo json_encode($response);
    exit();
}
$stmt->bind_param("ii", $reservation_id, $user_id);

// Izpilda vaicājumu
if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        $response["status"] = "success";
        $response["message"] = "Reservation successfully canceled.";
    } else {
        $response["message"] = "No reservation found or not authorized.";
    }
} else {
    $response["message"] = "Error canceling reservation: " . $conn->error;
}

// Aizver sagatavoto paziņojumu un datubāzes savienojumu
$stmt->close();
$conn->close();

echo json_encode($response);
?>
