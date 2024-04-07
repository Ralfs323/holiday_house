<?php
// Include database configuration
include_once "db/db.php";

// Get reserved dates from the database
$sql = "SELECT check_in, check_out FROM reservations";
$result = $conn->query($sql);

$reserved_dates = array();
while ($row = $result->fetch_assoc()) {
    $start_date = new DateTime($row['check_in']);
    $end_date = new DateTime($row['check_out']);
    $interval = new DateInterval('P1D'); // Check each date individually
    $date_range = new DatePeriod($start_date, $interval, $end_date->modify('+1 day'));

    foreach ($date_range as $date) {
        $reserved_dates[] = $date->format("Y-m-d");
    }
}

// Return reserved dates as JSON
echo json_encode(array("reserved_dates" => $reserved_dates));

// Close database connection
$conn->close();
?>
