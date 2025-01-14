<?php
session_start();
require_once 'basedatos/bd.php';
require_once 'php_controllers/selectUsuarios.php';
?>
<?php include 'mensaje.php'; ?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inicio de sesion</title>
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

        <h1 class="h3 mb-3 fw-normal text-center">Inicia sesión</h1>
        <div class="form-floating mb-3">
          <input type="text" name="nombre" placeholder="Escribe tu nombre de usuario" required class="form-control"
            id="floatingInput">
          <label for="floatingInput">Nombre de usuario</label>
        </div>
        <div class="form-floating mb-3">
          <input type="password" name="contrasena" placeholder="Escribe tu contraseña" required class="form-control"
            id="floatingPassword">
          <label for="floatingPassword">Contraseña</label>
        </div>
        <button type="submit" class="btn btn-primary w-100 py-2">Iniciar sesión</button>
        <p class="mt-3 text-center">¿No tienes cuenta? <a href="register.php">Regístrate</a></p>
      </form>
    </div>

  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>