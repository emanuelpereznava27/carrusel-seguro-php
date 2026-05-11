k<?php
$host = "127.0.0.1";
$user = "carrusel_admin";
$pass = "kali123";
$db   = "carrusel_dark_db";

$conn = pg_connect("host=$host dbname=$db user=$user password=$pass");

if (!$conn) {
    die("Error crítico de conexión a PostgreSQL.");
}
?>
