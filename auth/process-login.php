<?php
session_start();

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $mysqli = require __DIR . "/db/db.php";

    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
        $mysqli->real_escape_string($_POST["email"]));

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    if ($user) {

        if (password_verify($_POST["password"], $user["password_hash"])) {

            session_regenerate_id();

            $_SESSION["user_id"] = $user["id"];

            header("Location: index.php");
            exit;
        }
    }

    $is_invalid = true;
}

if ($is_invalid): ?>
    <em>Invalid login</em>
<?php endif; ?>

<!--<form method="post">-->
<!--    <label for="email">email</label>-->
<!--    <input type="email" name="email" id="email"-->
<!--           value="--><?php //= htmlspecialchars($_POST["email"] ?? "") ?><!--">-->
<!---->
<!--    <label for="password">Password</label>-->
<!--    <input type="password" name="password" id="password">-->
<!---->
<!--    --><?php
//    include "signup.html";
//    ?>
<!---->
<!--    <button>Log in</button>-->
<!--</form>-->