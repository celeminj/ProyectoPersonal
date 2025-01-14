<?php

// Obtén el id_proyecto desde la URL
$id_proyecto = isset($_GET['id_proyecto']) ? $_GET['id_proyecto'] : null;

// Consulta para obtener los usuarios vinculados a este proyecto
$query = "
        SELECT usuarios.id_usuario, usuarios.nombre 
        FROM usuarios
        INNER JOIN usuarios_proyectos ON usuarios.id_usuario = usuarios_proyectos.id_usuario
        WHERE usuarios_proyectos.id_proyecto = :id_proyecto
    ";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id_proyecto', $id_proyecto, PDO::PARAM_INT);
$stmt->execute();
