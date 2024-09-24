<?php
// Verbindung zur Datenbank herstellen
include 'db_connection.php';

// Überprüfen, ob das Formular abgeschickt wurde
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Daten aus dem Formular empfangen
    $zertifizierungsnr = $_POST['zertifizierungsnr'];
    $massnahmetitel = $_POST['massnahmetitel'];
    $gruppenfirma = $_POST['gruppenfirma'];
    $zertifizierer = $_POST['zertifizierer'];
    $zulassung_von = $_POST['zulassung_von'];
    $zulassung_bis = $_POST['zulassung_bis'];
    $massnahmeart = $_POST['massnahmeart'];
    $kldb = $_POST['kldb'];
    $ue_gesamt = $_POST['ue_gesamt'];
    $ue_betrieblicheLernphase = $_POST['ue_betrieblicheLernphase'];
    $zeitform = $_POST['zeitform'];
    $gesamtkosten = $_POST['gesamtkosten'];
    $unterrichtskostensatz = $_POST['unterrichtskostensatz'];
    $anz_tn = $_POST['anz_tn']; // INT Datentyp
    $bdks = $_POST['bdks'];
    $massnahmeziel = $_POST['massnahmeziel'];


    // SQL-Statement vorbereiten
    $sql = "INSERT INTO AZAV_Zertifikat (ZertifizierungsNR, Maßnahmetitel, Gruppenfirma, Zertifizierer, Zulassung_von, Zulassung_bis, Art_der_Maßnahme, KLDB, UE_gesamt, UE_betriebliche_Lernphase, Zeitform, Gesamtkosten, Unterrichtskostensatz, Anz_Teilnehmer, BDKS, Maßnahmeziel)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepared Statement erstellen
    $stmt = $conn->prepare($sql);

    // Parameter binden (s steht für string, i für integer, d für double/float)
    $stmt->bind_param(
        "ssssssssdddsdiss", 
        $zertifizierungsnr,            // VARCHAR
        $massnahmetitel,               // VARCHAR
        $gruppenfirma,                 // VARCHAR (Gruppenfirma hinzugefügt)
        $zertifizierer,                // VARCHAR
        $zulassung_von,                // DATE
        $zulassung_bis,                // DATE
        $massnahmeart,                 // VARCHAR
        $kldb,                         // INT
        $ue_gesamt,                    // FLOAT
        $ue_betrieblicheLernphase,     // FLOAT
        $zeitform,                     // VARCHAR
        $gesamtkosten,                 // FLOAT
        $unterrichtskostensatz,        // FLOAT
        $anz_tn,                       // INT (Anzahl der Teilnehmer)
        $bdks,                         // VARCHAR
        $massnahmeziel                 // VARCHAR
    );

    // Ausführen des Statements
    if ($stmt->execute()) {
        echo "Zertifikat erfolgreich hinzugefügt!";
    } else {
        echo "Fehler: " . $stmt->error;
    }

    // Statement und Verbindung schließen
    $stmt->close();
    $conn->close();
}
?>
