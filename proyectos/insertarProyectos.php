<?php
require_once __DIR__ . '/../basedatos/bd.php';

function verificarRol($conexion, $idRol, $nombreRol) {
    try {
        $conexion = openDB(); 
        $stmt = $conexion->prepare("SELECT id_rol FROM roles WHERE id_rol = :id_rol");
        $stmt->bindParam(':id_rol', $idRol);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            // Si no existe, insertar el rol
            $stmt = $conexion->prepare("INSERT INTO roles (id_rol, nombre_rol) VALUES (:id_rol, :nombre_rol)");
            $stmt->bindParam(':id_rol', $idRol);
            $stmt->bindParam(':nombre_rol', $nombreRol);
            $stmt->execute();
            
        }
        closeDB();
    } catch (PDOException $e) {
        die("Error al verificar o insertar el rol: " . $e->getMessage());
    }
}

function insertarProyecto($conexion, $idUsuario, $tituloProyecto, $usuariosSeleccionados) {
    try {
        $conexion->beginTransaction();

        // Verificar roles
        verificarRol($conexion, 1, "Admin"); // Verificar rol Admin
        verificarRol($conexion, 2, "Usuario"); // Verificar rol Usuario

        // Insertar proyecto
        $stmt = $conexion->prepare("INSERT INTO proyectos (titulo_proyecto) VALUES (:titulo)");
        $stmt->bindParam(':titulo', $tituloProyecto);
        $stmt->execute();
        $idProyecto = $conexion->lastInsertId();

        // Asignar rol de Admin al creador
        $stmt = $conexion->prepare("INSERT INTO usuarios_proyectos (id_usuario, id_proyecto, id_rol) VALUES (:id_usuario, :id_proyecto, :id_rol)");
        $stmt->execute([
            ':id_usuario' => $idUsuario,
            ':id_proyecto' => $idProyecto,
            ':id_rol' => 1
        ]);

        // Asignar usuarios seleccionados
        foreach ($usuariosSeleccionados as $usuario) {
            $stmt->execute([
                ':id_usuario' => $usuario,
                ':id_proyecto' => $idProyecto,
                ':id_rol' => 2
            ]);
        }

        $conexion->commit();
        echo "Proyecto creado y usuarios asignados correctamente.";
    } catch (PDOException $e) {
        $conexion->rollBack();
        echo "Error al crear el proyecto: " . $e->getMessage();
    }
}
