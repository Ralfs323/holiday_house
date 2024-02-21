<?php
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