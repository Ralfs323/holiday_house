<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pārbauda, vai visi nepieciešamie dati ir iesniegti
    if (isset($_POST['user_name']) && isset($_POST['review_text']) && isset($_POST['rating'])) {
        // Atvērt savienojumu ar datubāzi
        $conn = require __DIR__ . "/db/db.php";

        // Saglabā ievadītos datus mainīgajos, izvairoties no SQL injekcijām
        $user_name = htmlspecialchars($_POST['user_name']);
        $review_text = htmlspecialchars($_POST['review_text']);
        $rating = intval($_POST['rating']); // Pārveido vērtējumu par skaitli

        // Ievieto atsauksmi datubāzē
        $stmt = $conn->prepare("INSERT INTO reviews (user_name, review_text, rating) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $user_name, $review_text, $rating);

        if ($stmt->execute()) {
            $success_message = "Review submitted successfully!";
        } else {
            $error_message = "Error submitting review: " . $conn->error;
        }

        // Aizver iepriekš sagatavoto vaicājumu
        $stmt->close();
        // Aizver datubāzes savienojumu
        $conn->close();
    } else {
        $error_message = "Please fill in all required fields.";
    }
}
?>
