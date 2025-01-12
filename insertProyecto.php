<?php
require_once 'basedatos/bd.php';

// Función para verificar o insertar el rol "Admin"
function verificarRolAdmin($conexion) {
    try {
        // Verificar si el rol "Admin" ya existe
        $stmt = $conexion->prepare("SELECT id_rol FROM roles WHERE nombre_rol = :nombre_rol");
        $nombreRol = "Admin";
        $stmt->bindParam(':nombre_rol', $nombreRol);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            // Si no existe, insertar el rol "Admin"
            $stmt = $conexion->prepare("INSERT INTO roles (nombre_rol) VALUES (:nombre_rol)");
            $stmt->bindParam(':nombre_rol', $nombreRol);
            $stmt->execute();

            return $conexion->lastInsertId(); // Retornar el ID recién creado
        } else {
            // Si existe, retornar su ID
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['id_rol'];
        }
    } catch (PDOException $e) {
        die("Error al verificar o insertar el rol: " . $e->getMessage());
    }
}

// Función para insertar un proyecto y asignar usuarios
function insertarProyecto($idUsuario, $tituloProyecto, $usuariosSeleccionados) {
    $conexion = openDB();

    try {
        // Iniciar transacción
        $conexion->beginTransaction();

        // Verificar o insertar el rol "Admin"
        $idRolAdmin = verificarRolAdmin($conexion);

        // Insertar proyecto en la tabla proyectos
        $stmt = $conexion->prepare("INSERT INTO proyectos (titulo_proyecto) VALUES (:titulo)");
        $stmt->bindParam(':titulo', $tituloProyecto);
        $stmt->execute();

        // Obtener el ID del proyecto recién creado
        $idProyecto = $conexion->lastInsertId();

        // Asignar rol de admin al usuario que creó el proyecto
        $stmt = $conexion->prepare("INSERT INTO usuarios_proyectos (id_usuario, id_proyecto, id_rol) 
                                    VALUES (:id_usuario, :id_proyecto, :id_rol)");
        $stmt->bindParam(':id_usuario', $idUsuario);
        $stmt->bindParam(':id_proyecto', $idProyecto);
        $stmt->bindParam(':id_rol', $idRolAdmin);
        $stmt->execute();

        // Asignar los usuarios seleccionados al proyecto con rol de "Usuario" (id_rol = 2)
        $idRolUsuario = 2;
        $stmt = $conexion->prepare("INSERT INTO usuarios_proyectos (id_usuario, id_proyecto, id_rol) 
                                    VALUES (:id_usuario, :id_proyecto, :id_rol)");

        foreach ($usuariosSeleccionados as $usuarioSeleccionado) {
            $stmt->execute([
                ':id_usuario' => $usuarioSeleccionado,
                ':id_proyecto' => $idProyecto,
                ':id_rol' => $idRolUsuario
            ]);
        }

        // Confirmar transacción
        $conexion->commit();

        echo "Proyecto creado y usuarios asignados correctamente.";
    } catch (PDOException $e) {
        // Revertir transacción en caso de error
        $conexion->rollBack();
        echo "Error al crear el proyecto: " . $e->getMessage();
    } finally {
        closeDB();
    }
}


// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insert'])) {
    if (!isset($_SESSION['id_usuario'])) {
        die("Error: No se encontró un usuario autenticado.");
    }

    $idUsuario = $_SESSION['id_usuario']; // Obtener ID del usuario autenticado
    $tituloProyecto = $_POST['titulo_proyecto'];

    // Obtener IDs de usuarios seleccionados desde el formulario
    if (!isset($_POST['id_usuario_seleccionado']) || !is_array($_POST['id_usuario_seleccionado'])) {
        die("Error: No se seleccionaron usuarios.");
    }

    $usuariosSeleccionados = $_POST['id_usuario_seleccionado'];

    // Llamar a la función para insertar el proyecto
    insertarProyecto($idUsuario, $tituloProyecto, $usuariosSeleccionados);
}

function verificarRolUsuario($conexion) {
    try {
        // Verificar si el rol "Usuario" ya existe
        $stmt = $conexion->prepare("SELECT id_rol FROM roles WHERE id_rol = :id_rol");
        $idRol = 2; // ID del rol "Usuario"
        $stmt->bindParam(':id_rol', $idRol);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            // Si no existe, insertar el rol "Usuario"
            $stmt = $conexion->prepare("INSERT INTO roles (id_rol, nombre_rol) VALUES (:id_rol, :nombre_rol)");
            $nombreRol = "Usuario";
            $stmt->bindParam(':id_rol', $idRol);
            $stmt->bindParam(':nombre_rol', $nombreRol);
            $stmt->execute();

            echo "Rol 'Usuario' insertado correctamente.<br>";
        } else {
            echo "El rol 'Usuario' ya existe.<br>";
        }
    } catch (PDOException $e) {
        die("Error al verificar o insertar el rol 'Usuario': " . $e->getMessage());
    }
}
?>
