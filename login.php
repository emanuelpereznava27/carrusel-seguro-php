<?php
session_start();
include 'db.php'; // Usa la conexión de tu nuevo archivo db.php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = mysqli_real_escape_string($conexion, $_POST['username']);
    $pass = $_POST['password'];

    // Validamos en la nueva tabla
    $query = "SELECT * FROM usuarios WHERE username = '$user' AND password = '$pass'";
    $resultado = mysqli_query($conexion, $query);

    if (mysqli_num_rows($resultado) > 0) {
        $datos = mysqli_fetch_assoc($resultado);
        $_SESSION['usuario'] = $datos['username']; 
        header("Location: admin.php"); // Si es correcto, al panel oscuro
        exit();
    } else {
        $error = "[ ACCESO DENEGADO ] Credenciales inválidas.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Acceso Restringido</title>
    <style>
        body { 
            background: #0d1117; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            height: 100vh; 
            font-family: 'Consolas', 'Courier New', monospace;
            color: #c9d1d9;
            margin: 0;
        }
        .login-box { 
            width: 350px; 
            padding: 30px; 
            background: #161b22; 
            border: 1px solid #30363d; 
            border-radius: 8px; 
            box-shadow: 0 0 15px rgba(46, 160, 67, 0.1); 
        }
        .login-box h3 {
            text-align: center;
            color: #2ea043;
            letter-spacing: 1px;
            margin-bottom: 20px;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            background: #0d1117;
            border: 1px solid #30363d;
            color: #58a6ff;
            border-radius: 4px;
            box-sizing: border-box;
            font-family: inherit;
        }
        .form-control:focus {
            border-color: #58a6ff;
            outline: none;
        }
        .btn-submit {
            width: 100%;
            padding: 10px;
            background: #2ea043;
            color: #0d1117;
            border: none;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
            transition: 0.3s;
            font-family: inherit;
        }
        .btn-submit:hover {
            background: #238636;
            color: #fff;
        }
        .error-msg {
            color: #f85149;
            text-align: center;
            margin-bottom: 15px;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h3>[ AUTENTICACIÓN ]</h3>
        
        <?php if(isset($error)) echo "<div class='error-msg'>$error</div>"; ?>
        
        <form method="POST">
            <label style="font-size: 0.9em; color: #8b949e;">Usuario_</label>
            <input type="text" name="username" class="form-control" placeholder="admin" required autocomplete="off">
            
            <label style="font-size: 0.9em; color: #8b949e;">Contraseña_</label>
            <input type="password" name="password" class="form-control" placeholder="****" required>
            
            <button type="submit" class="btn-submit">INICIAR SESIÓN</button>
        </form>
    </div>
</body>
</html>

