<?php
session_start();

$is_invalid = false;

// Check if the "lohs" session variable is set
$lohs = isset($_SESSION['lohs']) ? $_SESSION['lohs'] : 1;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $mysqli = require __DIR__ . "/db/db.php";

    // ... (rest of your existing code for login)

    if($lohs == 1) {
        // Login form
        ?>
        <form method="post">
            <label for="email">Email</label>
            <input type="email" name="email" id="email"
                   value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">

            <label for="password">Password</label>
            <input type="password" name="password" id="password">

            <button>Log in</button>
        </form>
        <?php
    } else {
        // Signup form
        include "signup.html";
    }
}

if ($is_invalid): ?>
    <em>Invalid login</em>
<?php endif; ?>

<!-- Toggle between login and signup forms -->
<a href="?toggle_lohs=1">Switch to <?= ($lohs == 1) ? 'Signup' : 'Login' ?></a>

<?php
// Toggle the "lohs" session variable when the link is clicked
if (isset($_GET['toggle_lohs'])) {
    $_SESSION['lohs'] = ($_SESSION['lohs'] == 1) ? 2 : 1;
}
?>

</body>
sfdfdfdfdf
</html>
