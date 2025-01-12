<?php
require_once __DIR__ . '/../basedatos/bd.php';

if (isset($_POST['insertTareas'])) {
    // Debug: Verificar el contenido de $_POST
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
   
}

function ensureEstadoTareaExists($conexion, $nombreEstado) {
    try {
        // Buscar si existe el estado
        $query = "SELECT id_estado_tarea FROM estado_tareas WHERE estado_tarea = :estado_tarea";
        $stmt = $conexion->prepare($query);
        $stmt->bindParam(':estado_tarea', $nombreEstado);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['id_estado_tarea']; // Retorna el ID si ya existe
        } else {
            // Crear el estado si no existe
            $insert = "INSERT INTO estado_tareas (estado_tarea) VALUES (:estado_tarea)";
            $stmt = $conexion->prepare($insert);
            $stmt->bindParam(':estado_tarea', $nombreEstado);
            $stmt->execute();
            return $conexion->lastInsertId(); // Retorna el nuevo ID
        }
    } catch (PDOException $e) {
        throw new Exception("Error al garantizar estado de tarea: " . $e->getMessage());
    }
}

function ensureTipoTareaExists($conexion, $nombreTipo) {
    try {
        // Buscar si existe el tipo
        $query = "SELECT id_tipo_tarea FROM tipo_tareas WHERE tipo_tarea = :tipo_tarea";
        $stmt = $conexion->prepare($query);
        $stmt->bindParam(':tipo_tarea', $nombreTipo);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['id_tipo_tarea']; // Retorna el ID si ya existe
        } else {
            // Crear el tipo si no existe
            $insert = "INSERT INTO tipo_tareas (tipo_tarea) VALUES (:tipo_tarea)";
            $stmt = $conexion->prepare($insert);
            $stmt->bindParam(':tipo_tarea', $nombreTipo);
            $stmt->execute();
            return $conexion->lastInsertId(); // Retorna el nuevo ID
        }
    } catch (PDOException $e) {
        throw new Exception("Error al garantizar tipo de tarea: " . $e->getMessage());
    }
}

function insertTarea($nombre_tarea, $descripcion, $fecha_inicio, $fecha_final, $id_usuario, $id_proyecto, $nombre_estado_tarea, $nombre_tipo_tarea) {
    try {
        $conexion = openDB();

        // Garantizar que existen `id_estado_tarea` y `id_tipo_tarea`
        $id_estado_tarea = ensureEstadoTareaExists($conexion, $nombre_estado_tarea);
        $id_tipo_tarea = ensureTipoTareaExists($conexion, $nombre_tipo_tarea);

        // Realizar la inserción
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
    } catch (Exception $e) {
        return [
            'error' => "Error al insertar la tarea: " . $e->getMessage()
        ];
    }
}

?>