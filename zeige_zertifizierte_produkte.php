<?php
include 'db_connection.php'; // Verbindung zur Datenbank herstellen

// Dropdown für ZertifizierungsNR abrufen
$certSql = "SELECT DISTINCT ZertifizierungsNR FROM AZAV_Zertifikat";
$certResult = $conn->query($certSql);

// SQL-Abfrage für zertifizierte Produkte (JOIN von Produkt und AZAV_Zertifikat)
$sql = "SELECT 
            Produkt.ProduktID,
            Produkt.Maßnahmenummer,
            Produkt.ZertifizierungsNR,
            Produkt.Produkt_Titel,
            Produkt.Produktart,
            Produkt.Gesamtpreis AS Produkt_Gesamtpreis,
            Produkt.Gesamtumfang_UE,
            Produkt.OnDemand_Anteil_UE,
            Produkt.Start,
            Produkt.Ende,
            Produkt.Kostenstelle_CAG,
            Produkt.Gruppenfirma,
            AZAV_Zertifikat.Zertifizierer,
            AZAV_Zertifikat.Zulassung_von,
            AZAV_Zertifikat.Zulassung_bis,
            AZAV_Zertifikat.Art_der_Maßnahme,
            AZAV_Zertifikat.KLDB,
            AZAV_Zertifikat.UE_gesamt AS Zertifikat_UE_gesamt,
            AZAV_Zertifikat.UE_betriebliche_Lernphase,
            AZAV_Zertifikat.Gesamtkosten AS Zertifikat_Gesamtkosten,
            AZAV_Zertifikat.Anz_Teilnehmer,
            AZAV_Zertifikat.BDKS
        FROM Produkt
        INNER JOIN AZAV_Zertifikat 
        ON Produkt.ZertifizierungsNR = AZAV_Zertifikat.ZertifizierungsNR
        WHERE Produkt.ZertifizierungsNR IS NOT NULL";

// Wenn eine ZertifizierungsNR ausgewählt wurde, filtern wir die Ergebnisse
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!empty($_GET['dropdown_cert'])) {
        $zertifizierungsnr = $_GET['dropdown_cert'];
        $sql .= " AND Produkt.ZertifizierungsNR = '$zertifizierungsnr'";
    } elseif (!empty($_GET['search_cert'])) {
        $zertifizierungsnr = $_GET['search_cert'];
        $sql .= " AND Produkt.ZertifizierungsNR = '$zertifizierungsnr'";
    }
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zertifizierte Produkte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Zentriere den Tabellencontainer */
        .table-container {
            margin: 0 auto;
            max-width: 100%;
        }

        /* Ansprechendes Styling für die Tabelle */
        .table thead th {
            background-color: #778286;
            color: white;
            text-align: center;
        }

        .table td, .table th {
            text-align: center;
            padding: 10px;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }

        .table-hover tbody tr:hover {
            background-color: #d4f8f1;
        }

        .table-responsive {
            overflow-x: auto;
        }

        /* Abstand für Filterformular */
        .filter-container {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Zertifizierte Produkte</h1>

        <!-- Filterformular -->
        <div class="filter-container">
            <form method="GET" action="zeige_zertifizierte_produkte.php">
                <div class="row mb-3">
                    <!-- Dropdown für ZertifizierungsNR -->
                    <div class="col-md-6">
                        <label for="dropdown_cert" class="form-label">ZertifizierungsNR auswählen:</label>
                        <select class="form-select" id="dropdown_cert" name="dropdown_cert">
                            <option value="">Bitte wählen...</option>
                            <?php
                            if ($certResult->num_rows > 0) {
                                while ($row = $certResult->fetch_assoc()) {
                                    echo '<option value="' . $row['ZertifizierungsNR'] . '">' . $row['ZertifizierungsNR'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Eingabefeld für ZertifizierungsNR -->
                    <div class="col-md-6">
                        <label for="search_cert" class="form-label">Oder geben Sie eine ZertifizierungsNR ein:</label>
                        <input type="text" class="form-control" id="search_cert" name="search_cert" placeholder="ZertifizierungsNR eingeben">
                    </div>
                </div>
                <div class="row">
                    <div class="col text-center">
                        <button type="submit" class="btn btn-primary">Filtern</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Table container with scrollable area -->
        <div class="table-responsive table-container">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>ProduktID</th>
                        <th>Maßnahmenummer</th>
                        <th>ZertifizierungsNR</th>
                        <th>Produkt Titel</th>
                        <th>Produktart</th>
                        <th>Gesamtpreis (Produkt)</th>
                        <th>Gesamtumfang (UE)</th>
                        <th>OnDemand Anteil (UE)</th>
                        <th>Start</th>
                        <th>Ende</th>
                        <th>Kostenstelle CAG</th>
                        <th>Gruppenfirma</th>
                        <th>Zertifizierer</th>
                        <th>Zulassung von</th>
                        <th>Zulassung bis</th>
                        <th>Art der Maßnahme</th>
                        <th>KLDB</th>
                        <th>UE gesamt (Zertifikat)</th>
                        <th>UE betriebliche Lernphase</th>
                        <th>Gesamtkosten (Zertifikat)</th>
                        <th>Anzahl Teilnehmer</th>
                        <th>BDKS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>" . $row['ProduktID'] . "</td>
                                <td>" . $row['Maßnahmenummer'] . "</td>
                                <td>" . $row['ZertifizierungsNR'] . "</td>
                                <td>" . $row['Produkt_Titel'] . "</td>
                                <td>" . $row['Produktart'] . "</td>
                                <td>" . $row['Produkt_Gesamtpreis'] . "</td>
                                <td>" . $row['Gesamtumfang_UE'] . "</td>
                                <td>" . $row['OnDemand_Anteil_UE'] . "</td>
                                <td>" . $row['Start'] . "</td>
                                <td>" . $row['Ende'] . "</td>
                                <td>" . $row['Kostenstelle_CAG'] . "</td>
                                <td>" . $row['Gruppenfirma'] . "</td>
                                <td>" . $row['Zertifizierer'] . "</td>
                                <td>" . $row['Zulassung_von'] . "</td>
                                <td>" . $row['Zulassung_bis'] . "</td>
                                <td>" . $row['Art_der_Maßnahme'] . "</td>
                                <td>" . $row['KLDB'] . "</td>
                                <td>" . $row['Zertifikat_UE_gesamt'] . "</td>
                                <td>" . $row['UE_betriebliche_Lernphase'] . "</td>
                                <td>" . $row['Zertifikat_Gesamtkosten'] . "</td>
                                <td>" . $row['Anz_Teilnehmer'] . "</td>
                                <td>" . $row['BDKS'] . "</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='22'>Keine zertifizierten Produkte gefunden.</td></tr>";
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
