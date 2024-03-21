<?php
include "../db/db.php";

// Pārbaudām, vai lietotājs ir autentificējies
if (!isset($_SESSION['user_id'])) {
    header("Location: /auth/login.php"); // Ja lietotājs nav autentificējies, novirzīt uz autentifikācijas lapu
    exit;
}

// Pārbaudām, vai lietotājs ir administrators
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    // Ja lietotājs nav administrators, novirzīt uz kļūdas lapu vai citu atbilstošu vietni
    header("Location: /error.php");
    exit;
}

// Ja forma ir nosūtīta, pārbaudām un apstrādām atsauksmes statusa maiņas
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["review_id"]) && isset($_POST["action"])) {
    $review_id = $_POST["review_id"];
    $action = $_POST["action"];

    // Atjaunot atsauksmes statusu datubāzē
    $sql_update_review = "UPDATE Reviews SET status = '$action' WHERE id = $review_id";

    if ($conn->query($sql_update_review) === TRUE) {
        $success_message = "Review status updated successfully";
    } else {
        $error_message = "Error updating review status: " . $conn->error;
    }
}



// Izgūstam visas atsauksmes no datubāzes
$sql_select_reviews = "SELECT * FROM Reviews";
$result_reviews = $conn->query($sql_select_reviews);
?>
