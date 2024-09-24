<?php
session_start();

// Falls das Formular gesendet wurde (z.B. durch POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];

    // Dein gewünschtes Passwort
    $correct_password = 'dein_sicheres_passwort';

    if ($password === $correct_password) {
        // Wenn das Passwort korrekt ist, setzen wir die Session
        $_SESSION['logged_in'] = true;

        // Weiterleitung zur Startseite (index.php)
        header('Location: index.php');
        exit();
    } else {
        // Falls das Passwort falsch ist, wird eine Fehlermeldung ausgegeben
        $error_message = 'Falsches Passwort, bitte erneut versuchen!';
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>

    <?php
    // Zeige eine Fehlermeldung an, falls das Passwort falsch war
    if (isset($error_message)) {
        echo "<p style='color:red;'>$error_message</p>";
    }
    ?>

    <form action="login.php" method="post">
        <label for="password">Passwort:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Einloggen</button>
    </form>
</body>
</html>
