<?php
require_once '../basedatos/bd.php';

function updateTarea($id_tarea, $nombre_tarea, $descripcion, $fecha_inicio, $fecha_final, $id_usuario, $id_tipo_tarea)
{
    try {
        $conexion = openDB();

        $sentenciaText = "UPDATE tareas 
        SET nombre_tarea = :nombre_tarea,
         descripcion = :descripcion,
         fecha_inicio = :fecha_inicio,
         fecha_final = :fecha_final,
         id_usuario = :id_usuario, 
        id_tipo_tarea = :id_tipo_tarea
        WHERE id_tarea = :id_tarea";
        $sentencia = $conexion->prepare($sentenciaText);

        $sentencia->bindParam(':nombre_tarea',$nombre_tarea);
        $sentencia->bindParam(':descripcion', $descripcion);
        $sentencia->bindParam(':fecha_inicio', $fecha_inicio);
        $sentencia->bindParam(':fecha_final', $fecha_final);
        $sentencia->bindParam(':id_usuario', $id_usuario);
        $sentencia->bindParam(':id_tipo_tarea', $id_tipo_tarea);
        $sentencia->bindParam(':id_tarea', $id_tarea);

       
        $sentencia->execute();

        closeDB();

        return [
            'success' => true,
            'message' => "Estado de la tarea actualizado correctamente."
        ];
    } catch (PDOException $e) {
        return [
            'success' => false,
            'message' => "Error al actualizar el estado: " . $e->getMessage()
        ];
    }
}
?>