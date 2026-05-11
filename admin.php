<?php
session_start();
include 'db.php';

// Verificamos sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// En PostgreSQL usamos pg_query
$query = "SELECT * FROM imagenes ORDER BY id DESC";
$resultado = pg_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control - Administrador PG</title>
    <style>
        body { background: #0d1117; color: #c9d1d9; font-family: 'Consolas', 'Courier New', monospace; margin: 0; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #30363d; padding-bottom: 15px; margin-bottom: 30px; }
        h1, h3 { color: #58a6ff; margin: 0; }
        .btn { padding: 8px 15px; text-decoration: none; border-radius: 4px; font-weight: bold; border: 1px solid; display: inline-block; font-size: 0.9em; cursor: pointer; background: transparent; }
        .btn-primary { color: #58a6ff; border-color: #58a6ff; }
        .btn-success { color: #2ea043; border-color: #2ea043; }
        .btn-danger { color: #f85149; border-color: #f85149; }
        .upload-card { background: #161b22; border: 1px solid #30363d; padding: 20px; border-radius: 8px; margin-bottom: 30px; }
        .form-control { width: 100%; padding: 8px; margin-bottom: 15px; background: #0d1117; border: 1px solid #30363d; color: #58a6ff; box-sizing: border-box; font-family: inherit; }
        table { width: 100%; border-collapse: collapse; background: #161b22; border: 1px solid #30363d; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #30363d; }
        th { background: #21262d; color: #8b949e; }
        .img-preview { border: 1px solid #30363d; border-radius: 4px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>[ PGSQL_ROOT_PANEL ]</h1>
        <div>
            <a href="index.php" class="btn btn-primary" target="_blank">Ver Carrusel</a>
            <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
        </div>
    </div>

    <div class="upload-card">
        <h3>> Cargar_a_PostgreSQL</h3>
        <form action="subir.php" method="POST" enctype="multipart/form-data">
            <label style="color: #8b949e;">Etiqueta:</label>
            <input type="text" name="nombre_personalizado" class="form-control" placeholder="nombre_archivo" required>
            <label style="color: #8b949e;">Archivo:</label>
            <input type="file" name="imagen" class="form-control" required>
            <button type="submit" class="btn btn-success" style="width: 100%;">INSERTAR EN CLÚSTER</button>
        </form>
    </div>

    <h3>> Registros_en_PostgreSQL</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Etiqueta</th>
                <th>Preview</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = pg_fetch_assoc($resultado)): ?>
            <tr>
                <td>#<?php echo $row['id']; ?></td>
                <td><?php echo $row['nombre']; ?></td>
                <td><img src="<?php echo $row['ruta']; ?>" width="100" class="img-preview"></td>
                <td>
                    <a href="eliminar.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">X Eliminar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>
