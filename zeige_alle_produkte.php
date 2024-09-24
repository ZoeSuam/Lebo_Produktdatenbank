<?php
include 'db_connection.php';

// Definiere Variablen für die Filter
$filter_gruppenfirma = isset($_GET['gruppenfirma']) ? $_GET['gruppenfirma'] : '';
$filter_produktart = isset($_GET['produktart']) ? $_GET['produktart'] : '';

// SQL-Abfrage für die Produkte mit Filtern für Gruppenfirma und Produktart
$sql = "
    SELECT 
        p.ProduktID,
        p.Produkt_Titel,
        p.Gruppenfirma,
        p.Produktart,
        p.Gesamtpreis,
        p.Gesamtumfang_UE,
        p.OnDemand_Anteil_UE,
        IFNULL(p.Durchführungsform, z.Art_der_Maßnahme) AS Durchführungsform, 
        p.Start,
        p.Ende,
        p.Kostenstelle_CAG,
        z.ZertifizierungsNR
    FROM Produkt p
    LEFT JOIN AZAV_Zertifikat z
    ON p.ZertifizierungsNR = z.ZertifizierungsNR
    WHERE 1=1";

// Füge Bedingungen zur SQL-Abfrage basierend auf den ausgewählten Filtern hinzu
if (!empty($filter_gruppenfirma)) {
    $sql .= " AND p.Gruppenfirma = '$filter_gruppenfirma'";
}

if (!empty($filter_produktart)) {
    $sql .= " AND p.Produktart = '$filter_produktart'";
}

$result = $conn->query($sql);

// Dropdown-Optionen für die Filter abrufen
$gruppenfirmen_sql = "SELECT DISTINCT Gruppenfirma FROM Produkt WHERE Gruppenfirma IS NOT NULL";
$gruppenfirmen_result = $conn->query($gruppenfirmen_sql);

$produktart_sql = "SELECT DISTINCT Produktart FROM Produkt WHERE Produktart IS NOT NULL";
$produktart_result = $conn->query($produktart_sql);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alle Produkte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Hintergrund mit Farbverlauf */
        body {
            background: #ffffff;
        }

        /* Zentrierte Tabelle */
        .table-container {
            margin: 0 auto;
            max-width: 90%;
        }

        /* Abstand für Filterformular */
        .filter-container {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5 table-container">
        <h1 class="text-center mb-4">Alle Produkte</h1>

        <!-- Filterformular -->
        <div class="filter-container">
            <form method="GET" action="zeige_alle_produkte.php">
                <div class="row mb-3">
                    <!-- Dropdown für Gruppenfirma -->
                    <div class="col-md-6">
                        <label for="gruppenfirma" class="form-label">Gruppenfirma auswählen:</label>
                        <select class="form-select" id="gruppenfirma" name="gruppenfirma">
                            <option value="">Alle Gruppenfirmen</option>
                            <?php
                            if ($gruppenfirmen_result->num_rows > 0) {
                                while ($row = $gruppenfirmen_result->fetch_assoc()) {
                                    $selected = ($filter_gruppenfirma == $row['Gruppenfirma']) ? 'selected' : '';
                                    echo '<option value="' . $row['Gruppenfirma'] . '" ' . $selected . '>' . $row['Gruppenfirma'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Dropdown für Produktart -->
                    <div class="col-md-6">
                        <label for="produktart" class="form-label">Produktart auswählen:</label>
                        <select class="form-select" id="produktart" name="produktart">
                            <option value="">Alle Produktarten</option>
                            <?php
                            if ($produktart_result->num_rows > 0) {
                                while ($row = $produktart_result->fetch_assoc()) {
                                    $selected = ($filter_produktart == $row['Produktart']) ? 'selected' : '';
                                    echo '<option value="' . $row['Produktart'] . '" ' . $selected . '>' . $row['Produktart'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-center">
                        <button type="submit" class="btn btn-primary">Filtern</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tabelle für die Produkte -->
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Produkt ID</th>
                    <th>Produkt Titel</th>
                    <th>Gruppenfirma</th>
                    <th>Produktart</th>
                    <th>Gesamtpreis</th>
                    <th>Gesamtumfang (UE)</th>
                    <th>OnDemand Anteil (UE)</th>
                    <th>Durchführungsform / Art der Maßnahme</th>
                    <th>Start</th>
                    <th>Ende</th>
                    <th>Kostenstelle CAG</th>
                    <th>ZertifizierungsNR</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>" . $row['ProduktID'] . "</td>
                            <td>" . $row['Produkt_Titel'] . "</td>
                            <td>" . $row['Gruppenfirma'] . "</td>
                            <td>" . $row['Produktart'] . "</td>
                            <td>" . $row['Gesamtpreis'] . "</td>
                            <td>" . $row['Gesamtumfang_UE'] . "</td>
                            <td>" . $row['OnDemand_Anteil_UE'] . "</td>
                            <td>" . $row['Durchführungsform'] . "</td>
                            <td>" . $row['Start'] . "</td>
                            <td>" . $row['Ende'] . "</td>
                            <td>" . $row['Kostenstelle_CAG'] . "</td>
                            <td>" . $row['ZertifizierungsNR'] . "</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='12'>Keine Produkte gefunden</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close(); // Verbindung schließen
?>
