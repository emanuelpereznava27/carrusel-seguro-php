<?php
session_start();
include 'db.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // 1. Buscamos la ruta usando pg_query
    $query = "SELECT ruta FROM imagenes WHERE id = $id";
    $res = pg_query($conexion, $query);
    $datos = pg_fetch_assoc($res);

    if ($datos) {
        if (file_exists($datos['ruta'])) {
            unlink($datos['ruta']); 
        }
    }

    // 2. Borramos el registro del nodo PostgreSQL
    pg_query($conexion, "DELETE FROM imagenes WHERE id = $id");
}

header("Location: admin.php"); 
exit();
?>
