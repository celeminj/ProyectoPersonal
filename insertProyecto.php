<?php
require_once 'db.php';

function insertProyectos()
{
    try {
        $conexion = openDB();

        $sentenciaText = "INSERT INTO proyectos (titulo_proyecto) VALUES (:titulo_proyecto);";
        $sentencia = $conexion->prepare($sentenciaText);
        $sentencia->bindParam(':titulo_proyecto', $titulo_proyecto);
        $sentencia->execute();
        $_SESSION['mensaje'] = 'Registro insertado correctamente';
    } catch (PDOException $e) {
        $_SESSION['error'] = errorMessage($e);
        //$ciudad['titulo_proyecto'] = $titulo_proyecto;
       // $_SESSION['proyectos'] = $ciudad;

    }
    $conexion = closeDB();
    
}
?>