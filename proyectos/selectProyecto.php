<?php
require_once './basedatos/bd.php';

function selectProyectos($idUsuario) {
    $pdo = openDB();
    $stmt = $pdo->prepare("
        SELECT proyectos.id_proyecto, proyectos.titulo_proyecto
        FROM proyectos
        JOIN usuarios_proyectos ON proyectos.id_proyecto = usuarios_proyectos.id_proyecto
        WHERE usuarios_proyectos.id_usuario = ?
    ");
    $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
    $stmt->execute([$idUsuario]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
