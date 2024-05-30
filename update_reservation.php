<?php
// Iekļauj datubāzes konfigurāciju
require_once __DIR__ . "/db/db.php";

// Pārbauda, vai forma ir iesniegta
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pārbauda, vai ir nosūtīts rezervācijas ID
    if (isset($_POST['reservation_id'])) {
        // Iegūst rezervācijas ID no formas
        $reservation_id = $_POST['reservation_id'];

        // Pārbauda, vai pieaugušo un bērnu skaiti ir nosūtīti
        if (isset($_POST['adults']) && isset($_POST['children'])) {
            // Iegūst pieaugušo un bērnu skaitu no formas
            $adults = $_POST['adults'];
            $children = $_POST['children'];

            // Sagatavo SQL pieprasījumu, lai atjaunotu rezervācijas datus
            $sql = "UPDATE reservations SET adults = ?, children = ? WHERE id = ?";

            // Izpilda SQL pieprasījumu, izmantojot sagatavoto apgalvojumu
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $adults, $children, $reservation_id);

            // Pārbauda, vai apgalvojums ir izpildījies veiksmīgi
            if ($stmt->execute()) {
                // Ja rezervācija ir veiksmīgi atjaunota, pārvirza lietotāju atpakaļ uz profilu
                header("Location: profile.php");
            } else {
                // Ja kaut kas nokļūst greizi, izvada kļūdas ziņojumu
                echo "Error updating reservation: " . $conn->error;
            }

            // Aizver sagatavoto apgalvojumu
            $stmt->close();
        } else {
            // Ja kāds no laukiem nav nosūtīts, izvada kļūdas ziņojumu
            echo "Error: Missing required fields.";
        }
    } else {
        // Ja rezervācijas ID nav nosūtīts, izvada kļūdas ziņojumu
        echo "Error: Reservation ID not provided.";
    }
} else {
    // Ja forma nav nosūtīta, pārvirza lietotāju atpakaļ uz sākuma lapu
    header("Location: index.php");
}
?>
