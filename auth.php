<?php
session_start();
include 'db.php';

if (isset($_POST['registrar'])) {
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $sql = "INSERT INTO usuarios (username, password) VALUES ('$user', '$pass')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Usuario registrado'); window.location='auth.php';</script>";
    }
}

if (isset($_POST['entrar'])) {
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = $_POST['password'];
    $res = mysqli_query($conn, "SELECT * FROM usuarios WHERE username='$user'");
    $u = mysqli_fetch_assoc($res);
    if ($u && password_verify($pass, $u['password'])) {
        $_SESSION['usuario'] = $user;
        header("Location: index.php");
        exit();
    } else {
        echo "<script>alert('Datos incorrectos');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso Seguro</title>
    <style>
        body { background: #0b0e14; color: white; font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-card { background: #151921; padding: 30px; border-radius: 15px; border: 1px solid #007bff; box-shadow: 0 0 15px rgba(0,123,255,0.3); text-align: center; width: 300px; }
        input { width: 100%; padding: 10px; margin: 10px 0; background: #0b0e14; border: 1px solid #333; color: white; border-radius: 5px; box-sizing: border-box; }
        .btn-group { display: flex; justify-content: space-between; }
        button { width: 48%; padding: 10px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; }
        .btn-login { background: #007bff; color: white; }
        .btn-reg { background: #28a745; color: white; }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>🛡️ Login</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <div class="btn-group">
                <button type="submit" name="entrar" class="btn-login">Entrar</button>
                <button type="submit" name="registrar" class="btn-reg">Registro</button>
            </div>
        </form>
    </div>
</body>
</html>
