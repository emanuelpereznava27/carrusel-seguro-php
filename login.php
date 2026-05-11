<?php
session_start();
include 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // En PostgreSQL usamos pg_escape_string
    $user = pg_escape_string($conexion, $_POST['username']);
    $pass = $_POST['password'];

    // Consulta adaptada
    $query = "SELECT * FROM usuarios WHERE username = '$user' AND password = '$pass'";
    $resultado = pg_query($conexion, $query);

    if (pg_num_rows($resultado) > 0) {
        $datos = pg_fetch_assoc($resultado);
        $_SESSION['usuario'] = $datos['username']; 
        header("Location: admin.php"); 
        exit();
    } else {
        $error = "[ ACCESO DENEGADO ] Credenciales inválidas en el clúster.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Acceso Seguro PG</title>
    <style>
        body { background: #0d1117; display: flex; align-items: center; justify-content: center; height: 100vh; font-family: 'Consolas', 'Courier New', monospace; color: #c9d1d9; margin: 0; }
        .login-box { width: 350px; padding: 30px; background: #161b22; border: 1px solid #30363d; border-radius: 8px; box-shadow: 0 0 15px rgba(88, 166, 255, 0.1); }
        .login-box h3 { text-align: center; color: #58a6ff; letter-spacing: 1px; margin-bottom: 20px; }
        .form-control { width: 100%; padding: 10px; margin-bottom: 15px; background: #0d1117; border: 1px solid #30363d; color: #58a6ff; border-radius: 4px; box-sizing: border-box; font-family: inherit; }
        .btn-submit { width: 100%; padding: 10px; background: #58a6ff; color: #0d1117; border: none; font-weight: bold; border-radius: 4px; cursor: pointer; font-family: inherit; }
        .error-msg { color: #f85149; text-align: center; margin-bottom: 15px; font-size: 0.9em; }
    </style>
</head>
<body>
    <div class="login-box">
        <h3>[ AUTH_PGSQL ]</h3>
        <?php if(isset($error)) echo "<div class='error-msg'>$error</div>"; ?>
        <form method="POST">
            <label style="font-size: 0.9em; color: #8b949e;">DB_User_</label>
            <input type="text" name="username" class="form-control" placeholder="admin" required autocomplete="off">
            <label style="font-size: 0.9em; color: #8b949e;">DB_Pass_</label>
            <input type="password" name="password" class="form-control" placeholder="****" required>
            <button type="submit" class="btn-submit">CONECTAR AL NODO</button>
        </form>
    </div>
</body>
</html>
