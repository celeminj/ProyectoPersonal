<?php
require_once 'basedatos/bd.php';

function deleteProyecto($id_proyecto): array
{
    if (!$id_proyecto) {
        return [
            'success' => false,
            'message' => 'No se encuentra el proyecto para borrar.'
        ];
    }

    try {
        $conexion = openDB();

        $sentencia = $conexion->prepare("DELETE FROM proyectos WHERE id_proyecto = :id_proyecto");
        $sentencia->bindParam(':id_proyecto', $id_proyecto, PDO::PARAM_INT);

        $sentencia->execute();
        closeDB();

        return [
            'success' => true,
            'message' => "Proyecto eliminado correctamente."
        ];
    } catch (PDOException $e) {
        return [
            'success' => false,
            'message' => 'Error al borrar el proyecto: ' . $e->getMessage()
        ];
    }
}


?>