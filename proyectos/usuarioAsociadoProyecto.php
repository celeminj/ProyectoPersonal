<?php

function bd () {
    $host = 'localhost';
    $db = 'gestion_proyectos';
    $user = 'root';
    $pass = 'mysql';
    
    try {
        $conexion = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
    return $conexion;
}
  

$pdo = bd();

$nombre = '';
$proyecto = '';
if (isset($_SESSION['id_usuario'])) {
    $userId = $_SESSION['id_usuario'];

    $stmt = $pdo->prepare("SELECT nombre FROM usuarios WHERE id_usuario = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $nombre = $user['nombre'];
}

if (isset($_SESSION['id_proyecto'])) {
    $proyecId = $_SESSION['id_proyecto'];

    $stmt = $pdo->prepare("SELECT titulo_proyecto FROM proyectos WHERE id_proyecto = ?");
    $stmt->execute([$proyecId]);
    $proyect = $stmt->fetch(PDO::FETCH_ASSOC);
    $proyecto = $proyect['titulo_proyecto'];
}

?>