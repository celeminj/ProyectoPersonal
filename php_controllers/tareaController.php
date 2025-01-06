<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}


// Verificar si ya está seteado el id_proyecto en la sesión o si viene en la URL
if (isset($_POST['id_proyecto'])) {
  $_SESSION['id_proyecto'] = $_POST['id_proyecto'];
  echo "hay proyecto";
}

if (isset($_SESSION['id_proyecto'])) {
  $id_proyecto = $_SESSION['id_proyecto'];
} else {
  // Si no está presente, asigna un valor predeterminado o maneja el error
  $id_proyecto = 0; // o el valor adecuado
}

require_once '../basedatos/bd.php';
require_once '../tareas/insertTareas.php';
require_once '../tareas/deleteTareas.php';
require_once '../tareas/editTareas.php';
require_once '../proyectos/usuarioAsociadoProyecto.php';

if (isset($_POST['insertTareas'])) {
  $id_proyecto = $_POST['id_proyecto'];

  // Ahora estamos pasando los nombres de tipo y estado de tarea
  insertTarea(
    $_POST['nombre_tarea'],
    $_POST['descripcion'],
    $_POST['fecha_inicio'],
    $_POST['fecha_final'],
    $_POST['id_usuario'],
    $_POST['id_proyecto'],
    $_POST['estado_tarea'], // nombre del estado de tarea
    $_POST['tipo_tarea'] // nombre del tipo de tarea
  );
  echo 'Se ha insertado una tarea';

  header('Location: ../gestionarProyecto.php?id_proyecto=' . $id_proyecto);
  exit();

} elseif (isset($_POST['delete'])) {
  $id_proyecto = $_POST['id_proyecto'];
  deleteTareas($_POST['id_tarea']);
  echo 'Se ha eliminado la tarea';

  header('Location: ../gestionarProyecto.php?id_proyecto=' . $id_proyecto);
  exit();

} elseif (isset($_POST['updateTareas'])) {

  $id_proyecto = $_POST['id_proyecto'];
  $id_tarea = $_POST['id_tarea'];

  // Actualizamos pasando los valores correctos para tipo de tarea
  updateTarea(
    $id_tarea,
    $_POST['nombre_tarea'],
    $_POST['descripcion'],
    $_POST['fecha_inicio'],
    $_POST['fecha_final'],
    $_POST['id_usuario'],
    $_POST['tipo_tarea'] // nombre del tipo de tarea
  );

  echo 'Se ha editado la tarea';
  header('Location: ../gestionarProyecto.php?id_proyecto=' . $id_proyecto);
  exit();
}
?>
