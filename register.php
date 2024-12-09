<?php
session_start();
require_once 'basedatos/bd.php';
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <main>
        <div class="border rounded p-4 mx-auto" style="max-width: 400px;">
            <form method="POST" action="">
                <div class="image-container">
                    <img src="img/iconoEmpresa.png" alt="Logo de la empresa" id="logotipo">
                </div>

                <h1 class="h3 mb-3 fw-normal text-center">Registrate</h1>

                <div class="form-floating mb-3">
                    <input type="text" name="nombre" placeholder="Escribe tu nombre de usuario" required
                        class="form-control" id="floatingInput">
                    <label for="floatingInput">Nombre de usuario</label>
                </div>

                <div class="form-floating mb-3">

                    <input id="floatingInput" type="email" name="email" class="form-control"
                        placeholder="Escribe tu correo" required>
                    <label for="floatingInput">Correo electrónico:</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="password" name="contrasena" placeholder="Escribe tu contraseña" required
                        class="form-control" id="floatingPassword">
                    <label for="floatingPassword">Contraseña</label>
                </div>

                <button type="submit" class="mt-3 text-center btn btn-primary w-100 py-2">Registrarse</button>
                <p class="mt-3 text-center">¿Ya tienes cuenta? <a href="iniciarSesion.php">Iniciar Sesion</a></p>
            </form>
        </div>

        <!-- Mostrar mensajes de error -->
        <?php if (isset($_SESSION['error'])): ?>
            <p style="color: red;"><?php echo $_SESSION['error'];
            unset($_SESSION['error']); ?></p>
        <?php endif; ?>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>