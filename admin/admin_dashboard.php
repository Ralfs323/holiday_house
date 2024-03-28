<?php
session_start();

include_once "../db/db.php";

// Pārbaudām, vai lietotājs ir autentificējies un vai ir administrators
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: /auth/login.php"); // Ja lietotājs nav autentificējies vai nav administrators, novirzīt uz autentifikācijas lapu
    exit;
}

// Iekļaujam atbilstošu lapu, kuru izvēlēsies administrators
if(isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 'admin_default.php'; // Norādiet noklusēto lapu, ja nav norādīta cita
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

    <aside class="sidebar">
        <div class="sidebar-header">
            <h1>Admin Panel</h1>
        </div>
        <nav class="menu">
            <ul>
                <li><a href="?page=admin_default.php">Main Dashboard</a></li>
                <li><a href="?page=admin_reviews.php">Admin Reviews</a></li>
                <li><a href="?page=content.php">Content</a></li>
                <li><a href="?page=add_price_form.php">Prices</a></li>
                <li><a href="?page=add_image.php">Add image</a></li>
                <li><a href="?page=delete_image.php">Delete image</a></li>
                <li><a href="/index.php">Main page</a></li>
                <li><a href="/auth/logout.php">Log out</a></li>
            </ul>
        </nav>
    </aside>
    <main class="content">
        <div id="dynamic-content">
            <?php include $page; ?>
        </div>
    </main>

</div>
</body>
</html>
