<?php
require_once './basedatos/bd.php';

$pdo = openDB();
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
    $stmt->execute([$userId]);
    $proyect = $stmt->fetch(PDO::FETCH_ASSOC);
    $proyecto = $proyect['titulo_proyecto'];
}

?>