<?php
$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "form_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT * FROM solicitudes";
$result = $conn->query($sql);

$requests = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $requests[] = $row; 
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($requests); 
?>
