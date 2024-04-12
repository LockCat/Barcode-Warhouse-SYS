
<?php

// Verbindung zur ersten Datenbank herstellen
$servername1 = "";
$username1 = "";
$password1 = "";
$dbname1 = "";

$conn1 = new mysqli($servername1, $username1, $password1, $dbname1);

// Verbindung zur zweiten Datenbank herstellen
$servername2 = "";
$username2 = "";
$password2 = "";
$dbname2 = "";

$conn2 = new mysqli($servername2, $username2, $password2, $dbname2);

// Überprüfen, ob die Verbindungen erfolgreich waren
if ($conn1->connect_error || $conn2->connect_error) {
    die("Connection failed: " . $conn1->connect_error . " / " . $conn2->connect_error);
}

// ID aus dem Formular erhalten
$id = $_POST['entry_id'];

// Ziel-Tabelle aus dem Formular erhalten
$targetTable = $_POST['target_table'];

// SQL-Abfrage, um den Eintrag mit der angegebenen ID aus der ersten Datenbank zu erhalten
$sql1 = "SELECT * FROM items WHERE id = $id";
$result1 = $conn1->query($sql1);

if ($result1->num_rows > 0) {
    // Eintrag gefunden, Daten abrufen
    $row = $result1->fetch_assoc();

    // Daten in die zweite Datenbank einfügen
    $itemName = $row['itemName'];
    $description = $row['description'];
    $image = $row['image'];
    $location = $row['location'];
    $barcode = $row['barcode'];

    // SQL-Abfrage, um den Eintrag in die zweite Datenbank einzufügen
    $sql2 = "INSERT INTO $targetTable (itemName, description, image, location, barcode) VALUES ('$itemName', '$description', '$image', '$location', '$barcode')";

    if ($conn2->query($sql2) === TRUE) {
        echo "Eintrag erfolgreich kopiert!";
    } else {
        echo "Fehler beim Kopieren des Eintrags: " . $conn2->error;
    }
} else {
    echo "Eintrag mit ID $id nicht gefunden in der ersten Datenbank.";
}

// Verbindungen schließen
$conn1->close();
$conn2->close();

?>
