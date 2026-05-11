<?php
// Configuración para MariaDB en Kali Linux
$host = "127.0.0.1";
$user = "carrusel_admin";
$pass = "kali123";
$db   = "carrusel_dark_db"; // Nombre de BD personalizado para tu versión

$conexion = mysqli_connect($host, $user, $pass, $db);

if (!$conexion) {
    die("Error crítico de conexión a MariaDB: " . mysqli_connect_error());
}

// Codificación para aceptar caracteres especiales y eñes
mysqli_set_charset($conexion, "utf8");
?>

