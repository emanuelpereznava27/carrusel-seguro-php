<?php
$host = "127.0.0.1";
$user = "carrusel_admin";
$pass = "kali123";
$db   = "carrusel_dark_db";

// 1. Conexión directa a PostgreSQL
$conexion = @pg_connect("host=$host dbname=$db user=$user password=$pass");

if (!$conexion) {
    die("<body style='background:#0d1117; color:#f85149; font-family:monospace;'><h2 style='text-align:center; margin-top:50px;'>[ ERROR CRÍTICO ]<br>No se pudo conectar a PostgreSQL. Revisa tu servicio.</h2></body>");
}

$db_status = "✔ Conexión a base de datos PostgreSQL 'carrusel_dark_db' exitosa.";

// 2. Crear las tablas (PostgreSQL usa SERIAL para autoincrementar)
$tabla_fotos = "CREATE TABLE IF NOT EXISTS imagenes (
    id SERIAL PRIMARY KEY, 
    nombre VARCHAR(100), 
    ruta VARCHAR(255)
)";

$tabla_user = "CREATE TABLE IF NOT EXISTS usuarios (
    id SERIAL PRIMARY KEY, 
    username VARCHAR(50), 
    password VARCHAR(255)
)";

pg_query($conexion, $tabla_fotos);
pg_query($conexion, $tabla_user);

// 3. Insertar usuario administrador
$insert_admin = "INSERT INTO usuarios (username, password) 
                 SELECT 'admin', '1234' 
                 WHERE NOT EXISTS (SELECT 1 FROM usuarios WHERE username = 'admin')";
pg_query($conexion, $insert_admin);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Instalador PGSQL</title>
    <style>
        body { background-color: #0d1117; color: #2ea043; font-family: 'Consolas', 'Courier New', monospace; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .terminal { border: 1px solid #30363d; padding: 30px; border-radius: 8px; background-color: #161b22; box-shadow: 0 0 20px rgba(46, 160, 67, 0.15); width: 450px; text-align: center; }
        .boton-proceder { color: #58a6ff; text-decoration: none; font-weight: bold; font-size: 1.1em; display: inline-block; margin-top: 20px; border: 1px solid #58a6ff; padding: 10px 20px; border-radius: 5px; transition: 0.3s; }
        .boton-proceder:hover { background-color: #58a6ff; color: #0d1117; }
    </style>
</head>
<body>
    <div class="terminal">
        <h2 style="color: #c9d1d9; letter-spacing: 1px;">[ SISTEMA PGSQL INICIALIZADO ]</h2>
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
