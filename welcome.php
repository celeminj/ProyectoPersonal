<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

echo "Bienvenido, estás autenticado. <a href='logout.php'>Cerrar sesión</a>";
?>
