<?php
$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "form_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$especialidad = $_POST['especialidad'];
$tipo_tramite = $_POST['tipoTramite'];
$descripcion = $_POST['descripcion'];

$archivo_nombres = [];

if (isset($_FILES['fileUpload'])) {
    $total_files = count($_FILES['fileUpload']['name']);
    
    $upload_dir = "uploads/";

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    for ($i = 0; $i < $total_files; $i++) {
        $filename = basename($_FILES['fileUpload']['name'][$i]);
        $target_file = $upload_dir . $filename;

        if (move_uploaded_file($_FILES['fileUpload']['tmp_name'][$i], $target_file)) {
            $archivo_nombres[] = $filename; 
        } else {
            echo "Error al subir el archivo " . $filename;
        }
    }
}

$archivos = implode(",", $archivo_nombres);

$sql = "INSERT INTO solicitudes (especialidad, tipo_tramite, descripcion, archivos)
        VALUES ('$especialidad', '$tipo_tramite', '$descripcion', '$archivos')";

if ($conn->query($sql) === TRUE) {
    echo "Solicitud guardada exitosamente.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
