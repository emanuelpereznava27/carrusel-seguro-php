<?php
include 'db.php'; 

if (ob_get_length()) ob_clean(); 

// Consulta adaptada a PostgreSQL
$query = "SELECT nombre, ruta FROM imagenes ORDER BY id DESC";
$resultado = pg_query($conexion, $query);

$imagenes = [];
while ($row = pg_fetch_assoc($resultado)) {
    $imagenes[] = $row;
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($imagenes);
exit();
?>
