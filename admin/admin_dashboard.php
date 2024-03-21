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
<<<<<<< Updated upstream
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

=======
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
>>>>>>> Stashed changes
</div>
</body>
</html>
