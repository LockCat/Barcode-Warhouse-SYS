<?php
// Verbindung zur MySQL-Datenbank herstellen (ersetzen Sie die Platzhalter mit Ihren eigenen Daten)
$servername = "";
$username = "";
$password = "";
$dbname = "";

$conn = new mysqli($servername, $username, $password, $dbname);

// Überprüfen Sie die Verbindung
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// SQL-Abfrage zum Abrufen aller Items
$sql = "SELECT * FROM items";
$result = $conn->query($sql);

echo "<h2>Alle Items</h2>";

if ($result->num_rows > 0) {
    // Items gefunden, Liste anzeigen
    while ($row = $result->fetch_assoc()) {
        echo "<p>ID: " . $row['id'] . "</p>";
        echo "<p>Artikel Name: " . $row['itemName'] . "</p>";
        echo "<p>Beschreibung: " . $row['description'] . "</p>";
        echo "<p>Ortsbeschreibung: " . $row['location'] . "</p>";
        if ($row['image'] !== null) {
            echo '<img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" alt="Bild">';
        }
        echo "<hr>";
    }
} else {
    echo "Keine Items gefunden.";
}

// Verbindung schließen
$conn->close();
?>
