<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function openDB() {
    $host = 'localhost';
    $db = 'gestion_proyectos';
    $user = 'root';
    $pass = 'mysql';
    
    try {
        $conexion = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
    return $conexion;
}

function closeDB() {
    return null;
}

function errorMessage($e)
{

  if (!empty($e->errorInfo[1])) {

    switch ($e->errorInfo[1]) {
      case 1062:
        $mensaje = 'Registro duplicado';
        break;
      case 1451:
        $mensaje = 'Registro con elementos relacionados';
        break;
      default:
        $mensaje = $e->errorInfo[1] . ' - ' . $e->errorInfo[2];
        break;
    }
  } else {
    switch ($e->getCode()) {
      case 1044:
        $mensaje = "Usuario y/o password incorrecto";
        break;
      case 1049:
        $mensaje = "Base de datos desconocida";
        break;
      case 2002:
        $mensaje = "No se encuentra el servidor";
        break;
      default:
        $mensaje = $e->getCode() . ' - ' . $e->getMessage();
        break;
    }
  }
  return $mensaje;
}

?>
