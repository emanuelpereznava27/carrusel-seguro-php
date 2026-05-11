<?php
session_start();
include 'db.php';

// Si no hay sesión, lo pateamos de vuelta al login
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Consultamos las imágenes de la BD
$query = "SELECT * FROM imagenes ORDER BY id DESC";
$resultado = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control - Administrador</title>
    <style>
        body { 
            background: #0d1117; 
            color: #c9d1d9; 
            font-family: 'Consolas', 'Courier New', monospace; 
            margin: 0; 
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #30363d;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        h1, h3 { color: #2ea043; margin: 0; }
        
        /* Botones estilo terminal */
        .btn {
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            border: 1px solid;
            display: inline-block;
            font-size: 0.9em;
            cursor: pointer;
            background: transparent;
        }
        .btn-primary { color: #58a6ff; border-color: #58a6ff; }
        .btn-primary:hover { background: #58a6ff; color: #0d1117; }
        
        .btn-success { color: #2ea043; border-color: #2ea043; }
        .btn-success:hover { background: #2ea043; color: #0d1117; }
        
        .btn-danger { color: #f85149; border-color: #f85149; }
        .btn-danger:hover { background: #f85149; color: #0d1117; }

        /* Panel de subida */
        .upload-card {
            background: #161b22;
            border: 1px solid #30363d;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .form-label { display: block; margin-bottom: 5px; color: #8b949e; }
        .form-control {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            background: #0d1117;
            border: 1px solid #30363d;
            color: #58a6ff;
            box-sizing: border-box;
            font-family: inherit;
        }
        .form-control:focus { outline: none; border-color: #2ea043; }

        /* Tabla de registros */
        table {
            width: 100%;
            border-collapse: collapse;
            background: #161b22;
            border: 1px solid #30363d;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #30363d;
        }
        th { background: #21262d; color: #8b949e; }
        tr:hover { background: #0d1117; }
        .img-preview { border: 1px solid #30363d; border-radius: 4px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>[ ROOT PANEL ]</h1>
        <div>
            <a href="index.php" class="btn btn-primary" target="_blank">Ver Carrusel</a>
            <a href="registro_user.php" class="btn btn-success">Nuevo Admin</a>
            <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
        </div>
    </div>

    <div class="upload-card">
        <h3 style="margin-bottom: 15px;">> Cargar_Nuevo_Archivo</h3>
        <form action="subir.php" method="POST" enctype="multipart/form-data">
            <label class="form-label">Etiqueta de la imagen:</label>
            <input type="text" name="nombre_personalizado" class="form-control" placeholder="Ej: kali_linux_bg" required autocomplete="off">
            
            <label class="form-label">Seleccionar medio:</label>
            <input type="file" name="imagen" class="form-control" required>
            
            <button type="submit" class="btn btn-success" style="width: 100%;">EJECUTAR SUBIDA</button>
        </form>
    </div>

    <h3 style="margin-bottom: 10px;">> Registros_Activos</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Etiqueta</th>
                <th>Vista Previa</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($resultado)): ?>
            <tr>
                <td>#<?php echo $row['id']; ?></td>
                <td><?php echo $row['nombre']; ?></td>
                <td><img src="<?php echo $row['ruta']; ?>" width="100" class="img-preview"></td>
                <td>
                    <a href="eliminar.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('¿Confirmar eliminación del registro #<?php echo $row['id']; ?>?')">X Eliminar</a>
                </td>
            </tr>
            <?php endwhile; ?>
            <?php if(mysqli_num_rows($resultado) == 0): ?>
            <tr>
                <td colspan="4" style="text-align:center; color:#8b949e;">No hay registros en la base de datos.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>
