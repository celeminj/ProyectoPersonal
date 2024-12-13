<?php
require_once __DIR__ . '/../basedatos/bd.php';


function insertTarea($nombre_tarea, $descripcion, $fecha_inicio, $fecha_final, $id_usuario, $id_proyecto, $id_estado_tarea, $id_tipo_tarea)
{
    try {
        $conexion = openDB();

        $sentenciaText = "INSERT INTO tareas (nombre_tarea, descripcion, fecha_inicio, fecha_final, id_usuario, id_proyecto, id_estado_tarea, id_tipo_tarea) 
                          VALUES (:nombre_tarea, :descripcion, :fecha_inicio, :fecha_final, :id_usuario, :id_proyecto, :id_estado_tarea, :id_tipo_tarea)";
        $sentencia = $conexion->prepare($sentenciaText);

        $sentencia->bindParam(':nombre_tarea', $nombre_tarea);
        $sentencia->bindParam(':descripcion', $descripcion);
        $sentencia->bindParam(':fecha_inicio', $fecha_inicio);
        $sentencia->bindParam(':fecha_final', $fecha_final);
        $sentencia->bindParam(':id_usuario', $id_usuario);
        $sentencia->bindParam(':id_proyecto', $id_proyecto);
        $sentencia->bindParam(':id_estado_tarea', $id_estado_tarea);
        $sentencia->bindParam(':id_tipo_tarea', $id_tipo_tarea);

        $sentencia->execute();
        closeDB();

        return [
            'success' => "Tarea insertada correctamente."
        ];
    } catch (PDOException $e) {
        return [
            'error' => "Error al insertar la tarea: " . $e->getMessage()
        ];
    }
}
?>