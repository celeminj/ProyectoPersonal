<?php
require_once '../basedatos/bd.php';
require_once '../tareas/insertTareas.php';
require_once '../tareas/deleteTareas.php';
require_once '../tareas/editTareas.php';
require_once '../proyectos/usuarioAsociadoProyecto.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

/**
 * Busca si hay proyectos en la session
 */
if (isset($_POST['id_proyecto'])) {
  $_SESSION['id_proyecto'] = $_POST['id_proyecto'];
  echo "hay proyecto";
}

if (isset($_SESSION['id_proyecto'])) {
  $id_proyecto = $_SESSION['id_proyecto'];
} else {
  
  $id_proyecto = 0; 
}

/**
 * Inserta las tareas 
 */
if (isset($_POST['insertTareas'])) {
  $id_proyecto = $_POST['id_proyecto'];

  insertTarea(
    $_POST['nombre_tarea'],
    $_POST['descripcion'],
    $_POST['fecha_inicio'],
    $_POST['fecha_final'],
    $_POST['id_usuario'],
    $_POST['id_proyecto'],
    $_POST['estado_tarea'], 
    $_POST['tipo_tarea'] 
  );
  echo 'Se ha insertado una tarea';

  header('Location: ../gestionarProyecto.php?id_proyecto=' . $id_proyecto);
  exit();
/**
 *  Borra las tareas selecionadas
 */
} elseif (isset($_POST['delete'])) {
  $id_proyecto = $_POST['id_proyecto'];
  deleteTareas($_POST['id_tarea']);
  echo 'Se ha eliminado la tarea';

  header('Location: ../gestionarProyecto.php?id_proyecto=' . $id_proyecto);
  exit();

/**
 * Busca si hay tareas para editar
 */
} elseif (isset($_POST['updateTareas'])) {

  $id_proyecto = $_SESSION['id_proyecto'] ?? $_POST['id_proyecto'];
  $id_tarea = $_POST['id_tarea'];

  // Actualizamos pasando los valores correctos para tipo de tarea
  updateTarea(
    $id_tarea,
    $_POST['nombre_tarea'],
    $_POST['descripcion'],
    $_POST['fecha_inicio'],
    $_POST['fecha_final'],
    $_POST['id_usuario'],
    $_POST['tipo_tarea'],
    id_estado_tarea: $_POST['estado_tarea'] 
  );

  echo 'Se ha editado la tarea';
  header('Location: ../gestionarProyecto.php?id_proyecto=' . $id_proyecto . '&id_tarea=' . $id_tarea);

  exit();
}
?>
