<?php
// Verbindung zur Datenbank herstellen
include 'db_connection.php';

// ZertifizierungsNR aus der GET-Anfrage abrufen
$zertifizierungsnr = $_GET['zertifizierungsnr'];

// SQL-Abfrage, um den Maßnahmetitel zu der ZertifizierungsNR abzurufen
$sql = "SELECT Maßnahmetitel FROM AZAV_Zertifikat WHERE ZertifizierungsNR = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $zertifizierungsnr);
$stmt->execute();
$result = $stmt->get_result();

// Überprüfen, ob ein Maßnahmetitel gefunden wurde
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(array("Maßnahmetitel" => $row['Maßnahmetitel']));
} else {
    echo json_encode(array("Maßnahmetitel" => ""));
}

// Verbindung schließen
$stmt->close();
$conn->close();
?>
