<?php
$servername = "";
$username = "";
$password = "";
$dbname = "";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$listName = $_POST['list_name'];
$itemName = $_POST['item_name'];
$description = $_POST['description'];
$image = $_POST['image'];
$location = $_POST['location'];
$barcode = $_POST['barcode'];

$sql = "INSERT INTO $listName (itemName, description, image, location, barcode) VALUES ('$itemName', '$description', '$image', '$location', '$barcode')";

if ($conn->query($sql) === TRUE) {
    echo "New entry added successfully.";
} else {
    echo "Error adding entry: " . $conn->error;
}

$conn->close();
?>
