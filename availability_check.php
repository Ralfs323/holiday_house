<?php
// Pārbauda, vai formas dati ir iesniegti
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pārbauda, vai ir norādīts ienākšanas un iziešanas datums
    if (isset($_POST["check_in"]) && isset($_POST["check_out"])) {
        // Izvada ienākšanas un iziešanas datumus
        $check_in = $_POST["check_in"];
        $check_out = $_POST["check_out"];

        // Veiciet šeit kodu, lai pārbaudītu datu pieejamību datubāzē
        // Jūs varat veikt SQL vaicājumu, lai pārbaudītu, vai norādītais laika periods ir pieejams
        // Piemēram, varat pārbaudīt, vai tabulā "reservations" nav rezervāciju, kas sakrīt ar norādīto laika periodu

        // Ja dati ir pieejami, izvadiet veiksmes ziņojumu
        $message = "Success: The selected dates are available.";
    } else {
        // Ja kāds no datiem nav norādīts, izvadiet kļūdas ziņojumu
        $message = "Error: Please provide both check-in and check-out dates.";
    }
} else {
    // Ja forma nav iesniegta, izvadiet kļūdas ziņojumu
    $message = "Error: Form not submitted.";
}
?>

<script>
    alert("<?php echo $message; ?>");
</script>
