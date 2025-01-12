<?php
require_once './basedatos/bd.php';

function selectTarea($id_proyecto)
{
    $conexion = openDB();
    $sentenciaText = "SELECT *,tipo_tareas.tipo_tarea,usuarios.nombre FROM tareas INNER JOIN tipo_tareas ON tareas.id_tipo_tarea = tipo_tareas.id_tipo_tarea 
    INNER JOIN usuarios ON tareas.id_usuario = usuarios.id_usuario WHERE id_proyecto = ?";
    $sentencia = $conexion->prepare($sentenciaText);
    $sentencia->execute([$id_proyecto]);

    $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $conexion = closeDB();

    return $resultado;
}

?>