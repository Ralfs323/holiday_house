<?php
include "../db/db.php";
session_start();

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>
<div class="container">
    <a href="<?php echo isset($_SESSION['user_id']) ? '/auth/logout.php' : '/prakse-holiday_house/admin/admin_dashboard.php'; ?>">Logout</a>

    <h1>Admin Dashboard</h1>
    <nav>
        <ul>
            <li><a href="options/admin_reviews.php">Admin Reviews</a></li>
            <li><a href="options/admin_content.php">Admin content</a></li>
            <li><a href="options/admin_prices.php">Admin Prices</a></li>
            <li><a href="options/admin_gallery.php">Admin Gallery</a></li>

        </ul>
    </nav>

</div>
</body>
</html>
