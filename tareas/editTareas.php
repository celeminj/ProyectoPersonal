<?php
require_once '../basedatos/bd.php';

function updateTarea($id_tarea, $id_estado_tarea)
{
    try {
        $conexion = openDB();

        $sentenciaText = "UPDATE tareas 
        SET id_estado_tarea = :id_estado_tarea
        WHERE id_tarea = :id_tarea";
        $sentencia = $conexion->prepare($sentenciaText);

        $sentencia->bindParam(':id_estado_tarea', $id_estado_tarea);
        $sentencia->bindParam(':id_tarea', $id_tarea);

        // Ejecutar la sentencia
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