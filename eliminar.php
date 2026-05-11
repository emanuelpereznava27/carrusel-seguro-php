<?php
session_start();
include 'db.php';
if (!isset($_SESSION['usuario'])) { exit(); }

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    mysqli_query($conn, "DELETE FROM imagenes WHERE id=$id");
}
header("Location: editar.php");
?>
