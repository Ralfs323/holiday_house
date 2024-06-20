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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
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
                <li><a href="?page=admin_default.php"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="?page=admin_reviews.php"><i class="fas fa-comment"></i> Reviews</a></li>
                <li><a href="?page=content.php"><i class="fas fa-file-alt"></i> Content Management</a></li>
                <li><a href="?page=add_price_form.php"><i class="fas fa-money-bill-alt"></i> Prices</a></li>
                <li><a href="?page=add_image.php"><i class="fas fa-image"></i> Add Image</a></li>
                <li><a href="?page=delete_image.php"><i class="fas fa-trash-alt"></i> Delete Image</a></li>
                <li><a href="/index.php"><i class="fas fa-globe"></i> Main Page</a></li>
                <li><a href="/auth/logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
            </ul>
        </nav>
    </aside>
    <main class="content">
        <div class="content-header">
            <h2>Dashboard</h2>
        </div>
        <div class="content-body">
            <?php include $page; ?>
        </div>
    </main>
</div>
</body>
</html>