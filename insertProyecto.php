<?php
require_once 'basedatos/bd.php';

function insertProyectos()
{
    try {
        $conexion = openDB();

        // Recoger los datos del formulario
        $titulo_proyecto = $_POST['titulo_proyecto'] ?? '';

        // Validar que el título no esté vacío
        if (empty($titulo_proyecto)) {
            $_SESSION['error'] = 'El título del proyecto no puede ser vacío';
            return null;
        }

        // Verificar si el proyecto ya existe
        $consulta = "SELECT COUNT(*) FROM proyectos WHERE titulo_proyecto = :titulo_proyecto";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->bindParam(':titulo_proyecto', $titulo_proyecto);
        $sentencia->execute();
        $existe = $sentencia->fetchColumn();

        if ($existe > 0) {
            $_SESSION['mensaje'] = 'El proyecto ya existe';
            return null;
        }

        $sentenciaText = "INSERT INTO proyectos (titulo_proyecto) VALUES (:titulo_proyecto)";
        $sentencia = $conexion->prepare($sentenciaText);
        $sentencia->bindParam(':titulo_proyecto', $titulo_proyecto);
        $sentencia->execute();
    
        // Obtener el ID del nuevo proyecto insertado
        $idProyecto = $conexion->lastInsertId();
    
        // Obtener el ID del usuario actual (de la sesión)
        if (!isset($_SESSION['id_usuario'])) {
            throw new Exception("No se ha encontrado el ID del usuario en la sesión.");
        }
        $idUsuario = $_SESSION['id_usuario'];
        $idRol = 1; // Rol de admin
    
        // Asignar el nuevo proyecto al usuario con rol de admin
        $consultaAsignarRol = "INSERT INTO usuarios_proyectos (id_usuario, id_proyecto, id_rol) VALUES (:id_usuario, :id_proyecto, :id_rol)";
        $sentenciaAsignar = $conexion->prepare($consultaAsignarRol);
        $sentenciaAsignar->bindParam(':id_usuario', $idUsuario);
        $sentenciaAsignar->bindParam(':id_proyecto', $idProyecto);
        $sentenciaAsignar->bindParam(':id_rol', $idRol);
        $sentenciaAsignar->execute();
    
        echo "Proyecto y rol asignados correctamente.";
    } catch (PDOException $e) {
        echo "Error en la base de datos: " . $e->getMessage();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
