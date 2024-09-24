<?php
// Verbindung zur Datenbank herstellen
include 'db_connection.php';

// SQL-Abfrage, um alle Zertifizierungsnummern aus der AZAV_Zertifikat-Tabelle zu holen
$sql = "SELECT ZertifizierungsNR, Maßnahmetitel FROM AZAV_Zertifikat";
$result = $conn->query($sql);

// Prüfen, ob Ergebnisse vorhanden sind
if ($result->num_rows > 0) {
    // Daten in JSON-Format umwandeln
    $zertifizierungen = array();
    while ($row = $result->fetch_assoc()) {
        $zertifizierungen[] = array("ZertifizierungsNR" => $row["ZertifizierungsNR"], "Maßnahmetitel" => $row["Maßnahmetitel"]);
    }
    echo json_encode($zertifizierungen);
} else {
    // Falls keine Zertifizierungen gefunden wurden
    echo json_encode(array());
}

$conn->close();
?>
