<?php
$host = "127.0.0.1";
$user = "carrusel_admin";
$pass = "kali123";

// 1. Conexión inicial SIN seleccionar base de datos
$conexion_inicial = @mysqli_connect($host, $user, $pass);

if (!$conexion_inicial) {
    die("<body style='background:#0d1117; color:#f85149; font-family:monospace;'><h2 style='text-align:center; margin-top:50px;'>[ ERROR CRÍTICO ]<br>No se pudo conectar a MariaDB. Revisa tu servicio.</h2></body>");
}

// 2. Crear la base de datos
$sql_db = "CREATE DATABASE IF NOT EXISTS carrusel_dark_db";
$db_status = mysqli_query($conexion_inicial, $sql_db) ? "✔ Base de datos 'carrusel_dark_db' verificada." : "✖ Error al crear la BD.";

// 3. Seleccionar la base de datos para trabajar en ella
mysqli_select_db($conexion_inicial, "carrusel_dark_db");

// 4. Crear las tablas
$tabla_fotos = "CREATE TABLE IF NOT EXISTS imagenes (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    nombre VARCHAR(100), 
    ruta VARCHAR(255)
)";

$tabla_user = "CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    username VARCHAR(50), 
    password VARCHAR(255)
)";

mysqli_query($conexion_inicial, $tabla_fotos);
mysqli_query($conexion_inicial, $tabla_user);

// 5. Insertar usuario administrador por defecto (Ignora si ya existe)
mysqli_query($conexion_inicial, "INSERT IGNORE INTO usuarios (id, username, password) VALUES (1, 'admin', '1234')");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Instalador del Sistema</title>
    <style>
        body { 
            background-color: #0d1117; 
            color: #2ea043; 
            font-family: 'Consolas', 'Courier New', monospace; 
            display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; 
        }
        .terminal { 
            border: 1px solid #30363d; 
            padding: 30px; 
            border-radius: 8px; 
            background-color: #161b22; 
            box-shadow: 0 0 20px rgba(46, 160, 67, 0.15); 
            width: 450px; text-align: center; 
        }
        .boton-proceder { 
            color: #58a6ff; 
            text-decoration: none; 
            font-weight: bold; 
            font-size: 1.1em; 
            display: inline-block; 
            margin-top: 20px; 
            border: 1px solid #58a6ff; 
            padding: 10px 20px; 
            border-radius: 5px; 
            transition: 0.3s;
        }
        .boton-proceder:hover { 
            background-color: #58a6ff; 
            color: #0d1117; 
        }
    </style>
</head>
<body>
    <div class="terminal">
        <h2 style="color: #c9d1d9; letter-spacing: 1px;">[ SISTEMA INICIALIZADO ]</h2>
        <p style="text-align: left; margin-left: 20px;"><?php echo $db_status; ?></p>
        <p style="text-align: left; margin-left: 20px;">✔ Tablas de datos construidas.</p>
        <p style="text-align: left; margin-left: 20px;">✔ Credenciales de acceso generadas.</p>
        <hr style="border-color: #30363d;">
        <p style="color: #8b949e; font-size: 0.9em;">
            Usuario ROOT: <b style="color: white;">admin</b><br>
            Password ROOT: <b style="color: white;">1234</b>
        </p>
        <a href='login.php' class="boton-proceder">> Proceder al Login _</a>
    </div>
</body>
</html>
