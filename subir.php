<?php
include 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['imagen'])) {
    $nombre_mostrar = mysqli_real_escape_string($conexion, $_POST['nombre_personalizado']);
    $nombre_archivo = $_FILES['imagen']['name'];
    $ruta_temporal = $_FILES['imagen']['tmp_name'];
    $carpeta_destino = "img_carrusel/";

    // Por seguridad, si la carpeta se llega a borrar, el script la vuelve a crear
    if (!file_exists($carpeta_destino)) {
        mkdir($carpeta_destino, 0777, true);
    }

    // Limpiamos espacios en el nombre del archivo para evitar errores en Linux
    $nombre_limpio = str_replace(" ", "_", $nombre_archivo);
    
    // Generamos la ruta final con un timestamp
    $ruta_final = $carpeta_destino . time() . "_" . $nombre_limpio;

    // Movemos el archivo temporal a nuestra carpeta definitiva
    if (move_uploaded_file($ruta_temporal, $ruta_final)) {
        // Si se movió bien, guardamos el registro en la base de datos
        $sql = "INSERT INTO imagenes (nombre, ruta) VALUES ('$nombre_mostrar', '$ruta_final')";
        mysqli_query($conexion, $sql);
    }
}

// Terminando el proceso, regresamos al panel de control inmediatamente
header("Location: admin.php");
exit();
?>
