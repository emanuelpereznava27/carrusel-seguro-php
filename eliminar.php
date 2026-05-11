<?php
session_start();
include 'db.php';

// Verificación de seguridad básica
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // 1. Buscar la ruta de la imagen para borrar el archivo físico
    $query = "SELECT ruta FROM imagenes WHERE id = $id";
    $res = mysqli_query($conexion, $query);
    $datos = mysqli_fetch_assoc($res);

    if ($datos) {
        if (file_exists($datos['ruta'])) {
            unlink($datos['ruta']); // Borra la foto de la carpeta img_carrusel
        }
    }

    // 2. Borrar el registro de la base de datos MariaDB
    mysqli_query($conexion, "DELETE FROM imagenes WHERE id = $id");
}

// Regresa al panel oscuro
header("Location: admin.php"); 
exit();
?>
