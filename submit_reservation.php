<?php
session_start();
// Pārbauda, vai lietotājs ir autorizējies
if (!isset($_SESSION['user_id'])) {
header("Location: auth/login.php");
exit();
}

// Iegūst lietotāja ID no sesijas
$user_id = $_SESSION['user_id'];

// Iekļauj datubāzes konfigurāciju
include_once "db/db.php";

// Iegūst formas datus
$name = $_POST['name'];
$email = $_POST['email'];
$check_in = $_POST['check_in'];
$check_out = $_POST['check_out'];
$adults = $_POST['adults'];
$children = $_POST['children'];

// Pārbauda, vai izvēlētie datumi jau ir rezervēti
$sql_check = "SELECT * FROM reservations
WHERE ('$check_in' BETWEEN check_in AND check_out
OR '$check_out' BETWEEN check_in AND check_out)";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows > 0) {
// Ja datumi jau ir rezervēti, parādiet kļūdas ziņojumu
echo "Error: The selected dates are already booked.";
} else {
// Pārbauda, vai ir pieejami izvēlētie datumi
$sql_availability_check = "SELECT * FROM reservations
WHERE check_in <= '$check_out' AND check_out >= '$check_in'";
$result_availability_check = $conn->query($sql_availability_check);

if ($result_availability_check->num_rows > 0) {
// Ja datumi ir aizņemti citai rezervācijai, parādiet kļūdas ziņojumu
echo "Error: The selected dates are not available.";
} else {
// Ja datumi ir pieejami, turpiniet ar rezervāciju
    $user_id = $_SESSION['user_id'];
// Iegūst lietotāja ID no sesijas

    $sql = "INSERT INTO reservations (name, email, check_in, check_out, adults, children, user_id)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssiii",  $name, $email, $check_in, $check_out, $adults, $children, $user_id,);


// Izpilda vaicājumu
if ($stmt->execute()) {
// Pāradresē uz index.php ar veiksmes ziņojumu
header("Location: index.php?success=1");
exit;
} else {
echo "Error: " . $sql . "<br>" . $conn->error;
}

// Aizver sagatavoto paziņojumu
$stmt->close();
}
}

// Aizver datubāzes savienojumu
$conn->close();
