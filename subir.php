k<?php
session_start();
include 'db.php';

if (!isset($_SESSION['usuario'])) {
    exit("Acceso denegado");
}

if (isset($_POST['subir'])) {
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $archivo = $_FILES['imagen'];
    
    // Definir carpeta de destino
    $target_dir = "img_carrusel/";
    
    // Crear la carpeta si no existe
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . time() . "_" . basename($archivo["name"]);

    // Mover el archivo de la carpeta temporal a la final
    if (move_uploaded_file($archivo["tmp_name"], $target_file)) {
        // Insertar en la Base de Datos (CARGAR)
        $sql = "INSERT INTO imagenes (nombre, ruta) VALUES ('$nombre', '$target_file')";
        if (mysqli_query($conn, $sql)) {
            header("Location: editar.php?msg=subido");
        } else {
            echo "Error en la BD: " . mysqli_error($conn);
        }
    } else {
        echo "Error: No se pudo subir el archivo físico. Revisa los permisos de la carpeta.";
    }
}
?>
