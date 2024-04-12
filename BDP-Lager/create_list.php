<?php
$servername = "";
$username = "";
$password = "";
$dbname = "";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$newListName = $_POST['new_list_name'];

// Überprüfen, ob die Tabelle bereits existiert
$tableExistsQuery = "SHOW TABLES LIKE '$newListName'";
$tableExistsResult = $conn->query($tableExistsQuery);

if ($tableExistsResult->num_rows == 0) {
    // Tabelle erstellen, wenn sie nicht existiert
    $sql = "CREATE TABLE $newListName (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        itemName VARCHAR(255) NOT NULL,
        description TEXT,
        image VARCHAR(255),
        location VARCHAR(255),
        barcode VARCHAR(255)
    )";

    if ($conn->query($sql) === TRUE) {
        echo "List $newListName created successfully";
    } else {
        echo "Error creating list: " . $conn->error;
    }
} else {
    echo "List $newListName already exists.";
}

$conn->close();
?>
