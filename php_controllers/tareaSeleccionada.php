<?php

if (isset($_GET['id_tarea'])) {
    $id_tarea = $_GET['id_tarea'];

    // Consultar la tarea seleccionada desde la base de datos
    $query = "SELECT * FROM tareas WHERE id_tarea = :id_tarea";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id_tarea' => $id_tarea]);
    $tarea = $stmt->fetch();

    // Si la tarea no existe, mostrar un mensaje de error
    if (!$tarea) {
        echo "Tarea no encontrada.";
        exit;
    }
}
