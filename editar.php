<?php
session_start();
include 'db.php';

// Protección: Si no hay sesión, al login
if (!isset($_SESSION['usuario'])) {
    header("Location: auth.php");
    exit();
}

// Lógica para ACTUALIZAR datos (Editar)
if (isset($_POST['actualizar'])) {
    $id = (int)$_POST['id'];
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $ruta = mysqli_real_escape_string($conn, $_POST['ruta']);
    mysqli_query($conn, "UPDATE imagenes SET nombre='$nombre', ruta='$ruta' WHERE id=$id");
}

// Consultar todas las imágenes para la tabla
$res = mysqli_query($conn, "SELECT * FROM imagenes ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Edición - Administrador</title>
    <style>
        body { background: #0b0e14; color: #e0e0e0; font-family: sans-serif; padding: 40px; }
        h2, h3 { color: #00ff41; font-family: 'Courier New', monospace; }
        .upload-section { background: #1c222d; padding: 20px; border-radius: 10px; margin-bottom: 30px; border: 1px dashed #007bff; }
        table { width: 100%; border-collapse: collapse; background: #151921; border-radius: 10px; overflow: hidden; }
        th, td { padding: 15px; border: 1px solid #252a33; text-align: left; }
        th { background: #1c222d; color: #007bff; }
        input[type="text"] { background: #0b0e14; color: white; border: 1px solid #333; padding: 8px; border-radius: 4px; width: 85%; }
        .btn-save { background: #007bff; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; font-weight: bold; }
        .btn-upload { background: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold; }
        .btn-del { background: #dc3545; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-size: 14px; font-weight: bold; }
        .nav-link { margin-top: 20px; display: inline-block; color: #00ff41; text-decoration: none; font-family: monospace; }
    </style>
</head>
<body>
    <h2>⚙️ PANEL DE ADMINISTRACIÓN</h2>

    <div class="upload-section">
        <h3>📤 Cargar Nueva Imagen al Slider</h3>
        <form action="subir.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="nombre" placeholder="Nombre del recurso..." required style="width: 30%; margin-bottom: 10px;">
            <input type="file" name="imagen" accept="image/*" required style="color: white; margin: 10px 0;">
            <br>
            <button type="submit" name="subir" class="btn-upload">SUBIR AL SERVIDOR</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Ruta en Servidor</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($res)): ?>
            <tr>
                <form method="POST">
                    <td><?php echo $row['id']; ?><input type="hidden" name="id" value="<?php echo $row['id']; ?>"></td>
                    <td><input type="text" name="nombre" value="<?php echo $row['nombre']; ?>"></td>
                    <td><input type="text" name="ruta" value="<?php echo $row['ruta']; ?>"></td>
                    <td>
                        <button type="submit" name="actualizar" class="btn-save">Guardar</button>
                        <a href="eliminar.php?id=<?php echo $row['id']; ?>" class="btn-del" onclick="return confirm('¿Eliminar permanentemente?')">Borrar</a>
                    </td>
                </form>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="index.php" class="nav-link">< VOLVER AL CARRUSEL</a>
</body>
</html>
