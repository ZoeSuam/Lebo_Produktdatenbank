<?php
// Datenbankverbindung herstellen
$host = 'localhost';   // Servername
$dbname = 'produktdatenbank';  // Datenbankname
$username = 'root';     // Standard-Benutzername für XAMPP
$password = 'sheepW0rld';         // Passwort, Standard bei XAMPP ist leer

// Verbindungsaufbau
$conn = new mysqli($host, $username, $password, $dbname);

// Fehlerbehandlung
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}
?>
