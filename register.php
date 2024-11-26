<?php
session_start();
require_once 'db.php';
$pdo = openDB();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, contrasena) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $password]);
        $id_usuario = $pdo->lastInsertId();
        $_SESSION['id_usuario'] = $id_usuario; // Guardar el ID del usuario en la sesión
        $_SESSION['nombre'] = $username;
          $_SESSION['mensaje'] = "¡Registro completado con éxito! Bienvenido, <strong>$username</strong>.";
          header("Location: iniciarSesion.php");
          exit;
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // para errores de duplicados
            $_SESSION['error'] = "El nombre de usuario o el correo ya están registrados. Intenta con otro.";
        } else {
            $_SESSION['error'] = "Ocurrió un error inesperado. Por favor, inténtalo de nuevo más tarde.";
        }
        header("Location: register.php");
        exit;
    }
}
?>

<?php include 'mensaje.php'; ?>
<form method="POST" action="">
    <label>Nombre de usuario:</label>
    <input type="text" name="nombre" placeholder="Escribe tu nombre" required>
    <label>Correo electrónico:</label>
    <input type="email" name="email" placeholder="Escribe tu correo" required>
    <label>Contraseña:</label>
    <input type="password" name="contrasena" placeholder="Escrribe tu contraseña" required>
    <button type="submit">Registrarse</button>
</form>

<!-- Mostrar mensajes de error --> 
<?php if (isset($_SESSION['error'])): ?>
    <p style="color: red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>