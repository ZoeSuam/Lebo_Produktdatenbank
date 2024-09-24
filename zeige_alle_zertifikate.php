<?php
include 'db_connection.php'; // Verbindung zur Datenbank herstellen

// SQL-Abfrage, um alle Zertifikate zu holen
$sql = "SELECT * FROM AZAV_Zertifikat";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alle Zertifikate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Zentriere den Tabellencontainer */
        .table-container {
            margin: 0 auto; /* Horizontale Zentrierung */
            max-width: 100%;
        }

        /* Ansprechendes Styling für die Tabelle */
        .table thead th {
            background-color: #778286; /* Dunkler Hintergrund für Kopf */
            color: white;
            text-align: center;
        }

        .table td, .table th {
            text-align: center; /* Inhalt der Tabelle zentrieren */
            padding: 10px; /* Polsterung */
        }

        /* Tabellenzeilen optisch hervorheben */
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }

        /* Hover-Effekt */
        .table-hover tbody tr:hover {
            background-color: #d4f8f1;
        }

        /* Scrollbarer Container für die Tabelle */
        .table-responsive {
            overflow-x: auto; /* Ermöglicht horizontales Scrollen */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Alle Zertifikate</h1>

        <!-- Table container with scrollable area -->
        <div class="table-responsive table-container">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>ZertifizierungsNR</th>
                        <th>Maßnahmetitel</th>
                        <th>Zertifizierer</th>
                        <th>Zulassung von</th>
                        <th>Zulassung bis</th>
                        <th>Art der Maßnahme</th>
                        <th>KLDB</th>
                        <th>UE gesamt</th>
                        <th>UE betriebliche Lernphase</th>
                        <th>Gesamtkosten</th>
                        <th>Unterrichtskostensatz</th>
                        <th>Anzahl TN</th>
                        <th>Aktueller BDKS</th>
                        <th>Maßnahmeziel</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>" . $row['ZertifizierungsNR'] . "</td>
                                <td>" . $row['Maßnahmetitel'] . "</td>
                                <td>" . $row['Zertifizierer'] . "</td>
                                <td>" . $row['Zulassung_von'] . "</td>
                                <td>" . $row['Zulassung_bis'] . "</td>
                                <td>" . $row['Art_der_Maßnahme'] . "</td>
                                <td>" . $row['KLDB'] . "</td>
                                <td>" . $row['UE_gesamt'] . "</td>
                                <td>" . $row['UE_betriebliche_Lernphase'] . "</td>
                                <td>" . $row['Gesamtkosten'] . "</td>
                                <td>" . $row['Unterrichtskostensatz'] . "</td>
                                <td>" . $row['Anz_Teilnehmer'] . "</td>
                                <td>" . $row['BDKS'] . "</td>
                                <td>" . $row['Maßnahmeziel'] . "</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='14'>Keine Zertifikate gefunden</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close(); // Verbindung zur Datenbank schließen
?>
