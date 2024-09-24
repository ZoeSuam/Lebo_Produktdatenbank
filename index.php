<?php
session_start();

// Prüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Benutzer ist nicht eingeloggt, leite zur Login-Seite weiter
    header('Location: login.php');
    exit(); // Wichtiger Schritt, um sicherzustellen, dass der Code danach nicht ausgeführt wird
}

// Wenn der Benutzer eingeloggt ist, kannst du die Inhalte der index.php anzeigen
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Produktdatenbank</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Hintergrund mit Farbverlauf */
        body {
            background: linear-gradient(to right, #f8f9fa, #e2f0ff);
        }

        /* Hero section background (Dark) */
        .hero {
            background-color: #333; /* Dark background */
            color: white;
            padding: 100px 0;
            text-align: center; /* Center the text */
        }

        /* Hero text styling */
        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
        }

        .hero p {
            font-size: 1.5rem;
            margin-bottom: 2rem;
        }

        /* Button styling */
        .btn-custom {
            background-color: #6c757d; /* Grau */
            color: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px 30px;
            font-size: 18px;
            border-radius: 8px; /* Abgerundete Ecken */
            transition: background-color 0.3s ease; /* Sanfte Transition beim Hover */
        }

        /* Hover-Effekt: blau */
        .btn-custom:hover {
            background-color: #52EAAF; /* CAG GREEN */
            color: white;
        }

        /* Abstand für Icons und Text */
        .btn-custom i {
            margin-right: 10px;
        }

        /* Placeholder Image Section */
        .placeholder-section {
            background: url('bilder/Frame 85 (3).png') center center no-repeat;
            background-size: cover;
            height: 800px; /* Adjust height as needed */
            position: relative;
        }

        /* Overlay text on image */
        .placeholder-section .overlay-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 2rem;
            font-weight: bold;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
        }

    </style>
</head>
<body>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Willkommen zur Produktdatenbank</h1>
            <p>Was möchten Sie einpflegen oder anzeigen?</p>
            <div class="d-grid gap-3 col-6 mx-auto">
                <!-- Zertifikat einpflegen Button with Icon -->
                <a href="zertifizierung.html" class="btn btn-custom">
                    <i class="bi bi-file-earmark-plus"></i> Zertifikat einpflegen
                </a>
                <!-- Produkt einpflegen Button with Icon -->
                <a href="produkt.html" class="btn btn-custom">
                    <i class="bi bi-box-seam"></i> Produkt einpflegen
                </a>
                <!-- Produkte anzeigen Button with Icon -->
                <a href="zeige_produkte.html" class="btn btn-custom">
                    <i class="bi bi-list-ul"></i> Zeige Produkte
                </a>
            </div>
        </div>
    </section>

    <!-- Placeholder Image Section -->
    <section class="placeholder-section">
        <div class="overlay-text"></div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
ob_end_flush();
?>
