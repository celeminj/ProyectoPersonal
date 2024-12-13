<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}


require_once '../basedatos/bd.php';
require_once '../tareas/insertTareas.php';
require_once '../tareas/deleteTareas.php';
require_once '../tareas/editTareas.php';

if (isset($_POST['insertTareas'])) {
  $id_proyecto = $_POST['id_proyecto'];
  insertTarea(
    $_POST['nombre_tarea'],
    $_POST['descripcion'],
    $_POST['fecha_inicio'],
    $_POST['fecha_final'],
    $_POST['id_usuario'],
    $_POST['id_proyecto'],
    $_POST['id_estado_tarea'],
    $_POST['id_tipo_tarea']
  );
  echo 'se ha inssertado una tarea';
  header('Location: ../gestionarProyecto.php?id_proyecto=' . $id_proyecto);
  exit();

} elseif (isset($_POST['delete'])) {
  $id_proyecto = $_POST['id_proyecto'];
  deleteTareas($_POST['id_tarea']);
  echo 'Se ha eliminado la tarea';
  header('Location: ../gestionarProyecto.php?id_proyecto=' . $id_proyecto);
  exit();

} elseif (isset($_POST['id_tarea']) && isset($_POST['nuevo_estado'])) {
  $id_proyecto = $_POST['id_proyecto'];
  $id_tarea = $_POST['id_tarea'];
  $nuevo_estado = $_POST['nuevo_estado'];

  $resultado = updateTarea($id_tarea, $nuevo_estado);
  echo 'se ha editado la tarea';
  header('Location: ../gestionarProyecto.php?id_proyecto=' . $id_proyecto);
  exit();
}
?>