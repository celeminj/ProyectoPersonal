<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: welcome.php");
    } else {
        echo "Credenciales incorrectas.";
    }
}
?>
<form method="POST" action="">
    <label>Nombre de usuario:</label>
    <input type="text" name="username" required>
    <label>Contraseña:</label>
    <input type="password" name="password" required>
    <button type="submit">Iniciar sesión</button>
</form>
<p>¿No tienes cuenta? <a href="register.php">Regístrate</a></p>
