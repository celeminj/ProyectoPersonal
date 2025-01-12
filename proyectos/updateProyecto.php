<?php
require_once __DIR__ . '/../basedatos/bd.php';
function updateProyecto($id_proyecto, $titulo_proyecto)
{

    try {
        $conexion = openDB();

        $sentencia = $conexion->prepare("UPDATE
    proyectos SET titulo_proyecto = :titulo_proyecto 
             WHERE id_proyecto = :id_proyecto"
        );
        $sentencia->bindParam(':id_proyecto', $id_proyecto, PDO::PARAM_INT);
        $sentencia->bindParam(':titulo_proyecto', $titulo_proyecto, PDO::PARAM_STR);


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