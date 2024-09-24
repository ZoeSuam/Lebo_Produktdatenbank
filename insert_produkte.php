<?php
// Verbindung zur Datenbank herstellen
include 'db_connection.php';

// Überprüfen, ob das Formular abgeschickt wurde
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Debugging-Ausgabe für die empfangenen Werte
    echo "Produktart: " . $_POST['produktart'] . "<br>";
    echo "Produkt Titel: " . $_POST['produkt_titel'] . "<br>";
    echo "Gesamtpreis: " . $_POST['gesamtpreis'] . "<br>";
    echo "Gesamtumfang (UE): " . $_POST['gesamtumfang_ue'] . "<br>";
    echo "OnDemand Anteil: " . $_POST['ondemand_anteil'] . "<br>";
    echo "Kostenstelle CAG: " . $_POST['kostenstelle_cag'] . "<br>";
    echo "Gruppenfirma: " . $_POST['gruppenfirma'] . "<br>";

    $produktart = $_POST['produktart'];
    $produkt_titel = $_POST['produkt_titel'];
    $gesamtpreis = $_POST['gesamtpreis'];
    $gesamtumfang_ue = $_POST['gesamtumfang_ue'];
    $ondemand_anteil = $_POST['ondemand_anteil'];
    $kostenstelle_cag = $_POST['kostenstelle_cag'];
    $gruppenfirma = $_POST['gruppenfirma'];

    $zertifiziert = $_POST['zertifiziert'];

    if ($zertifiziert === "ja") {
        $zertifizierungsid = $_POST['zertifizierungsid'];
        $maßnahmenummer = $_POST['maßnahmenummer'];
        $start = $_POST['start'];
        $ende = $_POST['ende'];

        // Setze die Felder für unzertifizierte Produkte auf NULL
        $produktnr = NULL;
        $durchführungsform = NULL;

        echo "Produkt ist zertifiziert.<br>";
    } else {
        $produktnr = $_POST['produktnr'];
        $durchführungsform = $_POST['durchführungsform'];

        // Setze die Felder für zertifizierte Produkte auf NULL
        $zertifizierungsid = NULL;
        $maßnahmenummer = NULL;
        $start = NULL;
        $ende = NULL;

        echo "Produkt ist nicht zertifiziert.<br>";
    }



// SQL-Statement für beide Produkttypen
$sql = "INSERT INTO Produkt (ProduktNR, Maßnahmenummer, ZertifizierungsNR, Produkt_Titel, Produktart, Gesamtpreis, Gesamtumfang_UE, OnDemand_Anteil_UE, Durchführungsform, Start, Ende, Kostenstelle_CAG, Gruppenfirma)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Prepared Statement erstellen
$stmt = $conn->prepare($sql);

// Debug-Ausgabe der SQL-Abfrage und der Parameterwerte
echo "SQL Query: " . $sql . "<br>";
echo "Produktart: " . $produktart . "<br>";
echo "Produkt Titel: " . $produkt_titel . "<br>";

// Parameter binden (s für String, d für Double, i für Integer)
$stmt->bind_param(
    "sssssdddsssss",  // "s" für Strings und "d" für Double
    $produktnr,          // String (s)
    $maßnahmenummer,     // String (s)
    $zertifizierungsid,  // String (s)
    $produkt_titel,      // String (s)
    $produktart,         // String (s)
    $gesamtpreis,        // Double (d)
    $gesamtumfang_ue,    // Double (d)
    $ondemand_anteil,    // Double (d)
    $durchführungsform,  // String (s)
    $start,              // String (s) (für Date-Werte kannst du auch "s" nutzen)
    $ende,               // String (s)
    $kostenstelle_cag,   // String (s)
    $gruppenfirma        // String (s)
);

// Statement ausführen und Debug-Ausgabe bei Fehlern
if ($stmt->execute()) {
    echo "Produkt erfolgreich eingefügt!";
} else {
    echo "Fehler beim Einfügen des Produkts: " . $stmt->error;
}


    // Statement und Verbindung schließen
    $stmt->close();
    $conn->close();
}
?>
