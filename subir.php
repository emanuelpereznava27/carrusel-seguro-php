<?php
include 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['imagen'])) {
    // Escapamos strings para PostgreSQL
    $nombre_mostrar = pg_escape_string($conexion, $_POST['nombre_personalizado']);
    $nombre_archivo = $_FILES['imagen']['name'];
    $ruta_temporal = $_FILES['imagen']['tmp_name'];
    $carpeta_destino = "img_carrusel/";

    if (!file_exists($carpeta_destino)) {
        mkdir($carpeta_destino, 0777, true);
    }

    $nombre_limpio = str_replace(" ", "_", $nombre_archivo);
    $ruta_final = $carpeta_destino . time() . "_" . $nombre_limpio;

    if (move_uploaded_file($ruta_temporal, $ruta_final)) {
        // Query adaptada a PostgreSQL
        $sql = "INSERT INTO imagenes (nombre, ruta) VALUES ('$nombre_mostrar', '$ruta_final')";
        $resultado = pg_query($conexion, $sql);
        
        if (!$resultado) {
            echo "Error al insertar en PostgreSQL: " . pg_last_error($conexion);
            exit();
        }
    }
}
header("Location: admin.php");
exit();
?>
