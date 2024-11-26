<?php
require_once 'db.php';

function selectProyectos(){

    $conexion = openDB();
    $sentenciaText = "select * from proyectos";

    $sentencia = $conexion->prepare($sentenciaText);
    $sentencia->execute();
  
    $resultado = $sentencia->fetchAll();
  
    $conexion = closeDB();
  
    return $resultado;

}


?>