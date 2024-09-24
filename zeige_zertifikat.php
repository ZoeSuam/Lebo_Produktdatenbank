<?php
include 'db_connection.php';

// ZertifizierungsNR aus der URL abrufen
$zertifizierungsnr = $_GET['zertifizierungsnr'];

// SQL-Abfrage, um das entsprechende Zertifikat abzurufen
$sql = "SELECT * FROM AZAV_Zertifikat WHERE ZertifizierungsNR = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $zertifizierungsnr);
$stmt->execute();
$result = $stmt->get_result();
$zertifikat = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zertifikat Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Zertifikat: <?php echo $zertifikat['ZertifizierungsNR']; ?></h1>
        <table class="table table-bordered">
            <tr><th>ZertifizierungsNR</th><td><?php echo $zertifikat['ZertifizierungsNR']; ?></td></tr>
            <tr><th>Maßnahmetitel</th><td><?php echo $zertifikat['Maßnahmetitel']; ?></td></tr>
            <tr><th>Zertifizierer</th><td><?php echo $zertifikat['Zertifizierer']; ?></td></tr>
            <tr><th>Zulassung_von</th><td><?php echo $zertifikat['Zulassung_von']; ?></td></tr>
            <tr><th>Zulassung_bis</th><td><?php echo $zertifikat['Zulassung_bis']; ?></td></tr>
            <!-- Weitere Details -->
        </table>
        <a href="zeige_alle_produkte.php" class="btn btn-secondary mt-3">Zurück zur Produktübersicht</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
 