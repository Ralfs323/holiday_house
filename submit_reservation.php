<?php
// Iekļauj datubāzes konfigurāciju
include_once "db/db.php";

// Iegūst formas datus
$name = $_POST['name'];
$email = $_POST['email'];
$check_in = $_POST['check_in'];
$check_out = $_POST['check_out'];
$adults = $_POST['adults'];
$children = $_POST['children'];

// SQL vaicājums, lai pārbaudītu, vai izvēlētie datumi jau ir rezervēti
$sql_check = "SELECT * FROM reservations 
              WHERE ('$check_in' BETWEEN check_in AND check_out 
              OR '$check_out' BETWEEN check_in AND check_out)";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows > 0) {
    // Ja datumi jau ir rezervēti, parādiet kļūdas ziņojumu
    echo "Error: The selected dates are already booked.";
} else {
    // Ja datumi ir pieejami, turpiniet ar rezervāciju
    $sql = "INSERT INTO reservations (name, email, check_in, check_out, adults, children)
            VALUES (?, ?, ?, ?, ?, ?)";

    // Sagatavo vaicājumu
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", $name, $email, $check_in, $check_out, $adults, $children);

    // Izpilda vaicājumu
    if ($stmt->execute()) {
        // Pāradresē uz index.php ar veiksmes ziņojumu
        header("Location: index.php?success=1");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Aizver prepared statement
    $stmt->close();
}

// Aizver datubāzes savienojumu
$conn->close();
?>
