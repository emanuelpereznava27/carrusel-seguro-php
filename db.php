<?php
// Configuración para PostgreSQL en Kali Linux
$host = "127.0.0.1";
$user = "carrusel_admin";
$pass = "kali123";
$db   = "carrusel_dark_db";

// La cadena de conexión en PostgreSQL es distinta
$conexion = pg_connect("host=$host dbname=$db user=$user password=$pass");

if (!$conexion) {
    die("Error crítico de conexión a PostgreSQL.");
}
?>
