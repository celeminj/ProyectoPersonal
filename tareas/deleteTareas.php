<?php
require_once '../basedatos/bd.php';
function deleteTareas($id_tarea) {
    try {
        $conexion = openDB();

        $sentenciaText = "DELETE FROM tareas WHERE id_tarea = :id_tarea";
        $sentencia = $conexion->prepare($sentenciaText);

        $sentencia->bindParam(':id_tarea', $id_tarea, PDO::PARAM_INT);

        $sentencia->execute();
        $_SESSION['mensaje'] = 'Registro borrado correctamente';
        closeDB();

        return [
            'success' => "Tarea eliminada correctamente."
        ];
    } catch (PDOException $e) {
        return [
            'error' => "Error al eliminar la tarea: " . $e->getMessage()
        ];
    }
}

?>
