<?php
// Configuración para MariaDB
$host = "127.0.0.1";
$user = "carrusel_admin";
$pass = "kali123";
$db   = "carrusel_dark_db";

// Conexión para MariaDB/MySQL
$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Error crítico de conexión a MariaDB: " . mysqli_connect_error());
}
?>
