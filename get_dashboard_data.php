<?php
include 'db_connection.php';

// Abfrage für die Anzahl der Produkte pro Gruppenfirma
$sql_products = "
    SELECT Gruppenfirma, COUNT(*) AS Anzahl_Produkte 
    FROM Produkt 
    GROUP BY Gruppenfirma";
$result_products = $conn->query($sql_products);

$productLabels = [];
$productCounts = [];

while ($row = $result_products->fetch_assoc()) {
    $productLabels[] = $row['Gruppenfirma'];
    $productCounts[] = $row['Anzahl_Produkte'];
}

// Abfrage für die Anzahl der Zertifikate pro Gruppenfirma
$sql_certificates = "
    SELECT Gruppenfirma, COUNT(*) AS Anzahl_Zertifikate 
    FROM AZAV_Zertifikat 
    GROUP BY Gruppenfirma";
$result_certificates = $conn->query($sql_certificates);

$certificateLabels = [];
$certificateCounts = [];

while ($row = $result_certificates->fetch_assoc()) {
    $certificateLabels[] = $row['Gruppenfirma'];
    $certificateCounts[] = $row['Anzahl_Zertifikate'];
}

// Rückgabe der Daten als JSON-Objekt
echo json_encode([
    'productLabels' => $productLabels,
    'productCounts' => $productCounts,
    'certificateLabels' => $certificateLabels,
    'certificateCounts' => $certificateCounts
]);

$conn->close();

?>
