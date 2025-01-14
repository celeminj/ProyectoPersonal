<?php
$pdo = openDB();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['nombre'];
  $password = $_POST['contrasena'];

  $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE nombre = ?");
  $stmt->execute([$username]);
  $user = $stmt->fetch();

  if ($user && password_verify($password, $user['contrasena'])) {
    $_SESSION['id_usuario'] = $user['id_usuario'];
    header("Location: welcome.php");
  } else {
    echo "Credenciales incorrectas.";
  }
}